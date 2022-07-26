@extends('dashboard.master')

@section('main-content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> تقرير كشف حساب </li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="company text-right font-ar">
        <div class="container-fluid py-4">
            <div class="row mx-0">
                <div class="col-12 col-md-11 mx-auto px-0  font-main">
                    <form dir="rtl" method="POST" action="{{ route('customers.store') }}">
                        {{ csrf_field() }}

                        <div class="row py-2">
                            <div class="col-6 my-1 text-right">
                                <label class="font-main text-right"> من تاريخ </label>
                                <input type="datetime-local" name="from" class="form-control fromDate" />
                            </div>
                            <div class="col-6 my-1 text-right">
                                <label class="font-main text-right"> الي تاريخ </label>
                                <input type="datetime-local" to="to" class="form-control toDate" />
                            </div>

                            <div class="col-12 col-md-6 mx-auto">
                                <label class="col-form-label">اسم الحساب</label>
                                <select name="accountId" class="form-control chosen-select accountId" tabindex="4"
                                    dir="rtl">
                                    <option value="all"> الكل </option>
                                    @foreach ($accounts as $account)
                                        <option value={{ $account->account_id }}> {{ $account->name }} </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-12 col-md-6 mx-auto">
                                <label class="col-form-label"> مركز التكلفة </label>
                                <select name="cost_center" class="form-control chosen-select cost_center_id" tabindex="4"
                                    dir="rtl">
                                    <option value={{ null }}> --- </option>
                                    @foreach ($costCenters as $costCenter)
                                        <option value={{ $costCenter->id }}> {{ $costCenter->namear }} </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-12 col-md-6 ">
                                <label class="col-form-label">الفرع</label>
                                <select name="branshId" class="form-control chosen-select branshId" tabindex="4" dir="rtl">
                                    @foreach ($branches as $branche)
                                        <option value={{ $branche->id }}> {{ $branche->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="submiting d-flex mt-4">
                            <button type="submit" class="btn btn-primary mx-2 px-4" onclick="Show(event)"> عرض </button>
                            <button type="button" class="btn btn-primary mx-1 px-4" onclick="onViewPrint()"> طباعة </button>
                        </div>
                    </form>

                    <div class="col-12">
                        <div class="body-style-items table-responsive my-5">
                            <table class="table table-bordered table-striped" id="branches-dataTable" dir="rtl" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr class="text-center font-main">
                                        <th> م </th>
                                        <th> فرع </th>
                                        <th> تاريخ </th>
                                        <th> القيد </th>
                                        <th> الرقم - المصدر </th>
                                        <th> الوصف </th>
                                        <th> مدين </th>
                                        <th> دائن </th>
                                        <th> الرصيد </th>
                                    </tr>
                                </thead>
                                <tbody class="bodyAccountStateMent">

                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .chosen-single {
            height: 35px !important;
        }

        th {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .body-style-items {
            max-height: 400px !important;
            overflow-y: auto !important;
            margin: 30px 0
        }

        th,
        td {
            color: #555 !important;
            font-weight: bold;
            border: 1px solid #ccc !important;
        }

        input[type=number]::-webkit-inner-spin-button {
            display: none;
        }

        .td-style {
            width: 90px
        }

    </style>
@endpush

@push('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        let array = [];
        const Show = async (event) => {
            event.preventDefault();
            let from = $('.fromDate').val();
            let to = $('.toDate').val();
            let accountId = $('.accountId').val();
            let branchId = $('.branshId').val();
            let cost_center = $('.cost_center_id').val();
            let data = {
                from,
                to,
                accountId,
                branchId,
                cost_center
            };

            $.ajax({
                type: "POST",
                url: "/erp/public/account-statement/getData",
                data: data,
                success: function(data) {
                    if (data.length != 0) {
                        array = data;
                        let item = '';
                        let totoal_dector = 0;
                        let totoal_creditor = 0;
                        let totaling = 0;
                        let totalingDebit = 0;
                        let totalingCredit = 0;

                        data.forEach((ele, i) => {

                            if (ele.source != 0) {
                                if (ele.debtor != 0) {
                                    totaling += +ele.debtor;
                                    totalingDebit += ele.debtor;
                                }
                                if (ele.creditor != 0) {
                                    totaling -= ele.creditor
                                    totalingCredit += ele.creditor;
                                }
                            }
                            totoal_dector += ele.debtor;
                            totoal_creditor += ele.creditor;
                            item += `<tr class="text-center font-main">
                                    <td> ${i + 1} </td>
                                    <td> ${ele.branshName} </td>
                                    <td> ${ele.date} </td>
                                    <td> ${ele.numDailty} </td>
                                    <td> ${ele.source} - ${ele.source_name} </td>
                                    <td> ${ele.description} </td>
                                    <td class="text-success"> ${ele.debtor} </td>
                                    <td class="text-danger"> ${ele.creditor} </td>
                                    <td> ${totaling} </td>
                                </tr>`
                        })
                        $('.bodyAccountStateMent').html(item);
                        let row = `<tr class="text-center font-main">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2">اجمالي</td>
                                    <td class="text-success"> ${(totoal_dector).toFixed(3)} </td>
                                    <td class="text-danger"> ${(totoal_creditor).toFixed(3)} </td>
                                    <td class=${totaling > 0 ? "text-success" : "text-danger"}> ${totaling}</td>
                                </tr>`
                        $('.bodyAccountStateMent').append(row);
                    } else {
                        swal('لا يوجد بيانات')
                        $('.bodyAccountStateMent').html("");
                    }
                },
                error: function() {

                }
            });
        }


        const onViewPrint = () => {
            if (array.length == 0) {
                swal('لا يوجد بيانات للطباعة')
            } else {
                let from = $('.fromDate').val();
                let to = $('.toDate').val();
                let parms = {
                    data: array,
                    from,
                    to
                };
                let handle = window.open(window.location.origin + '/erp/public/account-statement-print', '_blank',
                    "width=" + window.screen.width + ",height=" + window.screen.height)
                handle.window.parameters = JSON.stringify(parms);
            }

        }
    </script>
@endpush
