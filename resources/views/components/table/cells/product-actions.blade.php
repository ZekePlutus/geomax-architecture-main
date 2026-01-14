{{--
    Custom actions view for product rows
    Receives: $row, $index
--}}
<div class="d-flex justify-content-end gap-2">
    <a href="#edit-{{ $row['id'] }}" class="btn btn-sm btn-icon btn-light-primary" title="Edit {{ $row['name'] }}">
        <i class="ki-outline ki-pencil"></i>
    </a>
    <button class="btn btn-sm btn-icon btn-light-danger" onclick="alert('Delete {{ $row['name'] }}?')" title="Delete">
        <i class="ki-outline ki-trash"></i>
    </button>
</div>
