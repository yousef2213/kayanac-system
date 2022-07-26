@extends('dashboard.master')

@section('main-content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <div class="container-fluid px-5">
        <div class="row">
            <nav aria-label="breadcrumb" class="">
                <ol class="breadcrumb justify-content-end font-main p-2">
                    <li class="breadcrumb-item active" aria-current="page"> تقرير مراكز التكلفة </li>
                    <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                </ol>
            </nav>
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul style="list-style: none;text-align: right">
                        <li class="font-main text-right">{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="container-fluid px-5">
        <div class="row font-main">
            <div class="col-12 mx-auto">
                <form action="" dir="rtl">
                    <div class="row text-right">
                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for="">من تاريخ</label>
                                <input type="datetime-local" class="form-control" name="from" id="date-from">
                            </div>
                        </div>
                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for="">الي تاريخ</label>
                                <input type="datetime-local" class="form-control" name="to" id="date-to">
                            </div>
                        </div>


                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for=""> الفروع </label>
                                <select class="form-control chosen-select" id="select-branches">
                                    @foreach ($branches as $branche)
                                        <option value="{{ $branche->id }}">{{ $branche->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for=""> الحسابات </label>
                                <select class="form-control chosen-select" id="select-accounts">
                                    <option value="0"> كل الحسابات </option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->account_id }}">{{ $account->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for=""> مراكز التكلفة </label>
                                <select class="form-control chosen-select" id="select-costCenters">
                                    <option value={{ null }}> -- </option>
                                    @foreach ($costCenters as $costCenter)
                                        <option value="{{ $costCenter->id }}">{{ $costCenter->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-right my-4">
                        <button class="btn btn-primary px-5" onclick="Show(event, '{{ csrf_token() }}')"> عرض </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-12">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="badget-dataTable" dir="rtl" width="100%">
                            <thead>
                                <tr class="text-center font-main" style="border: 0 !important">
                                    <th style="border: 0 !important"></th>
                                    <th style="border: 0 !important"></th>
                                    <th colspan="2"> اجمالي رصيد افتتاحي </th>
                                    <th colspan="2"> حركة الفترة </th>
                                    <th colspan="2"> الاجمالي </th>
                                    <th colspan="2"> الارصدة </th>
                                </tr>
                                <tr class="text-center font-main">
                                    <th> رقم الحساب </th>
                                    <th> اسم الحساب </th>
                                    <th> مدين </th>
                                    <th> دائن </th>
                                    <th> مدين </th>
                                    <th> دائن </th>
                                    <th> مدين </th>
                                    <th> دائن </th>
                                    <th> مدين </th>
                                    <th> دائن </th>
                                </tr>
                            </thead>
                            <tbody class="badgets"></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="badgetsTest d-none"></div>
@endsection
@push('styles')
    <style>
        .chosen-single {
            height: 35px !important;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid #000 !important
        }

    </style>
@endpush

@push('scripts')
    <script>
        let UpdatedList = [];
        let item;

        const Show = (event, csrf) => {
            event.preventDefault();
            let branch = $("#select-branches").val();
            let account = $("#select-accounts").val();
            let costCenters = $("#select-costCenters").val();
            let from = $("#date-from").val();
            let to = $("#date-to").val();
            let data = {
                _token: csrf,
                branch,
                account,
                costCenters,
                from,
                to
            };
            if (costCenters != "") {
                let ele = document.querySelector(".badgets");
                $.ajax({
                    type: "POST",
                    url: "/erp/public/cost_centers_reports/filter",
                    data,
                    success: function(res) {
                        let data = [...res.list2, ...res.list1];
                        if (data.length != 0) {
                            FormatData(res);
                        } else {
                            $('.badgets').html('');
                            swal("لا يوجد بيانات");
                        }
                    }
                });
            } else {
                swal("من فضلك تاكد من البيانات")
            }

        };


        const FormatData = res => {
            $('.badgets').html('<span></span>');
            let total_debtor = 0;
            let total_creditor = 0;
            let total_debtorm = 0;
            let total_creditorm = 0;
            UpdatedList = []

            let totaldb = 0;
            let totalcb = 0;
            let netTotaldb = 0;
            let netTotalcb = 0;
            let data = [...res.list2, ...res.list1];
            data.forEach(item => {
                if (item.type == "1") {
                    item.debtorm = 0;
                    item.creditorm = 0;
                    item.debtor = item.debtor;
                    item.creditor = item.creditor;
                }
                if (item.type == "2") {
                    item.debtorm = item.debtor;
                    item.creditorm = item.creditor;
                    item.debtor = 0;
                    item.creditor = 0;
                }
            });

            data.forEach(option => {
                let debtor1 = document.querySelectorAll(`.deb1-${option.account_id}`);
                let debtor2 = document.querySelectorAll(`.deb2-${option.account_id}`);
                let creditor1 = document.querySelectorAll(`.cer1-${option.account_id}`);
                let creditor2 = document.querySelectorAll(`.cer2-${option.account_id}`);
                if (debtor1.length != 0 || creditor1.length != 0 || debtor2.length != 0 || creditor2.length !=
                    0) {
                    let obj = UpdatedList.find(ele => ele.account_id == option.account_id);
                    if (option.type == 2) {
                        obj.debtorm += option.debtorm;
                        obj.creditorm += option.creditorm;
                        document.querySelector(`.cer2-${option.account_id}`).innerHTML = +(+document
                                .querySelector(`.cer2-${option.account_id}`).innerHTML + option.creditorm)
                            .toFixed(3);
                        document.querySelector(`.deb2-${option.account_id}`).innerHTML = +(+document
                                .querySelector(`.deb2-${option.account_id}`).innerHTML + option.debtorm)
                            .toFixed(3);
                    }
                    if (obj.type == 1) {
                        obj.debtor += option.debtor;
                        obj.creditor += option.creditor;
                        document.querySelector(`.deb1-${option.account_id}`).innerHTML = +(+document
                            .querySelector(`.deb1-${option.account_id}`).innerHTML + option.debtor).toFixed(
                            3);
                        document.querySelector(`.cer1-${option.account_id}`).innerHTML = +(+document
                                .querySelector(`.cer1-${option.account_id}`).innerHTML + option.creditor)
                            .toFixed(3);
                    }

                } else {
                    UpdatedList.push(option);
                    item = `<tr class="text-center font-main">
                                    <td> ${option.account_id} </td>
                                    <td> ${option.account_name} </td>
                                    <td class="deb1-${option.account_id}"> ${+option.debtor.toFixed(3)} </td>
                                    <td class="cer1-${option.account_id}"> ${+option.creditor.toFixed(3) } </td>
                                    <td class="deb2-${option.account_id}"> ${+option.debtorm.toFixed(3)}  </td>
                                    <td class="cer2-${option.account_id}"> ${+option.creditorm.toFixed(3) } </td>
                                    <td class="total-db-${option.id}-${option.account_id}"> 0 </td>
                                    <td class="total-cb-${option.id}-${option.account_id}"> 0 </td>
                                    <td class="balance-db-${option.id}-${option.account_id}">0</td>
                                    <td class="balance-cb-${option.id}-${option.account_id}">0</td>
                                </tr>
                            `
                    $('.badgets').append(item);
                }
            });


            UpdatedList.forEach(el => {
                document.querySelector(`.total-db-${el.id}-${el.account_id}`).innerHTML = +(el.debtor + el
                    .debtorm).toFixed(3);
                document.querySelector(`.total-cb-${el.id}-${el.account_id}`).innerHTML = +(el.creditor + el
                    .creditorm).toFixed(3);
                total_debtor += el.debtor;
                el.total_debtor = el.debtor + el.debtorm;
                el.total_creditor = el.creditor + el.creditorm;
                total_creditor += el.creditor;
                total_debtorm += el.debtorm;
                total_creditorm += el.creditorm;
            });

            UpdatedList.forEach(el => {
                totaldb += el.total_debtor;
                totalcb += el.total_creditor;
                let num = el.total_debtor - el.total_creditor;
                if (num > 0) {
                    el.nettotalDb = num;
                    el.nettotalCb = 0;
                    document.querySelector(`.balance-db-${el.id}-${el.account_id}`).innerHTML = +num.toFixed(3);
                } else {
                    el.nettotalDb = 0;
                    el.nettotalCb = num;
                    document.querySelector(`.balance-cb-${el.id}-${el.account_id}`).innerHTML = 0;
                    // document.querySelector(`.balance-cb-${el.id}-${el.account_id}`).innerHTML = num;
                }
            });

            UpdatedList.forEach(el => {
                netTotaldb += el.nettotalDb;
                netTotalcb += el.nettotalCb;
            });

            let item2 = `
                    <tr class="text-center font-main">
                        <td colspan="2"> الاجمالي </td>
                        <td class="text-success"> ${+total_debtor.toFixed(3)} </td>
                        <td class="text-danger"> ${+total_creditor.toFixed(3)} </td>
                        <td class="text-success"> ${+total_debtorm.toFixed(3)} </td>
                        <td class="text-danger"> ${+total_creditorm.toFixed(3)} </td>
                        <td class="text-success"> ${+totaldb.toFixed(3)} </td>
                        <td class="text-danger"> ${+totalcb.toFixed(3)} </td>
                        <td class="text-success"> ${+netTotaldb.toFixed(3)} </td>
                        <td class="text-danger"> ${+netTotalcb.toFixed(3)} </td>
                    </tr>`;
            $('.badgets').append(item2);
        }
    </script>
@endpush
