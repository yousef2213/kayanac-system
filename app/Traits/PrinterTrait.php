<?php

namespace App\Traits;

trait PrinterTrait
{



    function getArabic($text, $Arabic)
    {
        $textLtr = $Arabic->utf8Glyphs($text);
        return $textLtr;
    }

    function actualLength($text)
    {
        if (strlen($text) != strlen(utf8_decode($text))) {
            $cont = strlen($text);
            $cont = $cont - $cont / 3;
            return $cont;
        } else return 0;
    }

    function line($n = 44)
    {
        $line = '';
        for ($i = 1; $i <= $n; $i++)
            $line .= "-";
        $line = str_pad($line, 44,); // ' ', STR_PAD_LEFT
        return $line;
    }
	// ابعاد فاتورة المطبخ
    public function addItemHead($item,  $price, $quantity, $total)
    {
        $itemCols       = 1 + $this->actualLength($item);
        $priceCols      = 1 + $this->actualLength($price);
        $quantityCols   = 6 + $this->actualLength($quantity);          //الصنف
        $totalCols      = 5 + $this->actualLength($total);
        $text = str_pad($item, $itemCols);
        $text .= str_pad($price, $priceCols);
        $text .= str_pad($quantity, $quantityCols);
        $text .= str_pad($total, $totalCols);
        return "$text\n";
    }

	// ابعاد فاتورة العميل
    public function addItemHeadCustomer($item,  $price, $quantity, $total)
    {
        $itemCols       = 8 + $this->actualLength($item,);    //
        $priceCols      = 6+ $this->actualLength($price);
        $quantityCols   = 4 + $this->actualLength($quantity);      // الاجمالى
        $totalCols      = 20 + $this->actualLength($total);     //
        $text = str_pad($item, $itemCols);
        $text .= str_pad($price, $priceCols );
        $text .= str_pad($quantity, $quantityCols );
        $text .= str_pad($total, $totalCols );   //' ', STR_PAD_LEFT
        return "$text\n";
    }

    public function addItemHeadTotal($item,  $price, $quantity, $total, $delever)
    {
        $itemCols       = 7 + $this->actualLength($item);
        $priceCols      = 7 + $this->actualLength($price);
        $quantityCols   = 7 + $this->actualLength($quantity);
        $totalCols      = 7 + $this->actualLength($total);
        $deleverCols      = 7  + $this->actualLength($delever);
        $text = str_pad($item, $itemCols);
        $text .= str_pad($price, $priceCols);
        $text .= str_pad($quantity, $quantityCols);
        $text .= str_pad($total, $totalCols);
        $text .= str_pad($delever, $deleverCols);
        return "$text\n";
    }
}
