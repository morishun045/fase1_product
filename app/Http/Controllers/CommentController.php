<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Comic;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Comic $comic)
    {
        $existReview = Comment::where('comic_id', $comic->id)
                                    ->where('user_id', auth()->id())
                                    ->first();
        if($existReview){
            return redirect()->route('comics.comments.edit', ['comic'->$comic, 'comment'=>$existReview]);
        }
        return view('comics.comments.create', compact('comic'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Comic $comic)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);
        $comic->comments()->create([
            'comment' => $validated['comment'],
            'rating' => $validated['rating'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('comics.show', $comic);

    }

    /**
     * Display the specified resource.
     */
    public function show(Comic $comic, Comment $comment)
    {
        return view('comics.comments.show', compact('comic', 'comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comic $comic, Comment $comment)
    {
        return view('comics.comments.edit', compact('comic', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comic $comic, Comment $comment)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment ->update($validated);

        return redirect()->route('comics.comments.show', [$comic, $comment]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comic $comic, Comment $comment)
    {
        $comment->delete();

        return redirect()->route('comics.show', $comic);
    }
}
