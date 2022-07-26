<?php

namespace App\Http\Controllers;

use App\TermsReference;
use Carbon\Carbon;

class TermsReferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }

    public function index()
    {
        $current_date_time = Carbon::now()->toDateTimeString(); // Produces something like "2019-03-11 12:25:00"

        $terms = TermsReference::find(1);
        $terms->experimental = 1;
        $terms->date = $current_date_time;
        $terms->save();
        return redirect()->back()->with('msg', "تم تفعيل النسخة التجريبية لمدة 3 ايام");
    }
}
