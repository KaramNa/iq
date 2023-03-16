<?php

namespace Database\Seeders;

use App\Helpers\MainHelper;
use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuLink;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::create([
            'title' => "القائمة العلوية",
            'location' => "NAVBAR"
        ]);

        $this->makeMenuLink($menu, "CUSTOM_LINK", null, "الرئيسية", "Home", env("APP_URL"), "fal fa-home", 0);
        $this->makeMenuLink($menu, "CUSTOM_LINK", null, "الاختبارات", "Tests", route('tests'), "fal fa-brain", 1);
        $this->makeMenuLink($menu, "CUSTOM_LINK", null, "المدونة", "Blog", route('blog'), "fal fa-pen-alt", 2);
        $this->makeMenuLink(
            $menu,
            "CUSTOM_LINK",
            null,
            "تواصل معنا",
            "Contact us",
            route('contact'),
            "fal fa-phone",
            3
        );
        $this->makeMenuLink(
            $menu,
            "PAGE",
            \App\Models\Page::whereTranslationLike('slug', 'privacy-policy')->first()->id,
            "سياسة الخصوصية",
            "Privacy Policy",
            '',
            "fal fa-file",
            4
        );
        $this->makeMenuLink(
            $menu,
            "PAGE",
            \App\Models\Page::whereTranslationLike('slug', 'about-us')->first()->id,
            "معلومات عنا",
            "About Us",
            '',
            "fal fa-info",
            5
        );
    }


    public function makeMenuLink($menu, $type, $type_id, $title_ar, $title_en, $url, $icon, $order)
    {
        $menuLink = new MenuLink();


        $menuLink->menu_id = $menu->id;
        $menuLink->type = $type;
        $menuLink->type_id = $type_id;
        $menuLink->url = $url;
        $menuLink->icon = $icon;
        $menuLink->order = $order;


        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($key == 'ar') {
                $menuLink->translateOrNew($key)->title = $title_ar;
            } else {
                $menuLink->translateOrNew($key)->title = $title_en;
            }
        }

        $menuLink->save();

        $link = MenuLink::find($menuLink->id);
        if ($link->type == "PAGE") {
            $page = Page::where('id', $link->type_id)->first();
            $url = env("APP_URL") . substr(route('page.show', $page), strlen(env("APP_URL")));
            $link->update([
                'url' => $url
            ]);
        }
    }
}
