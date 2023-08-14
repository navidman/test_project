<?php $__env->startSection('title-page'); ?>
    <span class="icon"><img src="<?php echo e(asset('public/modules/commentsystem/images/icons/comment.gif')); ?>"></span>
    <span class="text">لیست دیدگاه ها</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="report-table">
        <?php if(count($CommentSystem)): ?>
            <div class="widget-block widget-item widget-style">
                <div class="heading-widget">
                    <div class="row align-items-center">
                        <div class="col-10">
                            <div class="form-style small-filter">
                                <form action="<?php echo e(url('dashboard/comment')); ?>" method="get" name="search">
                                    <div class="row align-items-end">
                                        <div class="col-3 field-block">
                                            <input class="text-input" value="<?php if(isset($_GET['search'])): ?><?php echo e($_GET['search']); ?><?php endif; ?>" id="search" type="text" name="search" placeholder="نام و یا ایمیل کاربر را وارد نمایید">
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
                        <div class="col-2 left">
                        </div>
                    </div>
                </div>

                <div class="widget-content">
                    <form action="<?php echo e(url('dashboard/comment/destroy')); ?>" method="post" onsubmit="return confirm('<?php echo "آیا از حذف موارد انتخاب شده مطمئن هستید؟";?>');">
                        <?php echo csrf_field(); ?>
                        <table class="table align-items-center">
                            <thead>
                            <tr>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                                    <th class="delete-col">
                                        <input class="select-all" type="checkbox">
                                    </th>
                                <?php endif; ?>
                                <th width="70">شناسه</th>
                                <th>نام</th>
                                <th>در بخش</th>
                                <th>وضعیت</th>
                                <th width="500">متن پیام</th>
                                <th>تاریخ انتشار</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                                    <th width="80px" class="center">عملیات</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $CommentSystem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php if($item->status == 'new'): ?><?php echo e('new-record'); ?><?php endif; ?>">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                                        <td class="delete-col">
                                            <input class="delete-checkbox" type="checkbox" name="delete_item[<?php echo e($item->id); ?>]" value="1">
                                        </td>
                                    <?php endif; ?>
                                    <td class="num-fa"><?php echo e($item->id); ?></td>
                                    <td class="text-capitalize"><?php if(isset($item->uid)): ?><?php if(\Modules\Users\Entities\Users::find($item->uid)->first()->role != 'user'): ?> <span class="zmdi zmdi-account"></span> <?php endif; ?> <?php endif; ?> <?php if(isset($item->parent_id)): ?> <span class="zmdi zmdi-mail-reply"></span> <?php endif; ?> <?php echo e($item->name); ?></td>
                                    <td class="text-capitalize"><?php echo e($item->post_type == 'blog' ? 'وبلاگ' : $item->post_type); ?></td>
                                    <td class="<?php echo \Illuminate\Support\Arr::toCssClasses([ 'text-capitalize', 'text-danger' => $item->status == 'new', 'text-success' => $item->status == 'accepted']) ?>"><?php if($item->status == 'new'): ?><?php echo e('جدید'); ?><?php elseif($item->status == 'reject'): ?><?php echo e('رد دیدگاه'); ?><?php elseif($item->status == 'viewed'): ?><?php echo e('در انتظار تایید'); ?><?php elseif($item->status == 'accepted'): ?><?php echo e('تایید شده'); ?><?php endif; ?></td>
                                    <td dir="auto"><?php echo e(\App\Http\Controllers\HomeController::TruncateString($item->message, 200, 1)); ?></td>
                                    <td class="num-fa"><?php echo e(\Morilog\Jalali\Jalalian::forge($item->created_at)->format('H:i - Y/m/d')); ?></td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                                        <td class="center">
                                            <a href="<?php echo e(route('comment.edit', $item->id)); ?>" class="table-btn table-btn-icon table-btn-icon-edit"><i class="zmdi zmdi-edit"></i></a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tbody>
                            <tfoot class="num-fa">
                            <tr class="titles">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                                    <th class="delete-col">
                                        <button class="table-btn table-btn-icon table-btn-icon-delete">
                                            <span><img src="<?php echo e(asset('public/modules/dashboard/admin/img/base/icons/trash.svg')); ?>" alt="شناسه" title="حذف"></span>
                                        </button>
                                    </th>
                                <?php endif; ?>
                                <th>شناسه</th>
                                <th>نام</th>
                                <th>در بخش</th>
                                <th>وضعیت</th>
                                <th>متن پیام</th>
                                <th>تاریخ انتشار</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('isAdmin')): ?>
                                    <th width="80px" class="center">عملیات</th>
                                <?php endif; ?>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;" colspan="20">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            نمایش موارد <?php echo e($CommentSystem->firstItem()); ?>

                                            تا <?php echo e($CommentSystem->lastItem()); ?>

                                            از <?php echo e($CommentSystem->total()); ?> مورد
                                            (صفحه <?php echo e($CommentSystem->currentPage()); ?>

                                            از <?php echo e($CommentSystem->lastPage()); ?>)
                                        </div>
                                        <div class="col-8 left">
                                            <div class="pagination-table">
                                                <?php echo e($CommentSystem->links('vendor.pagination.default')); ?>

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
                <div class="icon"><img src="<?php echo e(asset('public/modules/dashboard/admin/img/base/icons/no-item.svg')); ?>">
                </div>
                <h2>هیچ موردی یافت نشد!</h2>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard::layouts.dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/s/Desktop/Code/app/Modules/CommentSystem/Resources/views/admin/index.blade.php ENDPATH**/ ?>