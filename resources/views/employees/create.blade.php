@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة موظف </li>
            <li class="breadcrumb-item"><a href="/erp/public/employees"> الموظفين </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>


    <div class="card">
        <h5 class="card-header">Add Employee</h5>
        <div class="card-body">
            <form method="post" dir="rtl" class="font-main text-right" autocomplete="0"
                action="{{ route('employees.store') }}">

                {{ csrf_field() }}

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الاسم بالعربي </label>
                            <input type="text" name="namear" autocomplete="0" class="form-control">
                            @error('namear')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الاسم بالانجليزي </label>
                            <input type="text" name="nameen" class="form-control">
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
                                <option value="0"> -- </option>
                                <option value="مندوب">مندوب</option>
                                <option value="محاسب"> محاسب </option>
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
                                    <option value="{{ $branche->id }}"> {{ $branche->namear }} </option>
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
                                <option value="1">نشط</option>
                                <option value="2">موقوف</option>
                                <option value="3">استقالة</option>
                                <option value="4"> اجازة سنوية </option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <button class="btn btn-success px-4 my-3" type="submit">حفظ</button>
                </div>
            </form>
        </div>
    </div>

@endsection





@push('styles')
    <link href="{{ asset('css/pos.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush



@push('scripts')


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="{{ asset('js/choosen.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
