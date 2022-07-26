<div class="row">
    <div class="col-12 py-5">
        <div class="accordion font-main" id="SystemParentSide">
            @foreach ($childs as $child)
                @if ($child->name != 'تقارير المشتريات' && $child->name != 'تقييم المخزون' && $child->name != 'ارصدة الاصناف' && $child->name != 'النظام' && $child->name != 'المخازن' && $child->name != 'المبيعات' && $child->name != 'المشتريات' && $child->name != 'كارت الصنف')
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="{{ $child->page_name }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#{{ $child->page_name }}Manual" aria-expanded="false"
                                aria-controls="{{ $child->page_name }}Manual">
                                <div class="form-group p-0 m-0">
                                    <label for="{{ $child->page_name }}It" class="font-main font-weight-bold mr-2">
                                        {{ $child->name }} </label>
                                </div>
                            </button>
                        </h2>

                        <div id="{{ $child->page_name }}Manual" class="accordion-collapse collapse"
                            aria-labelledby="{{ $child->page_name }}" data-bs-parent="#SystemParentSide">
                            <div class="accordion-body">

                                {{-- add --}}
                                <div
                                    class="{{ $child->page_name == 'TsCompany' ? 'd-none' : '' }} form-group d-flex align-items-center">
                                    <input type="checkbox" class="{{ $child->page_name == 'الشركة' ? 'd-none' : '' }}"
                                        onchange="handelValuePermision(event,'add-hidden-{{ $child->id }}')"
                                        id="side-{{ $child->id }}"
                                        {{ $orders->where('power_name', $child->page_name)->first()->add == 1 ? 'checked' : '' }} />
                                    <label for="side-{{ $child->id }}"
                                        class="font-main font-weight-bold mr-2">اضافة</label>
                                    <input type="hidden" id="add-hidden-{{ $child->id }}"
                                        value="{{ $orders->where('power_name', $child->page_name)->first()->add }}"
                                        name="add-{{ $child->page_name }}" />
                                </div>

                                {{-- edit --}}
                                <div
                                    class="{{ $child->page_name == 'TsAccountsGuide' ? 'd-none' : '' }} {{ $child->page_name == 'TsOrderCashing' ? 'd-none' : '' }} {{ $child->page_name == 'TsOrderAdd' ? 'd-none' : '' }} form-group d-flex align-items-center">
                                    <input type="checkbox" id="sideedit-{{ $child->id }}"
                                        onchange="handelValuePermision(event,'edit-hidden-{{ $child->id }}')"
                                        {{ $orders->where('power_name', $child->page_name)->first()->edit == 1 ? 'checked' : '' }} />
                                    <label for="sideedit-{{ $child->id }}" class="font-main font-weight-bold mr-2">
                                        تعديل </label>
                                    <input type="hidden" id="edit-hidden-{{ $child->id }}"
                                        value="{{ $orders->where('power_name', $child->page_name)->first()->edit }}"
                                        name="edit-{{ $child->page_name }}" />
                                </div>

                                {{-- delete --}}
                                {{-- {{ $child->page_name }} --}}
                                <div
                                    class="{{ $child->page_name == 'TsAccountsGuide' ? 'd-none' : '' }} {{ $child->page_name == 'TsOrderCashing' ? 'd-none' : '' }} {{ $child->page_name == 'TsOrderAdd' ? 'd-none' : '' }} {{ $child->page_name == 'TsCompany' ? 'd-none' : '' }} form-group d-flex align-items-center">
                                    <input type="checkbox" id="sidedel-{{ $child->id }}"
                                        onchange="handelValuePermision(event,'del-hidden-{{ $child->id }}')"
                                        {{ $orders->where('power_name', $child->page_name)->first()->delete == 1 ? 'checked' : '' }} />
                                    <label for="sidedel-{{ $child->id }}" class="font-main font-weight-bold mr-2">
                                        حذف
                                    </label>
                                    <input type="hidden" id="del-hidden-{{ $child->id }}"
                                        value="{{ $orders->where('power_name', $child->page_name)->first()->delete }}"
                                        name="delete-{{ $child->page_name }}" />
                                </div>

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <hr>
            <hr>
        </div>
    </div>
</div>
<script>
    const handelValuePermision = (event, id) => {
        if (event.target.checked) {
            document.getElementById(id).value = 1;
            event.target.value = 1;
        } else {
            document.getElementById(id).value = 0;
            event.target.value = 0;
        }
    }
</script>
