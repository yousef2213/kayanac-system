<?php $__env->startSection('main-content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> فواتير المبيعات </li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Sales </h6>
                        <a href="<?php echo e(route('salesBill.create')); ?>" class="btn btn-primary font-main btn-sm float-right"
                            data-toggle="tooltip" data-placement="bottom" title="Add Purchases">
                            <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
                        </a>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="salesInvoice-dataTable" dir="rtl" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr class="text-center font-main">
                                        <th> رقم الفاتورة </th>
                                        <th> التاريخ </th>
                                        <th> العميل </th>
                                        <th> الصافي </th>
                                        <th> طريقة الدفع </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bodyTableSales">
                                    <?php $__currentLoopData = $Invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="text-center font-main">
                                            <td><?php echo e($Invoice->id); ?></td>
                                            <td><?php echo e($Invoice->created_at); ?></td>
                                            <td>
                                                <?php echo e($Invoice->customer_name); ?>

                                            </td>
                                            <td>
                                                <?php echo e($Invoice->netTotal); ?>

                                            </td>
                                            <td>
                                                <?php if($Invoice->status == 2): ?>
                                                    <span class="bagde bg-success py-1 rounded text-light d-inline-block"
                                                        style="width: 60px"> اجل </span>
                                                <?php endif; ?>
                                                <?php if($Invoice->status == 1): ?>
                                                    <span class="bagde bg-success py-1 rounded text-light d-inline-block"
                                                        style="width: 60px"> كاش </span>
                                                <?php endif; ?>
                                                <?php if($Invoice->status == 3): ?>
                                                    <span class="bagde bg-warning py-1 rounded d-inline-block"
                                                        style="width: 60px"> معلقة </span>
                                                <?php endif; ?>
                                                <?php if($Invoice->status == 4): ?>
                                                    <span class="bagde bg-warning py-1 rounded d-inline-block"
                                                        style="width: 60px"> توصيل </span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="width: 120px">
                                                <div class="d-flex justify-content-between">

                                                    <a href="<?php echo e(route('sales.print', $Invoice->id)); ?>"
                                                        class="btn btn-info btn-sm  mr-1">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('salesBill.edit', $Invoice->id)); ?>"
                                                        class="btn btn-primary btn-sm mr-1" data-toggle="tooltip"
                                                        title="edit" data-placement="bottom"><i
                                                            class="fas fa-edit"></i></a>
                                                    <form method="POST"
                                                        action="<?php echo e(route('salesBill.destroy', [$Invoice->id])); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('delete'); ?>
                                                        <button class="btn btn-danger btn-sm dltBtn"
                                                            data-id=<?php echo e($Invoice->id); ?> data-toggle="tooltip"
                                                            data-placement="bottom" title="Delete"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('js/sweetalert.min.js')); ?> "></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo e(asset('backend/js/demo/datatables-demo.js')); ?>"></script>

    <script>
        $(document).ready(function() {
            $('#salesInvoice-dataTable').DataTable();
        });
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/SalesBill/index.blade.php ENDPATH**/ ?>