<?php

namespace Database\Seeders;

use App\Models\Yazar;
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
            $yazar = Yazar::create(['isim' => $yazarAdi]);
            $yazarIds[] = $yazar->id;
        }

        // 50 kitap ekle
        $kitaplar = [
            // Orhan Pamuk kitapları
            ['kitap_adi' => 'Kara Kitap', 'yazar_id' => $yazarIds[0], 'ISBN' => '9789750719384', 'image' => 'kara-kitap.jpg'],
            ['kitap_adi' => 'Kar', 'yazar_id' => $yazarIds[0], 'ISBN' => '9789750719391', 'image' => 'kar.jpg'],
            ['kitap_adi' => 'Masumiyet Müzesi', 'yazar_id' => $yazarIds[0], 'ISBN' => '9789750719407', 'image' => 'masumiyet-muzesi.jpg'],
            ['kitap_adi' => 'Beyaz Kale', 'yazar_id' => $yazarIds[0], 'ISBN' => '9789750719414', 'image' => 'beyaz-kale.jpg'],
            ['kitap_adi' => 'Benim Adım Kırmızı', 'yazar_id' => $yazarIds[0], 'ISBN' => '9789750719421', 'image' => 'benim-adim-kirmizi.jpg'],

            // Elif Şafak kitapları
            ['kitap_adi' => 'Aşk', 'yazar_id' => $yazarIds[1], 'ISBN' => '9789750719438', 'image' => 'ask.jpg'],
            ['kitap_adi' => 'Baba ve Piç', 'yazar_id' => $yazarIds[1], 'ISBN' => '9789750719445', 'image' => 'baba-ve-pic.jpg'],
            ['kitap_adi' => 'Şemspare', 'yazar_id' => $yazarIds[1], 'ISBN' => '9789750719452', 'image' => 'semsipare.jpg'],
            ['kitap_adi' => 'Mahrem', 'yazar_id' => $yazarIds[1], 'ISBN' => '9789750719469', 'image' => 'mahrem.jpg'],
            ['kitap_adi' => 'Pinhan', 'yazar_id' => $yazarIds[1], 'ISBN' => '9789750719476', 'image' => 'pinhan.jpg'],

            // Ahmet Hamdi Tanpınar kitapları
            ['kitap_adi' => 'Huzur', 'yazar_id' => $yazarIds[2], 'ISBN' => '9789750719483', 'image' => 'huzur.jpg'],
            ['kitap_adi' => 'Saatleri Ayarlama Enstitüsü', 'yazar_id' => $yazarIds[2], 'ISBN' => '9789750719490', 'image' => 'saatleri-ayarlama-enstitusu.jpg'],
            ['kitap_adi' => 'Mahur Beste', 'yazar_id' => $yazarIds[2], 'ISBN' => '9789750719506', 'image' => 'mahur-beste.jpg'],
            ['kitap_adi' => 'Sahnenin Dışındakiler', 'yazar_id' => $yazarIds[2], 'ISBN' => '9789750719513', 'image' => 'sahnenin-disindakiler.jpg'],
            ['kitap_adi' => 'Aydaki Kadın', 'yazar_id' => $yazarIds[2], 'ISBN' => '9789750719520', 'image' => 'aydaki-kadin.jpg'],

            // Yaşar Kemal kitapları
            ['kitap_adi' => 'İnce Memed', 'yazar_id' => $yazarIds[3], 'ISBN' => '9789750719537', 'image' => 'ince-memed.jpg'],
            ['kitap_adi' => 'Yer Demir Gök Bakır', 'yazar_id' => $yazarIds[3], 'ISBN' => '9789750719544', 'image' => 'yer-demir-gok-bakir.jpg'],
            ['kitap_adi' => 'Ölmez Otu', 'yazar_id' => $yazarIds[3], 'ISBN' => '9789750719551', 'image' => 'olmez-otu.jpg'],
            ['kitap_adi' => 'Demirciler Çarşısı Cinayeti', 'yazar_id' => $yazarIds[3], 'ISBN' => '9789750719568', 'image' => 'demirciler-carsisi-cinayeti.jpg'],
            ['kitap_adi' => 'Yusufçuk Yusuf', 'yazar_id' => $yazarIds[3], 'ISBN' => '9789750719575', 'image' => 'yusufcuk-yusuf.jpg'],

            // Halide Edip Adıvar kitapları
            ['kitap_adi' => 'Sinekli Bakkal', 'yazar_id' => $yazarIds[4], 'ISBN' => '9789750719582', 'image' => 'sinekli-bakkal.jpg'],
            ['kitap_adi' => 'Vurun Kahpeye', 'yazar_id' => $yazarIds[4], 'ISBN' => '9789750719599', 'image' => 'vurun-kahpeye.jpg'],
            ['kitap_adi' => 'Ateşten Gömlek', 'yazar_id' => $yazarIds[4], 'ISBN' => '9789750719605', 'image' => 'ates-ten-gomlek.jpg'],
            ['kitap_adi' => 'Türkün Ateşle İmtihanı', 'yazar_id' => $yazarIds[4], 'ISBN' => '9789750719612', 'image' => 'turkun-atesle-imtihani.jpg'],
            ['kitap_adi' => 'Mor Salkımlı Ev', 'yazar_id' => $yazarIds[4], 'ISBN' => '9789750719629', 'image' => 'mor-salkimli-ev.jpg'],

            // Reşat Nuri Güntekin kitapları
            ['kitap_adi' => 'Çalıkuşu', 'yazar_id' => $yazarIds[5], 'ISBN' => '9789750719636', 'image' => 'calikusu.jpg'],
            ['kitap_adi' => 'Yaprak Dökümü', 'yazar_id' => $yazarIds[5], 'ISBN' => '9789750719643', 'image' => 'yaprak-dokumu.jpg'],
            ['kitap_adi' => 'Dudaktan Kalbe', 'yazar_id' => $yazarIds[5], 'ISBN' => '9789750719650', 'image' => 'dudaktan-kalbe.jpg'],
            ['kitap_adi' => 'Acımak', 'yazar_id' => $yazarIds[5], 'ISBN' => '9789750719667', 'image' => 'acimak.jpg'],
            ['kitap_adi' => 'Yeşil Gece', 'yazar_id' => $yazarIds[5], 'ISBN' => '9789750719674', 'image' => 'yesil-gece.jpg'],

            // Ömer Seyfettin kitapları
            ['kitap_adi' => 'Kaşağı', 'yazar_id' => $yazarIds[6], 'ISBN' => '9789750719681', 'image' => 'kasagi.jpg'],
            ['kitap_adi' => 'Falaka', 'yazar_id' => $yazarIds[6], 'ISBN' => '9789750719698', 'image' => 'falaka.jpg'],
            ['kitap_adi' => 'Beyaz Lale', 'yazar_id' => $yazarIds[6], 'ISBN' => '9789750719704', 'image' => 'beyaz-lale.jpg'],
            ['kitap_adi' => 'Pembe İncili Kaftan', 'yazar_id' => $yazarIds[6], 'ISBN' => '9789750719711', 'image' => 'pembe-incili-kaftan.jpg'],
            ['kitap_adi' => 'Gizli Mabet', 'yazar_id' => $yazarIds[6], 'ISBN' => '9789750719728', 'image' => 'gizli-mabet.jpg'],

            // Sabahattin Ali kitapları
            ['kitap_adi' => 'Kürk Mantolu Madonna', 'yazar_id' => $yazarIds[7], 'ISBN' => '9789750719735', 'image' => 'kurk-mantolu-madonna.jpg'],
            ['kitap_adi' => 'Kuyucaklı Yusuf', 'yazar_id' => $yazarIds[7], 'ISBN' => '9789750719742', 'image' => 'kuyucakli-yusuf.jpg'],
            ['kitap_adi' => 'İçimizdeki Şeytan', 'yazar_id' => $yazarIds[7], 'ISBN' => '9789750719759', 'image' => 'icimizdeki-seytan.jpg'],
            ['kitap_adi' => 'Değirmen', 'yazar_id' => $yazarIds[7], 'ISBN' => '9789750719766', 'image' => 'degirmen.jpg'],
            ['kitap_adi' => 'Sırça Köşk', 'yazar_id' => $yazarIds[7], 'ISBN' => '9789750719773', 'image' => 'sirca-kosk.jpg'],

            // Aziz Nesin kitapları
            ['kitap_adi' => 'Zübük', 'yazar_id' => $yazarIds[8], 'ISBN' => '9789750719780', 'image' => 'zubuk.jpg'],
            ['kitap_adi' => 'Yaşar Ne Yaşar Ne Yaşamaz', 'yazar_id' => $yazarIds[8], 'ISBN' => '9789750719797', 'image' => 'yasar-ne-yasar.jpg'],
            ['kitap_adi' => 'Şimdiki Çocuklar Harika', 'yazar_id' => $yazarIds[8], 'ISBN' => '9789750719803', 'image' => 'simdiki-cocuklar-harika.jpg'],
            ['kitap_adi' => 'Tatlı Betüş', 'yazar_id' => $yazarIds[8], 'ISBN' => '9789750719810', 'image' => 'tatli-betus.jpg'],
            ['kitap_adi' => 'Gol Kralı', 'yazar_id' => $yazarIds[8], 'ISBN' => '9789750719827', 'image' => 'gol-krali.jpg'],

            // Turgut Uyar kitapları
            ['kitap_adi' => 'Dünyanın En Güzel Arabistanı', 'yazar_id' => $yazarIds[9], 'ISBN' => '9789750719834', 'image' => 'dunyanin-en-guzel-arabistani.jpg'],
            ['kitap_adi' => 'Tütünler Islak', 'yazar_id' => $yazarIds[9], 'ISBN' => '9789750719841', 'image' => 'tutunler-islak.jpg'],
            ['kitap_adi' => 'Her Pazartesi', 'yazar_id' => $yazarIds[9], 'ISBN' => '9789750719858', 'image' => 'her-pazartesi.jpg'],
            ['kitap_adi' => 'Divan', 'yazar_id' => $yazarIds[9], 'ISBN' => '9789750719865', 'image' => 'divan.jpg'],
            ['kitap_adi' => 'Toplandılar', 'yazar_id' => $yazarIds[9], 'ISBN' => '9789750719872', 'image' => 'toplandilar.jpg']
        ];

        foreach ($kitaplar as $kitap) {
            Book::create($kitap);
        }

        $this->command->info('10 yazar ve 50 kitap başarıyla eklendi!');
    }
} 