@extends('dashboard.master')

@section('main-content')
    <form method="post" enctype="multipart/form-data" dir="rtl" action="{{ route('compaines.update', $company->id) }}">

        {{ csrf_field() }}
        @method('PATCH')
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto px-3">

                    <ul class="nav nav-tabs mb-4" dir="rtl" id="myTab" role="tablist">
                        <li class="nav-item font-main" role="presentation">
                            <button class="nav-link active font-weight-bold" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">اعدادات عامة</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link font-main font-weight-bold" id="electron_tab" data-bs-toggle="tab"
                                data-bs-target="#electronic" type="button" role="tab" aria-controls="electronic"
                                aria-selected="false">فاتورة الكترونية</button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link font-main font-weight-bold" id="taxs_tab" data-bs-toggle="tab"
                                data-bs-target="#taxs" type="button" role="tab" aria-controls="taxs"
                                aria-selected="false">الضرائب</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @include('compines.globalSetting')
                        </div>
                        <div class="tab-pane fade" id="electronic" role="tabpanel" aria-labelledby="electron_tab">
                            @include('compines.electronic_invoice')
                        </div>
                        <div class="tab-pane fade" id="taxs" role="tabpanel" aria-labelledby="taxs_tab">
                            @include('compines.taxs')
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 text-right px-5">
            <div class="form-group mb-3">
                <button class="btn btn-success font-main px-3" type="submit">Submit</button>
            </div>
        </div>
    </form>
@endsection
@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .nav-tabs>.nav-item>.nav-link.active {
            background: #1cc88a !important;
            color: #fff !important;
            font-weight: 800
        }

    </style>
@endpush
@push('scripts')
    <script src="{{ asset('boot5/bootstrap.min.js') }}"></script>
    <script src="{{ asset('boot5/bootstrap.bundle.js') }}"></script>
@endpush
