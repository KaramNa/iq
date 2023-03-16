<?php

namespace App\Providers;

use App\Helpers\SettingsHelper;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Observers\ContactObserver;
use App\Observers\ContactReplyObserver;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ContactReply::observe(ContactReplyObserver::class);
        Contact::observe(ContactObserver::class);

        Paginator::useBootstrapFive();
        Schema::defaultStringLength(191);
        try {
            $settings = (new SettingsHelper)->getAllSettings();
            View::share('settings', $settings);
        } catch (\Exception $e) {
        }

        Collection::macro('paginate', function ($perPage, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage), // $items
                $this->count(),                  // $total
                $perPage,
                $page,
                [                                // $options
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
