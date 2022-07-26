<?php $__env->startSection('main-content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> اضافة عميل </li>
                        <li class="breadcrumb-item"><a href="/erp/public/customers"> العملاء </a></li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 px-5">
                <div class="company text-right font-ar">
                    <div class="col-12 mx-auto px-0  font-main">
                        <form dir="rtl" method="POST" action="<?php echo e(route('customers.store')); ?>">
                            <?php echo e(csrf_field()); ?>


                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الكود</label>
                                    <input type="number" disabled class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <div class="form-group">
                                        <label for="group" class="col-form-label">المجموعة</label>
                                        <select name="group" class="form-control">
                                            <option value="0">---</option>
                                            <option value="1"> المجموعة الرئيسية </option>
                                        </select>
                                        <?php $__errorArgs = ['group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الاسم بالعربي</label>
                                    <input type="text" name="namecustomerar" class="form-control" />
                                    <?php $__errorArgs = ['namecustomerar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الاسم بالانجليزي</label>
                                    <input type="text" name="namecustomeren" class="form-control" />
                                    <?php $__errorArgs = ['namecustomeren'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>


                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <div class="form-group">
                                        <label class="col-form-label">نوع الفاتورة الالكترونية</label>
                                        <select name="type_invoice_electronice" class="form-control">
                                            <option value=<?php echo e(null); ?>>---</option>
                                            <option value="B  للاعمال التجارية فى مصر">B للاعمال التجارية فى مصر</option>
                                            <option value="F  للاجنبى">F للاجنبى</option>
                                            <option value="P  للشخص الطبيعى">P للشخص الطبيعى</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> رقم التسجيل بضريبة القيمة المضافة </label>
                                    <input type="number" name="numRegister" class="form-control" />
                                </div>
                            </div>


                            <div class="row py-2 font-main">

                                <div class="col-12 col-md-6 mx-auto">
                                    <label>تلفون</label>
                                    <input type="number" name="phone" class="form-control" />
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>رقم الهوية</label>
                                    <input type="number" name="IdentificationNumber" class="form-control" />
                                </div>
                            </div>
                            <div class="row py-2 font-main">
                                <div class="col-12 col-md-6">
                                    <label> العنوان </label>
                                    <input autocomplete="off" type="text" value="<?php echo e(old('address')); ?>" name="address"
                                        class="form-control" />
                                    <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>


                            <div class="submiting d-flex mt-4">
                                <button type="submit" class="btn btn-primary mx-2 px-4"> حفظ </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('boot5/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('boot5/bootstrap.bundle.js')); ?>"></script>
    <!-- Page level plugins -->
    <script src="<?php echo e(asset('backend/vendor/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo e(asset('backend/js/demo/datatables-demo.js')); ?>"></script>
    <script>
        $('#user-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [6, 7]
            }]
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

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/customers/create.blade.php ENDPATH**/ ?>