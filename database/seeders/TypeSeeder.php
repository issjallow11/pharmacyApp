<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      // DB::table('types')->truncate();

      DB::table('types')->insert(
        [
          [
              'name' => 'liquid',
              'description' => Str::words(50),
          ],
          [
            'name' => 'solid',
            'description' => Str::words(50),
          ] ,
          [
          'name' => 'capsules',
          'description' => Str::words(50),
          ],
        ]
      );
    }
}
