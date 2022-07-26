@if (count($itemChild->FourList) > 0)
    <div class="accordion text-right font-main" id="fourAcount">
        @foreach ($itemChild->FourList as $four)
            @if ($four->parent != 1)
                <a href="#" class="px-3 py-2 d-flex justify-content-end align-items-center">
                    <span class="mx-1">{{ $four->namear }} </span>
                    <span class="mx-1"> <i class="fas fa-file"></i> </span>
                </a>
            @else
                <div class="card cardContriner">
                    <div class="card-header" id="fourChild-{{ $four->id }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-right font-weight-bold" type="button"
                                data-toggle="collapse" data-target="#accountFourLast-{{ $four->id }}"
                                aria-expanded="true" aria-controls="accountFourLast-{{ $four->id }}">
                                <span class="mx-2"> {{ $four->namear }} </span>
                                <span> <i class="fas fa-folder"></i> </span>
                            </button>
                        </h2>
                    </div>

                    <div id="accountFourLast-{{ $four->id }}" class="collapse"
                        aria-labelledby="fourChild-{{ $four->id }}" data-parent="#fourAcount">
                        <div class="card-body">
                            @include('Accounts.last4')
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
