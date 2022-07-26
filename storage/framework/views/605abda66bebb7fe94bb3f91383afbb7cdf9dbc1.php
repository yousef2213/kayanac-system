<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title> Erp - Print Shifts </title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo e(asset('backend/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?php echo e(asset('backend/css/sb-admin-2.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">

</head>

<style>
    .col-print {
        width: 50% !important;
    }

    @media (max-width: 700px) {
        .col-print {
            width: 100% !important;
        }
    }

    @media  print {
        button {
            display: none !important;
        }

        .font-main {
            font-family: 'Tajawal', sans-serif !important;
        }

        html,
        body {
            -webkit-print-color-adjust: exact !important;
            height: auto;
            font-weight: 900;
            font-family: 'Tajawal', sans-serif !important;
            font-size: 35px !important;
            size: auto;
            color: #000;
            margin: 0 background-color: #fff;
        }

        .col-print {
            max-width: 100% !important;
            width: 100% !important;
        }

        .tr-print-account {
            font-weight: bold;
        }
    }

    /* Preloader */
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 999999999;
        width: 100%;
        height: 100%;
        background-color: #f1f1f2;
        opacity: 0.6;
        overflow: hidden;
    }

    .hiden-pre-load {
        display: none !important;
    }

    .preloader-inner {
        position: absolute;
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .preloader-icon {
        width: 100px;
        height: 100px;
        display: inline-block;
        padding: 0px;
    }

    .btn-delete {
        font-size: 12px
    }

</style>

<body>
    <div class="container-fluid">
        <!-- Preloader -->
        <div class="preloader">
            <div class="preloader-inner">
                <div class="preloader-icon">
                    <img src="<?php echo e(asset('/pandig.svg')); ?>" alt="">
                </div>
            </div>
        </div>
        <!-- End Preloader -->
        <div class="container">
            <div class="col-print mx-auto text-center my-4">
                <div class="total">
                    <div class="row">
                        <div class="col-12 mx-auto text-center logo">

                        </div>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2 mb-2">
                        <h5 class="invoiceId font-main"> 0 </h5>
                        <h5 class="font-main"> رقم الفاتورة </h5>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2 mb-2">
                        <h5 class="companyName font-main"> </h5>
                        <h5 class="font-main"> اسم الشركة </h5>
                    </div>
                </div>

                <table class="table table-striped px-0 font-main text-center" dir="rtl">
                    <thead>
                        <tr>
                            <th scope="col"> الصنف </th>
                            <th scope="col"> السعر </th>
                            <th scope="col"> الكمية </th>
                            <th scope="col">الاجمالي</th>
                        </tr>
                    </thead>
                    <tbody class="bodyPrinter">

                    </tbody>
                </table>
                <hr>
                <div class="total">
                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="totalSalles font-main"> 00 </h6>
                        <h6 class="font-main"> اجمالي المبيعات </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="discountSalles font-main"> 00 </h6>
                        <h6 class="font-main"> خصم مبيعات </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="returnSalles font-main"> 00 </h6>
                        <h6 class="font-main"> مرتجع مبيعات </h6>
                    </div>

                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="totalTaxRate font-main"> 0 </h6>
                        <h6 class="font-main"> ضريبة القيمة المضافة </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="tax_source font-main"> 0 </h6>
                        <h6 class="font-main"> ضريبة خصم المنبع </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="develery font-main"> 00 </h6>
                        <h6 class="font-main"> خدمة توصيل </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="payCach font-main"> 00 </h6>
                        <h6 class="font-main"> مدفوع نقدا </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="SBKA font-main"> 00 </h6>
                        <h6 class="font-main"> شبكة </h6>
                    </div>
                    <div class="d-flex justify-content-between px-4 align-items-center my-2">
                        <h6 class="visa font-main"> 00 </h6>
                        <h6 class="font-main"> فيزا </h6>
                    </div>

                </div>
            </div>

            <hr>
            <div class="text-center mb-5 mt-2">
                
                
            </div>
        </div>
    </div>
    </div>

    <script src="<?php echo e(asset('js/jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"> </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        window.onload = function() {
            document.querySelector('.preloader').classList.add("hiden-pre-load");
        }
    </script>
    <script>
        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
        });
    </script>

    <script>
        let netTotal = 0;
        let netTotal2 = 0;
        let netTotalHold = 0;
        let netQun = 0;
        let netQunHold = 0;

        let Optimzation = [];
        if (window.parameters) {
            let items = JSON.parse(window.parameters);
            if (items) {
                Optimzation = [];

                let item;
                let itemHold;
                let taxRateTotal = 0;
                let priceAfter = 0;
                let payCach = 0;
                let deleve = 0;
                console.log(items);

                let tax_source = 0;
                items.Orders.forEach(el => {
                    deleve += el.deleiver;
                });

                items.InvoicesDetails.forEach(option => {
                    let namear = items.units.find(unit => unit.id == option.unit_id).namear;
                    netTotal += +option.price * +option.qtn;
                    netTotal2 += option.nettotal;
                    netQun += +option.qtn;
                    taxRateTotal += +option.value * +option.qtn;
                    priceAfter += +option.price * +option.qtn;
                    let old_item = document.querySelectorAll(
                        `.input-qtn-${option.unit_id}-${option.item_id}-${option.price}`);
                    if (old_item.length != 0) {
                        let itemO = Optimzation.find(op => op.item_id == option.item_id && op.unit_id == option
                            .unit_id);
                        itemO.qtn += option.qtn;
                        document.querySelector(`.input-qtn-${option.unit_id}-${option.item_id}-${option.price}`)
                            .innerHTML = option.qtn + +document.querySelector(
                                `.input-qtn-${option.unit_id}-${option.item_id}-${option.price}`).innerHTML
                        document.querySelector(`.total-${option.unit_id}-${option.item_id}-${option.price}`)
                            .innerHTML = option.total + +document.querySelector(
                                `.total-${option.unit_id}-${option.item_id}-${option.price}`).innerHTML
                    } else {
                        Optimzation.push(option);
                        item = `
                            <tr class="">
                                <td scope="row"> ${option.item_name} - ${namear} </td>
                                <td> ${option.price || 0} </td>

                                <td class="input-qtn-${option.unit_id}-${option.item_id}-${option.price}"> ${option.qtn} </td>
                                <td class="total-${option.unit_id}-${option.item_id}-${option.price}"> ${option.nettotal || 0} </td>
                            </tr>`
                        $('.bodyPrinter').append(item)
                    }

                });

                netTotal = +netTotal.toFixed(2)
                netTotalHold = +netTotalHold.toFixed(2);

                let cach = +priceAfter + +taxRateTotal;
                $('.totalSalles').text(+(netTotal2 - taxRateTotal).toFixed(4));
                // $('.payCach').text(+(netTotal2).toFixed(2));

                $('.groupTotal').text(priceAfter);
                $('.totalTaxRate').text(+taxRateTotal.toFixed(2))
                $('.netTotalHold').text(netTotalHold)
                $('.netQtn').text(netQun)
                $('.netQtnHold').text(netQunHold)
                // company name
                $('.companyName').text(items.company.companyNameAr)
                $('.invoiceId').text(items.branch.id)
                let img = `<img class="rounded" width="100" src="<?php echo e(asset('comp/${items.company.logo}')); ?>" alt="">`;
                $('.logo').html(img)
                $('.develery').html(deleve)

                items.Orders.forEach(order => {
                    tax_source += order.taxSource;
                });
                tax_source = tax_source * netTotal2 / 100;
                $('.tax_source').html(tax_source);
                $('.payCach').text(+((netTotal2 - +tax_source + deleve)).toFixed(2));


            }
        }

        function youPrint() {
            window.focus();
            window.print();
        }
    </script>


</body>

</html>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/POS/closeShiftPrinter.blade.php ENDPATH**/ ?>