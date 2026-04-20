<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Pick;
use App\Services\ClaudeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $articles = Article::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%")
                      ->orWhere('expert_name', 'like', "%{$search}%");
                });
            })
            ->orderByRaw('published_at IS NULL')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.articles.index', [
            'articles' => $articles,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'article' => new Article(),
            'picks'   => Pick::orderBy('game_date', 'desc')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'excerpt'        => ['nullable', 'string'],
            'content'        => ['required', 'string'],
            'category'       => ['required', 'string', 'max:50'],
            'sport'          => ['nullable', 'string', 'max:50'],
            'author'         => ['nullable', 'string', 'max:255'],
            'expert_name'    => ['nullable', 'string', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_premium'     => ['boolean'],
            'is_published'   => ['boolean'],
            'published_at'   => ['nullable', 'date'],
            'related_pick_id'=> ['nullable', 'exists:picks,id'],
        ]);

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $i = 2;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }
        $validated['slug'] = $slug;

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['is_published'] = $request->boolean('is_published');
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('uploads/articles', 'public');
            $validated['featured_image'] = $path;
        }

        // Auto-generate excerpt if blank
        if (empty($validated['excerpt']) && !empty($validated['content'])) {
            try {
                $validated['excerpt'] = app(ClaudeService::class)->generateExcerpt($validated['content']);
            } catch (\Exception) {
                // Silently skip if API fails — excerpt stays empty
            }
        }

        $relatedPickId = $validated['related_pick_id'] ?? null;
        unset($validated['related_pick_id']);

        $article = Article::create($validated);

        // Link the selected pick to this article
        if ($relatedPickId) {
            // Unlink any other pick already pointing to this article (safety)
            Pick::where('related_article_id', $article->id)->update(['related_article_id' => null]);
            Pick::where('id', $relatedPickId)->update(['related_article_id' => $article->id]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', [
            'article' => $article,
            'picks'   => Pick::orderBy('game_date', 'desc')->get(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'excerpt'        => ['nullable', 'string'],
            'content'        => ['required', 'string'],
            'category'       => ['required', 'string', 'max:50'],
            'sport'          => ['nullable', 'string', 'max:50'],
            'author'         => ['nullable', 'string', 'max:255'],
            'expert_name'    => ['nullable', 'string', 'max:255'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_premium'     => ['boolean'],
            'is_published'   => ['boolean'],
            'published_at'   => ['nullable', 'date'],
            'related_pick_id'=> ['nullable', 'exists:picks,id'],
        ]);

        $baseSlug = Str::slug($validated['title']);
        $slug = $baseSlug;
        $i = 2;
        while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug = $baseSlug . '-' . $i++;
        }
        $validated['slug'] = $slug;

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['is_published'] = $request->boolean('is_published');
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $path = $request->file('featured_image')->store('uploads/articles', 'public');
            $validated['featured_image'] = $path;
        }

        // Auto-generate excerpt if blank
        if (empty($validated['excerpt']) && !empty($validated['content'])) {
            try {
                $validated['excerpt'] = app(ClaudeService::class)->generateExcerpt($validated['content']);
            } catch (\Exception) {
                // Silently skip if API fails
            }
        }

        $relatedPickId = $validated['related_pick_id'] ?? null;
        unset($validated['related_pick_id']);

        $article->update($validated);

        // Unlink all picks currently pointing to this article, then re-link the chosen one
        Pick::where('related_article_id', $article->id)->update(['related_article_id' => null]);
        if ($relatedPickId) {
            Pick::where('id', $relatedPickId)->update(['related_article_id' => $article->id]);
        }

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }

    public function parsePdf(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate(['pdf' => ['required', 'file', 'mimes:pdf', 'max:10240']]);

        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf    = $parser->parseFile($request->file('pdf')->getRealPath());
            $text   = $pdf->getText();

            // Convert plain text to basic HTML paragraphs
            $lines = preg_split('/\n{2,}/', trim($text));
            $html  = '';
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') continue;
                // Single-line that looks like a heading (short, no period at end)
                if (strlen($line) < 80 && !str_ends_with($line, '.')) {
                    $html .= '<h2>' . htmlspecialchars($line) . '</h2>' . "\n";
                } else {
                    $html .= '<p>' . nl2br(htmlspecialchars($line)) . '</p>' . "\n";
                }
            }

            return response()->json(['html' => $html ?: '<p>' . htmlspecialchars($text) . '</p>']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not parse PDF: ' . $e->getMessage()], 422);
        }
    }
}
