<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tnelb_Mst_Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
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
    public function home()
    {

        $media = Tnelb_Mst_Media::where('status', '1')->orderby('updated_at', 'Desc')->get();
        // $media = Tnelb_Mst_Media::all();

        return view('admincms.media.index', compact('media'));
    }

    public function insertmedia(Request $request)
    {
        $request->validate([
            'type' => 'required|in:image,pdf',
            'title_en' => 'required|string|max:255',
            'title_ta' => 'required|string|max:255',
            'alt_text_en' => 'required|string|max:255',
            'alt_text_ta' => 'required|string|max:255',
            'filepath_img_pdf' => 'required|file|max:250',
        ]);

        if ($request->hasFile('filepath_img_pdf')) {
            $file = $request->file('filepath_img_pdf');
            $ext = $file->getClientOriginalExtension();

            if ($request->type == 'pdf' && $ext != 'pdf') {
                return response()->json(['error' => 'Only PDF allowed'], 422);
            }

            if ($request->type == 'image' && !in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return response()->json(['error' => 'Only image formats allowed'], 422);
            }

            $filename = time() . '_' . uniqid() . '.' . $ext;
            $file->move(public_path('portaladmin/media'), $filename);
            $path = 'portaladmin/media/' . $filename; // ✅ This will be used in the asset() helper
        } else {
            return response()->json(['error' => 'No file uploaded'], 422);
        }

        $insertmedia = Tnelb_Mst_Media::create([
            'type' => $request->type,
            'title_en' => $request->title_en,
            'title_ta' => $request->title_ta,
            'alt_text_en' => $request->alt_text_en,
            'alt_text_ta' => $request->alt_text_ta,
            'filepath_img_pdf' => $path,
            'created_by' => $this->updatedBy,
            'updated_by' => $this->updatedBy,
            'status' => 1,
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'media' => $insertmedia
        ]);
    }

    public function softDelete($id)
    {
        $media = Tnelb_Mst_Media::findOrFail($id);
        $media->status = 0;
        $media->save();

        return response()->json(['success' => true]);
    }

    // -----------------update---------------

   public function updatemedia(Request $request)
{
    $validated = $request->validate([
        'id' => 'required|exists:tnelb_mst_media,id',
        'title_en' => 'required|string|max:255',
        'title_ta' => 'required|string|max:255',
        'alt_text_en' => 'required|string|max:255',
        'alt_text_ta' => 'required|string|max:255',
        'type' => 'required|in:image,pdf',
       
    ]);

    $media = Tnelb_Mst_Media::findOrFail($validated['id']);

    // If a file is uploaded, validate its type
    if ($request->hasFile('filepath_img_pdf')) {
        $file = $request->file('filepath_img_pdf');
        $ext = $file->getClientOriginalExtension();

        if ($validated['type'] === 'pdf' && $ext !== 'pdf') {
            return response()->json(['status' => 'error', 'message' => 'Only PDF files are allowed for type PDF'], 422);
        }

        if ($validated['type'] === 'image' && !in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return response()->json(['status' => 'error', 'message' => 'Only image formats are allowed for type Image'], 422);
        }

        $filename = time() . '_' . uniqid() . '.' . $ext;
        $file->move(public_path('portaladmin/media'), $filename);
        $media->filepath_img_pdf = 'portaladmin/media/' . $filename;
    }

    // Update text fields
    $media->title_en = $validated['title_en'];
    $media->title_ta = $validated['title_ta'];
    $media->alt_text_en = $validated['alt_text_en'];
    $media->alt_text_ta = $validated['alt_text_ta'];
    $media->type = $validated['type'];
    $media->updated_by = $this->updatedBy;
    $media->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Media updated successfully',
        'media' => [
            'id' => $media->id,
            'title_en' => $media->title_en,
            'title_ta' => $media->title_ta,
            'alt_text_en' => $media->alt_text_en,
            'alt_text_ta' => $media->alt_text_ta,
            'type' => $media->type,
            'path' => asset($media->filepath_img_pdf),
        ]
    ]);
}

}
