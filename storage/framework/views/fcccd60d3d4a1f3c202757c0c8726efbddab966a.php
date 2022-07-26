<?php $__env->startSection('main-content'); ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تفاصيل الشيفت </li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>
    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right"><?php echo \Session::get('success'); ?></li>
            </ul>
        </div>
    <?php endif; ?>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-right font-main "> تفاصيل الشيفت </h6>
        </div>
    </div>

    <div class="container font-main">
        <form action="<?php echo e(route('generate-pdf', $id)); ?>">

            <div class="row flex-row-reverse">

                <div class="text-right mb-5">
                    <button type="submit" class="btn btn-primary text-right"> Export PDF </button>
                </div>

                <div class="col-12">
                    <div class="btn-primary text-right p-2">
                        <p class="text-light font-weight-bold mb-0 pb-0 px-2"> الاجماليات </p>
                    </div>
                    <div class="details mb-5">
                        <table class="table" dir="rtl">
                            <thead>
                                <tr style="background: #ddd;color: #000 !important">
                                    <th class="text-right"> النوع </th>
                                    <th class="text-center"> المدفوع </th>
                                    <th class="text-center"> الضريبة </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="text-right"> فاتورة </th>
                                    <td class="text-center"> <?php echo e($PaymentTotal); ?> </td>
                                    <td class="text-center"> <?php echo e($taxValue); ?> </td>
                                </tr>
                                <tr>
                                    <th class="text-right"> اشعار خصم </th>
                                    <td class="text-center"> 0 </td>
                                    <td class="text-center"> 0 </td>
                                </tr>
                                <tr>
                                    <th class="text-right"> اشعار اضافة </th>
                                    <td class="text-center"> 0 </td>
                                    <td class="text-center"> 0 </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 body-style-voices">

                    <table class="table table-striped" dir="rtl">
                        <div class="btn-primary text-right p-2">
                            <p class="text-light font-weight-bold mb-0 pb-0 px-2"> الفواتير </p>
                        </div>
                        <thead class="">
                            <tr class="text-center font-main my-5" style="background: #716eab; color: #fff">
                                <th> رقم الفاتورة </th>
                                <th> التاريخ </th>
                                <th> العميل </th>
                                <th> الصافي </th>
                                <th> طريقة الدفع </th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-center font-main">
                                    <td><?php echo e($order->id); ?></td>
                                    <td><?php echo e($order->created_at); ?></td>
                                    <td>
                                        <?php echo e($customers->find($order->customerId)->name); ?>

                                    </td>
                                    <td>
                                        <?php echo e($order->netTotal); ?>

                                    </td>
                                    <td> كاش </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>



                <div class="col-12 body-style-items">
                    <table class="table table-striped" dir="rtl">
                        <div class="btn-primary text-right p-2">
                            <p class="text-light font-weight-bold mb-0 pb-0 px-2"> الاصناف </p>
                        </div>
                        <thead class="">
                            <tr class="text-center font-main my-5" style="background: #716eab; color: #fff">
                                <th> الصنف </th>
                                <th> الوحدة </th>
                                <th> الكمية </th>
                                <th> السعر </th>
                                <th> الضرائب </th>
                                <th> اجمالي </th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <?php $__currentLoopData = $InvoicesDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-center font-main">
                                    <td> <?php echo e($order->item_name); ?> </td>
                                    <td> <?php echo e($order->unit_name); ?> </td>
                                    <td class="">
                                        <?php echo e($order->qtn); ?>

                                    </td>
                                    <td> <?php echo e($order->price); ?> </td>

                                    <td> <?php echo e($order->value); ?> </td>
                                    <td> <?php echo e($order->nettotal); ?> </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        .body-style-voices,
        .body-style-items {
            max-height: 400px !important;
            overflow-y: auto !important;
            margin: 30px 0
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

    <!-- Page level plugins -->
    <script src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo e(asset('backend/js/demo/datatables-demo.js')); ?>"></script>

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

    <script>
        $(document).ready(function() {
            $('#items-dataTable').DataTable({
                "dom": 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        });
    </script>




<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/reports/show.blade.php ENDPATH**/ ?>