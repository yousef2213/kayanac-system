@extends('dashboard.master')


@section('main-content')
    <form method="post" class="font-main text-right" autocomplete="0" action="{{ route('users.store') }}">
        {{ csrf_field() }}
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto px-3">
                    <ul class="nav nav-tabs mb-4" dir="rtl" id="myTab" role="tablist">
                        <li class="nav-item font-main" role="presentation">
                            <button class="nav-link active font-weight-bold" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">بيانات المستخدم</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link font-main font-weight-bold" id="electron_tab" data-bs-toggle="tab"
                                data-bs-target="#electronic" type="button" role="tab" aria-controls="electronic"
                                aria-selected="false">صلاحيات المستخدم</button>
                        </li> --}}

                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link font-main font-weight-bold" id="otherPermision" data-bs-toggle="tab"
                                data-bs-target="#other_perimion" type="button" role="tab" aria-controls="other_perimion"
                                aria-selected="false">صلاحيات اخري</button>
                        </li> --}}


                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @include('users.info_user')
                        </div>

                        {{-- <div class="tab-pane fade" id="electronic" role="tabpanel" aria-labelledby="electron_tab">
                            @include('users.power')
                        </div> --}}


                        <div class="tab-pane fade" id="other_perimion" role="tabpanel" aria-labelledby="otherPermision">
                            <h2>Helo</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-right px-5">
            <div class="form-group mb-3">
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </div>



    </form>
@endsection



@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pos.css') }}" rel="stylesheet" type="text/css">
    <style>
        .accordion-button::after {
            margin: 0 !important
        }

        .accordion-button {
            display: flex !important;
            justify-content: space-between !important;
            flex-direction: row-reverse !important;
            align-items: center
        }

        .accordion-button>p {
            margin: 0;
            padding-bottom: 2px;
        }

        .nav-tabs>.nav-item>.nav-link.active {
            background: #1cc88a !important;
            color: #fff !important;
            font-weight: 800
        }

    </style>
@endpush

@push('scripts')
    <script src="{{ asset('boot5/bootstrap.min.js') }}"></script>
    <script>
        const handelValue = event => {
            if (event.target.checked) {
                event.target.value = 1;
            } else {
                event.target.value = 0;
            }
        }
    </script>
@endpush
