<?php $__env->startSection('main-content'); ?>
    <div class="px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> تعديل امر شراء </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>



        <div class="card">
            <h5 class="card-header">Add Invoice</h5>
            <div class="card-body font-main">

                <form dir="rtl" method="post" action="<?php echo e(route('purchase-order.update', $purchase->id)); ?>"
                    autocomplete="off" enctype="multipart/form-data">

                    <input type="hidden" name="list[]" id="hidenValue">

                    <?php echo e(csrf_field()); ?>

                    <?php echo method_field('PATCH'); ?>


                    <div class="row py-2 text-right">
                        <div class="col-12 col-md-6 mx-auto">
                            <label> رقم الفاتورة </label>
                            <input type="text" autocomplete="off" disabled value="<?php echo e($purchase->id); ?>" name="id"
                                class="form-control" />
                        </div>
                        <div class="col-12 col-md-6 mx-auto">
                            <label> تاريخ الفاتورة </label>
                            <input type="datetime-local" autocomplete="off" value="<?php echo e($purchase->dateInvoice); ?>"
                                name="dateInvoice" class="form-control" />
                        </div>
                    </div>

                    <div class="row py-2 text-right">
                        <div class="col-12 col-md-6 mx-auto">
                            <label> المورد </label>
                            <select name="supplier" class="form-control chosen-select" tabindex="4" dir="rtl">
                                <?php $__currentLoopData = $suppliers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value=<?php echo e($supplier->id); ?>

                                        <?php echo e($purchase->supplier == $supplier->id ? 'selected' : ''); ?>>
                                        <?php echo e($supplier->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mx-auto">
                            <label> رقم فاتورة المورد </label>
                            <input type="text" autocomplete="off" value="<?php echo e($purchase->supplier_invoice); ?>"
                                name="supplier_invoice" class="form-control" />
                        </div>
                    </div>

                    <div class="row py-2 text-right">
                        <div class="col-12 col-md-6 mx-auto">
                            <label> نوع الدفع </label>
                            <select name="payment" class="form-control" tabindex="4" dir="rtl">
                                <option value="1" <?php echo e($purchase->payment == '1' ? 'selected' : ''); ?>> كاش </option>
                                <option value="2" <?php echo e($purchase->payment == '2' ? 'selected' : ''); ?>> اجل </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 mx-auto">
                            <label class="col-form-label">الفرع</label>
                            <select name="branchId" class="form-control chosen-select" tabindex="4" dir="rtl">
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branche): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value=<?php echo e($branche->id); ?>

                                        <?php echo e($purchase->branchId == $branche->id ? 'selected' : ''); ?>>
                                        <?php echo e($branche->namear); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>


                    <div class="col-12 px-0">



                        <table class="table table-striped table-bordered mt-5">
                            <thead class="btn-primary">
                                <tr>
                                    <th> المخزن </th>
                                    <th> الصنف </th>
                                    <th> الوحدة </th>
                                    <th class="td-style"> الكمية </th>
                                    <th class="td-style"> السعر </th>
                                    <th class="td-style"> الخصم % </th>
                                    <th class="td-style"> الاجمالي بعد الخصم </th>
                                    <th class="td-style"> قيمة مضافة % </th>
                                    <th class="td-style"> قيمة ضريبة </th>
                                    <th class="td-style"> الاجمالي </th>
                                    <th class="td-style">
                                        <button class="btn btn-success" type="button" onclick="addRow()"> + </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="bodys">
                                <?php $__currentLoopData = $purchaseList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchaseitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="Item-<?php echo e($purchaseitem->id); ?>">
                                        <input type="hidden" name="listUpdate[<?php echo e($purchaseitem->id); ?>][id]"
                                            value="<?php echo e($purchaseitem->id); ?>">

                                        <td class="px-0">
                                            <select name="listUpdate[<?php echo e($purchaseitem->id); ?>][storeId]"
                                                onchange="handelStore(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control chosen-select">
                                                <option value="null"> --- </option>
                                                <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value=<?php echo e($store->id); ?>

                                                        <?php echo e($purchaseitem->storeId == $store->id ? 'selected' : ''); ?>>
                                                        <?php echo e($store->namear); ?> </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td class="px-0">
                                            <select name="listUpdate[<?php echo e($purchaseitem->id); ?>][itemId]"
                                                onchange="handelItem(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control chosen-select">
                                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value=<?php echo e($item->id); ?>

                                                        <?php echo e($purchaseitem->itemId == $item->id ? 'selected' : ''); ?>>
                                                        <?php echo e($item->namear); ?> </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td class="px-0">
                                            <select name="listUpdate[<?php echo e($purchaseitem->id); ?>][unitId]"
                                                onchange="handelUnit(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control chosen-select">
                                                <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value=<?php echo e($unit->id); ?>

                                                        <?php echo e($purchaseitem->unitId == $unit->id ? 'selected' : ''); ?>>
                                                        <?php echo e($unit->namear); ?> </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </td>
                                        <td class="px-0">
                                            <input type="number" name="listUpdate[<?php echo e($purchaseitem->id); ?>][qtn]"
                                                onkeyup="handelQtn(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control qtn-<?php echo e($purchaseitem->id); ?>"
                                                value="<?php echo e($purchaseitem->qtn); ?>" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" name="listUpdate[<?php echo e($purchaseitem->id); ?>][price]"
                                                onkeyup="handelPrice(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control price-<?php echo e($purchaseitem->id); ?>"
                                                value="<?php echo e($purchaseitem->price); ?>" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" name="listUpdate[<?php echo e($purchaseitem->id); ?>][discount]"
                                                onkeyup="handelDiscount(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control dis-<?php echo e($purchaseitem->id); ?>"
                                                value="<?php echo e($purchaseitem->discountRate); ?>" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" disabled
                                                name="listUpdate[<?php echo e($purchaseitem->id); ?>][total]"
                                                onchange="handelTotal(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control total-<?php echo e($purchaseitem->id); ?>"
                                                value="<?php echo e($purchaseitem->total - $purchaseitem->discountValue); ?>" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" name="listUpdate[<?php echo e($purchaseitem->id); ?>][added]"
                                                onkeyup="handelAdded(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control added-<?php echo e($purchaseitem->id); ?>"
                                                value="<?php echo e($purchaseitem->rate); ?>" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" disabled
                                                name="listUpdate[<?php echo e($purchaseitem->id); ?>][value]"
                                                onkeyup="handeltaxRate(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control rate-<?php echo e($purchaseitem->id); ?>"
                                                value="<?php echo e($purchaseitem->value); ?>" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" disabled
                                                name="listUpdate[<?php echo e($purchaseitem->id); ?>][nettotal]"
                                                onkeyup="handelNetTotal(event,'<?php echo e($purchaseitem->id); ?>')"
                                                class="form-control nettotal-<?php echo e($purchaseitem->id); ?>"
                                                value="<?php echo e($purchaseitem->nettotal); ?>" />
                                        </td>

                                        <td>
                                            <button class="btn btn-danger"
                                                onclick="DeleteRowDB('<?php echo e($purchaseitem->id); ?>')" type="button"> -
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12 col-md-4 my-4">
                        <table class="table table-border">
                            <thead class="text-center">
                                <tr>
                                    <th colspan="2" style="font-size: 15px">اجماليات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td colspan="1" style="font-size: 15px"> اجمالي الفاتورة </td>
                                    <td colspan="1" style="font-size: 15px" class="safe"><?php echo e($nettotal); ?></td>
                                </tr>
                                <?php if($company->tax_source != 0): ?>
                                    <tr>
                                        <td style="font-size: 15px"> ضريبة خصم المنبع % </td>
                                        <td style="font-size: 15px" class="text-center" class="da">
                                            <input type="number" name="taxSource" value="<?php echo e($purchase->taxSource); ?>"
                                                onkeyup="handelTax(event)" class="form-control text-center d-inline-block"
                                                style="width: 100px" step="0.1">
                                            <input type="hidden" name="taxSourceValue"
                                                class="form-control text-center d-inline-block" id="taxSourceValue"
                                                style="width: 100px" step="0.1">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 15px"> قيمة ضريبة المنبع </td>
                                        <td style="font-size: 15px" class="tax_value">
                                            <?php echo e(($nettotal * $purchase->taxSource) / 100); ?></td>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <td style="font-size: 15px"> قيمة ضريبة المضافة </td>
                                    <td style="font-size: 15px" class="tax_value_plus"><?php echo e($taxValue); ?></td>
                                </tr>

                                <tr>
                                    <td style="font-size: 15px"> صافي الفاتورة </td>
                                    <td style="font-size: 15px" class="nettotal_inovice"> <?php echo e($purchase->netTotal); ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="form-group mb-3 text-right">
                        <button type="reset" class="btn btn-warning"> Reset </button>
                        <button class="btn btn-success" type="submit" onclick="onSubmit(event)"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>">
    <style>
        .chosen-single {
            height: 35px !important;
        }

        th {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        th,
        tr,
        td {
            text-align: center !important;
            font-size: 10px;
            vertical-align: middle !important
        }

        input[type=number]::-webkit-inner-spin-button {
            display: none;
        }

        .td-style {
            width: 90px
        }

    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('boot5/bootstrap.min.js')); ?>"></script>

    <script>
        let Rows = <?php echo json_encode($purchaseList->toArray()); ?>;
        let itemList = <?php echo json_encode($itemsList->toArray()); ?>;

        const addRow = () => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let item = `
                <tr class="Item-${id}">
                    <td class="px-0">
                        <select name="storeId" onchange="handelStore(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($store->id); ?>> <?php echo e($store->namear); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td class="px-0">
                        <select name="itemId" onchange="handelItem(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($item->id); ?>> <?php echo e($item->namear); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td class="px-0">
                        <select name="unitId" onchange="handelUnit(event,'${id}')" class="form-control chosen-select" id="units-${id}">
                            <option value="null"> --- </option>

                        </select>
                    </td>
                    <td class="px-0">
                        <input type="number" name="qtn" onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="price" onkeyup="handelPrice(event,'${id}')" class="form-control price-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="discount" onkeyup="handelDiscount(event,'${id}')" class="form-control dis-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled name="total" onchange="handelTotal(event,'${id}')" value="0" class="form-control total-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="added" onkeyup="handelAdded(event,'${id}')" value="0" class="form-control added-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled name="taxRate" onkeyup="handeltaxRate(event,'${id}')" value="0" class="form-control rate-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" disabled onkeyup="handelNetTotal(event,'${id}')" value="0" class="form-control nettotal-${id}" />
                    </td>

                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodys').append(item);
        }


        const handelStore = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.storeId = event.target.value;
        }
        const handelItem = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.itemId = event.target.value;
            $.ajax({
                type: 'GET',
                url: "/erp/public/getUnits/" + event.target.value,
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                },
                success: function(data = []) {
                    $(`#units-${id}`).html('');
                    let obj = {
                        id: null,
                        namear: '---'
                    };
                    data = [obj, ...data];
                    let units = data.map(unit => `<option value="${unit.id}"> ${unit.namear} </option>`);
                    $(`#units-${id}`).html(units);
                }
            });
        }
        const handelQtn = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.qtn = event.target.value;
            Calc(id, event.target.value);
        }
        const handelPrice = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.price = event.target.value;
            Calc(id, event.target.value);
        }
        const handelDiscount = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.discount = event.target.value;
            Calc(id, event.target.value);
            getTotal()
        }
        const handelTotal = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.total = event.target.value;
        }
        const handelAdded = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.added = event.target.value;
            CalcRate(id)
            getTotal()
            handelTax()
        }
        const handeltaxRate = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.taxRate = event.target.value;
        }
        const handelNetTotal = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.netTotal = event.target.value;
        }
        const handelUnit = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.unitId = event.target.value;
        }
        const onSubmit = (event) => {
            event.preventDefault();
            $taxV = $('.tax_value').html();
            $('#taxSourceValue').val(+$taxV);
            Rows.forEach(item => {
                if (!item.itemId) item.itemId = item.item_id;
                if (!item.item_id) item.item_id = item.itemId;

                if (!item.unitId) item.unitId = item.unit_id;
                if (!item.unit_id) item.unit_id = item.unitId;
                item.isNew = !Number.isInteger(item.id);
            });
            $('#hidenValue').val(JSON.stringify(Rows))
            $('form').submit()
        }
        let IDGenertaor = function() {
            return '_' + Math.random().toString(36).substr(2, 10);
        };

        let Calc = (id) => {
            let price = $(`.price-${id}`).val();
            let qtn = $(`.qtn-${id}`).val();
            let discount = $(`.dis-${id}`).val();
            let discountValue = (discount * (+qtn * +price)) / 100;
            let total = (+qtn * +price) - discountValue;
            total = +total.toFixed(2);

            $(`.total-${id}`).val(total);
            CalcRate(id)
            getTotal(id)

        }

        function getTotal() {
            let total = 0;
            let taxs = 0;
            Rows.forEach(item => {
                let discount = +item.discount || 0;
                let calc = +item.qtn * +item.price;
                let discountValue = (calc * discount) / 100 || 0;
                total += calc - discountValue;
                taxs += +item.value || 0
            });
            let taxSource = $('.tax_value').html();
            $('.safe').text(+total.toFixed(2));
            $('.tax_value_plus').html(+taxs.toFixed(2));
            let safeTotal = (+taxs + +total) - +taxSource;
            $('.nettotal_inovice').html(safeTotal);
        }

        function handelTax(event) {
            let val = event.target.value;
            let total = $('.safe').html();

            let tax = 0;
            if (+val != 0) {
                tax = (+total * +val) / 100;
                $('.tax_value').html(+tax);

            } else {
                $('.tax_value').html(0);
            }
            getTotal()
        }
        let CalcRate = (id) => {
            let added = $(`.added-${id}`).val();
            let total = $(`.total-${id}`).val();

            let value = (total * added) / 100;
            value = +value.toFixed(4);
            $(`.rate-${id}`).val(value);
            let item = Rows.find(el => el.id == id);
            item.value = value;

            let rateVal = $(`.rate-${id}`).val();

            let nettotal = +total + +rateVal;
            nettotal = +nettotal.toFixed(4);
            $(`.nettotal-${id}`).val(nettotal);
        }

        let DeleteRow = id => {
            Rows = Rows.filter(el => el.id !== id);
            $(`.Item-${id}`).remove();
            getTotal();
            handelTax()
        }
    </script>
    <script>
        let DeleteRowDB = async (id) => {
            swal("هل انت متاكد من حذف هذا السطر").then(res => {
                if (res) {
                    fetch('/erp/public/purchase-order/deleteRow/' + id).then(response => response.json())
                        .then(data => {
                            if (data.status == 200) {
                                Rows = Rows.filter(el => el.id != id);
                                $(`.Item-${data.id}`).remove();
                                getTotal()
                                handelTax()
                            }
                        });
                }
            })
        }
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/Purchases/PurchasesOrder/edit.blade.php ENDPATH**/ ?>