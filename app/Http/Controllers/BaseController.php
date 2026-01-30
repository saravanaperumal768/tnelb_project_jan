<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Admin\Tnelb_Footerbottom;
use App\Models\Admin\Tnelb_Footercopyright;
use App\Models\Admin\Tnelb_Gallery;
use App\Models\Admin\Tnelb_homeslider_tbl;
use App\Models\Admin\Tnelb_Newsboard;
use App\Models\Admin\Tnelb_Quicklinks;
use App\Models\Admin\Tnelb_submenus;
use App\Models\Admin\Tnelb_Usefullinks;
use App\Models\Admin\Tnelb_Whatsnew;
use App\Models\Admin\TnelbMenu;
use App\Models\Admin\TnelbMenuPage;
use App\Models\Admin\Tnelb_Mst_Media;
class BaseController extends Controller
{
     protected $commonData = [];

    public function __construct()
    {
        $this->commonData = [
            'sliders' => Tnelb_homeslider_tbl::where('slider_status', 1)->orderBy('updated_at')->get(),
            'menu' => TnelbMenu::with('menuPage')->where('status', 1)->orderBy('order_id')->get(),
            'submenu' => Tnelb_submenus::with('submenuPage')->where('status', 1)->orderBy('order_id')->get(),

            // 'whatsnew' => Tnelb_Whatsnew::find(1),
            'whatsnew' => Tnelb_Whatsnew::where('status', 1)->get(),
            'newsboards' => Tnelb_Newsboard::all(),

            'quicklinks' => Tnelb_Quicklinks::with('menuPage')->where('status', 1)->orderBy('order_id')->get(),
                        'footerbottom' => Tnelb_Footerbottom::with('menuPage')->where('status', 1)->orderBy('order_id')->get(),

            'footercopyrights' => Tnelb_Footercopyright::first(),

                'footerbottom' => Tnelb_Footerbottom::with('menuPage')->where('status', 1)->orderBy('order_id')->get(),

            // 'newsboards' => Tnelb_Newsboard::find(1),
        ];
        view()->share($this->commonData); // Makes it available to all views automatically
    }
}
