<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo e(asset('assets/media/logos/favicon.ico')); ?>" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

   

    <!-- Global Stylesheets -->
    <link href="<?php echo e(asset('assets/css/plugins.bundle.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/style.bundle.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/custom.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet" type="text/css" />

    <?php echo $__env->yieldPushContent('styles'); ?>
</head><?php /**PATH /home/anass/public_html/resources/views/layout50/includes/head.blade.php ENDPATH**/ ?>