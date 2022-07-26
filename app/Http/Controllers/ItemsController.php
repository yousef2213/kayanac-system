<?php

namespace App\Http\Controllers;

use App\CategoryItems;
use App\Imports\MohsenImport;
use App\Items;
use App\Itemslist;
use App\OrderPages;
use App\Powers;
use App\SavedInvoices;
use App\Unit;
use Illuminate\Http\Request;
use DB;
use Excel;
use Illuminate\Support\Facades\Auth;


class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('active_permision');
        $this->middleware('auth');
    }

    public function index()
    {
        $this->middleware('permision:TsItems');
        $items = Items::all();
        $itemsList = Itemslist::all();
        $items->each(function ($item) {
            $details = Itemslist::where('itemId', $item->id)->first();
            if ($details) {
                $item->barcodee = Itemslist::where('itemId', $item->id)->first()->barcode;
            } else {
                $item->barcodee;
            }
        });

        $categorys = CategoryItems::all();
        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsItems" )->first();
        if(!$orders) {
                $columns = \Schema::getColumnListing('powers');
                $loginUser = Auth::user();
                $data['user_id'] = $loginUser->id;
                $power = Powers::create($data);
                if($loginUser->type == 3){
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            $power[$column] = 1;
                            $power->save();
                        }
                    }
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            OrderPages::create([
                                'user_id' => $loginUser->id,
                                "power_name" => $column,
                                "show" => 1,
                                "add" => 1,
                                "edit" => 1,
                                "delete" => 1,
                            ]);
                        }
                    }
                }
                else {
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            OrderPages::create([
                                'user_id' => $loginUser->id,
                                "power_name" => $column,
                                "show" => 0,
                                "add" => 0,
                                "edit" => 0,
                                "delete" => 0,
                            ]);
                        }
                    }
                }
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsItems" )->first();
        }
        // return $orders;
        return view('Items.index')
            ->with('items', $items)
            ->with('orders', $orders)
            ->with('itemsList', $itemsList)
            ->with('categorys', $categorys);
    }

    public function create()
    {
        $groups = CategoryItems::all();
        $units = Unit::all();
        return view('Items.add')
            ->with('groups', $groups)
            ->with('units', $units);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'namear' => 'string|unique:items|required',
            'group' => 'required',
            'list' => 'required',
        ]);
        $list = json_decode($request->list[0], true);
        $pids = [];
        $total = 0;




        if (count($list) <= 0) {
            return redirect()
                ->back()
                ->with('msg', 'من فضلك اكمل البيانات');
        } else {

            foreach ($list as $item) {
                if (!isset($item['unit_id'])) {
                    return redirect()
                        ->back()
                        ->with('msg', 'من فضلك اكمل بيانات الوحدات');
                }
                if (!isset($item['packing'])) {
                    return redirect()
                        ->back()
                        ->with('msg', 'من فضلك اكمل بيانات التعبئة');
                }
                if (!isset($item['price'])) {
                    return redirect()
                        ->back()
                        ->with('msg', 'من فضلك اكمل بيانات السعر');
                }
            }
            foreach ($list as $h) {
                $sm = 0;
                if (isset($h['small_unit']) && $h['small_unit'] != 'null') {
                    $sm = $h['small_unit'];
                }
                $pids[] = $sm;
            }
            foreach ($pids as $item) {
                $total += $item;
            }
            if ($total > 1) {
                return redirect()
                    ->back()
                    ->with('msg', 'لا يمكن اختيار اصغر وحدة مرتين ');
            }
            $last = Items::all()->last();
            $newId = 1;
            if ($last) {
                $newId = $last->id + 1;
            }
            $status = Items::create([
                'id' => $newId,
                'namear' => $request->namear,
                'nameen' => $request->nameen,
                'code' => $request->code,
                'coding_type' => $request->coding_type,
                'group' => $request->group,
                'catId' => $request->group,
                'priceWithTax' => $request->priceWithTax,
                'item_type' => $request->item_type,
                'description' => $request->description,
            ]);
            if($request->delegateC && $request->delegateC != "") {
                $status->delegateC = $request->delegateC;
                $status->save();
            }

            if ($request->taxRate) {
                $status->taxRate = $request->taxRate;
                $status->save();
            }

            if (count($list) > 0) {
                foreach ($list as $item) {
                    $rate = 0;
                    $value = 0;
                    $total = 0;
                    $small = 0;
                    $barcode = 0;
                    if (isset($item['discount_rate'])) {
                        $rate = $item['discount_rate'];
                    }
                    if (isset($item['discount_value'])) {
                        $value = $item['discount_value'];
                    }
                    if (isset($item['total'])) {
                        $total = $item['total'];
                    }
                    if (isset($item['small_unit'])) {
                        $small = $item['small_unit'];
                    }
                    if (isset($item['barcode'])) {
                        $barcode = $item['barcode'];
                    }
                    Itemslist::create([
                        'itemId' => $status->id,
                        'unitId' => $item['unit_id'],
                        'small_unit' => $small,
                        'packing' => $item['packing'],
                        'barcode' => $barcode,
                        'price1' => $item['price'],
                        'discountRate' => $rate,
                        'discountValue' => $value,
                        'total' => $total,
                    ]);
                }
            }

            $checkList = Itemslist::where('itemId', $status->id)->get();
            if (count($checkList) <= 0) {
                $status->delete();
            }
            if ($request->has('img')) {
                $filenameWithExt = $request->file('img')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('img')->getClientOriginalExtension();
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                $request->file('img')->move(public_path('assets/items'), $fileNameToStore);
                $status->img = $fileNameToStore;
            }
            $status->save();
        }

        return redirect()->route('items.index')->with('msg', 'Successfully added item');
    }

    public function edit($id)
    {
        $item = Items::findOrFail($id);
        $groups = CategoryItems::all();
        $units = Unit::all();
        $itemList = Itemslist::where('itemId', $item->id)->get();
        return view('items.edit')
            ->with('item', $item)
            ->with('groups', $groups)
            ->with('units', $units)
            ->with('list', $itemList);
    }

    public function update(Request $request, $id)
    {
        $list = json_decode($request->list[0], true);
        $this->validate($request, [
            'namear' => 'string|required',
            'group' => 'required',
        ]);

        if (!empty($list)) {
            if (count($list) != 1) {
                foreach ($list as $idx => $item) {
                    if ($idx != 0) {
                        // ****
                        $itemCreator = Itemslist::create();
                        $itemCreator->itemId = $id;
                        $itemCreator->save();
                        if ($item['price1']) {
                            $itemCreator->price1 = $item['price1'];
                            $itemCreator->save();
                        }
                        if ($item['price2']) {
                            $itemCreator->price2 = $item['price2'];
                            $itemCreator->save();
                        }
                        if ($item['price3']) {
                            $itemCreator->price3 = $item['price3'];
                            $itemCreator->save();
                        }
                        if ($item['price4']) {
                            $itemCreator->price4 = $item['price4'];
                            $itemCreator->save();
                        }
                        if ($item['price5']) {
                            $itemCreator->price5 = $item['price5'];
                            $itemCreator->save();
                        }
                        if ($item['unit']) {
                            $itemCreator->unitId = $item['unit'];
                            $itemCreator->save();
                        }
                        // if($item['discountAmount']) {
                        //     $itemCreator->discountAmount = $item['discountAmount'];
                        //     $itemCreator->save();
                        // }
                        if ($item['discountPercentage']) {
                            $itemCreator->discountPercentage = $item['discountPercentage'];
                            $itemCreator->save();
                        }
                        if ($item['priceAfterDiscount']) {
                            $itemCreator->priceAfterDiscount = $item['priceAfterDiscount'];
                            $itemCreator->save();
                        }
                        if ($item['packing']) {
                            $itemCreator->packing = $item['packing'];
                            $itemCreator->save();
                        }
                        if ($item['barcode']) {
                            $itemCreator->barcode = $item['barcode'];
                            $itemCreator->save();
                        }
                        // *****
                    }
                }
            }
        }

        $item = Items::find($id);

        $item->namear = $request->namear;
        $item->nameen = $request->nameen;
        $item->code = $request->code;
        $item->coding_type = $request->coding_type;
        $item->group = $request->group;
        $item->catId = $request->group;
        $item->description = $request->description;
        $item->taxRate = $request->taxRate;
        $item->nature = $request->nature;
        $item->priceWithTax = $request->priceWithTax;
        if ($request->item_type) {
            $item->item_type = $request->item_type;
            $item->save();
        }
        $item->save();

        if ($request->listUpdate) {
            foreach ($request->listUpdate as $item) {
                $itemUpdate = Itemslist::find($item['id']);
                if ($item['price1']) {
                    $itemUpdate->price1 = $item['price1'];
                    $itemUpdate->save();
                }
                if ($item['price2']) {
                    $itemUpdate->price2 = $item['price2'];
                    $itemUpdate->save();
                }
                if ($item['price3']) {
                    $itemUpdate->price3 = $item['price3'];
                    $itemUpdate->save();
                }
                if ($item['price4']) {
                    $itemUpdate->price4 = $item['price4'];
                    $itemUpdate->save();
                }
                if ($item['price5']) {
                    $itemUpdate->price5 = $item['price5'];
                    $itemUpdate->save();
                }
                if ($item['unit']) {
                    $itemUpdate->unitId = $item['unit'];
                    $itemUpdate->save();
                }
                // if($item['discountAmount']) {
                //     $itemUpdate->discountAmount = $item['discountAmount'];
                //     $itemUpdate->save();
                // }
                // if($item['discountPercentage']) {
                //     $itemUpdate->discountPercentage = $item['discountPercentage'];
                //     $itemUpdate->save();
                // }
                // if($item['priceAfterDiscount']) {
                //     $itemUpdate->priceAfterDiscount = $item['priceAfterDiscount'];
                //     $itemUpdate->save();
                // }
                // if($item['packing']) {
                //     $itemUpdate->packing = $item['packing'];
                //     $itemUpdate->save();
                // }
                if ($item['barcode']) {
                    $itemUpdate->barcode = $item['barcode'];
                    $itemUpdate->save();
                }
            }
        }

        if ($request->unit) {
            $itemCreatorSingle = Itemslist::create();
            $itemCreatorSingle->itemId = $id;
            $itemCreatorSingle->save();

            if ($request['price1']) {
                $itemCreatorSingle->price1 = $request['price1'];
                $itemCreatorSingle->save();
            }
            if ($request['price2']) {
                $itemCreatorSingle->price2 = $request['price2'];
                $itemCreatorSingle->save();
            }
            if ($request['price3']) {
                $itemCreatorSingle->price3 = $request['price3'];
                $itemCreatorSingle->save();
            }
            if ($request['price4']) {
                $itemCreatorSingle->price4 = $request['price4'];
                $itemCreatorSingle->save();
            }
            if ($request['price5']) {
                $itemCreatorSingle->price5 = $request['price5'];
                $itemCreatorSingle->save();
            }
            if ($request['unit']) {
                $itemCreatorSingle->unitId = $request['unit'];
                $itemCreatorSingle->save();
            }
            // if($item['discountAmount']) {
            //     $itemCreatorSingle->discountAmount = $request['discountAmount'];
            //     $itemCreatorSingle->save();
            // }
            if ($request['discountPercentage']) {
                $itemCreatorSingle->discountPercentage = $request['discountPercentage'];
                $itemCreatorSingle->save();
            }
            if ($request['priceAfterDiscount']) {
                $itemCreatorSingle->priceAfterDiscount = $request['priceAfterDiscount'];
                $itemCreatorSingle->save();
            }
            if ($request['packing']) {
                $itemCreatorSingle->packing = $request['packing'];
                $itemCreatorSingle->save();
            }
            if ($request['barcode']) {
                $itemCreatorSingle->barcode = $request['barcode'];
                $itemCreatorSingle->save();
            }
        }

        if ($item) {
            request()
                ->session()
                ->flash('success', 'Successfully updated');
        } else {
            request()
                ->session()
                ->flash('error', 'Error occured while updating');
        }
        return redirect()->route('items.index');
    }

    public function deleteItemList(Request $request)
    {
        $item = Itemslist::find($request->id);
        $item->delete();
        return response()->json([
            'status' => 200,
        ]);
    }

    public function categories()
    {
        $categorys = CategoryItems::paginate(10);

        $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsGroupItems" )->first();
        if(!$orders) {
                $columns = \Schema::getColumnListing('powers');
                $loginUser = Auth::user();
                $data['user_id'] = $loginUser->id;
                $power = Powers::create($data);
                if($loginUser->type == 3){
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            $power[$column] = 1;
                            $power->save();
                        }
                    }
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            OrderPages::create([
                                'user_id' => $loginUser->id,
                                "power_name" => $column,
                                "show" => 1,
                                "add" => 1,
                                "edit" => 1,
                                "delete" => 1,
                            ]);
                        }
                    }
                }
                else {
                    foreach ($columns as $column) {
                        if($column != "id" && $column != "user_id"){
                            OrderPages::create([
                                'user_id' => $loginUser->id,
                                "power_name" => $column,
                                "show" => 0,
                                "add" => 0,
                                "edit" => 0,
                                "delete" => 0,
                            ]);
                        }
                    }
                }
                $orders = OrderPages::where('user_id', Auth::user()->id )->where('power_name', "TsGroupItems" )->first();
        }

        return view('Items.indexCategory')->with('orders', $orders)->with('categorys', $categorys);
    }

    public function category()
    {
        $this->middleware('permision:TsGroupItems');
        $groups = CategoryItems::where('main', '=', 1)->get();
        return view('Items.category')->with('groups', $groups);
    }

    public function editCategory($id)
    {
        $item = CategoryItems::findOrFail($id);
        return view('Items.editCat')->with('item', $item);
    }

    public function updateCategory(Request $request, $id)
    {
        $this->validate($request, [
            'namear' => 'string|required',
        ]);

        $item = CategoryItems::findOrFail($id);
        $item->namear = $request->namear;
        $item->nameen = $request->nameen;
        $item->save();
        return redirect()->route('item.index.categories');
    }

    public function AddCategory(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'namear' => 'string|required',
        ]);

        $data = $request->all();
        $data['main'] = $request->group_type;
        $data['main_id'] = $request->group_main;
        $status = CategoryItems::create($data);

        if ($request->has('img')) {
            $filenameWithExt = $request->file('img')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('img')->move(public_path('assets/items'), $fileNameToStore);
            $status->img = $fileNameToStore;
        }
        $status->save();

        if ($status) {
            request()
                ->session()
                ->flash('success', 'User Successfully deleted');
        } else {
            request()
                ->session()
                ->flash('error', 'There is an error while deleting users');
        }
        return redirect()->route('item.index.categories');
    }

    public function deleteCat($id)
    {
        $check = Items::where('group', $id)->first();
        if ($check) {
            return redirect()
                ->back()
                ->with('msg', ' لا يمكن حذف مجموعة الصنف لارتباطها بحركات');
        }
        $delete = CategoryItems::findorFail($id);
        $delete->delete();

        return redirect()
            ->route('item.index.categories')
            ->with('msg', 'تم حذف المجموعة');
    }

    public function destroy($id)
    {
        $delete = Items::findorFail($id);
        $list = Itemslist::where('itemId', $id)->get();
        $item = SavedInvoices::where('item_id', $id)->first();
        if ($item) {
            return redirect()
                ->back()
                ->with('success', ' لا يمكن حذف النصف لارتباطة بحركات ');
        }
        $status = $delete->delete();
        if ($list) {
            foreach ($list as $item) {
                $item->delete();
            }
        }
        return redirect()->route('items.index')->with('msg', 'Successfully deleted');
    }

    public function FileItems()
    {
        return view('version.index');
    }

    public function FileItemsUpload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        Excel::import(new MohsenImport(), $request->file);
        return redirect()
            ->back()
            ->with('msg', 'تم رفع الاصناف بنجاح');
        // DB::table('tbl_customer')->insert($data);
    }
}
