<?php $__env->startSection('main-content'); ?>
    <style>
        .chosen-single {
            height: 37px !important;
        }

    </style>
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
            <form method="post" dir="rtl" id="updaingForm" action="<?php echo e(route('items.update', $item->id)); ?>"
                autocomplete="off">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="list[]" id="hidenUpdated">
                <?php echo method_field('PATCH'); ?>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الاسم بالعربي</label>
                            <input type="text" name="namear" value="<?php echo e($item->namear); ?>" class="form-control">
                            <?php $__errorArgs = ['namear'];
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
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الاسم بالانجليزي</label>
                            <input type="text" name="nameen" value="<?php echo e($item->nameen); ?>" class="form-control">
                            <?php $__errorArgs = ['nameen'];
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
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">نوع التكويد</label>
                            <select name="coding_type" class="form-control">
                                <option value=<?php echo e(null); ?>> --- </option>
                                <option value="EGS" <?php echo e($item->coding_type == 'EGS' ? 'selected' : ''); ?>> EGS </option>
                                <option value="ES1" <?php echo e($item->coding_type == 'ES1' ? 'selected' : ''); ?>> ES1 </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label"> CODE </label>
                            <input type="text" name="code" value="<?php echo e($item->code); ?>" class="form-control">
                            <?php $__errorArgs = ['code'];
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

                    <div class="col-12 col-md-6">
                        <?php
                        $groupsList = explode(',', $item->group);
                        ?>
                        <label class="col-form-label">المجموعة</label>
                        <select name="group" class="form-control chosen-select">
                            <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(in_array($element->id, $groupsList)): ?>
                                    <option value=<?php echo e($element->id); ?> selected> <?php echo e($element->namear); ?> </option>
                                <?php else: ?>
                                    <option value=<?php echo e($element->id); ?>> <?php echo e($element->namear); ?> </option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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


                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">نوع الصنف</label>
                            <select name="item_type" class="form-control chosen-select">
                                <option value="0" <?php echo e($item->item_type == '0' ? 'selected' : ''); ?>> --- </option>
                                <option value="1" <?php echo e($item->item_type == '1' ? 'selected' : ''); ?>> مخزنى </option>
                                <option value="2" <?php echo e($item->item_type == '2' ? 'selected' : ''); ?>> تصنيع </option>
                                <option value="3" <?php echo e($item->item_type == '3' ? 'selected' : ''); ?>> خدمه </option>
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

                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">قياس الكمية</label>
                            <input type="text" name="quantityM" disabled value="<?php echo e($item->quantityM); ?>"
                                class="form-control">
                            <?php $__errorArgs = ['quantityM'];
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


                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">نسبة الضريبة</label>
                            <input type="number" name="taxRate" value="<?php echo e($item->taxRate); ?>" class="form-control">
                            <?php $__errorArgs = ['taxRate'];
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

                    <div class="col-12 col-md-6">

                        <div class="form-group text-right">
                            <label class="col-form-label">نسبة الضريبة</label>
                            <input type="number" name="taxRate" value="<?php echo e($item->taxRate); ?>" class="form-control">
                            <?php $__errorArgs = ['taxRate'];
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
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">بيان</label>
                            <textarea name="description" class="form-control"> <?php echo e($item->description); ?> </textarea>
                            <?php $__errorArgs = ['description'];
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
                    <div class="col-12 col-md-6 text-right">

                        <div class="form-check form-check-inline text-right align-self-center">
                            <input class="form-check-input" type="checkbox"
                                <?php echo e($item->priceWithTax == 1 ? 'checked' : ''); ?> name="priceWithTax" id="priceWithTax"
                                value="1">
                            <label class="form-check-label mr-2" for="priceWithTax"> السعر شامل الضريبة</label>
                        </div>
                    </div>

                </div>




                <hr>

                <table class="table text-center" dir="rtl">
                    <thead>
                        <tr>
                            <th scope="col"> الوحدات </th>
                            <th scope="col"> التعبئة </th>
                            <th scope="col"> باركود </th>
                            <th scope="col"> السعر </th>
                            <th scope="col"> مقدار الخصم </th>
                            <th scope="col"> نسبة الخصم </th>
                            <th scope="col"> السعر بعد الخصم </th>
                            <th scope="col">
                                <button type="button" class="btn btn-primary btn-first-add" onclick="addItemUnit(1)"> +
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody id=bodyUnitsEdit>
                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($listItem->itemId == $item->id): ?>
                                <tr class="rowUpdate-<?php echo e($listItem->id); ?>">
                                    <th>
                                        <select name="listUpdate[<?php echo e($listItem->id); ?>][unit]" id="select-unit-item-0"
                                            class="form-control">
                                            <option value="null"> --- </option>
                                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value=<?php echo e($unit->id); ?>

                                                    <?php echo e($listItem->unitId == $unit->id ? 'selected' : ''); ?>>
                                                    <?php echo e($unit->namear); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </th>
                                    <input type="hidden" name="listUpdate[<?php echo e($listItem->id); ?>][id]"
                                        value="<?php echo e($listItem->id); ?>">
                                    <td>
                                        <input type="number" name="listUpdate[<?php echo e($listItem->id); ?>][packing]"
                                            value="<?php echo e($listItem->packing); ?>" class="form-control packing-Edit-0">
                                    </td>
                                    <td>
                                        <input type="text" name="listUpdate[<?php echo e($listItem->id); ?>][barcode]"
                                            value="<?php echo e($listItem->barcode); ?>" class="form-control barcode-Edit-0">
                                    </td>
                                    <td>
                                        <input type="text" name="listUpdate[<?php echo e($listItem->id); ?>][price1]"
                                            value="<?php echo e($listItem->price1); ?>" class="form-control barcode-Edit-0">
                                    </td>
                                    

                                    <td>
                                        <input type="number" disabled class="form-control discountAmount-Edit-0">
                                    </td>
                                    <td>
                                        <input type="number" name="listUpdate[<?php echo e($listItem->id); ?>][discountPercentage]"
                                            value="<?php echo e($listItem->discountPercentage); ?>"
                                            class="form-control discountPercentage-Edit-0">
                                    </td>
                                    <td>
                                        <input type="number" name="listUpdate[<?php echo e($listItem->id); ?>][priceAfterDiscount]"
                                            value="<?php echo e($listItem->priceAfterDiscount); ?>"
                                            class="form-control priceAfterDiscount-Edit-0">
                                    </td>
                                    <td class="d-flex">
                                        <button type="button" disabled class="btn btn-danger"
                                            onclick="DeleteRow(<?php echo e($listItem->id); ?>)"> x </button>
                                    </td>


                                    <div class="modal fade" id="modalPrice-<?php echo e($listItem->id); ?>" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"> اسعار الصنف </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 1</label>
                                                        <input type="number"
                                                            name="listUpdate[<?php echo e($listItem->id); ?>][price1]" min="0"
                                                            step="0.1" value="<?php echo e($listItem->price1); ?>"
                                                            class="form-control price1-0">
                                                        <?php $__errorArgs = ['price1'];
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
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 2</label>
                                                        <input type="number"
                                                            name="listUpdate[<?php echo e($listItem->id); ?>][price2]" min="0"
                                                            step="0.1" value="<?php echo e($listItem->price2); ?>"
                                                            class="form-control price2-0">
                                                        <?php $__errorArgs = ['price2'];
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
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 3</label>
                                                        <input type="number"
                                                            name="listUpdate[<?php echo e($listItem->id); ?>][price3]" min="0"
                                                            step="0.1" value="<?php echo e($listItem->price3); ?>"
                                                            class="form-control price3-0">
                                                        <?php $__errorArgs = ['price3'];
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
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 4</label>
                                                        <input type="number"
                                                            name="listUpdate[<?php echo e($listItem->id); ?>][price4]" min="0"
                                                            step="0.1" value="<?php echo e($listItem->price4); ?>"
                                                            class="form-control price4-0">
                                                        <?php $__errorArgs = ['price4'];
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
                                                    <div class="form-group text-right">
                                                        <label class="col-form-label"> السعر 5</label>
                                                        <input type="number"
                                                            name="listUpdate[<?php echo e($listItem->id); ?>][price5]" min="0"
                                                            step="0.1" value="<?php echo e($listItem->price5); ?>"
                                                            class="form-control price5-0">
                                                        <?php $__errorArgs = ['price5'];
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
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="form-group mb-3 text-right">
                    <button class="btn btn-success px-4" type="button" onclick="clickFun(event)"> Update </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        body {
            color: #555
        }

    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });

        let listUnits = [];


        let num = 1;


        function clickFun(event) {
            event.preventDefault();
            $('form#updaingForm').submit();
        }

        function addItemUnit(idx) {
            console.log(idx);
            let unit = $(`#select-unit-item-${idx}`).val();
            let packing = $(`.packing-${idx}`).val();
            let barcode = $(`.barcode-${idx}`).val();
            let price1 = $(`.price1-${idx}`).val();
            let price2 = $(`.price2-${idx}`).val();
            let price3 = $(`.price3-${idx}`).val();
            let price4 = $(`.price4-${idx}`).val();
            let price5 = $(`.price5-${idx}`).val();
            let discountAmount = $(`.discountAmount-${idx}`).val();
            let discountPercentage = $(`.discountPercentage-${idx}`).val();
            let priceAfterDiscount = $(`.priceAfterDiscount-${idx}`).val();
            let obj = {
                unit,
                packing,
                barcode,
                price1,
                price2,
                price3,
                price4,
                price5,
                discountAmount,
                discountPercentage,
                priceAfterDiscount
            };

            listUnits.push(obj);
            $('#hidenUpdated').val(JSON.stringify(listUnits))
            num += 1;



            let modalHtml = `
                    <div class="modal fade" id="modalPrice${num}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" > اسعار الصنف</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 1</label>
                                        <input type="number" name="price1" min="0" step="0.1" class="form-control price1-${num}">
                                    </div>
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 2</label>
                                        <input type="number" name="price2" min="0" step="0.1" class="form-control price2-${num}">
                                    </div>
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 3</label>
                                        <input type="number" name="price3" min="0" step="0.1" class="form-control price3-${num}">
                                    </div>
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 4</label>
                                        <input type="number" name="price4" min="0" step="0.1" class="form-control price4-${num}">
                                    </div>
                                    <div class="form-group text-right">
                                        <label class="col-form-label"> السعر 5</label>
                                        <input type="number" name="price5" min="0" step="0.1" class="form-control price5-${num}">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                `
            $('#bodyUnitsEdit').append(modalHtml);

            let row = `
                <tr  id="row${num}">
                    <th>
                        <select name="unit" id="select-unit-item-${num}" class="form-control">
                            <option value="null"> --- </option>
                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value=<?php echo e($unit->id); ?>> <?php echo e($unit->namear); ?> </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </th>
                    <td>
                        <input type="number" name="packing" class="form-control packing-${num}">
                    </td>
                    <td>
                        <input type="text" name="barcode" class="form-control barcode-${num}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-price-${num}" data-toggle="modal" data-target="#modalPrice${num}"> السعر </button>
                    </td>
                    <td>
                        <input type="number" disabled name="discountAmount" class="form-control discountAmount-${num}">
                    </td>
                    <td>
                        <input type="number" name="discountPercentage" class="form-control discountPercentage-${num}">
                    </td>
                    <td>
                        <input type="number" name="priceAfterDiscount" class="form-control priceAfterDiscount-${num}">
                    </td>
                    <td class="d-flex">
                        <button type="button" class="btn btn-primary" onclick="addItemUnit(${num})" > + </button>
                        <button type="button" class="btn btn-danger" onclick="DeleteRow(${num})"> x </button>
                    </td>
                </tr>
                `
            $('#bodyUnitsEdit').append(row);
        }


        function submitList(event) {
            event.preventDefault();
            let namear = $('[name=namear]').val();
            let nameen = $('[name=nameen]').val();
            let group = $('[name=group]').val();
            let quantityM = $('[name=quantityM]').val();
            let taxRate = $('[name=taxRate]').val();
            let priceWithTax = $('[name=priceWithTax]').val();
            let description = $('[name=description]').val();
            let img = $('[name=img]');

            $.ajax({
                method: 'post',
                url: "items/store",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    id: 123
                },
                success: function(data) {
                    console.log(data);
                }
            });
        }



        // done version
        function DeleteRow(id) {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: 'post',
                            url: "/itemlist/delete",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
                                id: id
                            },
                            success: function(data) {
                                if (data.status == 200) {
                                    swal("Removed Done!");
                                    window.location.reload();
                                    $(`.rowUpdate-${id}`).remove();
                                }

                            }
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });
            // $(`#row${id}`).remove();

        }

        function DeleteRowAdded(id) {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $(`#row${id}`).remove()
                    } else {
                        swal("Your data is safe!");
                    }
                });
            // $(`#row${id}`).remove();

        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\erp\resources\views/items/edit.blade.php ENDPATH**/ ?>