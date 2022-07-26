<div class="card">
    <h5 class="card-header font-main py-4 text-right">اعدادات الفاتورة الالكترونية</h5>
    <div class="card-body font-main text-right">

        <div class="form-group">
            <label class="col-form-label"> Token Serial Name </label>
            <select name="token_serial_name" class="form-control">
                <option value="null">---</option>
                <option value="Egypt Trust" {{ $company->token_serial_name == "Egypt Trust" ? 'selected' : '' }} >Egypt Trust</option>
                <option value="MCSD" {{ $company->token_serial_name == "MCSD" ? 'selected' : '' }}>MCSD</option>
            </select>
        </div>

        <div class="form-group">
            <label class="col-form-label"> Token Pin Password </label>
            <input type="password" name="token_pin_password" class="form-control"
                value="{{ $company->token_pin_password }}">
        </div>


        <div class="form-group">
            <label class="col-form-label"> Client Id </label>
            <input type="text" name="client_id" class="form-control"
                value="{{ $company->client_id }}">
        </div>
        <div class="form-group">
            <label class="col-form-label"> Client Secret </label>
            <input type="text" name="client_secret" class="form-control"
                value="{{ $company->client_secret }}">
        </div>
    </div>
</div>
