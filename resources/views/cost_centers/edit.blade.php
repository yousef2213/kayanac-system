@extends('dashboard.master')

@section('main-content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-end font-main">
        <li class="breadcrumb-item active" aria-current="page"> تعديل مجموعة </li>
        <li class="breadcrumb-item"><a href="/erp/public/items/categories-of-items"> مجموعة الاصناف </a></li>
        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
    </ol>
</nav>


    <div class="card">
        <h5 class="card-header">Edit Catrgory</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="{{ route('cat.update',$item->id) }}" autocomplete="off">
                {{-- @method('PATCH') --}}

                {{ csrf_field() }}

                <input type="hidden" name="id" value="{{ $item->id }}">

                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">الاسم بالعربي</label>
                        <input type="text" name="namear" class="form-control" value="{{ $item->namear }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group w-50 text-right">
                        <label class="col-form-label">الاسم بالانجليزي</label>
                        <input type="text" name="nameen" class="form-control" value="{{ $item->nameen }}">
                        @error('nameen')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
