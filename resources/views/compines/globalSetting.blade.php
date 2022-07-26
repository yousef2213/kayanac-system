<div class="card">
    <h5 class="card-header font-main py-4 text-right">اعدادات عامة</h5>
    <div class="card-body font-main text-right">


        <div class="form-group">
            <label class="col-form-label">اسم الشركة بالعربي</label>
            <input type="text" name="namear" class="form-control" value="{{ $company->companyNameAr }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="col-form-label">اسم الشركة بالانجليزي</label>
            <input type="text" name="nameen" class="form-control" value="{{ $company->companyNameEn }}">
            @error('nameen')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="col-form-label"> الرقم الضريبي </label>
            <input type="text" name="taxNum" class="form-control" value="{{ $company->taxNum }}">
            @error('taxNum')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <select name="negative_sale" class="form-control">
                <option value="0" {{ $company->negative_sale == 0 ? 'selected' : '' }}>--</option>
                <option value="1" {{ $company->negative_sale == 1 ? 'selected' : '' }}>البيع بالسالب</option>
            </select>
        </div>



        <div class="form-group">
            <label for="inputPassword" class="col-form-label">النشاط</label>
            <textarea name="active" class="form-control">{{ $company->active }}</textarea>
            @error('active')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="col-form-label"> لوجو الشركة </label>
            <input type="file" name="logo" class="form-control">
            @error('logo')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
