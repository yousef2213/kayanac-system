<?php $__env->startSection('main-content'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <div class="container-fluid px-5">
        <div class="row">
            <nav aria-label="breadcrumb" class="">
                <ol class="breadcrumb justify-content-end font-main p-2">
                    <li class="breadcrumb-item active" aria-current="page"> كارت صنف </li>
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
        </div>
    </div>

    <div class="container-fluid px-5">
        <div class="row font-main">
            <div class="col-12 mx-auto">
                <form action="" dir="rtl">
                    <div class="row text-right">
                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for=""> الاصناف </label>
                                <select name="items" class="form-control chosen-select" id="select-items">
                                    <option value="0" data-unit="0"> -- </option>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->id); ?>" data-unit="<?php echo e($item->unit_id); ?>">
                                            <?php echo e($item->namear); ?> </option>
                                        
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row text-right">
                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for="">من تاريخ</label>
                                <input type="datetime-local" class="form-control" name="from" id="date-from">
                            </div>
                        </div>
                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for="">الي تاريخ</label>
                                <input type="datetime-local" class="form-control" name="to" id="date-to">
                            </div>
                        </div>
                    </div>
                    <div class="text-right my-4">
                        <button class="btn btn-primary px-5" onclick="Show(event, '<?php echo e(csrf_token()); ?>')"> عرض </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-12">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="items_movement-dataTable" dir="rtl" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr class="text-center font-main">
                                    <th> التاريخ </th>
                                    <th> النوع </th>
                                    <th> المخزن </th>
                                    <th> الوحدة </th>
                                    <th> الكمية </th>
                                    <th> السعر </th>
                                    <th> الاجمالي </th>
                                    <th> الصافي </th>
                                </tr>
                            </thead>
                            <tbody class="items_movement"></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
    <style>
        .chosen-single {
            height: 35px !important;
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/item_mvment/index.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/ItemMovement/index.blade.php ENDPATH**/ ?>