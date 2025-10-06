<?php
use App\Models\User;
use App\Models\Comment;
use App\Models\Comic;

it('can follow a user', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $followedUser = User::factory()->create();
  $this->post(route('follow.store', $followedUser));

  $this->assertDatabaseHas('follows', [
    'follow_id' => $user->id,
    'follower_id' => $followedUser->id,
  ]);
});

it('can unFollow a user', function () {
  $user = User::factory()->create();
  $this->actingAs($user);

  $followedUser = User::factory()->create();
  $user->following()->attach($followedUser);
  $this->delete(route('follow.destroy', $followedUser));

  $this->assertDatabaseMissing('follows', [
    'follow_id' => $user->id,
    'follower_id' => $followedUser->id,
  ]);
});

it('displays the following list page correctly', function () {

    $userA = User::factory()->create(); // プロフィールページの持ち主
    $userB = User::factory()->create(); // userAがフォローしているユーザー
    $userC = User::factory()->create(); // userAがフォローしていないユーザー

    $userA->following()->attach($userB);

    $response = $this->actingAs($userA)->get(route('profile.following', $userA));

    $response->assertStatus(200);
    $response->assertSee($userB->name);
    $response->assertDontSee($userC->name);
});


it('show favorite comics', function (){
    $user=User::factory()->create();
    $this->actingAs($user);

    $likedcomic = Comic::factory()->create();
    $unlikedcomic = Comic::factory()->create();

    $user->likes()->attach($likedcomic);

    $response=$this->get(route('profile.show', $user));

    $response->assertStatus(200);
    $response->assertSee($likedcomic->title);
    $response->assertDontSee($unlikedcomic->title);
});