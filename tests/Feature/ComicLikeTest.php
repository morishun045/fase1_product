<?php

use App\Models\User;
use App\Models\Comic;

it('allows a user to like a comic', function () {
    $user = User::factory()->create();
    $comic = Comic::factory()->create();

    $this->actingAs($user)
        ->post(route('comics.like', ['comic' => $comic->id]))
        ->assertStatus(302);

    $this->assertDatabaseHas('comic_user', [
        'user_id' => $user->id,
        'comic_id' => $comic->id
    ]);
});

it('allows a user to dislike a comic', function () {
    $user = User::factory()->create();
    $comic = Comic::factory()->create();

    $user->likes()->attach($comic);

    $this->actingAs($user)
        ->delete(route('comics.dislike', ['comic' => $comic->id]))
        ->assertStatus(302);

    $this->assertDatabaseMissing('comic_user', [
        'user_id' => $user->id,
        'comic_id' => $comic->id
    ]);
});
