@extends('dashboard.master')

@section('main-content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container-fluid px-5">
        <div class="row">
            <nav aria-label="breadcrumb" class="">
                <ol class="breadcrumb justify-content-end font-main p-2">
                    <li class="breadcrumb-item active" aria-current="page">أرصدة الاصناف </li>
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
                                <label for=""> الفروع </label>
                                <select name="brancheId" class="form-control chosen-select" id="brancheId">
                                    @foreach ($branches as $branche)
                                        <option value="{{ $branche->id }}">
                                            {{ $branche->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for=""> المخزن </label>
                                <select name="storeId" class="form-control chosen-select" id="storeId">
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">
                                            {{ $store->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for="">الي تاريخ </label>
                                <input type="datetime-local" class="form-control" name="to" id="date-from">
                            </div>
                        </div>

                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for=""> المجموعة </label>
                                <select name="groupId" class="form-control chosen-select" id="groupId">
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for=""> الاصناف </label>
                                <select name="items" class="form-control chosen-select" dir="rtl" multiple id="itemId">
                                    <option value="0" data-unit="0"> -- </option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}" data-unit="{{ $item->unit_id }}">
                                            {{ $item->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mx-auto">
                            <div class="form-group my-3">
                                <label for=""> المزيد </label>
                                <select name="more" class="form-control chosen-select" id="select-items">
                                    <option value=""> الاصناف الموجبة فقط </option>
                                    <option value=""> الاصناف السالبة فقط </option>
                                    <option value=""> كل الاصناف </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group my-3">
                                <label for=""> الوحدة </label>
                                <select name="unit" class="form-control chosen-select" id="select-items">
                                    <option value="0"> اصغر وحدة </option>
                                    <option value="0"> الوحدة الكبري </option>
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
                        <table class="table table-striped" id="items_movement-dataTable" dir="rtl" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr class="text-center font-main">
                                    <th> م </th>
                                    <th> الصنف </th>
                                    <th> الوحدة </th>
                                    <th> المخزن </th>
                                    <th> الرصيد </th>
                                </tr>
                            </thead>
                            <tbody class="items_movement"></tbody>
                        </table>

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

        .chosen-choices {
            display: flex;
            border-radius: 4px !important;
            padding: 4px !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const Show = (event, csrf) => {
            event.preventDefault();
            let branchId = $('#brancheId').val();
            let itemId = $("#itemId").val();
            let unitId = $("#unitId").val();
            let from = $("#date-from").val();
            let groupId = $('#groupId').val();
            let storeId = $('#storeId').val();

            let data = {
                _token: csrf,
                itemId,
                groupId,
                branchId,
                storeId,
                unitId,
                from
            };
            console.log(itemId);
            let ele = document.querySelector(".items_movement");
            $.ajax({
                type: "POST",
                url: "/erp/public/items-balances/filter",
                data,
                success: function(res) {
                    console.log(res);
                    // ele.innerHTML = "<span></span>";
                    // let data = [...res.list, ...res.list2, ...res.listCollection, ...res.listCollection2];
                    let data = [...res];
                    // console.log(data);
                    if (data.length != 0) {
                        let row = data.map((item, i) => {
                            let count = 0;
                            if (item.source == "مشتريات") {
                                count = count + item.qtn;
                            }
                            if (item.source == "مبيعات") {
                                count = count - item.qtn;
                            }
                            if (item.source == "مرتجع مبيعات") {
                                count = count + item.qtn;
                            }
                            if (item.source == "مرتجع مشتريات") {
                                count = count - item.qtn;
                            }
                            return `<tr class="text-center font-main">
                                <td> ${ i + 1 } </td>
                                    <td> ${item.item_name} </td>
                                    <td> ${item.unit_name} </td>
                                    <td> ${item.store_name} </td>
                                    <td> ${ item.qtn } </td>


                            </tr>`;
                        });
                        ele.innerHTML = row.join("");
                    } else {
                        swal("لا يوجد بيانات");
                    }
                }
            });
        };
    </script>
@endpush
