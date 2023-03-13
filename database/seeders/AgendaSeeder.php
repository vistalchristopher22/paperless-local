<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;
use App\Models\SanggunianMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "title" => "Committee on Agriculture/Fisheries",
                "chairman" => "Hon. Valerio T. Montesclaros, Jr.",
                "vice_chairman" => "Hon. Raul K. Salazar",
                "members" => "Hon. Jose Dumagan, Jr.",
                "Hon. Conrad C. Cejoco",
                "Hon. Amado M. Layno, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],

            [
                "title" => "Committee on Barangay Affairs",
                "chairman" => "Hon. Melanie Joy M. Guno",
                "vice_chairman" => "Hon. Raul K. Salazar",
                "members" => "Hon. Charles P. Arezza",
                "Hon. Jimmy I. Guinsod",
                "Hon. Manuel O. Alameda, Sr.",
                "Hon. Margarita G. Garay",
            ],

            [
                "title" => "Committee on Boundary Settlement",
                "chairman" => "Hon. Antonio C. Azarcon",
                "vice_chairman" => "Hon. Conrad C. Cejoco",
                "members" => "Hon. Jimmy I. Guinsod",
                "Hon. Jose Dumagan, Jr.",
                "Hon. Gines Ricky J. Sayawan, Sr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Cooperatives and Livelihood",
                "chairman" => "Hon. Raul K. Salazar",
                "vice_chairman" => "Hon. Valerio T. Montesclaros, Jr.",
                "members" => "Hon. Anthony Joseph P. Cañedo",
                "Hon. Gines Ricky J. Sayawan, Sr.",
                "Hon. Jimmy I. Guinsod",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Education",
                "chairman" => "Hon. Conrad C. Cejoco",
                "vice_chairman" => "Hon. Amado M. Layno, Jr. ",
                "members" => "Hon. Charles P. Arezza",
                "Hon. John Paul C. Pimentel",
                "Hon. Jimmy I. Guinsod",
                "Hon. Anthony Joseph P. Cañedo",
                "Hon. Manuel O. Alameda, Sr.",
            ],

            [
                "title" => "Committee on Finance and Appropriation",
                "chairman" => "Hon. Gines Ricky J. Sayawan, Sr.",
                "vice_chairman" => "Hon. Antonio C. Azarcon",
                "members" => "Hon. Ruel D. Momo",
                "Hon. Jose Dumagan, Jr.",
                "Hon. Anthony Joseph P. Cañedo",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" =>
                "Committee on Good Government, Public Ethics and Accountability (Blue Ribbon Committee)",
                "chairman" => "Hon. Antonio C. Azarcon",
                "vice_chairman" => "Hon. Gines Ricky J. Sayawan, Sr.",
                "members" => "Hon. Margarita G. Garay",
                "Hon. John Paul C. Pimentel",
                "Hon. Amado M. Layno, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Environmental Protection and Ecology",
                "chairman" => "Hon. Jose Dumagan, Jr.",
                "vice_chairman" => "Hon. Anthony Joseph P. Cañedo",
                "members" => "Hon. Ruel D. Momo",
                "Hon. Valerio T. Montesclaros, Jr.",
                "Hon. Raul K. Salazar",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Health and Sanitation",
                "chairman" => "Hon. Amado M. Layno, Jr.",
                "vice_chairman" => "Hon. John Paul C. Pimentel",
                "members" => "Hon. Margarita G. Garay",
                "Hon. Conrad C. Cejoco",
                "Hon. Valerio T. Montesclaros, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Indigenous Peoples",
                "chairman" => "Hon. Jimmy I. Guinsod",
                "vice_chairman" => "Hon. Jose Dumagan, Jr.",
                "members" => "Hon. Manuel O. Alameda, Sr.",
                "Hon. Raul K. Salazar",
                "Hon. Amado M. Layno, Jr.",
                "Hon. Charles P. Arreza",
            ],
            [
                "title" => "Committee on Labor and Government Employment",
                "chairman" => "Hon. Gines Ricky J. Sayawan, Sr.",
                "vice_chairman" => "Hon. Antonio C. Azarcon",
                "members" => "Hon. Anthony Joseph P. Cañedo",
                "Hon. John Paul C. Pimentel",
                "Hon. Valerio T. Montesclaros, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Laws and Justice and Human Rights",
                "chairman" => "Hon. Antonio C. Azarcon",
                "vice_chairman" => "Hon. Conrad C. Cejoco",
                "members" => "Hon. Gines Ricky J. Sayawan, Sr.",
                "Hon. Jose Dumagan, Jr.",
                "Hon. Raul K. Salazar",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Legislative Oversight Committee",
                "chairman" => "Hon. Manuel O. Alameda, Sr.",
                "vice_chairman" => "Hon. Jose Dumagan, Jr.",
                "Hon. Conrad C. Cejoco",
                "Hon. Antonio C. Azarcon",
                "Hon. John Paul C. Pimentel",
                "Hon. Gines Ricky J. Sayawan, Sr.",
            ],
            [
                "title" =>
                "Committee on Peace and Order, Public Safety and Anti-Illegal Drugs",
                "chairman" => "Hon. Ruel D. Momo",
                "vice_chairman" => "Hon. Raul K. Salazar",
                "members" => "Hon. Charles P. Arreza",
                "Hon. Manuel O. Alameda, Sr.",
                "Hon. John Paul C. Pimentel",
                "Hon. Valerio T. Montesclaros, Jr.",
            ],
            [
                "title" => "Committee on Public Works and Infrastructure",
                "chairman" => "Hon. Ruel D. Momo",
                "vice_chairman" => "Hon. Conrad C. Cejoco",
                "members" => "Hon. John Paul C. Pimentel",
                "Hon. Jose Dumagan, Jr.",
                "Hon. Valerio T. Montesclaros, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Rules, Privileges and Ethics",
                "chairman" => "Hon. Jose Dumagan, Jr.",
                "vice_chairman" => "Hon. Gines Ricky J. Sayawan, Sr.",
                "Hon. Conrad C. Cejoco",
                "Hon. Ruel D. Momo",
                "Hon. Amado M. Layno, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" =>
                "Committee on Differently Abled or Persons with Disabilities and Senior Citizens, and Social Services and Community Development",
                "chairman" => "Hon. Amado M. Layno, Jr.",
                "vice_chairman" => "Hon. Ruel D. Momo",
                "members" => "Hon. Margarita G. Garay",
                "Hon. Jimmy I. Guinsod",
                "Hon. Gines Ricky J. Sayawan, Sr. ",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" => "Committee on Transportation, Traffic, Ports and Terminal",
                "chairman" => "Hon. Conrad C. Cejoco",
                "vice_chairman" => "Hon. Margarita G. Garay ",
                "members" => "Hon. Manuel O. Alameda, Sr.",
                "Hon. Ruel D. Momo",
                "Hon. Jose Dumagan, Jr.",
                "Hon. Anthony Joseph P. Cañedo",
            ],

            [
                "title" => "Committee on Tourism, Culture, Arts and Heritage",
                "chairman" => "Hon. Jose Dumagan, Jr.",
                "vice_chairman" => "Hon. Anthony Joseph P. Cañedo",
                "members" => "Hon. Ruel D. Momo",
                "Hon. Margarita G. Garay",
                "Hon. Amado M. Layno, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],
            [
                "title" =>
                "Committee on Trade, Industry, Investment and SMES/ Local Economic Enterprises and Utilities",
                "chairman" => "Hon. Valerio T. Montesclaros, Jr.",
                "vice_chairman" => "Hon. Margarita G. Garay",
                "members" => "Hon. Ruel D. Momo",
                "Hon. Jose Dumagan, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
                "Hon. Anthony Joseph P. Cañedo",
            ],
            [
                "title" => "Committee on Urban Planning and Development",
                "chairman" => "Hon. Gines Ricky J. Sayawan, Sr.",
                "vice_chairman" => "Hon. Ruel D. Momo",
                "members" => "Hon. Conrad C. Cejoco",
                "Hon. Melanie Joy M. Guno",
                "Hon. Jose Dumagan, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],

            [
                "title" => "Committee on Youth",
                "chairman" => "Hon. Charles P. Arreza",
                "vice_chairman" => "Hon. Anthony Joseph P. Cañedo",
                "members" => "Hon. Manuel O. Alameda, Sr.",
                "Hon. Gines Ricky J. Sayawan, Sr.",
                "Hon. Ruel D. Momo",
                "Hon. John Paul C. Pimentel",
            ],
            [
                "title" => "Committee on Ways and Means and Taxation",
                "chairman" => "Hon. Manuel O. Alameda, Sr.",
                "vice_chairman" => "Hon. Gines Ricky J. Sayawan, Sr. ",
                "members" => "Hon. Valerio T. Montesclaros, Jr.",
                "Hon. Margarita G. Garay",
                "Hon. Jose Dumagan, Jr.",
                "Hon. Anthony Joseph P. Cañedo",
            ],
            [
                "title" => "Committee on Women, Children and Family Relations",
                "chairman" => "Hon. Margarita G. Garay",
                "vice_chairman" => "Hon. Melanie Joy M. Guno",
                "members" => "Hon. Ruel D. Momo",
                "Hon. Anthony Joseph P. Cañedo",
                "Hon. Charles P. Arreza",
                "Hon. Manuel O. Alameda, Sr.",
                "Hon. Jose Dumagan, Jr.",
            ],

            [
                "title" =>
                "Committee on Disaster Risk Reduction and Climate Change Adaptation",
                "chairman" => "Hon. Manuel O. Alameda, Sr.",
                "vice_chairman" => "Hon. Amado M. Layno, Jr.",
                "members" => "Hon. Jose Dumagan, Jr.",
                "Hon. Jimmy 1. Guinsod",
                "Hon. Melanie Joy M. Guno",
                "Hon. Raul K. Salazar",
            ],

            [
                "title" => "Committee on Sports, Games and Amusement",
                "chairman" => "Hon. Anthony Joseph P. Cañedo",
                "vice_chairman" => "Hon. Charles P. Arreza",
                "members" => "Hon. Manuel O. Alameda, Sr.",
                "Hon. John Paul C. Pimentel",
                "Hon. Raul K. Salazar",
                "Hon. Antonio C. Azarcon",
            ],

            [
                "title" => "Committee on Sports, Games and Amusement",
                "chairman" => "Hon. Anthony Joseph P. Cañedo",
                "vice_chairman" => "Hon. Charles P. Arreza",
                "members" => "Hon. Manuel O. Alameda, Sr.",
                "Hon. John Paul C. Pimentel",
                "Hon. Raul K. Salazar",
                "Hon. Antonio C. Azarcon",
            ],
            [
                "title" => "Committee on Energy and Power",
                "chairman" => "Hon. John Paul C. Pimentel",
                "vice_chairman" => "Hon. Conrad C. Cejoco",
                "members" => "Hon. Jose Dumagan, Jr.",
                "Hon. Raul K. Salazar",
                "Hon. Amado M. Layno, Jr.",
                "Hon. Manuel O. Alameda, Sr.",
            ],

            [
                "title" => "Committee on Information, Technology and Communication",
                "chairman" => "Hon. Anthony Joseph P. Cañedo",
                "vice_chairman" => "Hon. John Paul C. Pimentel ",
                "members" => "Hon. Manuel O. Alameda, Sr.",
                "Hon. Ruel D. Momo",
                "Hon. Conrad C. Cejoco",
                "Hon. Raul K. Salazar",
            ],
            [
                "title" => "Committee on Inter Governmental Relations",
                "chairman" => "Hon. Conrad C. Cejoco",
                "vice_chairman" => "Hon. Antonio C. Azarcon",
                "members" => "Hon. Jimmy I. Guinsod",
                "Hon. Ruel D. Momo",
                "Hon. Melanie Joy M. Guno",
                "Hon. Manuel O. Alameda, Sr.",
            ]
        ];
        foreach ($data as $key => $agenda) {
            Agenda::create([
                'title' => $agenda['title'],
                'chairman' => SanggunianMember::where('fullname', $agenda['chairman'])->first()->id,
                'vice_chairman' => SanggunianMember::where('fullname', $agenda['vice_chairman'])->first()->id,
            ]);
        }
    }
}
