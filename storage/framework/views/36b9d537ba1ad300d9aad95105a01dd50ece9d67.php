<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?php if (! empty(trim($__env->yieldContent('title')))): ?><?php echo $__env->yieldContent('title'); ?> - <?php endif; ?> پنل مدیریت</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('public/modules/dashboard/admin/img/base/favicon.svg')); ?>">

    
    <link href="<?php echo e(asset('public/modules/dashboard/admin/css/notifi/style.css')); ?>" rel="stylesheet" type="text/css">

    
    <link href="<?php echo e(asset('public/modules/dashboard/admin/plugins/chosen.jquery/css/chosen.min.css')); ?>" rel="stylesheet" type="text/css">

    
    <link href="<?php echo e(asset('public/modules/dashboard/admin/css/admin-style.min.css')); ?>" rel="stylesheet" type="text/css">

    <?php echo $__env->yieldContent('lib'); ?>
</head>
<body>
<main class="main-admin">
    <div class="row no-gutters">
        <aside class="col-2 sidebar-col">
            <div class="sidebar">
                <div class="sidebar CustomScrollbar">
                    <?php echo $__env->make('dashboard::layouts.dashboard.section.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->yieldContent('sidebar'); ?>
                </div>
                <span class="version">MD CMS - v<?php echo e(env('APP_VERSION')); ?></span> <span class="update">Last Update: <?php echo e(env('APP_LAST_VERSION')); ?></span>
            </div>
        </aside>

        <article class="col-10 content-page content-block">
            <div class="heading-content-section">
                <div class="heading-inner">
                    <div class="row align-items-center">
                        <div class="col-7">
                            <h2 class="title-page"><?php echo $__env->yieldContent('title-page'); ?></h2>
                        </div>
                        <div class="col-5 left head-btn-col">
                            <div class="header-btn profile-btn">
                                <div class="icon">
                                    <i class="zmdi zmdi-account-o"></i>
                                </div>

                                <div class="menu-drop-down-header">
                                    <ul>
                                        <li>
                                            <a href="<?php echo e(Url('dashboard/users/' . auth()->user()->id . '/edit')); ?>"> <span class="text">ویرایش حساب</span> <i class="zmdi zmdi-account-box-o"></i> </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <span class="text">خروج از حساب</span> <i class="zmdi zmdi-power"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                            <?php if(auth()->user()->role == "admin"): ?>
                                <div class="header-btn notification-btn">
                                    <div class="icon">
                                        <a href="#"> <i class="zmdi zmdi-notifications-none  notification-icon "></i> <span class="badge-icon-header num-fa light-mode">9</span> </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="header-btn notification-btn">
                                <div class="icon">
                                    <a href="#"> <i style="font-size: 20px; height: 22px" class="zmdi zmdi-headset-mic"></i> <span class="badge-icon-header badge-icon-default num-fa light-mode">2</span> </a>
                                </div>
                            </div>
                            <div class="header-btn notification-btn">
                                <div class="icon">
                                    <a href="#"> <i style="font-size: 20px; height: 22px" class="zmdi zmdi-comment-alt-text"></i> <span class="badge-icon-header badge-icon-warning num-fa light-mode">6</span> </a>
                                </div>
                            </div>
                            <div class="header-btn wallet-btn">
                                <div class="icon">
                                    <a href="<?php echo e(Url('/')); ?>"><i class="zmdi zmdi-wallpaper"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-page">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </article>
    </div>
</main>



<script src="<?php echo e(asset('public/modules/dashboard/admin/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/modules/dashboard/admin/js/bootstrap.min.js')); ?>"></script>


<script src="<?php echo e(asset('public/modules/dashboard/admin/css/notifi/index.var.js')); ?>"></script>


<script src="<?php echo e(asset('public/modules/dashboard/admin/plugins/chosen.jquery/js/chosen.jquery.min.js')); ?>"></script>


<script src="<?php echo e(asset('public/modules/dashboard/admin/js/admin.js')); ?>"></script>
<script src="<?php echo e(asset('public/modules/dashboard/admin/js/footer.js')); ?>"></script>

<?php echo $__env->yieldContent('footer'); ?>

<?php
    $msg = \Session::get('notification')
?>

<script>
    var options = {
        position: "bottom-left",
        durations: {
            global: 10000,
            success: null,
            info: null,
            tip: null,
            warning: null,
            alert: null
        },
        labels: {
            success: '',
            alert: '',
            warning: '',
            info: '',
            tip: '',
        },
        icons: {
            prefix: '',
            suffix: '',
            success: '',
            alert: '',
            warning: '',
            info: '',
            tip: '',
        }
    };
    var notifier = new AWN(options);
</script>

<?php if($msg): ?>
    <?php $msg_icon = ''; ?>
    <?php if($msg['class'] == 'success'): ?>
        <?php $msg_icon = 'check' ?>
    <?php elseif($msg['class'] == 'alert'): ?>
        <?php $msg_icon = 'alert-circle-o' ?>
    <?php elseif($msg['class'] == 'warning'): ?>
        <?php $msg_icon = 'alert-triangle' ?>
    <?php elseif($msg['class'] == 'info'): ?>
        <?php $msg_icon = 'info-outline' ?>
    <?php elseif($msg['class'] == 'tip'): ?>
        <?php $msg_icon = 'help"' ?>
    <?php endif; ?>
    <script>
        notifier.<?php echo e($msg['class']); ?>('<?php echo e($msg['message']); ?><span class="awn-toast-icon"><i class="zmdi zmdi-<?php echo e($msg_icon); ?>"></i></span>');
    </script>
<?php endif; ?>

</body>
</html>
<?php /**PATH /Users/s/Desktop/Code/app/Modules/Dashboard/Resources/views/layouts/dashboard/master.blade.php ENDPATH**/ ?>