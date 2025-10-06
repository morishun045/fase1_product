<?php

namespace App\Http\Controllers;

use App\Models\Comic;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comics = Comic::with('liked')->latest()->get();
        $query = Comic::query();
        $comics=$query->latest()->paginate(10);


        return view('comics.index', compact('comics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                        'required',
                        'max:255',
                        Rule::unique('comics')->where(function ($query) use ($request) {
                        return $query->where('author', $request->author);
                        }),
                    ],
            'author' => 'required|max:255',
            'publisher' => 'nullable|max:255',
            'description' => 'nullable|max:400',
            'image' => 'nullable|image',
        ], [
            'tilte.unique' => 'その作者のその作品はすでに登録されています。',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        Comic::create($validated);

        return redirect()->route('comics.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comic $comic)
    {
        $comic->load('comments');
        $existReview = null;
        if (Auth::check()) {
            $existReview = Comment::where('comic_id', $comic->id)
                ->where('user_id', auth()->id())
                ->first();
        }
        return view('comics.show', compact('comic', 'existReview'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comic $comic)
    {
        return view('comics.edit', compact('comic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comic $comic)
    {
        $validated = $request->validate([
            'title' => [
                        'required',
                        'max:255',
                        Rule::unique('comics')->where(function ($query) use ($request) {
                        return $query->where('author', $request->author);
                        })->ignore($comic->id),
                    ],
            'author' => 'required|max:255',
            'publisher' => 'nullable|max:255',
            'description' => 'nullable|max:400',
        ], [
            'title.unique' => 'その作者のその作品はすでに登録されています。',
        ]);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'nullable|image',
            ]);
            if ($comic->image) {
                Storage::disk('public')->delete($comic->image);
            }
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $comic->update($validated);

        return redirect()->route('comics.show', $comic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comic $comic)
    {
        $comic->delete();
        return redirect()->route('comics.index');
    }

    public function search(Request $request)
    {

        $query = Comic::query();

        // キーワードが指定されている場合のみ検索を実行
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('title', 'like', '%' . $keyword . '%');
        }

        // ページネーションを追加（1ページに10件表示）
        $comics = $query
            ->latest()
            ->paginate(10);

        return view('comics.search', compact('comics'));
    }
}
