<div class="card mb-4">
    <h5 class="card-header font-main py-4 text-right">اعدادات الضرائب</h5>
    <div class="card-body font-main text-right">
        <div class="mb-3 form-check">
            @if ($company->tax_source == 1)
                <input type="checkbox" name="tax_source" checked value="1" class="form-check-input" id="tax_source">
                <label class="form-check-label mr-4" for="tax_source">ضريبة خصم المنبع</label>
            @else
                <input type="checkbox" name="tax_source" class="form-check-input" id="tax_source">
                <label class="form-check-label mr-4" for="tax_source">ضريبة خصم المنبع</label>
            @endif
        </div>

        <div class="mb-3 form-check">
            @if ($company->tobacco_tax == 1)
                <input type="checkbox" name="tobacco_tax" checked value="1" class="form-check-input" id="tobacco_tax">
                <label class="form-check-label mr-4" for="tobacco_tax">ضريبة التبغ</label>
            @else
                <input type="checkbox" name="tobacco_tax" class="form-check-input" id="tobacco_tax">
                <label class="form-check-label mr-4" for="tobacco_tax">ضريبة التبغ</label>
            @endif
        </div>
    </div>
</div>
