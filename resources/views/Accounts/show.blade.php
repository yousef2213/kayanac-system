@extends('dashboard.master')

@section('main-content')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-end font-main">
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

            <div class="card-body">


                <div class="table-responsive">
                    <table class="table" id="branches-dataTable" dir="rtl" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center font-main">
                                <th> رقم الحساب </th>
                                <th> اسم الحساب </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr class="text-center font-main">
                                    <td>{{ $customer->account_id }}</td>
                                    <td>
                                        {{ $customer->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
