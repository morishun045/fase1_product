<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Comic;
use App\Models\Comment;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $comics = Comic::all();

        // 何もない場合は処理を中断
        if ($users->isEmpty() || $comics->isEmpty()) {
            $this->command->info('ユーザーまたは漫画のデータが存在しないため、関係性のSeedingをスキップしました。');
            return;
        }

        // 既存の関係性データをクリア
        Comment::truncate();
        \Illuminate\Support\Facades\DB::table('comic_user')->truncate(); // お気に入りの中間テーブル
        \Illuminate\Support\Facades\DB::table('follows')->truncate(); // フォローの中間テーブル

        // --- レビュー (Comment) の作成 ---
        // 田中さんが『ONE PIECE』にレビュー
        Comment::create([
            'user_id' => $users->firstWhere('email', 'taro@example.com')->id,
            'comic_id' => $comics->firstWhere('title', 'ONE PIECE')->id,
            'comment' => '最高の冒険譚です！仲間との絆に感動します。',
            'rating' => 5,
        ]);
        // 鈴木さんが『進撃の巨人』にレビュー
        Comment::create([
            'user_id' => $users->firstWhere('email', 'hanako@example.com')->id,
            'comic_id' => $comics->firstWhere('title', '進撃の巨人')->id,
            'comment' => 'ストーリーの謎が深くて引き込まれます。少し怖いけど面白い！',
            'rating' => 4,
        ]);

        // --- お気に入り (Likes) の作成 ---
        $taro = $users->firstWhere('email', 'taro@example.com');
        $hanako = $users->firstWhere('email', 'hanako@example.com');

        // 田中さんが『鬼滅の刃』と『SLAM DUNK』をお気に入り登録
        $taro->likes()->attach($comics->firstWhere('title', '鬼滅の刃')->id);
        $taro->likes()->attach($comics->firstWhere('title', 'SLAM DUNK')->id);

        // 鈴木さんが『鬼滅の刃』と『呪術廻戦』をお気に入り登録
        $hanako->likes()->attach($comics->firstWhere('title', '鬼滅の刃')->id);
        $hanako->likes()->attach($comics->firstWhere('title', '呪術廻戦')->id);


        // --- フォロー関係の作成 ---
        $taro->following()->attach($hanako->id);
        $hanako->following()->attach($taro->id);
        $hanako->following()->attach($users->firstWhere('email', 'jiro@example.com')->id);
    
    }
}
