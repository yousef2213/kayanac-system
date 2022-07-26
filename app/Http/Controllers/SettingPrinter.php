<?php

namespace App\Http\Controllers;

use App\Compaines;
use App\PrinterSetting;
use Illuminate\Http\Request;

class SettingPrinter extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }


    public function store(Request $request)
    {
        $company = Compaines::get()->first();
        if ($request->printFront) {
            $company->printFront = 1;
            $company->save();
        } else {
            $company->printFront = 0;
            $company->save();
        }

        $setting = PrinterSetting::first();
        $setting->printkitchen = $request->printkitchen;
        $setting->printcasher = $request->printcasher;

        if ($request->print_qr) {
            $setting->print_qr = 1;
            $setting->save();
        } else {
            $setting->print_qr = 0;
            $setting->save();
        }
        // $setting->printReports = $request->printReports;
        $setting->save();
        if ($setting) {
            request()->session()->flash('success', 'Successfully Edit');
        } else {
            request()->session()->flash('error', 'Error occurred while adding item');
        }
        return redirect()->route('printer.setting');
    }
}
