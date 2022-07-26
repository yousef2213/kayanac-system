<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>كشف حساب</title>

    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bonds/print.css') }}">
    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@500&display=swap'); */

        @font-face {
            font-family: "Tajawal";
            src: url("../fonts/Tajawal-Regular.eot");
            /* IE9 Compat Modes */
            src: url("../fonts/Tajawal-Regular.eot") format("embedded-opentype"),
                /* IE6-IE8 */
                url("../fonts/Tajawal-Regular.woff") format("woff"),
                /* Modern Browsers */
                url("../fonts/Tajawal-Regular.ttf") format("truetype"),
                /* Safari, Android, iOS */
                url("../fonts/Tajawal-Regular.svg") format("svg");
            /* Legacy iOS */
        }

        .font-main {
            font-family: "Tajawal" !important;
            font-weight: 600;
        }

        .title {
            text-decoration: underline;
            font-family: "Tajawal" !important;
            font-weight: 600;
        }

        body {
            font-family: "Tajawal" !important;
            font-weight: 600;
        }

    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 py-4">
                <h4 class="title text-center"> تقرير كشف حساب </h4>

                <div class="text-right my-3">
                    <div class="d-flex">
                        <h6 class="mx-2"> بداية تاريخ </h6>
                        <h6 class="mx-2 from"> </h6>
                    </div>
                    <div class="d-flex">
                        <h6 class="mx-2"> نهاية تاريخ </h6>
                        <h6 class="mx-2 to"> </h6>
                    </div>
                </div>
            </div>
            <div class="col-11 mx-auto py-4">
                <div class="body-style-items  my-5">
                    <table class="table table-bordered table-striped" id="branches-dataTable" dir="rtl" width="100%"
                        cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th> م </th>
                                <th> فرع </th>
                                <th> تاريخ </th>
                                <th> القيد </th>
                                <th> الرقم - المصدر </th>
                                <th> الوصف </th>
                                <th> مدين </th>
                                <th> دائن </th>
                                <th> الرصيد </th>
                            </tr>
                        </thead>
                        <tbody class="bodyAccountStateMent">


                        </tbody>
                    </table>
                </div>


                <button class="d-block w-100 btn btn-primary font-main" onclick="Print()">
                    طباعة
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script>
        function Print() {
            window.print()
        }
    </script>
    <script>
        if (window.parameters) {
            let items = JSON.parse(window.parameters);
            if (items) {
                let {
                    data,
                    from,
                    to
                } = items;

                let fromDate = new Date(from);
                let toDate = new Date(to);

                if (data.length != 0) {
                    array = data;
                    let item = '';
                    let totoal_dector = 0;
                    let totoal_creditor = 0;
                    let totaling = 0;
                    let totalingDebit = 0;
                    let totalingCredit = 0;


                    data.forEach((ele, i) => {

                        if (ele.source != 0) {
                            if (ele.debtor != 0) {
                                totaling += +ele.debtor;
                                totalingDebit += ele.debtor;
                            }
                            if (ele.creditor != 0) {
                                totaling -= ele.creditor
                                totalingCredit += ele.creditor;
                            }
                        }


                        totoal_dector += ele.debtor;
                        totoal_creditor += ele.creditor;
                        item += `<tr class="text-center font-main">
                                    <td> ${i + 1} </td>
                                    <td> ${ele.branshName} </td>
                                    <td> ${ele.date} </td>
                                    <td> ${ele.numDailty} </td>
                                    <td> ${ele.source} - ${ele.source_name} </td>
                                    <td> ${ele.description} </td>
                                    <td class="text-success"> ${ele.debtor} </td>
                                    <td class="text-danger"> ${ele.creditor} </td>
                                    <td> ${totaling} </td>
                                </tr>`
                    });

                    $('.bodyAccountStateMent').html(item);
                    let row = `<tr class="text-center font-main">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">اجمالي</td>
                                    <td class="text-success"> ${(totoal_dector).toFixed(3)} </td>
                                    <td class="text-danger"> ${(totoal_creditor).toFixed(3)} </td>
                                    <td class=${totaling > 0 ? "text-success" : "text-danger"}> ${totaling}</td>
                                </tr>`
                    $('.bodyAccountStateMent').append(row);

                    let fromDatee = fromDate.getFullYear() + "-" + (fromDate.getMonth() + 1) + "-" + fromDate.getDate();
                    let toDatee = toDate.getFullYear() + "-" + (toDate.getMonth() + 1) + "-" + toDate.getDate();

                    $('.from').html(fromDatee);
                    $('.to').html(toDatee);
                } else {
                    swal('لا يوجد بيانات')
                    $('.bodyAccountStateMent').html("");
                }
            }
        }
    </script>
</body>

</html>
