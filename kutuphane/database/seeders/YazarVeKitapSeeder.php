<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class YazarVeKitapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 10 Türk yazarı ekle
        $yazarlar = [
            'Orhan Pamuk',
            'Elif Şafak',
            'Ahmet Hamdi Tanpınar',
            'Yaşar Kemal',
            'Halide Edip Adıvar',
            'Reşat Nuri Güntekin',
            'Ömer Seyfettin',
            'Sabahattin Ali',
            'Aziz Nesin',
            'Turgut Uyar'
        ];

        $yazarIds = [];
        foreach ($yazarlar as $yazarAdi) {
            $yazar = Author::create(['name' => $yazarAdi]);
            $yazarIds[] = $yazar->id;
        }

        // 50 kitap ekle
        $kitaplar = [
            // Orhan Pamuk kitapları
            ['book_name' => 'Kara Kitap', 'author_id' => $yazarIds[0], 'ISBN' => '9789750719384', 'image' => 'kara-kitap.jpg'],
            ['book_name' => 'Kar', 'author_id' => $yazarIds[0], 'ISBN' => '9789750719391', 'image' => 'kar.jpg'],
            ['book_name' => 'Masumiyet Müzesi', 'author_id' => $yazarIds[0], 'ISBN' => '9789750719407', 'image' => 'masumiyet-muzesi.jpg'],
            ['book_name' => 'Beyaz Kale', 'author_id' => $yazarIds[0], 'ISBN' => '9789750719414', 'image' => 'beyaz-kale.jpg'],
            ['book_name' => 'Benim Adım Kırmızı', 'author_id' => $yazarIds[0], 'ISBN' => '9789750719421', 'image' => 'benim-adim-kirmizi.jpg'],

            // Elif Şafak kitapları
            ['book_name' => 'Aşk', 'author_id' => $yazarIds[1], 'ISBN' => '9789750719438', 'image' => 'ask.jpg'],
            ['book_name' => 'Baba ve Piç', 'author_id' => $yazarIds[1], 'ISBN' => '9789750719445', 'image' => 'baba-ve-pic.jpg'],
            ['book_name' => 'Şemspare', 'author_id' => $yazarIds[1], 'ISBN' => '9789750719452', 'image' => 'semsipare.jpg'],
            ['book_name' => 'Mahrem', 'author_id' => $yazarIds[1], 'ISBN' => '9789750719469', 'image' => 'mahrem.jpg'],
            ['book_name' => 'Pinhan', 'author_id' => $yazarIds[1], 'ISBN' => '9789750719476', 'image' => 'pinhan.jpg'],

            // Ahmet Hamdi Tanpınar kitapları
            ['book_name' => 'Huzur', 'author_id' => $yazarIds[2], 'ISBN' => '9789750719483', 'image' => 'huzur.jpg'],
            ['book_name' => 'Saatleri Ayarlama Enstitüsü', 'author_id' => $yazarIds[2], 'ISBN' => '9789750719490', 'image' => 'saatleri-ayarlama-enstitusu.jpg'],
            ['book_name' => 'Mahur Beste', 'author_id' => $yazarIds[2], 'ISBN' => '9789750719506', 'image' => 'mahur-beste.jpg'],
            ['book_name' => 'Sahnenin Dışındakiler', 'author_id' => $yazarIds[2], 'ISBN' => '9789750719513', 'image' => 'sahnenin-disindakiler.jpg'],
            ['book_name' => 'Aydaki Kadın', 'author_id' => $yazarIds[2], 'ISBN' => '9789750719520', 'image' => 'aydaki-kadin.jpg'],

            // Yaşar Kemal kitapları
            ['book_name' => 'İnce Memed', 'author_id' => $yazarIds[3], 'ISBN' => '9789750719537', 'image' => 'ince-memed.jpg'],
            ['book_name' => 'Yer Demir Gök Bakır', 'author_id' => $yazarIds[3], 'ISBN' => '9789750719544', 'image' => 'yer-demir-gok-bakir.jpg'],
            ['book_name' => 'Ölmez Otu', 'author_id' => $yazarIds[3], 'ISBN' => '9789750719551', 'image' => 'olmez-otu.jpg'],
            ['book_name' => 'Demirciler Çarşısı Cinayeti', 'author_id' => $yazarIds[3], 'ISBN' => '9789750719568', 'image' => 'demirciler-carsisi-cinayeti.jpg'],
            ['book_name' => 'Yusufçuk Yusuf', 'author_id' => $yazarIds[3], 'ISBN' => '9789750719575', 'image' => 'yusufcuk-yusuf.jpg'],

            // Halide Edip Adıvar kitapları
            ['book_name' => 'Sinekli Bakkal', 'author_id' => $yazarIds[4], 'ISBN' => '9789750719582', 'image' => 'sinekli-bakkal.jpg'],
            ['book_name' => 'Vurun Kahpeye', 'author_id' => $yazarIds[4], 'ISBN' => '9789750719599', 'image' => 'vurun-kahpeye.jpg'],
            ['book_name' => 'Ateşten Gömlek', 'author_id' => $yazarIds[4], 'ISBN' => '9789750719605', 'image' => 'ates-ten-gomlek.jpg'],
            ['book_name' => 'Türkün Ateşle İmtihanı', 'author_id' => $yazarIds[4], 'ISBN' => '9789750719612', 'image' => 'turkun-atesle-imtihani.jpg'],
            ['book_name' => 'Mor Salkımlı Ev', 'author_id' => $yazarIds[4], 'ISBN' => '9789750719629', 'image' => 'mor-salkimli-ev.jpg'],

            // Reşat Nuri Güntekin kitapları
            ['book_name' => 'Çalıkuşu', 'author_id' => $yazarIds[5], 'ISBN' => '9789750719636', 'image' => 'calikusu.jpg'],
            ['book_name' => 'Yaprak Dökümü', 'author_id' => $yazarIds[5], 'ISBN' => '9789750719643', 'image' => 'yaprak-dokumu.jpg'],
            ['book_name' => 'Dudaktan Kalbe', 'author_id' => $yazarIds[5], 'ISBN' => '9789750719650', 'image' => 'dudaktan-kalbe.jpg'],
            ['book_name' => 'Acımak', 'author_id' => $yazarIds[5], 'ISBN' => '9789750719667', 'image' => 'acimak.jpg'],
            ['book_name' => 'Yeşil Gece', 'author_id' => $yazarIds[5], 'ISBN' => '9789750719674', 'image' => 'yesil-gece.jpg'],

            // Ömer Seyfettin kitapları
            ['book_name' => 'Kaşağı', 'author_id' => $yazarIds[6], 'ISBN' => '9789750719681', 'image' => 'kasagi.jpg'],
            ['book_name' => 'Falaka', 'author_id' => $yazarIds[6], 'ISBN' => '9789750719698', 'image' => 'falaka.jpg'],
            ['book_name' => 'Beyaz Lale', 'author_id' => $yazarIds[6], 'ISBN' => '9789750719704', 'image' => 'beyaz-lale.jpg'],
            ['book_name' => 'Pembe İncili Kaftan', 'author_id' => $yazarIds[6], 'ISBN' => '9789750719711', 'image' => 'pembe-incili-kaftan.jpg'],
            ['book_name' => 'Gizli Mabet', 'author_id' => $yazarIds[6], 'ISBN' => '9789750719728', 'image' => 'gizli-mabet.jpg'],

            // Sabahattin Ali kitapları
            ['book_name' => 'Kürk Mantolu Madonna', 'author_id' => $yazarIds[7], 'ISBN' => '9789750719735', 'image' => 'kurk-mantolu-madonna.jpg'],
            ['book_name' => 'Kuyucaklı Yusuf', 'author_id' => $yazarIds[7], 'ISBN' => '9789750719742', 'image' => 'kuyucakli-yusuf.jpg'],
            ['book_name' => 'İçimizdeki Şeytan', 'author_id' => $yazarIds[7], 'ISBN' => '9789750719759', 'image' => 'icimizdeki-seytan.jpg'],
            ['book_name' => 'Değirmen', 'author_id' => $yazarIds[7], 'ISBN' => '9789750719766', 'image' => 'degirmen.jpg'],
            ['book_name' => 'Sırça Köşk', 'author_id' => $yazarIds[7], 'ISBN' => '9789750719773', 'image' => 'sirca-kosk.jpg'],

            // Aziz Nesin kitapları
            ['book_name' => 'Zübük', 'author_id' => $yazarIds[8], 'ISBN' => '9789750719780', 'image' => 'zubuk.jpg'],
            ['book_name' => 'Yaşar Ne Yaşar Ne Yaşamaz', 'author_id' => $yazarIds[8], 'ISBN' => '9789750719797', 'image' => 'yasar-ne-yasar.jpg'],
            ['book_name' => 'Şimdiki Çocuklar Harika', 'author_id' => $yazarIds[8], 'ISBN' => '9789750719803', 'image' => 'simdiki-cocuklar-harika.jpg'],
            ['book_name' => 'Tatlı Betüş', 'author_id' => $yazarIds[8], 'ISBN' => '9789750719810', 'image' => 'tatli-betus.jpg'],
            ['book_name' => 'Gol Kralı', 'author_id' => $yazarIds[8], 'ISBN' => '9789750719827', 'image' => 'gol-krali.jpg'],

            // Turgut Uyar kitapları
            ['book_name' => 'Dünyanın En Güzel Arabistanı', 'author_id' => $yazarIds[9], 'ISBN' => '9789750719834', 'image' => 'dunyanin-en-guzel-arabistani.jpg'],
            ['book_name' => 'Tütünler Islak', 'author_id' => $yazarIds[9], 'ISBN' => '9789750719841', 'image' => 'tutunler-islak.jpg'],
            ['book_name' => 'Her Pazartesi', 'author_id' => $yazarIds[9], 'ISBN' => '9789750719858', 'image' => 'her-pazartesi.jpg'],
            ['book_name' => 'Divan', 'author_id' => $yazarIds[9], 'ISBN' => '9789750719865', 'image' => 'divan.jpg'],
            ['book_name' => 'Toplandılar', 'author_id' => $yazarIds[9], 'ISBN' => '9789750719872', 'image' => 'toplandilar.jpg']
        ];

        foreach ($kitaplar as $kitap) {
            Book::create($kitap);
        }

        $this->command->info('10 yazar ve 50 kitap başarıyla eklendi!');
    }
} 