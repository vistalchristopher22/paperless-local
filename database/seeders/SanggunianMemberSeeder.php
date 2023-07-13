<?php

namespace Database\Seeders;

use App\Models\SanggunianMember;
use Illuminate\Database\Seeder;

class SanggunianMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['lastname' => 'Dumagan, Jr.', 'fullname' => 'Hon. Jose Dumagan Jr.', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Montesclaros', 'fullname' => 'Hon. Valerio T. Montesclaros Jr.', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Salazar', 'fullname' => 'Hon. Raul K. Salazar', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Azarcon', 'fullname' => 'Hon. Antonio C. Azarcon', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Sayawan', 'fullname' => 'Hon. Gines Ricky J. Sayawan Sr.', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Cejoco', 'fullname' => 'Hon. Conrad C. Cejoco', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Layno, Jr.', 'fullname' => 'Hon. Amado M. Layno Jr.', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Momo', 'fullname' => 'Hon. Ruel D. Momo', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Pimentel', 'fullname' => 'Hon. John Paul C. Pimentel', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Guno', 'fullname' => 'Hon. Melanie Joy M. Guno', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Arrezza', 'fullname' => 'Hon. Charles P. Arreza', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Guinsod', 'fullname' => 'Hon. Jimmy I. Guinsod', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Garay', 'fullname' => 'Hon. Margarita G. Garay', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Alameda Sr.', 'fullname' => 'Hon. Manuel O. Alameda Sr.', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Cañedo', 'fullname' => 'Hon. Anthony Joseph P. Cañedo', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Bacolod', 'fullname' => 'Hon. Ana Marie A. Bacolod', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Racaza, Jr', 'fullname' => 'Hon. Alfredo V. Racaza Jr.', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Villalba, Jr.', 'fullname' => 'Hon. Timoteo G. Villalba Jr.', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Joyce', 'fullname' => 'Hon. Jason John A. Joyce', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Lomosco', 'fullname' => 'Hon. Nerissa A. Lomosco', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Fortunado', 'fullname' => 'Hon. Neil Angelo C. Fortunado', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Gonzales', 'fullname' => 'Hon. Michael Angelo D. Gonzales', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Alfaro', 'fullname' => 'Hon. Peter Angelo C. Alfaro', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
            ['lastname' => 'Eguia', 'fullname' => 'Hon. Erwin C. Eguia', 'district' => '-', 'sanggunian' => '19th Sangguniang Panlalawigan Member'],
        ];

        foreach ($data as $member) {
            SanggunianMember::create($member);
        }
    }
}
