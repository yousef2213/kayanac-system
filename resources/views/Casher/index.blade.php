<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kayanac - Casher</title>
    <link rel="shortcut icon" href="{{ asset('1.png') }}" type="image/*">
    <link href="{{ asset('css/pos.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/chose.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/Casher.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <style>
        .customerParent {
            position: relative;
            overflow: hidden;
        }

        .btn-adede {
            position: absolute;
            height: 100%;
            padding: 0 20px;
        }

    </style>
</head>

<body style="overflow: hidden">
    <!-- Preloader -->
    <div class="preloader">

        <div class="preloader-inner">
            <div class="preloader-icon">
                <img src="{{ asset('/loadig.svg') }}" alt="">
            </div>
        </div>
    </div>
    <!-- End Preloader -->


    <div class="container-fluid" style="height: 100vh">
        <div class="row h-100">
            @include('Casher.printer')

            <div class="col-12 col-md-9 mx-auto text-right col-setting col-small" style="height: 100% !important">
                <form class="d-flex flex-row-reverse w-100 align-items-center mb-3 mt-1 he1">
                    <div class="form-group font-main d-flex justify-content-between customerParent div-customer form1">
                        <select class="form-control pb-3" name="customer" dir="rtl" id="customers">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" data-name={{ $customer->name }}>
                                    {{ $customer->name }} - {{ $customer->phone }} </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-sm btn-success btn-adede" data-toggle="modal"
                            data-target="#CustomerAdded"> + </button>
                    </div>

                    <form onsubmit="return false;" class="form2">
                        @csrf

                        <div class="form-group font-main w-100" style="position: relative">
                            <input type="text" class="form-control text-right form-barcode" autocomplete="off"
                                onkeyup="addItemDirectFilter(event)" id="filterItem"
                                placeholder="البحث عن طريق اسم / الكود">
                            <button type="button" onclick="addItemDirectFilter(event)" class="seaching-btn"> <i
                                    class="fa fa-search"></i> </button>
                            <div>
                                <ul class="list-group list-group-flush flashListHidden" id="flashList">
                                    @foreach ($itemList as $item)
                                        <input type="hidden" id="descript" data-itemid="{{ $item->itemId }}" />
                                        <li onclick="setItemDirectFilter({{ $item->itemId }},{{ $item->unitId }},'{{ csrf_token() }}')"
                                            class="list-group-item list-group-item-action font-main"
                                            style="cursor: pointer">
                                            <a class="a-link" href="#">
                                                {{ $item->item_name }} - {{ $item->unit_name }} </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <button type="submit" onclick="submiting(event,'{{ csrf_token() }}')" style="display: none">
                            action </button>
                    </form>



                </form>


                <div class=" he2">
                    <table class="table table-striped px-0 font-main text-center" dir="rtl">
                        <thead>
                            <tr>
                                <th class="th-casher"> الاسم </th>
                                {{-- <th class="th-casher th-casher-md"> الرصيد </th> --}}
                                <th class="th-casher"> الكمية </th>
                                <th class="th-casher"> السعر </th>
                                <th class="th-casher th-casher-md"> الخصم </th>
                                <th class="th-casher th-casher-md">% قيمة مضافة </th>
                                <th class="th-casher th-casher-md"> قيمة ضريبة </th>
                                <th class="th-casher"> صافي </th>
                                <th class="th-casher td-md"> <i class=" btn-md  fas fa-trash"></i> </th>
                            </tr>
                        </thead>
                        <tbody class="tableItems">
                        </tbody>
                    </table>
                </div>


                <div class="he3 setting d-flex">
                    <div
                        class="smallFlex d-flex justify-content-between total w-50 bg-dark py-1 font-main text-light px-1">
                        <div class="smallFlexChild d-flex align-items-center ">
                            <h6 class="netTotal font-weight-bold nettotal_inovice" style="font-size: 14px">00</h6>
                            <h6 class="px-2 font-weight-bold" style="font-size: 14px"> اجمالي مستحق </h6>

                        </div>
                        <div
                            class="total d-flex align-items-center justify-content-between bg-dark py-1 font-main text-light px-1">
                            <h6 class="taxVals font-weight-bold" style="font-size: 14px">00</h6>
                            <h6 class="px-2" style="font-size: 14px"> {{ __('pos.taxval') }} </h6>
                        </div>
                        <div class="d-flex align-items-center smallFlexChild">
                            <h6 class="totalTaxVal font-weight-bold _total" style="font-size: 14px">00</h6>
                            <h6 class="px-2" style="font-size: 14px"> {{ __('pos.totalwithouttax') }} </h6>
                        </div>
                    </div>
                    <div class="d-flex flex-row-reverse w-50">
                        <div class="w-100 parent-pay">
                            <button disabled
                                class="d-block w-100 btn-save-casher btn font-weight-bold btn-success btn-save-paynow font-main px-5 py-1"
                                onclick="PayNow(1,'{{ csrf_token() }}')">
                                ادفع الان
                            </button>

                            <button disabled
                                class="d-block w-100 btn  btn-save-casher btn-save-hold-small font-weight-bold font-main px-5  py-1"
                                onclick="PayNow(3,'{{ csrf_token() }}')">
                                تعليق
                            </button>

                        </div>
                        <div class="w-100 d-f-m">
                            <button disabled
                                class="d-block w-100 btn  btn-save-casher btn-save-hold font-weight-bold font-main px-5  py-2"
                                onclick="PayNow(3,'{{ csrf_token() }}')">
                                تعليق
                            </button>
                            <button disabled
                                class="btn btn-save-casher2 btn-info btn-save-pay font-main px-4 border-0 py-2 w-100"
                                data-toggle="modal" data-target="#payModal"> {{ __('pos.pay') }} </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('Casher.modelPay')


    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src=" {{ asset('js/select2.min.js') }} "></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('docsupport/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('boot5/bootstrap.min.js') }}"></script>


    <script src="{{ asset('js/choosen.js') }}"></script>
    <script src="{{ asset('js/casher.js') }}"></script>

    <script>
        window.onload = function() {
            document.querySelector('.preloader').classList.add("hiden-pre-load");
        }
        $(document).ready(function() {
            // Initialize select2
            $("#customers").select2();
        });
    </script>

    <script type="text/javascript">

        $(".chosen").chosen();
        $(document).ready(function() {
            $('.products-search').select2({
                placeholder: "البحث عن طريق اسم / الكود",
                allowClear: true,
                width: 'resolve'
            });

            $('.products-search-2').select2({
                placeholder: "البحث عن طريق اسم / الكود",
                allowClear: true,
                width: 'resolve'
            });
        });

        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = '';
        });
        // document.addEventListener('contextmenu', (e) => {
        //     e.preventDefault();
        // });

        window.addEventListener("keydown", (event) => {
            if (event.keyCode == 119) {
                PayNow(1, '{{ csrf_token() }}')
            }
        })
    </script>

</body>

</html>
