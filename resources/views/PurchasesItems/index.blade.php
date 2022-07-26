@extends('dashboard.master')

@section('main-content')

    <style>


    </style>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تقرير مبيعات المشتريات </li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="px-3">

            <div class="form-row font-main align-items-center flex-row-reverse mx-auto mb-2">
                <div class="col-12 col-md-6 my-1 text-right">
                    <label class="font-main text-right"> من تاريخ</label>
                    <input type="datetime-local" class="form-control fromDate" />
                </div>
                <div class="col-12 col-md-6 my-1 text-right">
                    <label class="font-main text-right"> الي تاريخ </label>
                    <input type="datetime-local" class="form-control toDate" />
                </div>


            </div>

            <div class="form-row font-main align-items-center flex-row-reverse mx-auto justify-content-center mb-2">
                <div class="col-12 col-md-6 my-1 text-right">
                    <div class="form-group">
                        <label>مجموعة الاصناف</label>
                        <select class="form-control categorySelect">
                            <option value="all"> الكل </option>
                            @foreach ($categorys as $category)
                                <option value="{{ $category->id }}"> {{ $category->namear }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-6 my-1 text-right">
                    <div class="form-group">
                        <label>الاصناف</label>
                        <select class="form-control itemsSelect">
                            <option value="all"> الكل </option>
                            @foreach ($items as $item)
                                <option value="{{ $item->id }}"> {{ $item->namear }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>


            <div class="form-row font-main align-items-center flex-row-reverse mx-auto justify-content-center mb-2">
                <div class="col-12 col-md-6 my-1 text-right">
                    <div class="form-group">
                        <label>فرع</label>
                        <select class="form-control branchesSelect">
                            <option value="all"> الكل </option>
                            @foreach ($branches as $branche)
                                <option value="{{ $branche->id }}"> {{ $branche->namear }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-6 my-1 text-right">
                    <div class="form-group">
                        <label>العميل</label>
                        <select class="form-control customerSelect">
                            <option value="all"> الكل </option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"> {{ $customer->name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12 my-1 text-right">
                <form method="POST" id="myForm" action="{{ route('createPdf') }}">
                    @csrf
                    <input type="hidden" id="fromId" name="from" value="456">
                    <input type="hidden" id="toId" name="to" value="123">
                    <input type="hidden" id="priceAfterTaxForm" name="priceAfterTax" value="">
                    <input type="hidden" id="totalDiscountRateFrom" name="totalDiscountRate" value="">
                    <input type="hidden" id="totalDiscountValForm" name="totalDiscountVal" value="">
                    <input type="hidden" id="totalTaxRateForm" name="totalTaxRate" value="">
                    <input type="hidden" id="netTotalForm" name="netTotal" value="">
                    <input type="hidden" id="dataForm" name="data[]" value="">
                    <button type="submit" onclick="handelPrint(event)" class="btn btn-primary font-main px-4 py-1 my-3"> تصدير PDF </button>
                    <button type="button" onclick="filterDate(event)" class="btn btn-primary font-main px-4 py-1 my-3"> عرض
                    </button>
                </form>


            </div>
        </div>


        <div class="row flex-row-reverse font-main px-5 my-5">
            <div class="col-12 col-md-4">
                <div class="btn-primary text-right p-2">
                    <p class="text-light font-weight-bold mb-0 pb-0 px-2"> المبيعات </p>
                </div>
                <div class="details">
                    <table class="table" dir="rtl">
                        <tbody>
                            <tr>
                                <th class="text-right"> اجمالي </th>
                                <td class="text-center priceAfterTaxVal"> 00 </td>
                            </tr>
                            <tr>
                                <th class="text-right"> نسبة الخصم </th>
                                <td class="text-center totalDiscountRate"> 00 </td>
                            </tr>
                            <tr>
                                <th class="text-right"> قيمة الخصم </th>
                                <td class="text-center totalDiscountVal"> 00 </td>
                            </tr>
                            <tr>
                                <th class="text-right"> قيمة مضافة </th>
                                <td class="text-center totalTaxRate"> 00 </td>
                            </tr>
                            <tr>
                                <th class="text-right"> اجمالي </th>
                                <td class="text-center netTotal"> 00 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="btn-primary text-right p-2">
                    <p class="text-light font-weight-bold mb-0 pb-0 px-2"> مرتجع المبيعات </p>
                </div>
                <div class="details">
                    <table class="table" dir="rtl">
                        <tbody>
                            <tr>
                                <th class="text-right"> اجمالي </th>
                                <td class="text-center"> 00 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="btn-primary text-right p-2">
                    <p class="text-light font-weight-bold mb-0 pb-0 px-2"> صافي الرصيد </p>
                </div>
                <div class="details">
                    <table class="table" dir="rtl">
                        <tbody>
                            <tr>
                                <td class="text-right"> 00 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>



        <div class="card-body">
            <div class="table-responsive">


                <table class="table table-striped table-bordered" id="salesInvoice-dataTable2" dir="rtl" width="100%"
                    cellspacing="0">
                    <thead class="btn-primary">
                        <tr class="text-center font-main">
                            <th> الصنف </th>
                            <th> الوحدة </th>
                            <th> الكمية </th>
                            <th> السعر </th>
                            <th> اجمالي </th>
                            <th> الخصم </th>
                            <th> اجمالي </th>
                            <th> الضرائب </th>
                            <th> اجمالي </th>
                        </tr>
                    </thead>
                    <tbody class="bodyTableSalesItems">

                    </tbody>
                </table>

            </div>
        </div>


    </div>
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert.css') }}" rel="stylesheet">

    <style>
        #salesInvoice-dataTable2 {
            width: 100%;
        }



        #salesInvoice-dataTable2>thead {
            display: table;
            width: 100%;
        }

        .bodyTableSalesItems {
            display: block;
            width: 100%;
            max-height: 200px;
            overflow-y: scroll;
        }


        .select2-selection.select2-selection--single {
            height: 40px !important;
        }

        .tdBody>td {
            width: 163px;
        }

    </style>

@endpush

@push('scripts')
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src=" {{ asset('js/sweetalert.min.js') }} "></script>
    <script src=" {{ asset('js/select2.min.js') }} "></script>
    <script src=" {{ asset('js/ItemsReports/index.js') }} "></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>

    <script>
        let Optimzation = [];
        const Export = () => {
            $.ajax({
                type: 'GET',
                url: "/erp/public/export-excel",
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    console.log(data);
                }
            });
        }


        $(document).ready(function() {
            $('.categorySelect').select2({
                allowClear: true,
                width: 'resolve',
            });
            $('.itemsSelect').select2({
                allowClear: true,
                width: 'resolve',
            });
            $('.branchesSelect').select2({
                allowClear: true,
                width: 'resolve',
            });
            $('.customerSelect').select2({
                allowClear: true,
                width: 'resolve',
            });

        });



        function filterDate(event) {
            event.preventDefault();
            let from = $('.fromDate').val();
            let to = $('.toDate').val();
            let branch = $('.branchesSelect').val();
            let customer = $('.customerSelect').val();
            let item = $('.itemsSelect').val();
            let category = $('.categorySelect').val();

            if (from && to) {
                document.querySelector('.preloader').classList.remove("hiden-pre-load");
                $.ajax({
                    type: 'POST',
                    url: "/erp/public/PurchasesItems/FilterItemsReports",
                    data: {
                        _token: "{{ csrf_token() }}",
                        from,
                        to,
                        branch,
                        customer,
                        item,
                        category
                    },
                    success: function(data) {
                        document.querySelector('.preloader').classList.add("hiden-pre-load");
                        if (data.items.length == 0) {
                            $('.bodyTableSalesItemsfirst').html('');
                            $('.bodyTableSalesItems').html("");
                            $('.netTotal').text("00");
                            $('.totalTaxRate').text("00")
                            $('.priceAfterTaxVal').text("00")
                            swal('لا يوجد بيانات')
                        } else {
                            $('.bodyTableSalesItemsfirst').html('');
                            $('.bodyTableSalesItems').html("");


                            let totalAfterTex = 0;
                            let discounts = 0;
                            let discountsRate = 0;
                            let totalTaxRate = 0;
                            let netTotal = 0;

                            data.items.forEach(element => {
                                let unit = data.units.find(item => item.id == element.unitId).namear;
                                element.unit = unit;
                                netTotal += element.nettotal;
                                totalTaxRate += element.rate;
                                totalAfterTex += element.total;
                                discounts += element.discountValue;
                                discountsRate += element.discountRate;

                                let oldItem = document.querySelector(
                                    `.qtn-${element.unitId}-${element.itemId}`);
                                if (oldItem) {
                                    let itemO = Optimzation.find(op => {
                                        if (op.itemId == element.itemId && op.unitId == element
                                            .unitId) {
                                            return op;
                                        }
                                        return op;
                                    });
                                    itemO.qtn = +itemO.qtn + +element.qtn;
                                    document.querySelector(`.qtn-${element.unitId}-${element.itemId}`)
                                        .innerHTML = +element.qtn + +document.querySelector(
                                            `.qtn-${element.unitId}-${element.itemId}`).innerHTML;
                                } else {
                                    Optimzation.push(element);
                                    item = `
                                    <tr class="text-center font-main tdBody">
                                            <td> ${ element.namear } </td>
                                            <td> ${ element.unit } </td>
                                            <td class="${`qtn-${element.unitId}-${element.itemId}`}"> ${ element.qtn } </td>
                                            <td> ${element.price} </td>
                                            <td> ${ Number(element.total).toFixed(2) } </td>

                                            <td> ${(element.discountValue)} </td>
                                            <td> ${element.total - element.discountValue} </td>
                                            <td> ${ Number( element.value.toFixed(4) ) } </td>
                                            <td> ${ Number( element.nettotal.toFixed(4) ) } </td>
                                        </tr>

                                    `;
                                    $('.bodyTableSalesItems').append(item);
                                }

                            });

                            $('.netTotal').text(Number(netTotal).toFixed(4));
                            $('.totalTaxRate').text(Number(totalTaxRate).toFixed(4))
                            $('.totalDiscountRate').text(Number(discountsRate) + "%")
                            $('.totalDiscountVal').text(Number(discounts).toFixed(4))
                            $('.priceAfterTaxVal').text(Number(totalAfterTex).toFixed(4))

                            $('#priceAfterTaxForm').val(totalAfterTex);
                            $('#totalDiscountRateFrom').val(totalTaxRate);
                            $('#totalDiscountValForm').val(discounts);
                            $('#totalTaxRateForm').val(totalTaxRate);
                            $('#netTotalForm').val(netTotal);
                            $('#dataForm').val(JSON.stringify(Optimzation));

                        }

                    }
                });
            } else {
                swal('يجب تحديد التفاصيل')
            }
        }

        const handelPrint = (event) => {
            event.preventDefault();
            if(Optimzation.length != 0) {
                $('form#myForm').submit();
            }else {
                swal('لا يوجد بيانات للطباعة')
            }
        }
        const PrintReports = () => {
            let priceAfterTaxVal = $('.priceAfterTaxVal').text();
            let totalTaxRate = $('.totalTaxRate').text();
            let netTotal = $('.netTotal').text();
            let from = $('.fromDate').val();
            let to = $('.toDate').val();

            if (Optimzation.length == 0) {
                swal('لا يوجد بيانات للطباعة')
            } else {
                document.querySelector('.preloader').classList.remove("hiden-pre-load");
                $.ajax({
                    type: 'POST',
                    url: "/erp/public/printItmesReport",
                    data: {
                        _token: "{{ csrf_token() }}",
                        data: Optimzation,
                        from,
                        to,
                        priceAfterTaxVal,
                        totalTaxRate,
                        netTotal
                    },
                    success: function(data) {
                        document.querySelector('.preloader').classList.add("hiden-pre-load");
                        console.log(data);
                    }
                });
            }

        }


        const PrintReportsFront = () => {
            let total = $('.priceAfterTaxVal').text();
            let discount = $('.totalDiscount').text();
            let taxRate = $('.totalTaxRate').text();
            let netTotal = $('.netTotal').text();

            let parms = {
                Optimzation,
                total,
                discount,
                taxRate,
                netTotal
            }
            let handle = window.open(
                window.location.origin + '/erp/public/ReportsPrint', '_blank', 'width=' + window.screen.width +
                ',height=' + window.screen.height,
            )
            handle.window.parameters = JSON.stringify(parms)
        }

        const PrintItemsPDF = () => {
            let priceAfterTaxVal = $('.priceAfterTaxVal').text();
            let totalTaxRate = $('.totalTaxRate').text();
            let netTotal = $('.netTotal').text();
            let from = $('.fromDate').val();
            let to = $('.toDate').val();

            // if (Optimzation.length == 0) {
            //     swal('لا يوجد بيانات للطباعة')
            // } else {
            //     document.querySelector('.preloader').classList.remove("hiden-pre-load");
            $.ajax({
                type: 'POST',
                url: "/erp/public/getDownloadPdf",
                data: {
                    _token: "{{ csrf_token() }}",
                    data: Optimzation,
                    from,
                    to,
                    priceAfterTaxVal,
                    totalTaxRate,
                    netTotal
                },
                success: function(data) {
                    // document.querySelector('.preloader').classList.add("hiden-pre-load");
                    console.log(data);
                }
            });
            // }
        }
    </script>
@endpush
