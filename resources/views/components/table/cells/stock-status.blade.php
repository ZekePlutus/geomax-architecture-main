{{--
    Custom cell view for stock status
    Receives: $row, $value, $column, $index
--}}
@if($value > 20)
    <span class="badge badge-light-success">In Stock ({{ $value }})</span>
@elseif($value > 0)
    <span class="badge badge-light-warning">Low Stock ({{ $value }})</span>
@else
    <span class="badge badge-light-danger">Out of Stock</span>
@endif
