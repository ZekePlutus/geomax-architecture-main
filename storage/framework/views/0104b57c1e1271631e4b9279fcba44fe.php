

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
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
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
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
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
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
?>


<?php if($needsMask): ?>
<?php if (! $__env->hasRenderedOnce('2044fb81-3e59-4d79-b8e5-f2b4f7d32305')): $__env->markAsRenderedOnce('2044fb81-3e59-4d79-b8e5-f2b4f7d32305'); ?>
<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php endif; ?>

<div class="mb-5 <?php echo e($wrapperClass); ?>">
    
    <?php if($label): ?>
    <label for="<?php echo e($inputId); ?>" class="form-label <?php echo e($required ? 'required' : ''); ?>">
        <?php echo e($label); ?>

        <?php if($tooltip): ?>
        <span class="ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e($tooltip); ?>">
            <i class="ki-outline ki-information-5 text-gray-500 fs-7" style="cursor: help;"></i>
        </span>
        <?php endif; ?>
    </label>
    <?php endif; ?>

    <?php if($hasInputGroup): ?>
    
    <div class="<?php echo e($inputGroupClass); ?>">
        
        <?php if($prepend): ?>
        <span class="input-group-text"><?php echo $prepend; ?></span>
        <?php endif; ?>

        
        <?php if($icon && $iconPosition === 'start'): ?>
        <span class="input-group-text">
            <i class="<?php echo e($icon); ?>"></i>
        </span>
        <?php endif; ?>

        
        <input 
            type="<?php echo e($type); ?>" 
            name="<?php echo e($name); ?>" 
            id="<?php echo e($inputId); ?>"
            class="<?php echo e(trim($formControlClass)); ?>"
            placeholder="<?php echo e($placeholder); ?>"
            value="<?php echo e(old($name ?? '', $value)); ?>"
            <?php if($autocomplete): ?> autocomplete="<?php echo e($autocomplete); ?>" <?php endif; ?>
            <?php if(!is_null($min)): ?> min="<?php echo e($min); ?>" <?php endif; ?>
            <?php if(!is_null($max)): ?> max="<?php echo e($max); ?>" <?php endif; ?>
            <?php if(!is_null($step)): ?> step="<?php echo e($step); ?>" <?php endif; ?>
            <?php if(!is_null($minlength)): ?> minlength="<?php echo e($minlength); ?>" <?php endif; ?>
            <?php if(!is_null($maxlength)): ?> maxlength="<?php echo e($maxlength); ?>" <?php endif; ?>
            <?php if($pattern): ?> pattern="<?php echo e($pattern); ?>" <?php endif; ?>
            <?php if($inputmode): ?> inputmode="<?php echo e($inputmode); ?>" <?php endif; ?>
            <?php if($dir): ?> dir="<?php echo e($dir); ?>" <?php endif; ?>
            <?php if($required): ?> required <?php endif; ?>
            <?php if($disabled): ?> disabled <?php endif; ?>
            <?php if($readonly): ?> readonly <?php endif; ?>
            <?php echo e($attributes); ?>

        />

        
        <?php if($icon && $iconPosition === 'end'): ?>
        <span class="input-group-text">
            <i class="<?php echo e($icon); ?>"></i>
        </span>
        <?php endif; ?>

        
        <?php if($append): ?>
        <span class="input-group-text"><?php echo $append; ?></span>
        <?php endif; ?>
    </div>
    <?php else: ?>
    
    <input 
        type="<?php echo e($type); ?>" 
        name="<?php echo e($name); ?>" 
        id="<?php echo e($inputId); ?>"
        class="<?php echo e(trim($formControlClass)); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        value="<?php echo e(old($name ?? '', $value)); ?>"
        <?php if($autocomplete): ?> autocomplete="<?php echo e($autocomplete); ?>" <?php endif; ?>
        <?php if(!is_null($min)): ?> min="<?php echo e($min); ?>" <?php endif; ?>
        <?php if(!is_null($max)): ?> max="<?php echo e($max); ?>" <?php endif; ?>
        <?php if(!is_null($step)): ?> step="<?php echo e($step); ?>" <?php endif; ?>
        <?php if(!is_null($minlength)): ?> minlength="<?php echo e($minlength); ?>" <?php endif; ?>
        <?php if(!is_null($maxlength)): ?> maxlength="<?php echo e($maxlength); ?>" <?php endif; ?>
        <?php if($pattern): ?> pattern="<?php echo e($pattern); ?>" <?php endif; ?>
        <?php if($inputmode): ?> inputmode="<?php echo e($inputmode); ?>" <?php endif; ?>
        <?php if($dir): ?> dir="<?php echo e($dir); ?>" <?php endif; ?>
        <?php if($required): ?> required <?php endif; ?>
        <?php if($disabled): ?> disabled <?php endif; ?>
        <?php if($readonly): ?> readonly <?php endif; ?>
        <?php echo e($attributes); ?>

    />
    <?php endif; ?>

    
    <?php if($hint): ?>
    <div class="form-text text-muted"><?php echo e($hint); ?></div>
    <?php endif; ?>

    
    <?php if($error): ?>
    <div class="invalid-feedback d-block"><?php echo e($error); ?></div>
    <?php elseif($errors->{$errorBag}->has($name ?? '')): ?>
    <div class="invalid-feedback d-block"><?php echo e($errors->{$errorBag}->first($name)); ?></div>
    <?php endif; ?>
</div>


<?php if($needsMask): ?>
<?php $__env->startPush('scripts'); ?>
<script>
(function() {
    function initMask_<?php echo e(str_replace(['-', '.'], '_', $inputId)); ?>() {
        if (!window.maskPluginReady || typeof jQuery === 'undefined' || typeof jQuery.fn.mask === 'undefined') return false;
        try {
            <?php if($mask): ?>
            jQuery('#<?php echo e($inputId); ?>').mask('<?php echo e($mask); ?>', <?php echo json_encode($maskOptions ?? new stdClass(), 15, 512) ?>);
            <?php elseif($maskOptions): ?>
            jQuery('#<?php echo e($inputId); ?>').mask(<?php echo json_encode($maskOptions, 15, 512) ?>);
            <?php endif; ?>
            return true;
        } catch (e) {
            console.warn('Mask init failed for <?php echo e($inputId); ?>:', e);
            return false;
        }
    }
    
    function waitAndInit() {
        if (typeof jQuery !== 'undefined') {
            if (window.maskPluginReady) {
                initMask_<?php echo e(str_replace(['-', '.'], '_', $inputId)); ?>();
            } else {
                jQuery(document).one('maskPluginReady', initMask_<?php echo e(str_replace(['-', '.'], '_', $inputId)); ?>);
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
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /home/anass/public_html/resources/views/components/form/input/base.blade.php ENDPATH**/ ?>