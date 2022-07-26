<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/pos.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/bonds/print.css')); ?>">
    <title>Pdf Sales</title>
</head>

<body>

    <div class="container py-5">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-main text-right"><?php echo e($company->companyNameAr); ?></h6>
                            <h6 class="font-main text-right text-uppercase"><?php echo e($company->active); ?></h6>
                            <h6 class="font-main text-right text-uppercase"><?php echo e($company->taxNum); ?></h6>
                        </div>
                        <div>
                            <img src="<?php echo e(asset('comp/' . $company->logo)); ?>" class="rounded" width="100" alt="">
                        </div>
                        <div>
                            <h6 class="font-main text-left text-uppercase"><?php echo e($company->companyNameEn); ?></h6>
                            <h6 class="font-main text-left text-uppercase"><?php echo e($company->active); ?></h6>
                            <h6 class="font-main text-left text-uppercase"><?php echo e($company->taxNum); ?></h6>
                        </div>
                    </div>
                </div>
                <hr>


                <div class="pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-main text-right"><?php echo e($customer->name); ?></h6>
                            <h6 class="font-main text-right text-uppercase"><?php echo e($customer->customer); ?></h6>
                        </div>
                        <div>
                            <h6 class="font-main text-left text-uppercase"><?php echo e($invoice->created_at); ?></h6>
                            <h6 class="font-main text-left text-uppercase">
                                <?php if($invoice->status == 2): ?>
                                    اجل
                                <?php else: ?>
                                    كاش
                                <?php endif; ?>
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="text-center py-2">
                    <h5 class="font-main" style="text-decoration: underline">فاتورة مبيعات رقم -
                        <?php echo e($invoice->id); ?></h5>
                </div>





                
                <table class="table" dir="rtl">
                    <thead>
                        <tr class="text-center font-main">
                            <th scope="col">م</th>
                            <th scope="col"> الصنف - الوصف </th>
                            <th scope="col">العدد</th>
                            <th scope="col">السعر</th>
                            <th scope="col">الخصم</th>
                            <th scope="col">الاجمالي</th>
                            <th scope="col">الضريبة</th>
                            <th scope="col">الاجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total1 = 0;
                        $total2 = 0;
                        $discounts  = 0;
                        ?>
                        <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $total1 += $item->total;
                            $total2 += $item->value;
                            $discounts += $item->discountValue;
                            ?>
                            <tr class="text-center font-main">
                                <th scope="row"><?php echo e($key + 1); ?></th>
                                <td><?php echo e($item->item_name); ?> - <?php echo e($item->description); ?></td>
                                <td><?php echo e($item->qtn); ?></td>
                                <td><?php echo e($item->price); ?></td>
                                <td><?php echo e($item->discountValue); ?></td>
                                <td><?php echo e($item->total); ?></td>
                                <td><?php echo e($item->value); ?></td>
                                <td><?php echo e($item->nettotal); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="col-12 col-md-4 my-4">
                    <table class="table font-main table-border">
                        <thead class="text-center">
                            <tr>
                                <th colspan="2" style="font-size: 15px">اجماليات</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td colspan="1" style="font-size: 15px"> اجمالي الفاتورة </td>
                                <td colspan="1" style="font-size: 15px" class="safe"> <?php echo e($total1); ?>

                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 15px"> ضريبة القيمة المضافة </td>
                                <td style="font-size: 15px" class="tax_value_plus"> <?php echo e($total2); ?> </td>
                            </tr>

                            <tr>
                                <?php $taxSouceValue = ($total1 * $invoice->taxSource) / 100; ?>
                                <td colspan="1" style="font-size: 15px"> ضريبة خصم المنبع % </td>
                                <td colspan="1" style="font-size: 15px" class="safe">
                                    <?php echo e($taxSouceValue); ?></td>
                            </tr>


                            <tr>
                                <td style="font-size: 15px"> صافي الفاتورة </td>
                                <?php
                                    $nettotal = $total1 + ($total1 * $total2) / 100;
                                    $taxSource = ($total1 * $invoice->taxSource) / 100;
                                    $nettotal = $nettotal - $taxSource;
                                ?>
                                <td style="font-size: 15px" class="nettotal_inovice">
                                    <?php echo e(($total1 + $total2 - $taxSouceValue) - $discounts); ?> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h6 class="text-right font-main"> <?php echo Numbers::TafqeetMoney($nettotal, 'EGP'); ?> </h6>



                <div class="py-3">
                    <div class="d-flex justify-content-between align-items-center flex-row-reverse">
                        <div>
                            <h6 class="font-main text-left text-uppercase "><?php echo e($branch->address); ?></h6>
                            <h6 class="font-main text-left text-uppercase"><?php echo e($branch->phone); ?></h6>
                        </div>
                    </div>
                </div>


                <button class="d-block w-100 btn btn-primary font-main" onclick="Print()">
                    طباعة
                </button>

            </div>
        </div>
    </div>

    <script>
        function Print() {
            window.print()
        }
    </script>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/SalesBill/print.blade.php ENDPATH**/ ?>