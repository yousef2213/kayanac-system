@extends('dashboard.master')

@section('main-content')

    <div class="container-fluid font-main">
        <div class="row">
            <div class="col-12 px-5 mx-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end font-main">
                        <li class="breadcrumb-item active" aria-current="page"> اضافة فرع </li>
                        <li class="breadcrumb-item"><a href="/erp/public/branches"> الفروع </a></li>
                        <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
                    </ol>
                </nav>
            </div>

            <div class="col-12 px-5 py-4">

                <div class="company text-right font-ar">
                    <div class="col-12 mx-auto px-0">
                        <form dir="rtl" method="POST" autocomplete="off" action="{{ route('branches.store') }}">
                            {{ csrf_field() }}

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>الاسم بالعربي</label>
                                    <input type="text" autocomplete="off" name="namear" value="{{ old('namear') }}"
                                        class="form-control" />
                                    @error('namear')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> الاسم بالانجليزي </label>
                                    <input type="text" autocomplete="off" name="nameen" value="{{ old('nameen') }}"
                                        class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label">الشركة</label>
                                        <select autocomplete="off" name="companyId" disabled class="form-control">
                                            @foreach ($companys as $company)
                                                <option value="{{ $company->id }}">
                                                    {{ $company->companyNameAr }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label>المدينة</label>
                                    <input type="text" autocomplete="off" name="city" value="{{ old('city') }}"
                                        class="form-control" />
                                </div>

                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> كود النشاط </label>
                                    <input type="number" step="0.1" name="code_activite" value="{{ old('code_activite') }}"
                                        class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> Activity Code </label>
                                    <input type="number" step="0.1" name="activite_code" value="{{ old('activite_code') }}"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> المنطقة </label>
                                    <input autocomplete="off" type="text" name="region" value="{{ old('region') }}"
                                        class="form-control" />
                                </div>
                                <div class="col-12 col-md-6 mx-auto">
                                    <label> الدولة </label>
                                    <input autocomplete="off" type="text" name="country" value="{{ old('country') }}"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="row py-2">
                                <div class="col-12 col-md-6">
                                    <label> هاتف </label>
                                    <input autocomplete="off" type="number" value="{{ old('phone') }}" name="phone"
                                        class="form-control" />
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label> العنوان </label>
                                    <input autocomplete="off" type="text" value="{{ old('address') }}" name="address"
                                        class="form-control" />
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="submiting d-flex mt-4">
                                <button type="submit" class="btn btn-primary mx-2 px-4"> حفظ </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
    <script src="{{ asset('boot5/bootstrap.bundle.js')}}"></script>
@endpush
