<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Shift - {{ $id }} </title>
</head>

<style>
    @font-face {
        font-family: 'Tajawal';
        src: url('../fonts/Tajawal-Regular.eot');
        /* IE9 Compat Modes */
        src: url('../fonts/Tajawal-Regular.eot') format('embedded-opentype'),
            /* IE6-IE8 */
            url('../fonts/Tajawal-Regular.woff') format('woff'),
            /* Modern Browsers */
            url('../fonts/Tajawal-Regular.ttf') format('truetype'),
            /* Safari, Android, iOS */
            url('../fonts/Tajawal-Regular.svg') format('svg');
        /* Legacy iOS */
    }

    .font-main {
        font-family: 'Tajawal' !important;
        font-weight: 800;
    }

</style>

<body>
    <h1 style="text-align: center" class=" font-main"> Details Shift - {{ $id }}</h1>


    <div class="row flex-row-reverse font-main">

        <div class="col-12 font-main" style="width: 100%">
            <div class="btn-primary text-right p-2">
                <h2 class="font-main" style="text-align: center; text-decoration: underline"> الاجماليات </h2>
                {{-- <h2 style="text-align: center; text-decoration: underline"> Totals </h2> --}}
            </div>
            <div class="details mb-5 w-100" style="width: 100%">
                <table class="table" dir="rtl" style="width: 100%">
                    <thead>
                        <tr style="background: #ddd;color: #000 !important">
                            {{-- <th class="text-right" style="text-align: right"> Type </th>
                            <th class="text-center" style="text-align: center"> Payment </th>
                            <th class="text-center" style="text-align: center"> TaxValue </th> --}}
                            <th class="text-right" style="text-align: right"> النوع </th>
                            <th class="text-center" style="text-align: center"> المدفوع </th>
                            <th class="text-center" style="text-align: center"> الضريبة </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-right font-main" style="text-align: center"> فاتورة </th>
                            {{-- <th class="text-right" style="text-align: center"> Invoice </th> --}}
                            <td class="text-center font-main" style="text-align: center"> {{ $PaymentTotal }} </td>
                            <td class="text-center font-main" style="text-align: center"> {{ $taxValue }} </td>
                        </tr>
                        <tr>
                            <th class="text-right font-main" style="text-align: center"> اشعار خصم </th>
                            {{-- <th class="text-right" style="text-align: center"> Discount notice </th> --}}
                            <td class="text-center font-main" style="text-align: center"> 0 </td>
                            <td class="text-center font-main" style="text-align: center"> 0 </td>
                        </tr>
                        <tr>
                            <th class="text-right" style="text-align: center"> اشعار اضافة </th>
                            {{-- <th class="text-right" style="text-align: center"> Add notice </th> --}}
                            <td class="text-center" style="text-align: center"> 0 </td>
                            <td class="text-center" style="text-align: center"> 0 </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 body-style-voices font-main" style="width: 100%">
            <div class="btn-primary text-right p-2">
                <h2 class=" font-main" style="text-align: center; text-decoration: underline"> الفواتير </h2>
                {{-- <h2 style="text-align: center; text-decoration: underline"> Invoices </h2> --}}

            </div>
            <table class="table table-striped" dir="rtl" style="width: 100%">
                <thead class="">
                    <tr class="text-center font-main my-5" style="background: #716eab; color: #fff">
                        {{-- <th> Num Voice </th>
                        <th> Date </th>
                        <th> Customer Id </th>
                        <th> netTotal </th>
                        <th> Payment Method </th> --}}
                        <th class="font-main"> رقم الفاتورة </th>
                        <th class="font-main"> التاريخ </th>
                        <th class="font-main"> عميل </th>
                        <th class="font-main"> الصافي </th>
                        <th class="font-main"> طريقة الدفع </th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($orders as $order)
                        <tr class="text-center font-main" style="text-align: center">
                            <td style="text-align: center">{{ $order->id }}</td>
                            <td style="text-align: center">{{ $order->created_at }}</td>
                            <td style="text-align: center">
                                {{ $customers->find($order->customerId)->name }}
                            </td>
                            <td style="text-align: center">
                                {{ $order->netTotal }}
                            </td>
                            <td style="text-align: center"> Cash </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        <div class="col-12 body-style-items" style="width: 100%">
            <div class="btn-primary text-right p-2 font-main">
                <h2 class=" font-main" style="text-align: center; text-decoration: underline"> الاصناف </h2>

            </div>
            <table class="table table-striped" dir="rtl" style="width: 100%">
                <thead class="">
                    <tr class="text-center font-main my-5" style="background: #716eab; color: #fff">
                        {{-- <th> Item </th>
                        <th> Unit </th>
                        <th> Quantity </th>
                        <th> Price </th>
                        <th> taxes </th>
                        <th> Total </th> --}}

                        <th class="font-main"> الصنف </th>
                        <th class="font-main"> الوحدة </th>
                        <th class="font-main"> الكمية </th>
                        <th class="font-main"> السعر </th>
                        <th class="font-main"> الضرائب </th>
                        <th class="font-main"> اجمالي </th>

                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($InvoicesDetails as $order)
                        <tr class="text-center font-main" style="text-align: center">
                            <td style="text-align: center"> {{ $order->item_name }} </td>
                            <td style="text-align: center"> {{ $order->unit_name }} </td>
                            <td style="text-align: center" class="">
                                {{ $order->qtn }}
                            </td>
                            <td style="text-align: center">
                                {{ $order->price }} </td>

                            <td style="text-align: center"> {{ number_format((float) $order->value, 2, '.', '') }}
                            </td>
                            <td style="text-align: center"> {{ $order->nettotal }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
