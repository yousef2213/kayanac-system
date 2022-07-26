<div class="row py-2">


    <div class="col-12 col-md-6 mx-auto py-2">
        <div class="form-group">
            <label for="delg" class="col-form-label">
                <span> المندوب </span>
                <span class="text-danger"> * </span>
            </label>
            <select name="delegateId" class="form-control chosen-select" id="delg">
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}"> {{ $employee->namear }} </option>
                @endforeach
            </select>
            @error('delg')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6 mx-auto py-2">
        <div class="form-group">
            <label  class="col-form-label">
                <span> الرصيد الافتتاحي </span>
            </label>
            <div class="d-flex justify-content-between">
                <input type="number" name="Obalance" step="0.1" class="form-control w-50" id="">
                <select name="TObalance" class="form-control w-50">
                    <option value="1"> مدين </option>
                    <option value="2"> دائن </option>
                </select>
            </div>
            @error('delg')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>



    <div class="col-12 col-md-6 mx-auto py-2">
        <div class="form-group">
            <label  class="col-form-label">
                <span> استحقاق الاجل </span>
            </label>
            <input type="number" name="term_maturity" step="0.1" class="form-control text-center" value="30" id="">
            @error('delg')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-12 col-md-6 mx-auto py-2">
        <div class="form-group">
            <label  class="col-form-label">
                <span>سياسة  التسعير </span>
            </label>
            <input type="number" name="pricing_policy" step="0.1" class="form-control" id="">
            @error('delg')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-12 col-md-6 py-2">
        <div class="form-group">
            <label  class="col-form-label">
                <span>الحد الائتماني </span>
            </label>
            <div class="d-flex align-items-center">
                <input class="form-check-input" type="checkbox" name="is_credit_limit" onchange="handelNum(event)" checked value=""
                    id="flexCheckDefault">
                <input class="form-control mx-4" id="isChecked" name="credit_limit" step="0.1" type="number" value="">
            </div>
        </div>
    </div>






</div>
