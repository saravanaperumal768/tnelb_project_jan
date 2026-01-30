<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tnelb_Newsboard;
use App\Models\Admin\Tnelb_Whatsnew;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
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
    public function index()
    {
        $newsboard = Tnelb_Newsboard::orderBy('updated_at', 'desc')->get();
        return view('admincms.newsboard.index', compact('newsboard'));
        // return view('admincms.newsboard.index');
    }
    // --------------------------insert------------------------
    public function insert(Request $request)
    {
        $request->validate([
            'subject_en'    => 'required|string',
            'subject_ta'    => 'required|string',
            'startdate'     => 'required|date',
            'enddate'       => 'required|date|after_or_equal:startdate',
            'content_type'  => 'required|in:Static Page,url,pdf',
            'pdf_en'        => 'nullable|mimes:pdf',
            'pdf_ta'        => 'nullable|mimes:pdf',
            'external_url'  => 'nullable|url',
        ]);

        $data = $request->only([
            'subject_en',
            'subject_ta',
            'startdate',
            'enddate',
            'content_type',
            'external_url'
        ]);

        $data['status'] = '1';
        $data['updated_by'] = $this->updatedBy;
        $data['page_type'] = $request->content_type;

        if ($request->content_type === 'pdf') {
            $uploadPath = public_path('portaladmin/pdf_noticeboard');

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $pdf_en_file = $request->file('pdf_en');
                $pdf_en_name = time() . '_en.' . $pdf_en_file->getClientOriginalExtension();
                $pdf_en_file->move($uploadPath, $pdf_en_name);
                $data['pdf_en'] = 'portaladmin/pdf_noticeboard/' . $pdf_en_name;
            }

            if ($request->hasFile('pdf_ta')) {
                $pdf_ta_file = $request->file('pdf_ta');
                $pdf_ta_name = time() . '_ta.' . $pdf_ta_file->getClientOriginalExtension();
                $pdf_ta_file->move($uploadPath, $pdf_ta_name);
                $data['pdf_ta'] = 'portaladmin/pdf_noticeboard/' . $pdf_ta_name;
            }
        }

        // Clear PDF & URL if not relevant (cleanup)
        if ($request->content_type === 'url') {
            $data['pdf_en'] = null;
            $data['pdf_ta'] = null;
        }

        if ($request->content_type === 'Static Page') {
            $data['pdf_en'] = null;
            $data['pdf_ta'] = null;
            $data['external_url'] = null;
        }

        $created = \App\Models\Admin\Tnelb_Newsboard::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Newsboard notice added successfully.',
            'data' => $created
        ]);
    }



    // --------------------------------------------








    public function updatetamil(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'heading' => 'required|string',
            'newsboard_ta' => 'required|string',
        ]);

        $newsboard = Tnelb_Newsboard::findOrFail($request->id);
        $newsboard->heading = $request->heading;
        $newsboard->newsboard_ta = $request->newsboard_ta;

        $newsboard->save();

        return response()->json(['message' => 'News board updated successfully']);
    }

    public function whatsnew()
    {
        $whatsnew = Tnelb_Whatsnew::orderBy('updated_at', 'desc')->get();
        return view('admincms.whatsnew.index', compact('whatsnew'));
        // return view('admincms.whatsnew.index');
    }

    public function updateWhatsNew(Request $request)
    {
        $id = $request->input('id');
        $item = Tnelb_Whatsnew::find($id);

        if (!$item) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        }

        if ($request->has('whatsnew_en')) {
            $item->whatsnew_en = $request->input('whatsnew_en');
        }

        if ($request->has('whatsnew_ta')) {
            $item->whatsnew_ta = $request->input('whatsnew_ta');
        }

        if ($request->has('status')) {
            $item->status = $request->input('status');
        }

        $item->save();

        return response()->json(['status' => 'success']);
    }



    // -----------------whatsnew--------------------------------
    public function insertscrolling(Request $request)
    {
        $request->validate([

            'subject_en' => 'required|string',
            'subject_ta' => 'required|string',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after_or_equal:startdate',
            'content_type' => 'required|in:url,pdf',
            'pdf_en' => 'nullable|mimes:pdf',
            'pdf_ta' => 'nullable|mimes:pdf',
            'external_url' => 'nullable|url',
        ]);

        $data = $request->only([
            'subject_en',
            'subject_ta',
            'startdate',
            'enddate',
            'content_type',
            'external_url'
        ]);
        $data['status'] = '1';
        $data['updated_by'] = $this->updatedBy;
        $data['page_type'] = $request->content_type;
        if ($request->content_type === 'pdf') {
            $uploadPath = public_path('portaladmin/pdf_whatsnew');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if ($request->hasFile('pdf_en')) {
                $pdfEn = $request->file('pdf_en');
                $pdfEnName = time() . '_en.' . $pdfEn->getClientOriginalExtension();
                $pdfEn->move($uploadPath, $pdfEnName);
                $data['pdf_en'] = 'portaladmin/pdf_whatsnew/' . $pdfEnName;
            }

            if ($request->hasFile('pdf_ta')) {
                $pdfTa = $request->file('pdf_ta');
                $pdfTaName = time() . '_ta.' . $pdfTa->getClientOriginalExtension();
                $pdfTa->move($uploadPath, $pdfTaName);
                $data['pdf_ta'] = 'portaladmin/pdf_whatsnew/' . $pdfTaName;
            }
        }

        $news = Tnelb_Whatsnew::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Scroll Message added successfully!',
            'data' => $news
        ]);
    }

    // -----------------------------------------------

    public function showboardContent($id)
    {
        $board = Tnelb_Newsboard::findOrFail($id);


        return view('admincms.newsboard.noticeboardcontent', compact('board'));
    }

    // --------------------------------content board -------------------------
    public function updateboard(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tnelb_newsboards,id',
            'subject_en' => 'nullable|string',
            'subject_ta' => 'nullable|string',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'content_type' => 'nullable|string',
         
            'external_url' => 'nullable|string',
            'pdf_en' => 'nullable|file|mimes:pdf',
            'pdf_ta' => 'nullable|file|mimes:pdf',
        ]);

        $news = Tnelb_Newsboard::findOrFail($request->id);

        $news->subject_en = $request->subject_en;
        $news->subject_ta = $request->subject_ta;
        $news->startdate = $request->startdate;
        $news->enddate = $request->enddate;
        $news->page_type = $request->content_type;
        $news->external_url = $request->external_url;
        $news->updated_by = $this->updatedBy;

        $uploadPath = public_path('portaladmin/pdf_whatsnew');
        // Handle file uploads
        if ($request->hasFile('pdf_en')) {
            $pdfEn = $request->file('pdf_en');
            $pdfEnName = time() . '_en.' . $pdfEn->getClientOriginalExtension();
            $pdfEn->move($uploadPath, $pdfEnName);
            $data['pdf_en'] = 'portaladmin/pdf_whatsnew/' . $pdfEnName;
        }

        if ($request->hasFile('pdf_ta')) {
            $pdfTa = $request->file('pdf_ta');
            $pdfTaName = time() . '_ta.' . $pdfTa->getClientOriginalExtension();
            $pdfTa->move($uploadPath, $pdfTaName);
            $data['pdf_ta'] = 'portaladmin/pdf_whatsnew/' . $pdfTaName;
        }

        $news->save();

        return response()->json([
            'success' => true,
            'message' => 'Noticeboard updated successfully',
            'data' => $news
        ]);
    }


    // -----------------------scroll baord edit--------------------

    public function updatescrollboard(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tnelb_whatsnew,id',
            'subject_en' => 'nullable|string',
            'subject_ta' => 'nullable|string',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'content_type' => 'nullable|string',
         
            'external_url' => 'nullable|string',
            'pdf_en' => 'nullable|file|mimes:pdf',
            'pdf_ta' => 'nullable|file|mimes:pdf',
        ]);

        $news = Tnelb_Whatsnew::findOrFail($request->id);

        $news->subject_en = $request->subject_en;
        $news->subject_ta = $request->subject_ta;
        $news->startdate = $request->startdate;
        $news->enddate = $request->enddate;
        $news->page_type = $request->content_type;
        $news->external_url = $request->external_url;
        $news->updated_by = $this->updatedBy;

         $uploadPath = public_path('portaladmin/pdf_whatsnew');
        // Handle file uploads
        if ($request->hasFile('pdf_en')) {
            $pdfEn = $request->file('pdf_en');
            $pdfEnName = time() . '_en.' . $pdfEn->getClientOriginalExtension();
            $pdfEn->move($uploadPath, $pdfEnName);
            $news->pdf_en = 'portaladmin/pdf_whatsnew/' . $pdfEnName;
        }

        if ($request->hasFile('pdf_ta')) {
            $pdfTa = $request->file('pdf_ta');
            $pdfTaName = time() . '_ta.' . $pdfTa->getClientOriginalExtension();
            $pdfTa->move($uploadPath, $pdfTaName);
            $news->pdf_ta = 'portaladmin/pdf_whatsnew/' . $pdfTaName;
        }

        $news->save();

        return response()->json([
            'success' => true,
            'message' => 'Scroll Board updated successfully',
            'data' => $news
        ]);
    }

    // --------------update newsboard--------------------

    public function updateNewsBoardContent(Request $request)
{
    $request->validate([
        'id' => 'required|exists:tnelb_newsboards,id',
        'newsboardcontent_en' => 'nullable|string',
        'newsboardcontent_ta' => 'nullable|string',
        
    ]);

    $board = Tnelb_Newsboard::findOrFail($request->id);

    if ($request->has('newsboardcontent_en')) {
        $board->newsboardcontent_en = $request->newsboardcontent_en;
    }

    if ($request->has('newsboardcontent_ta')) {
        $board->newsboardcontent_ta = $request->newsboardcontent_ta;
    }

    $board->updated_by = $this->updatedBy;
    $board->save();

    return response()->json([
        'success' => true,
        'message' => 'News board content updated successfully!',
        'data' => $board
    ]);
}

}
