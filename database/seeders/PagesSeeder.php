<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $page = new Page();
        $page->user_id = 1;
        $page->removable = 0;

        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($key == 'ar') {
                $page->translateOrNew($key)->title = 'سياسة الخصوصية';
                $page->translateOrNew($key)->slug = 'سياسة-الخصوصية';
            }else{
                $page->translateOrNew($key)->title = 'Privacy Policy';
                $page->translateOrNew($key)->slug = 'privacy-policy';
            }
        }

        $page->save();
        /*terms*/


        $page = new Page();
        $page->user_id = 1;
        $page->removable = 0;

        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($key == 'ar') {
                $page->translateOrNew($key)->title = 'معلومات عنا';
                $page->translateOrNew($key)->slug = 'معلومات-عنا';
            }else{
                $page->translateOrNew($key)->title = 'About us';
                $page->translateOrNew($key)->slug = 'about-us';
            }
        }

        $page->save();
    }
}
