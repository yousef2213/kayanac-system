<?php

namespace App\Imports;

use App\Items;
use App\Itemslist;
use item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MohsenImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {

        $item = Items::create([
            "namear" => $row['namear'],
            "nameen" => $row['nameen'],
            "group" => $row['group'],
            "catId" => $row['catid'],
            "taxRate" => $row['taxrate'],
            "priceWithTax" => $row['withtax'],
            // "quantityM" => $row['quantitym'],
            // "nature" => $row['nature'],
            "description" => $row['description'],
        ]);
        $item->save();
        // $itemList = new Itemslist([
        //     "itemId" => 29879,
        //     "unitId" => "1",
        //     "price1" => "10",
        // ]);
        // $itemList->save();
        // new Items([
        //     "namear" => $row['namear'],
        //     "nameen" => $row['nameen'],
        //     "group" => $row['group'],
        //     "catId" => $row['catid'],
        //     "taxRate" => $row['rate'],
        //     "priceWithTax" => $row['withtax'],
        //     "quantityM" => $row['quantitym'],
        //     "nature" => $row['nature'],
        //     "description" => $row['description'],
        // ]);
        return new Itemslist([
            "itemId" => $item->id,
            "unitId" => $row['unit_id'],
            "barcode" => $row['barcode'],
            "price1" => $row['price1'],
            "total" => $row['price1'],
            "price2" => $row['price2'],
            "packing" => $row['packing'],
            "small_unit" => $row['small_unit'],
        ]);;
    }
}
