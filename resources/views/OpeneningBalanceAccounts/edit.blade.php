@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة رصيد افتتاحي </li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    @if (\Session::has('faild'))
        <div class="alert alert-danger">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right">{!! \Session::get('faild') !!}</li>
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="{{ route('opening_balance_accounts.update', $invoice->id) }}"
                autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="list[]" id="hidenValue">
                {{ csrf_field() }}

                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6">
                        <label class="col-form-label">الفرع</label>
                        <select name="branchId" class="form-control chosen-select" tabindex="4" dir="rtl">
                            @foreach ($branches as $branche)
                                <option value={{ $branche->id }}
                                    {{ $branche->id == $invoice->branchId ? 'selected' : '' }}> {{ $branche->namear }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <table class="table table-border">
                            <thead class="text-center">
                                <tr>
                                    <th colspan="2" style="font-size: 15px">اجماليات</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td colspan="1" style="font-size: 15px"> اجمالي المدين </td>
                                    <td colspan="1" style="font-size: 15px" class="md"> {{ $debtors }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px"> اجمالي الدائن </td>
                                    <td style="font-size: 15px" class="da"> {{ $credetors }} </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 15px"> الفرق </td>
                                    <td style="font-size: 15px" class="def"> {{ $debtors - $credetors }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="col-12 px-0">



                        <table class="table table-striped table-bordered mt-5">
                            <thead class="btn-primary">
                                <tr>
                                    <th> اسم الحساب </th>
                                    <th> مدين </th>
                                    <th> دائن </th>
                                    <th> بيان </th>
                                    <th>
                                        <button class="btn btn-success" type="button" onclick="addRow()"> + </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="bodys">
                                @foreach ($invoicesList as $item)
                                    <input type="hidden" name="listUpdate[{{ $item->id }}][id]"
                                        value="{{ $item->id }}">
                                    <tr class="Item-{{ $item->id }}">
                                        <td class="px-0">
                                            <select name="listUpdate[{{ $item->id }}][account_id]"
                                                class="form-control chosen-select w-100">
                                                <option value="null"> --- </option>
                                                @foreach ($accounts as $account)
                                                    <option value={{ $account->account_id }}
                                                        {{ $account->account_id == $item->account_id ? 'selected' : '' }}>
                                                        {{ $account->name }} </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="px-0">
                                            <input type="number" onkeyup="handeldebtor(event,'{{ $item->id }}')"
                                                name="listUpdate[{{ $item->id }}][debtor]" step="0.1"
                                                value="{{ $item->debtor }}"
                                                class="form-control debtor-{{ $item->id }}" />
                                        </td>
                                        <td class="px-0">
                                            <input type="number" onkeyup="handelcreditor(event,'{{ $item->id }}')"
                                                name="listUpdate[{{ $item->id }}][creditor]" step="0.1"
                                                value="{{ $item->creditor }}"
                                                class="form-control creditor-{{ $item->id }}" />
                                        </td>
                                        <td class="px-0">
                                            <input type="text" name="listUpdate[{{ $item->id }}][description]"
                                                value="{{ $item->description }}"
                                                class="form-control dis-{{ $item->id }}" />
                                        </td>

                                        <td>
                                            <button class="btn btn-danger" onclick="DeleteRow('{{ $item->id }}')"
                                                type="button"> -
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>


                    <div class="form-group mb-3 text-right">
                        <button type="reset" class="btn btn-warning"> Reset </button>
                        <button class="btn btn-success" type="submit" onclick="onSubmit(event)"> Submit </button>
                    </div>
            </form>
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

        th,
        tr,
        td {
            text-align: center !important;
            font-size: 10px;
            vertical-align: middle !important
        }

        input[type=number]::-webkit-inner-spin-button {
            display: none;
        }

        .td-style {
            width: 90px
        }

        .chosen-container-single {
            width: 100% !important;
            min-width: 200px !important;
        }

    </style>
@endpush
@push('scripts')
    <script>
        let Rows = {!! json_encode($invoicesList->toArray()) !!};
        const addRow = () => {
            let id = IDGenertaor();
            Rows.push({
                id
            });
            let item = `
                <tr class="Item-${id}">
                    <td class="px-0">
                        <select name="account_id" onchange="handelAccount(event,'${id}')" class="form-control chosen-select">
                            <option value="null"> --- </option>
                            @foreach ($accounts as $account)
                                <option value={{ $account->account_id }}> {{ $account->name }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-0">
                        <input type="number" name="debtor"  step="0.1" onkeyup="handeldebtor(event,'${id}')"  value="0" class="form-control debtor-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="number" name="creditor" step="0.1" onkeyup="handelcreditor(event,'${id}')" value="0" class="form-control creditor-${id}" />
                    </td>
                    <td class="px-0">
                        <input type="text" name="desc" onkeyup="handeldesc(event,'${id}')"  class="form-control dis-${id}" />
                    </td>

                    <td>
                        <button class="btn btn-danger"onclick="DeleteRow('${id}')" type="button"> - </button>
                    </td>
                </tr>
                `;
            $('#bodys').append(item);
        }

        const handelAccount = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.account_id = event.target.value;
        }
        const handelItem = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.itemId = event.target.value;
        }
        const handeldebtor = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.debtor = event.target.value;
            Calc(id, event.target.value);
        }
        const handelcreditor = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.creditor = event.target.value;
            Calc(id, event.target.value);
        }
        const handeldesc = (event, id) => {
            let item = Rows.find(el => el.id == id);
            item.description = event.target.value;
        }
        const handelTotal = (event, id) => {
            let item = Rows.find(el => el.id == id);
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
        let Calc = (id) => {
            getTotal()
        }

        function getTotal() {
            let totalMd = 0;
            let totalDa = 0;
            Rows.forEach(item => {
                totalMd += +item.debtor || 0
                totalDa += +item.creditor || 0
            });
            $('.md').text(Number(totalMd).toFixed(2));
            $('.da').text(Number(totalDa).toFixed(2));
            $('.def').text(Number(totalMd - totalDa).toFixed(2));
        }
        let CalcRate = (id) => {
            let added = $(`.added-${id}`).val();
            let total = $(`.total-${id}`).val();

            let value = (total * added) / 100;
            $(`.rate-${id}`).val(value);

            let rateVal = $(`.rate-${id}`).val();

            let nettotal = +total + +rateVal;
            $(`.nettotal-${id}`).val(nettotal);
        }
        console.log(Rows);

        let DeleteRow = id => {
            swal("هل انت متاكد من حذف هذا السطر").then(res => {
                if (res) {
                    fetch('/erp/public/opening_balance_accounts/deleteRow/' + id).then(response => response
                            .json())
                        .then(data => {
                            if (data.status == 200) {
                                Rows = Rows.filter(el => el.id != id);
                                $(`.Item-${id}`).remove();
                                getTotal()
                            }
                        });
                }
            })

        }
    </script>


@endpush
