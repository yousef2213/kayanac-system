<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Invoices;
use App\SavedInvoices;
use App\Shift;
use App\Unit;
use App\Traits\PrinterTrait;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use I18N_Arabic;

require_once __DIR__ . '/ar/I18N/Arabic.php';


class ReportsController extends Controller {

    use PrinterTrait;


    public function __construct() {
        $this->middleware('auth');
        $this->middleware('active_permision');
    }


    public function index() {
        $Shifts = Shift::all();
        return view('reports.index')->with('Shifts', $Shifts);
    }


    public function show($id) {
        $shift = Shift::find($id);
        $current_date_time = Carbon::now()->toDateTimeString();
        $orders = Invoices::whereBetween('created_at', [$shift->openDate, $shift->closeDate])->where("status","!=","2")->get();
        $Invoices = SavedInvoices::get();
        $customers = Customers::all();
        $units = Unit::all();
        $InvoicesDetails = [];
        $PaymentTotal = 0;
        $taxValue = 0;
        foreach ($orders as $order) {
            foreach ($Invoices as $invoicesave) {
                if($invoicesave->invoiceId == $order->id) {
                    if($invoicesave->priceWithTax == "1"){
                        $invoicesave->TaxVal = $invoicesave->price / "1.$invoicesave->taxRate" * $invoicesave->taxRate/100;
                    }else {
                        $invoicesave->TaxVal = $invoicesave->price * $invoicesave->taxRate/100;
                    }
                    $PaymentTotal += $invoicesave->total;
                    $taxValue += $invoicesave->TaxVal;
                    $InvoicesDetails[] = $invoicesave;
                }
            }
        }
        $InvoicesDetails = collect($InvoicesDetails);
        $InvoicesDetails->each(function($item) {
            $item->unit_name = Unit::find($item->unit_id)->namear;
        });
        // return $InvoicesDetails;

        return view('reports.show')
            ->with('PaymentTotal', $PaymentTotal)
            ->with('orders', $orders)
            ->with('InvoicesDetails', $InvoicesDetails)
            ->with('customers', $customers)
            ->with('id', $id)
            ->with("taxValue", $taxValue);
    }



    public function ItemsReports(Request $request) {
        $connector = new WindowsPrintConnector("POS-80");
        $printer = new Printer($connector);
        mb_internal_encoding("UTF-8");
        $Arabic = new I18N_Arabic('Glyphs');
        $fontPath = __DIR__ . '/ar/I18N/Arabic/Examples/GD/no.otf';
        $fontSize = 25;
        // date
        // date_default_timezone_set('Africa/Cairo');
         $date = date('Y-m-d h:i:s a', time());
        $buffer = new ImagePrintBuffer();
        $buffer->setFontSize($fontSize);
        $buffer->setFont($fontPath);
        $printer->setPrintBuffer($buffer);

        // $img = EscposImage::load(public_path() . "/comp" . "/" . $company->logo);
        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $printer->bitImage($img);
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        // $printer->feed();

        // $printer -> setTextSize(3, 4);
        // $textLtr = $Arabic -> utf8Glyphs($company->companyNameAr);
        // $textLB = $Arabic -> utf8Glyphs("الفرع : " . $branch->namear );
        // $printer -> text( $textLB  . "   " .$textLtr);
        // $printer -> feed();

        // $textLtr = $Arabic -> utf8Glyphs("الرقم الضريبي   ");
        // $ss = $printer -> text( $company->taxNum . "  " . $textLtr ."\n");
        // $printer -> feed();

        // $textLtr = $Arabic -> utf8Glyphs("تاريخ الفاتورة   ");
        // $ss = $printer -> text( $date . "  " . $textLtr ."\n");
        // $printer -> feed();
        // $textLtr = $Arabic -> utf8Glyphs("رقم الفاتورة    ".$invoiceId->id);
        // $printer -> text($textLtr);
        // $printer -> feed();
        // $textLtr = $Arabic -> utf8Glyphs("نوع الطلب   : ".$textar);
        // $printer -> text($texten . " " . $textLtr);
        // $printer -> feed();
        // $printer->setJustification(Printer::JUSTIFY_CENTER);
        // $textLtr = $Arabic -> utf8Glyphs("رقم الاوردر   ");
        // $ss = $printer -> text( $numOrder->num . "  " . $textLtr ."\n");
        // $printer -> feed();
        // $printer->text("Payment Methods : " . $textPay . "\n\n");
        // $printer->feed();

        $printer->setJustification(Printer::JUSTIFY_CENTER);
       $textLtr = $Arabic -> utf8Glyphs("تقرير الاصناف");
        $ss = $printer -> text( $textLtr);
        $printer -> feed();

        $textLtr = $Arabic -> utf8Glyphs("من تاريخ   ");
        $ss = $printer -> text( $request->from . "  " . $textLtr ."\n");
        $printer -> feed();

        $textLtr = $Arabic -> utf8Glyphs("الي تاريخ   ");
        $ss = $printer -> text( $request->to . "  " . $textLtr ."\n");
        $printer -> feed();


        $head = $this->addItemHead(
            $this->getArabic('الصنف', $Arabic),
            $this->getArabic('سعر', $Arabic),
            $this->getArabic('كمية', $Arabic),
            $this->getArabic('اجمالى', $Arabic)
        );
        $printer->text($head);
        $printer->text($this->line());

        if ($request->data) {
            foreach ($request->data as $item) {
            $unitnamear = Unit::find($item['unitId'])->namear;
            $unitnameen = Unit::find($item['unitId'])->nameen;
                $itemCols       = 16 + $this->actualLength($item['nameen']);
                $priceCols      = 8  + $this->actualLength($item['price']);
                $quantityCols   = 8  + $this->actualLength($item['qtn']);
                $totalCols      = 8  + $this->actualLength($item['total']);
                $text = str_pad($item['nameen'] . " - " . $unitnameen, $itemCols);
                $text .= str_pad($item['price'], $priceCols, ' ', STR_PAD_LEFT);
                $text .= str_pad($item['qtn'], $quantityCols, ' ', STR_PAD_LEFT);
                $text .= str_pad($item['total'], $totalCols, ' ', STR_PAD_LEFT);

                $printer->text($text . "\n");
                $printer->text($this->line());
                $text  = $this->addItemHead(
                    $this->getArabic($item['namear'] . " - " . $unitnamear, $Arabic),
                    $this->getArabic("", $Arabic),
                    $this->getArabic("", $Arabic),
                    $this->getArabic("", $Arabic)
                );
                $printer->text($text . "\n");
                $printer->text($this->line());
            }
        }

        $printer -> feed();
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $textLtr = $Arabic -> utf8Glyphs("الاجمالي قبل الضريبة");
        $ss = $printer -> text( $request->priceAfterTaxVal . "             " . $textLtr ."\n");
        $printer -> feed();
        $textLtr = $Arabic -> utf8Glyphs("ضريبة القيمة المضافة   ");
        $ss = $printer -> text( $request->totalTaxRate . "        " . " 15% " . $textLtr ."\n");
        $printer -> feed();
        $textLtr = $Arabic -> utf8Glyphs("المجموع شامل الضريبة ");
        $ss = $printer -> text( $request->netTotal . "              " . $textLtr ."\n");
        $printer -> feed();

        $printer->cut();
        $printer->pulse();
        $printer->close();


        return $request;
    }

}
