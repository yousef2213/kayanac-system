<?php $__env->startSection('main-content'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> فواتير مشتريات </li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Purchases </h6>
            <a href="<?php echo e(route('ItemsPurchases.create')); ?>" class="btn btn-primary font-main btn-sm float-right"
                data-toggle="tooltip" data-placement="bottom" title="Add Purchases">
                <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
            </a>
        </div>
        <div class="card-body font-main">
            <div class="table-responsive">
                <table class="table text-dark table-bordered" id="salesInvoice-dataTable" dir="rtl" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr class="text-center font-main">
                            <th> رقم الفاتورة </th>
                            <th> اسم المورد </th>
                            <th> رقم فاتورة المورد </th>
                            <th> فرع </th>
                            <th> تاريخ </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="bodyTableSales text-center">
                        <?php $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($purchase->id); ?></td>
                                <td><?php echo e($suppliers->find($purchase->supplier)->name); ?></td>
                                <td> <?php echo e($purchase->supplier_invoice); ?> </td>
                                <td><?php echo e($branches->find($purchase->branchId)->namear); ?></td>
                                <td> <?php echo e($purchase->dateInvoice); ?> </td>
                                <td>
                                    <a href="<?php echo e(route('ItemsPurchases.edit', $purchase->id)); ?>"
                                        class="btn btn-primary btn-sm float-left mr-1" data-toggle="tooltip" title="edit"
                                        data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="<?php echo e(route('ItemsPurchases.destroy', [$purchase->id])); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('delete'); ?>
                                        <button class="btn btn-danger btn-sm dltBtn" data-id=<?php echo e($purchase->id); ?>

                                            data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                                <div class="modal fade" id="delModalCustomer<?php echo e($purchase->id); ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="#delModalCustomer<?php echo e($purchase->id); ?>Label"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="#delModalCustomer<?php echo e($purchase->id); ?>Label">
                                                    Delete user </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post"
                                                    action="<?php echo e(route('ItemsPurchases.destroy', $purchase->id)); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('delete'); ?>
                                                    <button type="submit" class="btn btn-danger"
                                                        style="margin:auto; text-align:center">Parmanent delete
                                                        user</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
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

        function filterDate(event) {
            event.preventDefault();
        }
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
                // alert(dataID);
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/Purchases/index.blade.php ENDPATH**/ ?>