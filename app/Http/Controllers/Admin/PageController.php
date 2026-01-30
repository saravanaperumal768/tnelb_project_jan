<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tnelb_ContactDetails;
use App\Models\Admin\Tnelb_Footerbottom;
use App\Models\Admin\Tnelb_Footercopyright;
use App\Models\Admin\Tnelb_Quicklinks;
use App\Models\Admin\Tnelb_submenus;
use App\Models\Admin\Tnelb_Usefullinks;
use App\Models\Admin\TnelbMenu;
use App\Models\Admin\TnelbMenuPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $updatedBy;

    public function __construct()
    {
        // Ensure user is authenticated before accessing
        $this->middleware(function ($request, $next) {
            $this->updatedBy = Auth::user()->name ?? 'System';
            return $next($request);
        });
    }

    public function index($slug_id)
    {

        // $menus = TnelbMenu::where('id', $slug_id)->get();

        $menu = TnelbMenu::with('menuPage')
            ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END")
            ->orderBy('updated_at', 'desc')
            ->where('id', $slug_id)
            ->first();

        return view('admincms.pagescontent.index', compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subpageshow($slug_id)
    {
        $submenu = Tnelb_submenus::with('submenuPage')
            ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END")
            ->orderBy('updated_at', 'desc')
            ->where('id', $slug_id)
            ->first();

        return view('admincms.pagescontent.subpagecontent', compact('submenu'));
    }


    // --------------------Contact details---------------

    public function contactdetails()
    {

        $contact = Tnelb_ContactDetails::first();
        return view('admincms.footerlinks.contactdetails.index', compact('contact'));
    }

    public function updatecontact(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mobilenumber' => 'required|string|max:20',
            'address' => 'required|string',
          
        ]);

        // $contact = Tnelb_ContactDetails::findOrFail($request->id); // or use `first()` if needed

        $contact = Tnelb_ContactDetails::findOrFail(1);

        $contact->update([
            'email' => $request->email,
            'mobilenumber' => $request->mobilenumber,
            'address' => $request->address,
            'updated_by' => $this->updatedBy,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Contact details updated successfully.']);
    }


    // -------------------Quicklinks------------------------------------
    public function quicklinksshow()
    {

        $quicklinks = Tnelb_Quicklinks::with('menuPage')->orderby('updated_at', 'desc')->get();
        return view('admincms.footerlinks.quicklinks.index', compact('quicklinks'));
    }
    // ---------------------------

    public function showquicklinksContent($id)
    {
        $menu = Tnelb_Quicklinks::with('menuPage')->findOrFail($id);

        // $menus = TnelbMenu::with('menuPage')
        // ->orderByRaw("CASE WHEN status = 1 THEN 0 ELSE 1 END")
        // ->orderBy('updated_at', 'desc')
        // ->get();

        // Show the page with content
        return view('admincms.footerlinks.quicklinks.quicklinkscontent', compact('menu'));
    }

    // ------------------------------------------


    public function updatequicklinkcontent(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_quicklinks,id',
        ]);

        $menuPage = TnelbMenuPage::firstOrNew([
            'footer_quicklinks_id' => $request->id,
        ]);

        if ($request->has('link_content_en')) {
            $menuPage->menucontent = $request->link_content_en;
        }

        if ($request->has('link_content_ta')) {
            $menuPage->menucontent_ta = $request->link_content_ta;
        }
        $menuPage->updated_by = $this->updatedBy;
        // $menuPage->updated_by;
        $menuPage->save();

        return response()->json([
            'success' => true,
            'message' => 'Quicklinks content updated successfully.'
        ]);
    }

    // ----------------------------------------------usefullinks
    public function usefullinks()
    {

        $usefullinks = Tnelb_Usefullinks::with('menuPage')->orderby('updated_at', 'desc')->get();
        return view('admincms.footerlinks.usefullinks.index', compact('usefullinks'));
    }



    public function insertusefullinks(Request $request)
    {
        $lastOrderId = Tnelb_Usefullinks::max('order_id');
        $nextOrderId = $lastOrderId ? $lastOrderId + 1 : 1;

        $usefullinksId = Tnelb_Usefullinks::max('order_id');
        $usefullinksOrderId = $usefullinksId ? $usefullinksId + 1 : 1;

        $existing = Tnelb_Usefullinks::where('order_id', $request->order_id)->first();
        if ($existing) {
            return response()->json([
                'success' => false,
                'errors' => ['order_id' => ['Order ID already exists!']],
            ], 422);
        }

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
            $uploadPath = public_path('portaladmin/pdf_usefullinks');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $pdf_en_file = $request->file('pdf_en');
                $pdf_en_name = time() . '_en.' . $pdf_en_file->getClientOriginalExtension();
                $pdf_en_file->move($uploadPath, $pdf_en_name);
                $pdf_en_path = 'portaladmin/pdf_usefullinks/' . $pdf_en_name;
            }

            if ($request->hasFile('pdf_ta')) {
                $pdf_ta_file = $request->file('pdf_ta');
                $pdf_ta_name = time() . '_ta.' . $pdf_ta_file->getClientOriginalExtension();
                $pdf_ta_file->move($uploadPath, $pdf_ta_name);
                $pdf_ta_path = 'portaladmin/pdf_usefullinks/' . $pdf_ta_name;
            }
        }

        $updatedBy = Auth::user()->name;


        // Store in tnelb_menus
        $usefullinks = Tnelb_Usefullinks::create([
            'menu_name_en'       => $request->menu_name_en,
            'menu_name_ta'       => $request->menu_name_ta,
            'page_type'          => $request->page_type,
            'status'             => $request->status ?? 1,
            'order_id'           => $nextOrderId,
            'updated_by'         => $this->updatedBy,
        ]);


        // dd($usefullinks);
        // exit;

        // Store in tnelb_menu_pages
        TnelbMenuPage::create([
            'usefullinks_id'              => $usefullinks->id,

            'page_url'             => $request->page_type === 'Static Page' ? $request->page_url : null,
            'page_url_ta'          => $request->page_type === 'Static Page' ? $request->page_url_ta : null,
            'pdf_en'               => $pdf_en_path,
            'pdf_ta'               => $pdf_ta_path,
            'external_url'         => $request->page_type === 'url' ? $request->external_url : null,
            'updated_by'           => $this->updatedBy,
            'page_type'            => $request->page_type,
            'status'               => $request->status ?? 1,
        ]);


        $usefullinks->load('menuPage');

        return response()->json([
            'success' => true,
            'message' => 'Useful Links Added successfully!',
            'data'    => $usefullinks
        ]);
    }


    // -------------------------------------

    public function updatelinks(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_usefullinks,id',
            'status' => 'required',
        ]);

        $updatedBy = Auth::user()->name;
        $link = Tnelb_Usefullinks::findOrFail($request->id);

        // Check for duplicate order_id
        if ($request->filled('order_id')) {
            $existing = Tnelb_Usefullinks::where('order_id', $request->order_id)
                ->where('id', '!=', $request->id)
                ->first();

            if ($existing && !$request->has('force_replace')) {
                return response()->json([
                    'conflict' => true,
                    'message' => "Order number '{$request->order_id}' already exists and is used by: " . ($existing->menu_name_en ?? 'Untitled'),
                ]);
            }

            if ($existing && $request->has('force_replace')) {
                $existing->order_id = null;
                $existing->save();
            }

            $link->order_id = $request->order_id;
        }

        $link->menu_name_en = $request->menu_name_en;
        $link->menu_name_ta = $request->menu_name_ta;
        $link->status = $request->status;
        $link->page_type = $request->page_type;
        $link->updated_by = $this->updatedBy;
        $link->save();

        $page = $link->menuPage ?: new TnelbMenuPage();
        $page->usefullinks_id = $link->id;

        if ($request->page_type === 'Static Page') {
            $page->page_url = $request->page_url;
            $page->page_url_ta = $request->page_url_ta;
        } elseif ($request->page_type === 'url') {
            $page->external_url = $request->external_url;
        }

        if ($request->hasFile('pdf_en')) {
            $page->pdf_en = $request->file('pdf_en')->store('pdfs');
        }

        if ($request->hasFile('pdf_ta')) {
            $page->pdf_ta = $request->file('pdf_ta')->store('pdfs');
        }

        $page->updated_by = $this->updatedBy;
        $page->save();

        return response()->json([
            'success' => true,
            'menu' => [
                'id' => $link->id,
                'menu_name_en' => $link->menu_name_en,
                'menu_name_ta' => $link->menu_name_ta,
                'order_id' => $link->order_id,
                'status' => $link->status,
                'page_type' => $link->page_type,
                'menu_page' => [
                    'page_url' => $page->page_url,
                    'page_url_ta' => $page->page_url_ta,
                    'external_url' => $page->external_url,
                    'pdf_en' => $page->pdf_en,
                    'pdf_ta' => $page->pdf_ta,
                ],
            ]
        ]);
    }

    public function usefullinkscontent($id)
    {
        $usefullink = Tnelb_Usefullinks::with('menuPage')->findOrFail($id);


        return view('admincms.footerlinks.usefullinks.usefullinkscontent', compact('usefullink'));
    }

    // -------------------------------------------------

    public function updateusefullinkscontent(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_usefullinks,id',
        ]);

        $menuPage = TnelbMenuPage::firstOrNew([
            'usefullinks_id' => $request->id,
        ]);



        if ($request->has('menucontent')) {
            $menuPage->menucontent = $request->menucontent;
        }

        if ($request->has('menucontent_ta')) {
            $menuPage->menucontent_ta = $request->menucontent_ta;
        }
        $updatedBy = Auth::user()->name;
        $menuPage->updated_by = $this->updatedBy;
        $menuPage->save();

        return response()->json([
            'success' => true,
            'message' => 'Useful Links content updated successfully.'
        ]);
    }


    // ----------------------------------footerbottom--------------

    public function footerbottom()
    {

        $footerbottoms = Tnelb_Footerbottom::with('menuPage')->orderby('updated_at', 'desc')->get();
        $footercopyrights = Tnelb_Footercopyright::first();

        return view('admincms.footerlinks.footerbottom.index', compact('footerbottoms', 'footercopyrights'));
    }

    // ---------------------------------------------------


    public function insertfooterbottomlinks(Request $request)
    {
        $lastOrderId = Tnelb_Footerbottom::max('order_id');
        $nextOrderId = $lastOrderId ? $lastOrderId + 1 : 1;

        $usefullinksId = Tnelb_Footerbottom::max('order_id');
        $usefullinksOrderId = $usefullinksId ? $usefullinksId + 1 : 1;

        $existing = Tnelb_Footerbottom::where('order_id', $request->order_id)->first();
        if ($existing) {
            return response()->json([
                'success' => false,
                'errors' => ['order_id' => ['Order ID already exists!']],
            ], 422);
        }

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
            $uploadPath = public_path('portaladmin/pdf_usefullinks');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $pdf_en_file = $request->file('pdf_en');
                $pdf_en_name = time() . '_en.' . $pdf_en_file->getClientOriginalExtension();
                $pdf_en_file->move($uploadPath, $pdf_en_name);
                $pdf_en_path = 'portaladmin/pdf_usefullinks/' . $pdf_en_name;
            }

            if ($request->hasFile('pdf_ta')) {
                $pdf_ta_file = $request->file('pdf_ta');
                $pdf_ta_name = time() . '_ta.' . $pdf_ta_file->getClientOriginalExtension();
                $pdf_ta_file->move($uploadPath, $pdf_ta_name);
                $pdf_ta_path = 'portaladmin/pdf_usefullinks/' . $pdf_ta_name;
            }
        }

        $updatedBy = Auth::user()->name;


        // Store in tnelb_menus
        $footerbottom = Tnelb_Footerbottom::create([
            'menu_name_en'       => $request->menu_name_en,
            'menu_name_ta'       => $request->menu_name_ta,
            'page_type'          => $request->page_type,
            'status'             => $request->status ?? 1,
            'order_id'           => $nextOrderId,
            'updated_by'         => $this->updatedBy,
        ]);


        // dd($usefullinks);
        // exit;

        // Store in tnelb_menu_pages
        TnelbMenuPage::create([
            'footer_bottom_id'     => $footerbottom->id,
            'page_url'             => $request->page_type === 'Static Page' ? $request->page_url : null,
            'page_url_ta'          => $request->page_type === 'Static Page' ? $request->page_url_ta : null,
            'pdf_en'               => $pdf_en_path,
            'pdf_ta'               => $pdf_ta_path,
            'external_url'         => $request->page_type === 'url' ? $request->external_url : null,
            'updated_by'           => $this->updatedBy,
            'page_type'            => $request->page_type,
            'status'               => $request->status ?? 1,
        ]);


        $footerbottom->load('menuPage');

        return response()->json([
            'success' => true,
            'message' => 'FooterBottom Links Added successfully!',
            'data'    => $footerbottom
        ]);
    }
    // --------------------------------------------------edit footer bottom------------------

    public function updatebottomlinks(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_usefullinks,id',
            'status' => 'required',
        ]);

        $updatedBy = Auth::user()->name;
        $link = Tnelb_Footerbottom::findOrFail($request->id);

        // Check for duplicate order_id
        if ($request->filled('order_id')) {
            $existing = Tnelb_Footerbottom::where('order_id', $request->order_id)
                ->where('id', '!=', $request->id)
                ->first();

            if ($existing && !$request->has('force_replace')) {
                return response()->json([
                    'conflict' => true,
                    'message' => "Order number '{$request->order_id}' already exists and is used by: " . ($existing->menu_name_en ?? 'Untitled'),
                ]);
            }

            if ($existing && $request->has('force_replace')) {
                $existing->order_id = null;
                $existing->save();
            }

            $link->order_id = $request->order_id;
        }

        $link->menu_name_en = $request->menu_name_en;
        $link->menu_name_ta = $request->menu_name_ta;
        $link->status = $request->status;
        $link->page_type = $request->page_type;
        $link->updated_by = $this->updatedBy;
        $link->save();

        $page = $link->menuPage ?: new TnelbMenuPage();
        $page->usefullinks_id = $link->id;

        if ($request->page_type === 'Static Page') {
            $page->page_url = $request->page_url;
            $page->page_url_ta = $request->page_url_ta;
        } elseif ($request->page_type === 'url') {
            $page->external_url = $request->external_url;
        }

        if ($request->hasFile('pdf_en')) {
            $page->pdf_en = $request->file('pdf_en')->store('pdfs');
        }

        if ($request->hasFile('pdf_ta')) {
            $page->pdf_ta = $request->file('pdf_ta')->store('pdfs');
        }

        $page->updated_by = $this->updatedBy;
        $page->save();

        return response()->json([
            'success' => true,
            'menu' => [
                'id' => $link->id,
                'menu_name_en' => $link->menu_name_en,
                'menu_name_ta' => $link->menu_name_ta,
                'order_id' => $link->order_id,
                'status' => $link->status,
                'page_type' => $link->page_type,
                'menu_page' => [
                    'page_url' => $page->page_url,
                    'page_url_ta' => $page->page_url_ta,
                    'external_url' => $page->external_url,
                    'pdf_en' => $page->pdf_en,
                    'pdf_ta' => $page->pdf_ta,
                ],
            ]
        ]);
    }

    // ----------------------------footerbottomcontent------------------------

    public function footerbottomcontent($id)
    {
        $footerbottom = Tnelb_Footerbottom::with('menuPage')->findOrFail($id);



        return view('admincms.footerlinks.footerbottom.footerbottomcontent', compact('footerbottom'));
    }

    // --------------------------------
    public function updatefootercontent(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:tnelb_footerbottoms,id',
        ]);

        $menuPage = TnelbMenuPage::firstOrNew([
            'footer_bottom_id' => $request->id,
        ]);



        if ($request->has('menucontent')) {
            $menuPage->menucontent = $request->menucontent;
        }

        if ($request->has('menucontent_ta')) {
            $menuPage->menucontent_ta = $request->menucontent_ta;
        }
        $updatedBy = Auth::user()->name;
        $menuPage->updated_by = $this->updatedBy;
        $menuPage->save();

        return response()->json([
            'success' => true,
            'message' => 'Footer Bottom Links content updated successfully.'
        ]);
    }

    // ---------------------copyrights content ----------------
    public function updatecopyrights(Request $request)
    {
        $request->validate([
            'copyrights_en' => 'nullable|string',
            'copyrights_ta' => 'nullable|string',
        ]);

        $footer = Tnelb_Footercopyright::first();

        if (!$footer) {
            $footer = new Tnelb_Footercopyright();
        }

        $updatedBy = Auth::user()->name;

        if ($request->filled('copyrights_en')) {
            $footer->copyrights_en = $request->copyrights_en;
            $footer->updated_by = $this->updatedBy;
        }

        if ($request->filled('copyrights_ta')) {
            $footer->copyrights_ta = $request->copyrights_ta;
            $footer->updated_by = $this->updatedBy;
        }

        $footer->save();

        return response()->json(['message' => 'Footer updated successfully.']);
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
