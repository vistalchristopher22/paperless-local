<?php

namespace Database\Seeders;

use App\Models\SanggunianMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SanggunianMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ["fullname" => "Hon. Jose Dumagan, Jr.", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Valerio T. Montesclaros, Jr.", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Raul K. Salazar", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Antonio C. Azarcon", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Gines Ricky J. Sayawan, Sr.", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Conrad C. Cejoco", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Amado M. Layno, Jr.", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Ruel D. Momo", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. John Paul C. Pimentel", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Melanie Joy M. Guno", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Charles P. Arreza", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Jimmy I. Guinsod", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Ruel D. Momo", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Margarita G. Garay", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Manuel O. Alameda, Sr.", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Anthony Joseph P. Cañedo", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Ana Marie A. Bacolod", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Alfredo V. Racaza, Jr.", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Timoteo G. Villalba, Jr.", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Jason John A. Joyce", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Nerissa A. Lomosco", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Neil Angelo C. Fortunado", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Michael Angelo D. Gonzales", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Peter Angelo C. Alfaro", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
            ["fullname" => "Hon. Erwin C. Eguia", "district" => "-", "sanggunian" => "19th Sangguniang Panlalawigan Member"],
        ];

        foreach ($data as $member) {
            SanggunianMember::create($member);
        }
    }
}
