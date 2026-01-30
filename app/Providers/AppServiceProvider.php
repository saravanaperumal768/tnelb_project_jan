<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Admin\Tnelb_submenus;
use App\Models\Admin\TnelbMenu;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View as FacadesView;

use Illuminate\Support\Facades\URL;

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
    // Force HTTPS only in production
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }

    FacadesView::composer('admincms.include.navbar', function ($view) {
        $user = Auth::user();

        if ($user && $user->email === 'admin@tnelb.com') {
            $menus = TnelbMenu::whereNotIn('id', [1, 2, 3])->orderBy('order_id')->get();
            $memberlist = TnelbMenu::where('menu_name_en', 'members')->first();
            $submenus = Tnelb_submenus::all();
        } else {
            $menus = TnelbMenu::orderBy('order_id')->get();
            $submenus = Tnelb_submenus::all();
            $memberlist = TnelbMenu::where('menu_name_en', 'members')->first();
        }

        $view->with([
            'menus' => $menus,
            'submenus' => $submenus,
            'memberlist' => $memberlist,
        ]);
    });
}

}
