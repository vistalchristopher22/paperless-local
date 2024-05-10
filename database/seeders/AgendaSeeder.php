<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;
use App\Models\SanggunianMember;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [

                'title' => 'Committee on Agriculture/Fisheries',
                'chairman' => 2,
                'vice_chairman' => 3,
                'index' => 1,

            ],
            [

                'title' => 'Committee on Barangay Affairs',
                'chairman' => 10,
                'vice_chairman' => 3,
                'index' => 2,

            ],
            [

                'title' => 'Committee on Boundary Settlement',
                'chairman' => 4,
                'vice_chairman' => 6,
                'index' => 3,

                'updated_at' => '2023-03-16 12:14:02',
            ],
            [

                'title' => 'Committee on Cooperatives and Livelihood',
                'chairman' => 3,
                'vice_chairman' => 2,
                'index' => 4,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Education',
                'chairman' => 6,
                'vice_chairman' => 7,
                'index' => 5,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Finance and Appropriation',
                'chairman' => 5,
                'vice_chairman' => 4,
                'index' => 6,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Good Government, Public Ethics and Accountability (Blue Ribbon Committee)',
                'chairman' => 4,
                'vice_chairman' => 5,
                'index' => 7,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Environmental Protection and Ecology',
                'chairman' => 1,
                'vice_chairman' => 2,
                'index' => 8,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Health and Sanitation',
                'chairman' => 7,
                'vice_chairman' => 9,
                'index' => 9,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Indigenous Peoples',
                'chairman' => 12,
                'vice_chairman' => 1,
                'index' => 10,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Labor and Government Employment',
                'chairman' => 5,
                'vice_chairman' => 4,
                'index' => 11,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Laws and Justice and Human Rights',
                'chairman' => 4,
                'vice_chairman' => 6,
                'index' => 12,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Legislative Oversight Committee',
                'chairman' => 15,
                'vice_chairman' => 1,
                'index' => 13,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Peace and Order, Public Safety and Anti-Illegal Drugs',
                'chairman' => 8,
                'vice_chairman' => 3,
                'index' => 14,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Public Works and Infrastructure',
                'chairman' => 8,
                'vice_chairman' => 6,
                'index' => 15,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Rules, Privileges and Ethics',
                'chairman' => 1,
                'vice_chairman' => 5,
                'index' => 16,

                'updated_at' => '2023-03-15 09:13:38',
            ],
            [

                'title' => 'Committee on Differently Abled or Persons with Disabilities and Senior Citizens, and Social Services and Community Development',
                'chairman' => 7,
                'vice_chairman' => 8,
                'index' => 17,

                'updated_at' => '2023-03-20 03:33:51',
            ],
            [

                'title' => 'Committee on Transportation, Traffic, Ports and Terminal',
                'chairman' => 6,
                'vice_chairman' => 14,
                'index' => 18,

                'updated_at' => '2023-03-20 03:33:56',
            ],
            [

                'title' => 'Committee on Tourism, Culture, Arts and Heritage',
                'chairman' => 1,
                'vice_chairman' => 2,
                'index' => 19,

                'updated_at' => '2023-03-20 03:34:16',
            ],
            [

                'title' => 'Committee on Trade, Industry, Investment and SMES/ Local Economic Enterprises and Utilities',
                'chairman' => 2,
                'vice_chairman' => 14,
                'index' => 20,

                'updated_at' => '2023-03-20 03:39:02',
            ],
            [

                'title' => 'Committee on Urban Planning and Development',
                'chairman' => 5,
                'vice_chairman' => 8,
                'index' => 21,

                'updated_at' => '2023-03-20 03:39:27',
            ],
            [

                'title' => 'Committee on Youth',
                'chairman' => 11,
                'vice_chairman' => 2,
                'index' => 22,

                'updated_at' => '2023-03-20 03:39:27',
            ],
            [

                'title' => 'Committee on Ways and Means and Taxation',
                'chairman' => 15,
                'vice_chairman' => 5,
                'index' => 23,

                'updated_at' => '2023-03-20 03:39:28',
            ],
            [

                'title' => 'Committee on Women, Children and Family Relations',
                'chairman' => 14,
                'vice_chairman' => 10,
                'index' => 25,
                'updated_at' => '2023-03-20 05:30:49',
            ],
            [

                'title' => 'Committee on Disaster Risk Reduction and Climate Change Adaptation',
                'chairman' => 15,
                'vice_chairman' => 7,
                'index' => 24,
                'updated_at' => '2023-03-20 05:30:49',
            ],
            [

                'title' => 'Committee on Sports, Games and Amusement',
                'chairman' => 2,
                'vice_chairman' => 11,
                'index' => 26,
                'updated_at' => '2023-03-20 03:39:28',
            ],
            [

                'title' => 'Committee on Energy and Power',
                'chairman' => 9,
                'vice_chairman' => 6,
                'index' => 27,
                'updated_at' => '2023-03-20 03:42:08',
            ],
            [

                'title' => 'Committee on Information, Technology and Communication',
                'chairman' => 16,
                'vice_chairman' => 9,
                'index' => 28,
                'updated_at' => '2023-03-20 03:42:08',
            ],
            [

                'title' => 'Committee on Inter Governmental Relations',
                'chairman' => 6,
                'vice_chairman' => 4,
                'index' => 29,
                'updated_at' => '2023-03-20 03:32:18',
            ],
        ];

        foreach ($data as $key => $agenda) {
            $agenda['vice_chairman'] = SanggunianMember::inRandomOrder()->limit(1)->first()->id;
            $agenda['chairman'] = SanggunianMember::inRandomOrder()->limit(1)->first()->id;
            Agenda::create($agenda);
        }
    }
}
