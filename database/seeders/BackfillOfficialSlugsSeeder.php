<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Official;
use Illuminate\Support\Str;

class BackfillOfficialSlugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Official::whereNull('slug')->orWhere('slug', '')->get()->each(function ($official) {
            $baseSlug = Str::slug($official->name);
            $slug = $baseSlug;
            $i = 1;
            while (Official::where('slug', $slug)->where('id', '!=', $official->id)->exists()) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }
            $official->slug = $slug;
            $official->save();
        });
    }
}
