{{--
    Custom cell view for active toggle
    Receives: $row, $value, $column, $index
--}}
<div class="form-check form-switch">
    <input class="form-check-input" type="checkbox" {{ $value ? 'checked' : '' }} disabled>
</div>
