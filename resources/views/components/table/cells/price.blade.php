{{--
    Custom cell view for price column
    Receives: $row, $value, $column, $index
--}}
<span class="fw-bold {{ $value > 500 ? 'text-success' : 'text-muted' }}">
    ${{ number_format($value, 2) }}
</span>
