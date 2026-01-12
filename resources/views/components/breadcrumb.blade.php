@props(['items' => []])

@if(count($items) > 0)
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base my-1">
    @foreach($items as $index => $item)
        @if($index > 0)
            <li class="breadcrumb-item">
                <span class="text-gray-500">/</span>
            </li>
        @endif

        @if(is_array($item) && isset($item['url']))
            <li class="breadcrumb-item text-gray-500">
                <a href="{{ $item['url'] }}" class="text-gray-500 text-hover-primary">{{ $item['label'] }}</a>
            </li>
        @elseif(is_array($item))
            <li class="breadcrumb-item text-gray-500">{{ $item['label'] }}</li>
        @else
            <li class="breadcrumb-item text-gray-500">{{ $item }}</li>
        @endif
    @endforeach
</ul>
@endif
