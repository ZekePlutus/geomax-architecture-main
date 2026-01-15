{{--
    Metronic Floating Label Textarea Component
    
    Documentation: 
    - Bootstrap Floating Labels: https://getbootstrap.com/docs/5.3/forms/floating-labels/
    - Metronic Forms: https://preview.keenthemes.com/html/metronic/docs/?page=base/forms/controls
    
    Usage:
    <x-form.textarea.floating 
        name="description" 
        label="Description" 
        placeholder="Enter description..."
    />
    
    With Pre-filled Value (auto-resizes to fit content):
    <x-form.textarea.floating 
        name="value_description" 
        label="Description" 
        value="Pre-filled content..."
    />
    
    Features:
    - Auto-resizes to fit pre-filled content on load
    - Auto-resizes as user types
    - Floating label animation
    - All Metronic variants supported (solid, transparent, flush)
--}}

@props([
    // Field & Labels
    'name',
    'id' => null,
    'label' => null,
    'hint' => null,                  // Help text below textarea
    'tooltip' => null,               // Tooltip text for help icon
    'placeholder' => ' ',            // Required for floating label (space by default)
    
    // Value
    'value' => '',
    
    // Metronic Styles
    'variant' => 'solid',            // solid, transparent, flush
    'size' => null,                  // sm, lg
    'wrapperClass' => '',            // Additional class for wrapper
    'textareaClass' => '',           // Additional class for textarea
    
    // Sizing
    'rows' => 3,                     // Initial rows
    'minRows' => 2,                  // Minimum rows for auto-resize
    'maxRows' => null,               // Maximum rows for auto-resize (null = unlimited)
    'autoResize' => true,            // Enable auto-resize to fit content
    
    // States
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    
    // HTML5 Constraints
    'minlength' => null,
    'maxlength' => null,
    
    // Validation
    'error' => null,                 // Manual error message
    'errorBag' => 'default',         // Laravel error bag
])

@php
    // Generate unique ID
    $textareaId = $id ?? ($name ? str_replace(['[', ']', '.'], '_', $name) . '_floating' : 'textarea_' . \Illuminate\Support\Str::uuid());
    
    // Build form-control classes
    $formControlClass = 'form-control';
    
    if ($variant === 'solid') {
        $formControlClass .= ' form-control-solid';
    } elseif ($variant === 'transparent') {
        $formControlClass .= ' form-control-transparent';
    } elseif ($variant === 'flush') {
        $formControlClass .= ' form-control-flush';
    }
    
    // Size classes
    if ($size === 'sm') {
        $formControlClass .= ' form-control-sm';
    } elseif ($size === 'lg') {
        $formControlClass .= ' form-control-lg';
    }
    
    // Error state
    $hasError = $error || $errors->{$errorBag}->has($name ?? '');
    if ($hasError) {
        $formControlClass .= ' is-invalid';
    }
    
    // Additional classes
    $formControlClass .= ' ' . $textareaClass;
    
    // Get current value
    $currentValue = old($name ?? '', $value);
    
    // Calculate line height for auto-resize
    $lineHeight = match($size) {
        'sm' => 20,
        'lg' => 28,
        default => 24,
    };
    
    // Padding for floating label textarea
    $paddingTop = match($size) {
        'sm' => 24,
        'lg' => 32,
        default => 28,
    };
    $paddingBottom = match($size) {
        'sm' => 8,
        'lg' => 12,
        default => 10,
    };
@endphp

<div class="mb-5 {{ $wrapperClass }}">
    <div class="form-floating">
        <textarea 
            name="{{ $name }}" 
            id="{{ $textareaId }}"
            class="{{ trim($formControlClass) }}"
            placeholder="{{ $placeholder }}"
            rows="{{ $rows }}"
            @if($autoResize) 
                data-auto-resize="true"
                data-min-rows="{{ $minRows }}"
                @if($maxRows) data-max-rows="{{ $maxRows }}" @endif
                data-line-height="{{ $lineHeight }}"
                data-padding-top="{{ $paddingTop }}"
                data-padding-bottom="{{ $paddingBottom }}"
                style="overflow-y: hidden; resize: none;"
            @endif
            @if(!is_null($minlength)) minlength="{{ $minlength }}" @endif
            @if(!is_null($maxlength)) maxlength="{{ $maxlength }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes }}
        >{{ $currentValue }}</textarea>
        
        {{-- Floating Label --}}
        <label for="{{ $textareaId }}" class="{{ $required ? 'required' : '' }}">
            {{ $label }}
            @if($tooltip)
            <span class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}">
                <i class="ki-outline ki-information-5 text-gray-500 fs-7" style="cursor: help;"></i>
            </span>
            @endif
        </label>
    </div>

    {{-- Hint text --}}
    @if($hint)
    <div class="form-text text-muted">{{ $hint }}</div>
    @endif

    {{-- Character counter when maxlength is set --}}
    @if($maxlength)
    <div class="form-text text-muted text-end">
        <span id="{{ $textareaId }}_counter">{{ strlen($currentValue) }}</span>/{{ $maxlength }}
    </div>
    @endif

    {{-- Error message --}}
    @if($error)
    <div class="invalid-feedback d-block">{{ $error }}</div>
    @elseif($errors->{$errorBag}->has($name ?? ''))
    <div class="invalid-feedback d-block">{{ $errors->{$errorBag}->first($name) }}</div>
    @endif
</div>

{{-- Auto-resize Script (loaded once) --}}
@if($autoResize)
@once
@push('scripts')
<script>
(function() {
    function autoResizeTextarea(textarea) {
        const minRows = parseInt(textarea.dataset.minRows) || 2;
        const maxRows = textarea.dataset.maxRows ? parseInt(textarea.dataset.maxRows) : null;
        const lineHeight = parseInt(textarea.dataset.lineHeight) || 24;
        const paddingTop = parseInt(textarea.dataset.paddingTop) || 28;
        const paddingBottom = parseInt(textarea.dataset.paddingBottom) || 10;
        
        function resize() {
            // Reset height to calculate actual scrollHeight
            textarea.style.height = 'auto';
            
            // Calculate content height
            const scrollHeight = textarea.scrollHeight;
            
            // Calculate min/max heights
            const minHeight = (minRows * lineHeight) + paddingTop + paddingBottom;
            const maxHeight = maxRows ? (maxRows * lineHeight) + paddingTop + paddingBottom : Infinity;
            
            // Apply constrained height
            const newHeight = Math.min(Math.max(scrollHeight, minHeight), maxHeight);
            textarea.style.height = newHeight + 'px';
            
            // Show/hide scrollbar based on content overflow
            textarea.style.overflowY = scrollHeight > maxHeight ? 'auto' : 'hidden';
        }
        
        // Resize on input
        textarea.addEventListener('input', resize);
        
        // Resize on window resize (for responsive layouts)
        window.addEventListener('resize', resize);
        
        // Initial resize (for pre-filled content)
        // Use requestAnimationFrame to ensure DOM is fully rendered
        requestAnimationFrame(() => {
            resize();
            // Double-check after fonts are loaded
            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(resize);
            }
        });
        
        // Store cleanup function
        textarea._autoResizeCleanup = () => {
            textarea.removeEventListener('input', resize);
            window.removeEventListener('resize', resize);
        };
        
        // Mark as initialized
        textarea.dataset.autoResizeInitialized = 'true';
    }
    
    function initAutoResize() {
        document.querySelectorAll('textarea[data-auto-resize="true"]:not([data-auto-resize-initialized])').forEach(textarea => {
            autoResizeTextarea(textarea);
        });
    }
    
    // Init on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAutoResize);
    } else {
        initAutoResize();
    }
    
    // Support Livewire/Turbo/dynamic content
    document.addEventListener('livewire:navigated', initAutoResize);
    document.addEventListener('turbo:load', initAutoResize);
    
    // Expose for manual re-init
    window.initAutoResizeTextareas = initAutoResize;
})();
</script>
@endpush
@endonce
@endif

{{-- Character counter script --}}
@if($maxlength)
@push('scripts')
<script>
(function() {
    const textarea = document.getElementById('{{ $textareaId }}');
    const counter = document.getElementById('{{ $textareaId }}_counter');
    
    if (textarea && counter) {
        textarea.addEventListener('input', function() {
            counter.textContent = this.value.length;
        });
    }
})();
</script>
@endpush
@endif
