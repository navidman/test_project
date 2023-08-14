<?php use Morilog\Jalali\Jalalian; ?>

<?php $__env->startSection('title','داشبورد'); ?>

<?php $__env->startSection('title-page'); ?>
    <span class="icon"><img src="<?php echo e(asset('public/modules/dashboard/admin/img/base/icons/dashboard.gif ')); ?>"></span>
    <span class="text">میزکار</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('lib'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-6">
            <div style="color: #dddddd; border: 5px dashed" class="<?php echo \Illuminate\Support\Arr::toCssClasses('center mt-2 pt-5 mb-5 pb-5') ?>">
                <h2 class="mb-3">محل قرار گیری ویجت ها و ابزارها</h2>
                <span style="font-size: 16px">برنامه نویسان در این محل مشغول کار هستند</span>
            </div>
        </div>
        <div class="col-6">
            <div style="color: #dddddd; border: 5px dashed" class="<?php echo \Illuminate\Support\Arr::toCssClasses('center mt-2 pt-5 mb-5 pb-5') ?>">
                <h2 class="mb-3">محل قرار گیری ویجت ها و ابزارها</h2>
                <span style="font-size: 16px">برنامه نویسان در این محل مشغول کار هستند</span>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard::layouts.dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/s/Desktop/Code/app/Modules/Dashboard/Resources/views/pages/dashboard/index.blade.php ENDPATH**/ ?>