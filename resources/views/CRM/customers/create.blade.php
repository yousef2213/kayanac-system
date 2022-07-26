@extends('dashboard.master')

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> اضافة عميل </li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 px-5">
                <div class="company text-right font-ar">
                    <div class="col-12 mx-auto px-0  font-main">
                        <form dir="rtl" method="POST" action="{{ route('crm-customers.store') }}">
                            {{ csrf_field() }}

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الكود</label>
                                    <input type="number" disabled class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <div class="form-group">
                                        <label for="group" class="col-form-label">المجموعة</label>
                                        <select name="group" class="form-control">
                                            <option value="0">---</option>
                                            <option value="1"> المجموعة الرئيسية </option>
                                        </select>
                                        @error('group')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الاسم بالعربي</label>
                                    <input type="text" name="namear" class="form-control" />
                                    @error('namear')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الاسم بالانجليزي</label>
                                    <input type="text" name="nameen" class="form-control" />
                                    @error('nameen')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <div class="form-group">
                                        <label class="col-form-label">المندوب</label>
                                        <select name="employee" class="form-control chosen-select">
                                            @foreach ($employees as $employee)
                                                <option value={{ $employee->id }}> {{ $employee->name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> رقم التسجيل بضريبة القيمة المضافة </label>
                                    <input type="number" name="numRegister" class="form-control" />
                                </div>
                            </div>


                            <div class="row py-2 font-main">

                                <div class="col-12 col-md-6 mx-auto">
                                    <label>تلفون</label>
                                    <input type="number" name="phone" class="form-control" />
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label>رقم الهوية</label>
                                    <input type="number" name="IdentificationNumber" class="form-control" />
                                </div>
                            </div>
                            <div class="row py-2 font-main">
                                <div class="col-12 col-md-6">
                                    <label> العنوان </label>
                                    <input autocomplete="off" type="text" value="{{ old('address') }}" name="address"
                                        class="form-control" />
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>


                            <div class="submiting d-flex mt-4">
                                <button type="submit" class="btn btn-primary mx-2 px-4"> حفظ </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

    </style>
@endpush

@push('scripts')
    <script src="{{ asset('boot5/bootstrap.min.js') }}"></script>
    <script src="{{ asset('boot5/bootstrap.bundle.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="{{ asset('js/choosen.js') }}"></script>



@endpush
