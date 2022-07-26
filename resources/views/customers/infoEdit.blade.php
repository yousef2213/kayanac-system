<div class="row py-2">
    <div class="col-12 col-md-6 mx-auto font-main">
        <label>الكود</label>
        <input type="number" disabled value="{{ $custom->code }}" class="form-control" />
    </div>
    <div class="col-12 col-md-6 mx-auto">
        <div class="form-group font-main">
            <label for="status" class="col-form-label">المجموعة</label>
            <select name="group" class="form-control">
                <option value="0" {{ $custom->group == '0' ? 'selected' : '' }}>---</option>
                <option value="1" {{ $custom->group == '1' ? 'selected' : '' }}>مجموعة رئيسية
                </option>
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>



    <div class="col-12 col-md-6 mx-auto py-2">
        <label>الاسم بالعربي <span class="text-danger"> * </span> </label>
        <input type="text" name="namecustomerar" value="{{ $custom->name }}" class="form-control" />
        @error('namecustomerar')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-12 col-md-6 mx-auto py-2">
        <label>الاسم بالانجليزي<span class="text-danger"> * </span></label>
        <input type="text" name="namecustomeren" value="{{ $custom->name }}" class="form-control" />
        @error('namecustomeren')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>





    <div class="col-12 col-md-6 mx-auto py-2">
        <div class="form-group">
            <label class="col-form-label">نوع الفاتورة الالكترونية</label>
            <select name="type_invoice_electronice" class="form-control">
                <option value={{ null }}>---</option>
                <option value="B  للاعمال التجارية فى مصر"
                    {{ $custom->type_invoice_electronice == 'B  للاعمال التجارية فى مصر' ? 'selected' : '' }}>
                    B للاعمال التجارية فى مصر</option>
                <option value="F  للاجنبى" {{ $custom->type_invoice_electronice == 'F  للاجنبى' ? 'selected' : '' }}>
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
        <label>تلفون <span class="text-danger"> * </span></label>
        <input type="number" name="phone" value="{{ $custom->phone }}" class="form-control" />
        @error('phone')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-12 col-md-6">
        <label>رقم الهوية</label>
        <input type="number" name="IdentificationNumber" value="{{ $custom->IdentificationNumber }}"
                                class="form-control" />
    </div>


    <div class="row py-2 font-main">
        <div class="col-12 col-md-6">
            <label> العنوان
                {{-- <span class="text-danger"> * </span> --}}
            </label>
            <input autocomplete="off" type="text" value="{{ $custom->address }}" name="address"
            class="form-control" />
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

    </div>


</div>
