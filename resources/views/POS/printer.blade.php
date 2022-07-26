<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Erp - Print Invoice </title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style media="print">
        
        .col-print {
            width: 50% !important;
            min-height: 90vh !important;
            height: 100%;
        }
        .tr-items-all > h6 {
            text-align: center !important
        }
        img {
                width: 140px !important;
                height: 140px !important;
            }
        .tr-items-all {
            border-bottom: 1px solid #444;
        }
        @media (max-width: 700px) {
            .col-print {
                width: 100% !important;
                min-height: 90vh !important;
                height: 100% !important;
            }
        }

        @media print {
            .heading {
                border-bottom: 1px solid #ccc;
                padding-bottom: 10px;
                margin-bottom: 10px;
            }
            button {
                display: none !important;
            }
            html,
            body {
                -webkit-print-color-adjust: exact !important;
                height: auto;
                font-weight: 900;
                font-family: 'Tajawal', sans-serif !important;
                font-size: 35px !important;
                margin-left: 1em;
                margin-right: 5em;
                width: 100vw !important;
                /* size: auto; */
                color: #000;
                background-color: #fff;
            }
            img {
                width: 240px !important;
                height: 240px !important;
                margin-bottom: 20px;
            }
            th,
            td {
                font-size: 33px !important;
                font-family: 'Tajawal', sans-serif !important;
                font-weight: 700;
            }
            
            .col-print {
                max-width: 100% !important;
                width: 100% !important;
                min-height: 90vh !important;
                height: 100%;
            }
            .tr-print-account {
                font-weight: bold;
            }
            .tr-items-all {
                font-weight: bold;
                font-size: 35px !important; 
                border-bottom: 1px solid #ccc;
                padding-bottom: 10px;
                margin-bottom: 10px;
                text-align: center !important
            }
            .tr-items-all > h6 {
                text-align: center !important
            }
            table {
                display: table !important
            }
        }
        .footerList {
            position: absolute;
            bottom: 20px;

        }
    </style>

</head>


<body>
    <div class="container-fluid">
        <div class="container font-main">
            <div class="col-print mx-auto text-center my-4">

                <div class="total">
                    <div class="row">
                        <div class="col-12 mx-auto text-center logo">

                        </div>
                    </div>
                    <?php 
                        date_default_timezone_set('Africa/Cairo');
                        $date = date('d/m/y h:i:s a', time());
                    ?>
                    <div class="d-flex justify-content-between px-4 align-items-center mb-2 mt-3">
                        <h6 class="font-main"> <?php echo date('d/m/y h:i:s a', time()); ?> </h5>
                        <h6 class="font-main"> تاريخ الفاتورة </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center mb-2">
                        <h6 class="invoiceId font-main"> 0 </h6>
                        <h6 class="font-main"> رقم الفاتورة </h6>
                    </div>
                   
                </div>


                {{-- <table class="table" dir="rtl">
                    <thead>
                        <tr>
                            <th scope="col"> منتج </th>
                            <th scope="col"> السعر </th>
                            <th scope="col"> الكمية </th>
                            <th scope="col">الاجمالي</th>
                        </tr>
                    </thead>
                    <tbody class="bodyPrinter">

                    </tbody>
                </table> --}}

                <div class="w-100 my-3" style="width: 100%">
                    <div class="w-100 d-flex justify-content-between text-center heading">
                        <h6 class="w-25"> منتج </h6>
                        <h6 class="w-25"> السعر </h6>
                        <h6 class="w-25"> الكمية </h6>
                        <h6 class="w-25">الاجمالي</h6>
                        {{-- <hr> --}}
                    </div>
                    <div class="bodyPrinter w-100">

                    </div>
                </div>


                {{-- <hr> --}}
                <div class="total">
                    <div class="d-flex justify-content-between px-4 align-items-center">
                        <h6  class="netQtn font-main"> 0 </h6>
                        <h6 class="font-main"> اجمالي الكمية </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center">
                        <h6 class="netTotal font-main"> 0 </h6>
                        <h6 class="font-main"> الاجمالي </h6>
                    </div>
                    
                </div>

                <div class="d-flex justify-content-between px-4 align-items-center mb-2 footerList w-100">
                    <h6 class="font-main"> 0550160849 </h6>
                    <h6 class="font-main"> للتوصيل </h6>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" > </script>

    <script>
        window.addEventListener('beforeunload', function (e) {
            e.preventDefault();
            e.returnValue = '';
        });
        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
        });
    </script>

    <script>
        let netTotal = 0;
        let netQun = 0;
        if (window.parameters) {
            let items = JSON.parse(window.parameters);
            // console.log(items);
            if (items) {
                let item;
                items.data.forEach(option => {
                    netTotal += +option.total;
                    netQun += +option.qtn;
                    item = `
                    <div class="w-100 tr-items-all d-flex justify-content-between text-center">
                        <h6 class="w-25"> ${option.name} </h6>
                        <h6 class="w-25"> ${option.price1} </h6>

                        <h6 class="w-25 input-qtn-${option.id}"> ${option.qtn} </h6>
                        <h6 class="w-25 total-${option.id}"> ${option.total} </h6>
                    </div>`
                    $('.bodyPrinter').append(item)
                });
                $('.netTotal').text(netTotal)
                $('.netQtn').text(netQun)
                // $('.companyName').text(items.company.companyNameAr)
                $('.invoiceId').text(items.branch.id)
                let img = `<img class="rounded" src="{{asset('comp/${items.company.logo}')}}" alt="">`;
                $('.logo').html(img)
            }
        }
        window.focus();
        window.print();
        window.onafterprint = window.close;
    </script>






</body>

</html>
