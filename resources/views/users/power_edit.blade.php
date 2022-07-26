<div class="row">
    <div class="col-12 py-5">
        <div class="accordion font-main" id="SystemParent">

            @foreach ($parents as $parent)
                @if ($parent->page_name != 'TsReports' && $parent->page_name != 'TsSettings' && $parent->page_name != 'TsPrintSetting')
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="{{ $parent->page_name }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#{{ $parent->page_name }}Manual" aria-expanded="false"
                                aria-controls="{{ $parent->page_name }}Manual">
                                <div class="form-group p-0 m-0">
                                    <input type="checkbox" name="{{ $parent->page_name }}"
                                        {{ $power[$parent->page_name] == 1 ? 'checked' : '' }}
                                        id="{{ $parent->page_name }}It" onchange="handelValue(event)"
                                        value="{{ $power[$parent->page_name] }}" />

                                    <label for="{{ $parent->page_name }}It" class="font-main font-weight-bold mr-2">
                                        {{ $parent->name }} </label>
                                </div>
                            </button>
                        </h2>
                        <div id="{{ $parent->page_name }}Manual" class="accordion-collapse collapse"
                            aria-labelledby="{{ $parent->page_name }}" data-bs-parent="#SystemParent">
                            <div class="accordion-body">
                                @foreach ($childs as $child)
                                    @if ($child->parent_id == $parent->id)
                                        <div class="form-group d-flex align-items-center">
                                            <input type="checkbox" id="{{ $child->id }}"
                                                {{ $power[$child->page_name] == 1 ? 'checked' : '' }}
                                                onchange="handelValue(event)" name="{{ $child->page_name }}"
                                                value="{{ $power[$child->page_name] }}" />
                                            <label for="{{ $child->id }}" class="font-main font-weight-bold mr-2">
                                                {{ $child->name }} </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach



            <div class="accordion-item">
                <h2 class="accordion-header" id="POSS">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#POSSManual" aria-expanded="false" aria-controls="POSSManual">
                        <div class="form-group p-0 m-0">
                            {{-- <input type="checkbox" name="POSS"
                                {{ $power["TsPos"] == 1 ? 'checked' : '' }}
                                id="POSSIt" onchange="handelValue(event)"
                                value="{{ $power["TsPos"] }}" />

                            <label for="POSSIt" class="font-main font-weight-bold mr-2">
                                {{ "TsPos" }} </label> --}}
                            <p class="font-main ">نقاط البيع</p>
                        </div>
                    </button>
                </h2>
                <div id="POSSManual" class="accordion-collapse collapse" aria-labelledby="POSS"
                    data-bs-parent="#SystemParent">
                    <div class="accordion-body">
                        <div class="form-group d-flex align-items-center">
                            <input type="checkbox" id="TsPos" {{ $power['TsPos'] == 1 ? 'checked' : '' }}
                                onchange="handelValue(event)" name="TsPos" value="{{ $power['TsPos'] }}" />
                            <label for="TsPos" class="font-main font-weight-bold mr-2">
                                فتح نقاط البيع (ايقون) </label>
                        </div>

                    </div>
                </div>
            </div>

            <hr>
            <hr>
        </div>
    </div>
</div>
