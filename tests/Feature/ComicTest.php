<?php

use App\Models\Comic;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('displays comics on the list page', function () {

    $user = User::factory()->create();
    $comic = Comic::factory()->create();

    $response = $this->actingAs($user)->get('/comics');

    $response->assertStatus(200);
    $response->assertSee($comic->title);
    $response->assertSee($comic->author);
    $response->assertSee($comic->publisher);
    $response->assertSee($comic->description);
});

it('displays the create comic page', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/comics/create');
    $response->assertStatus(200);
});

it('allows authenticated users to create a comic', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    Storage::fake('public');

    $comicData = [
        'title' => 'テスト漫画',
        'author' => 'テスト作者',
        'publisher' => 'テスト出版社',
        'description' => 'これはテスト用のあらすじです。',
        'image' => UploadedFile::fake()->image('test_cover.jpg'),
    ];

    $response = $this->post('/comics', $comicData);
    $dbCheckData = $comicData;
    unset($dbCheckData['image']);

    $this->assertDatabaseHas('comics', $dbCheckData);

    $comic = Comic::where('title', 'テスト漫画')->first();
    Storage::disk('public')->assertExists($comic->image);

    $response->assertStatus(302);
    $response->assertRedirect('/comics');
});

it('displays a comic', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $comic = Comic::factory()->create();

    $response = $this->get("/comics/{$comic->id}");

    $response->assertStatus(200);
    $response->assertSee($comic->title);
    $response->assertSee($comic->author);
    $response->assertSee($comic->publisher);
    $response->assertSee($comic->description);
    $response->assertSee($comic->created_at->format('Y-m-d H:i'));
    $response->assertSee($comic->updated_at->format('Y-m-d H:i'));
});

it ('displays the edit comic page', function (){
    $user = User::factory()->create();

    $this ->actingAs($user);
    $comic=Comic::factory()->create();
    $response=$this->get("/comics/{$comic->id}/edit");
    $response->assertStatus(200);
    $response->assertSee($comic->title);
    $response->assertSee($comic->author);
    $response->assertSee($comic->publisher);
    $response->assertSee($comic->description);

});
it ('can update a comic with a new image', function(){
    Storage::fake('public');

    $user = User::factory()->create();
    $this->actingAs($user);

    $oldImageFile = UploadedFile::fake()->image('old_cover.jpg');
    $oldImagePath = $oldImageFile->store('images', 'public');

    $comic = Comic::factory()->create(['image' => $oldImagePath,]);

    $updatedData = [
        'title' => '画像が更新された漫画',
        'author' => $comic->author, 
        'image' => UploadedFile::fake()->image('new_cover.jpg'),
    ];

    $response = $this->put("/comics/{$comic->id}", $updatedData);

    $response->assertRedirect("/comics/{$comic->id}");
    $this->assertDatabaseHas('comics', [
        'id' => $comic->id,
        'title' => '画像が更新された漫画',
    ]);
    $comic->refresh();
    $this->assertNotEquals($oldImagePath, $comic->image);

    Storage::disk('public')->assertExists($comic->image);
    Storage::disk('public')->assertMissing($oldImagePath);

});
it ('allows a user to delete ', function(){
    $user = User::factory()->create();
    $this->actingAs($user);
    $comic = Comic::factory()->create();

    $response=$this->delete("/comics/{$comic->id}");

    $this->assertDatabaseMissing('comics', ['id' => $comic->id]);

    $response->assertStatus(302);
    $response->assertRedirect('/comics');
});

it('can search comics by title keyword', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Comic::factory()->create([
        'title' => 'これはテスト用のすごい漫画',
    ]);

    Comic::factory()->create([
        'title' => 'これは別の普通の漫画',
    ]);

    $response = $this->get(route('comics.search', ['keyword' => 'すごい']));


    $response->assertStatus(200);
    $response->assertSee('これはテスト用のすごい漫画');
    $response->assertDontSee('これは別の普通の漫画');
});

it('shows a message if no comics are found', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Comic::factory()->create([
        'title' => '存在する漫画',
    ]);

    $response = $this->get(route('comics.search', ['keyword' => '存在しないキーワード']));

    $response->assertStatus(200);
    $response->assertDontSee('存在する漫画');
    $response->assertSee('検索結果が見つかりませんでした。');
});
