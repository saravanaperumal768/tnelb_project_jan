<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Portaladmin_menu;
use App\Models\Admin\Tnelb_Mst_Media;
use App\Models\Admin\Tnelb_Quicklinks;
use App\Models\Admin\Tnelb_submenus;
use App\Models\Admin\Tnelb_Whatsnew;
use App\Models\Admin\TnelbMenu;
use App\Models\Admin\TnelbMenuPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    protected $updatedBy;

    public function __construct()
    {
        // Ensure user is authenticated before accessing
        $this->middleware(function ($request, $next) {
            $this->updatedBy = Auth::user()->name ?? 'System';
            return $next($request);
        });
    }
    public function menus()
    {
        // $menus = Portaladmin_menu::orderBy('portions')->get; // Fetch all menu items
        // $menus = TnelbMenu::orderBy('updated_at', 'desc')->get();
        $menus = TnelbMenu::with('menuPage')
            ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END")
            ->orderBy('updated_at', 'desc')
            ->get();

            $media = Tnelb_Mst_Media::where([
            ['status', '=', '1'],
            ['type', '=', 'pdf']
        ])->orderBy('updated_at', 'desc')->get();


        return view('admincms.menus.index', compact('menus', 'media'));
    }

    public function insertmenu(Request $request)
    {
        $lastOrderId = TnelbMenu::max('order_id');
        $nextOrderId = $lastOrderId ? $lastOrderId + 1 : 1;

        $quicklinksId = Tnelb_Quicklinks::max('order_id');
        $quicklinksOrderId = $quicklinksId ? $quicklinksId + 1 : 1;

        $rules = [
            'menu_name_en'  => 'required|string|max:255',
            'menu_name_ta'  => 'required|string|max:255',
            'page_type'     => 'required|in:Static Page,pdf,url,submenu',
            'order_id'      => 'required|integer',
            'status'        => 'nullable|in:0,1,2',
        ];

        // Additional rules based on page type
        if ($request->page_type === 'Static Page') {
            $rules += [
                'page_url'    => 'required|string|max:255',
                'page_url_ta' => 'required|string|max:255',
            ];
        } elseif ($request->page_type === 'pdf') {
            $rules += [
                'pdf_en' => 'required|file|mimes:pdf|max:10240',
                'pdf_ta' => 'required|file|mimes:pdf|max:10240',
            ];
        } elseif ($request->page_type === 'url') {
            $rules += [
                'external_url' => 'required|url',
            ];
        }

        $request->validate($rules);

        // Handle PDF uploads
        $pdf_en_path = null;
        $pdf_ta_path = null;

        if ($request->page_type === 'pdf') {
            $uploadPath = public_path('portaladmin/pdf_menu');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $pdf_en_file = $request->file('pdf_en');
                $pdf_en_name = time() . '_en.' . $pdf_en_file->getClientOriginalExtension();
                $pdf_en_file->move($uploadPath, $pdf_en_name);
                $pdf_en_path = 'portaladmin/pdf_menu/' . $pdf_en_name;
            }

            if ($request->hasFile('pdf_ta')) {
                $pdf_ta_file = $request->file('pdf_ta');
                $pdf_ta_name = time() . '_ta.' . $pdf_ta_file->getClientOriginalExtension();
                $pdf_ta_file->move($uploadPath, $pdf_ta_name);
                $pdf_ta_path = 'portaladmin/pdf_menu/' . $pdf_ta_name;
            }
        }

        // Check if checkbox is ticked
        $addToQuickLinks = $request->has('footer_quicklinks') ? 1 : 0;

        // Store in tnelb_menus
        $menu = TnelbMenu::create([
            'menu_name_en'       => $request->menu_name_en,
            'menu_name_ta'       => $request->menu_name_ta,
            'page_type'          => $request->page_type,
            'status'             => $request->status ?? 1,
            'order_id'           => $nextOrderId,
            'footer_quicklinks'  => $addToQuickLinks,
            'updated_by'         => $this->updatedBy,
        ]);

        // Conditionally insert into tnelb_quicklinks
        // $footerQuicklinks = null;
        if ($addToQuickLinks) {
            $footerQuicklinks = Tnelb_Quicklinks::create([
                'menu_id'          => $menu->id,
                'footer_menu_en'   => $request->menu_name_en,
                'footer_menu_ta'   => $request->menu_name_ta,
                'page_type'        => $request->page_type,
                'status'           => $request->status ?? 1,
                'order_id'         => $quicklinksOrderId,
                'updated_by'       => $this->updatedBy,
            ]);
        }

        // Store in tnelb_menu_pages
        TnelbMenuPage::create([
            'menu_id'              => $menu->id,
            'footer_quicklinks_id' => isset($footerQuicklinks) ? $footerQuicklinks->id : null,
            'page_url'             => $request->page_type === 'Static Page' ? $request->page_url : null,
            'page_url_ta'          => $request->page_type === 'Static Page' ? $request->page_url_ta : null,
            'pdf_en'               => $pdf_en_path,
            'pdf_ta'               => $pdf_ta_path,
            'external_url'         => $request->page_type === 'url' ? $request->external_url : null,
            'updated_by'           => $this->updatedBy,
            'page_type'            => $request->page_type,
            'status'               => $request->status ?? 1,
        ]);


        $menu->load('menuPage');

        return response()->json([
            'success' => true,
            'message' => 'Menu and page content saved successfully!',
            'data'    => $menu
        ]);
    }




    public function deactivate($id)
    {
        $menu = TnelbMenu::find($id);
        if (!$menu) {
            return response()->json(['success' => false, 'message' => 'Menu not found.']);
        }

        $menu->status = 0;
        $menu->save();

        return response()->json(['success' => true, 'message' => 'Menu deactivated successfully.']);
    }

    public function toggleStatus(Request $request, $id)
    {
        $menu = TnelbMenu::find($id);

        if (!$menu) {
            return response()->json(['success' => false, 'message' => 'Menu not found.']);
        }

        $menu->status = $request->input('status');
        $menu->save();

        return response()->json([
            'success' => true,
            'message' => $menu->status == 1 ? 'Menu activated.' : 'Menu deactivated.'
        ]);
    }


    public function updateMenuPositions(Request $request)
    {
        foreach ($request->positions as $item) {
            Portaladmin_menu::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return response()->json(['message' => 'Positions updated successfully']);
    }

    public function reorder(Request $request)
    {
        $menuData = $request->input('data');

        if (!is_array($menuData)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data format'], 400);
        }

        foreach ($menuData as $item) {
            // Check if order_id and id keys exist
            if (!isset($item['order_id'], $item['id'])) {
                continue; // or handle error
            }

            // Update the menu item order
            TnelbMenu::where('id', $item['id'])->update([
                'order_id' => $item['order_id']
            ]);
        }

        return response()->json(['status' => 'success']);
    }



    // --------------submenu---------------------------
    public function submenus()
    {
        $menus = TnelbMenu::orderBy('order_id')->get();

        $submenus = Tnelb_submenus::with(['submenuPage', 'parentMenu'])
            ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END")
            ->orderBy('updated_at', 'desc')
            ->get();


        return view('admincms.submenu.index', compact('submenus', 'menus'));
    }



    public function insertSubmenu(Request $request)
    {
        $lastOrderId = Tnelb_submenus::max('order_id');
        $nextOrderId = $lastOrderId ? $lastOrderId + 1 : 1;

        $quicklinksId = Tnelb_Quicklinks::max('order_id');
        $quicklinksOrderId = $quicklinksId ? $quicklinksId + 1 : 1;

        $rules = [
            'page_type'     => 'required|in:Static Page,pdf,url,submenu',
            'order_id'      => 'required|integer',
            'status'        => 'nullable|in:0,1,2',
            'menu_name_en'  => 'required|string|max:255',
            'menu_name_ta'  => 'required|string|max:255',
            'parent_code'   => 'required|integer|exists:tnelb_menus,id',
        ];

        if ($request->page_type === 'Static Page') {
            $rules += [
                'page_url'    => 'required|string|max:255',
                'page_url_ta' => 'required|string|max:255',
            ];
        } elseif ($request->page_type === 'pdf') {
            $rules += [
                'pdf_en' => 'required|file|mimes:pdf|max:10240',
                'pdf_ta' => 'required|file|mimes:pdf|max:10240',
            ];
        } elseif ($request->page_type === 'url') {
            $rules += [
                'external_url' => 'required|url',
            ];
        }

        $request->validate($rules);

        $pdf_en_path = null;
        $pdf_ta_path = null;

        if ($request->page_type === 'pdf') {
            $uploadPath = public_path('portaladmin/pdf_menu');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $pdf_en_file = $request->file('pdf_en');
                $pdf_en_name = time() . '_en.' . $pdf_en_file->getClientOriginalExtension();
                $pdf_en_file->move($uploadPath, $pdf_en_name);
                $pdf_en_path = 'portaladmin/pdf_menu/' . $pdf_en_name;
            }

            if ($request->hasFile('pdf_ta')) {
                $pdf_ta_file = $request->file('pdf_ta');
                $pdf_ta_name = time() . '_ta.' . $pdf_ta_file->getClientOriginalExtension();
                $pdf_ta_file->move($uploadPath, $pdf_ta_name);
                $pdf_ta_path = 'portaladmin/pdf_menu/' . $pdf_ta_name;
            }
        }

        // Detect checkbox
        $addToQuickLinks = $request->has('footer_quicklinks') ? 1 : 0;

        // Save to submenu
        $submenu = Tnelb_submenus::create([
            'menu_name_en'       => $request->menu_name_en,
            'menu_name_ta'       => $request->menu_name_ta,
            'parent_code'        => $request->parent_code,
            'order_id'           => $nextOrderId,
            'page_type'          => $request->page_type,
            'status'             => $request->status ?? 1,
            'footer_quicklinks'  => $addToQuickLinks,
            'updated_by'         => $this->updatedBy,
        ]);

        // Conditionally create footer entry
        $footerQuicklinks = null;
        if ($addToQuickLinks) {
            $footerQuicklinks = Tnelb_Quicklinks::create([
                'submenu_id'        => $submenu->id,
                'footer_menu_en' => $request->menu_name_en,
                'footer_menu_ta' => $request->menu_name_ta,
                'page_type'      => $request->page_type,
                'status'         => $request->status ?? 1,
                'order_id'       => $quicklinksOrderId,
                'updated_by'     => $this->updatedBy,
            ]);
        }

        // Create menu page
        TnelbMenuPage::create([
            'menu_id'              => $request->parent_code,
            'submenu_id'           => $submenu->id,
            'footer_quicklinks_id' => $footerQuicklinks->id ?? null,
            // 'footer_quicklinks_id' => $footerQuicklinks?->id,
            'page_url'             => $request->page_type === 'Static Page' ? $request->page_url : null,
            'page_url_ta'          => $request->page_type === 'Static Page' ? $request->page_url_ta : null,
            'pdf_en'               => $pdf_en_path,
            'pdf_ta'               => $pdf_ta_path,
            'external_url'         => $request->page_type === 'url' ? $request->external_url : null,
            'updated_by'           => $this->updatedBy,
            'page_type'            => $request->page_type,
            'status'               => $request->status ?? 1,


        ]);

        $submenu->load('submenuPage');

        return response()->json([
            'success' => true,
            'message' => 'Submenu and page content saved successfully!',
            'data'    => $submenu
        ]);
    }





    // -----------updatemenu----------------------
    public function updateitems(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_menus,id',
            'status' => 'required',
        ]);

        $menu = TnelbMenu::findOrFail($request->id);

        if ($request->filled('order_id')) {
            $existing = TnelbMenu::where('order_id', $request->order_id)
                ->where('id', '!=', $request->id)
                ->first();

            if ($existing && !$request->has('force_replace')) {
                return response()->json([
                    'conflict' => true,
                    'message' => "Order number '{$request->order_id}' already exists and is used by: " . ($existing->menu_name_en ?? 'Untitled') . ". If you want to change this, you must replace it.",
                ]);
            }

            if ($existing && $request->has('force_replace')) {
                $existing->order_id = null;
                $existing->save();
            }

            $menu->order_id = $request->order_id;
        }

        $menu->menu_name_en = $request->menu_name_en;
        $menu->menu_name_ta = $request->menu_name_ta;
        $menu->page_type = $request->page_type;
        $menu->status = $request->status;
        $menu->updated_by = $this->updatedBy;

        $menuPage = TnelbMenuPage::firstOrNew(['menu_id' => $menu->id]);
        $menuPage->page_type = $request->page_type;
        $menuPage->updated_by = $this->updatedBy;
        $menuPage->status = $request->status;

        if ($request->page_type === 'Static Page') {
            $request->validate([
                'menu_name_en' => 'required|string|max:255',
                'menu_name_ta' => 'required|string|max:255',
                'page_url' => 'required|string|max:255',
                'page_url_ta' => 'required|string|max:255',
            ]);

            $menuPage->page_url = $request->page_url;
            $menuPage->page_url_ta = $request->page_url_ta;
            $menuPage->pdf_en = null;
            $menuPage->pdf_ta = null;
            $menuPage->external_url = null;
            $menu->pdf_en = null;
            $menu->pdf_ta = null;
        } elseif ($request->page_type === 'pdf') {
            $request->validate([
                'pdf_en' => 'nullable|file|mimes:pdf|max:10240',
                'pdf_ta' => 'nullable|file|mimes:pdf|max:10240',
            ]);

            $uploadPath = public_path('portaladmin/pdf_menu');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $enFile = $request->file('pdf_en');
                $enFileName = time() . '_en.' . $enFile->getClientOriginalExtension();
                $enFile->move($uploadPath, $enFileName);
                $menuPage->pdf_en = 'portaladmin/pdf_menu/' . $enFileName;
            }

            if ($request->hasFile('pdf_ta')) {
                $taFile = $request->file('pdf_ta');
                $taFileName = time() . '_ta.' . $taFile->getClientOriginalExtension();
                $taFile->move($uploadPath, $taFileName);
                $menuPage->pdf_ta = 'portaladmin/pdf_menu/' . $taFileName;
            }

            $menuPage->page_url = null;
            $menuPage->page_url_ta = null;
            $menuPage->external_url = null;

            $menu->page_url = null;
            $menu->page_url_ta = null;
        } elseif ($request->page_type === 'url') {
            $request->validate([
                'external_url' => 'required|url|max:255',
            ]);

            $menuPage->external_url = $request->external_url;
            $menuPage->page_url = null;
            $menuPage->page_url_ta = null;
            $menuPage->pdf_en = null;
            $menuPage->pdf_ta = null;

            $menu->page_url = null;
            $menu->page_url_ta = null;
            $menu->pdf_en = null;
            $menu->pdf_ta = null;
        }

        // Handle Footer Quick Links
        $addToQuickLinks = $request->has('footer_quicklinks') ? 1 : 0;

        if ($addToQuickLinks) {
            if ($menuPage->footer_quicklinks_id) {
                $quicklink = Tnelb_Quicklinks::find($menuPage->footer_quicklinks_id);
                if ($quicklink) {
                    $quicklink->update([
                        'footer_menu_en' => $request->menu_name_en,
                        'footer_menu_ta' => $request->menu_name_ta,
                        'page_type' => $request->page_type,
                        'status' => $request->status ?? 1,
                        'updated_by' => $this->updatedBy,
                        'order_id' => $request->order_id ?? $quicklink->order_id,
                    ]);
                }
            } else {
                $quicklink = Tnelb_Quicklinks::create([
                    'menu_id' => $menu->id,
                    'footer_menu_en' => $request->menu_name_en,
                    'footer_menu_ta' => $request->menu_name_ta,
                    'page_type' => $request->page_type,
                    'status' => $request->status ?? 1,
                    'updated_by' => $this->updatedBy,
                    'order_id' => $request->order_id,
                ]);
                $menuPage->footer_quicklinks_id = $quicklink->id;
            }
        } else {
            if ($menuPage->footer_quicklinks_id) {
                $quicklink = Tnelb_Quicklinks::find($menuPage->footer_quicklinks_id);
                if ($quicklink) $quicklink->delete();
                $menuPage->footer_quicklinks_id = null;
            }
        }

        $menu->save();
        $menuPage->save();

        $menu->load('menuPage');

        return response()->json([
            'success' => true,
            'menu' => $menu,
        ]);
    }



    // -------------------menucontent---------------------------------



    public function showContent($id)
    {
        $menu = TnelbMenu::with('menuPage')->findOrFail($id);

        // $menus = TnelbMenu::with('menuPage')
        // ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END")
        // ->orderBy('updated_at', 'desc')
        // ->get();

        // Show the page with content
        return view('admincms.menus.menucontent', compact('menu'));
    }

    // ------------------------------------------

    public function reorders(Request $request)
    {
        $menuData = $request->input('data');

        if (!is_array($menuData)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data format'], 400);
        }

        foreach ($menuData as $item) {
            // Check if order_id and id keys exist
            if (!isset($item['order_id'], $item['id'])) {
                continue; // or handle error
            }

            // Update the menu item order
            Tnelb_submenus::where('id', $item['id'])->update([
                'order_id' => $item['order_id']
            ]);
        }

        return response()->json(['status' => 'success']);
    }
    // --------------update submenu items---------------------
   

public function updatesubitems(Request $request)
{
    $request->validate([
        'id' => 'required|integer|exists:tnelb_submenus,id',
        'status' => 'required',
        'page_type' => 'required|string',
        'menu_name_en' => 'required|string|max:255',
        'menu_name_ta' => 'required|string|max:255',
        'parent_code' => 'required|string',
        
    ]);

    $submenu = Tnelb_submenus::findOrFail($request->id);

    if ($request->filled('order_id')) {
        $existing = Tnelb_submenus::where('order_id', $request->order_id)
            ->where('id', '!=', $request->id)
            ->first();

        if ($existing && !$request->has('force_replace')) {
            return response()->json([
                'conflict' => true,
                'message' => "Order number '{$request->order_id}' already exists and is used by: " . ($existing->menu_name_en ?? 'Untitled') . ". If you want to change this, you must replace it.",
            ]);
        }

        if ($existing && $request->has('force_replace')) {
            $existing->order_id = null;
            $existing->save();
        }

        $submenu->order_id = $request->order_id;
    }

    $submenu->menu_name_en = $request->menu_name_en;
    $submenu->menu_name_ta = $request->menu_name_ta;
    $submenu->page_type = $request->page_type;
    $submenu->parent_code = $request->parent_code;
    $submenu->status = $request->status;
    $submenu->updated_by = $this->updatedBy;

    $submenuPage = \App\Models\Admin\TnelbMenuPage::firstOrNew(['submenu_id' => $submenu->id]);
    $submenuPage->page_type = $request->page_type;
    $submenuPage->updated_by = $this->updatedBy;
    $submenuPage->status = $request->status;

    if ($request->page_type === 'Static Page') {
        $request->validate([
            'page_url' => 'required|string|max:255',
            'page_url_ta' => 'required|string|max:255',
        ]);

        $submenuPage->page_url = $request->page_url;
        $submenuPage->page_url_ta = $request->page_url_ta;

        $submenuPage->pdf_en = null;
        $submenuPage->pdf_ta = null;
        $submenuPage->external_url = null;

        $submenu->pdf_en = null;
        $submenu->pdf_ta = null;
    } elseif ($request->page_type === 'pdf') {
        $request->validate([
            'pdf_en' => 'nullable|file|mimes:pdf|max:10240',
            'pdf_ta' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $uploadPath = public_path('portaladmin/pdf_submenu');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if ($request->hasFile('pdf_en')) {
            $enFile = $request->file('pdf_en');
            $enFileName = time() . '_en.' . $enFile->getClientOriginalExtension();
            $enFile->move($uploadPath, $enFileName);
            $submenuPage->pdf_en = 'portaladmin/pdf_submenu/' . $enFileName;
        }

        if ($request->hasFile('pdf_ta')) {
            $taFile = $request->file('pdf_ta');
            $taFileName = time() . '_ta.' . $taFile->getClientOriginalExtension();
            $taFile->move($uploadPath, $taFileName);
            $submenuPage->pdf_ta = 'portaladmin/pdf_submenu/' . $taFileName;
        }

        $submenuPage->page_url = null;
        $submenuPage->page_url_ta = null;
        $submenuPage->external_url = null;

        $submenu->page_url = null;
        $submenu->page_url_ta = null;
    } elseif ($request->page_type === 'url') {
        $request->validate([
            'external_url' => 'required|url|max:255',
        ]);

        $submenuPage->external_url = $request->external_url;
        $submenuPage->page_url = null;
        $submenuPage->page_url_ta = null;
        $submenuPage->pdf_en = null;
        $submenuPage->pdf_ta = null;

        $submenu->page_url = null;
        $submenu->page_url_ta = null;
        $submenu->pdf_en = null;
        $submenu->pdf_ta = null;
    }

    $addToQuickLinks = $request->has('footer_quicklinks') ? 1 : 0;

    if ($addToQuickLinks) {
        if ($submenuPage->footer_quicklinks_id) {
            $quicklink = \App\Models\Admin\Tnelb_Quicklinks::find($submenuPage->footer_quicklinks_id);
            if ($quicklink) {
                $quicklink->update([
                    'footer_menu_en' => $request->menu_name_en,
                    'footer_menu_ta' => $request->menu_name_ta,
                    'page_type' => $request->page_type,
                    'status' => $request->status ?? 1,
                    'updated_by' => $this->updatedBy,
                    'order_id' => $request->order_id ?? $quicklink->order_id,
                ]);
            }
        } else {
            $quicklink = \App\Models\Admin\Tnelb_Quicklinks::create([
                'submenu_id' => $submenu->id,
                'footer_menu_en' => $request->menu_name_en,
                'footer_menu_ta' => $request->menu_name_ta,
                'page_type' => $request->page_type,
                'status' => $request->status ?? 1,
                'updated_by' => $this->updatedBy,
                'order_id' => $request->order_id,
            ]);
            $submenuPage->footer_quicklinks_id = $quicklink->id;
        }
    } else {
        if ($submenuPage->footer_quicklinks_id) {
            $quicklink = \App\Models\Admin\Tnelb_Quicklinks::find($submenuPage->footer_quicklinks_id);
            if ($quicklink) $quicklink->delete();
            $submenuPage->footer_quicklinks_id = null;
        }
    }

    $submenu->save();
    $submenuPage->save();

    $submenu->load('submenuPage');

    return response()->json([
        'success' => true,
        'submenu' => [
            'id' => $submenu->id,
            'menu_name_en' => $submenu->menu_name_en,
            'menu_name_ta' => $submenu->menu_name_ta,
            'parent_menu_name' => optional($submenu->parentMenu)->menu_name_en,
            'page_type' => $submenu->page_type,
            'order_id' => $submenu->order_id,
            'status' => $submenu->status,
            'updated_at' => $submenu->updated_at->format('Y-m-d'),
            'footer_quicklinks_id' => $submenuPage->footer_quicklinks_id,
        ],
    ]);
}



    // public function updateSubmenuContent(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|integer|exists:tnelb_menus,id',
    //         'submenu_content_en' => 'nullable|string',
    //         'submenu_content_ta' => 'nullable|string',
    //     ]);

    //     $menu = Tnelb_submenus::find($request->id);
    //     $menu->submenu_content_en = $request->submenu_content_en;
    //     $menu->submenu_content_ta = $request->submenu_content_ta;
    //     $menu->save();

    //     return response()->json(['success' => true]);
    // }


    public function deactivatesubmenu($id)
    {
        $menu = Tnelb_submenus::find($id);
        if (!$menu) {
            return response()->json(['success' => false, 'message' => 'Menu not found.']);
        }

        $menu->status = 0;
        $menu->save();

        return response()->json(['success' => true, 'message' => 'Menu deactivated successfully.']);
    }

    public function toggleStatussubmenu(Request $request, $id)
    {
        $menu = Tnelb_submenus::find($id);

        if (!$menu) {
            return response()->json(['success' => false, 'message' => 'Menu not found.']);
        }

        $menu->status = $request->input('status');
        $menu->save();

        return response()->json([
            'success' => true,
            'message' => $menu->status == 1 ? 'Menu activated.' : 'Menu deactivated.'
        ]);
    }

    // ----------------menucontentedit-----------------------

    public function updateMenuContent(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_menus,id',
        ]);

        $menuPage = \App\Models\Admin\TnelbMenuPage::firstOrNew([
            'menu_id' => $request->id,
        ]);

        if ($request->has('menucontent')) {
            $menuPage->menucontent = $request->menucontent;
        }

        if ($request->has('menucontent_ta')) {
            $menuPage->menucontent_ta = $request->menucontent_ta;
        }

        $menuPage->updated_by=$this->updatedBy;
        $menuPage->save();

        return response()->json([
            'success' => true,
            'message' => 'Menu content updated successfully.'
        ]);
    }

    public function showsubContent($id)
    {
        $menu = Tnelb_submenus::with('submenuPage')->findOrFail($id);

        // $menus = TnelbMenu::with('menuPage')
        // ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END")
        // ->orderBy('updated_at', 'desc')
        // ->get();

        // Show the page with content
        return view('admincms.submenu.submenucontent', compact('menu'));
    }
    // -------------------------------------------------
    public function updatesubMenuContent(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_submenus,id',
        ]);

        $menuPage = \App\Models\Admin\TnelbMenuPage::firstOrNew([
            'submenu_id' => $request->id,
        ]);

        if ($request->has('menucontent')) {
            $menuPage->menucontent = $request->menucontent;
        }

        if ($request->has('menucontent_ta')) {
            $menuPage->menucontent_ta = $request->menucontent_ta;
        }

        $menuPage->updated_by = $this->updatedBy;
        $menuPage->status = 1;
        $menuPage->save();

        return response()->json([
            'success' => true,
            'message' => 'Submenu content updated successfully.'
        ]);
    }

    // -------------Quick Links Insert--------------------

    public function insertquicklinks(Request $request)
    {
        $lastOrderId = Tnelb_Quicklinks::max('order_id');
        $nextOrderId = $lastOrderId ? $lastOrderId + 1 : 1;

        $rules = [
            'footer_menu_en'  => 'required|string|max:255',
            'footer_menu_ta'  => 'required|string|max:255',
            'page_type'     => 'required|in:Static Page,pdf,url,submenu',
            'order_id'      => 'required|integer',
            'status'        => 'nullable|in:0,1,2',
        ];

        if ($request->page_type === 'Static Page') {
            $rules += [
                'page_url'    => 'required|string|max:255',
                'page_url_ta' => 'required|string|max:255',
            ];
        } elseif ($request->page_type === 'pdf') {
            $rules += [
                'pdf_en' => 'required|file|mimes:pdf|max:10240',
                'pdf_ta' => 'required|file|mimes:pdf|max:10240',
            ];
        } elseif ($request->page_type === 'url') {
            $rules += [
                'external_url' => 'required|url',
            ];
        }

        $request->validate($rules);

        $pdf_en_path = null;
        $pdf_ta_path = null;

        if ($request->page_type === 'pdf') {
            $uploadPath = public_path('portaladmin/pdf_quicklinks');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $pdf_en_file = $request->file('pdf_en');
                $pdf_en_name = time() . '_en.' . $pdf_en_file->getClientOriginalExtension();
                $pdf_en_file->move($uploadPath, $pdf_en_name);
                $pdf_en_path = 'portaladmin/pdf_quicklinks/' . $pdf_en_name;
            }

            if ($request->hasFile('pdf_ta')) {
                $pdf_ta_file = $request->file('pdf_ta');
                $pdf_ta_name = time() . '_ta.' . $pdf_ta_file->getClientOriginalExtension();
                $pdf_ta_file->move($uploadPath, $pdf_ta_name);
                $pdf_ta_path = 'portaladmin/pdf_quicklinks/' . $pdf_ta_name;
            }
        }



        $footerQuicklinks = Tnelb_Quicklinks::create([
            'footer_menu_en'   => $request->footer_menu_en,
            'footer_menu_ta'   => $request->footer_menu_ta,
            'page_type'        => $request->page_type,
            'status'           => $request->status ?? 1,
            'order_id'         => $nextOrderId,
            'updated_by'       =>  $this->updatedBy,
        ]);

        TnelbMenuPage::create([
            'footer_quicklinks_id' => $footerQuicklinks->id,
            'page_url'             => $request->page_type === 'Static Page' ? $request->page_url : null,
            'page_url_ta'          => $request->page_type === 'Static Page' ? $request->page_url_ta : null,
            'pdf_en'               => $pdf_en_path,
            'pdf_ta'               => $pdf_ta_path,
            'external_url'         => $request->page_type === 'url' ? $request->external_url : null,
            'updated_by'       =>  $this->updatedBy,
            'page_type'            => $request->page_type,
            'status'               => $request->status ?? 1,
        ]);

        $footerQuicklinks->load('menuPage'); // Ensure this is added before response

        return response()->json([
            'success' => true,
            'message' => 'QuickLinks Added successfully!',
            'data'    => $footerQuicklinks
        ]);
    }
    // ------------------------------scrollmsg--------------------------

    public function editquicklinks(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_quicklinks,id',
            'status' => 'required',
        ]);

        $menu = Tnelb_Quicklinks::findOrFail($request->id);

        if ($request->filled('order_id')) {
            $existing = Tnelb_Quicklinks::where('order_id', $request->order_id)
                ->where('id', '!=', $request->id)
                ->first();

            if ($existing && !$request->has('force_replace')) {
                return response()->json([
                    'conflict' => true,
                    'message' => "Order number '{$request->order_id}' already exists and is used by: " . ($existing->menu_name_en ?? 'Untitled') . ".",
                ]);
            }

            if ($existing && $request->has('force_replace')) {
                $existing->order_id = null;
                $existing->save();
            }

            $menu->order_id = $request->order_id;
        }

        $menu->footer_menu_en = $request->footer_menu_en;
        $menu->footer_menu_ta = $request->footer_menu_ta;
        $menu->page_type = $request->page_type;
        $menu->status = $request->status;

        // Update or create menu page
        $menuPage = \App\Models\Admin\TnelbMenuPage::firstOrNew(['footer_quicklinks_id' => $menu->id]);
        $menuPage->page_type = $request->page_type;
        $menuPage->updated_by = $this->updatedBy;
        $menuPage->status = $request->status;

        if ($request->page_type === 'Static Page') {
            $request->validate([
                'footer_menu_en' => 'required|string|max:255',
                'footer_menu_ta' => 'required|string|max:255',
                'page_url' => 'required|string|max:255',
                'page_url_ta' => 'required|string|max:255',
            ]);

            $menuPage->page_url = $request->page_url;
            $menuPage->page_url_ta = $request->page_url_ta;
            $menuPage->pdf_en = null;
            $menuPage->pdf_ta = null;
            $menuPage->external_url = null;
        } elseif ($request->page_type === 'pdf') {
            $request->validate([
                'pdf_en' => 'nullable|file|mimes:pdf|max:10240',
                'pdf_ta' => 'nullable|file|mimes:pdf|max:10240',
            ]);

            $uploadPath = public_path('portaladmin/pdf_quicklinks');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $enFile = $request->file('pdf_en');
                $enFileName = time() . '_en.' . $enFile->getClientOriginalExtension();
                $enFile->move($uploadPath, $enFileName);
                $menuPage->pdf_en = 'portaladmin/pdf_quicklinks/' . $enFileName;
            }

            if ($request->hasFile('pdf_ta')) {
                $taFile = $request->file('pdf_ta');
                $taFileName = time() . '_ta.' . $taFile->getClientOriginalExtension();
                $taFile->move($uploadPath, $taFileName);
                $menuPage->pdf_ta = 'portaladmin/pdf_quicklinks/' . $taFileName;
            }

            $menuPage->page_url = null;
            $menuPage->page_url_ta = null;
            $menuPage->external_url = null;
        } elseif ($request->page_type === 'url') {
            $request->validate([
                'external_url' => 'required|url|max:255',
            ]);

            $menuPage->external_url = $request->external_url;
            $menuPage->page_url = null;
            $menuPage->page_url_ta = null;
            $menuPage->pdf_en = null;
            $menuPage->pdf_ta = null;
        }

        $menu->save();
        $menuPage->save();

        $menu->load('menuPage');

        return response()->json([
            'success' => true,
            'menu' => $menu,
        ]);
    }

    // ----------------------usefullinkscontentupdate------------------



}
