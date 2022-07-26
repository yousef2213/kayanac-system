@extends('dashboard.master')

@section('main-content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <div class="container-fluid px-5">
        <div class="row">
            <nav aria-label="breadcrumb" class="">
                <ol class="breadcrumb justify-content-end font-main p-2">
                    <li class="breadcrumb-item active" aria-current="page"> تقرير قائمة الدخل </li>
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
                        <button class="btn bg-main px-5" onclick="Show(event, '{{ csrf_token() }}')"> عرض </button>
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

                                <tr class="text-center font-main">
                                    <th> رقم الحساب </th>
                                    <th> اسم الحساب </th>
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
            let ele = document.querySelector(".badgets");
            $.ajax({
                type: "POST",
                url: "/erp/public/income_list/filter",
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
            //

            let dataStore = [...new Set(data.map(item => item.parent_name))]
            let setN = {};
            dataStore.forEach(ele => {
                setN = {
                    ...setN,
                    [ele]: data.filter(item => item.parent_name === ele)
                };
            });
            if (Object.keys(setN).length > 0) {
                let row;
                let title;
                for (let item of Object.keys(setN)) {
                    let dataStoreGroup = [...new Set(setN[item].map(item => item.itemGroupName))]
                    let netObjs = {};
                    dataStoreGroup.forEach(ele => {
                        netObjs = {
                            ...netObjs,
                            [ele]: setN[item].filter(item => item.itemGroupName === ele)
                        };
                    });
                    title = `<tr class="text-center bg-main font-main">
                        <td colspan="4" class="text-right text-light"> ${item} </td>
                    </tr>`;
                    $('.badgets').append(title);
                    getData(setN[item]);

                }
            }
            //
        }





        const getData = list => {

            list.forEach(option => {
                let debtor = document.querySelectorAll(`.deb1-${option.account_id}`);
                let creditor = document.querySelectorAll(`.cer1-${option.account_id}`);
                if (debtor.length != 0 || creditor.length != 0) {
                    let obj = UpdatedList.find(ele => ele.account_id == option.account_id);
                    obj.debtor += option.debtor;
                    obj.creditor += option.creditor;
                    document.querySelector(`.deb1-${option.account_id}`).innerHTML = +(+document.querySelector(
                        `.deb1-${option.account_id}`).innerHTML + option.debtor).toFixed(3);
                    document.querySelector(`.cer1-${option.account_id}`).innerHTML = +(+document.querySelector(
                        `.cer1-${option.account_id}`).innerHTML + option.creditor).toFixed(3);

                } else {
                    UpdatedList.push(option);
                    item = `<tr class="text-center font-main">
                    <td> ${option.account_id} </td>
                    <td> ${option.account_name} </td>
                    <td class="deb1-${option.account_id}"> ${+option.debtor.toFixed(3)} </td>
                    <td class="cer1-${option.account_id}"> ${+option.creditor.toFixed(3) } </td>
                </tr>
            `
                    $('.badgets').append(item);
                }

            });

            let totalDebtor = 0;
            let totalCreditor = 0;
            UpdatedList.forEach(row => {
                totalDebtor += row.debtor;
                totalCreditor += row.creditor;
            })

            let row = '';
            let textRow = '';
            row = `<tr class="text-center font-main">
                        <td colspan="2"> اجمالي </td>
                        <td class="text-success"> ${+totalDebtor.toFixed(3)} </td>
                        <td class="text-danger"> ${+totalCreditor.toFixed(3) } </td>
                    </tr>
                `;
            let result = +totalCreditor - +totalDebtor;
            textRow = `<tr class="text-center font-main">
                    <td colspan="4" class="text-right"> ${totalDebtor < totalCreditor ? `
                            <div class="d-flex align-items-center">
                                <h6 class="mx-3 p-0 my-0 safeResult"> صافي الربح : </h6>
                                <span class="text-success">${+result.toFixed(3)}</span>
                            </div>
                            `: `
                            <div class="d-flex align-items-center">
                                <h6 class="mx-3 p-0 my-0 safeResult"> صافي الخسائر :  </h6>
                                <span class="text-danger">${+Math.abs(result).toFixed(3)}</span>
                            </div>
                    `} </td>
                </tr>
            `
            $('.badgets').append(row);
            $('.badgets').append(textRow);
        }
    </script>
@endpush
