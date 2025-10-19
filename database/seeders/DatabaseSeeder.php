<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Insert content directly - Multiple contents
        DB::table('contents')->insert([
            // Content 1: Handbag Multifungsi
            [
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'idea' => 'Handbag Multifungsi untuk cowok yang anti ribet',
                'title' => 'Handbag Multifungsi: Bro, Anti Ribet!',
                'caption' => 'Ke mall bawa banyak barang? Auto rempong, bro! Pake Hefand Ortize – dompet multifungsi, compact, bisa jadi slingbag, muat HP-dompet-aksesori tanpa ngegembung. Maskulin & simpel, urusan beres. Upgrade gayamu sekarang!',
                'video_prompt' => '{"video":{"title":"Handbag Multifungsi: Bro, Anti Ribet!","duration":10,"narration":"Ke mall bawa banyak barang? Auto rempong, bro! Pake Hefand Ortize – dompet multifungsi, compact, bisa jadi slingbag, muat HP-dompet-aksesori tanpa ngegembung. Maskulin & simpel, urusan beres. Upgrade gayamu sekarang!"},"visual":{"style":"absurd, dreamy, viral aesthetic","camera":"dynamic tracking shots, close-ups, and wide angles with smooth transitions","lighting":"soft ambient lighting with a touch of spot highlights","color_palette":["charcoal","silver","warm beige","coffee brown"],"scenes":[{"time":"0-3","description":"Cowok stylish jalan cepat di mall, tangan sibuk pegang HP dan kantong belanjaan, wajah kelihatan hectic dan sedikit panik."},{"time":"3-6","description":"Cut ke close-up Hefand Ortize – cowok selipkan semua barang (HP, kartu, headset) ke dompet multifungsi, finishing rapi, ekspresi lega dan confident."},{"time":"6-9","description":"Cowok ganteng melenggang pede, semua barang tersusun di dompet-slingbag. Orang sekitar ngeliatin, ada efek dreamy dan viral."},{"time":"9-10","description":"Logo Hefand Ortize muncul, teks viral: \'Next level cowok smart. Klik untuk upgrade!\'"}]},"audio":{"music_mood":"catchy urban funk beat confident dan ringan","sfx":[{"time":3.2,"effect":"swoosh cepat transisi dompet multifungsi"},{"time":5.0,"effect":"zip kompartemen dompet terbuka"},{"time":8.1,"effect":"clasp dompet tertutup, click crisp"}]}}',
                'image_ref' => 'https://s3.demolite.my.id/gen-reel/daf17c66-0c20-47c3-a76f-841f3ee2fa83/82652d79-95d4-4d1e-b401-8a1656e96703.jpeg',
                'aspect_ratio' => 'portrait',
                'style' => 'professional',
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Content 2: Clutch Kecil
            [
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'idea' => 'Clutch kecil dengan gaya maksimal',
                'title' => 'Clutch Kecil, Gaya Maksimal!',
                'caption' => 'Ketinggalan zaman bawa tas segede gaban! Cowok zaman now: simple, stylish, muat banyak. Clutch Hefand, kecil-kecil cabe rawit!',
                'video_prompt' => '{"video":{"title":"Clutch Kecil, Gaya Maksimal!","duration":10,"narration":"Ketinggalan zaman bawa tas segede gaban! Cowok zaman now: simple, stylish, muat banyak. Clutch Hefand, kecil-kecil cabe rawit!"},"visual":{"style":"absurd, dreamy, viral aesthetic","camera":"zoom in dramatis, sudut serong handheld","lighting":"high contrast dengan efek dreamy bloom","color_palette":["neon pink","electric blue","matte black","chrome silver"],"scenes":[{"time":"0-3","description":"Cowok berjalan ngos-ngosan, bawa ransel jumbo dan kantong plastik berceceran. Kamera hand-held mengikuti dari samping penuh dramatisasi."},{"time":"3-6","description":"Senyum terkejut saat lihat cowok lain ambil clutch Hefand mini — efek kartun \'pop\' — dan isinya keluar bertingkat: botol minum, dompet, charger, bahkan jaket tipis. Mata terbelalak kaget dan kagum."},{"time":"6-9","description":"Langsung ganti, ransel dibuang ke udara meletus seperti confetti warna-warni. Cowok pegang clutch Hefand, melangkah slow motion di lorong neon futuristik."},{"time":"9-10","description":"Teks tayang: \'HEFAND — Clutch kecil, urusan besar\' bareng logo brand melenting, suara narator: \'Beli sekarang, bro!\'"}]},"audio":{"music_mood":"synth-pop dreamy aneh dengan beat quirky","sfx":[{"time":3.2,"effect":"pop kartun aneh"},{"time":5.1,"effect":"whoosh ekspresi shock"},{"time":8.0,"effect":"letusan confetti glitter"}]}}',
                'image_ref' => 'https://s3.demolite.my.id/gen-reel/daf17c66-0c20-47c3-a76f-841f3ee2fa83/b4299ab8-fbc6-44fa-86e2-3535a4a0147c.jpeg',
                'aspect_ratio' => 'portrait',
                'style' => 'absurd',
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Content 3: Sendal Anti Selip
            [
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'idea' => 'Sendal anti selip yang stylish dan terjangkau',
                'title' => 'Sendal Keren, Anti Selip – Gaya Aman, Duit Selamat!',
                'caption' => 'Cowok stylish kelabakan tiap nemu lantai licin… sampai nemu sendal budget ramah: ringan, anti selip, dan tetap cool!',
                'video_prompt' => '{"video":{"title":"Sendal Keren, Anti Selip – Gaya Aman, Duit Selamat!","duration":10,"narration":"Cowok stylish kelabakan tiap nemu lantai licin… sampai nemu sendal budget ramah: ringan, anti selip, dan tetap cool!"},"visual":{"style":"absurd, dreamy, viral aesthetic","camera":"speed-ramp chaos cut & punchy close-ups","lighting":"matte neon + shower of daylight","color_palette":["electric blue","bold orange","matte black"],"scenes":[{"time":"0-3","description":"Cowok berparas kece berlari di mall saat lihat diskon, lalu tergelincir dan terbang dramatis seperti slow-motion kartun. Background berubah jadi cetakan uang kertas beterbangan."},{"time":"3-6","description":"Saat jatuh, dia meratapi dompet tipis, tiba-tiba sendal glowing muncul dari dalam etalase, seperti disorot spotlight."},{"time":"6-9","description":"Cowok mencoba sendal itu, beraksi parkour super pede – loncat eskalator, sliding licin di lantai, semua aman tanpa selip. Penonton mall heboh tepuk tangan dengan efek euforia."},{"time":"9-10","description":"Cut ke close-up sendal, logo muncul dengan suara heroik: \'ANTI SELIP, HEMAT STYLISH! Pilihan cowok kekinian.\' + CTA: \'Beli sekarang, dompet aman, kaki nyaman!\'"}]},"audio":{"music_mood":"funky synth-wave dengan beat jenaka","sfx":[{"time":2.7,"effect":"cartoon slip squeak saat cowok terpeleset"},{"time":5.5,"effect":"bling sound saat sendal glowing muncul"},{"time":8.3,"effect":"suara gemuruh crowd \'WOOOO!\' dengan echo viral"}]}}',
                'image_ref' => 'https://s3.demolite.my.id/gen-reel/daf17c66-0c20-47c3-a76f-841f3ee2fa83/a2db305d-f20d-4332-b158-07dc0fe9107d.jpeg',
                'aspect_ratio' => 'portrait',
                'style' => 'absurd',
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Content 4: Setelan Cargo
            [
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'idea' => 'Setelan cargo oversize yang lucu dan stylish',
                'title' => 'Setelan Cargo Bikin Ngakak, Tetep Kawaii!',
                'caption' => 'Cewek tampil dengan setelan cargo oversize, pose lucu di tengah ruang tamu: Dresscode penting buat ngejar diskonan kopi, guys!',
                'video_prompt' => '{"video":{"title":"Setelan Cargo Bikin Ngakak, Tetep Kawaii!","duration":10,"narration":"Cewek tampil dengan setelan cargo oversize, pose lucu di tengah ruang tamu: \'Dresscode penting buat ngejar diskonan kopi, guys!\' (ngikik absurd) | Narator: \'Tampil lucu & gampang, dompet tetap aman!\'"},"visual":{"style":"absurd, dreamy, viral aesthetic","camera":"fast cuts, playful low angle, fisheye lens for exaggerated comedy","lighting":"pastel filter, accent light on outfit","color_palette":["bubblegum pink","sage green","soft grey","light blue"],"scenes":[{"time":"0-3","description":"Cewek melompat keluar dari belakang sofa bawa tote bag raksasa, pakai setelan cargo oversize. Latar ruang tamu berubah jadi kartun dreamy penuh efek bintang."},{"time":"3-6","description":"Gaya pose OOTD ala idol, ekspresi exaggerated sambil muncul tulisan \'Kawaii Nampol!\' di font komik gelembung."},{"time":"6-9","description":"Duduk nyantai di bean bag, ngemil keripik, sambil selfie dengan filter lucu. Tulisan melayang muncul: \'Cukup Cargo, Tetap Gemes\'."},{"time":"9-10","description":"Close-up muka absurd sambil berkata \'Nggak pake ribet, langsung klik aja!\' Logo brand dan CTA langsung muncul dengan suara efek pop."}]},"audio":{"music_mood":"upbeat, quirky bubble pop","sfx":[{"time":3.5,"effect":"anime pop-in"},{"time":5.5,"effect":"slide up whoosh"},{"time":8.8,"effect":"magic sparkle over tulisan"}]}}',
                'image_ref' => 'https://s3.demolite.my.id/gen-reel/daf17c66-0c20-47c3-a76f-841f3ee2fa83/dc0d2329-6ecd-4bd8-84e2-0f0af943e48b.jpeg',
                'aspect_ratio' => 'portrait',
                'style' => 'absurd',
                'status' => 'success',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
