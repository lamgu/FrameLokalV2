<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewApiController extends Controller
{
    // ==========================================
    // RATING
    // ==========================================

    public function ratingStatus(Film $film)
    {
        if (!Auth::check()) {
            return response()->json(['rating' => null]);
        }

        $review = Review::where('user_id', Auth::id())
            ->where('film_id', $film->id)
            ->first();

        return response()->json(['rating' => $review ? $review->rating : null]);
    }

    public function storeRating(Request $request, Film $film)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::firstOrNew([
            'user_id' => Auth::id(),
            'film_id' => $film->id,
        ]);

        $review->rating = $request->rating;
        $review->save();

        $film->recalculateRating();

        return response()->json([
            'message' => 'Rating berhasil disimpan',
            'rating' => $review->rating,
            'avg_rating' => $film->fresh()->rating,
        ]);
    }

    public function raters(Film $film)
    {
        $raters = Review::where('film_id', $film->id)
            ->whereNotNull('rating')
            ->where('rating', '>', 0)
            ->with('user:id,name')
            ->orderByDesc('rating')
            ->get()
            ->map(function ($r) {
                return [
                    'id' => $r->user->id,
                    'name' => $r->user->name,
                    'rating' => $r->rating,
                    'created_at_formatted' => $r->created_at?->translatedFormat('d M Y')
                ];
            });

        return response()->json([
            'raters' => $raters,
            'total'  => $raters->count()
        ]);
    }

    // ==========================================
    // COMMENTS
    // ==========================================

    public function comments(Film $film)
    {
        // Only get reviews that have a comment
        $reviews = $film->reviews()
            ->whereNotNull('comment')
            ->where('comment', '!=', '')
            ->with(['user:id,name', 'replies.user:id,name'])
            ->latest()
            ->get()
            ->map(fn ($r) => $this->formatReview($r));

        return response()->json([
            'comments' => $reviews,
            'total'    => $reviews->count(),
        ]);
    }

    public function storeComment(Request $request, Film $film)
    {
        $request->validate([
            'comment' => 'required|string|min:5|max:1000',
        ], [
            'comment.required' => 'Komentar wajib diisi.',
            'comment.min'      => 'Komentar minimal 5 karakter.',
        ]);

        $review = Review::firstOrNew([
            'user_id' => Auth::id(),
            'film_id' => $film->id,
        ]);

        $review->comment = $request->comment;
        $review->save();

        return response()->json([
            'message' => 'Komentar berhasil dikirim!',
            'comment' => $this->formatReview($review->fresh(['user:id,name', 'replies.user:id,name'])),
        ]);
    }

    public function destroyComment(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $film = $review->film;

        // If the user only has a comment and no rating, we can delete the row
        // But if they have a rating, we should just nullify the comment
        if ($review->rating) {
            $review->comment = null;
            $review->save();
            $review->replies()->delete();
        } else {
            $review->delete();
        }

        if ($film) {
            $film->recalculateRating();
        }

        return response()->json(['message' => 'Komentar berhasil dihapus.']);
    }

    // ==========================================
    // REPLIES
    // ==========================================

    public function storeReply(Request $request, Review $review)
    {
        $request->validate([
            'reply' => 'required|string|min:2|max:500',
        ], [
            'reply.required' => 'Balasan wajib diisi.',
            'reply.min'      => 'Balasan minimal 2 karakter.',
        ]);

        $reply = ReviewReply::create([
            'review_id' => $review->id,
            'user_id'   => Auth::id(),
            'reply'     => $request->reply,
        ]);

        $reply->load('user:id,name');

        return response()->json([
            'message' => 'Balasan berhasil dikirim!',
            'reply'   => $this->formatReply($reply),
        ]);
    }

    public function destroyReply(ReviewReply $reply)
    {
        if ($reply->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $reply->delete();

        return response()->json(['message' => 'Balasan berhasil dihapus.']);
    }

    // ==========================================
    // FORMATTERS
    // ==========================================

    private function formatReview(Review $review): array
    {
        return [
            'id'         => $review->id,
            'rating'     => $review->rating,
            'comment'    => $review->comment,
            'created_at' => $review->created_at?->diffForHumans(),
            'created_at_formatted' => $review->created_at?->translatedFormat('d M Y H:i'),
            'user'       => [
                'id'   => $review->user?->id,
                'name' => $review->user?->name ?? 'Pengguna',
            ],
            'is_mine'    => Auth::check() && Auth::id() === $review->user_id,
            'replies'    => $review->replies->map(fn($rp) => $this->formatReply($rp)),
        ];
    }

    private function formatReply(ReviewReply $reply): array
    {
        return [
            'id'         => $reply->id,
            'reply'      => $reply->reply,
            'created_at' => $reply->created_at?->diffForHumans(),
            'created_at_formatted' => $reply->created_at?->translatedFormat('d M Y H:i'),
            'user'       => [
                'id'   => $reply->user?->id,
                'name' => $reply->user?->name ?? 'Pengguna',
            ],
            'is_mine'    => Auth::check() && Auth::id() === $reply->user_id,
        ];
    }

    // ==========================================
    // USER ACTIVITY
    // ==========================================

    public function userRatings()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $reviews = Review::where('user_id', Auth::id())
            ->whereNotNull('rating')
            ->where('rating', '>', 0)
            ->with(['film.genres', 'film.regency.province'])
            ->latest()
            ->get()
            ->map(function ($r) {
                $film = $r->film;
                return [
                    'review_id'  => $r->id,
                    'rating'     => $r->rating,
                    'created_at' => $r->created_at?->translatedFormat('d M Y'),
                    'film' => $film ? [
                        'id'         => $film->id,
                        'title'      => $film->title,
                        'slug'       => $film->slug,
                        'poster_url' => $film->poster ? asset('storage/' . $film->poster) : null,
                        'year'       => $film->year,
                        'genres'     => $film->genres->pluck('name'),
                    ] : null,
                ];
            })
            ->filter(fn ($r) => $r['film'] !== null)
            ->values();

        return response()->json(['ratings' => $reviews, 'total' => $reviews->count()]);
    }

    public function userComments()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $reviews = Review::where('user_id', Auth::id())
            ->whereNotNull('comment')
            ->where('comment', '!=', '')
            ->with(['film'])
            ->latest()
            ->get()
            ->map(function ($r) {
                $film = $r->film;
                return [
                    'review_id'  => $r->id,
                    'comment'    => $r->comment,
                    'rating'     => $r->rating,
                    'created_at' => $r->created_at?->translatedFormat('d M Y'),
                    'film' => $film ? [
                        'id'         => $film->id,
                        'title'      => $film->title,
                        'slug'       => $film->slug,
                        'year'       => $film->year,
                        'poster_url' => $film->poster ? asset('storage/' . $film->poster) : null,
                    ] : null,
                ];
            })
            ->filter(fn ($r) => $r['film'] !== null)
            ->values();

        return response()->json(['comments' => $reviews, 'total' => $reviews->count()]);
    }
}

