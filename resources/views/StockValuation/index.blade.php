@extends('dashboard.master')

@section('main-content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container-fluid px-5">
        <div class="row">
            <nav aria-label="breadcrumb" class="">
                <ol class="breadcrumb justify-content-end font-main p-2">
                    <li class="breadcrumb-item active" aria-current="page"> تقييم المخزون </li>
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
                                <label for=""> مجموعة الاصناف </label>
                                <select name="groupId" class="form-control chosen-select" multiple {{-- <select name="groupId" class="form-control chosen-select" onchange="getItemsByCatId(event)" --}}
                                    id="groupId">
                                    <option value="yousef" selected>كل المجموعات</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->namear }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>




                    </div>

                    <div class="d-flex align-items-center text-right my-4">
                        <button class="btn btn-primary px-5" onclick="SubmitForm(event, '{{ csrf_token() }}')"> عرض
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="font-main d-flex justify-content-end align-items-center">
            <h5 class="font-weight-bold total mb-0 pb-0 mx-3"> 00 </h5>
            <h5 class="font-weight-bold mb-0 pb-0"> : الاجمالي </h5>
        </div>



        <div class="row">
            <div class="col-12">

                <div class="card-body">
                    <div class="table-responsive tableS">
                        {{-- Tables --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
    <script src=" {{ asset('js/select2.min.js') }} "></script>

    <script>
        $(document).ready(function() {
            $("#itemId").select2();
        });

        function getItemsByCatId(e) {
            let ele = document.querySelector("#itemId");

            $.ajax({
                type: "GET",
                url: `/erp/public/getItemsByCatId/${e.target.value}`,
                success: function(res) {
                    let data = [...res];
                    $('#itemId').html('');
                    if (data.length != 0) {
                        data.forEach(item => {
                            console.log(item);
                            var asas = `<option value="${item.id}"  data-name=${item.namear}>
                             ${item.namear} - ${item.namear} </option>`;
                            $('#itemId').append(asas);
                        });

                    } else {
                        swal("لا يوجد اصناف في المجموعة");
                    }

                }
            });
        }

        const SubmitForm = (event, csrf) => {
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
            let ele = document.querySelector(".items_movement");
            $.ajax({
                type: "POST",
                url: "/erp/public/getDataStock/filter",
                data,
                success: function(res) {
                    let total = 0;
                    $('.tableS').html("");
                    let data = [...res];
                    let filterCategory = data.map(el => el.catId);
                    let namesCat = data.map(el => el.cat_name);
                    let arr = [];
                    filterCategory.forEach(num => {
                        let dataResource = data.filter(item => item.catId == num)
                        arr.push({
                            name: data.find(el => el.catId == num) ? data.find(el => el.catId == num).cat_name : "Default...",
                            data: dataResource
                        });
                    });

                    arr.forEach(element => {
                        let itemRow = `
                            <h5 class="text-right font-main mt-3"> ${element.name} -</h5>
                           <table class="table table-striped my-3" dir="rtl" width="100%"
                            cellspacing="0">
                            <thead>
                                <tr class="text-center font-main">
                                    <th> م </th>
                                    <th> اسم الصنف </th>
                                    <th> الوحدة </th>
                                    <th> الكمية </th>
                                    <th> التكلفة </th>
                                    <th> الاجمالي </th>
                                </tr>
                            </thead>
                            <tbody>
                                ${element.data.map((el, i) => {
                                    total += (el.qtn * el.av_price) || 0;
                                    return `<tr class="text-center font-main">
                                        <td> ${ i + 1 } </td>
                                        <td> ${el.item_name} </td>
                                        <td> ${el.unit_name} </td>
                                        <td> ${el.qtn} </td>
                                        <td> ${el.av_price || 0 }  </td>
                                        <td> ${ +(el.qtn * el.av_price).toFixed(4) || 0 } </td>
                                    </tr>`
                                })}
                            </tbody>
                        </table>
                           `
                        $('.tableS').append(itemRow);
                        $('.total').html(+total.toFixed(3))
                    });
                }
            });
        };
    </script>
@endpush
