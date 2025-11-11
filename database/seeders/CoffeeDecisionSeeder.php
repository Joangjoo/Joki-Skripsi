<?php

// database/seeders/CoffeeDecisionSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criteria;
use App\Models\SubCriteria;
use App\Models\CoffeeAlternative;
use App\Models\Evaluation;

class CoffeeDecisionSeeder extends Seeder
{
    public function run()
    {
        // Buat Kriteria
        $criteria = [
            [
                'code' => 'C1',
                'name' => 'Harga',
                'weight' => 0.25,
                'type' => 'cost',
                'sub_criteria' => [
                    ['name' => 'Sangat Murah', 'value' => 1],
                    ['name' => 'Murah', 'value' => 2],
                    ['name' => 'Sedang', 'value' => 3],
                    ['name' => 'Mahal', 'value' => 4],
                    ['name' => 'Sangat Mahal', 'value' => 5],
                ]
            ],
            [
                'code' => 'C2',
                'name' => 'Aroma',
                'weight' => 0.20,
                'type' => 'benefit',
                'sub_criteria' => [
                    ['name' => 'Sangat Lemah', 'value' => 1],
                    ['name' => 'Lemah', 'value' => 2],
                    ['name' => 'Sedang', 'value' => 3],
                    ['name' => 'Kuat', 'value' => 4],
                    ['name' => 'Sangat Kuat', 'value' => 5],
                ]
            ],
            [
                'code' => 'C3',
                'name' => 'Rasa',
                'weight' => 0.30,
                'type' => 'benefit',
                'sub_criteria' => [
                    ['name' => 'Sangat Pahit', 'value' => 1],
                    ['name' => 'Pahit', 'value' => 2],
                    ['name' => 'Seimbang', 'value' => 3],
                    ['name' => 'Manis', 'value' => 4],
                    ['name' => 'Sangat Manis', 'value' => 5],
                ]
            ],
            [
                'code' => 'C4',
                'name' => 'Keasaman',
                'weight' => 0.15,
                'type' => 'benefit',
                'sub_criteria' => [
                    ['name' => 'Sangat Rendah', 'value' => 1],
                    ['name' => 'Rendah', 'value' => 2],
                    ['name' => 'Sedang', 'value' => 3],
                    ['name' => 'Tinggi', 'value' => 4],
                    ['name' => 'Sangat Tinggi', 'value' => 5],
                ]
            ],
            [
                'code' => 'C5',
                'name' => 'Body (Kekentalan)',
                'weight' => 0.10,
                'type' => 'benefit',
                'sub_criteria' => [
                    ['name' => 'Sangat Ringan', 'value' => 1],
                    ['name' => 'Ringan', 'value' => 2],
                    ['name' => 'Medium', 'value' => 3],
                    ['name' => 'Tebal', 'value' => 4],
                    ['name' => 'Sangat Tebal', 'value' => 5],
                ]
            ],
        ];

        foreach ($criteria as $c) {
            $criterion = Criteria::create([
                'code' => $c['code'],
                'name' => $c['name'],
                'weight' => $c['weight'],
                'type' => $c['type'],
            ]);

            foreach ($c['sub_criteria'] as $sub) {
                SubCriteria::create([
                    'criteria_id' => $criterion->id,
                    'name' => $sub['name'],
                    'value' => $sub['value'],
                ]);
            }
        }

        // Buat Alternatif Biji Kopi
        $coffees = [
            [
                'name' => 'Arabica Gayo',
                'description' => 'Kopi premium dari Aceh dengan cita rasa khas dan aroma yang kuat'
            ],
            [
                'name' => 'Arabica Toraja',
                'description' => 'Kopi dari Sulawesi dengan karakter earthy dan body yang tebal'
            ],
            [
                'name' => 'Robusta Lampung',
                'description' => 'Kopi robusta dengan kafein tinggi dan harga terjangkau'
            ],
            [
                'name' => 'Arabica Kintamani',
                'description' => 'Kopi Bali dengan keasaman yang tinggi dan rasa citrus'
            ],
            [
                'name' => 'Luwak Coffee',
                'description' => 'Kopi premium hasil fermentasi alami dengan harga tinggi'
            ],
        ];

        foreach ($coffees as $coffee) {
            CoffeeAlternative::create($coffee);
        }

        // Sample Evaluasi (opsional - bisa dikomentari jika ingin input manual)
        $evaluations = [
            // Arabica Gayo
            ['coffee_id' => 1, 'criteria_id' => 1, 'sub_id' => 4],  // Harga: Mahal
            ['coffee_id' => 1, 'criteria_id' => 2, 'sub_id' => 10], // Aroma: Sangat Kuat
            ['coffee_id' => 1, 'criteria_id' => 3, 'sub_id' => 14], // Rasa: Manis
            ['coffee_id' => 1, 'criteria_id' => 4, 'sub_id' => 18], // Keasaman: Sedang
            ['coffee_id' => 1, 'criteria_id' => 5, 'sub_id' => 23], // Body: Medium
            
            // Arabica Toraja
            ['coffee_id' => 2, 'criteria_id' => 1, 'sub_id' => 4],  // Harga: Mahal
            ['coffee_id' => 2, 'criteria_id' => 2, 'sub_id' => 9],  // Aroma: Kuat
            ['coffee_id' => 2, 'criteria_id' => 3, 'sub_id' => 13], // Rasa: Seimbang
            ['coffee_id' => 2, 'criteria_id' => 4, 'sub_id' => 17], // Keasaman: Rendah
            ['coffee_id' => 2, 'criteria_id' => 5, 'sub_id' => 24], // Body: Tebal
            
            // Robusta Lampung
            ['coffee_id' => 3, 'criteria_id' => 1, 'sub_id' => 2],  // Harga: Murah
            ['coffee_id' => 3, 'criteria_id' => 2, 'sub_id' => 8],  // Aroma: Sedang
            ['coffee_id' => 3, 'criteria_id' => 3, 'sub_id' => 12], // Rasa: Pahit
            ['coffee_id' => 3, 'criteria_id' => 4, 'sub_id' => 16], // Keasaman: Sangat Rendah
            ['coffee_id' => 3, 'criteria_id' => 5, 'sub_id' => 24], // Body: Tebal
            
            // Arabica Kintamani
            ['coffee_id' => 4, 'criteria_id' => 1, 'sub_id' => 3],  // Harga: Sedang
            ['coffee_id' => 4, 'criteria_id' => 2, 'sub_id' => 9],  // Aroma: Kuat
            ['coffee_id' => 4, 'criteria_id' => 3, 'sub_id' => 14], // Rasa: Manis
            ['coffee_id' => 4, 'criteria_id' => 4, 'sub_id' => 20], // Keasaman: Sangat Tinggi
            ['coffee_id' => 4, 'criteria_id' => 5, 'sub_id' => 22], // Body: Ringan
            
            // Luwak Coffee
            ['coffee_id' => 5, 'criteria_id' => 1, 'sub_id' => 5],  // Harga: Sangat Mahal
            ['coffee_id' => 5, 'criteria_id' => 2, 'sub_id' => 10], // Aroma: Sangat Kuat
            ['coffee_id' => 5, 'criteria_id' => 3, 'sub_id' => 15], // Rasa: Sangat Manis
            ['coffee_id' => 5, 'criteria_id' => 4, 'sub_id' => 18], // Keasaman: Sedang
            ['coffee_id' => 5, 'criteria_id' => 5, 'sub_id' => 23], // Body: Medium
        ];

        foreach ($evaluations as $eval) {
            Evaluation::create([
                'coffee_alternative_id' => $eval['coffee_id'],
                'criteria_id' => $eval['criteria_id'],
                'sub_criteria_id' => $eval['sub_id'],
            ]);
        }
    }
}

