<?php if($paginator->hasPages()): ?>
    <nav>
        <ul class="pagination-items" style="direction: ltr">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                    <span aria-hidden="true"><svg width="10" height="16" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m5.996 12.98-4.59-4.923a1.577 1.577 0 0 1 0-2.114l4.59-4.922" stroke="#C4C4C4" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </li>
            <?php else: ?>
                <li>
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>"><svg width="10" height="16" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m5.996 12.98-4.59-4.923a1.577 1.577 0 0 1 0-2.114l4.59-4.922" stroke="#C4C4C4" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="disabled" aria-disabled="true"><span><?php echo e($element); ?></span></li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="active" aria-current="page"><span><?php echo e($page); ?></span></li>
                        <?php else: ?>
                            <li><a href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li>
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>"><svg width="10" height="16" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m1.996 12.98 4.59-4.923a1.577 1.577 0 0 0 0-2.114l-4.59-4.922" stroke="#C4C4C4" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                </li>
            <?php else: ?>
                <li class="disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <span aria-hidden="true"><svg width="10" height="16" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m1.996 12.98 4.59-4.923a1.577 1.577 0 0 0 0-2.114l-4.59-4.922" stroke="#C4C4C4" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH /Users/s/Desktop/Code/app/resources/views/vendor/pagination/default.blade.php ENDPATH**/ ?>