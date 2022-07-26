@extends('dashboard.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Add Company</h5>
        <div class="card-body font-main">
            <form method="post" enctype="multipart/form-data" action="{{ route('compaines.store') }}">

                {{ csrf_field() }}

                <div class="form-group">
                    <label class="col-form-label">اسم الشركة بالعربي</label>
                    <input type="text" name="namear" value="{{ old('namear') }}" class="form-control">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label">اسم الشركة بالانجليزي</label>
                    <input type="text" name="nameen" value="{{ old('nameen') }}" class="form-control">
                    @error('nameen')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="col-form-label"> الرقم الضريبي </label>
                    <input type="text" name="taxNum" class="form-control" value="{{ old('taxNum') }}">
                    @error('taxNum')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="col-form-label">النشاط</label>
                    <textarea name="active" value="{{ old('active') }}" class="form-control"></textarea>
                    @error('active')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label"> لوجو الشركة </label>
                    <input type="file" name="logo" value="{{ old('logo') }}" class="form-control">
                    @error('logo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
