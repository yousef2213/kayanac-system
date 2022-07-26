@extends('dashboard.master')

@section('main-content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main py-2 px-2">
                <li class="breadcrumb-item active" aria-current="page"> الحسابات </li>
                <li class="breadcrumb-item"><a href="/erp/public/home">{{ __('pos.main') }}</a></li>
            </ol>
        </nav>
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul style="list-style: none;text-align: right">
                    <li class="font-main text-right">{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif





        <div class="card shadow mb-4 font-main">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left"> الحسابات</h6>
                <a href="{{ route('accounts.create') }}"
                    class="btn {{ $orders->add == 0 ? 'd-none' : '' }} font-main btn-primary btn-sm float-right"
                    data-toggle="tooltip" data-placement="bottom" title="Add Branches"><i class="fas fa-plus"
                        style="font-size: 10px"></i> اضافة </a>
            </div>
            <div class="card-body">
                <div class="accordion accordion-flush text-right font-main" id="accountsDrop">

                    @if (count($newAccounts) > 0)
                        @foreach ($newAccounts as $account)
                            <div class="card cardContriner">
                                <div class="card-header" id="account-{{ $account->id }}">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#accountOne-{{ $account->id }}" aria-expanded="false"
                                            aria-controls="flush-collapseOne">
                                            <span> <i class="fas fa-folder"></i> </span>
                                            <span class="mx-2 font-weight-bold"> {{ $account->namear }} </span>
                                        </button>
                                    </h2>
                                </div>

                                <div id="accountOne-{{ $account->id }}" class="collapse"
                                    aria-labelledby="account-{{ $account->id }}" data-parent="#accountsDrop">
                                    <div class="card-body">
                                        {{-- child --}}
                                        @include('Accounts.child')
                                        {{-- end of child --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-10 mx-auto text-canter">
                            <h4 class="text-center py-5"> لا يوجد حسابات </h4>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .btn-link {
            box-shadow: none !important;
            background: #f6f6f6;
            border: 1px solid #ccc;
            margin: 0;
            color: #555;
        }

        .btn-link:hover,
        .btn-link:active {
            text-decoration: none !important;
        }

        .accordion-button::after {
            margin-right: auto !important;
            margin-left: 0 !important
        }

        .accordion-button {
            justify-content: space-between;
            flex-direction: row-reverse;
        }

        .cardContriner>.card-header {
            padding: 0 !important
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
@endpush
