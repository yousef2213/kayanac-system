<?php $__env->startSection('main-content'); ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> قيود اليومية </li>
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
            <h6 class="m-0 font-weight-bold text-primary float-left font-main"> قيود يومية </h6>
            <a href="<?php echo e(route('daily.create')); ?>" class="btn btn-primary font-main btn-sm float-right"
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
                            <th> رقم القيد </th>
                            <th> document </th>
                            <th> رقم المصدر </th>
                            <th> المصدر </th>
                            <th> بيان </th>
                            <th> فرع </th>
                            <th> مدين </th>
                            <th> دائن </th>
                            <th> تاريخ </th>

                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="bodyTableSales text-center">
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($invoice->id); ?></td>
                                <td><?php echo e($invoice->document); ?></td>
                                <td><?php echo e($invoice->source); ?></td>
                                <td><?php echo e($invoice->source_name); ?></td>
                                <td><?php echo e($invoice->description); ?></td>
                                <td><?php echo e($invoice->branshName); ?></td>
                                <td> <?php echo e($invoice->debtor); ?> </td>
                                <td><?php echo e($invoice->creditor); ?></td>
                                <td> <?php echo e($invoice->date); ?> </td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <a href="<?php echo e(route('daily.print', [$invoice->id])); ?>"
                                            class="btn btn-primary btn-sm  mr-1">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <?php if($invoice->manual == 1): ?>
                                            <a href="<?php echo e(route('daily.edit', $invoice->id)); ?>"
                                                class="btn btn-primary btn-sm float-left mr-1"
                                                data-toggle="tooltip"
                                                title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

                                            <form method="POST" action="<?php echo e(route('daily.destroy', [$invoice->id])); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('delete'); ?>
                                                <button class="btn btn-danger btn-sm dltBtn" data-id=<?php echo e($invoice->id); ?>

                                                    data-toggle="tooltip" data-placement="bottom" title="Delete"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>

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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/DailyRestrictions/index.blade.php ENDPATH**/ ?>