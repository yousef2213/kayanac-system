<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bonds/print.css') }}">
    <title>Pdf Bond</title>
</head>

<body>

    <div class="container py-5">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="font-main text-center">{{ $company->companyNameAr }}</h6>
                            <h6 class="font-main text-center text-uppercase">{{ $company->active }}</h6>
                        </div>
                        <div>
                            <img src="{{ asset('comp/'.$company->logo) }}" class="rounded" width="100" alt="">
                        </div>
                        <div>
                            <h6 class="font-main text-center text-uppercase">{{ $company->companyNameEn }}</h6>
                            <h6 class="font-main text-center text-uppercase">{{ $company->active }}</h6>
                        </div>
                    </div>
                </div>
                @if ($type == 1)
                    <h3 class="text-center title color-main font-main"> سند قبض نقدي </h3>
                    <h3 class="text-center title color-main text-uppercase font-main"> cash receipt voucher </h3>
                @endif
                @if ($type == 2)
                    <h3 class="text-center title color-main font-main"> سند قبض بنكي </h2>
                    <h3 class="text-center title color-main text-uppercase font-main"> bank receipt voucher </h3>
                @endif
                @if ($type == 3)
                    <h3 class="text-center title color-main font-main"> سند صرف نقدي </h2>
                    <h3 class="text-center title color-main text-uppercase font-main"> voucher for cash </h3>
                @endif
                @if ($type == 4)
                    <h3 class="text-center title color-main font-main"> سند صرف بنكي </h2>
                    <h3 class="text-center title color-main text-uppercase font-main"> voucher for bank </h3>
                @endif

                <div class="d-flex justify-content-between align-items-center flex-row-reverse py-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="date-name font-main">الموافق :</h6>
                        <h6 class="mx-3 font-main"> {{ date('d / m / Y', strtotime($bond->date)) }} م</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        {{-- <h6 class="date-name font-main">الموافق :</h6>
                        <h6 class="mx-3 font-main"> {{ $bond->hijiri }} </h6> --}}
                        <div class="text-center">
                            <span class="span-title font-main rel"> {{ $currency->bigar }} </span>
                            {{-- <span class="span-title font-main">.</span>
                            <span class="span-title font-main"> S.R</span> --}}
                            <div class="box">
                                <h6> {{ $item->amount }} </h6>
                            </div>
                        </div>
                    </div>
                </div>



                <section class="card px-4">
                    <div class=" d-flex justify-content-between align-items-center py-3">
                        <h6 class="title-box font-main"> استملنا من السيد / السيدة :</h6>
                        <p class="text-box font-main ">
                            {{ $item->account_name }}
                            <span class="line"></span>
                        </p>
                    </div>
                    <div class=" d-flex justify-content-between align-items-center py-3">
                        <h6 class="title-box-2 font-main"> مبلغ وقدرة :</h6>
                        <p class="text-box-2 font-main ">
                            <?php echo Numbers::TafqeetMoney($item->amount, 'EGP'); ?>
                            <span class="line"></span>
                        </p>
                    </div>


                    <div class=" d-flex justify-content-between align-items-center py-3">
                        <div style="max-width: 50%; width: 100%;"
                            class="text-right d-flex justify-content-between align-items-center">
                            <h6 class="font-main" style="width:30%"> نقدا / شيك رقم :</h6>
                            <p class="font-main p-0 m-0" style="width:70%">
                                <span class="line2"></span>
                            </p>
                        </div>
                        <div style="width: 50%" class="text-right d-flex justify-content-between align-items-center">
                            <h6 class="font-main" style="width:30%"> علي بنك :</h6>
                            <p class="font-main p-0 m-0" style="width:70%">
                                <span class="line2"></span>
                            </p>
                        </div>
                    </div>

                    <div class=" d-flex justify-content-between align-items-center py-3">
                        <h6 class="title-box-4 font-main p-0 m-0"> وذالك مقابل :</h6>
                        <p class="text-box-4 desc font-main p-0 m-0">
                            {{ $item->description }}
                            <span class="line"></span>
                        </p>
                    </div>



                    <div class="d-flex justify-content-between align-items-center py-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="font-main m-0 pl-3"> المحاسب </h6>
                            <h6 class="font-main m-0 p-0"> ...... </h6>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 p-0 px-3 font-main"> المسلتم </h6>
                            <h6 class="m-0 p-0 font-main"> ...... </h6>
                        </div>
                    </div>


                    <div class="py-3">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse">
                            <div>
                                <h6 class="font-main text-center text-uppercase ">{{ $branch->address }}</h6>
                                <h6 class="font-main text-center text-uppercase">{{ $branch->phone  }}</h6>
                            </div>
                        </div>
                    </div>
                </section>


                <button class="d-block w-100 btn btn-primary font-main" onclick="Print()">
                    طباعة
                </button>

            </div>
        </div>
    </div>

    <script>
        function Print() {
            window.print()
        }
    </script>

</body>

</html>
