{{--
    Metronic Form Input Component
    
    Documentation: 
    - https://preview.keenthemes.com/html/metronic/docs/?page=base/forms/controls
    - https://preview.keenthemes.com/html/metronic/docs/?page=base/forms/input-group
    
    Usage:
    <x-form.input.base 
        name="email" 
        label="Email Address" 
        type="email"
        placeholder="name@example.com"
        icon="ki-outline ki-sms"
    />
    
    Input Group Examples:
    <x-form.input.base name="username" prepend="@" />
    <x-form.input.base name="email" append="@example.com" />
    <x-form.input.base name="price" prepend="$" append=".00" />
    <x-form.input.base name="url" prependIcon="ki-outline ki-globe" />
    <x-form.input.base name="search" appendButton="Search" appendButtonClass="btn-primary" />
    
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
    'prependIcon' => null,           // Icon class for prepend: ki-outline ki-user
    'append' => null,                // Text/HTML to append (input group)
    'appendIcon' => null,            // Icon class for append: ki-outline ki-sms
    'appendButton' => null,          // Button text to append
    'appendButtonClass' => 'btn-secondary', // Button class (btn-primary, btn-light, etc.)
    'appendButtonType' => 'button',  // Button type: button, submit
    'appendButtonId' => null,        // Button ID for JS hooks
    'prependButton' => null,         // Button text to prepend
    'prependButtonClass' => 'btn-secondary', // Prepend button class
    'prependButtonType' => 'button', // Prepend button type
    'prependButtonId' => null,       // Prepend button ID
    'inputGroupVariant' => null,     // null (default), solid
    
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
    $hasInputGroup = $icon || $prepend || $append || $prependIcon || $appendIcon || $appendButton || $prependButton;
    
    // Input group classes (Metronic specific)
    $inputGroupClass = 'input-group';
    if ($inputGroupVariant === 'solid' || $variant === 'solid') {
        $inputGroupClass .= ' input-group-solid';
    }
    if ($size === 'sm') {
        $inputGroupClass .= ' input-group-sm';
    } elseif ($size === 'lg') {
        $inputGroupClass .= ' input-group-lg';
    }
    
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

    @if($hasInputGroup)
    {{-- Input with icon/prepend/append --}}
    <div class="{{ $inputGroupClass }}">
        {{-- Prepend button --}}
        @if($prependButton)
        <button class="btn {{ $prependButtonClass }}" type="{{ $prependButtonType }}" @if($prependButtonId) id="{{ $prependButtonId }}" @endif>
            {!! $prependButton !!}
        </button>
        @endif

        {{-- Prepend icon --}}
        @if($prependIcon)
        <span class="input-group-text">
            <i class="{{ $prependIcon }}"></i>
        </span>
        @endif

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
            @if($mask) data-mask="{{ $mask }}" @endif
            @if($maskOptions) data-mask-options='@json($maskOptions)' @endif
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

        {{-- Append icon --}}
        @if($appendIcon)
        <span class="input-group-text">
            <i class="{{ $appendIcon }}"></i>
        </span>
        @endif

        {{-- Append button --}}
        @if($appendButton)
        <button class="btn {{ $appendButtonClass }}" type="{{ $appendButtonType }}" @if($appendButtonId) id="{{ $appendButtonId }}" @endif>
            {!! $appendButton !!}
        </button>
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
        @if($mask) data-mask="{{ $mask }}" @endif
        @if($maskOptions) data-mask-options='@json($maskOptions)' @endif
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

{{-- Global Mask Initializer (loaded once, library-agnostic) --}}
@if($mask || $maskOptions)
@once
@push('scripts')
<script>
(function() {
    // Mask definitions: 0 = digit, A = alpha, S = alphanumeric
    const MASK_TOKENS = { '0': /\d/, 'A': /[a-zA-Z]/, 'S': /[a-zA-Z0-9]/ };
    
    function applyMask(input, pattern, options = {}) {
        const tokens = { ...MASK_TOKENS, ...(options.tokens || {}) };
        
        function format(value) {
            let result = '', valueIndex = 0;
            const cleanValue = value.replace(/[^a-zA-Z0-9]/g, '');
            
            for (let i = 0; i < pattern.length && valueIndex < cleanValue.length; i++) {
                const maskChar = pattern[i];
                if (tokens[maskChar]) {
                    if (tokens[maskChar].test(cleanValue[valueIndex])) {
                        result += cleanValue[valueIndex++];
                    } else {
                        valueIndex++;
                        i--;
                    }
                } else {
                    result += maskChar;
                    if (cleanValue[valueIndex] === maskChar) valueIndex++;
                }
            }
            return result;
        }
        
        function handleInput(e) {
            const pos = input.selectionStart;
            const oldLen = input.value.length;
            input.value = format(input.value);
            const newLen = input.value.length;
            const newPos = Math.max(0, pos + (newLen - oldLen));
            input.setSelectionRange(newPos, newPos);
        }
        
        input.addEventListener('input', handleInput);
        input.addEventListener('focus', () => { if (input.value) input.value = format(input.value); });
        if (input.value) input.value = format(input.value);
        
        // Store cleanup function
        input._maskCleanup = () => {
            input.removeEventListener('input', handleInput);
        };
    }
    
    function initMasks() {
        document.querySelectorAll('[data-mask]:not([data-mask-initialized])').forEach(input => {
            const mask = input.dataset.mask;
            let options = {};
            try { options = JSON.parse(input.dataset.maskOptions || '{}'); } catch(e) {}
            applyMask(input, mask, options);
            input.dataset.maskInitialized = 'true';
        });
    }
    
    // Init on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMasks);
    } else {
        initMasks();
    }
    
    // Support Livewire/Turbo/dynamic content
    document.addEventListener('livewire:navigated', initMasks);
    document.addEventListener('turbo:load', initMasks);
    
    // Expose for manual re-init
    window.initInputMasks = initMasks;
})();
</script>
@endpush
@endonce
@endif
