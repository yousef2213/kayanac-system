@extends('dashboard.master')

@section('main-content')
    <div class="container py-5">
        <div class="row pb-4">
            <div class="col-12 text-right px-3">
                <h5 class="font-main p-0 m-0"> تقارير المبيعات </h5>
                <div class="line"> </div>
            </div>
        </div>
        <div class="row flex-row-reverse">
            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="{{ route('ItemsSalles.index') }}"
                        class="report font-main d-flex justify-content-center align-items-center">تقارير المبيعات</a>
                </div>
            </div>


            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="{{ route('ItemsSallesSaved.index') }}"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقارير الاصناف
                    </a>
                </div>
            </div>

            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="{{ route('combined-billing-profits') }}"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقارير ارباح الفواتير مجمع
                    </a>
                </div>
            </div>



        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('boot5/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reports/reports-account.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('boot5/bootstrap.min.js') }}"></script>
@endpush
