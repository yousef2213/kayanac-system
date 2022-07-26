<?php

namespace App\Traits;

use App\Branches;
use App\Compaines;
use App\Itemslist;
use App\NumOrders;
use App\PrinterSetting;
use App\Unit;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\ImagickEscposImage;
use Mike42\Escpos\PrintBuffers\ImagePrintBuffer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use I18N_Arabic;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\InvoiceDate;
use Salla\ZATCA\Tags\InvoiceTaxAmount;
use Salla\ZATCA\Tags\InvoiceTotalAmount;
use Salla\ZATCA\Tags\Seller;
use Salla\ZATCA\Tags\TaxNumber;

class PrintVoice
{


    use PrinterTrait;

    public function print($request, $invoiceId, $invoice)
    {
        $printerName = PrinterSetting::first();
        $company = Compaines::all()->first();
        $user = auth()->user();
        $branch = Branches::find($user->barnchId);
        $numOrder = NumOrders::first();
        //  Last version

        // if ($request->status == 2) {
        //     return $this->HoldInvoice($request, $printerName, $customers, $company, $user, $branch, $shift);
        // }
        // if ($request->status == 10) {
        //     return $this->PaymentMethods($request, $printerName, $customers, $company, $user, $branch, $shift);
        // }

        $textar = '';
        $texten = '';

        if ($request->typyInvoice == '3') {
            $textar = 'سفري';
            $texten = 'Takeaway';
        }
        if ($request->typyInvoice == '4') {
            $textar = 'محلي';
            $texten = 'Mahli';
        }
        if ($request->typyInvoice == '5') {
            $textar = 'محلي طاولات';
            $texten = 'Mahli Tawlat';
        }
        if ($request->typyInvoice == '6') {
            $textar = 'محلي طاولات';
            $texten = 'Mahli Takeaway';
        }
        $newList = [];
        $average_total = 0;
        if (count($request->list) > 0) {
            foreach ($request->list as $item) {
                $status = Itemslist::where('itemId', $item['itemId'])
                    ->where('unitId', $item['unitId'])
                    ->first();

                if (!$status) {
                    return response()->json([
                        'msg' => 'لا يوجد هذا الصنف',
                        'status' => 201,
                    ]);
                }
                $newQtn = $status->packing * $item['qtn'];
                $item['newQ'] = $newQtn;
                $item['av_price'] = $status->av_price;
                $newList[] = $item;
            }
        }



        // first Printer ****

        $connector = new WindowsPrintConnector("XP-80");
        // $connector = new WindowsPrintConnector($printerName->printcasher);
        $printer = new Printer($connector);
        $printer->initialize();
        mb_internal_encoding('UTF-8');
        $Arabic = new I18N_Arabic('Glyphs');
        $fontPath = __DIR__ . '/ar/I18N/Arabic/Examples/GD/no.otf';
        $fontSize = 28;
        // date
        date_default_timezone_set('Asia/Riyadh');
        $date = date('Y-m-d h:i:s a', time());
        $buffer = new ImagePrintBuffer();
        $buffer->setFontSize($fontSize);
        $buffer->setFont($fontPath);
        $printer->setPrintBuffer($buffer);

        $img = EscposImage::load(public_path() . '/comp' . '/' . $company->logo);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->bitImage($img);
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->feed();
        $printer->setTextSize(3, 4);

        $textLtr = $Arabic->utf8Glyphs($company->companyNameAr);
        $textLB = $Arabic->utf8Glyphs('الفرع : ' . $branch->namear);
        $printer->text($textLB . '   ' . $textLtr);
        $printer->feed();

        $textLtr = $Arabic->utf8Glyphs('الرقم الضريبي   ');
        $ss = $printer->text($company->taxNum . '  ' . $textLtr . "\n");
        $printer->feed();

        $textLtr = $Arabic->utf8Glyphs('تاريخ الفاتورة   ');
        $ss = $printer->text($date . '  ' . $textLtr . "\n");
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('رقم الفاتورة    ' . $invoiceId->id);
        $printer->text($textLtr);
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('نوع الطلب   : ' . $textar);
        $printer->text($texten . ' ' . $textLtr);
        $printer->feed();

        $printer->setJustification(Printer::JUSTIFY_CENTER);

        $textLtr = $Arabic->utf8Glyphs('رقم الاوردر   ');
        $ss = $printer->text($numOrder->num . '  ' . $textLtr . "\n");
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $head = $this->addItemHead($this->getArabic('الصنف', $Arabic), $this->getArabic('سعر', $Arabic), $this->getArabic('كمية', $Arabic), $this->getArabic('اجمالى', $Arabic));
        $printer->text($head);
        $printer->text($this->line());

        // *****************(*)
        // اذن صرف

        // *****************(*)

        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $textLtr = $Arabic->utf8Glyphs('الاجمالي قبل الضريبة');
        $ss = $printer->text($request->totalAfter . '             ' . $textLtr . "\n");
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('ضريبة القيمة المضافة   ');
        $ss = $printer->text($request->taxVals . '        ' . ' 15% ' . $textLtr . "\n");
        $printer->feed();
        $textLtr = $Arabic->utf8Glyphs('المجموع شامل الضريبة ');
        $ss = $printer->text($request->netTotal . '              ' . $textLtr . "\n");
        $printer->feed();
        $printer->setJustification(Printer::JUSTIFY_CENTER);

        // Genertae Qr
        $displayQRCodeAsBase64 = GenerateQrCode::fromArray([new Seller($company->companyNameAr), new TaxNumber($company->taxNum), new InvoiceDate($date), new InvoiceTotalAmount($request->netTotal), new InvoiceTaxAmount($request->taxVals)])->render();

        // Qr Genertator VT
        $imageBlob = base64_decode(explode(',', $displayQRCodeAsBase64)[1]);
        $imagick = new \Imagick();
        $imagick->setResourceLimit(6, 1);
        $imagick->readImageBlob($imageBlob, 'input.png');
        $im = new ImagickEscposImage();
        $im->readImageFromImagick($imagick);
        $printer->bitImage($im);

        $textLtr = $Arabic->utf8Glyphs($branch->address);
        $printer->text($textLtr);
        $printer->feed();

        $printer->cut();
        $printer->pulse();
        $printer->close();

        // printkitchen

        if ($printerName->printkitchen) {
            $connector = new WindowsPrintConnector($printerName->printkitchen);
            $printer = new Printer($connector);
            $buffer = new ImagePrintBuffer();
            $buffer->setFontSize($fontSize);
            $buffer->setFont($fontPath);
            $printer->setPrintBuffer($buffer);

            $textLtr = $Arabic->utf8Glyphs('نوع الطلب   : ' . $textar);
            $printer->text($textLtr);
            $printer->text('Typy Order   : ' . $texten);
            $printer->feed();

            $printer->text('Date   : ' . $date);
            $printer->feed();
            $printer->setJustification(Printer::JUSTIFY_LEFT);

            $printer->text('Num Order : ' . $numOrder->num . "\n\n");
            $printer->feed();
            $printer->feed();

            $head = $this->addItemHead($this->getArabic('الصنف', $Arabic), $this->getArabic(' ', $Arabic), $this->getArabic('كمية', $Arabic), $this->getArabic(' ', $Arabic));
            $printer->text($head);
            $printer->text($this->line());

            if ($request->list) {
                foreach ($request->list as $item) {
                    $unitnamear = Unit::find($item['unitId'])->namear;
                    $unitnameen = Unit::find($item['unitId'])->nameen;
                    $invoice->img = $item['img'];
                    $invoice->unitId = $item['unitId'];
                    $invoice->price = $item['price'];
                    $invoice->priceWithTax = $item['priceWithTax'];
                    $invoice->itemId = $item['itemId'];
                    $invoice->qtn = $item['qtn'];
                    $invoice->groupItem = $item['group'];
                    $invoice->description = $item['description'];
                    $invoice->namear = $item['namear']; //
                    $invoice->nameen = $item['nameen']; //
                    $invoice->total = $item['total'];
                    $invoice->quantityM = $item['quantityM'];
                    $invoice->taxRate = $item['taxRate'];
                    $invoice->status = $request['status'];

                    $itemCols = 10 + $this->actualLength($item['nameen']);
                    $priceCols = 10 + $this->actualLength(' ');
                    $quantityCols = 10 + $this->actualLength($item['qtn']);
                    $totalCols = 10 + $this->actualLength(' ');
                    $text = str_pad($item['nameen'] . ' - ' . $unitnameen, $itemCols);
                    $text .= str_pad(' ', $priceCols, ' ', STR_PAD_LEFT);
                    $text .= str_pad($item['qtn'], $quantityCols, ' ', STR_PAD_LEFT);
                    $text .= str_pad(' ', $totalCols, ' ', STR_PAD_LEFT);

                    $printer->text($text . "\n");
                    $printer->text($this->line());
                    $text = $this->addItemHead($this->getArabic($item['namear'] . ' ' . $unitnamear, $Arabic), $this->getArabic('', $Arabic), $this->getArabic('', $Arabic), $this->getArabic('', $Arabic));
                    $printer->text($text . "\n");
                    $printer->text($this->line());
                }
            }
            $printer->feed();
            $printer->cut();
            $printer->pulse();
            $printer->close();
        }

    }
}
