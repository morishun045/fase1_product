<?php

use App\Models\User;
use App\Models\Comic;
use App\Models\Comment;

it('displays the comment creation form', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $comic = Comic::factory()->create();

  $response = $this->get(route('comics.comments.create', $comic));
  $response->assertStatus(200);
  $response->assertViewIs('comics.comments.create');
  $response->assertViewHas('comic', $comic);
});

it('allows authenticated users to create a comment', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $comic = Comic::factory()->create();
  $commentData = ['comment' => 'store test comment',
                    'rating' => 5,
];

  $response = $this->post(route('comics.comments.store', $comic), $commentData);
  $response->assertRedirect(route('comics.show', $comic));
  $this->assertDatabaseHas('comments', [
    'comment' => $commentData['comment'],
    'rating' => $commentData['rating'],
    'comic_id' => $comic->id,
    'user_id' => $user->id,
  ]);
});

it('displays a comment', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $comic = Comic::factory()->create();
  $comment = $comic->comments()->create(Comment::factory()->raw(['user_id' => $user->id]));

  $response = $this->get(route('comics.comments.show', [$comic, $comment]));
  $response->assertStatus(200);
  $response->assertViewIs('comics.comments.show');
  $response->assertViewHas('comic', $comic);
  $response->assertViewHas('comment', $comment);
});

it('displays the edit comment page', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $comic = Comic::factory()->create();
  $comment = $comic->comments()->create(Comment::factory()->raw(['user_id' => $user->id]));

  $response = $this->get(route('comics.comments.edit', [$comic, $comment]));
  $response->assertStatus(200);
  $response->assertViewIs('comics.comments.edit');
  $response->assertViewHas('comic', $comic);
  $response->assertViewHas('comment', $comment);
});

it('allows a user to update their comment', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $comic = Comic::factory()->create();
  $comment = $comic->comments()->create(Comment::factory()->raw(['user_id' => $user->id]));
  $updatedData = ['comment' => 'update test comment',
                'rating'=> 5,
];

  $response = $this->put(route('comics.comments.update', [$comic, $comment]), $updatedData);
  $response->assertRedirect(route('comics.comments.show', [$comic, $comment]));
  $this->assertDatabaseHas('comments', [
    'id' => $comment->id,
    'comment' => $updatedData['comment'],
    'rating' => $updatedData['rating'],
  ]);
});

it('allows a user to delete their comment', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $comic = Comic::factory()->create();
  $comment = $comic->comments()->create(Comment::factory()->raw(['user_id' => $user->id]));

  $response = $this->delete(route('comics.comments.destroy', [$comic, $comment]));
  $response->assertRedirect(route('comics.show', $comic));
  $this->assertDatabaseMissing('comments', [
    'id' => $comment->id,
  ]);
});
