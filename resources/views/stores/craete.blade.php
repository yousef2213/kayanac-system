@extends('dashboard.master')

@section('main-content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb justify-content-end font-main">
        <li class="breadcrumb-item active" aria-current="page"> تعديل مخزن </li>
        <li class="breadcrumb-item"><a href="/erp/public/stores"> المخازن </a></li>
        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
    </ol>
</nav>



    <div class="card">
        <h5 class="card-header">Add Store</h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="{{ route('stores.store') }}" autocomplete="off"
                enctype="multipart/form-data">

                {{ csrf_field() }}


                {{-- <div class="form-group text-right">
                    <label class="col-form-label">الاسم </label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="row py-2 text-right">
                    <div class="col-12 col-md-6 mx-auto">
                        <label>الاسم بالعربي</label>
                        <input type="text" autocomplete="off" name="namear" class="form-control"  />
                    </div>
                    <div class="col-12 col-md-6 mx-auto">
                        <label>الاسم بالانجليزي</label>
                        <input type="text" autocomplete="off"  name="nameen" class="form-control"  />
                    </div>
                </div>



                <div class="form-group text-right">
                    <label class="col-form-label">الفرع</label>
                    <select name="branchId[]" class="form-control chosen-select" multiple tabindex="4" dir="rtl">
                        <option value={{ null }}> --- </option>
                        @foreach ($branches as $branche)
                            <option value={{ $branche->id }}> {{ $branche->namear }} </option>
                        @endforeach
                    </select>
                    @error('branchId')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="text-right my-3">
                    <div class="form-check form-check-inline align-self-center">
                        <input class="form-check-input" type="checkbox" checked name="active" id="activateion">
                        <label class="form-check-label mr-2" for="activateion">  تفعيل </label>
                    </div>
                </div>



                <div class="form-group mb-3 text-right">
                    <button type="reset" class="btn btn-warning"> Reset </button>
                    <button class="btn btn-success" type="submit"> Submit </button>
                </div>
            </form>
        </div>
    </div>


@endsection
