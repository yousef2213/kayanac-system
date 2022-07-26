@extends('dashboard.master')

@section('main-content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> تعديل طاولة </li>
                <li class="breadcrumb-item"><a href="/erp/public/tables"> الطاولات </a></li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </nav>


        <div class="card">
            <h5 class="card-header">Edit Table</h5>
            <div class="card-body">
                <form method="post" action="{{ route('tables.update', $table->id) }}" dir="rtl">
                    @method('PATCH')
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value={{ $table->id }}>
                    <div class="form-group text-right font-main">
                        <label class="col-form-label text-right ">رقم الطاولة</label>
                        <input type="number" name="numTable" class="text-right form-control"
                            value="{{ $table->numTable }}" class="form-control">
                        @error('numTable')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group mb-3 text-right">
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button class="btn btn-success" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
