<?php

namespace Database\Seeders;

use App\Models\Enterprise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnterpriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "name" => "Buxoroneftgaz AJ",
                "person" => "Qobilov Sardor",
                "phone" => "+99865 225-10-20",
                "location" => "Buxoro sh., Ibn Sino koʻchasi, 45"
            ],
            [
                "name" => "Buxoroazot AJ",
                "person" => "Rahimov Islom",
                "phone" => "+99865 224-50-11",
                "location" => "Buxoro sh., Kimyogarlar shaharchasi"
            ],
            [
                "name" => "Buxoro shahar suv ta'minoti MChJ",
                "person" => "Xolmirzayev Shuxrat",
                "phone" => "+99865 223-15-55",
                "location" => "Buxoro sh., Navoiy koʻchasi, 12"
            ],
            [
                "name" => "Buxorodonteks korxonasi",
                "person" => "Karimova Dilfuza",
                "phone" => "+99865 226-30-40",
                "location" => "Buxoro sh., Buxoro-2 sanoat zonasi"
            ],
            [
                "name" => "Buxoro mebel MChJ",
                "person" => "Yusupov Farhod",
                "phone" => "+99865 227-11-22",
                "location" => "Buxoro sh., Istiqlol koʻchasi, 78"
            ],
            [
                "name" => "Buxoro yogʻ-moy kombinati",
                "person" => "Toʻrayev Bahodir",
                "phone" => "+99865 224-33-44",
                "location" => "Buxoro sh., Sanoat koʻchasi, 5"
            ],
            [
                "name" => "Buxoro qurilish materiallari korx.",
                "person" => "Joʻrayev Otabek",
                "phone" => "+99865 228-77-88",
                "location" => "Buxoro sh., Quruvchilar koʻchasi, 30"
            ],
            [
                "name" => "Buxoro agroservis MChJ",
                "person" => "Qodirov Zafar",
                "phone" => "+99865 229-90-90",
                "location" => "Buxoro sh., Yangiobod koʻchasi, 15"
            ],
            [
                "name" => "Buxoro elektromarkaz",
                "person" => "Toshmatov Rustam",
                "phone" => "+99865 223-45-67",
                "location" => "Buxoro sh., Temiryoʻlchilar koʻchasi, 10"
            ],
            [
                "name" => "Buxoro avtotrans korxonasi",
                "person" => "Nazarov Shuhrat",
                "phone" => "+99865 226-55-66",
                "location" => "Buxoro sh., Temiryoʻl koʻchasi, 25"
            ],
            [
                "name" => "Buxoro issiqlik elektr stansiyasi",
                "person" => "Xamidov Alisher",
                "phone" => "+99865 222-12-34",
                "location" => "Buxoro sh., Energiya koʻchasi, 7"
            ],
            [
                "name" => "Buxoro paxta tozalash zavodi",
                "person" => "Eshonqulov Jamol",
                "phone" => "+99865 227-88-99",
                "location" => "Buxoro sh., Paxtakor koʻchasi, 18"
            ],
            [
                "name" => "Buxoro sut kombinati",
                "person" => "Abdullayeva Malika",
                "phone" => "+99865 225-67-89",
                "location" => "Buxoro sh., Bogʻishamol koʻchasi, 33"
            ],
            [
                "name" => "Buxoro shahar tibbiyot markazi",
                "person" => "Turgʻunov Shavkat",
                "phone" => "+99865 224-78-90",
                "location" => "Buxoro sh., Tibbiyot koʻchasi, 50"
            ],
            [
                "name" => "Buxoro mehmonxona 'Orient Star'",
                "person" => "Ruziyev Farrux",
                "phone" => "+99865 221-11-22",
                "location" => "Buxoro sh., B. Naqshband koʻchasi, 5"
            ],
            [
                "name" => "Buxoro temir yoʻl stansiyasi",
                "person" => "Sobirov Aziz",
                "phone" => "+99865 220-55-66",
                "location" => "Buxoro sh., Temiryoʻl koʻchasi, 1"
            ],
            [
                "name" => "Buxoro universiteti",
                "person" => "Qurbonov Prof. Akmal",
                "phone" => "+99865 223-33-44",
                "location" => "Buxoro sh., M. Ulugʻbek koʻchasi, 11"
            ],
            [
                "name" => "Buxoro telekom MChJ",
                "person" => "Zoirov Bahrom",
                "phone" => "+99865 229-12-34",
                "location" => "Buxoro sh., Alisher Navoiy koʻchasi, 20"
            ],
            [
                "name" => "Buxoro qishloq xoʻjalik banki",
                "person" => "Xoʻjayeva Zarina",
                "phone" => "+99865 226-78-90",
                "location" => "Buxoro sh., I. Karimov koʻchasi, 15"
            ],
            [
                "name" => "Buxoro aviakompaniyasi",
                "person" => "Nizomov Javlon",
                "phone" => "+99865 227-55-66",
                "location" => "Buxoro xalqaro aeroporti yonida"
            ],
            [
                "name" => "Buxoro hunarmandchilik markazi",
                "person" => "Qodirova Malika",
                "phone" => "+99865 228-12-34",
                "location" => "Buxoro sh., B. Naqshband koʻchasi, 30"
            ],
            [
                "name" => "Buxoro shahar kommunal xizmatlar MChJ",
                "person" => "Ismoilov Sherzod",
                "phone" => "+99865 224-56-78",
                "location" => "Buxoro sh., Yangi hayot koʻchasi, 10"
            ],
            [
                "name" => "Buxoro qurilish trusti",
                "person" => "Xasanov Bobur",
                "phone" => "+99865 227-34-56",
                "location" => "Buxoro sh., Bunyodkor koʻchasi, 25"
            ],
            [
                "name" => "Buxoro agrokimyo korxonasi",
                "person" => "Toshpoʻlatov Bekzod",
                "phone" => "+99865 229-67-89",
                "location" => "Buxoro sh., Kimyogar shaharchasi"
            ],
            [
                "name" => "Buxoro neft mahsulotlari zavodi",
                "person" => "Karimov Shodmon",
                "phone" => "+99865 225-89-90",
                "location" => "Buxoro sh., Neftchilar koʻchasi, 7"
            ],
            [
                "name" => "Buxoro gʻisht zavodi",
                "person" => "Rahimberdiyev Jamshid",
                "phone" => "+99865 226-12-34",
                "location" => "Buxoro sh., Gʻishtsozlar koʻchasi, 12"
            ],
            [
                "name" => "Buxoro mebel kombinati",
                "person" => "Yusupova Gulnoza",
                "phone" => "+99865 228-90-12",
                "location" => "Buxoro sh., Mebelchilar koʻchasi, 8"
            ],
            [
                "name" => "Buxoro elektrotexnika zavodi",
                "person" => "Xolboyev Olim",
                "phone" => "+99865 223-78-90",
                "location" => "Buxoro sh., Elektronika koʻchasi, 15"
            ],
            [
                "name" => "Buxoro shahar atrof-muhit inspektsiyasi",
                "person" => "Nazirova Dilbar",
                "phone" => "+99865 221-34-56",
                "location" => "Buxoro sh., Ekologiya koʻchasi, 5"
            ],
            [
                "name" => "Buxoro avtoulov markazi",
                "person" => "Qodirov Sardor",
                "phone" => "+99865 227-90-12",
                "location" => "Buxoro sh., Avtomobilchilar koʻchasi, 20"
            ],
            [
                "name" => "Buxoro qishloq xoʻjalik texnikasi MChJ",
                "person" => "Toʻxtayev Farrux",
                "phone" => "+99865 224-90-12",
                "location" => "Buxoro sh., Traktorchilar koʻchasi, 9"
            ],
            [
                "name" => "Buxoro plastmassa zavodi",
                "person" => "Mirzayev Shavkat",
                "phone" => "+99865 229-34-56",
                "location" => "Buxoro sh., Polimer koʻchasi, 14"
            ],
            [
                "name" => "Buxoro shahar yoshlar ishlari markazi",
                "person" => "Otaboyeva Nigora",
                "phone" => "+99865 226-78-90",
                "location" => "Buxoro sh., Yoshlik koʻchasi, 3"
            ],
            [
                "name" => "Buxoro gilam fabrikasi",
                "person" => "Xakimova Zulfiya",
                "phone" => "+99865 225-34-56",
                "location" => "Buxoro sh., Hunarmand koʻchasi, 22"
            ],
            [
                "name" => "Buxoro shahar savdo boʻlimi",
                "person" => "Joʻraboyev Ilhom",
                "phone" => "+99865 223-90-12",
                "location" => "Buxoro sh., Savdo koʻchasi, 17"
            ],
            [
                "name" => "Buxoro qurilish loyihalari instituti",
                "person" => "Abdullayev Prof. Rustam",
                "phone" => "+99865 228-34-56",
                "location" => "Buxoro sh., Arxitektorlar koʻchasi, 11"
            ],
            [
                "name" => "Buxoro shahar transport boshqarmasi",
                "person" => "Xudoyberdiyev Aziz",
                "phone" => "+99865 221-78-90",
                "location" => "Buxoro sh., Transportchilar koʻchasi, 7"
            ],
            [
                "name" => "Buxoro konchilik korxonasi",
                "person" => "Tursunov Bahrom",
                "phone" => "+99865 227-12-34",
                "location" => "Buxoro sh., Konchilar koʻchasi, 5"
            ],
            [
                "name" => "Buxoro shahar energetika inspektsiyasi",
                "person" => "Zokirov Alisher",
                "phone" => "+99865 224-78-90",
                "location" => "Buxoro sh., Energiya koʻchasi, 13"
            ],
            [
                "name" => "Buxoro meva-sabzavot kombinati",
                "person" => "Eshonqulova Malika",
                "phone" => "+99865 229-78-90",
                "location" => "Buxoro sh., Bogʻdorchilik koʻchasi, 8"
            ],
            [
                "name" => "Buxoro shahar statistika boshqarmasi",
                "person" => "Qurbonova Dilafruz",
                "phone" => "+99865 226-34-56",
                "location" => "Buxoro sh., Statistika koʻchasi, 4"
            ],
            [
                "name" => "Buxoro temir-beton buyumlari zavodi",
                "person" => "Raxmonov Shuxrat",
                "phone" => "+99865 225-78-90",
                "location" => "Buxoro sh., Betonchilar koʻchasi, 19"
            ],
            [
                "name" => "Buxoro shahar madaniyat saroyi",
                "person" => "Xolmatova Sevara",
                "phone" => "+99865 223-12-34",
                "location" => "Buxoro sh., Madaniyat koʻchasi, 10"
            ],
            [
                "name" => "Buxoro shahar yuridik xizmatlar markazi",
                "person" => "Fayzullayev Jamol",
                "phone" => "+99865 228-78-90",
                "location" => "Buxoro sh., Adliya koʻchasi, 6"
            ],
            [
                "name" => "Buxoro qishloq suv xoʻjaligi MChJ",
                "person" => "Yoʻldoshev Anvar",
                "phone" => "+99865 221-90-12",
                "location" => "Buxoro sh., Suv xoʻjaligi koʻchasi, 12"
            ],
            [
                "name" => "Buxoro shahar mehnat inspektsiyasi",
                "person" => "Qodirov Shodmon",
                "phone" => "+99865 227-34-56",
                "location" => "Buxoro sh., Mehnat koʻchasi, 9"
            ],
            [
                "name" => "Buxoro shahar qurilish banki",
                "person" => "Xamidova Lola",
                "phone" => "+99865 224-12-34",
                "location" => "Buxoro sh., Bank koʻchasi, 3"
            ],
            [
                "name" => "Buxoro shahar sport majmuasi",
                "person" => "Nurmatov Javlon",
                "phone" => "+99865 229-12-34",
                "location" => "Buxoro sh., Sport koʻchasi, 15"
            ],
            [
                "name" => "Buxoro shahar oziq-ovqat kombinati",
                "person" => "Toshpoʻlatova Zebo",
                "phone" => "+99865 226-90-12",
                "location" => "Buxoro sh., Oziq-ovqat koʻchasi, 7"
            ],
            [
                "name" => "Buxoro shahar telekommunikatsiya uzeli",
                "person" => "Zokirov Farhod",
                "phone" => "+99865 225-12-34",
                "location" => "Buxoro sh., Aloqa koʻchasi, 11"
            ]
        ];

        foreach ($data as $item) {
            Enterprise::create($item);
        }

//        Enterprise::create([
//            'name' => 'Tech Innovators Inc.',
//            'description' => 'A leading company in technology solutions and innovations.',
//            'location' => 'Silicon Valley, CA'
//        ]);
//
//        Enterprise::create([
//            'name' => 'Buxdu.',
//            'description' => 'A leading company in technology solutions and innovations.',
//            'location' => 'Bukhara, Uzbekistan'
//        ]);
    }
}
