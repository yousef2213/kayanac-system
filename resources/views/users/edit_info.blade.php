<div class="card font-main">
    <h5 class="card-header">Edit User</h5>
    <div class="card-body text-right">
        <div class="form-group text-right">
            <label for="inputTitle" class="col-form-label">الاسم</label>
            <input id="inputTitle" type="text" autocomplete="0" aria-autocomplete="0" name="name"
                value="{{ $user->name }}" class="form-control">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group text-right">
            <label for="inputEmail" class="col-form-label">البريد الالكتروني</label>
            <input id="inputEmail" type="text" autocomplete="0" aria-autocomplete="0" name="email"
                value="{{ $user->email }}" class="form-control">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <label for="inputPassword" class="col-form-label"> كلمة المرور </label>
        <div class="input-group mb-3 flex-row-reverse">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text" id="basic-addon1"> <i id="eyeId"
                        class="fa fa-eye-slash" aria-hidden="true"></i> </span>
            </div>
            <input id="inputPassword" type="password" name="password" class="form-control">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>


        <label for="inputPasswordConfirm" class="col-form-label"> تاكيد كلمة المرور </label>

        <div class="input-group mb-3 flex-row-reverse">
            <div class="input-group-prepend">
                <button type="button" class="input-group-text" id="basic-addon2"> <i id="eyeId2"
                        class="fa fa-eye-slash" aria-hidden="true"></i> </span>
            </div>
            <input id="inputPasswordConfirm" type="password" name="password_confirmation" class="form-control">
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>




        @php
            $roles = DB::table('users')
                ->select('role')
                ->where('id', $user->id)
                ->get();
        @endphp
        <div class="form-group text-right">
            <label for="role" class="col-form-label">صلاحية</label>
            <select name="role" class="form-control">
                <option value="">---</option>
                <option value="3" {{ $user->role == '3' ? 'selected' : '' }}>مسؤل</option>
                <option value="1" {{ $user->role == '1' ? 'selected' : '' }}>مستخدم عادي</option>
            </select>
            @error('role')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group text-right">
            <label for="status" class="col-form-label">الحالة</label>
            <select name="status" class="form-control">
                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}> نشط </option>
                <option value="deactive" {{ $user->status == 'deactive' ? 'selected' : '' }}> غير نشط </option>
            </select>
            @error('status')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

    </div>
</div>
