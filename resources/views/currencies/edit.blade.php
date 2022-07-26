@extends('dashboard.master')

@section('main-content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تعديل عملة </li>
            <li class="breadcrumb-item"><a href="/erp/public/currencies"> العملات </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    <div class="card font-main">
        <h5 class="card-header">Edit Fiscal Year</h5>
        <div class="card-body text-right">
            <form method="post" dir="rtl" action="{{ route('currencies.update', $currancy->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')


                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الاسم عربي </label>
                            <input type="text" name="namear" value="{{ $currancy->namear }}" class="form-control">
                            @error('namear')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الاسم انجليزي </label>
                            <input type="text" name="nameen" value="{{ $currancy->nameen }}" class="form-control">
                            @error('nameen')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> العملة الكبري عربي </label>
                            <input type="text" name="bigar" value="{{ $currancy->bigar }}" class="form-control">
                            @error('bigar')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> العملة الكبري انجليزي </label>
                            <input type="text" name="bigen" value="{{ $currancy->bigen }}" class="form-control">
                            @error('bigen')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> العملة الصغري عربي </label>
                            <input type="text" name="smallar" value="{{ $currancy->smallar }}" class="form-control">
                            @error('smallar')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> العملة الصغري انجليزي </label>
                            <input type="text" name="smallen" value="{{ $currancy->smallen }}" class="form-control">
                            @error('smallen')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> سعر الصرف </label>
                            <input type="number" step="0.1" {{ $currancy->main == 1 ? 'disabled' : '' }}
                                value="{{ $currancy->rate }}" name="rate" id="rate" class="form-control">
                            @error('rate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> كود الربط مع الضرائب </label>
                            <input type="text" name="tax_code" value="{{ $currancy->tax_code }}" class="form-control">
                            @error('tax_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> افتراضي </label>
                            <select name="main" class="form-control" onchange="handelCurrency(event)">
                                <option value="1" {{ $currancy->main == 1 ? 'selected' : '' }}>نعم</option>
                                <option value="0" {{ $currancy->main == 0 ? 'selected' : '' }}>لا</option>
                            </select>
                        </div>
                        @error('main')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

        function handelCurrency(event) {
            let val = event.target.value;
            if (val == 1) {
                $('#rate').attr('disabled', true);
                $('#rate').val(1);
            }
            if (val == 0) {
                $('#rate').attr('disabled', false);
            }
        }
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
