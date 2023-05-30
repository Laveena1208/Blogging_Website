<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        \App\Models\User::factory()->create([
            'name' => 'Laveena',
            'email' => 'laveena@gmail.com',
            'password' => Hash::make('laveena123456789'),
            'role' => 'admin'
        ]);

        \App\Models\User::factory(10)->create();
        $categories = ['Sports', 'Technology', 'Gaming', 'Web Development','Entertainment'];
        foreach($categories as $category){
            $user = User::all()->random();
            Category::create([
                'name' => $category,
                'created_by' => $user->id,
                'last_updated_by' => $user->id
        ]);
        }

        $tags = ['Programming', 'Coding', 'Softwares', 'Computers', 'CS', 'IT', 'Cricket', 'Football', 'Dance'];
        foreach($tags as $tag){
            $user = User::all()->random();
            Tag::create([
                'name' => $tag,
                'created_by' => $user->id,
                'last_updated_by' => $user->id
        ]);
        }
        $this->call(BlogsSeeder::class);
    }
}
