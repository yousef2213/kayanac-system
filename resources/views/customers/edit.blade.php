@extends('dashboard.master')

@section('main-content')
    <div class="container">

        <div class="col-12">
            <ol class="breadcrumb justify-content-end font-main p-2">
                <li class="breadcrumb-item active" aria-current="page"> تعديل عميل </li>
                <li class="breadcrumb-item"><a href="/erp/public/customers"> العملاء </a></li>
                <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
            </ol>
        </div>


        <div class="company text-right font-ar">
            <div class="col-12 mx-auto px-0">
                <form dir="rtl" method="post" action="{{ route('customers.update', $custom->id) }}">
                    {{ csrf_field() }}
                    @method('PATCH')



                    <div class="container font-main">
                        <div class="row font-main">
                            <div class="col-12 mx-auto px-3 font-main">
                                <ul class="nav nav-tabs mb-4 px-0" dir="rtl" id="myTab" role="tablist">
                                    <li class="nav-item font-main" role="presentation">
                                        <button class="nav-link active font-weight-bold" id="home-tab" data-bs-toggle="tab"
                                            data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                            aria-selected="true">بيانات العميل</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link font-main font-weight-bold" id="electron_tab"
                                            data-bs-toggle="tab" data-bs-target="#electronic" type="button" role="tab"
                                            aria-controls="electronic" aria-selected="false">
                                            <span> سياسة التسعير </span>
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel"
                                        aria-labelledby="home-tab">
                                        @include('customers.infoEdit')
                                    </div>
                                    <div class="tab-pane fade" id="electronic" role="tabpanel"
                                        aria-labelledby="electron_tab">
                                        @include('customers.RoleSaleEdit')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- <div class="row py-2">



                    <div class="row py-2 font-main">
                        <div class="col-12 col-md-6 mx-auto py-2">
                            <div class="form-group">
                                <label class="col-form-label">نوع الفاتورة الالكترونية</label>
                                <select name="type_invoice_electronice" class="form-control">
                                    <option value={{ null }}>---</option>
                                    <option value="B  للاعمال التجارية فى مصر"
                                        {{ $custom->type_invoice_electronice == 'B  للاعمال التجارية فى مصر' ? 'selected' : '' }}>
                                        B للاعمال التجارية فى مصر</option>
                                    <option value="F  للاجنبى"
                                        {{ $custom->type_invoice_electronice == 'F  للاجنبى' ? 'selected' : '' }}>
                                        F
                                        للاجنبى</option>
                                    <option value="P  للشخص الطبيعى"
                                        {{ $custom->type_invoice_electronice == 'P  للشخص الطبيعى' ? 'selected' : '' }}>
                                        P للشخص الطبيعى</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mx-auto py-2">
                            <label> رقم التسجيل بضريبة القيمة المضافة </label>
                            <input type="number" name="numRegister" value="{{ $custom->VATRegistration }}"
                                class="form-control" />
                        </div>
                        <div class="col-12 col-md-6 mx-auto py-2">
                            <label>تلفون</label>
                            <input type="number" name="phone" value="{{ $custom->phone }}" class="form-control" />
                        </div>
                        <div class="col-12 col-md-6 py-2">
                            <label>رقم الهوية</label>
                            <input type="number" name="IdentificationNumber" value="{{ $custom->IdentificationNumber }}"
                                class="form-control" />
                        </div>

                        <div class="col-12 col-md-6 py-2">
                            <label> العنوان </label>
                            <input autocomplete="off" type="text" value="{{ $custom->address }}" name="address"
                                class="form-control" />
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="submiting d-flex mt-4">
                        <button type="submit" class="btn btn-primary mx-2 px-4 font-main"> تعديل </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('boot5/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        .select2-selection {
            height: 35px !important;
        }

        .chosen-container.chosen-container-single {
            width: 100% !important;
        }

    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#user-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [6, 7]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }
    </script>

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
                // alert(dataID);
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
