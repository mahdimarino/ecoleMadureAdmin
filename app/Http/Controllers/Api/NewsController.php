<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    public function index(): JsonResponse
    {
        $news = News::where('is_published', 1)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $news->map(function ($article) {
                return $this->formatNews($article);
            }),
            'pagination' => [
                'current_page' => $news->currentPage(),
                'last_page' => $news->lastPage(),
                'per_page' => $news->perPage(),
                'total' => $news->total(),
            ],
        ]);
    }

    public function featured(): JsonResponse
    {
        $featured = News::where('is_published', 1)
            ->where('is_featured', 1)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        if ($featured->count() < 3) {
            $remaining = 3 - $featured->count();

            $latest = News::where('is_published', 1)
                ->where('is_featured', 0)
                ->orderByDesc('published_at')
                ->orderByDesc('created_at')
                ->take($remaining)
                ->get();

            $featured = $featured->concat($latest);
        }

        return response()->json([
            'success' => true,
            'data' => $featured->map(fn($item) => $this->formatNews($item))->values(),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $article = News::where('slug', $slug)
            ->where('is_published', 1)
            ->first();

        if (!$article) {
            return response()->json([
                'success' => false,
                'message' => 'Actualité introuvable.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $this->formatNews($article, true),
        ]);
    }

    private function formatNews($article, bool $fullContent = false): array
    {
        $data = [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'category' => $article->category,
            'summary' => $article->summary,

            'image' => $article->image
                ? asset('storage/' . $article->image)
                : null,

            'button' => [
                'text' => $article->button_text,
                'url' => $article->button_url,
            ],

            'published_at' => $article->published_at,

            'is_featured' => (bool) $article->is_featured,
        ];

        if ($fullContent) {
            $data['content'] = $article->content;
        }

        return $data;
    }
}
