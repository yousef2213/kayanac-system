<div class="card">
    <h5 class="card-header font-main py-4 text-right">اضافة مستخدم جديد</h5>
    <div class="card-body">

        <div class="form-group">
            <label for="inputTitle" class="col-form-label"> الاسم </label>
            <input id="inputTitle" type="text" name="name" autocomplete="0" class="form-control text-right" required>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label"> البريد الالكتروني </label>
            <input id="inputEmail" autocomplete="0" aria-autocomplete="0" type="text" name="email"
                class="form-control text-right">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>



        <div class="form-group">
            <label for="status" class="col-form-label"> الفروع </label>
            <select autocomplete="off" dir="rtl" name="barnchId" class="form-control barnchesSelect">
                @foreach ($branches as $branche)
                    <option value="{{ $branche->id }}"> {{ $branche->namear }} </option>
                @endforeach
            </select>
            @error('branchId')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <label for="inputPassword" class="col-form-label"> كلمة المرور </label>
        <div class="input-group mb-3 flex-row-reverse">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text" id="basic-addon1"> <i id="eyeId" class="fa fa-eye-slash"
                        aria-hidden="true"></i> </span>
            </div>
            <input id="inputPassword" type="password" name="password" value="{{ old('password') }}"
                class="form-control text-right" required>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <label for="inputPasswordConfirm" class="col-form-label"> تاكيد كلمة المرور </label>

        <div class="input-group mb-3 flex-row-reverse">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text" id="basic-addon2"> <i id="eyeId2" class="fa fa-eye-slash"
                        aria-hidden="true"></i> </span>
            </div>
            <input id="inputPasswordConfirm" type="password" name="password_confirmation"
                value="{{ old('password_confirmation') }}" class="form-control text-right" required>
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>




        <div class="form-group">
            <label for="role" class="col-form-label"> الصلاحيه </label>
            <select name="type"  dir="rtl" class="form-control" required>
                <option value="">---</option>
                <option value="3">مسؤل</option>
                <option value="1">مستخدم عادي</option>
            </select>
            @error('role')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="status"  class="col-form-label"> الحالة </label>
            <select name="status" dir="rtl" class="form-control">
                <option value="active">نشط</option>
                <option value="deactive">غير نشط</option>
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


    </div>
</div>
