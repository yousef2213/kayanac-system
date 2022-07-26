@extends('dashboard.master')

@section('main-content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة حساب </li>
            <li class="breadcrumb-item"><a href="/erp/public/accounts"> الحسابات </a></li>
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
    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right">{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif
    @if (\Session::has('msg'))
        <div class="alert alert-success">
            <ul style="list-style: none;text-align: right">
                <li class="font-main text-right">{!! \Session::get('msg') !!}</li>
            </ul>
        </div>
    @endif

    <div class="company text-right font-ar">
        <div class="container-fluid py-4 font-main">
            <div class="row mx-0">
                <div class="col-12 mx-auto px-0">
                    <form dir="rtl" method="POST" autocomplete="off" action="{{ route('accounts.update', $account->id) }}">
                        {{ csrf_field() }}

                        <div class="row py-2">
                            <div class="col-12 col-md-6 mx-auto">
                                <label> اسم الحساب بالعربي </label>
                                <input type="text" autocomplete="off" name="namear" value="{{ $account->namear }}"
                                    class="form-control" />
                                @error('namear')
                                    <span class="text-danger"> البيانات مطلوبة </span>

                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mx-auto">
                                <label> الاسم الحساب بالانجليزي </label>
                                <input type="text" autocomplete="off" name="nameen" value="{{ $account->nameen }}"
                                    class="form-control" />
                                @error('nameen')
                                    <span class="text-danger"> البيانات مطلوبة </span>

                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="balance_sheet" class="col-form-label">مجموعة الميزانية العمومية </label>
                                    <select autocomplete="off" name="balance_sheet" class="form-control">
                                        <option value="0"> --- </option>
                                        <option value="1" {{ $account->balance_sheet == 1 ? 'selected' : '' }}> قايمة دخل
                                        </option>
                                        <option value="2" {{ $account->balance_sheet == 2 ? 'selected' : '' }}> ميزانية
                                        </option>
                                    </select>
                                </div>
                                @error('balance_sheet')
                                    <span class="text-danger"> البيانات مطلوبة </span>
                                @enderror
                            </div>
                        </div>


                        <div class="submiting d-flex mt-4">
                            <button type="submit" class="btn btn-primary mx-2 px-4 font-main px-4"> حفظ </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

    </style>
@endpush
