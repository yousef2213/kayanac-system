<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Items Reports Print</title>
    <link rel="stylesheet" href="{{ asset('css/printReport.css') }}">
</head>

<body>

<div class="content">
    <h3> تقرير الاصناف </h3>
    <table class="table" dir="rtl">
    <thead>
        <tr>
        <th scope="col"> الصنف </th>
        <th scope="col"> سعر </th>
        <th scope="col"> الكمية </th>
        <th scope="col">اجمالي</th>
        </tr>
    </thead>
    <tbody class="Rows"></tbody>
    </table>
      <div class="col-12 col-md-4">
                <div class="details">
                    <table class="table" dir="rtl">
                        <tbody>
                          <tr>
                            <th class="text-right"> اجمالي </th>
                            <td class="text-center priceAfterTaxVal"> 00 </td>
                          </tr>
                          <tr>
                            <th class="text-right"> الخصم </th>
                            <td class="text-center totalDiscount"> 00 </td>
                          </tr>
                          <tr>
                            <th class="text-right"> قيمة مضافة </th>
                            <td class="text-center totalTaxRate"> 00 </td>
                          </tr>
                          <tr>
                            <th class="text-right"> اجمالي </th>
                            <td class="text-center netTotal"> 00 </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
</div>
    <script src="{{ asset('docsupport/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script>
         if (window.parameters) {
            let items = JSON.parse(window.parameters);
            if (items) {
                let Rows = document.querySelector(".Rows");
                let row = '';
                items.Optimzation.map(item => {
                    Rows.innerHTML += `
                         <tr>
                            <th scope="row"> ${item.item_name} </th>
                            <td> ${item.price} </td>
                            <td> ${item.qtn} </td>
                            <td> ${item.total} </td>
                        </tr>
                    `
                });
                $('.priceAfterTaxVal').text(items.total);
                $('.totalDiscount').text(items.discount);
                $('.totalTaxRate').text(items.taxRate);
                $('.netTotal').text(items.netTotal);
            }
        }

        window.focus();
        window.print();
    </script>
</body>
</html>
