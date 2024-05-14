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
            ['lastname' => 'Dumagan, Jr.', 'fullname' => 'Hon. Jose Dumagan Jr.', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Montesclaros', 'fullname' => 'Hon. Valerio T. Montesclaros Jr.', 'district' => '2', 'sanggunian' => '19'],
            ['lastname' => 'Salazar', 'fullname' => 'Hon. Raul K. Salazar', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Azarcon', 'fullname' => 'Hon. Antonio C. Azarcon', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Sayawan', 'fullname' => 'Hon. Gines Ricky J. Sayawan Sr.', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Cejoco', 'fullname' => 'Hon. Conrad C. Cejoco', 'district' => '2', 'sanggunian' => '19'],
            ['lastname' => 'Layno, Jr.', 'fullname' => 'Hon. Amado M. Layno Jr.', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Momo', 'fullname' => 'Hon. Ruel D. Momo', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Pimentel', 'fullname' => 'Hon. John Paul C. Pimentel', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Guno', 'fullname' => 'Hon. Melanie Joy M. Guno', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Sanchez', 'fullname' => 'Hon. Yuri Art Eufy  R. Sanchez', 'district' => '2', 'sanggunian' => '19'],
            ['lastname' => 'Guinsod', 'fullname' => 'Hon. Jimmy I. Guinsod', 'district' => '1', 'sanggunian' => '19'],
            ['lastname' => 'Garay', 'fullname' => 'Hon. Margarita G. Garay', 'district' => '2', 'sanggunian' => '19'],
            ['lastname' => 'Alameda Sr.', 'fullname' => 'Hon. Manuel O. Alameda Sr.', 'district' => '2', 'sanggunian' => '19'],
            ['lastname' => 'Cañedo', 'fullname' => 'Hon. Anthony Joseph P. Cañedo', 'district' => '1', 'sanggunian' => '19'],
        ];

        foreach ($data as $index => $member) {
            $member['unique_id'] = $index + 1;
            SanggunianMember::create($member);
        }
    }
}
