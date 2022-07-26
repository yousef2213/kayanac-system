<?php $__env->startSection('main-content'); ?>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> رصيد افتتاحي للحسابات </li>
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


    <div class="row">
        <div class="col-12 col-md-6 font-main"></div>
        <div class="col-12 col-md-6 font-main">
            <table class="table table-border">
                <thead class="text-center">
                    <tr>
                        <th colspan="2" style="font-size: 15px">اجماليات</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td colspan="1" style="font-size: 15px"> اجمالي المدين </td>
                        <td colspan="1" style="font-size: 15px" class="md text-success">
                            <?php echo e(isset($invoice) ? $invoice->debtor : 0); ?> </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px"> اجمالي الدائن </td>
                        <td style="font-size: 15px" class="da text-danger">
                            <?php echo e(isset($invoice) ? $invoice->creditor : 0); ?> </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px"> الفرق </td>
                        <td style="font-size: 15px" class="def">
                            <?php echo e(isset($invoice) ? $invoice->debtor - $invoice->creditor : 0); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left font-main"> رصيد افتتاحي </h6>
            <?php if($show == 1): ?>
                <a href="<?php echo e(route('opening_balance_accounts.create')); ?>"
                    class="btn btn-primary font-main btn-sm float-right" data-toggle="tooltip" data-placement="bottom"
                    title="Add Purchases">
                    <i class="fas fa-plus" style="font-size: 10px"></i> اضافة
                </a>
            <?php endif; ?>

        </div>
        <div class="card-body font-main">
            <div class="table-responsive">
                <table class="table text-dark table-bordered" id="salesInvoice-dataTable" dir="rtl" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr class="text-center font-main">
                            <th> اسم الفرع </th>
                            <th> مدين </th>
                            <th> دائن </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="bodyTableSales text-center">
                        <?php if(isset($invoice)): ?>
                            <tr class="text-center">
                                <td><?php echo e($invoice->branch_name); ?></td>
                                <td> <?php echo e($invoice->debtor); ?> </td>
                                <td><?php echo e($invoice->creditor); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('opening_balance_accounts.edit', $invoice->id)); ?>"
                                        class="btn btn-primary btn-sm " data-toggle="tooltip" title="edit"
                                        data-placement="bottom"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        <?php endif; ?>
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/OpeneningBalanceAccounts/index.blade.php ENDPATH**/ ?>