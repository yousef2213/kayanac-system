<?php $__env->startSection('main-content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-12 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> تقرير المبيعات </li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="px-3">
                        <div class="form-row align-items-center flex-row-reverse">
                            <div class="col-sm-3 my-1 text-right">
                                <label class="font-main text-right"> من تاريخ </label>
                                <input type="date" class="form-control fromDate" />
                            </div>
                            <div class="col-sm-3 my-1 text-right">
                                <label class="font-main text-right"> الي تاريخ </label>
                                <input type="date" class="form-control toDate" />
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
                                            <th class="text-right"> اجمالي قيمة مضافة </th>
                                            <td class="text-center totalTaxRate"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> اجمالي شامل الضريبة </th>
                                            <td class="text-center netTotal"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> خدمة توصيل </th>
                                            <td class="text-center delever"> 00 </td>
                                        </tr>
                                        <tr>
                                            <th class="text-right"> خصم اضافي </th>
                                            <td class="text-center"> 00 </td>
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


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="salesInvoice-dataTable2" dir="rtl" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr class="text-center font-main">
                                        <th> رقم الفاتورة </th>
                                        <th> التاريخ </th>
                                        <th> العميل </th>
                                        <th> الصافي </th>
                                        <th> طريقة الدفع </th>

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

    <script>
        let netTotal = 0;
        let netTotal2 = 0;
        let priceAfterTax = 0;
        let taxRateTotal = 0;
        let cash = 0;
        let visa = 0;
        let masterCard = 0;
        let credit = 0;
        let itemsQtn = 0;


        let net = 0;
        let price_before = 0;

        function filterDate(event) {
            event.preventDefault();
            let from = $('.fromDate').val();
            let to = $('.toDate').val();
            $.ajax({
                type: 'POST',
                url: "/erp/public/filter-items",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    from,
                    to
                },
                success: function(data) {
                    let item = '';
                    netTotal = 0;
                    netTotal2 = 0;
                    priceAfterTax = 0;
                    taxRateTotal = 0;
                    cash = 0;
                    visa = 0;
                    masterCard = 0;
                    credit = 0;
                    itemsQtn = 0;


                    net = 0;
                    price_before = 0;

                    $('.bodyTableSales').html('<span></span>');
                    data.orders.forEach(calc => {
                        cash += calc.cash;
                        visa += calc.visa;
                        masterCard += calc.masterCard;
                        credit += calc.credit;
                    });

                    data.InvoicesDetails.forEach(it => {
                        if (it.priceWithTax == "1") {
                            it.priceafterTax = (it.price / `1.${it.rate}`) * it.qtn;
                            it.TaxVal = (it.price * it.rate / 100) * it.qtn;
                        } else {
                            it.priceafterTax = it.price * it.qtn;
                            it.TaxVal = (it.price * it.rate / 100) * it.qtn;
                        }
                    });


                    data.orders.forEach(invoice => {
                        net += +invoice.netTotal;
                    });
                    data.InvoicesDetails.forEach(invoice => {
                        taxRateTotal += +invoice.value * +invoice.qtn;
                        price_before += +invoice.priceafterTax + invoice.qtn;
                    });

                    console.log(data);
                    let delever = 0;
                    data.orders.forEach(element => {
                        netTotal2 += element.netTotal;
                        delever += element.deleiver;
                        let cashText = '';
                        if(element.cash != 0) {
                            cashText += "كاش";
                            cashText += "-";
                        }
                        if(element.visa != 0) {
                            cashText += "فيزا";
                            cashText += "-";
                        }
                        if(element.masterCard != 0) {
                            cashText += "masterCard";
                            cashText += "-";
                        }
                        if(element.credit != 0) {
                            cashText += "اجل";
                            cashText += "-";
                        }
                        item += `
                        <tr class="text-center font-main">
                                <td>${ element.id }</td>
                                <td>${ new Date(element.created_at).toLocaleString() }</td>
                                <td>
                                    ${element.customer}
                                </td>
                                <td>
                                    ${ element.netTotal }
                                </td>
                                <td>
                                    ${element.payment == 10 ? cashText : element.payment}
                                </td>

                            </tr>
                        `
                    });
                    $('.bodyTableSales').html(item);
                    priceAfterTax = +priceAfterTax.toFixed(2)
                    $('.cashVal').text(cash);
                    $('.visahVal').text(visa);
                    $('.masterCardVal').text(masterCard);
                    $('.creditVal').text(credit);

                    $('.totalTaxRate').text(+taxRateTotal.toFixed(2));
                    $('.netTotal').text(+net.toFixed(2));
                    $('.finalTotal').text(net);
                    $('.priceAfterTaxVal').text(+(net - taxRateTotal).toFixed(4));
                    $('.delever').text(+delever);


                }
            });
        }
        $(document).ready(function() {});
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/ItemsSales/index.blade.php ENDPATH**/ ?>