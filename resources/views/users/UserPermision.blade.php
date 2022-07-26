@extends('dashboard.master')




@section('main-content')
    <form method="post" dir="rtl" action="{{ route('users.updates.side', $user->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto px-3">
                    <ul class="nav nav-tabs mb-4" dir="rtl" id="myTab" role="tablist">
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link font-main active font-weight-bold" id="electron_tab"
                                data-bs-toggle="tab" data-bs-target="#electronic" type="button" role="tab"
                                aria-controls="electronic" aria-selected="false">صلاحيات المستخدم</button>
                        </li> --}}
                        <li class="nav-item font-main" role="presentation">
                            <button class="nav-link font-weight-bold active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">صلاحيات </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">

                        {{-- <div class="tab-pane fade show active" id="electronic" role="tabpanel"
                            aria-labelledby="electron_tab">
                            @include('users.power_edit')
                        </div> --}}
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            @include('users.sidePermision')
                            {{-- <input type="checkbox" name="ssssssssssss"
                                    id="ssssssssssssssIt" onchange="handelValue(event)" value="0" /> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 text-right px-5">
            <div class="form-group mb-3 text-right mt-4">
                <button class="btn btn-success" type="submit">Update</button>
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
            /* flex-direction: row-reverse !important; */
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
                event.target.checked = true;
            } else {
                event.target.value = 0;
            }
            console.log(event.target);
        }
    </script>
@endpush
