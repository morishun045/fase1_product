<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ComicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('comics')->truncate();
         $comics = [
            [
                'title' => 'ONE PIECE',
                'author' => '尾田栄一郎',
                'publisher' => '集英社',
                'description' => '海賊王を目指す少年モンキー・D・ルフィとその仲間たちの冒険物語。',
                'image' => null, // 画像は後で登録するため、一旦nullにしておく
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '進撃の巨人',
                'author' => '諫山創',
                'publisher' => '講談社',
                'description' => '巨人がすべてを支配する世界。巨人の餌と化した人類は、巨大な壁を築き、壁外への自由と引き換えに侵略を防いでいた。',
                'image' => null,
                'created_at' => now()->addSeconds(1),
                'updated_at' => now()->addSeconds(1),
            ],
            [
                'title' => '鬼滅の刃',
                'author' => '吾峠呼世晴',
                'publisher' => '集英社',
                'description' => '時は大正、日本。炭を売る心優しき少年・炭治郎は、ある日鬼に家族を皆殺しにされてしまう。',
                'image' => null,
                'created_at' => now()->addSeconds(2),
                'updated_at' => now()->addSeconds(2),
            ],
            [
                'title' => '呪術廻戦',
                'author' => '芥見下々',
                'publisher' => '集英社',
                'description' => '驚異的な身体能力を持つ、少年・虎杖悠仁はごく普通の高校生活を送っていたが、ある日“呪い”に襲われた学友を救うため、自身の魂に呪いを宿してしまう。',
                'image' => null,
                'created_at' => now()->addSeconds(3),
                'updated_at' => now()->addSeconds(3),
            ],
            [
                'title' => 'SLAM DUNK',
                'author' => '井上雄彦',
                'publisher' => '集英社',
                'description' => '中学校3年間で50人もの女性にフラれた高校1年の不良少年・桜木花道が、ふとしたきっかけで湘北高校バスケットボール部に入部し、チームメイトやライバルたちと共に成長していく物語。',
                'image' => null,
                'created_at' => now()->addSeconds(4),
                'updated_at' => now()->addSeconds(4),
            ],
        ];

        DB::table('comics')->insert($comics);
    }
}
