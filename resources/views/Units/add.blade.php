@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة وحدة </li>
            <li class="breadcrumb-item"><a href="/erp/public/units"> الوحدات </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    <div class="card">
        <h5 class="card-header">Add Unit</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="{{ route('units.store') }}" autocomplete="off"
                enctype="multipart/form-data">

                {{ csrf_field() }}

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

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الكود الضريبى</label>
                            <input type="text" name="tax_code"class="form-control">
                            @error('tax_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group mb-3 text-right">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
