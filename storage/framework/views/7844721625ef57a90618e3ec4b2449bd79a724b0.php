<?php $__env->startSection('main-content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-12 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> تقرير ارباح الفواتير مجمع </li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="px-3">
                        <div class="form-row align-items-center flex-row-reverse">
                            <div class="col-sm-3 my-1 text-right">
                                <label class="font-main text-right"> من تاريخ </label>
                                <input type="datetime-local" class="form-control fromDate" />
                            </div>
                            <div class="col-sm-3 my-1 text-right">
                                <label class="font-main text-right"> الي تاريخ </label>
                                <input type="datetime-local" class="form-control toDate" />
                            </div>

                            <div class="col-12 my-1 text-right">
                                <button onclick="filterDate(event)" class="btn btn-primary font-main px-3"> بحث
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row flex-row-reverse font-main px-5 my-5">
                        <div class="col-12 col-md-6">
                            <div class="btn-primary text-right p-2">
                                <p class="text-light font-weight-bold mb-0 pb-0 px-2"> اجماليات </p>
                            </div>
                            <div class="details">
                                <table class="table" dir="rtl">
                                    <tbody>
                                        <tr>
                                            <th class="text-right"> اجمالي بدون ضريبة </th>
                                            <td class="text-center priceAfterTaxVal"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> مرتجع مبيعات </th>
                                            <td class="text-center price_before_returned"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> اجمالي الخصم </th>
                                            <td class="text-center discountTotla"> 00 </td>
                                        </tr>

                                        <tr>
                                            <th class="text-right"> الاجمالي النهائي </th>
                                            <td class="text-center finalTotal"> 00 </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="btn-primary text-right p-2">
                                <p class="text-light font-weight-bold mb-0 pb-0 px-2"> عملية الدفع </p>
                            </div>
                            <div class="details">
                                <table class="table" dir="rtl">
                                    <tbody>
                                        <tr>
                                            <th class="text-right"> كاش </th>
                                            <td class="cashVal text-center"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> فيزا </th>
                                            <td class="text-center visahVal"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right">مستر كارد</th>
                                            <td class="text-center masterCardVal"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> اجل </th>
                                            <td class="text-center creditVal"> 00 </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>




                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 mx-auto">
                            <canvas id="myChart" style="width:100%;max-width:700px"></canvas>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="btn-primary text-right p-2">
                                <p class="text-light font-weight-bold mb-0 pb-0 px-2 font-main"> الارباح </p>
                            </div>
                            <div class="details">
                                <table class="table" dir="rtl">
                                    <tbody>
                                        <tr>
                                            <th class="text-right font-main"> قيمة الربح </th>
                                            <td class="profit text-center font-weight-bold"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right font-main"> نسبة الربح </th>
                                            <td class="text-center profit-precent font-weight-bold"> 00 </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="salesInvoice-dataTable2" dir="rtl" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr class="text-center font-main">
                                        <th>م</th>
                                        <th> رقم الفاتورة </th>
                                        <th> الفرع </th>
                                        <th> التاريخ </th>
                                        <th> العميل </th>
                                        <th> المندوب </th>
                                        <th> السعر </th>
                                        <th> الخصم % </th>
                                        <th> الخصم </th>
                                        <th> الصافي </th>
                                        <th> التكلفة </th>
                                        <th> نسبة الربح </th>
                                        <th> الربح </th>

                                    </tr>
                                </thead>
                                <tbody class="bodyTableSales">

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>" rel="stylesheet">

    <link href="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
    <style>
        .table-responsive {
            max-height: 400px !important;
            overflow-y: auto;
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src=" <?php echo e(asset('js/jquery.js')); ?> "></script>
    <script src=" <?php echo e(asset('js/bootstrap-datepicker.js')); ?> "></script>
    <script src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('js/sweetalert.min.js')); ?> "></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo e(asset('backend/js/demo/datatables-demo.js')); ?>"></script>


    <script src="<?php echo e(asset('backend/vendor/chart.js/Chart.min.js')); ?>"></script>

    <script>
        let netTotal = 0;
        let netTotalReturned = 0;
        let priceAfterTax = 0;
        let taxRateTotal = 0;
        let cash = 0;
        let visa = 0;
        let masterCard = 0;
        let credit = 0;
        let itemsQtn = 0;


        let net = 0;
        let price_before = 0;
        let price_before_returned = 0;
        let discountValues = 0;
        let profit = 0;
        let totalAv_price = 0;
        let totalCost = 0;

        let newTotalSale = 0;
        let newTotalReturnedSale = 0;

        function filterDate(event) {
            event.preventDefault();
            let from = $('.fromDate').val();
            let to = $('.toDate').val();
            $.ajax({
                type: 'POST',
                url: "/erp/public/sale/filter-billing",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    from,
                    to
                },
                success: function(data) {
                    let item = '';
                    netTotal = 0;
                    cash = 0;
                    visa = 0;
                    masterCard = 0;
                    credit = 0;

                    newTotalSale = 0;
                    newTotalReturnedSale = 0;
                    totalCost = 0;

                    price_before = 0;
                    price_before_returned = 0;
                    discountValues = 0;
                    profit = 0;

                    $('.bodyTableSales').html('<span></span>');
                    data.orders.forEach(calc => {
                        cash += calc.cash;
                        visa += calc.visa;
                        masterCard += calc.masterCard;
                        credit += calc.credit;
                    });


                    data.orders.forEach((element, i) => {
                        netTotal += element.netTotal;
                        price_before += element.price;
                        discountValues += element.discountValue;
                        let totalPrice = element.total - element.discountValue;
                        element.profit = totalPrice - element.av_price;
                        let Precent = (totalPrice - element.av_price) * 100 / totalPrice;
                        totalAv_price += totalPrice;
                        totalCost += element.av_price;
                        newTotalSale = +totalPrice;
                        item = `
                            <tr class="text-center font-main">
                                <td>${ i + 1 }</td>
                                <td>${ element.id }</td>
                                <td>${ element.branch_name }</td>
                                <td>${ new Date(element.created_at).toLocaleString() }</td>
                                <td> ${element.customer} </td>
                                <td> </td>
                                <td> ${element.price} </td>
                                <td> ${element.discount} </td>
                                <td> ${element.discountValue} </td>
                                <td> ${totalPrice} </td>
                                <td> ${element.av_price} </td>
                                <td class="${element.total - element.av_price > 0 ? "text-success" : "text-danger"}">
                                    ${  +Precent.toFixed(3) } %
                                </td>

                                <td class="${totalPrice - element.av_price > 0 ? "text-success" : "text-danger"}">
                                    ${+(totalPrice - element.av_price).toFixed(3) }
                                </td>
                            </tr>
                            `
                        $('.bodyTableSales').append(item);

                    });


                    data.orders2.forEach((element, i) => {
                        netTotalReturned += element.netTotal;
                        price_before_returned += element.price - element.discountValue;
                        let totalPrice = element.total - element.discountValue;
                        element.profit = totalPrice - element.av_price;
                        let Precent = (totalPrice - element.av_price) * 100 / totalPrice;

                        totalAv_price += totalPrice;

                        newTotalReturnedSale += totalPrice;
                        totalCost += element.av_price;

                        item = `
                            <tr class="text-center font-main bg-info">
                                <td>${ i + 1 }</td>
                                <td>${ element.id }</td>
                                <td>${ element.branch_name }</td>
                                <td>${ new Date(element.created_at).toLocaleString() }</td>
                                <td> ${element.customer} </td>
                                <td> </td>
                                <td> ${element.price} </td>
                                <td> ${element.discount} </td>
                                <td> ${element.discountValue} </td>
                                <td> ${totalPrice} </td>
                                <td> ${element.av_price} </td>
                                <td> ${ +Precent.toFixed(3) } % </td>
                                <td class="${totalPrice - element.av_price > 0 ? "text-success" : "text-danger"}">
                                    ${+(totalPrice - element.av_price).toFixed(3) }
                                </td>
                            </tr>
                            `
                        $('.bodyTableSales').append(item);

                    });
                    $('.cashVal').text(cash);
                    $('.visahVal').text(visa);
                    $('.masterCardVal').text(masterCard);
                    $('.creditVal').text(credit);
                    $('.priceAfterTaxVal').text(+price_before.toFixed(4));
                    $('.price_before_returned').text(+price_before_returned.toFixed(4));

                    $('.discountTotla').text(+discountValues.toFixed(4));
                    let lastTotal = price_before - price_before_returned - discountValues;
                    $('.finalTotal').html(+lastTotal.toFixed(4));

                    let totalLast = newTotalSale - totalCost;
                    $('.profit').html(totalLast);
                    let precentTotal = (totalLast * 100) / newTotalSale;
                    $('.profit-precent').html(`${+precentTotal.toFixed(3) } %`);



                    var xValues = ["المبيعات", "المرتجعات", "الربح", "نسبة الربح"];
                    var yValues = [newTotalSale, newTotalReturnedSale, totalLast, precentTotal];
                    console.log(newTotalSale);
                    console.log(newTotalReturnedSale);
                    var barColors = [
                        "#1e7145",
                        "#2b5797",
                        "#00aba9",
                        "#ffa500",
                    ];
                    new Chart("myChart", {
                        type: "pie",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: "نسبة وقيمة المكسب والخسائر"
                            }
                        }
                    });


                }
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/SalesBill/reports/billing.blade.php ENDPATH**/ ?>