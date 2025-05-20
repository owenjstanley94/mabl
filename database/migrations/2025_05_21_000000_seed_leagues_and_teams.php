<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add leagues
        $leagues = [
            'Premier',
            'Championship',
            'Division One',
            'Womens',
            'Cup',
        ];

        foreach ($leagues as $leagueName) {
            \App\Models\League::firstOrCreate(['name' => $leagueName]);
        }

        // Add Premier teams
        $premierLeague = \App\Models\League::where('name', 'Premier')->first();
        $teams = [
            [
                'name' => 'Burnley Blazers 1',
                'court' => 'Spirit of Sport, 20 Ormerod Road, Burnley. BB103AA',
                'tip_day' => 'Mon',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Cardinal Langley 1',
                'court' => 'Heywood Sports Village, W Starkey St, Heywood . OL104TW',
                'tip_day' => 'Thu',
                'tip_time' => '20:10pm',
            ],
            [
                'name' => 'Free City YMCA',
                'court' => 'The Y Club Castlefield Hotel, Liverpool Rd, Castlefield, Manchester. M34JR',
                'tip_day' => 'Thu',
                'tip_time' => '20:00pm',
            ],
            [
                'name' => 'Manchester Heat',
                'court' => 'NBPC, Kirkmanshulme Lane, Belle Vue. M124TF',
                'tip_day' => 'Wed',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Mavericks 1',
                'court' => 'Bury Grammar School, Tenterden St, Bury. BL90HH',
                'tip_day' => 'Fri',
                'tip_time' => '19:45pm',
            ],
            [
                'name' => 'Mavericks 2',
                'court' => 'Bury Grammar School, Tenterden St, Bury . BL90HH',
                'tip_day' => 'Tue',
                'tip_time' => '19:45pm',
            ],
            [
                'name' => 'Moss Side Tropics',
                'court' => 'Active Lifestyle, 120 Denmark Road, Manchester. M156FG',
                'tip_day' => 'Wed',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Myerscough College',
                'court' => 'Myescough College, St Michaels Road, Bilsborrow, Preston. PR30RY',
                'tip_day' => 'Tue',
                'tip_time' => '20:00pm',
            ],
            [
                'name' => 'St Helens',
                'court' => 'Carmel College, Prescot Road, St Helens. WA103AG',
                'tip_day' => 'Wed',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Trafford Giants 1',
                'court' => 'Hough End Centre, Mauldeth Road West, Manchester. M217SX',
                'tip_day' => 'Wed',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'YMCA',
                'court' => 'The Y Club, Castlefield Hotel, Liverpool Road, Manchester. M34JR',
                'tip_day' => 'Thu',
                'tip_time' => '20:00pm',
            ],
        ];
        foreach ($teams as $team) {
            \App\Models\Team::firstOrCreate([
                'name' => $team['name'],
                'league_id' => $premierLeague->id,
                'court' => $team['court'],
                'tip_day' => $team['tip_day'],
                'tip_time' => $team['tip_time'],
            ]);
        }

        // Add Championship teams
        $championshipLeague = \App\Models\League::where('name', 'Championship')->first();
        $championshipTeams = [
            [
                'name' => 'Belle Vue Bears',
                'court' => 'NBPC, Kirkmanshulme Lane, Belle Vue. M124TF',
                'tip_day' => 'Wed',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Canute',
                'court' => 'Manchester Enterprise Academy, Simonsway, Wythenshawe. M229RH',
                'tip_day' => 'Wed',
                'tip_time' => '20:00pm',
            ],
            [
                'name' => 'Cheshire Hornets 1',
                'court' => 'Reaseheath College, Rease Heath, Nantwich. CW56DF',
                'tip_day' => 'Wed',
                'tip_time' => '19:45pm',
            ],
            [
                'name' => 'North West A Nabbs',
                'court' => 'Phillips Sports Centre, Higher Lane, Whitefield, Manchester. M457PH',
                'tip_day' => 'Fri',
                'tip_time' => '20:30pm',
            ],
            [
                'name' => 'Preston Basketball Club 1',
                'court' => 'St. Augustines Leisure Centre, Avenham, Preston. PR13YJ',
                'tip_day' => 'Tue',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Preston Basketball Club 2',
                'court' => 'St. Augustines Leisure Centre, St Austins Place, Avenham, Preston. PR13YJ',
                'tip_day' => 'Mon',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Salford',
                'court' => 'All Hallows High School, Eccles Old Road, Salford. M68AA',
                'tip_day' => 'Thu',
                'tip_time' => '19:30pm',
            ],
            [
                'name' => 'Stockport Atlas',
                'court' => 'Hough End Police Club, Mauldeth Road. M217SX',
                'tip_day' => 'Fri',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Tameside Vikings 1',
                'court' => 'Astley Sports Village, Yew Tree Lane, Dukinfield. SK165BL',
                'tip_day' => 'Mon',
                'tip_time' => '20:20pm',
            ],
        ];
        foreach ($championshipTeams as $team) {
            \App\Models\Team::firstOrCreate([
                'name' => $team['name'],
                'league_id' => $championshipLeague->id,
                'court' => $team['court'],
                'tip_day' => $team['tip_day'],
                'tip_time' => $team['tip_time'],
            ]);
        }

        // Add Division One teams
        $divisionOneLeague = \App\Models\League::where('name', 'Division One')->first();
        $divisionOneTeams = [
            [
                'name' => '8ight5ive2wo',
                'court' => 'Droylsden Academy, Mannor Road, Droylsden, Manchester. M436QD',
                'tip_day' => 'Mon',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Cardinal Langley 2',
                'court' => 'Heywood Sports Village, W Starkey St, Heywood. OL104TW',
                'tip_day' => 'Thu',
                'tip_time' => '20:10pm',
            ],
            [
                'name' => 'Cheshire Hornets 2',
                'court' => 'Reaseheath College, Rease Heath, Nantwich. CW56DF',
                'tip_day' => 'Wed',
                'tip_time' => '19:45pm',
            ],
            [
                'name' => 'High Peak Steelers',
                'court' => 'Wright Robinson College, Abbey Hey Ln, Gorton. M188RL',
                'tip_day' => 'Mon',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Manchester Kings U23',
                'court' => 'EAST Manchester Academy, Grey Mare Lane, Manchester. M113DS',
                'tip_day' => 'Tue',
                'tip_time' => '19:30pm',
            ],
            [
                'name' => 'Mavericks 3',
                'court' => 'Bury Grammar School, Tenterden St, Bury . BL90HH',
                'tip_day' => 'Tue',
                'tip_time' => '19:45pm',
            ],
            [
                'name' => 'Northwich Basketball Club',
                'court' => 'The Winsford Academy Grange Lane Winsford. CW72BT',
                'tip_day' => 'Wed',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Preston Basketball Club 3',
                'court' => 'St. Augustines Leisure Centre, Avenham, Preston. PR13YJ',
                'tip_day' => 'Thu',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Tameside Vikings 2',
                'court' => 'Astley Sports Village, Yew Tree Lane, Dukinfield. SK165BL',
                'tip_day' => 'Mon',
                'tip_time' => '20:20pm',
            ],
        ];
        foreach ($divisionOneTeams as $team) {
            \App\Models\Team::firstOrCreate([
                'name' => $team['name'],
                'league_id' => $divisionOneLeague->id,
                'court' => $team['court'],
                'tip_day' => $team['tip_day'],
                'tip_time' => $team['tip_time'],
            ]);
        }

        // Add Womens teams
        $womensLeague = \App\Models\League::where('name', 'Womens')->first();
        $womensTeams = [
            [
                'name' => 'Cheshire Roar',
                'court' => 'Blacon High School, Chester. CH15JH',
                'tip_day' => 'Tue',
                'tip_time' => '19:30pm',
            ],
            [
                'name' => 'FBA Manchester',
                'court' => 'NBPC, Kirkmanshulme Lane, Manchester. M124TF',
                'tip_day' => 'Fri',
                'tip_time' => '19:30pm',
            ],
            [
                'name' => 'FBA Rockettes',
                'court' => 'NBPC, Kirkmanshulme Lane, Manchester. M124TF',
                'tip_day' => 'Fri',
                'tip_time' => '19:30pm',
            ],
            [
                'name' => 'Lancashire Spinners',
                'court' => 'Elton High School, Walshaw Road, Bury. BL81RN',
                'tip_day' => 'Tue',
                'tip_time' => '20:00pm',
            ],
            [
                'name' => 'Liverpool Basketball Club',
                'court' => 'St John Bosco Arts College, Storrington Avenue, Liverpool. L119DQ',
                'tip_day' => 'Thu',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Manchester Lynx',
                'court' => 'CHS South, 451 Mauldeth Road West, Chorlton. M217SX',
                'tip_day' => 'Fri',
                'tip_time' => '19:30pm',
            ],
            [
                'name' => 'Manchester Valkyries',
                'court' => 'East Manchester Academy, Grey Mare Lane, Manchester. M113DS',
                'tip_day' => 'Fri',
                'tip_time' => '19:30pm',
            ],
            [
                'name' => 'Rossendale Raptors',
                'court' => 'Nelson and Colne College. BB97YT',
                'tip_day' => 'Tue',
                'tip_time' => '20:15pm',
            ],
            [
                'name' => 'Stockport Lapwings',
                'court' => 'Stockport Sport For All Centre, Vale Road, Reddish, Stockport. SK57HD',
                'tip_day' => 'Fri',
                'tip_time' => '20:30pm',
            ],
            [
                'name' => 'Stockport Lapwings Green',
                'court' => 'Stockport Sport For All Centre, Vale Road, Reddish, Stockport. SK57HD',
                'tip_day' => 'Fri',
                'tip_time' => '20:30pm',
            ],
            [
                'name' => 'Tameside Wikings',
                'court' => 'Astley Sports Village, Yew Tree Lane, Dukinfield. . SK165BL',
                'tip_day' => 'Fri',
                'tip_time' => '20:30pm',
            ],
        ];
        foreach ($womensTeams as $team) {
            \App\Models\Team::firstOrCreate([
                'name' => $team['name'],
                'league_id' => $womensLeague->id,
                'court' => $team['court'],
                'tip_day' => $team['tip_day'],
                'tip_time' => $team['tip_time'],
            ]);
        }

        // Add Officials (Referees)
        $officials = [
            ['name' => 'Marcus Aghatabay', 'email' => 'mabasketball@outlook.com', 'licence_number' => null],
            ['name' => 'Nathaniel Aidoo', 'email' => 'Nataidoo2005@gmail.com', 'licence_number' => null],
            ['name' => 'Nathaniel Aidoo', 'email' => 'Nataidoo2005@gmail.com', 'licence_number' => null],
            ['name' => 'Luc Baldwin', 'email' => 'Markfbaldwin@hotmail.co.uk', 'licence_number' => null],
            ['name' => 'Ingus Bankevics', 'email' => 'inguciitis@inbox.lv', 'licence_number' => '000480'],
            ['name' => 'John Barker', 'email' => 'sparkybarker@hotmail.com', 'licence_number' => null],
            ['name' => 'Husein Ben Rabah', 'email' => 'benrabhahusein@yahoo.co.uk', 'licence_number' => null],
            ['name' => 'John Benstead', 'email' => 'johnbenstead257@hotmail.com', 'licence_number' => '000247'],
            ['name' => 'Jade Bow Butters', 'email' => 'jadebow5@gmail.com', 'licence_number' => null],
            ['name' => 'Mal Casson', 'email' => 'mrcasson@btinternet.com', 'licence_number' => null],
            ['name' => 'John Cihlar', 'email' => 'john.c@mabl.co.uk', 'licence_number' => '002708'],
            ['name' => 'Nathan Conaty', 'email' => 'nath.conaty13@gmail.com', 'licence_number' => null],
            ['name' => 'Alex Crowther', 'email' => 'alex.crowther13@gmail.com', 'licence_number' => null],
            ['name' => 'Tim Crowther', 'email' => 'tim_crowther@yahoo.com', 'licence_number' => null],
            ['name' => 'Louis Darbandi', 'email' => 'louisdarbandi.ref@gmail.com', 'licence_number' => null],
            ['name' => 'Rick Dell', 'email' => 'rickdellman@gmail.com', 'licence_number' => null],
            ['name' => 'Oliver Garland', 'email' => 'andrea.garland@hotmail.co.uk', 'licence_number' => null],
            ['name' => 'Sean Green', 'email' => 'seangreen6@hotmail.com', 'licence_number' => null],
            ['name' => 'Sara Guebaiti', 'email' => 'saraguebaili@outlook.ie', 'licence_number' => null],
            ['name' => 'Chi Haug Fung', 'email' => 'willyhfun@gmail.com', 'licence_number' => null],
            ['name' => 'Colin Hindmarch', 'email' => 'hindmarchc@gmail.com', 'licence_number' => null],
            ['name' => 'Cole Inglis', 'email' => 'coley.inglis@gmail.com', 'licence_number' => null],
            ['name' => 'Jay Jackson', 'email' => 'play_the_game6@hotmail.com', 'licence_number' => '5913'],
            ['name' => 'Kayleigh Johnson', 'email' => 'johnsonkayleigh70081993@gmail.com', 'licence_number' => '34424'],
            ['name' => 'Evangelos Karagiannis', 'email' => 'evangkaragiannis@gmail.com', 'licence_number' => null],
            ['name' => 'Dave Mann', 'email' => 'davemanntm@gmail.com', 'licence_number' => null],
            ['name' => 'Noah Marshall', 'email' => 'noahmarshall2005@gmail.com', 'licence_number' => null],
            ['name' => 'Dominic Maxwell', 'email' => 'maxdom100@gmail.com', 'licence_number' => null],
            ['name' => 'Tadas Merkelis', 'email' => 'tadasmerkelis@yahoo.co.uk', 'licence_number' => '000706'],
            ['name' => 'Tom Muldoon', 'email' => 'tom_muldoon@hotmail.com', 'licence_number' => '017268'],
            ['name' => 'Joshua Murdoch', 'email' => 'joshua_murdoch@icloud.com', 'licence_number' => null],
            ['name' => 'Roger Murie', 'email' => 'rmurie0964@aol.com', 'licence_number' => '000879'],
            ['name' => 'George Pastor', 'email' => 'georgepastor222@gmail.com', 'licence_number' => null],
            ['name' => 'Ryan Petrie', 'email' => 'rpetrie893@gmail.com', 'licence_number' => null],
            ['name' => 'Gregg Pickard', 'email' => 'greggno11@hotmail.co.uk', 'licence_number' => '000196'],
            ['name' => 'Barry Pui', 'email' => 'barrypuicy@yahoo.com.hk', 'licence_number' => null],
            ['name' => 'Zexian Qin', 'email' => 'shanelovesapple@hotmail.com', 'licence_number' => null],
            ['name' => 'Josh Roberts', 'email' => 'joshrobertscity@gmail.com', 'licence_number' => null],
            ['name' => 'Mike Rudkowskyj', 'email' => 'rudkowskyj@btinternet.com', 'licence_number' => '004879'],
            ['name' => 'Amy Russell', 'email' => 'amyrussell1993@hotmail.co.uk', 'licence_number' => null],
            ['name' => 'Zoe Silcock', 'email' => 'zoesilcock@gmail.com', 'licence_number' => null],
            ['name' => 'Salty Siteine', 'email' => 'saltysiteine@hotmail.com', 'licence_number' => null],
            ['name' => 'Dean Sorah', 'email' => 'deanbasketball@hotmail.co.uk', 'licence_number' => null],
            ['name' => 'Chris Stainton', 'email' => 'stainy15@gmail.com', 'licence_number' => '000388'],
            ['name' => 'Emma Tomkinson', 'email' => 'emmatomkinson234@gmail.com', 'licence_number' => null],
            ['name' => 'Jonathan Vickerstaff', 'email' => 'j.vickerstaff@live.co.uk', 'licence_number' => '000172'],
            ['name' => 'Simeon Viveash', 'email' => 'simeon.viveash@gmail.com', 'licence_number' => '005931'],
            ['name' => 'Fitzroy Wallace', 'email' => 'fbwlexus@hotmail.com', 'licence_number' => '004010'],
            ['name' => 'Max Watt', 'email' => 'wattsmax277@gmail.com', 'licence_number' => null],
            ['name' => 'Sam West', 'email' => 'samueljoshuawest@gmail.com', 'licence_number' => null],
            ['name' => 'Craig Wilson', 'email' => 'craig_wilson16@hotmail.com', 'licence_number' => '000192'],
            ['name' => 'Dave Woods', 'email' => 'woodsd59@icloud.com', 'licence_number' => '000779'],
        ];
        foreach ($officials as $official) {
            \App\Models\Official::firstOrCreate([
                'name' => $official['name'],
                'email' => $official['email'],
                'licence_number' => $official['licence_number'],
            ]);
        }

        // Update officials to have role 'referee'
        DB::table('officials')->update(['role' => 'Referee']);

        // Add Table Officials
        $tableOfficials = [
            ['name' => 'Christine Kitchen', 'email' => 'christinelewin61@hotmail.com', 'phone' => '07961 191337', 'level' => '3'],
            ['name' => 'John Kitchen', 'email' => 'kitchen_john@hotmail.com', 'phone' => '07984 644207', 'level' => '3'],
            ['name' => 'Steve Stoddart', 'email' => 'steve_stoddart2003@yahoo.co.uk', 'phone' => '07960 294801', 'level' => '3'],
            ['name' => 'Iain Roberts', 'email' => 'iainroberts@zohomail.eu', 'phone' => '07958 570202', 'level' => '3'],
            ['name' => 'Karen Brooks', 'email' => 'karen.brooke65@outlook.com', 'phone' => '07779 525487', 'level' => '3'],
            ['name' => 'Sam Hodkin', 'email' => 'samhodkin47@gmail.com', 'phone' => '07851 343680', 'level' => '1'],
            ['name' => 'Glynis Aghatabay', 'email' => 'gabasketball2@outlook.com', 'phone' => '07512 650859', 'level' => '3'],
            ['name' => 'David Cunningham', 'email' => 'statsrogerson@hotmail.com', 'phone' => '07812 813437', 'level' => '5'],
            ['name' => 'Gregg Pickard', 'email' => 'greggno11@hotmail.com', 'phone' => '07976 821857', 'level' => '2'],
            ['name' => 'Kevin Garry', 'email' => 'kayjaygee2003@yahoo.co.uk', 'phone' => '07963 042481', 'level' => '2'],
        ];
        foreach ($tableOfficials as $official) {
            \App\Models\Official::firstOrCreate([
                'name' => $official['name'],
                'email' => $official['email'],
                'role' => 'Table',
                'level' => $official['level'],
            ]);
        }

        // Add Fixtures from screenshot
        $fixtures = [
            [
                'league' => 'Premier',
                'tip_day' => 'Mon',
                'tip_time' => '20:15pm',
                'home_team' => 'Burnley Blazers 1',
                'away_team' => 'Mavericks 1',
                'referee1' => 'S.Viveash',
                'referee2' => 'T.Crowther',
                'table_official' => null,
                'date' => '2024-05-20',
            ],
            [
                'league' => 'Premier',
                'tip_day' => 'Wed',
                'tip_time' => '20:15pm',
                'home_team' => 'Moss Side Tropics',
                'away_team' => 'Cardinal Langley 1',
                'referee1' => 'D.Woods',
                'referee2' => 'J.Jackson',
                'table_official' => null,
                'date' => '2024-05-22',
            ],
            [
                'league' => 'Premier',
                'tip_day' => 'Thu',
                'tip_time' => '20:00pm',
                'home_team' => 'YMCA',
                'away_team' => 'Burnley Blazers 1',
                'referee1' => 'J.Jackson',
                'referee2' => 'S.Viveash',
                'table_official' => null,
                'date' => '2024-05-23',
            ],
            [
                'league' => 'Premier',
                'tip_day' => 'Thu',
                'tip_time' => '20:00pm',
                'home_team' => 'Free City YMCA',
                'away_team' => 'Trafford Giants 1',
                'referee1' => 'S.Viveash',
                'referee2' => 'S.Guebaiti',
                'table_official' => null,
                'date' => '2024-05-23',
            ],
        ];
        foreach ($fixtures as $fixture) {
            $leagueId = \App\Models\League::where('name', $fixture['league'])->first()?->id;
            $homeTeam = \App\Models\Team::where('name', $fixture['home_team'])->first();
            $awayTeam = \App\Models\Team::where('name', $fixture['away_team'])->first();
            $ref1 = \App\Models\Official::whereRaw("REPLACE(name, ' ', '') = ?", [str_replace('.', '', $fixture['referee1'])])->first();
            $ref2 = \App\Models\Official::whereRaw("REPLACE(name, ' ', '') = ?", [str_replace('.', '', $fixture['referee2'])])->first();
            if ($leagueId && $homeTeam && $awayTeam) {
                DB::table('fixtures')->insert([
                    'league_id' => $leagueId,
                    'home_team_id' => $homeTeam->id,
                    'away_team_id' => $awayTeam->id,
                    'crew_chief_id' => $ref1?->id,
                    'referee_1_id' => $ref2?->id,
                    'referee_2_id' => null,
                    'date' => $fixture['date'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        // Remove Premier teams
        $premierLeague = \App\Models\League::where('name', 'Premier')->first();
        if ($premierLeague) {
            \App\Models\Team::where('league_id', $premierLeague->id)
                ->whereIn('name', [
                    'Burnley Blazers 1',
                    'Cardinal Langley 1',
                    'Free City YMCA',
                    'Manchester Heat',
                    'Mavericks 1',
                    'Mavericks 2',
                    'Moss Side Tropics',
                    'Myerscough College',
                    'St Helens',
                    'Trafford Giants 1',
                    'YMCA',
                ])->delete();
        }
        // Remove Championship teams
        $championshipLeague = \App\Models\League::where('name', 'Championship')->first();
        if ($championshipLeague) {
            \App\Models\Team::where('league_id', $championshipLeague->id)
                ->whereIn('name', [
                    'Belle Vue Bears',
                    'Canute',
                    'Cheshire Hornets 1',
                    'North West A Nabbs',
                    'Preston Basketball Club 1',
                    'Preston Basketball Club 2',
                    'Salford',
                    'Stockport Atlas',
                    'Tameside Vikings 1',
                ])->delete();
        }
        // Remove Division One teams
        $divisionOneLeague = \App\Models\League::where('name', 'Division One')->first();
        if ($divisionOneLeague) {
            \App\Models\Team::where('league_id', $divisionOneLeague->id)
                ->whereIn('name', [
                    '8ight5ive2wo',
                    'Cardinal Langley 2',
                    'Cheshire Hornets 2',
                    'High Peak Steelers',
                    'Manchester Kings U23',
                    'Mavericks 3',
                    'Northwich Basketball Club',
                    'Preston Basketball Club 3',
                    'Tameside Vikings 2',
                ])->delete();
        }
        // Remove Womens teams
        $womensLeague = \App\Models\League::where('name', 'Womens')->first();
        if ($womensLeague) {
            \App\Models\Team::where('league_id', $womensLeague->id)
                ->whereIn('name', [
                    'Cheshire Roar',
                    'FBA Manchester',
                    'FBA Rockettes',
                    'Lancashire Spinners',
                    'Liverpool Basketball Club',
                    'Manchester Lynx',
                    'Manchester Valkyries',
                    'Rossendale Raptors',
                    'Stockport Lapwings',
                    'Stockport Lapwings Green',
                    'Tameside Wikings',
                ])->delete();
        }
        // Remove the leagues
        \App\Models\League::whereIn('name', [
            'Premier',
            'Championship',
            'Division One',
            'Womens',
            'Cup',
        ])->delete();
    }
}; 