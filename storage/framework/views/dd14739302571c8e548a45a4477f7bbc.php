<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['items' => []]));

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

foreach (array_filter((['items' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(count($items) > 0): ?>
<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-base my-1">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($index > 0): ?>
            <li class="breadcrumb-item">
                <span class="text-gray-500">/</span>
            </li>
        <?php endif; ?>

        <?php if(is_array($item) && isset($item['url'])): ?>
            <li class="breadcrumb-item text-gray-500">
                <a href="<?php echo e($item['url']); ?>" class="text-gray-500 text-hover-primary"><?php echo e($item['label']); ?></a>
            </li>
        <?php elseif(is_array($item)): ?>
            <li class="breadcrumb-item text-gray-500"><?php echo e($item['label']); ?></li>
        <?php else: ?>
            <li class="breadcrumb-item text-gray-500"><?php echo e($item); ?></li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php endif; ?>
<?php /**PATH /home/anass/public_html/resources/views/components/breadcrumb.blade.php ENDPATH**/ ?>