<div class="card mb-4">
    <h5 class="card-header font-main py-4 text-right">اعدادات الضرائب</h5>
    <div class="card-body font-main text-right">
        <div class="mb-3 form-check">
            <?php if($company->tax_source == 1): ?>
                <input type="checkbox" name="tax_source" checked value="1" class="form-check-input" id="tax_source">
                <label class="form-check-label mr-4" for="tax_source">ضريبة خصم المنبع</label>
            <?php else: ?>
                <input type="checkbox" name="tax_source" class="form-check-input" id="tax_source">
                <label class="form-check-label mr-4" for="tax_source">ضريبة خصم المنبع</label>
            <?php endif; ?>

        </div>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\erp\resources\views/compines/taxs.blade.php ENDPATH**/ ?>