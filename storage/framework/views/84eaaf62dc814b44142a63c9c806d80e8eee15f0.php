<?php $__env->startSection('main-content'); ?>


    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> <?php echo e(__('pos.branches')); ?> </li>
            <li class="breadcrumb-item"><a href="/erp/public/home"><?php echo e(__('pos.main')); ?></a></li>
        </ol>
    </nav>
    <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right"><?php echo \Session::get('success'); ?></li>
            </ul>
        </div>
    <?php endif; ?>


    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left"> <?php echo e(__('pos.branches')); ?> </h6>
            <a href="<?php echo e(route('branches.create')); ?>" class="btn  font-main btn-primary btn-sm float-right"
                data-toggle="tooltip" data-placement="bottom" title="Add Branches"><i class="fas fa-plus"
                    style="font-size: 10px"></i> <?php echo e(__('pos.addBarcnch')); ?> </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="branches-dataTable" dir="rtl" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center font-main">
                            <th> <?php echo e(__('pos.Num')); ?> </th>
                            <th> <?php echo e(__('pos.nameBranch')); ?> </th>
                            <th> <?php echo e(__('pos.city')); ?> </th>
                            <th> <?php echo e(__('pos.Region')); ?> </th>
                            <th> <?php echo e(__('pos.addess')); ?> </th>
                            <th> <?php echo e(__('pos.phone')); ?> </th>
                            <th> <?php echo e(__('pos.edit')); ?> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branche): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="text-center font-main">
                                <td><?php echo e($branche->id); ?></td>
                                <td><?php echo e($branche->namear); ?></td>
                                <td><?php echo e($branche->city); ?></td>
                                <td><?php echo e($branche->region); ?></td>
                                <td><?php echo e($branche->address); ?></td>
                                <td><?php echo e($branche->phone); ?></td>
                                <td>
                                    <a href="<?php echo e(route('branches.edit', $branche->id)); ?>"
                                        class="btn btn-primary btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                        data-placement="bottom"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="<?php echo e(route('branches.destroy', [$branche->id])); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('delete'); ?>
                                        <button class="btn btn-danger btn-sm dltBtn" data-id=<?php echo e($branche->id); ?>

                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>

                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <span style="float:right"><?php echo e($branches->links()); ?></span>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
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
        // $('#branches-dataTable').DataTable({
        //     "columnDefs": [{
        //         "orderable": false,
        //         "targets": [6, 7]
        //     }]
        // });
        $(document).ready(function() {
            $('#branches-dataTable').DataTable();
        });

        // Sweet alert

        function deleteData(id) {

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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/branches/index.blade.php ENDPATH**/ ?>