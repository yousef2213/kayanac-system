{{-- @if (count($itemChild->FourList) > 0)
    <div class="accordion text-right font-main" id="fourAcount">
        @foreach ($itemChild->FourList as $four)
            @if ($four->parent != 1)
                @if ($itemChild->parent_2_Id == $child->id && $four->parent_3_Id == $child->id)
                    <a href="#"> {{ $four->namear }} </a>
                @endif
            @endif
        @endforeach
    </div>
@endif --}}

@if (count($four->FiveList) > 0)
    <div class="accordion text-right font-main" id="fourAcount">
        @foreach ($four->FiveList as $five)
            @if ($five->parent == 0)
                <a href="#" class="px-3 py-2 d-block">
                    <span class="mx-2"> {{ $five->namear }} </span>
                    <span> <i class="fas fa-file"></i> </span>
                </a>
            @else
                <div class="card cardContriner">
                    <div class="card-header" id="fourChild-{{ $four->id }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-right font-weight-bold" type="button"
                                data-toggle="collapse" data-target="#accountFourLast-{{ $four->id }}"
                                aria-expanded="true" aria-controls="accountFourLast-{{ $four->id }}">
                                <span> {{ $four->namear }} </span>
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
