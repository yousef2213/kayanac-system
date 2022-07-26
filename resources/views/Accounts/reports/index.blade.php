@extends('dashboard.master')

@section('main-content')
    <div class="container py-5">
        <div class="row pb-4">
            <div class="col-12 text-right px-3">
                <h5 class="font-main p-0 m-0"> تقارير دليل الحسابات </h5>
                <div class="line"> </div>
            </div>
        </div>
        <div class="row flex-row-reverse">
            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="{{ route('account.statement') }}"
                        class="report font-main d-flex justify-content-center align-items-center">تقرير كشف حساب</a>
                </div>
            </div>


            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="{{ route('budget.index') }}"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقرير الميزانية
                    </a>
                </div>
            </div>



            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="{{ route('cost_centers_reports') }}"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقرير مراكز التكلفة
                    </a>
                </div>
            </div>



            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="{{ route('income_list') }}"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقرير قائمة الدخل
                    </a>
                </div>
            </div>

            <div class="col-12 col-md-3 px-3 my-2">
                <div>
                    <a href="{{ route('FinancialCenter.index') }}"
                        class="report font-main d-flex justify-content-center align-items-center">
                        تقرير قائمة المركز المالي
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
