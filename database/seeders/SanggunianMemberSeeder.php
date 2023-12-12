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
            ['lastname' => 'Dumagan, Jr.', 'fullname' => 'Hon. Jose Dumagan Jr.', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Montesclaros', 'fullname' => 'Hon. Valerio T. Montesclaros Jr.', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Salazar', 'fullname' => 'Hon. Raul K. Salazar', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Azarcon', 'fullname' => 'Hon. Antonio C. Azarcon', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Sayawan', 'fullname' => 'Hon. Gines Ricky J. Sayawan Sr.', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Cejoco', 'fullname' => 'Hon. Conrad C. Cejoco', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Layno, Jr.', 'fullname' => 'Hon. Amado M. Layno Jr.', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Momo', 'fullname' => 'Hon. Ruel D. Momo', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Pimentel', 'fullname' => 'Hon. John Paul C. Pimentel', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Guno', 'fullname' => 'Hon. Melanie Joy M. Guno', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Arrezza', 'fullname' => 'Hon. Charles P. Arreza', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Guinsod', 'fullname' => 'Hon. Jimmy I. Guinsod', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Garay', 'fullname' => 'Hon. Margarita G. Garay', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Alameda Sr.', 'fullname' => 'Hon. Manuel O. Alameda Sr.', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Cañedo', 'fullname' => 'Hon. Anthony Joseph P. Cañedo', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Bacolod', 'fullname' => 'Hon. Ana Marie A. Bacolod', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Racaza, Jr', 'fullname' => 'Hon. Alfredo V. Racaza Jr.', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Villalba, Jr.', 'fullname' => 'Hon. Timoteo G. Villalba Jr.', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Joyce', 'fullname' => 'Hon. Jason John A. Joyce', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Lomosco', 'fullname' => 'Hon. Nerissa A. Lomosco', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Fortunado', 'fullname' => 'Hon. Neil Angelo C. Fortunado', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Gonzales', 'fullname' => 'Hon. Michael Angelo D. Gonzales', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Alfaro', 'fullname' => 'Hon. Peter Angelo C. Alfaro', 'district' => '-', 'sanggunian' => '19'],
            ['lastname' => 'Eguia', 'fullname' => 'Hon. Erwin C. Eguia', 'district' => '-', 'sanggunian' => '19'],
        ];

        foreach ($data as $member) {
            SanggunianMember::create($member);
        }
    }
}
