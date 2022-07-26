<div class="printerCalc col-12 col-md-3 mx-auto d-none d-md-block text-center col-products">


    <?php if($shiftOpening->opening == 1): ?>
        <div class="d-flex justify-content-between pt-2">
            <button class="btn btn-warning font-weight-boldbtn-sm font-main" onclick="sendAlertClose()">
                <?php echo e(__('pos.reportdaily')); ?> </button>

            <button class="btn btn-secondary font-weight-bold btn-sm font-main ReturnedTrue" onclick="Returned()"> الطلبات المعلقة </button>
            <button class="btn btn-secondary font-weight-bold btn-sm font-main ReturnedFalse d-none" onclick="ReturnedFalse()"> الكاشير </button>

            <button class="btn btn-warning font-weight-bold btn-sm font-main"
                onclick="closeShify('<?php echo e(csrf_token()); ?>')">
                <?php echo e(__('pos.closeShift')); ?> </button>
        </div>
    <?php else: ?>
        <script>
            window.location.replace(window.location.origin);
        </script>
    <?php endif; ?>

    <div class="notHold p-0 ">
        <div class="my-3">
            <select class="form-control chosen" name="store" dir="rtl" id="storeId">
                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($store->id); ?>"> <?php echo e($store->namear); ?> </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>


            <?php if($company->tax_source != 0): ?>
                <div class="my-3">
                    <div class=" d-flex justify-content-between flex-row-reverse align-items-center">
                        <h6 class="font-main">
                            ضريبة خصم المنبع %
                        </h6>
                        <div class="d-flex">
                            <input type="number" name="taxSource" onkeyup="handelTax(event)"
                                class="form-control text-center d-inline-block" step="0.1" id="taxSourceRate">
                            <input type="hidden" name="taxSourceValue" class="form-control text-center d-inline-block "
                                id="taxSourceValue" step="0.1">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between flex-row-reverse align-items-center">
                    <h6 style="font-size: 15px" class="font-main"> قيمة ضريبة المنبع </h6>
                    <h6 style="font-size: 15px" class="px-3 text-center tax_value font-main">00</h6>
                </div>
            <?php endif; ?>
        </div>


        <form dir="rtl">
            <div class="form-group d-flex justify-content-between align-items-center my-4">
                <label class="font-main text-right" style="font-size: 14px" style="width: 30%"> تحديد نسبة الخصم
                </label>
                <input type="text" class="form-control text-center" style="width: 70%">
            </div>

            <hr style="background: #fff">

            <div class="form-group d-flex justify-content-between align-items-center my-2">
                <label class="font-main" style="font-size: 14px" style="width: 30%"> الخصم </label>
                <input type="text" class="form-control text-center" style="width: 70%">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center my-2">
                <label class="font-main" style="font-size: 14px" style="width: 30%"> الاجمالي </label>
                <input type="text" class="form-control text-center" style="width: 70%">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center my-2">
                <label class="font-main" style="font-size: 14px" style="width: 30%"> قيمة مضافة </label>
                <input type="text" class="form-control text-center" style="width: 70%">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center my-2">
                <label class="font-main" style="font-size: 14px" style="width: 30%"> خدمة توصيل </label>
                <input type="text" class="form-control text-center" style="width: 70%">
            </div>
            <div class="form-group d-flex justify-content-between align-items-center my-2">
                <label class="font-main" style="font-size: 14px" style="width: 30%"> الصافي </label>
                <input type="text" class="form-control text-center" style="width: 70%">
            </div>
        </form>

        <div class="printerCalc-items mx-auto px-0 calculation-print d-none d-md-block">
            <div class="row">
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(1)"> 1</button>
                </div>
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(2)"> 2</button>
                </div>
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(3)"> 3</button>
                </div>
            </div>
            <div class="row">
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(4)"> 4</button>
                </div>
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(5)"> 5</button>
                </div>
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(6)"> 6</button>
                </div>
            </div>
            <div class="row">
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(7)"> 7</button>
                </div>
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(8)"> 8</button>
                </div>
                <div class="col-4 px-1 my-1">
                    <button class="btn btn-print w-100 py-2" onclick="changePrinter(9)"> 9</button>
                </div>
            </div>
            <div class="row">
                <div class="col-8 px-1 my-1">
                    <button class="btn w-100 btn-print py-2" onclick="changePrinter(0)"> 0</button>
                </div>
                <div class="col-4 px-1 my-1">
                    <button class="btn w-100 btn-clear py-2" onclick="changePrinter(10)"> C</button>
                </div>
            </div>
        </div>
    </div>



    <div class="table-holds my-3 d-none">
        <table class="table table-striped font-main" dir="rtl">
            <thead>
                <tr>
                    <th>كود</th>
                    <th style="width: 170px">تاريخ</th>
                    <th>اجمالي</th>
                    <th>
                        <button class="btn btn-small btn-success"> <i class="fa fa-mouse"></i> </button>
                    </th>
                </tr>
            </thead>
            <tbody class="bodyHolds">

            </tbody>
        </table>
    </div>

</div>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/Casher/printer.blade.php ENDPATH**/ ?>