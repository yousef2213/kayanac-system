<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>POS</title>
    <link rel="shortcut icon" href="{{ asset('icon.png') }}" type="image/*">
    <link href="{{ asset('css/pos.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/chose.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pointStyle.css') }}">

</head>

<body>

    <?php
    $lang = LaravelLocalization::getCurrentLocale();
    ?>
    <!-- Preloader -->
    <div class="preloader">

        <div class="preloader-inner">
            <div class="preloader-icon">
                <img src="{{ asset('/pandig.svg') }}" alt="">
            </div>
        </div>
    </div>
    <!-- End Preloader -->
    <input type="hidden" name="lang" class="lang" value={{ $lang }}>
    <div class="container-fluid" style="height: 100vh; overflow: hidden;">
        <div class="row h-100">
            <div class="col-12 header-pos py-0 smallHead" style="max-height: 8%; height: 100%;">
                <div class="py-0 head d-flex align-items-center px-4 justify-content-between smallHeadChild">
                    @auth
                        <div class="d-flex align-items-center pl-4">
                            <h6
                                class="text-uppercase text-light font-main ml-2 {{ $lang == 'en' ? 'd-flex flex-row-reverse' : '' }}">
                                <span class="mx-2">{{ Auth::user()->name }}</span>
                                <span class="d-inline-block pl-2"> {{ __('pos.welcome') }} </span>
                            </h6>
                        </div>
                    @endauth


                </div>
            </div>


            <!-- Modal -->
            {{-- <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="LableModalPay" aria-hidden="true">
                <div class="modal-dialog" style="max-width: 800px">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="LableModalPay">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body font-main">
                            <div class="row">

                                <div class="col-7">
                                    <form>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"> Cash </label>
                                            <div class="col-sm-10">
                                                <input type="number" min="0.1" onclick="SetId('cashVal')" step="0.1"
                                                    id="cashVal" class="form-control" style="position: relative;">
                                                <button type="button" onclick="CalcVal('cashVal')"
                                                    class="btn btn-primary py-1 px-3"
                                                    style="position: absolute;right: 15px;top:2px"> Calc </button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label"> Visa </label>
                                            <div class="col-sm-10">
                                                <input type="number" onclick="SetId('visaVal')" min="0.1" step="0.1"
                                                    id="visaVal" class="form-control" style="position: relative;">
                                                <button type="button" onclick="CalcVal('visaVal')"
                                                    class="btn btn-primary py-1 px-3"
                                                    style="position: absolute;right: 15px;top:2px"> Calc </button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label"> MasterCard
                                            </label>
                                            <div class="col-sm-10">
                                                <input type="number" onclick="SetId('masterVal')" min="0.1" step="0.1"
                                                    id="masterVal" class="form-control" style="position: relative;">
                                                <button type="button" onclick="CalcVal('masterVal')"
                                                    class="btn btn-primary py-1 px-3"
                                                    style="position: absolute;right: 15px;top:2px"> Calc </button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputPassword" class="col-sm-2 col-form-label"> Credit </label>
                                            <div class="col-sm-10">
                                                <input type="number" onclick="SetId('creditVal')" min="0.1" step="0.1"
                                                    id="creditVal" class="form-control" style="position: relative;">
                                                <button type="button" onclick="CalcVal('creditVal')"
                                                    class="btn btn-primary py-1 px-3"
                                                    style="position: absolute;right: 15px;top:2px"> Calc </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-5">
                                    <div class="row">
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(1)"> 1</button>
                                        </div>
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(2)"> 2</button>
                                        </div>
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(3)"> 3</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(4)"> 4</button>
                                        </div>
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(5)"> 5</button>
                                        </div>
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(6)"> 6 </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(7)"> 7 </button>
                                        </div>
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(8)"> 8</button>
                                        </div>
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn btn-primary btn-print w-100 py-2"
                                                onclick="changePrinter(9)"> 9</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8 px-1 my-1">
                                            <button class="btn w-100 btn-primary btn-print py-2"
                                                onclick="changePrinter(0)"> 0</button>
                                        </div>
                                        <div class="col-4 px-1 my-1">
                                            <button class="btn w-100 btn-clear py-2 bg-warning"
                                                onclick="changePrinter(10)"> C </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">

                            <div class="d-flex justify-content-between w-100 flex-row-reverse align-items-center">
                                <div>
                                    <button type="button" class="btn btn-primary" onclick="PayNow(10)"
                                        data-dismiss="modal">Save</button>
                                    <button type="button" class="btn btn-success" onclick="PayNow(11)"
                                        data-dismiss="modal">Credit</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                </div>
                                <h6 class="netTotal23  font-weight-bold mb-0">00</h6>

                            </div>


                        </div>
                    </div>
                </div>
            </div> --}}


            <div class="col-12 col-md-5 mx-auto text-right col-setting col-small" style="height: 92%">
                <form class="pt-2">
                    <div class="form-group font-main div-customer">
                        <select class="form-control chosen p-3" name="customer" dir="rtl" id="customers">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" data-name={{ $customer->name }}>
                                    {{ $customer->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between flex-row-reverse">

                        <form onsubmit="return false;" style="max-width: 5%">
                            @csrf
                            <div class="form-group font-main" style="position: relative">
                                <input type="text" class="form-control text-right form-barcode" autocomplete="off"
                                    onkeyup="addItemDirectFilter(event)" id="filterItem"
                                    placeholder="Barcode ...">
                                {{-- <button type="button" onclick="addItemDirectFilter(event)" class="seaching-btn"> <i
                                        class="fa fa-search"></i> </button> --}}
                                <div>
                                    <ul class="list-group list-group-flush flashListHidden" id="flashList">
                                        @foreach ($items as $item)
                                            @foreach ($itemList as $listItem)
                                                @if ($listItem->itemId == $item->id)
                                                    <input type="hidden" id="descript"
                                                        data-itemid="{{ $item->id }}" />
                                                    <li class="list-group-item list-group-item-action font-main"
                                                        style="cursor: pointer">
                                                        <a href="#"
                                                            onclick="setItemDirectFilter({{ $item->id }},{{ $listItem->unitId }})">
                                                            {{ $item->namear }} -
                                                            {{ $units->find($listItem->unitId) ? $units->find($listItem->unitId)->namear : '....' }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <button type="submit" onclick="submiting(event)" style="display: none"> Actioi </button>
                        </form>

                        <select name="search" class="chosen" style="max-width: 95%;width: 100%">
                            @foreach ($items as $item)
                                <option value=""> {{ $item->namear }} </option>
                            @endforeach
                        </select>

                    </div>


                </form>


                <div class="heEdint">
                    <table class="table table-striped px-0 font-main text-center" dir="rtl">
                        <thead>
                            <tr>
                                <th class="py-1"> {{ __('pos.items') }} </th>
                                <th style="width: 70px" class="py-1"> {{ __('pos.price') }} </th>
                                <th style="width: 80px" class="py-1"> {{ __('pos.qtn') }} </th>
                                <th style="width: 70px" class="py-1"> {{ __('pos.vt') }} </th>
                                <th style="width: 70px" class="py-1"> {{ __('pos.total') }} </th>
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
                            class="total d-flex justify-content-between bg-dark py-1 font-main text-light px-1 {{ $lang == 'en' ? 'flex-row-reverse' : '' }}">
                            <h6 class="totalTaxVal  font-weight-bold">00</h6>
                            <h6 class="px-2"> {{ __('pos.totalwithouttax') }} </h6>
                        </div>
                        <div
                            class="total  d-flex justify-content-between bg-dark py-1 font-main text-light px-1 {{ $lang == 'en' ? 'flex-row-reverse' : '' }}">
                            <h6 class="taxVals  font-weight-bold">00</h6>
                            <h6 class="px-2"> {{ __('pos.taxval') }} </h6>
                        </div>
                        <div
                            class="total  d-flex justify-content-between bg-dark py-1 font-main text-light px-1 {{ $lang == 'en' ? 'flex-row-reverse' : '' }}">
                            <h6 class="netTotal  font-weight-bold">00</h6>
                            <h6 class="px-2"> {{ __('pos.netTotal') }} </h6>
                        </div>
                    </div>

                    <div class="btns d-flex justify-content-between">
                        <div class=" w-50">
                            <button class="btn btn-success font-main py-2 w-100 paynow" onclick="PayNow(1)">
                                {{ __('pos.paynow') }} </button>
                            <button class="btn btn-info font-main px-4 border-0 py-2 w-100" data-toggle="modal"
                                data-target="#payModal"> {{ __('pos.pay') }} </button>
                        </div>
                        <div class=" w-50">
                            <button class="btn btn-info font-main px-4 border-0 py-2 w-100" onclick="PayNow(2)"
                                disabled> {{ __('pos.hold') }} </button>
                            <button class="btn btn-danger font-main px-4 border-0  py-2 w-100"
                                onclick="CancelInvoice()"> {{ __('pos.cancel') }} </button>
                        </div>
                    </div>

                </div>

            </div>



            {{-- <div class="col-12 col-md-7 mx-auto d-none d-md-block text-center col-products">

                <div class="products d-flex flex-wrap" id="productsCats"
                    style="overflow: hidden; overflow-y: auto !important; max-height: 30vh !important;">
                    @foreach ($CatrgoryItems as $item)
                        <button class="product mx-1 mb-2 thisproduct" onclick="getItemById({{ $item->id }})">
                            <h6 class="font-main mt-2 mb-1" style="font-size: 13px">
                                {{ Str::limit($item->name, 20, '...') }} </h6>
                        </button>
                    @endforeach



                </div>
                <hr>


                <div class="modal fade" id="modalItems" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
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
            </div> --}}
        </div>
    </div>



    <!-- totaling -->
    {{-- <div class="d-none">
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
    </div> --}}


    <script type="text/javascript" src=" {{ asset('js/jquery.js') }} "></script>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/choosen.js') }}"></script>
    <script src=" {{ asset('js/select2.min.js') }} "></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/pos.js') }}"></script>

    <script>
        window.onload = function() {
            document.querySelector('.preloader').classList.add("hiden-pre-load");
        }
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

        const SetId = val => {
            valPrint = val;
        }

        const CalcVal = input => {
            let item = document.getElementById(input);

            let val1 = +document.getElementById("cashVal").value;
            let val2 = +document.getElementById("visaVal").value;
            let val3 = +document.getElementById("masterVal").value;
            let val4 = +document.getElementById("creditVal").value;
            let netTotal = $('.netTotal').text();
            netTotal = +netTotal;
            let total = val1 + val2 + val3 + val4;
            let newValue = netTotal - total;
            item.value = newValue;
        }

        function getItemById(id) {
            $.ajax({
                type: 'POST',
                url: "/erp/public/getItemById/" + id,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(data = []) {
                    $('#productsCategorys').empty();
                    let item;
                    let text = `name${lang}`;

                    data.items.forEach(option => {
                        let listItem = data.list.filter(item => item.itemId == option.id);
                        if (listItem.length == 1) {
                            item = `
                               <button class="product mx-1 mb-2 thisproduct"  onclick="addItem(${option.id})" >
                                   <h6 class="font-main my-2" style="font-size: 14px"> ${option[text].substring(0, 10,'..')} </h6>
                               </button>
                           `;
                        } else {
                            item = `
                               <button class="product mx-1 mb-2 thisproduct"  onclick="addItem(${option.id})" data-toggle="modal" data-target="#modalItems">
                                   <h6 class="font-main my-2" style="font-size: 14px"> ${option[text].substring(0, 10, '..')} </h6>
                               </button>
                           `;
                        }

                        $('#productsCategorys').append(item);
                    });
                }
            });
        }

        function addItemDirect(event) {
            let item = document.getElementById(event.target.value);
            let idItem = item.getAttribute("data-idItem");
            let idUnit = item.getAttribute("data-idList");
            $.ajax({
                type: 'POST',
                url: "/erp/public/getItemDirect/" + idItem + "/" + idUnit,
                data: {
                    _token: "{{ csrf_token() }}",
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

        function addItem(id) {
            $('.body-items').empty();
            $.ajax({
                type: 'POST',
                url: "/erp/public/getItem/" + id,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.list.length == 1) {
                        let text = `name${lang}`;
                        let {
                            unitId,
                            price1,
                            id
                        } = data.list[0];
                        let unit = data.units.find(item => item.id == unitId)[text];

                        confirmData(unitId, price1, data.item.namear, data.item.img, data.item.id, data.item
                            .description, data.item.group, data.item.priceWithTax, data.item.taxRate, data
                            .item.quantityM, id, data.item.nameen, unit)
                    } else {
                        createSwal(data)
                    }

                }
            });
        }

        async function createSwal(data) {
            $('.body-items').empty();
            let text = `name${lang}`;
            data.list.forEach((option, idx) => {
                let unit = data.units.find(item => item.id == option.unitId)[text];
                item = `
                       <button class="product mx-1 mb-2 thisproduct" data-dismiss="modal" onclick="confirmData(
                               ${option.unitId},
                               ${option.price1},
                               '${data.item.namear}',
                               '${data.item.img}',
                               '${data.item.id}',
                               '${data.item.description}',
                               '${data.item.group}',
                               '${data.item.priceWithTax}',
                               '${data.item.taxRate}',
                               '${data.item.quantityM}',
                               '${data.list[idx].id}',
                               '${data.item.nameen}',
                               '${unit}',
                               ) " >
                           <h6 class="font-main my-2" style="font-size: 13px">  ${data.units.find(item => item.id == +option.unitId)[text]} - ${option.price1} </h6>
                       </button>
                   `;
                $('.body-items').append(item);
            });
        }

        function confirmData(id, price, namear, img, idItem, description, group, priceWithTax, taxRate, quantityM, idxList,
            nameen, unit) {
            let data = {};
            data.unitId = id;
            data.listId = idxList;
            data.namear = namear;
            data.img = img;
            data.price = price;
            data.itemId = idItem;
            data.description = description;
            data.group = group;
            data.priceWithTax = priceWithTax;
            data.taxRate = taxRate;
            data.quantityM = quantityM;
            data.nameen = nameen;
            data.unitname = unit;
            if (data.priceWithTax == "1") {
                data.priceafterTax = data.price / `1.${data.taxRate}`;
                data.TaxVal = data.priceafterTax * data.taxRate / 100;
            } else {
                data.priceafterTax = data.price;
                data.TaxVal = data.priceafterTax * data.taxRate / 100;
            }
            if (lang == "ar") {
                name = data.namear;
            } else {
                name = data.nameen
            }
            let check = list.find(item => item.listId == idxList);
            let item;
            if (check) {
                check.qtn += 1;
                check.total = check.qtn * check.price;
                $('.input-qtn-' + check.unitId + '-' + data.itemId + '-' + idxList).text(check.qtn);
                $('.total-' + check.unitId + '-' + data.itemId + '-' + idxList).text(check.total);
            } else {
                data.qtn = 1;
                data.price1 = price;
                data.total = data.qtn * price;
                list.push(data);

                item = `
                       <tr class="row-${data.listId}">
                           <td  scope="row"> ${name.substring(0, 12,'..')} - ${data.unitname}</td>
                           <td style="width: 70px">
                               ${data.price1}
                           </td>

                           <td style="width: 80px" class="p-0 input-qtn-${data.unitId}-${data.itemId}-${idxList}">
                              <div class="d-flex justify-content-center w-100 p-0" style="overflow: hidden;">
                                   <button class="text-primary btn btn-delete pl-2 ml-2 text-center pr-0" style="width:10px" onclick="changeCount2(event,${idxList})" > <i class="fas fa-plus"></i> </button>
                                   <input type="input" class="input-form w-100 p-0 mx-2 text-center input-val-${data.unitId}-${data.itemId}-${idxList}" min="1" style="
                                       width: 36px !important;
                                       border: 1px solid #999;
                                       padding-right: 0 !important;
                                       padding-left: 0 !important;
                                       margin-left: 0 !important;
                                       margin-right: 0 !important;
                                       border-radius: 4px;
                                   " onkeyup="changeCount(event,${idxList})" value=${data.qtn} />
                                   <button class="text-primary btn btn-delete pr-1 rx-2 text-center" style="width:10px" onclick="changeCount3(event,${idxList})" > <i class="fas fa-minus"></i> </button>
                              </div>
                           </td>
                           <td style="width: 70px">
                               ${data.TaxVal.toFixed(2)}
                           </td>
                           <td style="width: 70px" class="total-${data.unitId}-${data.itemId}-${idxList}"> ${ Number(data.total).toFixed(2) } </td>
                           <td class="" style="width: 70px">
                               <button class="text-danger btn btn-delete" onclick="deleteRow(${data.listId})" > <i class="fas fa-trash"></i> </button>
                           </td>
                       </tr>
                   `
            }

            getTotal()
            $('.tableItems').append(item);
        }

        function changeCount(event, id) {
            list = [...list];
            let item = list.find(item => item.listId == id);
            item.qtn = +event.target.value;
            item.total = +event.target.value * item.price;
            $(`.total-${item.unitId}-${item.itemId}-${item.listId}`).text(Number(item.total).toFixed(2));
            getTotal()
        }

        function changeCount2(event, id) {
            list = [...list];
            let item = list.find(item => item.listId == id);
            item.qtn += 1;
            item.total = item.qtn * item.price;
            $(`.input-val-${item.unitId}-${item.itemId}-${item.listId}`).val(item.qtn);
            $(`.total-${item.unitId}-${item.itemId}-${item.listId}`).text(Number(item.total).toFixed(2));
            getTotal()
        }

        function changeCount3(event, id) {
            list = [...list];
            let item = list.find(item => item.listId == id);
            if (item.qtn != 1) {
                item.qtn -= 1;
                item.total = item.qtn * item.price;
                $(`.input-val-${item.unitId}-${item.itemId}-${item.listId}`).val(item.qtn);
                $(`.total-${item.unitId}-${item.itemId}-${item.listId}`).text(Number(item.total).toFixed(2));
                getTotal()
            }
        }

        function changePrice(event, id) {
            list = [...list];
            let item = list.find(item => item.listId == id);
            item.price = +event.target.value;
            item.total = +event.target.value * item.qtn;
            $(`.total-${item.unitId}-${item.itemId}-${item.listId}`).text(Number(item.total).toFixed(2));
            getTotal()
        }

        function getItem(event) {
            addItem(event.target.value)
        }

        function deleteRow(id) {
            list = [...list];
            list = list.filter(item => item.listId != id);
            $('.row-' + id).remove()
            getTotal()
        }

        function getTotal() {
            let total = 0;
            let vals = 0;
            let totalVals = 0;
            list.forEach(item => {
                total += item.total
            });
            list.forEach(item => {
                vals += item.TaxVal * item.qtn
            });
            list.forEach(item => {
                totalVals += item.priceafterTax * item.qtn
            });
            $('.totalTaxVal').text(Number(totalVals).toFixed(2));
            $('.netTotal').text(Number(total).toFixed(2));
            $('.netTotal23').text(Number(total).toFixed(2));
            $('.taxVals').text(Number(vals).toFixed(2));
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
                        _token: "{{ csrf_token() }}",
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
            console.log(event.target.value);
            if (event.target.value == 5) {
                if ($('.tablesType').hasClass('d-none')) {
                    $('.tablesType').removeClass('d-none')
                    $('tbody').addClass('checkH')
                }
            } else {
                $('.tablesType').addClass('d-none')
                $('tbody').removeClass('checkH')
            }
        }

        function getTypeTable(event) {
            console.log('table', event.target.value);
        }

        function CancelInvoice() {
            list = [];
            getTotal();
            $('.totalTaxVal').text(0);
            $('.netTotal').text(0);
            $('.taxVals').text(0);
            // pay type
            $('#cashVal').val(0);
            $('#visaVal').val(0);
            $('#masterVal').val(0);
            $('#creditVal').val(0);
            $('#productsCategorys').empty();
            $('.tableItems').empty();
        }

        function sendAlertClose() {
            $.ajax({
                type: 'GET',
                url: "/erp/public/close-shift",
                data: {
                    _token: "{{ csrf_token() }}",
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
            console.log({
                id,
                unitId
            });
            $.ajax({
                type: 'POST',
                url: "/erp/public/getItemDirect/" + id + "/" + unitId,
                data: {
                    _token: "{{ csrf_token() }}",
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
                        let name = data.units.find(item => item.id == unitId).namear;
                        confirmData(unitId, price1, data.item.namear, data.item.img, data.item.id, data.item
                            .description, data.item.group, data.item.priceWithTax, data.item.taxRate, data
                            .item.quantityM, id, data.item.nameen)
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
                    _token: "{{ csrf_token() }}",
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
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.status == 200) {
                        let items = data;
                        if (items.InvoicesDetails.length == 0) {
                            $.ajax({
                                type: 'POST',
                                url: "/erp/public/pos/end-shift",
                                data: {
                                    _token: "{{ csrf_token() }}",
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
                                let namear = items.units.find(unit => unit.id == option.unitId).namear;
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
                                           <td scope="row"> ${option.namear} - ${namear} </td>
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
                                `<img class="rounded" width="100" src="{{ asset('comp/${items.company.logo}') }}" alt="">`;
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
                                    _token: "{{ csrf_token() }}",
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
</body>

</html>
