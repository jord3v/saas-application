<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="pb-3">
    <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
      @php $segments = ''; @endphp
      @foreach(request()->segments() as $key => $segment)
            @php
                $segments .= '/'.$segment;
            @endphp

            @if (!$loop->last)
                <li class="breadcrumb-item"><a href="{{$segments}}">{{!is_numeric($segment) ? trans('system.'.$segment) : $segment}}</a></li>
            @else
                <li class="breadcrumb-item active" aria-current="page">{{trans('system.'.$segment)}}</li>
            @endif
        @endforeach
    </ol>
</nav>