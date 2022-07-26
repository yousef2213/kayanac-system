<?php $__env->startSection('main-content'); ?>
    <style>
        .chosen-container {
            height: 37px !important;
            width: 100% !important;
        }

    </style>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
                <li class="breadcrumb-item active" aria-current="page"> تعديل صنف </li>
                <li class="breadcrumb-item"><a href="/erp/public/items"> الاصناف </a></li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>



        <div class="card">
            <h5 class="card-header">Update Item</h5>
            <div class="card-body font-main">
                <form method="post" dir="rtl" id="updaingForm" action="<?php echo e(route('items-collection.update', $item->id)); ?>"
                    autocomplete="off">
                    <?php echo e(csrf_field()); ?>

                    <?php echo method_field('PATCH'); ?>

                    <input type="hidden" name="list[]" id="hidenValue">

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">الاصناف </label>
                                <select name="itemId" class="form-control chosen-select" onchange="handelItemBasic(event)">
                                    <option value=<?php echo e(null); ?>> --- </option>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=<?php echo e($product->id); ?>

                                            <?php echo e($item->itemId == $product->id ? 'selected' : ''); ?>>
                                            <?php echo e($product->namear); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">الوحدات </label>
                                <select name="unitId" class="form-control" id="units">
                                    <option value=<?php echo e(null); ?>> --- </option>
                                    <?php $__currentLoopData = $itemsList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itemsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=<?php echo e($itemsItem->unitId); ?>

                                            <?php echo e($item->unitId == $itemsItem->unitId ? 'selected' : ''); ?>>
                                            <?php echo e($itemsItem->unit_name); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group text-right">
                                <label class="col-form-label">مكونات الاصناف </label>
                                <select class="form-control chosen-select" onchange="handelItem(event)">
                                    <option value=<?php echo e(null); ?>> --- </option>
                                    <?php $__currentLoopData = $itemsCreate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value=<?php echo e($item->id); ?>> <?php echo e($item->namear); ?> </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                    </div>



                    <hr>

                    <table class="table text-center" dir="rtl">
                        <thead class="btn-primary">
                            <tr>
                                <th scope="col" class="py-1"> الصنف </th>
                                <th scope="col" class="py-1"> الوحدة </th>
                                <th scope="col" class="py-1"> الكمية </th>
                                <th class="td-style py-1">
                                    <button class="btn btn-success" type="button"> ... </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody id=bodysItemsCollection>
                            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="Item-<?php echo e($item->id); ?>">
                                    <td class="px-0">
                                        <input type="text" disabled value="<?php echo e($item->item_name); ?>"
                                            class="form-control packing-Edit-0">
                                    </td>
                                    <td class="px-0">
                                        <select name="unit_id" onchange="handelUnit(event,'<?php echo e($item->id); ?>')"
                                            class="form-control chosen-select w-100">
                                            <option value="null"> --- </option>
                                            <?php $__currentLoopData = $item->units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value='<?php echo e($unit->unitId); ?>'
                                                    <?php echo e($item->unitId == $unit->unitId ? 'selected' : ''); ?>>
                                                    <?php echo e($unit->unit_name); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td class="px-0">
                                        <input type="text" onkeyup="handelQtn(event,'<?php echo e($item->id); ?>')"
                                            value="<?php echo e($item->qtn); ?>" class="form-control barcode-Edit-0">
                                    </td>

                                    <td class="px-0">
                                        <button type="button" class="btn btn-danger"
                                            onclick="DeleteRowDB(<?php echo e($item->id); ?>)"> x </button>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="form-group mb-3 text-right">
                        <button class="btn btn-success px-4" type="button" onclick="onSubmit(event)"> Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('boot5/bootstrap.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        let Rows = <?php echo json_encode($list->toArray()); ?>;
        const addRow = (res) => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let row = Rows.find(el => el.id == id);
            row.itemId = res.item.id;
            let item = `
                <tr class="Item-${id}">

                    <td class="px-0">
                        <input type="text" name="item" disabled class="form-control item-${id}" value="${res.item.namear}" />
                    </td>

                    <td class="px-0">
                        <select name="unit_id" onchange="handelUnit(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            ${res.list.map(row => ` <option value='${row.unitId}'> ${row.unit_name} </option> ` )}
                    </select>

                    </td>

                    <td class="px-0">
                        <input type="number" name="qtn" onkeyup="handelQtn(event,'${id}')" class="form-control qtn-${id}" />
                    </td>


                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodysItemsCollection').append(item);
        }

        const handelItem = async (event) => {
            const req = await fetch("/erp/public/get-item-collection/" + event.target.value);
            const res = await req.json();
            addRow(res)
        }


        const handelItemBasic = async (event) => {
            $.ajax({
                type: 'GET',
                url: "/erp/public/getUnits/" + event.target.value,
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                },
                success: function(data = []) {
                    $(`#units`).html('');
                    let obj = {
                        id: null,
                        namear: '---'
                    };
                    data = [obj, ...data];
                    let units = data.map(unit =>
                    `<option value="${unit.id}"> ${unit.namear} </option>`);
                    $(`#units`).html(units);
                }
            });

        }

        const handelUnit = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.unitId = event.target.value;
        }
        const handelQtn = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.qtn = event.target.value;
        }

        const onSubmit = (event) => {
            event.preventDefault();
            Rows.forEach(item => {
                item.isNew = !Number.isInteger(item.id);
            });
            $('#hidenValue').val(JSON.stringify(Rows))
            $('form').submit()
        }
        let IDGenertaor = function() {
            return '_' + Math.random().toString(36).substr(2, 10);
        };

        let DeleteRow = id => {
            Rows = Rows.filter(el => el.id !== id);
            $(`.Item-${id}`).remove();
        }
    </script>
    <script>
        let DeleteRowDB = async (id) => {
            swal("هل انت متاكد من حذف هذا السطر").then(res => {
                if (res) {
                    fetch('/erp/public/collection/deleteRow/' + id).then(response => response.json())
                        .then(data => {
                            if (data.status == 200) {
                                Rows = Rows.filter(el => el.id != id);
                                $(`.Item-${data.id}`).remove();
                            }
                        });
                }
            })
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/ItemsCollection/edit.blade.php ENDPATH**/ ?>