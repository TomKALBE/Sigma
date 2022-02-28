<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Chapter;
use App\Models\Formation;
use App\Models\Formation_Category;
use App\Models\Step;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3)->create();
        User::factory()->create(['email' => "admin@admin.com",'role'=>User::ADMIN_ROLE,'password'=>'$2y$10$kAE7xYYjsR4t7aB8V34Mduy.Ri4RTJf9EiPO1MpZw3FXQBY9x7qMW']);
        $category = Category::factory(4)->create();
        Formation::factory()
            ->hasAttached($category)
            ->count(15)
            ->create();
        Chapter::factory(20)->create();
        Step::factory(50)->create();

    }
}
