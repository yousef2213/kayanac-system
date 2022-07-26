@foreach ($child->childList as $itemChild)
    <div class="accordion text-right font-main" id="fourAcountDrop">
        @if ($itemChild->parent != 1)
            <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                <span class="mx-2">{{ $itemChild->namear }} </span>
                <span> <i class="fas fa-file"></i> </span>
            </a>
        @else
            <div class="card cardContriner">
                <div class="card-header" id="threeChild-{{ $itemChild->id }}">
                    <h2 class="mb-0 d-flex">
                        <button class="btn btn-link btn-block text-right font-weight-bold" type="button"
                            data-toggle="collapse" data-target="#accountThreeLast-{{ $itemChild->id }}"
                            aria-expanded="true" aria-controls="accountThreeLast-{{ $itemChild->id }}">
                            @if ($itemChild->id == 8)
                                <span class="mx-2"> {{ $itemChild->namear }}</span>
                                <span> <i class="fas fa-folder text-success"></i> </span>
                            @elseif($itemChild->id == 21)
                                <span class="mx-2"> {{ $itemChild->namear }}</span>
                                <span> <i class="fas fa-folder text-success"></i> </span>
                            @else
                                <span class="mx-2"> {{ $itemChild->namear }}</span>
                                <span> <i class="fas fa-folder"></i> </span>
                            @endif
                        </button>
                        <a class="border-0" href="{{ route('accounts.edit', $itemChild->id) }}">
                            <span style="font-size: 16px;display: inline-block;padding-bottom: 13px;"> <i
                                    class="fas fa-edit"></i>
                            </span>
                        </a>
                    </h2>
                </div>

                <div id="accountThreeLast-{{ $itemChild->id }}" class="collapse"
                    aria-labelledby="threeChild-{{ $itemChild->id }}" data-parent="#fourAcountDrop">
                    <div class="card-body">
                        @if ($itemChild->id == 8)
                            @foreach ($customers as $customer)
                                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                    <span class="mx-1"> {{ $customer->name }} </span>
                                    <span class="mx-1"> {{ $customer->account_id }} </span>
                                    <span> <i class="fas fa-file"></i> </span>
                                </a>
                            @endforeach
                        @elseif($itemChild->id == 21)
                            @foreach ($suppliers as $customer)
                                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                    <span class="mx-1"> {{ $customer->name }} </span>
                                    <span class="mx-1"> {{ $customer->account_id }} </span>
                                    <span> <i class="fas fa-file"></i> </span>
                                </a>
                            @endforeach
                        @elseif($itemChild->id == 15)
                            @foreach ($employees as $employee)
                                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                    <span class="mx-1"> {{ $employee->namear }} </span>
                                    <span class="mx-1"> {{ $employee->account_id }} </span>
                                    <span> <i class="fas fa-file"></i> </span>
                                </a>
                            @endforeach
                        @elseif($itemChild->id == 11)
                            @foreach ($stores as $store)
                                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                                    <span class="mx-1"> {{ $store->namear }} </span>
                                    <span class="mx-1"> {{ $store->account_id }} </span>
                                    <span> <i class="fas fa-file"></i> </span>
                                </a>
                            @endforeach
                        @endif

                        @include('Accounts.last2')
                    </div>
                </div>
            </div>
        @endif
    </div>

@endforeach
