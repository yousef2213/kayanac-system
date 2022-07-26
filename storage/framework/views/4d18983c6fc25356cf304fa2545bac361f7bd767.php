 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>POS</title>
     <link rel="shortcut icon" href="<?php echo e(asset('logo.png')); ?>" type="image/x-icon">
     <link href="<?php echo e(asset('css/pos.css')); ?>" rel="stylesheet" type="text/css">
     <link href="<?php echo e(asset('css/chose.css')); ?>" rel="stylesheet" type="text/css">
     <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
     <link href="<?php echo e(asset('css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
     <link href="<?php echo e(asset('backend/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
     <link href="<?php echo e(asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet">
     <link rel="stylesheet" href="<?php echo e(asset('css/sweetalert.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('css/posStyle.css')); ?>">


 </head>

 <body>

     <?php
     $lang = LaravelLocalization::getCurrentLocale();
     ?>
     <!-- Preloader -->
     <div class="preloader">

         <div class="preloader-inner">
             <div class="preloader-icon">
                 <img src="<?php echo e(asset('/pandig.svg')); ?>" alt="">
             </div>
         </div>
     </div>
     <!-- End Preloader -->
     <input type="hidden" name="lang" class="lang" value=<?php echo e($lang); ?>>
     <div class="container-fluid" style="height: 100vh; overflow: hidden;">
         <div class="row h-100">
             <div class="col-12 header-pos py-0 smallHead" style="max-height: 5%; height: 100%;">
                 <div class="py-0 head d-flex align-items-center px-4 justify-content-between smallHeadChild">
                     <?php if(auth()->guard()->check()): ?>
                         <div class="d-flex align-items-center pl-4">
                             <h6
                                 class="text-uppercase text-light font-main ml-2 <?php echo e($lang == 'en' ? 'd-flex flex-row-reverse' : ''); ?>">
                                 <span class="mx-2"><?php echo e(Auth::user()->name); ?></span>
                                 <span class="d-inline-block pl-2"> <?php echo e(__('pos.welcome')); ?> </span>
                             </h6>
                         </div>
                     <?php endif; ?>

                     <?php if($shiftOpening->opening == 1): ?>
                         <div class="d-flex">

                            <button class="btn btn-info font-weight-bold btn-sm font-main ReturnedTrue mx-3"
                                 onclick="getDelevery()" data-toggle="modal"
                                 data-target="#deleverys"> طلبات التوصيل </button>

                            <button class="btn btn-warning btn-sm font-main" onclick="sendAlertClose()">
                                 <?php echo e(__('pos.reportdaily')); ?> </button>

                             <button class="btn btn-secondary font-weight-bold btn-sm font-main ReturnedFalse d-none"
                                 onclick="ReturnedFalse()"> الكاشير </button>

                             <button class="btn btn-warning btn-sm font-main" onclick="closeShify()">
                                 <?php echo e(__('pos.closeShift')); ?> </button>
                         </div>

                         <div class="modal fade" id="ordersHold">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header font-main">
                                         <h5 class="modal-title" id="ordersHoldLabel"> <?php echo e(__('pos.holds')); ?> </h5>
                                         <button type="button" class="close" data-dismiss="modal"
                                             aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                         </button>
                                     </div>
                                     <div class="modal-body">
                                         <table class="table text-center font-main" dir="rtl">
                                             <thead>
                                                 <tr>
                                                     <th> <?php echo e(__('pos.numOrder')); ?> </th>
                                                     <th> <?php echo e(__('pos.netTotal')); ?> </th>
                                                     <th> <?php echo e(__('pos.recovery')); ?> </th>
                                                 </tr>
                                             </thead>
                                             <tbody class="bodyOrdersHold">

                                             </tbody>
                                         </table>
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                             <?php echo e(__('pos.close')); ?> </button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     <?php else: ?>
                         <script>
                             window.location.replace(window.location.origin);
                         </script>
                     <?php endif; ?>
                 </div>
             </div>

             <?php echo $__env->make('POS.PayModel', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

             <div class="col-12 col-md-5 mx-auto text-right col-setting col-small" style="height: 95%">
                 <form class="pt-2">

                     <div class="form-group font-main d-flex justify-content-between">
                         <div class="w-100">
                             <select class="form-control chosen" name="customer" dir="rtl" id="stores">
                                 <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <option value="<?php echo e($store->id); ?>"><?php echo e($store->namear); ?> </option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </select>
                         </div>
                         <div class="w-100 d-flex customerParent">
                             <select class="form-control pb-3" name="customer" dir="rtl" id="customers">
                                 <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <option value="<?php echo e($customer->id); ?>" data-name=<?php echo e($customer->name); ?>>
                                         <?php echo e($customer->name); ?> - <?php echo e($customer->phone); ?> </option>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             </select>
                             <button type="button" class="btn btn-sm btn-success btn-adede" data-toggle="modal"
                                 data-target="#CustomerAdded"> + </button>
                         </div>



                     </div>


                     <div class="d-flex flex-row-reverse justify-content-between">
                         <div class="form-group font-main" style="width: 45%">
                             <select class="form-control products-search p-3" name="statusType" id="statusType"
                                 dir="rtl" onchange="getTypeInvoice(event)">
                                 <option value="5" class="font-main text-right" id="del5"> سفري </option>
                                 <option value="6" class="font-main text-right" id="del6"> محلي </option>
                                 <option value="7" class="font-main text-right" id="del7"> محلي طولات </option>
                                 <option value="4" class="font-main text-right" id="del8"> توصيل </option>
                                 <option value="8" class="font-main text-right" id="del9"> حجز </option>
                             </select>
                         </div>

                         
                         <div>
                             <input type="number" placeholder="سعر التوصيل"
                                 class="form-control text-center font-main d-none" onkeyup="handelDelevery(event)"
                                 id="price-deleiver">
                         </div>

                         <div class="form-group font-main tablesType d-none w-50">
                             <select class="form-control products-search p-3" id="tab" dir="rtl" onchange="getTypeTable(event)">
                                 <?php if($tables): ?>
                                     <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $table): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <option value="<?php echo e($table->id); ?>" class="font-main text-right">
                                             <?php echo e($table->numTable); ?> </option>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                             </select>
                         </div>
                     </div>



                 </form>


                 <div class="heEdint">
                     <table class="table table-striped px-0 font-main text-center" dir="rtl">
                         <thead>
                             <tr>
                                 <th style="width: 140px" class="py-1"> <?php echo e(__('pos.items')); ?> </th>
                                 <th style="width: 60px" class="py-1"> <?php echo e(__('pos.qtn')); ?> </th>
                                 <th style="width: 90px" class="py-1"> <?php echo e(__('pos.price')); ?> </th>
                                 <th style="width: 80px" class="py-1"> <?php echo e(__('pos.vt')); ?> % </th>
                                 <th style="width: 70px" class="py-1"> <?php echo e(__('pos.total')); ?> </th>
                                 <th style="width: 70px" class="py-1"> الوصف </th>
                                 <th style="width: 70px" class="py-1"> <i class="fas fa-trash"></i> </th>
                             </tr>
                         </thead>
                         <tbody class="tableItems">
                         </tbody>
                     </table>

                 </div>

                 <div class="setting">
                     <div
                         class=" d-flex justify-content-between flex-row-reverse bg-dark py-1 font-main text-light px-1">
                         <div
                             class="total d-flex justify-content-between bg-dark py-1 font-main text-light px-1 <?php echo e($lang == 'en' ? 'flex-row-reverse' : ''); ?>">
                             <h6 class="totalTaxVal  font-weight-bold">00</h6>
                             <h6 class="px-2"> <?php echo e(__('pos.totalwithouttax')); ?> </h6>
                         </div>
                         <div
                             class="total  d-flex justify-content-between bg-dark py-1 font-main text-light px-1 <?php echo e($lang == 'en' ? 'flex-row-reverse' : ''); ?>">
                             <h6 class="taxVals  font-weight-bold">00</h6>
                             <h6 class="px-2"> <?php echo e(__('pos.taxval')); ?> </h6>
                         </div>
                         <div
                             class="total  d-flex justify-content-between bg-dark py-1 font-main text-light px-1 <?php echo e($lang == 'en' ? 'flex-row-reverse' : ''); ?>">
                             <h6 class="netTotal font-weight-bold">00</h6>
                             <h6 class="px-2"> <?php echo e(__('pos.netTotal')); ?> </h6>
                         </div>
                     </div>

                     <div class="btns">
                         
                         <div class="d-flex justify-content-between">
                             <button class="btn btn-success font-main py-2 w-100 paynow btn-save-pos" disabled
                                 onclick="PayNowResturant(1,'<?php echo e(csrf_token()); ?>')">
                                 <?php echo e(__('pos.paynow')); ?> </button>
                             <button class="btn btn-info font-main px-4 border-0 py-2 w-100 btn-save-pos" disabled
                                 data-toggle="modal" data-target="#payModal"> <?php echo e(__('pos.pay')); ?> </button>


                             <button class="btn btn-info font-main px-4 border-0 py-2 w-100 btn-save-pos"
                                 onclick="PayNowResturant(4,'<?php echo e(csrf_token()); ?>')" disabled>
                                 توصيل </button>
                         </div>
                         <div class="d-flex justify-content-between">
                             <button class="btn btn-info font-main px-4 border-0 py-2 w-100 btn-save-pos" disabled
                                 onclick="PayNowResturant(3,'<?php echo e(csrf_token()); ?>')" disabled> <?php echo e(__('pos.hold')); ?>

                             </button>

                             <button class="btn btn-secondary font-main px-4 border-0 py-2 w-100  holdholdTrue"
                                 onclick="Returned()">
                                 الطلبات المعلقة </button>
                             <button class="btn btn-secondary font-weight-bold d-none font-main holdholdFalse"
                                 onclick="ReturnedFalse()"> شاشة المطعم </button>
                             <button class="btn btn-danger font-main px-4 border-0  py-2 w-100 btn-save-pos" disabled
                                 onclick="CancelInvoice()"> <?php echo e(__('pos.cancel')); ?> </button>
                         </div>
                     </div>

                 </div>

             </div>



             <div class="col-12 col-md-7 mx-auto d-none d-md-block text-center col-products">

                 <div class="products d-flex flex-wrap" id="productsCats"
                     style="overflow: hidden; overflow-y: auto !important; max-height: 30vh !important;">
                     <?php $__currentLoopData = $CatrgoryItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <button class="product mx-1 mb-2 thisproduct"
                             onclick="getItemById(<?php echo e($item->id); ?>, '<?php echo e(csrf_token()); ?>')">
                             <h6 class="font-main mt-2 mb-1" style="font-size: 13px">
                                 <?php echo e(Str::limit($item->name, 20, '...')); ?> </h6>
                         </button>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                 </div>
                 <hr>


                 <div class="modal fade" id="modalItems" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                         <div class="modal-content">

                             <div class="modal-body body-items">
                             </div>
                         </div>
                     </div>
                 </div>

                 <div id="productsCategorys" class="products d-flex  flex-wrap" style="max-height: 61vh !important;
                height: 100% !important;
                overflow-y: auto !important;">

                 </div>
             </div>

             <div class="col-12 col-md-7 mx-auto d-none text-center col-holde">
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
         </div>
     </div>



     <!-- totaling -->
     <div class="d-none">
         <div class="container">
             <div class="col-print mx-auto text-center my-4">
                 <div class="total">
                     <div class="row">
                         <div class="col-12 mx-auto text-center logo">

                         </div>
                     </div>
                     <div class="d-flex justify-content-between px-4 align-items-center my-2 mb-2">
                         <h5 class="invoiceId font-main"> 0 </h5>
                         <h5 class="font-main"> رقم الفاتورة </h5>
                     </div>
                     <div class="d-flex justify-content-between px-4 align-items-center my-2 mb-2">
                         <h5 class="companyName font-main"> </h5>
                         <h5 class="font-main"> اسم الشركة </h5>
                     </div>
                 </div>

                 <table class="table table-striped px-0 font-main text-center" dir="rtl">
                     <thead>
                         <tr>
                             <th scope="col"> الصنف </th>
                             <th scope="col"> السعر </th>
                             <th scope="col"> الكمية </th>
                             <th scope="col">الاجمالي</th>
                         </tr>
                     </thead>
                     <tbody class="bodyPrinter">

                     </tbody>
                 </table>
                 <hr>
                 <div class="total">
                     <div class="d-flex justify-content-between px-4 align-items-center my-2">
                         <h6 class="totalSalles font-main"> 00 </h6>
                         <h6 class="font-main"> اجمالي المبيعات </h6>
                     </div>
                     <div class="d-flex justify-content-between px-4 align-items-center my-2">
                         <h6 class="discountSalles font-main"> 00 </h6>
                         <h6 class="font-main"> خصم مبيعات </h6>
                     </div>
                     <div class="d-flex justify-content-between px-4 align-items-center my-2">
                         <h6 class="returnSalles font-main"> 00 </h6>
                         <h6 class="font-main"> مرتجع مبيعات </h6>
                     </div>

                     <div class="d-flex justify-content-between px-4 align-items-center my-2">
                         <h6 class="totalTaxRate font-main"> 0 </h6>
                         <h6 class="font-main"> ضريبة القيمة المضافة </h6>
                     </div>
                     <div class="d-flex justify-content-between px-4 align-items-center my-2">
                         <h6 class="payCach font-main"> 00 </h6>
                         <h6 class="font-main"> مدفوع نقدا </h6>
                     </div>
                     <div class="d-flex justify-content-between px-4 align-items-center my-2">
                         <h6 class="SBKA font-main"> 00 </h6>
                         <h6 class="font-main"> شبكة </h6>
                     </div>
                     <div class="d-flex justify-content-between px-4 align-items-center my-2">
                         <h6 class="visa font-main"> 00 </h6>
                         <h6 class="font-main"> فيزا </h6>
                     </div>

                 </div>
             </div>
         </div>
     </div>
     </div>


     <script type="text/javascript" src=" <?php echo e(asset('js/jquery.js')); ?> "></script>

     <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
     <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
     <script src="<?php echo e(asset('js/choosen.js')); ?>"></script>
     <script src=" <?php echo e(asset('js/select2.min.js')); ?> "></script>
     <script src="<?php echo e(asset('js/sweetalert.min.js')); ?>"></script>
     <script src="<?php echo e(asset('js/pos.js')); ?>"></script>

     <script>
         window.onload = function() {
             document.querySelector('.preloader').classList.add("hiden-pre-load");
         }

         //  window.addEventListener('beforeunload', function(e) {
         //      e.preventDefault();
         //      e.returnValue = '';
         //  });
         // document.addEventListener('contextmenu', (e) => {
         //     e.preventDefault();
         // });

         window.addEventListener("keydown", (event) => {
             if (event.keyCode == 119) {
                 PayNowResturant(1, '<?php echo e(csrf_token()); ?>')
             }
         })
     </script>



     <script>
         let list = [];
         let valPrint = "cashVal";
         const changePrinter = (num) => {
             let pointerSelect = document.getElementById(valPrint);
             if (num != 10) {
                 if (pointerSelect) pointerSelect.value += num;
             } else pointerSelect.value = pointerSelect.value.slice(0, -1);
         }; // change pointer keyboard


         function addItemDirect(event) {
             let item = document.getElementById(event.target.value);
             let idItem = item.getAttribute("data-idItem");
             let idUnit = item.getAttribute("data-idList");
             $.ajax({
                 type: 'POST',
                 url: "/erp/public/getItemDirect/" + idItem + "/" + idUnit,
                 data: {
                     _token: "<?php echo e(csrf_token()); ?>",
                 },
                 success: function(data) {
                     if (data.list.length == 1) {
                         let {
                             unitId,
                             price1,
                             id
                         } = data.list[0];
                         let name = data.units.find(item => item.id == unitId).namear;
                         confirmData(unitId, price1, data.item.namear, data.item.img, data.item.id, data.item
                             .description, data.item.group, data.item.priceWithTax, data.item.taxRate, data
                             .item.quantityM, id)
                     } else {
                         createSwal(data)
                     }
                 }
             });
         }






         function getItem(event) {
             addItem(event.target.value)
         }



         function PayNow(status = 1) {
             $('.paynow').attr('disabled', 'disabled');
             $('.btn-delete').attr('disabled', 'disabled');
             document.querySelector('.preloader').classList.remove("hiden-pre-load");
             let customerId = document.getElementById('customers').value;
             let customer = document.getElementById('customers');
             let totalAfter = $('.totalTaxVal').text();
             let taxVals = $('.taxVals').text();
             let netTotal = $('.netTotal').text();
             let statusVal = $('#statusType').val();

             // pay type
             let cash = $('#cashVal').val();
             let visa = $('#visaVal').val();
             let masterCard = $('#masterVal').val();
             let credit = $('#creditVal').val();


             if (status != 2 && status != 10 && status != 11) {
                 if (statusVal) {
                     status = statusVal;
                 }
             }
             if (status == 11) {
                 credit = netTotal;
                 status = 10;
             }




             if (list.length == 0) {
                 swal('تاكد من ان المعلومات صحيحة');
                 $('.paynow').removeAttr("disabled");
                 $('.btn-delete').removeAttr("disabled");
                 document.querySelector('.preloader').classList.add("hiden-pre-load");
             } else {
                 $.ajax({
                     type: 'POST',
                     url: "/erp/public/pos/save/paynow",
                     data: {
                         _token: "<?php echo e(csrf_token()); ?>",
                         list: list,
                         customerId: customerId,
                         netTotal: +netTotal,
                         taxVals: +taxVals,
                         typyInvoice: +statusVal,
                         totalAfter: +totalAfter,
                         status: status,
                         cash,
                         visa,
                         masterCard,
                         credit
                     },
                     success: function(res) {
                         document.querySelector('.preloader').classList.add("hiden-pre-load");
                         $('.paynow').removeAttr("disabled");
                         if (res.status == 200) {
                             list = [];
                             getTotal();
                             CancelInvoice()
                             $('#productsCategorys').empty();
                             $('.tableItems').empty();
                         }
                         if (res.status == 201) {
                             swal(res.msg)
                         }

                     }
                 });
             }

         }

         function getTypeInvoice(event) {
             if (event.target.value == 7) {
                 if ($('.tablesType').hasClass('d-none')) {
                     $('.tablesType').removeClass('d-none')
                     $('#price-deleiver').addClass('d-none')
                     $('tbody').addClass('checkH')
                 }
             } else if (event.target.value == 4) {
                 //  $('#price-deleiver').addClass('d-none')
                 $('#price-deleiver').removeClass('d-none')
                 $('.tablesType').addClass('d-none')
                 $('tbody').removeClass('checkH')
             } else {
                 $('.tablesType').addClass('d-none')
                 $('#price-deleiver').addClass('d-none')
                 $('tbody').removeClass('checkH')
             }
         }

         function getTypeTable(event) {
             console.log('table', event.target.value);
         }

         function sendAlertClose() {
             $.ajax({
                 type: 'GET',
                 url: "/erp/public/close-shift",
                 data: {
                     _token: "<?php echo e(csrf_token()); ?>",
                 },
                 success: function(data) {
                     if (data.status == 200) {
                         let handle = window.open(window.location.origin + '/erp/public/close-shift/printer',
                             '_blank', "width=" + window.screen.width + ",height=" + window.screen.height)
                         handle.window.parameters = JSON.stringify(data);
                     }
                     // window.close()
                 }
             });
         }

         function addItemDirectFilter(event) {
             event.preventDefault();

             if (document.getElementById("filterItem").value == "") {
                 document.getElementById('flashList').classList.add('flashListHidden')
             } else {
                 document.getElementById('flashList').classList.remove('flashListHidden')
             }

             let input, filter, ul, li, a, i, txtValue;
             input = document.getElementById("filterItem");
             filter = input.value.toUpperCase();
             ul = document.getElementById("flashList");
             li = ul.getElementsByTagName("li");
             for (i = 0; i < li.length; i++) {
                 a = li[i].getElementsByTagName("a")[0];
                 txtValue = a.textContent || a.innerText;
                 if (txtValue.toUpperCase().indexOf(filter) > -1) {
                     li[i].style.display = "";
                 } else {
                     li[i].style.display = "none";
                 }
             }
         }

         function setItemDirectFilter(id, unitId) {

             $.ajax({
                 type: 'POST',
                 url: "/erp/public/getItemDirect/" + id + "/" + unitId,
                 data: {
                     _token: "<?php echo e(csrf_token()); ?>",
                 },
                 success: function(data) {

                     document.getElementById('flashList').classList.add('flashListHidden')
                     document.getElementById("filterItem").value = ''
                     if (data.list.length == 1) {
                         let {
                             unitId,
                             price1,
                             id
                         } = data.list[0];
                         console.log("iss", data.item);

                         let name = data.units.find(item => item.id == unitId).namear;
                         confirmData(unitId, price1, data.item.namear, data.item.img, data.item.id, data.item
                             .description, data.item.group, data.item.priceWithTax, data.item.taxRate, data
                             .item.quantityM, id, data.item.nameen, data.item)
                     } else {
                         createSwal(data)
                     }
                 }
             });
         }

         function submiting(event) {
             event.preventDefault();
             let val = document.getElementById("filterItem").value;
             let id = document.getElementById("descript").getAttribute('data-itemid');
             $.ajax({
                 type: 'POST',
                 url: "/erp/public/getItemByBarCode/" + val,
                 data: {
                     _token: "<?php echo e(csrf_token()); ?>",
                 },
                 success: function(data) {
                     if (data.list.length == 0) {
                         swal('هذا الصنف غير موجود');
                     } else {
                         document.getElementById("filterItem").value = "";
                         let {
                             unitId,
                             price1,
                             id
                         } = data.list;
                         let name = data.units.find(item => item.id == unitId).namear;
                         confirmData(unitId, price1, data.item.namear, data.item.img, data.item.id, data.item
                             .description, data.item.group, data.item.priceWithTax, data.item.taxRate, data
                             .item.quantityM, id)
                     }
                 }
             });
         }
     </script>

     <script>
         let netTotal = 0;
         let netTotalHold = 0;
         let netQun = 0;
         let netQunHold = 0;

         let Optimzation = [];


         function closeShify() {
             swal({
                     title: "هل تريد اغلاق الوردية ؟",
                     icon: "warning",
                     buttons: true,
                     dangerMode: true,
                 })
                 .then((willDelete) => {
                     if (willDelete) {
                         CallingAfterCheck()
                     } else {
                         swal("الوردية ما زالت مفتوحة !");
                     }
                 });
         }

         function CallingAfterCheck() {
             $.ajax({
                 type: 'GET',
                 url: "/erp/public/close-shift",
                 data: {
                     _token: "<?php echo e(csrf_token()); ?>",
                 },
                 success: function(data) {
                     if (data.status == 200) {
                         let items = data;
                         if (items.InvoicesDetails.length == 0) {
                             $.ajax({
                                 type: 'POST',
                                 url: "/erp/public/pos/end-shift",
                                 data: {
                                     _token: "<?php echo e(csrf_token()); ?>",
                                     totalSalles: 0,
                                     totalTax: 0,
                                     Optimzation: [],
                                     payment: 0,
                                 },
                                 cache: false,
                                 success: function(res) {
                                     if (res.status == 200) {
                                         document.querySelector('.preloader').classList.add(
                                             "hiden-pre-load");
                                         window.location.replace(res.path);

                                     }

                                 }
                             });
                         } else {
                             Optimzation = [];
                             let item;
                             let itemHold;
                             let taxRateTotal = 0;
                             let priceAfter = 0;
                             let payCach = 0;
                             items.InvoicesDetails.forEach(it => {
                                 it.total = it.qtn * it.price;
                             });


                             items.InvoicesDetails.forEach(it => {
                                 if (it.priceWithTax == "1") {
                                     it.priceafterTax = it.price / `1.${it.taxRate}`;
                                     it.TaxVal = it.priceafterTax * it.taxRate / 100;
                                 } else {
                                     it.priceafterTax = it.price;
                                     it.TaxVal = it.priceafterTax * it.taxRate / 100;
                                 }
                             });

                             items.InvoicesDetails.forEach(option => {
                                 netTotal += +option.priceafterTax * +option.qtn;
                                 payCach += +option.total;
                                 netQun += +option.qtn;
                                 taxRateTotal += +option.TaxVal * +option.qtn;
                                 priceAfter += +option.priceafterTax;

                                 let oldItem = document.querySelectorAll(
                                     `.input-qtn-${option.unitId}-${option.itemId}`);

                                 if (oldItem.length != 0) {
                                     let itemO = Optimzation.find(op => op.itemId == option.itemId && op
                                         .unitId == option.unitId);
                                     itemO.qtn += option.qtn;
                                     document.querySelector(
                                             `.input-qtn-${option.unitId}-${option.itemId}`).innerHTML =
                                         option.qtn + +document.querySelector(
                                             `.input-qtn-${option.unitId}-${option.itemId}`).innerHTML
                                     document.querySelector(`.total-${option.unitId}-${option.itemId}`)
                                         .innerHTML = option.total + +document.querySelector(
                                             `.total-${option.unitId}-${option.itemId}`).innerHTML
                                 } else {
                                     Optimzation.push(option);
                                     item = `
                                        <tr class="">
                                            <td scope="row"> ${option.namear} - ${option.unit_name} </td>
                                            <td> ${option.price} </td>

                                            <td class="input-qtn-${option.unitId}-${option.itemId}"> ${option.qtn} </td>
                                            <td class="total-${option.unitId}-${option.itemId}"> ${option.total} </td>
                                        </tr>`
                                     $('.bodyPrinter').append(item)
                                 }
                             });

                             netTotal = Number(netTotal).toFixed(2)
                             netTotalHold = Number(netTotalHold).toFixed(2);

                             $('.totalSalles').text(netTotal);
                             let cach = +netTotal + +taxRateTotal;
                             $('.payCach').text(Number(cach).toFixed(2));


                             $('.groupTotal').text(priceAfter);
                             $('.totalTaxRate').text(Number(taxRateTotal).toFixed(2))
                             $('.netTotalHold').text(netTotalHold)
                             $('.netQtn').text(netQun)
                             $('.netQtnHold').text(netQunHold)
                             // company name
                             $('.companyName').text(items.company.companyNameAr)
                             $('.invoiceId').text(items.branch.id)
                             let img =
                                 `<img class="rounded" width="100" src="<?php echo e(asset('comp/${items.company.logo}')); ?>" alt="">`;
                             $('.logo').html(img)

                             // end function
                             document.querySelector('.preloader').classList.remove("hiden-pre-load");
                             let totalSalles = $('.totalSalles').text(); // net total
                             let totalTax = $('.totalTaxRate').text(); // taxvalue
                             let payment = $('.payCach').text(); // payment

                             $.ajax({
                                 type: 'POST',
                                 url: "/erp/public/pos/end-shift",
                                 data: {
                                     _token: "<?php echo e(csrf_token()); ?>",
                                     totalSalles,
                                     totalTax,
                                     Optimzation,
                                     payment,
                                 },
                                 cache: false,
                                 success: function(res) {
                                     if (res.status == 200) {
                                         document.querySelector('.preloader').classList.add(
                                             "hiden-pre-load");
                                         window.location.replace(res.path);
                                     }

                                 }
                             });

                         }
                     }
                 }
             });
         }
     </script>


     <!-- Script -->
     <script>
         $(document).ready(function() {
             // Initialize select2
             $("#customers").select2();
         });

         const Added = () => {
             let item = `<option value="<?php echo e($customer->id); ?>" data-name=<?php echo e($customer->name); ?>>
                                         <?php echo e($customer->name); ?> - <?php echo e($customer->phone); ?> </option>`;
             $('#customers').append(item)
         }
     </script>
 </body>

 </html>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/POS/index.blade.php ENDPATH**/ ?>