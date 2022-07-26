@extends('dashboard.master')

@section('main-content')
    <style>
        .chosen-single {
            height: 37px !important;
        }

    </style>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة صنف </li>
            <li class="breadcrumb-item"><a href="/erp/public/items"> الاصناف </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>


    <div class="card">
        <h5 class="card-header">Add Item</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" id="AdddingForm" action="{{ route('item.store') }}" autocomplete="off"
                enctype="multipart/form-data">

                {{ csrf_field() }}

                <input type="hidden" name="list[]" id="hidenValue">


                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">الاسم بالعربي</label>
                        <input type="text" name="namear" value="{{ old('namear') }}" class="form-control">
                        @error('namear')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">الاسم بالانجليزي</label>
                        <input type="text" name="nameen" value="{{ old('nameen') }}" class="form-control">
                        @error('nameen')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>



                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">المجموعة</label>
                        <select name="group[]" class="form-control chosen-select" tabindex="4" dir="rtl">
                            <option value={{ null }}> --- </option>
                            @foreach ($groups as $item)
                                <option value={{ $item->id }}> {{ $item->namear }} </option>
                            @endforeach
                        </select>
                        @error('group')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">قياس الكمية</label>
                        <input type="text" name="quantityM" value="{{ old('quantityM') }}" class="form-control">
                        @error('quantityM')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">

                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">نسبة الضريبة</label>
                        <input type="number" name="taxRate" value="{{ old('taxRate') }}" class="form-control">
                        @error('taxRate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-check form-check-inline text-right w-50 align-self-center">
                        <input class="form-check-input" type="checkbox" name="priceWithTax" id="priceWithTax" value="1">
                        <label class="form-check-label mr-2" for="priceWithTax"> السعر شامل الضريبة</label>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">بيان</label>
                        <textarea name="description" value="{{ old('description') }}" class="form-control"></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="form-group w-50 text-right">
                        <label class="col-form-label">صورة</label>
                        <input type="file" name="img" class="form-control" />
                    </div> --}}
                </div>

                <hr>

                <table class="table text-center" dir="rtl">
                    <thead>
                        <tr>
                            <th scope="col"> الوحدة </th>
                            <th scope="col"> اصغر وحدة </th>
                            <th scope="col"> التعبئة </th>
                            <th scope="col"> باركود </th>
                            <th scope="col"> السعر </th>
                            <th scope="col"> مقدار الخصم </th>
                            <th scope="col"> نسبة الخصم </th>
                            <th scope="col"> السعر بعد الخصم </th>
                            <th scope="col"> actions </th>
                        </tr>
                    </thead>
                    <tbody id=bodyUnits>
                        <tr id="row1">
                            <th>
                                <select name="unit" id="select-unit-item-0" class="form-control">
                                    <option value="null"> --- </option>
                                    @foreach ($units as $unit)
                                        <option value={{ $unit->id }}> {{ $unit->namear }} </option>
                                    @endforeach
                                </select>
                            </th>
                            <td>
                                <select name="small_unit" id="select-small-unit-item-0" class="form-control">
                                    <option value="null"> --- </option>
                                    @foreach ($units as $unit)
                                        <option value={{ $unit->id }}> {{ $unit->namear }} </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="packing" class="form-control packing-0">
                            </td>
                            <td>
                                <input type="text" name="barcode" class="form-control barcode-0">
                            </td>
                            <td>
                                <button type="button" onclick="autoFoucs(0)" class="btn btn-primary btn-price-0"
                                    data-toggle="modal" data-target="#modalPrice1"> السعر </button>
                            </td>

                            <td>
                                <input type="number" disabled name="discountAmount" class="form-control discountAmount-0">
                            </td>
                            <td>
                                <input type="number" name="discountPercentage" class="form-control discountPercentage-0">
                            </td>
                            <td>
                                <input type="number" name="priceAfterDiscount" class="form-control priceAfterDiscount-0">
                            </td>
                            <td class="d-flex">
                                <button type="button" class="btn btn-primary" onclick="addItemUnit(0)"> + </button>
                                <button type="button" class="btn btn-danger" onclick="DeleteRow(1)"> x </button>
                            </td>


                            <!-- Modal -->
                            <div class="modal fade" id="modalPrice1" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">اسعار الصنف</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group text-right">
                                                <label class="col-form-label"> السعر 1</label>
                                                <input type="number" min="0" step="0.1" name="price1"
                                                    value="{{ old('price1') }}" class="form-control price1-0">
                                                @error('price1')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text-right">
                                                <label class="col-form-label"> السعر 2</label>
                                                <input type="number" min="0" step="0.1" name="price2"
                                                    value="{{ old('price2') }}" class="form-control price2-0">
                                                @error('price2')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text-right">
                                                <label class="col-form-label"> السعر 3</label>
                                                <input type="number" min="0" step="0.1" name="price3"
                                                    value="{{ old('price3') }}" class="form-control price3-0">
                                                @error('price3')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text-right">
                                                <label class="col-form-label"> السعر 4</label>
                                                <input type="number" min="0" step="0.1" name="price4"
                                                    value="{{ old('price4') }}" class="form-control price4-0">
                                                @error('price4')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text-right">
                                                <label class="col-form-label"> السعر 5</label>
                                                <input type="number" min="0" step="0.1" name="price5"
                                                    value="{{ old('price5') }}" class="form-control price5-0">
                                                @error('price5')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </tr>
                    </tbody>
                </table>

                <div class="form-group mb-3 text-right">
                    <button type="reset" class="btn btn-warning"> Reset </button>
                    <button class="btn btn-success" type="button" onclick="Sunbimyffing(event)"> Submit </button>
                    {{-- <button class="btn btn-success" type="submit" onclick="submitList(event)"> Submit </button> --}}
                </div>
            </form>
        </div>
    </div>


@endsection

@push('scripts')
    <script src="{{ asset('js/autoFoucsItem.js') }}"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                }
            });
        });
        let listUnits = [];
        let num = 1;


        function Sunbimyffing(event) {
            event.preventDefault();
            if ($(`#select-unit-item-0`).val() == "null") {
                swal('لا يمكن اضافة الصنف بدون وحدة');
            } else {
                $('form#AdddingForm').submit();
            }
        }

        function addItemUnit(idx) {
            let unit = $(`#select-unit-item-${idx}`).val();
            let smallUnit = $(`#select-small-unit-item-${idx}`).val();
            let packing = $(`.packing-${idx}`).val();
            let barcode = $(`.barcode-${idx}`).val();
            let price1 = $(`.price1-${idx}`).val();
            let price2 = $(`.price2-${idx}`).val();
            let price3 = $(`.price3-${idx}`).val();
            let price4 = $(`.price4-${idx}`).val();
            let price5 = $(`.price5-${idx}`).val();
            let discountAmount = $(`.discountAmount-${idx}`).val();
            let discountPercentage = $(`.discountPercentage-${idx}`).val();
            let priceAfterDiscount = $(`.priceAfterDiscount-${idx}`).val();
            let obj = {
                unit,
                smallUnit,
                packing,
                barcode,
                price1,
                price2,
                price3,
                price4,
                price5,
                discountAmount,
                discountPercentage,
                priceAfterDiscount
            };

            listUnits.push(obj);
            $('#hidenValue').val(JSON.stringify(listUnits))
            num += 1;
            let modalHtml = `
                <div class="modal fade" id="modalPrice${num}" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" > اسعار الصنف</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group text-right">
                                    <label class="col-form-label"> السعر 1</label>
                                    <input type="number" min="0" autofocus step="0.1" name="price1" class="form-control price1-${num}">
                                </div>
                                <div class="form-group text-right">
                                    <label class="col-form-label"> السعر 2</label>
                                    <input type="number" min="0" step="0.1" name="price2" class="form-control price2-${num}">
                                </div>
                                <div class="form-group text-right">
                                    <label class="col-form-label"> السعر 3</label>
                                    <input type="number" min="0" step="0.1" name="price3" class="form-control price3-${num}">
                                </div>
                                <div class="form-group text-right">
                                    <label class="col-form-label"> السعر 4</label>
                                    <input type="number" min="0" step="0.1" name="price4" class="form-control price4-${num}">
                                </div>
                                <div class="form-group text-right">
                                    <label class="col-form-label"> السعر 5</label>
                                    <input type="number" min="0" step="0.1" name="price5" class="form-control price5-${num}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            `
            $('#bodyUnits').append(modalHtml);
            let row = `
            <tr  id="row${num}">
                <td>
                    <select name="unit" id="select-unit-item-${num}" class="form-control">
                        <option value="null"> --- </option>
                        @foreach ($units as $unit)
                            <option value={{ $unit->id }}> {{ $unit->namear }} </option>
                        @endforeach
                    </select>
                </td>
                 <td>
                    <select name="small_unit" id="select-small-unit-item-${num}" class="form-control">
                        <option value="null"> --- </option>
                        @foreach ($units as $unit)
                            <option value={{ $unit->id }}> {{ $unit->namear }} </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="packing" class="form-control packing-${num}">
                </td>
                <td>
                    <input type="text" name="barcode" class="form-control barcode-${num}">
                </td>
                <td>
                    <button type="button" class="btn btn-primary btn-price-${num}" onclick="autoFoucs(${num})" data-toggle="modal" data-target="#modalPrice${num}"> السعر </button>
                </td>
                <td>
                    <input type="number" disabled name="discountAmount" class="form-control discountAmount-${num}">
                </td>
                <td>
                    <input type="number" name="discountPercentage" class="form-control discountPercentage-${num}">
                </td>
                <td>
                    <input type="number" name="priceAfterDiscount" class="form-control priceAfterDiscount-${num}">
                </td>
                <td class="d-flex">
                    <button type="button" class="btn btn-primary" onclick="addItemUnit(${num})" > + </button>
                    <button type="button" class="btn btn-danger" onclick="DeleteRow(${num})"> x </button>
                </td>
            </tr>
            `
            $('#bodyUnits').append(row);
        }

        function submitList(event) {
            event.preventDefault();
            let namear = $('[name=namear]').val();
            let nameen = $('[name=nameen]').val();
            let group = $('[name=group]').val();
            let quantityM = $('[name=quantityM]').val();
            let taxRate = $('[name=taxRate]').val();
            let priceWithTax = $('[name=priceWithTax]').val();
            let description = $('[name=description]').val();
            let img = $('[name=img]');
            // primary
            let unit = $(`#select-unit-item-0`).val();
            let packing = $(`.packing-0`).val();
            let barcode = $(`.barcode-0`).val();
            let price1 = $(`.price1-0`).val();
            let price2 = $(`.price2-0`).val();
            let price3 = $(`.price3-0`).val();
            let price4 = $(`.price4-0`).val();
            let price5 = $(`.price5-0`).val();
            let discountAmount = $(`.discountAmount-0`).val();
            let discountPercentage = $(`.discountPercentage-0`).val();
            let priceAfterDiscount = $(`.priceAfterDiscount-0`).val();
            let obj = {
                unit,
                packing,
                barcode,
                price1,
                price2,
                price3,
                price4,
                price5,
                discountAmount,
                discountPercentage,
                priceAfterDiscount
            };
            listUnits.push(obj);

            $.ajax({
                method: 'post',
                url: "/erp/public/items/store",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: 123
                },
                success: function(data) {
                    console.log(data);
                }
            });
        }

        function DeleteRow(id) {
            let idPre = id - 1;
            // console.log(id);
            // console.log(idPre);
            $(`#row${idPre}`).remove();
            $(`#select-unit-item-${idPre}`).attr("disabled", false);
            $(`#select-unit-item-${idPre}`).attr("disabled", false);
            $(`.packing-${idPre}`).attr("disabled", false);
            $(`.barcode-${idPre}`).attr("disabled", false);
            $(`.price1-${idPre}`).attr("disabled", false);
            $(`.price2-${idPre}`).attr("disabled", false);
            $(`.price3-${idPre}`).attr("disabled", false);
            $(`.price4-${idPre}`).attr("disabled", false);
            $(`.price5-${idPre}`).attr("disabled", false);
            $(`.discountAmount-${idPre}`).attr("disabled", false);
            $(`.discountPercentage-${idPre}`).attr("disabled", false);
            $(`.priceAfterDiscount-${idPre}`).attr("disabled", false);
            $(`.ppr-${idPre}`).attr("disabled", false);
            $(`.btn-price-${idPre}`).attr("disabled", false);
        }

        function SubmitItem() {}
    </script>
@endpush
