{{--
    Metronic Form Range Component
    
    Documentation: https://preview.keenthemes.com/html/metronic/docs/?page=base/forms/controls
    
    Usage:
    <x-form.range.base 
        name="volume" 
        label="Volume Level"
        min="0"
        max="100"
        value="50"
    />
    
    With value display:
    <x-form.range.base 
        name="brightness" 
        label="Brightness"
        :showValue="true"
        suffix="%"
    />
    
    With ticks/steps:
    <x-form.range.base 
        name="rating" 
        label="Rating"
        min="1"
        max="5"
        step="1"
        :showTicks="true"
    />
--}}

@props([
    // Field & Labels
    'name',
    'id' => null,
    'label' => null,
    'hint' => null,                  // Help text below input
    'tooltip' => null,               // Tooltip text for help icon
    
    // Value
    'value' => null,
    'min' => 0,
    'max' => 100,
    'step' => 1,
    
    // Metronic Styles
    'wrapperClass' => '',            // Additional class for wrapper
    'inputClass' => '',              // Additional class for input
    
    // Display Options
    'showValue' => false,            // Show current value
    'valuePosition' => 'end',        // start, end, top
    'prefix' => '',                  // Value prefix (e.g., '$')
    'suffix' => '',                  // Value suffix (e.g., '%', 'px')
    'showMinMax' => false,           // Show min/max labels below range
    'showTicks' => false,            // Show tick marks
    
    // States
    'required' => false,
    'disabled' => false,
    
    // Validation
    'error' => null,                 // Manual error message
    'errorBag' => 'default',         // Laravel error bag
])

@php
    // Generate unique ID
    $inputId = $id ?? ($name ? str_replace(['[', ']', '.'], '_', $name) : 'range_' . \Illuminate\Support\Str::uuid());
    
    // Build form-range classes
    $formRangeClass = 'form-range';
    
    // Error state
    $hasError = $error || $errors->{$errorBag}->has($name ?? '');
    if ($hasError) {
        $formRangeClass .= ' is-invalid';
    }
    
    // Additional classes
    $formRangeClass .= ' ' . $inputClass;
    
    // Get current value
    $currentValue = old($name ?? '', $value ?? $min);
    
    // Calculate tick count for showTicks
    $tickCount = $showTicks ? floor(($max - $min) / $step) + 1 : 0;
@endphp

<div class="mb-5 {{ $wrapperClass }}">
    {{-- Label with optional tooltip --}}
    @if($label)
    <label for="{{ $inputId }}" class="form-label {{ $required ? 'required' : '' }}">
        {{ $label }}
        @if($tooltip)
        <span class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}">
            <i class="ki-outline ki-information-5 text-gray-500 fs-7" style="cursor: help;"></i>
        </span>
        @endif
    </label>
    @endif

    {{-- Value display at top --}}
    @if($showValue && $valuePosition === 'top')
    <div class="text-center mb-2">
        <span class="badge badge-light-primary fs-6" data-range-value="{{ $inputId }}">{{ $prefix }}{{ $currentValue }}{{ $suffix }}</span>
    </div>
    @endif

    {{-- Range container --}}
    <div class="d-flex align-items-center gap-3">
        {{-- Value at start --}}
        @if($showValue && $valuePosition === 'start')
        <span class="fw-semibold text-gray-700 min-w-40px text-end" data-range-value="{{ $inputId }}">{{ $prefix }}{{ $currentValue }}{{ $suffix }}</span>
        @endif

        {{-- Range input wrapper --}}
        <div class="flex-grow-1">
            <input 
                type="range" 
                name="{{ $name }}" 
                id="{{ $inputId }}"
                class="{{ trim($formRangeClass) }}"
                value="{{ $currentValue }}"
                min="{{ $min }}"
                max="{{ $max }}"
                step="{{ $step }}"
                @if($required) required @endif
                @if($disabled) disabled @endif
                {{ $attributes }}
                @if($showValue) data-range-display="{{ $inputId }}" @endif
            />
            
            {{-- Tick marks --}}
            @if($showTicks && $tickCount > 1 && $tickCount <= 20)
            <div class="d-flex justify-content-between px-1 mt-1">
                @for($i = 0; $i < $tickCount; $i++)
                <span class="text-muted fs-9">|</span>
                @endfor
            </div>
            @endif
            
            {{-- Min/Max labels --}}
            @if($showMinMax)
            <div class="d-flex justify-content-between mt-1">
                <span class="text-muted fs-8">{{ $prefix }}{{ $min }}{{ $suffix }}</span>
                <span class="text-muted fs-8">{{ $prefix }}{{ $max }}{{ $suffix }}</span>
            </div>
            @endif
        </div>

        {{-- Value at end --}}
        @if($showValue && $valuePosition === 'end')
        <span class="fw-semibold text-gray-700 min-w-40px" data-range-value="{{ $inputId }}">{{ $prefix }}{{ $currentValue }}{{ $suffix }}</span>
        @endif
    </div>

    {{-- Hint text --}}
    @if($hint)
    <div class="form-text text-muted mt-2">{{ $hint }}</div>
    @endif

    {{-- Error message --}}
    @if($error)
    <div class="invalid-feedback d-block">{{ $error }}</div>
    @elseif($errors->{$errorBag}->has($name ?? ''))
    <div class="invalid-feedback d-block">{{ $errors->{$errorBag}->first($name) }}</div>
    @endif
</div>

{{-- Range Value Display Script (loaded once) --}}
@if($showValue)
@once
@push('scripts')
<script>
(function() {
    function initRangeDisplays() {
        document.querySelectorAll('[data-range-display]:not([data-range-initialized])').forEach(function(range) {
            const displayId = range.dataset.rangeDisplay;
            const displays = document.querySelectorAll('[data-range-value="' + displayId + '"]');
            
            if (displays.length === 0) return;
            
            // Get prefix/suffix from initial display
            const initialText = displays[0].textContent;
            const initialValue = range.value;
            const prefix = initialText.substring(0, initialText.indexOf(initialValue));
            const suffix = initialText.substring(initialText.indexOf(initialValue) + initialValue.length);
            
            function updateDisplay() {
                displays.forEach(function(display) {
                    display.textContent = prefix + range.value + suffix;
                });
            }
            
            range.addEventListener('input', updateDisplay);
            range.dataset.rangeInitialized = 'true';
        });
    }
    
    // Init on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRangeDisplays);
    } else {
        initRangeDisplays();
    }
    
    // Support Livewire/Turbo/dynamic content
    document.addEventListener('livewire:navigated', initRangeDisplays);
    document.addEventListener('turbo:load', initRangeDisplays);
    
    // Expose for manual re-init
    window.initRangeDisplays = initRangeDisplays;
})();
</script>
@endpush
@endonce
@endif