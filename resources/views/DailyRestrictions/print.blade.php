<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bonds/print.css') }}">
    <title>Daily Print</title>
</head>

<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-10 mx-auto">
                <section>

                    <div class="py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="font-main text-right">{{ $company->companyNameAr }}</h6>
                                <h6 class="font-main text-right text-uppercase">{{ $branch->namear }}</h6>
                            </div>
                            <div>
                                <img src="{{ asset('comp/' . $company->logo) }}" class="rounded" width="100"
                                    alt="">
                                <h5 class="font-main" style="text-decoration: underline"> القيود اليومية </h5>
                            </div>
                            <div>
                                <h6 class="font-main text-left text-uppercase">{{ $company->companyNameEn }}</h6>
                                <h6 class="font-main text-left text-uppercase">{{ $company->active }}</h6>
                            </div>
                        </div>
                    </div>



                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="font-main text-center text-uppercase ">الرقم :</h6>
                                <h6 class="font-main text-center text-uppercase pr-4"> {{ $daily->id }} </h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="font-main text-center text-uppercase ">التاريخ : </h6>
                                <h6 class="font-main d-flex text-center text-uppercase pr-4"
                                    style="text-decoration: underline">
                                    <span> {{ date('a', strtotime($daily->date)) }} </span>
                                    <span class="pr-1"> {{ date('h:m:s d/m/Y', strtotime($daily->date)) }}
                                    </span>
                                </h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="font-main text-center text-uppercase ">الحالة :</h6>
                                <h6 class="font-main text-center text-uppercase pr-4">
                                    {{ $daily->status == 1 ? 'معتمدة' : '' }}
                                    {{ $daily->status == 0 ? 'غير معتمدة' : '' }}
                                    {{ $daily->status == 85 ? '' : '' }}</h6>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="font-main text-center text-uppercase ">المصدر :</h6>
                                <h6 class="font-main text-center text-uppercase pr-4"> {{ $daily->source_name }}
                                </h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pl-5">
                                <h6 class="font-main text-center text-uppercase ">رقم المصدر : </h6>
                                <h6 class="font-main d-flex text-center text-uppercase pr-4 pl-5">
                                    {{ $daily->source }}
                                </h6>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                            </div>
                        </div>

                    </div>


                    {{-- body --}}
                    <table class="table" dir="rtl">
                        <thead>
                            <tr class="text-center font-main">
                                <th scope="col">م</th>
                                <th scope="col">رقم الحساب</th>
                                <th scope="col">اسم الحساب</th>
                                <th scope="col">مدين</th>
                                <th scope="col">دائن</th>
                                <th scope="col">الوصف</th>
                                <th scope="col">مركز التكلفة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total1 = 0;
                            $total2 = 0;
                            ?>
                            @foreach ($list as $key => $item)
                                <?php
                                $total1 += $item->debtor;
                                $total2 += $item->creditor;
                                ?>
                                <tr class="text-center font-main">
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $item->account_id }}</td>
                                    <td>{{ $item->account_name }}</td>
                                    <td>{{ $item->debtor }}</td>
                                    <td>{{ $item->creditor }}</td>
                                    <td>{{ $item->description }}</td>
                                    @if ($item->cost_center)
                                        <td>{{ $item->cost_center . ' - ' . $item->costName }} </td>
                                    @else
                                        <td> </td>
                                    @endif
                                </tr>
                            @endforeach
                            <tr class="text-center font-main">
                                <th scope="row"></th>
                                <td></td>
                                <td>اجمالي </td>
                                <td> <?php echo $total1; ?> </td>
                                <td> <?php echo $total2; ?> </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="pt-3 pb-5">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h6 class="font-main text-center text-uppercase ">المحاسب</h6>
                            <h6 class="font-main text-center text-uppercase ">المدير المالي</h6>
                            <h6 class="font-main text-center text-uppercase ">المدير العام</h6>
                        </div>
                    </div>





                    <div class="py-3">
                        <div class="d-flex justify-content-between align-items-center flex-row-reverse">
                            <div>
                                <h6 class="font-main text-center text-uppercase ">{{ $branch->address }}</h6>
                                <h6 class="font-main text-center text-uppercase">{{ $branch->phone }}</h6>
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
