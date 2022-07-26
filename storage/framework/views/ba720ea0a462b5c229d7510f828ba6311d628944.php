<?php $__env->startSection('main-content'); ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تقارير اليومية </li>
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
            <h6 class="m-0 font-weight-bold text-primary float-left font-main"> Daily Reports </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="items-dataTable"dir="rtl" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center font-main">
                            <th>  <?php echo e(__('general.numOrder')); ?> </th>
                            <th> <?php echo e(__('general.startshift')); ?> </th>
                            <th> نهاية الشيفت </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $__currentLoopData = $Shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-center font-main">

                                <td><?php echo e($shift->id); ?></td>
                                <td> <?php echo e(\Carbon\Carbon::parse($shift->openDate)->format('d-m-Y h:m a')); ?> </td>
                                <td><?php echo e(\Carbon\Carbon::parse($shift->closeDate)->format('d-m-Y h:m a')); ?> </td>

                                <?php if($shift->closeing == 1): ?>
                                <td class="text-center">
                                    <a
                                        href="<?php echo e(route('reports.show', $shift->id)); ?>"
                                        class="btn btn-primary btn-sm  mr-1"
                                        data-toggle="tooltip"
                                        title="show"
                                        data-placement="bottom">
                                        عرض تفاصيل

                                    </a>
                                </td>
                            <?php else: ?>
                                <td class="text-center">
                                    <button
                                        disabled
                                        class="btn btn-primary btn-sm  mr-1"
                                        data-toggle="tooltip"
                                        title="show"
                                        data-placement="bottom"
                                        >
                                        هذا الشيفت مفتوح الان

                                    </button>
                                </td>

                            <?php endif; ?>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        /* div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        } */

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
        $(document).ready( function () {
            $('#items-dataTable').DataTable({
                "dom": 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

        });
    </script>




<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/reports/index.blade.php ENDPATH**/ ?>