@extends('dashboard.master')

@section('main-content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> تعديل سنة مالية </li>
            <li class="breadcrumb-item"><a href="/erp/public/fiscal_years"> السنوات المالية </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>

    <div class="card font-main">
        <h5 class="card-header">Edit Fiscal Year</h5>
        <div class="card-body text-right">
            <form method="post" dir="rtl" action="{{ route('fiscal_years.update', $fiscal->id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> كود السنة </label>
                            <input type="number" step="0.1" name="code" value="{{ $fiscal->code }}" autocomplete="0"
                                class="form-control">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> الحالة </label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $fiscal->status == 1 ? 'selected' : '' }}>نشطة</option>
                                <option value="0" {{ $fiscal->status == 0 ? 'selected' : '' }}>غير نشطة</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> بداية السنة </label>
                            <input type="date" name="start" id="start"
                                value="{{ $fiscal->start }}" class="form-control">
                            @error('start')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> نهاية السنة </label>
                            <input type="date" name="end" id="end"
                                value="{{ $fiscal->end }}" class="form-control">
                            @error('end')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="col-form-label"> ملاحظات</label>
                            <input type="text" name="notes" value="{{ $fiscal->notes }}" class="form-control">
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
