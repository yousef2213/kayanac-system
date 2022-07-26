<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> تقارير الاصناف مشتريات </title>
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


    <div class="row flex-row-reverse font-main">

        <div class="col-12 body-style-voices font-main" style="width: 100%">
            <div class="btn-primary text-right p-2">
                <h2 class=" font-main" style="text-align: center; text-decoration: underline"> تقارير الاصناف </h2>
            </div>



            <div class="details"  style="width: 100%;margin-bottom: 14px;margin-top: 10px">
                <table class="table" dir="rtl" style="width: 100%">
                    <tbody style="width: 100%">
                        <tr>
                            <th class="text-right"> اجمالي </th>
                            <td class="text-center priceAfterTaxVal"> {{ $priceAfterTaxVal }} </td>
                        </tr>
                        <tr>
                            <th class="text-right"> نسبة الخصم </th>
                            <td class="text-center totalDiscountRate"> {{ $totalDiscountRate }} </td>
                        </tr>
                        <tr>
                            <th class="text-right"> قيمة الخصم </th>
                            <td class="text-center totalDiscountVal"> {{ $totalDiscountVal }} </td>
                        </tr>
                        <tr>
                            <th class="text-right"> قيمة مضافة </th>
                            <td class="text-center totalTaxRate"> {{ $totalTaxRate }} </td>
                        </tr>
                        <tr>
                            <th class="text-right"> اجمالي </th>
                            <td class="text-center netTotal"> {{ number_format($netTotal, 2, '.', '') }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <table class="table table-striped" dir="rtl" style="width: 100%">
                <thead class="">
                    <tr class="text-center font-main my-5" style="background: #716eab; color: #fff">
                        <th class="font-main"> الصنف </th>
                        <th class="font-main"> الوحدة </th>
                        <th class="font-main"> الكمية </th>
                        <th class="font-main"> السعر </th>
                        <th class="font-main"> اجمالي </th>
                        <th class="font-main"> الخصم </th>
                        <th class="font-main"> اجمالي بعد الخصم </th>
                        <th class="font-main"> الضرائب </th>
                        <th class="font-main"> اجمالي </th>
                    </tr>
                </thead>
                <tbody class="">
                    @foreach ($orders as $order)
                        <tr class="text-center font-main" style="text-align: center">
                            <td style="text-align: center"> {{ $order['namear'] }} </td>
                            <td style="text-align: center"> {{ $order['unit'] }} </td>
                            <td style="text-align: center"> {{ $order['qtn'] }} </td>
                            <td style="text-align: center"> {{ $order['price'] }} </td>
                            <td style="text-align: center"> {{ $order['total'] }} </td>
                            <td style="text-align: center"> {{ $order['discountValue'] }} </td>
                            <td style="text-align: center"> {{ $order['total'] - $order['discountValue'] }} </td>
                            <td style="text-align: center"> {{ $order['value'] }} </td>
                            <td style="text-align: center"> {{ $order['nettotal'] }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>
