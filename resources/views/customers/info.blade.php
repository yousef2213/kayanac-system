<div class="row py-2">
    {{-- <div class="col-12 col-md-6 mx-auto py-2">
        <label>الكود</label>
        <input type="number" disabled class="form-control" />
    </div> --}}
    <div class="col-12 col-md-6 mx-auto py-2">
        <div class="form-group">
            <label for="group" class="col-form-label">المجموعة</label>
            <select name="group" class="form-control">
                <option value="0">---</option>
                <option value="1"> المجموعة الرئيسية </option>
            </select>
            @error('group')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>



    <div class="col-12 col-md-6 mx-auto py-2">
        <label>الاسم بالعربي <span class="text-danger"> * </span> </label>
        <input type="text" name="namecustomerar" class="form-control" />
        @error('namecustomerar')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-12 col-md-6 mx-auto py-2">
        <label>الاسم بالانجليزي<span class="text-danger"> * </span></label>
        <input type="text" name="namecustomeren" class="form-control" />
        @error('namecustomeren')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>





    <div class="col-12 col-md-6 mx-auto py-2">
        <div class="form-group">
            <label class="col-form-label">نوع الفاتورة الالكترونية</label>
            <select name="type_invoice_electronice" class="form-control">
                <option value={{ null }}>---</option>
                <option value="B  للاعمال التجارية فى مصر">B للاعمال التجارية فى مصر</option>
                <option value="F  للاجنبى">F للاجنبى</option>
                <option value="P  للشخص الطبيعى">P للشخص الطبيعى</option>
            </select>
        </div>
    </div>
    <div class="col-12 col-md-6 mx-auto py-2">
        <label> رقم التسجيل بضريبة القيمة المضافة </label>
        <input type="number" name="numRegister" value="{{ old('numRegister') }}" class="form-control" />
    </div>



    <div class="col-12 col-md-6 mx-auto py-2">
        <label>تلفون <span class="text-danger"> * </span></label>
        <input type="number" name="phone" value="{{ old('phone') }}" class="form-control" />
        @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-12 col-md-6">
        <label>رقم الهوية</label>
        <input type="number" name="IdentificationNumber" class="form-control" />
    </div>


    <div class="row py-2 font-main">
        <div class="col-12 col-md-6">
            <label> العنوان
                {{-- <span class="text-danger"> * </span> --}}
            </label>
            <input autocomplete="off" type="text" value="{{ old('address') }}" name="address"
                class="form-control" />
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

    </div>


</div>
