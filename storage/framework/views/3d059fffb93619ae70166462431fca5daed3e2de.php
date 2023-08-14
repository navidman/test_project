<?php $__env->startSection('title','رزومه پلاس ها'); ?>

<?php $__env->startSection('title-page'); ?>
    <span class="icon"><img src="<?php echo e(asset('public/modules/resumemanager/images/icons/resume.gif')); ?>"></span>
    <span class="text">رزومه پلاس ها</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="report-table">
        <?php if(count($Resumes)): ?>
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="form-style small-filter">
                        <form action="<?php echo e(url('dashboard/resume-manager')); ?>" method="get" name="search">
                            <div class="row align-items-end">
                                <div class="col-3 field-block">
                                    <input class="text-input" value="<?php if(isset($_GET['search'])): ?><?php echo e($_GET['search']); ?><?php endif; ?>" id="search" type="text" name="search" placeholder="نام و نام خانوادگی را وارد نمایید">
                                </div>

                                <div class="col-auto submit-field">
                                    <button type="submit">
                                        <span class="zmdi zmdi-search"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="widget-content">
                    <form action="<?php echo e(url('dashboard/users/destroy')); ?>" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                        <?php echo csrf_field(); ?>
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAuthor')): ?>
                                    <th class="delete-col">
                                        <input class="select-all" type="checkbox">

                                    </th>
                                <?php endif; ?>
                                <th>نام و نام خانوادگی</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAuthor')): ?>
                                    <th width="100px" class="center">عملیات</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $Resumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAuthor')): ?>
                                        <td class="delete-col">
                                            <input class="delete-checkbox" type="checkbox" name="delete_item[<?php echo e($item->uid); ?>]" value="1">
                                        </td>
                                    <?php endif; ?>
                                    <td class="cursor-pointer" onclick="window.location.href = '<?php echo e(url('dashboard/resume-manager/' . $item->id)); ?>/edit'"><?php echo e($item->user_tbl->full_name); ?></td>
                                    <td><?php if($item->status == 'new'): ?><?php echo e('جدید'); ?><?php elseif($item->status == 'pending_operator'): ?><?php echo e('در انتظار بررسی اپراتور'); ?><?php elseif($item->status == 'pending_job_seeker'): ?><?php echo e('در انتظار تایید کارجو'); ?><?php elseif($item->status == 'job_seeker_reject'): ?><?php echo e('رد توسط کارجو'); ?><?php elseif($item->status == 'accept_job_seeker'): ?><?php echo e('تایید توسط کارجو'); ?><?php endif; ?></td>
                                    <td class="num-fa"><?php echo e(\Morilog\Jalali\Jalalian::forge($item->publish_at ? $item->publish_at : $item->created_at)->format('H:i - Y/m/d')); ?></td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAuthor')): ?>
                                        <td class="center">
                                            <a href="<?php echo e(route('resume-manager.edit', $item->id)); ?>" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-edit"></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                            <tfoot class="num-fa">
                            <tr class="titles">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAuthor')): ?>
                                    <th class="delete-col">
                                        <button class="table-btn table-btn-icon table-btn-icon-delete">
                                            <span><img src="<?php echo e(asset('public/modules/dashboard/admin/img/base/icons/trash.svg')); ?>" alt="شناسه" title="حذف"></span>
                                        </button>
                                    </th>
                                <?php endif; ?>
                                <th>نام و نام خانوادگی</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAuthor')): ?>
                                    <th width="100px" class="center">عملیات</th>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;" colspan="20">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            نمایش موارد <?php echo e($Resumes->firstItem()); ?> تا <?php echo e($Resumes->lastItem()); ?>

                                            از <?php echo e($Resumes->total()); ?> مورد (صفحه <?php echo e($Resumes->currentPage()); ?>

                                            از <?php echo e($Resumes->lastPage()); ?>)
                                        </div>
                                        <div class="col-8 left">
                                            <div class="pagination-table">
                                                <?php echo e($Resumes->links('vendor.pagination.default')); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </form>

                </div>
            </div>
        <?php else: ?>
            <div class="widget-block widget-item widget-style center no-item">
                <div class="icon"><img src="<?php echo e(asset('public/modules/dashboard/admin/img/base/icons/no-item.svg')); ?>"></div>
                <h2>هیچ موردی یافت نشد!</h2>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard::layouts.dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/s/Desktop/Code/app/Modules/ResumeManager/Resources/views/index.blade.php ENDPATH**/ ?>