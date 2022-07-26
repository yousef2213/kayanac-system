@extends('dashboard.master')

@section('main-content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تعديل موظف </li>
            <li class="breadcrumb-item"><a href="/erp/public/employees"> الموظفين </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    <div class="card font-main">
        <h5 class="card-header">Edit Employees</h5>
        <div class="card-body text-right">
            <form method="post" dir="rtl" action="{{ route('employees.update', $employee->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')


                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الاسم بالعربي </label>
                            <input type="text" name="namear" value="{{ $employee->namear }}" class="form-control">
                            @error('namear')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الاسم بالانجليزي </label>
                            <input type="text" name="nameen" value="{{ $employee->nameen }}" class="form-control">
                            @error('nameen')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الوظيفة </label>
                            <select name="occupation" class="form-control barnchesSelect">
                                <option value="0" {{ $employee->occupation == 0 ? 'selected' : '' }}> --
                                </option>
                                <option value="مندوب محاسب"
                                    {{ $employee->occupation == 'مندوب محاسب' ? 'selected' : '' }}> مندوب محاسب </option>
                            </select>
                        </div>
                        @error('occupation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الفروع </label>
                            <select name="branchId" class="form-control barnchesSelect">
                                @foreach ($branches as $branche)
                                    <option value="{{ $branche->id }}"
                                        {{ $employee->branchId == $branche->id ? 'selected' : '' }}>
                                        {{ $branche->namear }} </option>
                                @endforeach
                            </select>
                        </div>
                        @error('branchId')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-12 col-md-6">

                        <div class="form-group">
                            <label for="status" class="col-form-label"> الحالة </label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $employee->status == 1 ? 'selected' : '' }}>نشط</option>
                                <option value="2" {{ $employee->status == 2 ? 'selected' : '' }}>موقوف</option>
                                <option value="3" {{ $employee->status == 3 ? 'selected' : '' }}>استقالة</option>
                                <option value="4" {{ $employee->status == 4 ? 'selected' : '' }}> اجازة سنوية </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3 text-right mt-4">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#lfm').filemanager('image');
    </script>
    <script>
        $(document).ready(function() {
            $('.barnchesSelect').select2({
                placeholder: "البحث عن طريق اسم / الكود",
                allowClear: true,
                width: 'resolve',
            });
        });

        $(document).ready(function() {
            $("#basic-addon1").on('click', function(event) {
                event.preventDefault();
                if ($('#inputPassword').attr("type") == "text") {
                    $('#inputPassword').attr('type', 'password');
                    $('#eyeId').addClass("fa-eye-slash");
                    $('#eyeId').removeClass("fa-eye");
                } else if ($('#inputPassword').attr("type") == "password") {
                    $('#inputPassword').attr('type', 'text');
                    $('#eyeId').removeClass("fa-eye-slash");
                    $('#eyeId').addClass("fa-eye");
                }
            });
        });

        $(document).ready(function() {
            $("#basic-addon2").on('click', function(event) {
                event.preventDefault();
                if ($('#inputPasswordConfirm').attr("type") == "text") {
                    $('#inputPasswordConfirm').attr('type', 'password');
                    $('#eyeId2').addClass("fa-eye-slash");
                    $('#eyeId2').removeClass("fa-eye");
                } else if ($('#inputPasswordConfirm').attr("type") == "password") {
                    $('#inputPasswordConfirm').attr('type', 'text');
                    $('#eyeId2').removeClass("fa-eye-slash");
                    $('#eyeId2').addClass("fa-eye");
                }
            });
        });
    </script>
@endpush
