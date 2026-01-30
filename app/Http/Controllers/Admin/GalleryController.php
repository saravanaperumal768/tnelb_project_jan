<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tnelb_Gallery;

use App\Models\Admin\Tnelb_Mst_Media;

use App\Models\Admin\Tnelb_Gallerycat;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{

        public function __construct()
    {
        // Ensure user is authenticated before accessing
        $this->middleware(function ($request, $next) {
            $this->updatedBy = Auth::user()->name ?? 'System';
            return $next($request);
        });
    }
    public function index()
    {

        // $gallery = Tnelb_Gallery::with('media', 'category')->orderBy('updated_at', 'desc')->get();

        $gallery = Tnelb_Gallery::with(['media', 'category'])
        // ->where('status', '1')
        ->orderBy('updated_at', 'desc')
        ->get()
        ->groupBy('category_id');

        $media = Tnelb_Mst_Media::where([
            ['status', '=', '1'],
            ['type', '=', 'image']
        ])->orderBy('updated_at', 'desc')->get();
     

    $categories = Tnelb_Gallerycat::all();

    $media = Tnelb_Mst_Media::where([
        ['status', '=', '1'],
        ['type', '=', 'image']
    ])->orderBy('updated_at', 'desc')->get();

    return view('admincms.gallery.index', compact('gallery', 'categories', 'media'));
    }


    // -----gallery catname insert---------------

public function catnameinsert(Request $request)
{
    $request->validate([
        'catname' => 'required|string|max:255',
    ]);

    // Convert input to uppercase for consistent matching
    $catname = strtoupper($request->catname);

    // Check if already exists in DB
    $exists = Tnelb_Gallerycat::whereRaw('UPPER(catname) = ?', [$catname])->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'errors' => ['catname' => 'This Category already exists.'],
        ], 422); // 422 Unprocessable Entity for validation errors
    }

    // Save new category
    $category = new Tnelb_Gallerycat();
    $category->catname = $catname;
    $category->updatedby = $this->updatedBy;
    $category->createdby = $this->updatedBy;
    $category->save();

    return response()->json([
        'success' => true,
        'message' => 'Gallery Category added successfully!',
        'data' => $category
    ]);
}

// -----------------imageinsert---------------------

 public function insertimage(Request $request)
    {
        // dd($request->all());
        // exit;
        $request->validate([
            'category_id'  => 'required|integer',
            'imagetitle'   => 'required|string|max:255',
            'gallery_image'=> 'required|string', // coming as ID or path
      
        ]);

        $gallery = Tnelb_Gallery::create([
            'category_id' => $request->category_id,
            'imagetitle'  => strtoupper($request->imagetitle), // save in uppercase if needed
            'image'       => $request->gallery_image, // this will be image ID or path
            'status'      => 1,
            'updatedby'   => $this->updatedBy,
        ]);
          $gallery->load(['media', 'category']);
        return response()->json([
            'success' => true,
            'message' => 'Gallery Image Added Successfully!',
            'data'    => $gallery
        ]);
    }


    // public function imageupload(Request $request)
    // {
    //     $request->validate([
    //         'imagetitle' => 'required|string|max:255',
    //         'image' => 'required|image|max:2048',
    //     ]);



    //     $file = $request->file('image');
    //     $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //     $file->move(public_path('portaladmin/gallery'), $filename);

    //     Tnelb_Gallery::create([
    //         'imagetitle' => $request->imagetitle,
    //         'image' => $filename,

    //         'updatedby' => $request->updatedby,
    //     ]);

    //     return response()->json([
    //         'message' => 'Image uploaded successfully',
    //         'image' => [
    //             'imagetitle' => $request->imagetitle,
    //             'image' => $filename,
    //         ]
    //     ]);
    // }

    public function showImage($id)
    {
        $image = Tnelb_Gallery::findOrFail($id);

        return response($image->image)
            ->header('Content-Type', 'image/jpeg'); // or use $image->mimetype if stored
    }


    public function update(Request $request, $id)
    {
        $gallery = Tnelb_Gallery::findOrFail($id);
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('portaladmin/gallery'), $imageName);
    
            if ($gallery->image && file_exists(public_path('portaladmin/gallery/' . $gallery->image))) {
                unlink(public_path('portaladmin/gallery/' . $gallery->image));
            }
    
            $gallery->image = $imageName;
        }
    
        if ($request->has('imagetitle')) {
            $gallery->imagetitle = $request->input('imagetitle');
        }
    
        $gallery->save();
    
        return response()->json([
            'success' => true,
            'image' => $gallery->image,
            'imagetitle' => $gallery->imagetitle
        ]);
    }
    

    public function softDelete($id)
    {
        $gallery = Tnelb_Gallery::findOrFail($id);
        $gallery->status = 0;
        $gallery->save();

        return response()->json(['success' => true]);
    }
}
