<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();
        return view('dashboard', compact('pages'));
    }

    public function edit(Page $page)
    {
        return response()->json($page);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        // Auto-generate slug from title if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Ensure slug is unique
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Page::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        Page::create($validated);

        return redirect()->route('dashboard')->with('success', 'Pagina succesvol aangemaakt!');
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        // Auto-generate slug from title if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            
            // Ensure slug is unique (excluding current page)
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Page::where('slug', $validated['slug'])->where('id', '!=', $page->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $page->update($validated);

        return redirect()->route('dashboard')->with('success', 'Pagina succesvol bijgewerkt!');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('dashboard')->with('success', 'Pagina succesvol verwijderd!');
    }

    /**
     * Publieke index: alle gepubliceerde pagina's tonen.
     */
    public function indexPublic()
    {
        $pages = Page::where('status', 'published')
            ->orderBy('title')
            ->get();

        return view('pages.index', compact('pages'));
    }

    /**
     * Publieke weergave van een gepubliceerde pagina op basis van slug.
     */
    public function showPublic(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('pages.show', compact('page'));
    }
}
