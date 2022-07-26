@if (count($account->ParentChild) > 0)
    <div class="accordion text-right font-main" id="accountsChildDrop">
        @if (count($account->ParentChild) > 0)
            @foreach ($account->ParentChild as $child)
                @if ($child->parent == 1)
                    <div class="card cardContriner">
                        <div class="card-header" id="accountchild-{{ $child->id }}">
                            <h2 class="mb-0 d-flex">
                                <button class="btn btn-link btn-block text-right font-weight-bold" type="button"
                                    data-toggle="collapse" data-target="#accountOneChild-{{ $child->id }}"
                                    aria-expanded="true" aria-controls="accountOneChild-{{ $child->id }}">
                                    <span class="mx-2"> {{ $child->namear }} </span>
                                    <span> <i class="fas fa-folder"></i> </span>
                                </button>
                                <a class="border-0" href="{{ route('accounts.edit', $child->id) }}">
                                    <span style="font-size: 16px;display: inline-block;padding-bottom: 13px;"> <i
                                            class="fas fa-edit"></i>
                                    </span>
                                </a>
                            </h2>
                        </div>

                        <div id="accountOneChild-{{ $child->id }}" class="collapse"
                            aria-labelledby="accountchild-{{ $child->id }}" data-parent="#accountsChildDrop">
                            <div class="card-body">
                                {{-- last child --}}
                                @include('Accounts.last_component')
                                {{-- end of last child --}}
                                @if ($child->id == 26)
                                    @foreach ($stores as $store)
                                        <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                            <span class="mx-1"> تكلفة مبيعات {{ $store->namear }} </span>
                                            <span class="mx-1"> {{ $store->account_id }} </span>
                                            <span> <i class="fas fa-file"></i> </span>
                                        </a>
                                    @endforeach
                                    {{-- @elseif($itemChild->id == 11)
                                    @foreach ($stores as $store)
                                        <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                            <span class="mx-1"> {{ $store->namear }} </span>
                                            <span class="mx-1"> {{ $store->account_id }} </span>
                                            <span> <i class="fas fa-file"></i> </span>
                                        </a>
                                    @endforeach --}}
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- && $child->child == 1 && $child->parent_2_id == 0 --}}
                @elseif ($child->parent == 0)
                    <a href="#" class="d-inline-block px-3 my-2">
                        <span class="mx-2">{{ $child->namear }} </span>
                        <span> <i class="fas fa-file"></i> </span>
                    </a>
                @endif
            @endforeach
        @else
            <div class="col-10 mx-auto text-canter">
                <h4 class="text-center py-5"> لا يوجد حسابات </h4>
            </div>
        @endif


    </div>

@endif
