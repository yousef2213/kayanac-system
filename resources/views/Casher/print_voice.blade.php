<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <title>Document</title>
    <style>
        .ar {
            text-align: right !important
        }

        .en {
            text-align: left !important
        }

    </style>
    <style type="text/css" media="print">
        button {
            display: none !important
        }

        p,
        th,
        tr,
        td {
            font-size: 13px !important;
            font-weight: 800 !important
        }

        .ar {
            text-align: right !important
        }

        .en {
            text-align: left !important
        }

        img {
            max-width: 70px !important;
            max-height: 50px !important
        }

        @page {
            margin: 0mm !important;
        }

    </style>
</head>

<body>

    <div class="container-fluid px-0">
        <div class="col-12 col-md-10 mx-auto px-0">

            <div class="d-flex justify-content-between font-main align-items-center">
                <div>
                    <p class="company-en en"> .. </p>
                    <p class="branch-en en"> .. </p>
                </div>
                <div class="img">

                </div>
                <div>
                    <p class="company-ar ar"> .. </p>
                    <p class="branch-ar ar"> .. </p>
                </div>
            </div>

            <div class="d-flex justify-content-end font-main">
                <p class="customer-invoice px-1"> </p>
                <p class=""> : العميل </p>
            </div>

            <div class="d-flex justify-content-end font-main">
                <p class="px-1"> <span class="date-invoice"></span> <span class="time-invoice"></span>
                </p>
                <p class=""> : تاريخ الفاتورة </p>
            </div>

            <div class="d-flex justify-content-end font-main">
                <p class="num-invoice px-1"> .. </p>
                <p class=""> : رقم الفاتورة </p>
            </div>


            <div class="mx-auto text-center mt-1  px-0 mx-0">
                <table class="table px-5" dir="rtl">
                    <thead>
                        <tr class="text-center font-main">
                            <th class=""> الصنف </th>
                            <th class=""> السعر </th>
                            <th class=""> ض.م </th>
                            <th class=""> الصافي </th>
                        </tr>
                    </thead>
                    <tbody class="body">

                    </tbody>
                </table>


                <div class="d-flex justify-content-between font-main">
                    <p class="total px-1"> .. </p>
                    <p class=""> : الاجمالي قبل الضريبة </p>
                </div>
                <div class="d-flex justify-content-between font-main">
                    <p class="tax px-1"> .. </p>
                    <p class=""> : ضريبة القيمة المضافة </p>
                </div>
                <div class="d-flex justify-content-between font-main">
                    <p class="nettotal px-1"> .. </p>
                    <p class=""> : الاجمالي بعد الضريبة </p>
                </div>


                <div class="w-100 d-block">
                    <button class="btn btn-primary btn-block font-main my-3" onclick="youPrint()">
                        Print
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        let total = 0;
        let taxs = 0;
        let netTotal = 0;

        if (window.parameters) {
            let data = JSON.parse(window.parameters);
            if (data) {
                let date = new Date(data.invoiceId.created_at);
                let company = data.company;
                let branch = data.branch;
                let customer = data.customer;
                let items = data.list.map(({
                    item_name,
                    value,
                    price,
                    nettotal,
                    qtn
                }, i) => {
                    total += price * qtn;
                    taxs += value;
                    return `<tr class="text-center font-main">
                            <td class=""> ${item_name} </td>
                            <td class=""> ${price} </td>
                            <td class=""> ${value} </td>
                            <td class=""> ${nettotal} </td>
                        </tr>`

                });
                document.querySelector('.body').innerHTML = items.join('');
                $('.company-ar').html(company.companyNameAr)
                $('.company-en').html(company.companyNameEn)
                $('.branch-ar').html(branch.namear)
                $('.branch-en').html(branch.nameen)
                $('.branch-en').html(branch.nameen)
                $('.date-invoice').html(date.toLocaleDateString())
                $('.time-invoice').html(date.toLocaleTimeString())
                $('.num-invoice').html(data.invoiceId.id)
                $('.nettotal').html(+data.invoiceId.netTotal.toFixed(3))
                $('.total').html(+total.toFixed(3))
                $('.tax').html(+taxs.toFixed(3))
                $('.customer-invoice').html(customer.name)
                let img = `<img src="{{ asset('comp/${company.logo}') }}" height="100" alt="">`
                $('.img').html(img);
            }
        }

        function youPrint() {
            window.focus();
            window.print();
        }
        youPrint()
    </script>
</body>

</html>
