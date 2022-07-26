@extends('dashboard.master')

@section('main-content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-end font-main">
            <li class="breadcrumb-item active" aria-current="page"> اضافة مجموعة </li>
            <li class="breadcrumb-item"><a href="/erp/public/items/categories-of-items"> مجموعة الاصناف </a></li>
            <li class="breadcrumb-item"><a href="/erp/public/home">الرئيسية</a></li>
        </ol>
    </nav>
    <div class="card">
        <h5 class="card-header"> Add Group </h5>
        <div class="card-body font-main">
            <form method="post" dir="rtl" action="{{ route('item.index.category.add') }}" autocomplete="off"
                enctype="multipart/form-data">

                {{ csrf_field() }}

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الاسم بالعربي</label>
                            <input type="text" name="namear" value="{{ old('namear') }}" class="form-control">
                            @error('namear')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label">الاسم بالانجليزي</label>
                            <input type="text" name="nameen" value="{{ old('nameen') }}" class="form-control">
                            @error('nameen')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group text-right">
                            <label class="col-form-label"> نوع المجموعة </label>
                            <select name="group_type" class="form-control chosen-select" onchange="handelGroup(event)"
                                tabindex="4" dir="rtl">
                                <option value="0"> --- </option>
                                <option value="1"> رئيسية </option>
                                <option value="0"> متفرعة </option>
                            </select>
                            @error('group_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6 main d-none">
                        <div class="form-group text-right">
                            <label class="col-form-label"> المجموعة الرئيسية </label>
                            <select name="group_main" class="form-control mainId" dir="rtl">
                                <option value="0"> --- </option>
                                @foreach ($groups as $item)
                                    <option value="{{ $item->id }}"> {{ $item->namear }} </option>
                                @endforeach
                            </select>
                            @error('group_main')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <hr>

                <div class="form-group mb-3 text-right">
                    {{-- <button type="reset" class="btn btn-warning">Reset</button> --}}
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('styles')
    <style>
        .chosen-single {
            height: 35px !important;
        }

    </style>
@endpush
@push('scripts')
    <script>
        const handelGroup = event => {
            let val = event.target.value;
            if (val == 1) {
                document.querySelector('.main').classList.add('d-none')
            } else {
                document.querySelector('.main').classList.remove('d-none')
                document.querySelector('.mainId').value = 0
            }
            console.log(event.target.value);
        }
    </script>
@endpush
