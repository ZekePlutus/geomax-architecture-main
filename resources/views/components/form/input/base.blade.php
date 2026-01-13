{{--
    Metronic Form Input Component
    
    Documentation: https://preview.keenthemes.com/html/metronic/docs/?page=base/forms/controls
    
    Usage:
    <x-form.input.base 
        name="email" 
        label="Email Address" 
        type="email"
        placeholder="name@example.com"
        icon="ki-outline ki-sms"
    />
    
    Sizes: sm, lg (default is normal)
    Types: text, email, number, password, url, tel, date, datetime-local, time, month, week, color, search
--}}

@props([
    // Field & Labels
    'name',
    'id' => null,
    'label' => null,
    'hint' => null,                  // Help text below input
    'tooltip' => null,               // Tooltip text for help icon
    'placeholder' => '',
    
    // Value and Type
    'type' => 'text',                // text|email|number|password|url|tel|date|datetime-local|time|month|week|color|search
    'value' => '',
    'autocomplete' => 'off',
    
    // Metronic Styles
    'variant' => 'solid',            // solid, transparent, flush
    'size' => null,                  // sm, lg
    'wrapperClass' => '',            // Additional class for wrapper
    'inputClass' => '',              // Additional class for input
    
    // Input Group (Icons & Addons)
    'icon' => null,                  // Icon class: ki-outline ki-user
    'iconPosition' => 'start',       // start, end
    'prepend' => null,               // Text/HTML to prepend (input group)
    'append' => null,                // Text/HTML to append (input group)
    
    // States
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    
    // HTML5 Constraints
    'min' => null,
    'max' => null,
    'step' => null,
    'minlength' => null,
    'maxlength' => null,
    'pattern' => null,
    'inputmode' => null,             // numeric, decimal, tel, email, url, search
    'dir' => null,                   // rtl, ltr
    
    // Input Mask (jQuery Mask Plugin)
    'mask' => null,                  // Mask pattern (e.g., '000.000.000-00', '(00) 00000-0000')
    'maskOptions' => null,           // Additional options for jQuery Mask Plugin
    
    // Validation
    'error' => null,                 // Manual error message
    'errorBag' => 'default',         // Laravel error bag
])

@php
    // Generate unique ID
    $inputId = $id ?? ($name ? str_replace(['[', ']', '.'], '_', $name) : 'input_' . \Illuminate\Support\Str::uuid());
    
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
    $formControlClass .= ' ' . $inputClass;
    
    // Determine if we need input group
    $hasInputGroup = $icon || $prepend || $append;
    
    // Input group classes (Metronic specific)
    $inputGroupClass = 'input-group input-group-solid';
    if ($size === 'sm') {
        $inputGroupClass .= ' input-group-sm';
    } elseif ($size === 'lg') {
        $inputGroupClass .= ' input-group-lg';
    }
    
    // Check if mask is needed
    $needsMask = !empty($mask) || !empty($maskOptions);
@endphp

{{-- jQuery Mask Plugin (loaded once) --}}
@if($needsMask)
@once
@push('scripts')
<script>
// Wait for jQuery to be available before loading mask plugin
(function waitForJQuery() {
    if (typeof jQuery !== 'undefined') {
        var script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js';
        script.onload = function() {
            window.maskPluginReady = true;
            jQuery(document).trigger('maskPluginReady');
        };
        document.head.appendChild(script);
    } else {
        setTimeout(waitForJQuery, 50);
    }
})();
</script>
@endpush
@endonce
@endif

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

    @if($hasInputGroup)
    {{-- Input with icon/prepend/append --}}
    <div class="{{ $inputGroupClass }}">
        {{-- Prepend text --}}
        @if($prepend)
        <span class="input-group-text">{!! $prepend !!}</span>
        @endif

        {{-- Icon at start --}}
        @if($icon && $iconPosition === 'start')
        <span class="input-group-text">
            <i class="{{ $icon }}"></i>
        </span>
        @endif

        {{-- Input field --}}
        <input 
            type="{{ $type }}" 
            name="{{ $name }}" 
            id="{{ $inputId }}"
            class="{{ trim($formControlClass) }}"
            placeholder="{{ $placeholder }}"
            value="{{ old($name ?? '', $value) }}"
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if(!is_null($min)) min="{{ $min }}" @endif
            @if(!is_null($max)) max="{{ $max }}" @endif
            @if(!is_null($step)) step="{{ $step }}" @endif
            @if(!is_null($minlength)) minlength="{{ $minlength }}" @endif
            @if(!is_null($maxlength)) maxlength="{{ $maxlength }}" @endif
            @if($pattern) pattern="{{ $pattern }}" @endif
            @if($inputmode) inputmode="{{ $inputmode }}" @endif
            @if($dir) dir="{{ $dir }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            {{ $attributes }}
        />

        {{-- Icon at end --}}
        @if($icon && $iconPosition === 'end')
        <span class="input-group-text">
            <i class="{{ $icon }}"></i>
        </span>
        @endif

        {{-- Append text --}}
        @if($append)
        <span class="input-group-text">{!! $append !!}</span>
        @endif
    </div>
    @else
    {{-- Simple input without icon --}}
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $inputId }}"
        class="{{ trim($formControlClass) }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name ?? '', $value) }}"
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        @if(!is_null($min)) min="{{ $min }}" @endif
        @if(!is_null($max)) max="{{ $max }}" @endif
        @if(!is_null($step)) step="{{ $step }}" @endif
        @if(!is_null($minlength)) minlength="{{ $minlength }}" @endif
        @if(!is_null($maxlength)) maxlength="{{ $maxlength }}" @endif
        @if($pattern) pattern="{{ $pattern }}" @endif
        @if($inputmode) inputmode="{{ $inputmode }}" @endif
        @if($dir) dir="{{ $dir }}" @endif
        @if($required) required @endif
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        {{ $attributes }}
    />
    @endif

    {{-- Hint text --}}
    @if($hint)
    <div class="form-text text-muted">{{ $hint }}</div>
    @endif

    {{-- Error message --}}
    @if($error)
    <div class="invalid-feedback d-block">{{ $error }}</div>
    @elseif($errors->{$errorBag}->has($name ?? ''))
    <div class="invalid-feedback d-block">{{ $errors->{$errorBag}->first($name) }}</div>
    @endif
</div>

{{-- Input Mask Initialization --}}
@if($needsMask)
@push('scripts')
<script>
(function() {
    function initMask_{{ str_replace(['-', '.'], '_', $inputId) }}() {
        if (!window.maskPluginReady || typeof jQuery === 'undefined' || typeof jQuery.fn.mask === 'undefined') return false;
        try {
            @if($mask)
            jQuery('#{{ $inputId }}').mask('{{ $mask }}', @json($maskOptions ?? new stdClass()));
            @elseif($maskOptions)
            jQuery('#{{ $inputId }}').mask(@json($maskOptions));
            @endif
            return true;
        } catch (e) {
            console.warn('Mask init failed for {{ $inputId }}:', e);
            return false;
        }
    }
    
    function waitAndInit() {
        if (typeof jQuery !== 'undefined') {
            if (window.maskPluginReady) {
                initMask_{{ str_replace(['-', '.'], '_', $inputId) }}();
            } else {
                jQuery(document).one('maskPluginReady', initMask_{{ str_replace(['-', '.'], '_', $inputId) }});
            }
        } else {
            setTimeout(waitAndInit, 50);
        }
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', waitAndInit);
    } else {
        waitAndInit();
    }
})();
</script>
@endpush
@endif
