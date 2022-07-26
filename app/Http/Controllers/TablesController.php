<?php

namespace App\Http\Controllers;

use App\Invoices;
use App\SavedInvoices;
use Illuminate\Http\Request;
use App\TablesModal;
use App\Unit;

class TablesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }
    public function index()
    {
        $tables = TablesModal::paginate(10);
        return view('Tables.index')->with('tables', $tables);
    }


    public function create()
    {
        return view('Tables.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'numTable' => 'required|unique:tables,numTable'
        ]);
        $id = 1;
        $tables = TablesModal::all()->last();
        if ($tables) {
            $id = $tables->id + 1;
        }
        $table = TablesModal::create([
            'id' => $id,
            'numTable' => $request->numTable
        ]);
        if ($table) {
            return redirect()->route('tables.index');
        } else {
            return redirect()->back();
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $table = TablesModal::find($id);
        return view('Tables.edit')->with('table', $table);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'numTable' => 'required'
        ]);

        $table = TablesModal::find($id);
        $invoices = Invoices::where('tab', $table->numTable)->get();
        if(count($invoices) == 0){
            $table->numTable = $request->numTable;
            $table->save();
            return redirect()->route('tables.index')->with('msg', "Updated Successfully");
        }
        else {
            return redirect()->route('tables.index')->with('msg', "لا يمكن تعديل اسم الطاولة لارتباطها بحركات");
        }

    }


    public function destroy($id)
    {
        $tableCheck = TablesModal::find($id);

        $invoices = Invoices::where('tab', $tableCheck->numTable)->get();

        if(count($invoices) == 0){
            $table = TablesModal::find($id);
            $table->delete();
            return redirect()->route('tables.index')->with('msg', "Delete Successfully");
        }else {
            return redirect()->route('tables.index')->with('msg', "لا يمكن حذف الطاولة لارتباطها بحركات");
        }

    }



    public function getDelevery()
    {
        $invoices = Invoices::where('status_type', 4)->where('status', '=', 4)->get();
        return response()->json([
            'Orders' => $invoices
        ]);
    }

    public function getDeleveryById($id)
    {
        $invoice = Invoices::find($id);
        $list = SavedInvoices::where('invoiceId', $id)->get();
        $list->each(function ($el) {
            $el->unit_name = Unit::find($el->unit_id)->namear;
        });
        return response()->json([
            'invoice' => $invoice,
            'list' => $list,
        ]);
    }
}
