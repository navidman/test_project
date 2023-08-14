<?php $__env->startSection('title','ویرایش رزومه'); ?>

<?php $__env->startSection('title-page'); ?>
    <span class="icon"><img src="<?php echo e(asset('public/modules/resumemanager/images/icons/resume.gif')); ?>"></span>
    <span class="text">ویرایش رزومه</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <section class="form-section">
        <form action="<?php echo e(route('resume-manager.update', $Resume->id)); ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-9">
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <span class="widget-title">اطلاعات رزومه</span>
                        </div>

                        <div class="widget-content widget-content-padding">
                            <?php echo csrf_field(); ?>
                            <?php echo e(method_field('PUT')); ?>

                            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses('row') ?>">
                                <div class="col-12 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('full_name')): ?>
                                            <span class="col-12 message-show"><?php echo e($errors->first('full_name')); ?></span>
                                        <?php endif; ?>
                                        <?php echo Form::text('full_name',$Resume->user_tbl->full_name,[ 'id'=>'full_name' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'نام و نام خانوادگی را وارد نمایید']); ?>

                                        <?php echo Form::label('full_name','نام و نام خانوادگی:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('email')): ?>
                                            <span class="col-12 message-show"><?php echo e($errors->first('email')); ?></span>
                                        <?php endif; ?>
                                        <?php echo Form::email('email',$Resume->user_tbl->email,[ 'id'=>'email' , 'class'=>'col-12 field-style input-text left', 'placeholder'=>'ایمیل کاربر را وارد نمایید']); ?>

                                        <?php echo Form::label('email','ایمیل:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('phone')): ?>
                                            <span class="col-12 message-show"><?php echo e($errors->first('phone')); ?></span>
                                        <?php endif; ?>
                                        <?php echo Form::text('phone',$Resume->user_tbl->phone,[ 'id'=>'phone' , 'class'=>'col-12 field-style input-text left', 'placeholder'=>'تلفن را وارد نمایید']); ?>

                                        <?php echo Form::label('phone','تلفن:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                
                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('province')): ?>
                                            <span class="col-12 message-show"><?php echo e($errors->first('province')); ?></span>
                                        <?php endif; ?>
                                        <?php echo Form::label('province','استان اجرای پروژه:',); ?>

                                        <select data-placeholder="لطفا استان را انتخاب نمایید" id="province" class="select chosen-rtl" name="province" onChange="CityList(this.value);">
                                            <option></option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '1'): echo 'selected'; endif; ?> value="1">تهران</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '2'): echo 'selected'; endif; ?> value="2">گیلان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '3'): echo 'selected'; endif; ?> value="3">آذربایجان شرقی</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '4'): echo 'selected'; endif; ?> value="4">خوزستان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '5'): echo 'selected'; endif; ?> value="5">فارس</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '6'): echo 'selected'; endif; ?> value="6">اصفهان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '7'): echo 'selected'; endif; ?> value="7">خراسان رضوی</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '8'): echo 'selected'; endif; ?> value="8">قزوین</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '9'): echo 'selected'; endif; ?> value="9">سمنان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '10'): echo 'selected'; endif; ?> value="10">قم</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '11'): echo 'selected'; endif; ?> value="11">مرکزی</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '12'): echo 'selected'; endif; ?> value="12">زنجان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '13'): echo 'selected'; endif; ?> value="13">مازندران</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '14'): echo 'selected'; endif; ?> value="14">گلستان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '15'): echo 'selected'; endif; ?> value="15">اردبیل</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '16'): echo 'selected'; endif; ?> value="16">آذربایجان غربی</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '17'): echo 'selected'; endif; ?> value="17">همدان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '18'): echo 'selected'; endif; ?> value="18">کردستان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '19'): echo 'selected'; endif; ?> value="19">کرمانشاه</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '20'): echo 'selected'; endif; ?> value="20">لرستان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '21'): echo 'selected'; endif; ?> value="21">بوشهر</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '22'): echo 'selected'; endif; ?> value="22">کرمان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '23'): echo 'selected'; endif; ?> value="23">هرمزگان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '24'): echo 'selected'; endif; ?> value="24">چهارمحال و بختیاری</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '25'): echo 'selected'; endif; ?> value="25">یزد</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '26'): echo 'selected'; endif; ?> value="26">سیستان و بلوچستان</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '27'): echo 'selected'; endif; ?> value="27">ایلام</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '28'): echo 'selected'; endif; ?> value="28">کهگلویه و بویراحمد</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '29'): echo 'selected'; endif; ?> value="29">خراسان شمالی</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '30'): echo 'selected'; endif; ?> value="30">خراسان جنوبی</option>
                                            <option <?php if(old(
                                            "project_state", $Resume->user_tbl->province) == '31'): echo 'selected'; endif; ?> value="31">البرز</option>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('city')): ?>
                                            <span class="col-12 message-show"><?php echo e($errors->first('city')); ?></span>
                                        <?php endif; ?>
                                        <?php echo Form::label('city','شهر اجرای پروژه:',); ?>

                                        <select data-placeholder="لطفا ابتدا استان را انتخاب نمایید" class="js-example-basic-single select chosen-rtl" name="city" id="city">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('level')): ?>
                                            <span class="message-show"><?php echo e($errors->first('level')); ?></span>
                                        <?php endif; ?>
                                        <div class="col-12 field-style">
                                            <select data-placeholder="یک مورد را انتخاب کنید" id="level" class="select chosen-rtl" name="level">
                                                <option></option>
                                                <option value="مدیر عامل" <?php if(old(
                                                "level", $Resume->level) == "مدیر عامل"): echo 'selected'; endif; ?>>مدیر عامل</option>
                                                <option value="قائم مقام" <?php if(old(
                                                "level", $Resume->level) == "قائم مقام"): echo 'selected'; endif; ?>>قائم مقام</option>
                                                <option value="معاونت" <?php if(old(
                                                "level", $Resume->level) == "معاونت"): echo 'selected'; endif; ?>>معاونت</option>
                                                <option value="مدیر" <?php if(old(
                                                "level", $Resume->level) == "مدیر"): echo 'selected'; endif; ?>>مدیر</option>
                                                <option value="رئیس / سرپرست" <?php if(old(
                                                "level", $Resume->level) == "رئیس / سرپرست"): echo 'selected'; endif; ?>>رئیس / سرپرست</option>
                                                <option value="کارشناس ارشد / کارشناس مسئول" <?php if(old(
                                                "level", $Resume->level) == "کارشناس ارشد / کارشناس مسئول"): echo 'selected'; endif; ?>>کارشناس ارشد / کارشناس مسئول</option>کارشناس ارشد / کارشناس مسئول
                                                <option value="کارشناس" <?php if(old(
                                                "level", $Resume->level) == "کارشناس"): echo 'selected'; endif; ?>>کارشناس</option>
                                                <option value="کارمند" <?php if(old(
                                                "level", $Resume->level) == "کارمند"): echo 'selected'; endif; ?>>کارمند</option>
                                            </select>
                                        </div>
                                        <?php echo Form::label('level','سطح ارشديت:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                
                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('cooperation_type')): ?>
                                            <span class="message-show"><?php echo e($errors->first('cooperation_type')); ?></span>
                                        <?php endif; ?>
                                        <div class="col-12 field-style">
                                            <select data-placeholder="یک مورد را انتخاب کنید" id="cooperation_type" class="select chosen-rtl" name="cooperation_type">
                                                <option></option>
                                                <option value="تمام وقت" <?php if(old(
                                                "cooperation_type", $Resume->cooperation_type) == "تمام وقت"): echo 'selected'; endif; ?>>تمام وقت</option>
                                                <option value="مشاوره" <?php if(old(
                                                "cooperation_type", $Resume->cooperation_type) == "مشاوره"): echo 'selected'; endif; ?>>مشاوره</option>
                                                <option value="پاره وقت" <?php if(old(
                                                "cooperation_type", $Resume->cooperation_type) == "پاره وقت"): echo 'selected'; endif; ?>>پاره وقت</option>
                                                <option value="پروژه ای" <?php if(old(
                                                "cooperation_type", $Resume->cooperation_type) == "پروژه ای"): echo 'selected'; endif; ?>>پروژه ای</option>
                                            </select>
                                        </div>
                                        <?php echo Form::label('cooperation_type','نوع همکاری:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                
                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('presence_type')): ?>
                                            <span class="message-show"><?php echo e($errors->first('presence_type')); ?></span>
                                        <?php endif; ?>
                                        <div class="col-12 field-style">
                                            <select data-placeholder="یک مورد را انتخاب کنید" id="presence_type" class="select chosen-rtl" name="presence_type">
                                                <option></option>
                                                <option value="دورکاری" <?php if(old(
                                                "presence_type", $Resume->presence_type) == "دورکاری"): echo 'selected'; endif; ?>>دورکاری</option>
                                                <option value="هیبرید (ترکیب حضوری و دورکاری)" <?php if(old(
                                                "presence_type", $Resume->presence_type) == "هیبرید (ترکیب حضوری و دورکاری)"): echo 'selected'; endif; ?>>هیبرید (ترکیب حضوری و دورکاری)</option>
                                                <option value="حضور کامل" <?php if(old(
                                                "presence_type", $Resume->presence_type) == "حضور کامل"): echo 'selected'; endif; ?>>حضور کامل</option>
                                            </select>
                                        </div>
                                        <?php echo Form::label('presence_type','نوع حضور:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                
                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('salary')): ?>
                                            <span class="message-show"><?php echo e($errors->first('salary')); ?></span>
                                        <?php endif; ?>
                                        <div class="col-12 field-style">
                                            <select data-placeholder="یک مورد را انتخاب کنید" id="salary" class="select chosen-rtl" name="salary">
                                                <option></option>
                                                <option value="adaptive" <?php if(old(
                                                "salary", $Resume->salary) == "adaptive"): echo 'selected'; endif; ?>>توافقی</option>
                                                <option value="basic_salary" <?php if(old(
                                                "salary", $Resume->salary) == "basic_salary"): echo 'selected'; endif; ?>>حقوق پایه (وزارت کار)</option>
                                                <option value="4-6" <?php if(old(
                                                "salary", $Resume->salary) == "4-6"): echo 'selected'; endif; ?>>از ۴ تا ۶ میلیون تومان</option>
                                                <option value="6-8" <?php if(old(
                                                "salary", $Resume->salary) == "6-8"): echo 'selected'; endif; ?>>از ۶ تا ۸ میلیون تومان</option>
                                                <option value="8-10" <?php if(old(
                                                "salary", $Resume->salary) == "8-10"): echo 'selected'; endif; ?>>از ۸ تا ۱۰ میلیون تومان</option>
                                                <option value="10-12" <?php if(old(
                                                "salary", $Resume->salary) == "10-12"): echo 'selected'; endif; ?>>از ۱۰ تا ۱۲ میلیون تومان</option>
                                                <option value="12-14" <?php if(old(
                                                "salary", $Resume->salary) == "12-14"): echo 'selected'; endif; ?>>از ۱۲ تا ۱۴ میلیون تومان</option>
                                                <option value="14-16" <?php if(old(
                                                "salary", $Resume->salary) == "14-16"): echo 'selected'; endif; ?>>از ۱۴ تا ۱۶ میلیون تومان</option>
                                                <option value="16-20" <?php if(old(
                                                "salary", $Resume->salary) == "16-20"): echo 'selected'; endif; ?>>از ۱۶ تا ۲۰ میلیون تومان</option>
                                                <option value="20-25" <?php if(old(
                                                "salary", $Resume->salary) == "20-25"): echo 'selected'; endif; ?>>از ۲۰ تا ۲۵ میلیون تومان</option>
                                                <option value="25-30" <?php if(old(
                                                "salary", $Resume->salary) == "25-30"): echo 'selected'; endif; ?>>از ۲۵ تا ۳۰ میلیون تومان</option>
                                                <option value="30-35" <?php if(old(
                                                "salary", $Resume->salary) == "30-35"): echo 'selected'; endif; ?>>از ۳۰ تا ۳۵ میلیون تومان</option>
                                                <option value="35-40" <?php if(old(
                                                "salary", $Resume->salary) == "35-40"): echo 'selected'; endif; ?>>از ۳۵ تا ۴۰ میلیون تومان</option>
                                                <option value="40-45" <?php if(old(
                                                "salary", $Resume->salary) == "40-45"): echo 'selected'; endif; ?>>از ۴۰ تا ۴۵ میلیون تومان</option>
                                                <option value="45-50" <?php if(old(
                                                "salary", $Resume->salary) == "45-50"): echo 'selected'; endif; ?>>از ۴۵ تا ۵۰ میلیون تومان</option>
                                                <option value="more_than_50" <?php if(old(
                                                "salary", $Resume->salary) == "more_than_50"): echo 'selected'; endif; ?>>بیش از ۵۰ میلیون تومان</option>
                                            </select>
                                        </div>
                                        <?php echo Form::label('salary','مقدار حقوق درخواستی:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                
                                <?php if($gender == 'male'): ?>
                                    <div class="col-6 mb-4">
                                        <div class="form-group row no-gutters">
                                            <?php if($errors->has('sarbazi')): ?>
                                                <span class="message-show"><?php echo e($errors->first('sarbazi')); ?></span>
                                            <?php endif; ?>
                                            <div class="col-12 field-style">
                                                <select data-placeholder="یک مورد را انتخاب کنید" id="sarbazi" class="select chosen-rtl" name="sarbazi">
                                                    <option></option>
                                                    <option value="غیر مشمول" <?php if(old(
                                                "sarbazi", $Resume->sarbazi) == "غیر مشمول"): echo 'selected'; endif; ?>>غیر مشمول</option>
                                                    <option value="مشمول" <?php if(old(
                                                "sarbazi", $Resume->sarbazi) == "مشمول"): echo 'selected'; endif; ?>>مشمول</option>
                                                    <option value="سرباز" <?php if(old(
                                                "sarbazi", $Resume->sarbazi) == "سرباز"): echo 'selected'; endif; ?>>سرباز</option>
                                                    <option value="معافیت" <?php if(old(
                                                "sarbazi", $Resume->sarbazi) == "معافیت"): echo 'selected'; endif; ?>>معافیت</option>
                                                    <option value="پایان خدمت" <?php if(old(
                                                "sarbazi", $Resume->sarbazi) == "پایان خدمت"): echo 'selected'; endif; ?>>پایان خدمت</option>
                                                </select>
                                            </div>
                                            <?php echo Form::label('sarbazi','وضعیت سربازی:',['class'=>'col-12']); ?>

                                        </div>
                                    </div>
                                <?php endif; ?>


                                
                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('birth_day')): ?>
                                            <span class="col-12 message-show"><?php echo e($errors->first('birth_day')); ?></span>
                                        <?php endif; ?>
                                        <?php echo Form::text('birth_day',$Resume->birth_day,[ 'id'=>'birth_day' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'تاریخ تولد را وارد نمایید']); ?>

                                        <?php echo Form::label('birth_day','تاریخ تولد:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                
                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('skills')): ?>
                                            <span class="message-show"><?php echo e($errors->first('skills')); ?></span>
                                        <?php endif; ?>
                                        <div class="col-12 field-style">
                                            <select data-placeholder="یک مورد را انتخاب کنید" id="skills" class="select chosen-rtl" name="skills">
                                                <option></option>
                                                <?php $__empty_1 = true; $__currentLoopData = $Skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                    <option value="<?php echo e($item->id); ?>" <?php if(old("cat", $Resume->skills) ==
                                                    $item->id): echo 'selected'; endif; ?>><?php echo e($item->title); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <?php echo Form::label('skills','گروه شغلی:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                                <div class="col-6 mb-4">
                                    <div class="form-group row no-gutters">
                                        <?php if($errors->has('job_position')): ?>
                                            <span class="col-12 message-show"><?php echo e($errors->first('job_position')); ?></span>
                                        <?php endif; ?>
                                        <?php echo Form::text('job_position',$Resume->job_position,[ 'id'=>'job_position' , 'class'=>'col-12 field-style input-text', 'placeholder'=>'عنوان شغلی کارجو را وارد نمایید']); ?>

                                        <?php echo Form::label('job_position','عنوان شغلی کارجو:',['class'=>'col-12']); ?>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php $__empty_1 = true; $__currentLoopData = $Resume->resume_introducer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="widget-block widget-item widget-style">
                            <div class="heading-widget">
                                <span class="widget-title"><?php echo e($item->employment_tbl->company_name_fa ? $item->employment_tbl->company_name_fa :  $item->employment_tbl->full_name); ?></span>
                            </div>
                            <div class="widget-content widget-content-padding">
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>نحوه آشنایی</strong>
                                    <div><?php echo e($item->recognition ? 'مصاحبه' : 'همکاری'); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>شایستگی های تخصصی</strong>
                                    <div><?php echo e($item->expertise); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>شایستگی های روانشناختی</strong>
                                    <div><?php echo e($item->personality); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>میزان تجربه در شغل</strong>
                                    <div><?php echo e($item->experience); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>مهارت های نرم افزاری</strong>
                                    <div><?php echo e($item->software); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>رفتار حرفه ای</strong>
                                    <div><?php echo e($item->organizational_behavior); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>اشتیاق در شغل</strong>
                                    <div><?php echo e($item->passion); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>حقوق و دستمزد</strong>
                                    <div><?php echo e($item->salary_rate); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>با این اوصاف چرا امکان همکاری فراهم نگردید؟</strong>
                                    <div><?php echo e($item->reason_adjustment); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>نظر کارفرما</strong>
                                    <div><?php echo e($item->comment_employment); ?></div>
                                </div>
                                <div class='border-bottom pb-2 mb-4'>
                                    <strong>نظر تخصصی کارفرما</strong>
                                    <div><?php echo e($item->expert_opinion); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <?php endif; ?>

                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <span class="widget-title">مشکلات و پیشنهادات رزومه پلاس</span>
                        </div>

                        <div class="widget-content widget-content-padding">
                            <div class="row">
                                <div class="col-6" style="border-left: solid 1px #cccccc">
                                    <div class="form-group">
                                        <div class="requirements-repeater text-field-repeater">
                                            <div class="field-list" id="repeat_list_problem">
                                                <?php $ProblemKey = 1 ?>
                                                <?php if($Resume->requirements): ?>
                                                    <?php if(isset(json_decode($Resume->requirements, true)['problem'])): ?>
                                                        <?php $__empty_1 = true; $__currentLoopData = json_decode($Resume->requirements, true)['problem']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <div id="field-repeat-item-problem-<?php echo e($ProblemKey); ?>">
                                                                <div class="text-field">
                                                                    <div class='text-field'>
                                                                        <input placeholder='مشکل را وارد نمایید...' class='field-style input-text' type="text" name="requirements[problem][<?php echo e($ProblemKey); ?>]" value="<?php echo e($item); ?>">
                                                                        <span class='delete-row icon-close' onclick='delete_item_problem(<?php echo e($ProblemKey); ?>)'>
                                                                        <span class='zmdi zmdi-close'></span>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $ProblemKey += 1 ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="add-field center bg-danger" id="addRepeatItemProblem">
                                                <span class="icon-plus"></span>افزودن مشکل رزومه پلاس
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="requirements-repeater text-field-repeater">
                                            <div class="field-list" id="repeat_list_suggest">
                                                <?php $SuggestKey = 1 ?>
                                                <?php if($Resume->requirements): ?>
                                                    <?php if(isset(json_decode($Resume->requirements, true)['suggest'])): ?>
                                                        <?php $__empty_1 = true; $__currentLoopData = json_decode($Resume->requirements, true)['suggest']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <div id="field-repeat-item-suggest-<?php echo e($SuggestKey); ?>">
                                                                <div class="text-field">
                                                                    <div class='text-field'>
                                                                        <input placeholder='پیشنهاد را وارد نمایید...' class='field-style input-text' type="text" name="requirements[suggest][<?php echo e($SuggestKey); ?>]" value="<?php echo e($item); ?>">
                                                                        <span class='delete-row icon-close' onclick='delete_item_suggest(<?php echo e($SuggestKey); ?>)'>
                                                                        <span class='zmdi zmdi-close'></span>
                                                                    </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $SuggestKey += 1 ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                            <div class="add-field center bg-warning" id="addRepeatItemSuggest">
                                                <span class="icon-plus"></span>افزودن پیشنهاد برای بهتر شدن رزومه پلاس
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    
                    <div class="widget-block widget-item widget-style">
                        <div class="heading-widget">
                            <div class="row align-items-center">
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses('col') ?>"><span class="widget-title">ثبت اطلاعات</span></div>
                            </div>
                        </div>

                        <div class="widget-content widget-content-padding widget-content-padding-side">
                            
                            <div class="form-group row no-gutters">
                                <div class="col-12 field-style">
                                    <select data-placeholder="یک مورد را انتخاب کنید" class="select chosen-rtl" name="status" id="status">
                                        <option value="pending_operator" <?php if(old(
                                        "status", $Resume->status) == "pending_operator"): echo 'selected'; endif; ?>> در انتظار تایید تاپلیکنت</option>
                                        <option value="toplicant_reject" <?php if(old(
                                        "status", $Resume->status) == "toplicant_reject"): echo 'selected'; endif; ?>>✘ رد توسط تاپلیکنت</option>
                                        <option value="pending_job_seeker" <?php if(old(
                                        "status", $Resume->status) == "pending_job_seeker"): echo 'selected'; endif; ?>>✓ تایید تاپلیکنت</option>
                                        <option value="job_seeker_reject" <?php if(old(
                                        "status", $Resume->status) == "job_seeker_reject"): echo 'selected'; endif; ?>>رد توسط کارجو</option>
                                        <option value="accept_job_seeker" <?php if(old(
                                        "status", $Resume->status) == "accept_job_seeker"): echo 'selected'; endif; ?>>تایید توسط کارجو</option>
                                        <option value="expire" <?php if(old(
                                        "status", $Resume->status) == "expire"): echo 'selected'; endif; ?>>منقضی شده</option>
                                    </select>
                                </div>

                                <?php echo Form::label('status','وضعیت رزومه',['class'=>'col-12']); ?>

                            </div>

                            <div class="form-group row no-gutters">
                                <?php if($errors->has('access_resume')): ?>
                                    <span class="message-show"><?php echo e($errors->first('access_resume')); ?></span>
                                <?php endif; ?>
                                <div class="col-12 field-style">
                                    <select data-placeholder="یک مورد را انتخاب کنید" id="access_resume" class="select chosen-rtl" name="access_resume">
                                        <option></option>
                                        <option value="all" <?php if(old(
                                        "access_resume", $Resume->access_resume) == "all"): echo 'selected'; endif; ?>> قابل نمایش برای همه</option>
                                        <option value="cooperation_companies" <?php if(old(
                                        "access_resume", $Resume->access_resume) == "cooperation_companies"): echo 'selected'; endif; ?>>فقط شرکت های همکار</option>
                                    </select>
                                </div>
                                <?php echo Form::label('access_resume','چه کسانی دسترسی داشته باشند:',['class'=>'col-12']); ?>

                            </div>

                            
                            <div class="form-group row no-gutters">
                                <?php if($errors->has('gender')): ?>
                                    <span class="message-show"><?php echo e($errors->first('gender')); ?></span>
                                <?php endif; ?>
                                <div class="col-12 field-style">
                                    <select data-placeholder="یک مورد را انتخاب کنید" id="gender" class="select chosen-rtl" name="gender">
                                        <option></option>
                                        <option value="male" <?php if(old(
                                        "gender", $Resume->user_tbl->gender) == "male"): echo 'selected'; endif; ?>> آقا</option>
                                        <option value="female" <?php if(old(
                                        "gender", $Resume->user_tbl->gender) == "female"): echo 'selected'; endif; ?>>خانم</option>
                                    </select>
                                </div>
                                <?php echo Form::label('gender','جنسیت:',['class'=>'col-12']); ?>

                            </div>

                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            

                            <button type="submit" class="submit-form-btn">بروزرسانی اطلاعات</button>
                        </div>
                    </div>

                    
                    <div class="widget-content widget-content-padding widget-content-padding-side">
                        <div class="widget-block widget-item widget-style">
                            <div class="heading-widget">
                                <span class="widget-title">تصویر پروفایل</span>
                            </div>

                            <div class="widget-content widget-content-padding widget-content-padding-side">
                                
                                <div class="form-group row no-gutters">
                                    <?php if($errors->has('avatar')): ?>
                                        <span class="message-show"><?php echo e($errors->first('avatar')); ?></span>
                                    <?php endif; ?>
                                    <div class="col-12 field-style custom-select-field">
                                        <div class="thumbnail-image-upload">
                                            <div>
                                                <label for="thumbnail-image" id="thumbnail-label" class="thumbnail-label"><img id="thumbnail-preview" src="<?php if($Resume->user_tbl->avatar): ?><?php echo e(asset( 'storage/' . \Modules\FileLibrary\Entities\FileLibrary::find($Resume->user_tbl->avatar)->path .'full/'. \Modules\FileLibrary\Entities\FileLibrary::find($Resume->user_tbl->avatar)->file_name)); ?><?php else: ?><?php echo e(asset('public/modules/dashboard/admin/img/base/icons/image.svg')); ?><?php endif; ?>"></label>
                                                <input onchange="readURL(this)" name="avatar" type="file" class="thumbnail-image" id="thumbnail-image" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content widget-content-padding widget-content-padding-side">
                        <div class="widget-block widget-item widget-style">
                            <div class="heading-widget">
                                <span class="widget-title">دانلود مستندات</span>
                            </div>

                            <div class="widget-content widget-content-padding widget-content-padding-side">
                                <?php if($Resume->resume_file_tbl): ?>
                                    <div class="download-item light-mode fs-3 fw-bold mb-2">
                                        <a class="d-inline-block p-2 w-100 text-center border-radius-px-5 bg-info" href="<?php echo e(asset( 'storage/' . $Resume->resume_file_tbl->path . $Resume->resume_file_tbl->file_name)); ?>">دانلود فایل رزومه</a>
                                    </div>
                                <?php endif; ?>
                                <?php if($Resume->interview_file): ?>
                                    <div class="download-item light-mode fs-3 fw-bold">
                                        <a class="d-inline-block p-2 w-100 text-center border-radius-px-5 bg-info" href="<?php echo e(asset( 'storage/' . $Resume->interview_file_tbl->path . $Resume->interview_file_tbl->file_name)); ?>">دانلود فایل مصاحبه</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    
    <script>
        function CityList(state) {
            with (document.getElementById('city')) {
                options.length = 0;

                if (state == 0) {
                    options[0] = new Option('لطفا ابتدا استان را انتخاب نمایید', '0');
                }

                if (state == 1) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('تهران', 'تهران');
                    options[2] = new Option('ادران', 'ادران');
                    options[3] = new Option('اسلام آباد', 'اسلام آباد');
                    options[4] = new Option('اسلام شهر', 'اسلام شهر');
                    options[5] = new Option('اكبرآباد', 'اكبرآباد');
                    options[6] = new Option('اميريه', 'اميريه');
                    options[7] = new Option('انديشه', 'انديشه');
                    options[8] = new Option('اوشان', 'اوشان');
                    options[9] = new Option('آبسرد', 'آبسرد');
                    options[10] = new Option('آبعلي', 'آبعلي');
                    options[11] = new Option('باغستان', 'باغستان');
                    options[12] = new Option('باقر شهر', 'باقر شهر');
                    options[13] = new Option('برغان', 'برغان');
                    options[14] = new Option('بومهن', 'بومهن');
                    options[15] = new Option('پارچين', 'پارچين');
                    options[16] = new Option('پاكدشت', 'پاكدشت');
                    options[17] = new Option('پرديس', 'پرديس');
                    options[18] = new Option('پرند', 'پرند');
                    options[19] = new Option('پس قلعه', 'پس قلعه');
                    options[20] = new Option('پيشوا', 'پيشوا');
                    options[21] = new Option('تجزيه مبادلات لشكر', 'تجزيه مبادلات لشكر');
                    options[22] = new Option('احمدآبادمستوفي', 'احمدآبادمستوفي');
                    options[23] = new Option('جاجرود', 'جاجرود');
                    options[24] = new Option('چرمسازي سالاريه', 'چرمسازي سالاريه');
                    options[25] = new Option('چهاردانگه', 'چهاردانگه');
                    options[26] = new Option('حسن آباد', 'حسن آباد');
                    options[27] = new Option('حومه گلندوك', 'حومه گلندوك');
                    options[28] = new Option('خاتون آباد', 'خاتون آباد');
                    options[29] = new Option('خاوه', 'خاوه');
                    options[30] = new Option('خرمدشت', 'خرمدشت');
                    options[31] = new Option('دركه', 'دركه');
                    options[32] = new Option('دماوند', 'دماوند');
                    options[33] = new Option('رباط كريم', 'رباط كريم');
                    options[34] = new Option('رزگان', 'رزگان');
                    options[35] = new Option('رودهن', 'رودهن');
                    options[36] = new Option('ري', 'ري');
                    options[37] = new Option('سعيدآباد', 'سعيدآباد');
                    options[38] = new Option('سلطان آباد', 'سلطان آباد');
                    options[39] = new Option('سوهانك', 'سوهانك');
                    options[40] = new Option('شاهدشهر', 'شاهدشهر');
                    options[41] = new Option('شريف آباد', 'شريف آباد');
                    options[42] = new Option('شمس آباد', 'شمس آباد');
                    options[43] = new Option('شهر قدس', 'شهر قدس');
                    options[44] = new Option('شهرآباد', 'شهرآباد');
                    options[45] = new Option('شهرجديدپرديس', 'شهرجديدپرديس');
                    options[46] = new Option('شهرقدس(مويز)', 'شهرقدس(مويز)');
                    options[47] = new Option('شهريار', 'شهريار');
                    options[48] = new Option('شهرياربردآباد', 'شهرياربردآباد');
                    options[49] = new Option('صالح آباد', 'صالح آباد');
                    options[50] = new Option('صفادشت', 'صفادشت');
                    options[51] = new Option('فرودگاه امام خميني', 'فرودگاه امام خميني');
                    options[52] = new Option('فرون آباد', 'فرون آباد');
                    options[53] = new Option('فشم', 'فشم');
                    options[54] = new Option('فيروزكوه', 'فيروزكوه');
                    options[55] = new Option('قرچك', 'قرچك');
                    options[56] = new Option('قيام دشت', 'قيام دشت');
                    options[57] = new Option('كهريزك', 'كهريزك');
                    options[58] = new Option('كيلان', 'كيلان');
                    options[59] = new Option('گلدسته', 'گلدسته');
                    options[60] = new Option('گلستان (بهارستان)', 'گلستان (بهارستان)');
                    options[61] = new Option('گيلاوند', 'گيلاوند');
                    options[62] = new Option('لواسان', 'لواسان');
                    options[63] = new Option('لوسان بزرگ', 'لوسان بزرگ');
                    options[64] = new Option('مارليك', 'مارليك');
                    options[65] = new Option('مروزبهرام', 'مروزبهرام');
                    options[66] = new Option('ملارد', 'ملارد');
                    options[67] = new Option('منطقه 11 پستي تهران', 'منطقه 11 پستي تهران');
                    options[68] = new Option('منطقه 13 پستي تهران', 'منطقه 13 پستي تهران');
                    options[69] = new Option('منطقه 14 پستي تهران', 'منطقه 14 پستي تهران');
                    options[70] = new Option('منطقه 15 پستي تهران', 'منطقه 15 پستي تهران');
                    options[71] = new Option('منطقه 16 پستي تهران', 'منطقه 16 پستي تهران');
                    options[72] = new Option('منطقه 17 پستي تهران  ', 'منطقه 17 پستي تهران  ');
                    options[73] = new Option('منطقه 18 پستي تهران  ', 'منطقه 18 پستي تهران  ');
                    options[74] = new Option('منطقه 19 پستي تهران  ', 'منطقه 19 پستي تهران  ');
                    options[75] = new Option('نسيم شهر (بهارستان)', 'نسيم شهر (بهارستان)');
                    options[76] = new Option('نصيرآباد', 'نصيرآباد');
                    options[77] = new Option('واوان', 'واوان');
                    options[78] = new Option('وحيديه', 'وحيديه');
                    options[79] = new Option('ورامين', 'ورامين');
                    options[80] = new Option('وهن آباد', 'وهن آباد');
                }
                if (state == 2) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('احمد سرگوراب', 'احمد سرگوراب');
                    options[2] = new Option('اسالم', 'اسالم');
                    options[3] = new Option('اسكلك', 'اسكلك');
                    options[4] = new Option('اسلام آباد', 'اسلام آباد');
                    options[5] = new Option('اطاقور', 'اطاقور');
                    options[6] = new Option('املش', 'املش');
                    options[7] = new Option('آبكنار', 'آبكنار');
                    options[8] = new Option('آستارا', 'آستارا');
                    options[9] = new Option('آستانه اشرفيه', 'آستانه اشرفيه');
                    options[10] = new Option('بازاراسالم', 'بازاراسالم');
                    options[11] = new Option('بازارجمعه شاندرمن', 'بازارجمعه شاندرمن');
                    options[12] = new Option('برهسر', 'برهسر');
                    options[13] = new Option('بلترك', 'بلترك');
                    options[14] = new Option('بلسبنه', 'بلسبنه');
                    options[15] = new Option('بندرانزلي', 'بندرانزلي');
                    options[16] = new Option('پاشاكي', 'پاشاكي');
                    options[17] = new Option('پرهسر', 'پرهسر');
                    options[18] = new Option('پلاسي', 'پلاسي');
                    options[19] = new Option('پونل', 'پونل');
                    options[20] = new Option('پيربست لولمان', 'پيربست لولمان');
                    options[21] = new Option('توتكابن', 'توتكابن');
                    options[22] = new Option('جوكندان', 'جوكندان');
                    options[23] = new Option('جيرنده', 'جيرنده');
                    options[24] = new Option('چابكسر', 'چابكسر');
                    options[25] = new Option('چاپارخانه', 'چاپارخانه');
                    options[26] = new Option('چوبر', 'چوبر');
                    options[27] = new Option('خاچكين', 'خاچكين');
                    options[28] = new Option('خشك بيجار', 'خشك بيجار');
                    options[29] = new Option('خطبه سرا', 'خطبه سرا');
                    options[30] = new Option('خمام', 'خمام');
                    options[31] = new Option('ديلمان', 'ديلمان');
                    options[32] = new Option('رانكوه', 'رانكوه');
                    options[33] = new Option('رحيم آباد', 'رحيم آباد');
                    options[34] = new Option('رستم آباد', 'رستم آباد');
                    options[35] = new Option('رشت', 'رشت');
                    options[36] = new Option('رضوان شهر', 'رضوان شهر');
                    options[37] = new Option('رودبار', 'رودبار');
                    options[38] = new Option('رودسر', 'رودسر');
                    options[39] = new Option('سراوان', 'سراوان');
                    options[40] = new Option('سنگر', 'سنگر');
                    options[41] = new Option('سياهكل', 'سياهكل');
                    options[42] = new Option('شاندرمن', 'شاندرمن');
                    options[43] = new Option('شفت', 'شفت');
                    options[44] = new Option('صومعه سرا', 'صومعه سرا');
                    options[45] = new Option('طاهر گوداب', 'طاهر گوداب');
                    options[46] = new Option('طوللات', 'طوللات');
                    options[47] = new Option('فومن', 'فومن');
                    options[48] = new Option('قاسم آبادسفلي', 'قاسم آبادسفلي');
                    options[49] = new Option('كپورچال', 'كپورچال');
                    options[50] = new Option('كلاچاي', 'كلاچاي');
                    options[51] = new Option('كوچصفهان', 'كوچصفهان');
                    options[52] = new Option('كومله', 'كومله');
                    options[53] = new Option('كياشهر', 'كياشهر');
                    options[54] = new Option('گشت', 'گشت');
                    options[55] = new Option('لاهيجان', 'لاهيجان');
                    options[56] = new Option('لشت نشا', 'لشت نشا');
                    options[57] = new Option('لنگرود', 'لنگرود');
                    options[58] = new Option('لوشان', 'لوشان');
                    options[59] = new Option('لولمان', 'لولمان');
                    options[60] = new Option('لوندويل', 'لوندويل');
                    options[61] = new Option('ليسار', 'ليسار');
                    options[62] = new Option('ماسال', 'ماسال');
                    options[63] = new Option('ماسوله', 'ماسوله');
                    options[64] = new Option('منجيل', 'منجيل');
                    options[65] = new Option('هشتپر ـ طوالش', 'هشتپر ـ طوالش');
                    options[66] = new Option('واجارگاه', 'واجارگاه');
                }
                if (state == 3) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ابشاحمد', 'ابشاحمد');
                    options[2] = new Option('اذغان', 'اذغان');
                    options[3] = new Option('اسب فروشان', 'اسب فروشان');
                    options[4] = new Option('اسكو', 'اسكو');
                    options[5] = new Option('اغچه ريش', 'اغچه ريش');
                    options[6] = new Option('اقمنار', 'اقمنار');
                    options[7] = new Option('القو', 'القو');
                    options[8] = new Option('اهر', 'اهر');
                    options[9] = new Option('ايلخچي', 'ايلخچي');
                    options[10] = new Option('آذرشهر', 'آذرشهر');
                    options[11] = new Option('باسمنج', 'باسمنج');
                    options[12] = new Option('بخشايش ـ كلوانق', 'بخشايش ـ كلوانق');
                    options[13] = new Option('بستان آباد', 'بستان آباد');
                    options[14] = new Option('بناب', 'بناب');
                    options[15] = new Option('بناب جديد ـ مرند', 'بناب جديد ـ مرند');
                    options[16] = new Option('تبريز', 'تبريز');
                    options[17] = new Option('ترك', 'ترك');
                    options[18] = new Option('تسوج', 'تسوج');
                    options[19] = new Option('جلفا', 'جلفا');
                    options[20] = new Option('خامنه', 'خامنه');
                    options[21] = new Option('خداآفرين', 'خداآفرين');
                    options[22] = new Option('خسروشهر', 'خسروشهر');
                    options[23] = new Option('خضرلو', 'خضرلو');
                    options[24] = new Option('خلجان', 'خلجان');
                    options[25] = new Option('سبلان', 'سبلان');
                    options[26] = new Option('سراب', 'سراب');
                    options[27] = new Option('سردرود', 'سردرود');
                    options[28] = new Option('سيس', 'سيس');
                    options[29] = new Option('شادبادمشايخ', 'شادبادمشايخ');
                    options[30] = new Option('شبستر', 'شبستر');
                    options[31] = new Option('شربيان', 'شربيان');
                    options[32] = new Option('شرفخانه', 'شرفخانه');
                    options[33] = new Option('شهر جديد سهند', 'شهر جديد سهند');
                    options[34] = new Option('صوفيان', 'صوفيان');
                    options[35] = new Option('عجب شير', 'عجب شير');
                    options[36] = new Option('قره اغاج ـ چاراويماق', 'قره اغاج ـ چاراويماق');
                    options[37] = new Option('قره بابا', 'قره بابا');
                    options[38] = new Option('كردكندي', 'كردكندي');
                    options[39] = new Option('كليبر', 'كليبر');
                    options[40] = new Option('كندرود', 'كندرود');
                    options[41] = new Option('كندوان', 'كندوان');
                    options[42] = new Option('گوگان', 'گوگان');
                    options[43] = new Option('مراغه', 'مراغه');
                    options[44] = new Option('مرند', 'مرند');
                    options[45] = new Option('ملكان', 'ملكان');
                    options[46] = new Option('ممقان', 'ممقان');
                    options[47] = new Option('ميانه', 'ميانه');
                    options[48] = new Option('هاديشهر', 'هاديشهر');
                    options[49] = new Option('هريس', 'هريس');
                    options[50] = new Option('هشترود', 'هشترود');
                    options[51] = new Option('هوراند', 'هوراند');
                    options[52] = new Option('ورزقان', 'ورزقان');
                }
                if (state == 4) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اروندكنار', 'اروندكنار');
                    options[2] = new Option('اميديه', 'اميديه');
                    options[3] = new Option('انديمشك', 'انديمشك');
                    options[4] = new Option('اهواز', 'اهواز');
                    options[5] = new Option('ايذه', 'ايذه');
                    options[6] = new Option('آبادان', 'آبادان');
                    options[7] = new Option('آغاجاري', 'آغاجاري');
                    options[8] = new Option('باغ ملك', 'باغ ملك');
                    options[9] = new Option('بندرامام خميني', 'بندرامام خميني');
                    options[10] = new Option('بهبهان', 'بهبهان');
                    options[11] = new Option('جايزان', 'جايزان');
                    options[12] = new Option('جنت مكان', 'جنت مكان');
                    options[13] = new Option('چمران ـ شهرك طالقاني ', 'چمران ـ شهرك طالقاني ');
                    options[14] = new Option('حميديه', 'حميديه');
                    options[15] = new Option('خرمشهر', 'خرمشهر');
                    options[16] = new Option('دزآب', 'دزآب');
                    options[17] = new Option('دزفول', 'دزفول');
                    options[18] = new Option('دهدز', 'دهدز');
                    options[19] = new Option('رامشير', 'رامشير');
                    options[20] = new Option('رامهرمز', 'رامهرمز');
                    options[21] = new Option('سربندر', 'سربندر');
                    options[22] = new Option('سردشت', 'سردشت');
                    options[23] = new Option('سماله', 'سماله');
                    options[24] = new Option('سوسنگرد ـ دشت آزادگان', 'سوسنگرد ـ دشت آزادگان');
                    options[25] = new Option('شادگان', 'شادگان');
                    options[26] = new Option('شرافت', 'شرافت');
                    options[27] = new Option('شوش', 'شوش');
                    options[28] = new Option('شوشتر', 'شوشتر');
                    options[29] = new Option('شيبان', 'شيبان');
                    options[30] = new Option('صالح مشطت', 'صالح مشطت');
                    options[31] = new Option('كردستان بزرگ', 'كردستان بزرگ');
                    options[32] = new Option('گتوند', 'گتوند');
                    options[33] = new Option('لالي', 'لالي');
                    options[34] = new Option('ماهشهر', 'ماهشهر');
                    options[35] = new Option('مسجد سليمان', 'مسجد سليمان');
                    options[36] = new Option('ملاثاني', 'ملاثاني');
                    options[37] = new Option('ميانكوه', 'ميانكوه');
                    options[38] = new Option('هفتگل', 'هفتگل');
                    options[39] = new Option('هنديجان', 'هنديجان');
                    options[40] = new Option('هويزه', 'هويزه');
                    options[41] = new Option('ويس', 'ويس');
                }
                if (state == 5) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option(' بيضا', ' بيضا');
                    options[2] = new Option('اردكان ـ سپيدان', 'اردكان ـ سپيدان');
                    options[3] = new Option('ارسنجان', 'ارسنجان');
                    options[4] = new Option('استهبان', 'استهبان');
                    options[5] = new Option('اشكنان ـ اهل', 'اشكنان ـ اهل');
                    options[6] = new Option('اقليد', 'اقليد');
                    options[7] = new Option('اكبرآبادكوار', 'اكبرآبادكوار');
                    options[8] = new Option('اوز', 'اوز');
                    options[9] = new Option('ايزدخواست', 'ايزدخواست');
                    options[10] = new Option('آباده', 'آباده');
                    options[11] = new Option('آباده طشك', 'آباده طشك');
                    options[12] = new Option('بالاده', 'بالاده');
                    options[13] = new Option('بانش', 'بانش');
                    options[14] = new Option('بنارويه', 'بنارويه');
                    options[15] = new Option('بهمن', 'بهمن');
                    options[16] = new Option('بوانات', 'بوانات');
                    options[17] = new Option('بوانات(سوريان)', 'بوانات(سوريان)');
                    options[18] = new Option('بيرم', 'بيرم');
                    options[19] = new Option('جنت شهر(دهخير)', 'جنت شهر(دهخير)');
                    options[20] = new Option('جهرم', 'جهرم');
                    options[21] = new Option('جويم', 'جويم');
                    options[22] = new Option('حاجي آباد ـ زرين دشت', 'حاجي آباد ـ زرين دشت');
                    options[23] = new Option('حسن آباد', 'حسن آباد');
                    options[24] = new Option('خرامه', 'خرامه');
                    options[25] = new Option('خرمی', 'خرمی');
                    options[26] = new Option('خشت', 'خشت');
                    options[27] = new Option('خنج', 'خنج');
                    options[28] = new Option('خيرآبادتوللي', 'خيرآبادتوللي');
                    options[29] = new Option('داراب', 'داراب');
                    options[30] = new Option('داريان', 'داريان');
                    options[31] = new Option('دهرم', 'دهرم');
                    options[32] = new Option('رونيز ', 'رونيز ');
                    options[33] = new Option('زاهدشهر', 'زاهدشهر');
                    options[34] = new Option('زرقان', 'زرقان');
                    options[35] = new Option('سروستان', 'سروستان');
                    options[36] = new Option('سعادت شهر ـ پاسارگاد', 'سعادت شهر ـ پاسارگاد');
                    options[37] = new Option('سيدان', 'سيدان');
                    options[38] = new Option('ششده', 'ششده');
                    options[39] = new Option('شهر جديد صدرا', 'شهر جديد صدرا');
                    options[40] = new Option('شيراز', 'شيراز');
                    options[41] = new Option('صغاد', 'صغاد');
                    options[42] = new Option('صفاشهر ـ خرم بيد', 'صفاشهر ـ خرم بيد');
                    options[43] = new Option('طسوج', 'طسوج');
                    options[44] = new Option('علاءمرودشت', 'علاءمرودشت');
                    options[45] = new Option('فدامي', 'فدامي');
                    options[46] = new Option('فراشبند', 'فراشبند');
                    options[47] = new Option('فسا', 'فسا');
                    options[48] = new Option('فيروزآباد', 'فيروزآباد');
                    options[49] = new Option('فيشور', 'فيشور');
                    options[50] = new Option('قادرآباد', 'قادرآباد');
                    options[51] = new Option('قائميه', 'قائميه');
                    options[52] = new Option('قطب آباد', 'قطب آباد');
                    options[53] = new Option('قطرويه', 'قطرويه');
                    options[54] = new Option('قير و كارزين', 'قير و كارزين');
                    options[55] = new Option('كازرون', 'كازرون');
                    options[56] = new Option('كام فيروز', 'كام فيروز');
                    options[57] = new Option('كلاني', 'كلاني');
                    options[58] = new Option('كنارتخته', 'كنارتخته');
                    options[59] = new Option('كوار', 'كوار');
                    options[60] = new Option('گراش', 'گراش');
                    options[61] = new Option('گويم', 'گويم');
                    options[62] = new Option('لار ـ لارستان', 'لار ـ لارستان');
                    options[63] = new Option('لامرد', 'لامرد');
                    options[64] = new Option('مبارك آباد', 'مبارك آباد');
                    options[65] = new Option('مرودشت', 'مرودشت');
                    options[66] = new Option('مشكان', 'مشكان');
                    options[67] = new Option('مصيري ـ رستم', 'مصيري ـ رستم');
                    options[68] = new Option('مظفري', 'مظفري');
                    options[69] = new Option('مهر', 'مهر');
                    options[70] = new Option('ميمند', 'ميمند');
                    options[71] = new Option('نورآباد ـ ممسني', 'نورآباد ـ ممسني');
                    options[72] = new Option('ني ريز', 'ني ريز');
                    options[73] = new Option('وراوي', 'وراوي');
                }
                if (state == 6) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ابريشم', 'ابريشم');
                    options[2] = new Option('ابوزيدآباد', 'ابوزيدآباد');
                    options[3] = new Option('اردستان', 'اردستان');
                    options[4] = new Option('اريسمان', 'اريسمان');
                    options[5] = new Option('اژيه', 'اژيه');
                    options[6] = new Option('اسفرجان', 'اسفرجان');
                    options[7] = new Option('اسلام آباد', 'اسلام آباد');
                    options[8] = new Option('اشن', 'اشن');
                    options[9] = new Option('اصغرآباد', 'اصغرآباد');
                    options[10] = new Option('اصفهان', 'اصفهان');
                    options[11] = new Option('امين آباد', 'امين آباد');
                    options[12] = new Option('ايمان شهر', 'ايمان شهر');
                    options[13] = new Option('آران وبيدگل', 'آران وبيدگل');
                    options[14] = new Option('بادرود', 'بادرود');
                    options[15] = new Option('باغ بهادران', 'باغ بهادران');
                    options[16] = new Option('بهارستان', 'بهارستان');
                    options[17] = new Option('بوئين ومياندشت', 'بوئين ومياندشت');
                    options[18] = new Option('پيربكران', 'پيربكران');
                    options[19] = new Option('تودشك', 'تودشك');
                    options[20] = new Option('تيران', 'تيران');
                    options[21] = new Option('جعفرآباد', 'جعفرآباد');
                    options[22] = new Option('جندق', 'جندق');
                    options[23] = new Option('جوجيل', 'جوجيل');
                    options[24] = new Option('چادگان', 'چادگان');
                    options[25] = new Option('چرمهين', 'چرمهين');
                    options[26] = new Option('چمگردان', 'چمگردان');
                    options[27] = new Option('حسن اباد', 'حسن اباد');
                    options[28] = new Option('خالدآباد', 'خالدآباد');
                    options[29] = new Option('خميني شهر', 'خميني شهر');
                    options[30] = new Option('خوانسار', 'خوانسار');
                    options[31] = new Option('خوانسارك', 'خوانسارك');
                    options[32] = new Option('خور', 'خور');
                    options[33] = new Option('خوراسگان', 'خوراسگان');
                    options[34] = new Option('خورزوق', 'خورزوق');
                    options[35] = new Option('داران ـ فريدن', 'داران ـ فريدن');
                    options[36] = new Option('درچه پياز', 'درچه پياز');
                    options[37] = new Option('دستگردوبرخوار', 'دستگردوبرخوار');
                    options[38] = new Option('دهاقان', 'دهاقان');
                    options[39] = new Option('دهق', 'دهق');
                    options[40] = new Option('دولت آباد', 'دولت آباد');
                    options[41] = new Option('ديزيچه', 'ديزيچه');
                    options[42] = new Option('رزوه', 'رزوه');
                    options[43] = new Option('رضوان شهر', 'رضوان شهر');
                    options[44] = new Option('رهنان', 'رهنان');
                    options[45] = new Option('زاينده رود', 'زاينده رود');
                    options[46] = new Option('زرين شهر ـ لنجان', 'زرين شهر ـ لنجان');
                    options[47] = new Option('زواره', 'زواره');
                    options[48] = new Option('زيار', 'زيار');
                    options[49] = new Option('زيبا شهر', 'زيبا شهر');
                    options[50] = new Option('سپاهان شهر', 'سپاهان شهر');
                    options[51] = new Option('سده لنجان', 'سده لنجان');
                    options[52] = new Option('سميرم', 'سميرم');
                    options[53] = new Option('شاهين شهر', 'شاهين شهر');
                    options[54] = new Option('شهرضا', 'شهرضا');
                    options[55] = new Option('شهرك صنعتي مورچ', 'شهرك صنعتي مورچ');
                    options[56] = new Option('شهرك مجلسي', 'شهرك مجلسي');
                    options[57] = new Option('شهرک صنعتي محمودآباد', 'شهرک صنعتي محمودآباد');
                    options[58] = new Option('طالخونچه', 'طالخونچه');
                    options[59] = new Option('عسگران', 'عسگران');
                    options[60] = new Option('علويچه', 'علويچه');
                    options[61] = new Option('غرغن', 'غرغن');
                    options[62] = new Option('فرخي', 'فرخي');
                    options[63] = new Option('فريدون شهر', 'فريدون شهر');
                    options[64] = new Option('فلاورجان', 'فلاورجان');
                    options[65] = new Option('فولادشهر', 'فولادشهر');
                    options[66] = new Option('فولادمباركه', 'فولادمباركه');
                    options[67] = new Option('قهد ريجان', 'قهد ريجان');
                    options[68] = new Option('كاشان', 'كاشان');
                    options[69] = new Option('كليشادوسودرجان', 'كليشادوسودرجان');
                    options[70] = new Option('كمشچه', 'كمشچه');
                    options[71] = new Option('كوهپايه', 'كوهپايه');
                    options[72] = new Option('گز', 'گز');
                    options[73] = new Option('گلپايگان', 'گلپايگان');
                    options[74] = new Option('گلدشت', 'گلدشت');
                    options[75] = new Option('گلشهر', 'گلشهر');
                    options[76] = new Option('گوگد', 'گوگد');
                    options[77] = new Option('مباركه', 'مباركه');
                    options[78] = new Option('مهاباد', 'مهاباد');
                    options[79] = new Option('مورچه خورت', 'مورچه خورت');
                    options[80] = new Option('ميمه', 'ميمه');
                    options[81] = new Option('نائين', 'نائين');
                    options[82] = new Option('نجف آباد', 'نجف آباد');
                    options[83] = new Option('نصر آباد', 'نصر آباد');
                    options[84] = new Option('نطنز', 'نطنز');
                    options[85] = new Option('نيك آباد', 'نيك آباد');
                    options[86] = new Option('بهارستان', 'بهارستان');
                    options[87] = new Option('هرند', 'هرند');
                    options[88] = new Option('ورزنه', 'ورزنه');
                    options[89] = new Option('ورنامخواست', 'ورنامخواست');
                    options[90] = new Option('ویلاشهر', 'ویلاشهر');
                }
                if (state == 7) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ابدال آباد', 'ابدال آباد');
                    options[2] = new Option('ازادوار', 'ازادوار');
                    options[3] = new Option('باجگيران', 'باجگيران');
                    options[4] = new Option('باخرز', 'باخرز');
                    options[5] = new Option('باسفر', 'باسفر');
                    options[6] = new Option('بجستان', 'بجستان');
                    options[7] = new Option('بردسكن', 'بردسكن');
                    options[8] = new Option('برون', 'برون');
                    options[9] = new Option('بزنگان', 'بزنگان');
                    options[10] = new Option('بند قرائ', 'بند قرائ');
                    options[11] = new Option('بيدخت', 'بيدخت');
                    options[12] = new Option('تايباد', 'تايباد');
                    options[13] = new Option('تربت جام', 'تربت جام');
                    options[14] = new Option('تربت حيدريه', 'تربت حيدريه');
                    options[15] = new Option('جغتاي', 'جغتاي');
                    options[16] = new Option('جنگل', 'جنگل');
                    options[17] = new Option('چمن آباد', 'چمن آباد');
                    options[18] = new Option('چناران', 'چناران');
                    options[19] = new Option('خليل آباد', 'خليل آباد');
                    options[20] = new Option('خواف', 'خواف');
                    options[21] = new Option('داورزن', 'داورزن');
                    options[22] = new Option('درگز', 'درگز');
                    options[23] = new Option('دولت آباد ـ زاوه', 'دولت آباد ـ زاوه');
                    options[24] = new Option('رادكان', 'رادكان');
                    options[25] = new Option('رشتخوار', 'رشتخوار');
                    options[26] = new Option('رضويه', 'رضويه');
                    options[27] = new Option('ريوش(كوهسرخ)', 'ريوش(كوهسرخ)');
                    options[28] = new Option('سبزوار', 'سبزوار');
                    options[29] = new Option('سرخس', 'سرخس');
                    options[30] = new Option('سلطان آباد', 'سلطان آباد');
                    options[31] = new Option('سنگان', 'سنگان');
                    options[32] = new Option('شانديز', 'شانديز');
                    options[33] = new Option('صالح آباد', 'صالح آباد');
                    options[34] = new Option('طرقبه ـ بينالود', 'طرقبه ـ بينالود');
                    options[35] = new Option('طوس سفلي', 'طوس سفلي');
                    options[36] = new Option('فريمان', 'فريمان');
                    options[37] = new Option('فيروزه ـ تخت جلگه', 'فيروزه ـ تخت جلگه');
                    options[38] = new Option('فيض آباد ـ مه ولات', 'فيض آباد ـ مه ولات');
                    options[39] = new Option('قاسم آباد', 'قاسم آباد');
                    options[40] = new Option('قدمگاه', 'قدمگاه');
                    options[41] = new Option('قوچان', 'قوچان');
                    options[42] = new Option('كاخك', 'كاخك');
                    options[43] = new Option('كاشمر', 'كاشمر');
                    options[44] = new Option('كلات', 'كلات');
                    options[45] = new Option('گلبهار', 'گلبهار');
                    options[46] = new Option('گناباد', 'گناباد');
                    options[47] = new Option('لطف آباد', 'لطف آباد');
                    options[48] = new Option('مشهد', 'مشهد');
                    options[49] = new Option('مشهدريزه', 'مشهدريزه');
                    options[50] = new Option('مصعبي', 'مصعبي');
                    options[51] = new Option('نشتيفان', 'نشتيفان');
                    options[52] = new Option('نقاب ـ جوين', 'نقاب ـ جوين');
                    options[53] = new Option('نيشابور', 'نيشابور');
                    options[54] = new Option('نيل شهر', 'نيل شهر');
                }
                if (state == 8) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('َآوج', 'َآوج');
                    options[2] = new Option('ارداق', 'ارداق');
                    options[3] = new Option('اسفرورين', 'اسفرورين');
                    options[4] = new Option('اقباليه', 'اقباليه');
                    options[5] = new Option('الوند ـ البرز', 'الوند ـ البرز');
                    options[6] = new Option('آبگرم', 'آبگرم');
                    options[7] = new Option('آبيك', 'آبيك');
                    options[8] = new Option('آقابابا', 'آقابابا');
                    options[9] = new Option('بوئين زهرا', 'بوئين زهرا');
                    options[10] = new Option('بیدستان', 'بیدستان');
                    options[11] = new Option('تاكستان', 'تاكستان');
                    options[12] = new Option('حصاروليعصر', 'حصاروليعصر');
                    options[13] = new Option('خاكعلي', 'خاكعلي');
                    options[14] = new Option('خرم دشت', 'خرم دشت');
                    options[15] = new Option('دانسفهان', 'دانسفهان');
                    options[16] = new Option('سيردان', 'سيردان');
                    options[17] = new Option('شال', 'شال');
                    options[18] = new Option('شهر صنعتي البرز', 'شهر صنعتي البرز');
                    options[19] = new Option('ضياآباد', 'ضياآباد');
                    options[20] = new Option('قزوين', 'قزوين');
                    options[21] = new Option('ليا', 'ليا');
                    options[22] = new Option('محمديه', 'محمديه');
                    options[23] = new Option('محمود آباد نمونه', 'محمود آباد نمونه');
                    options[24] = new Option('معلم كلايه', 'معلم كلايه');
                    options[25] = new Option('نرجه', 'نرجه');
                }
                if (state == 9) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ارادان', 'ارادان');
                    options[2] = new Option('اميريه', 'اميريه');
                    options[3] = new Option('ايوانكي', 'ايوانكي');
                    options[4] = new Option('بسطام', 'بسطام');
                    options[5] = new Option('بيارجمند', 'بيارجمند');
                    options[6] = new Option('خيرآباد', 'خيرآباد');
                    options[7] = new Option('دامغان', 'دامغان');
                    options[8] = new Option('درجزين', 'درجزين');
                    options[9] = new Option('سرخه', 'سرخه');
                    options[10] = new Option('سمنان', 'سمنان');
                    options[11] = new Option('شاهرود', 'شاهرود');
                    options[12] = new Option('شهميرزاد', 'شهميرزاد');
                    options[13] = new Option('گرمسار', 'گرمسار');
                    options[14] = new Option('مجن', 'مجن');
                    options[15] = new Option('مهدي شهر', 'مهدي شهر');
                    options[16] = new Option('ميامي', 'ميامي');
                    options[17] = new Option('ميغان', 'ميغان');
                }
                if (state == 10) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('دستجرد', 'دستجرد');
                    options[2] = new Option('سلفچگان', 'سلفچگان');
                    options[3] = new Option('شهر جعفریه', 'شهر جعفریه');
                    options[4] = new Option('قم', 'قم');
                    options[5] = new Option('قنوات', 'قنوات');
                    options[6] = new Option('كهك', 'كهك');
                }
                if (state == 11) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اراك', 'اراك');
                    options[2] = new Option('آستانه', 'آستانه');
                    options[3] = new Option('آشتيان', 'آشتيان');
                    options[4] = new Option('تفرش', 'تفرش');
                    options[5] = new Option('توره', 'توره');
                    options[6] = new Option('جاورسيان', 'جاورسيان');
                    options[7] = new Option('خسروبيك', 'خسروبيك');
                    options[8] = new Option('خشك رود', 'خشك رود');
                    options[9] = new Option('خمين', 'خمين');
                    options[10] = new Option('خنداب', 'خنداب');
                    options[11] = new Option('دليجان', 'دليجان');
                    options[12] = new Option('ريحان عليا', 'ريحان عليا');
                    options[13] = new Option('زاويه', 'زاويه');
                    options[14] = new Option('ساوه', 'ساوه');
                    options[15] = new Option('شازند', 'شازند');
                    options[16] = new Option('شهراب', 'شهراب');
                    options[17] = new Option('شهرك مهاجران', 'شهرك مهاجران');
                    options[18] = new Option('فرمهين', 'فرمهين');
                    options[19] = new Option('كميجان', 'كميجان');
                    options[20] = new Option('مامونيه ـ زرنديه', 'مامونيه ـ زرنديه');
                    options[21] = new Option('محلات', 'محلات');
                    options[22] = new Option('ميلاجرد', 'ميلاجرد');
                    options[23] = new Option('هندودر', 'هندودر');
                }
                if (state == 12) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option(' آب بر ـ طارم', ' آب بر ـ طارم');
                    options[2] = new Option('ابهر', 'ابهر');
                    options[3] = new Option('اسفجين', 'اسفجين');
                    options[4] = new Option('پري', 'پري');
                    options[5] = new Option('حلب', 'حلب');
                    options[6] = new Option('خرمدره', 'خرمدره');
                    options[7] = new Option('دستجرده', 'دستجرده');
                    options[8] = new Option('دندي', 'دندي');
                    options[9] = new Option('زرين آباد ـ ايجرود', 'زرين آباد ـ ايجرود');
                    options[10] = new Option('زرين رود', 'زرين رود');
                    options[11] = new Option('زنجان', 'زنجان');
                    options[12] = new Option('سلطانيه', 'سلطانيه');
                    options[13] = new Option('صائين قلعه', 'صائين قلعه');
                    options[14] = new Option('قيدار', 'قيدار');
                    options[15] = new Option('گرماب', 'گرماب');
                    options[16] = new Option('گيلوان', 'گيلوان');
                    options[17] = new Option('ماهنشان', 'ماهنشان');
                    options[18] = new Option('همايون', 'همايون');
                    options[19] = new Option('هيدج', 'هيدج');
                }
                if (state == 13) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اسلام آباد', 'اسلام آباد');
                    options[2] = new Option('اميركلا', 'اميركلا');
                    options[3] = new Option('ايزدشهر', 'ايزدشهر');
                    options[4] = new Option('آمل', 'آمل');
                    options[5] = new Option('آهنگركلا', 'آهنگركلا');
                    options[6] = new Option('بابل', 'بابل');
                    options[7] = new Option('بابلسر', 'بابلسر');
                    options[8] = new Option('بلده', 'بلده');
                    options[9] = new Option('بهشهر', 'بهشهر');
                    options[10] = new Option('بهنمير', 'بهنمير');
                    options[11] = new Option('پل سفيد ـ سوادكوه', 'پل سفيد ـ سوادكوه');
                    options[12] = new Option('تنكابن', 'تنكابن');
                    options[13] = new Option('جويبار', 'جويبار');
                    options[14] = new Option('چالوس', 'چالوس');
                    options[15] = new Option('چمستان', 'چمستان');
                    options[16] = new Option('خرم آباد', 'خرم آباد');
                    options[17] = new Option('خوشرودپی', 'خوشرودپی');
                    options[18] = new Option('رامسر', 'رامسر');
                    options[19] = new Option('رستم كلا', 'رستم كلا');
                    options[20] = new Option('رويانشهر', 'رويانشهر');
                    options[21] = new Option('زاغمرز', 'زاغمرز');
                    options[22] = new Option('زرگر محله', 'زرگر محله');
                    options[23] = new Option('زيرآب', 'زيرآب');
                    options[24] = new Option('سادات محله', 'سادات محله');
                    options[25] = new Option('ساري', 'ساري');
                    options[26] = new Option('سرخرود', 'سرخرود');
                    options[27] = new Option('سلمانشهر', 'سلمانشهر');
                    options[28] = new Option('سنگده', 'سنگده');
                    options[29] = new Option('سوا', 'سوا');
                    options[30] = new Option('سورك', 'سورك');
                    options[31] = new Option('شيرگاه', 'شيرگاه');
                    options[32] = new Option('شيرود', 'شيرود');
                    options[33] = new Option('عباس آباد', 'عباس آباد');
                    options[34] = new Option('فريدون كنار', 'فريدون كنار');
                    options[35] = new Option('قائم شهر', 'قائم شهر');
                    options[36] = new Option('كلارآباد', 'كلارآباد');
                    options[37] = new Option('كلاردشت', 'كلاردشت');
                    options[38] = new Option('كيا كلا', 'كيا كلا');
                    options[39] = new Option('كياسر', 'كياسر');
                    options[40] = new Option('گزنك', 'گزنك');
                    options[41] = new Option('گلوگاه', 'گلوگاه');
                    options[42] = new Option('گهرباران', 'گهرباران');
                    options[43] = new Option('محمودآباد', 'محمودآباد');
                    options[44] = new Option('مرزن آباد', 'مرزن آباد');
                    options[45] = new Option('مرزي كلا', 'مرزي كلا');
                    options[46] = new Option('نشتارود', 'نشتارود');
                    options[47] = new Option('نكاء', 'نكاء');
                    options[48] = new Option('نور', 'نور');
                    options[49] = new Option('نوشهر', 'نوشهر');
                }
                if (state == 14) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('انبار آلوم', 'انبار آلوم');
                    options[2] = new Option('اينچه برون', 'اينچه برون');
                    options[3] = new Option('آزادشهر', 'آزادشهر');
                    options[4] = new Option('آق قلا', 'آق قلا');
                    options[5] = new Option('بندر گز', 'بندر گز');
                    options[6] = new Option('بندرتركمن', 'بندرتركمن');
                    options[7] = new Option('جلين', 'جلين');
                    options[8] = new Option('خان ببين', 'خان ببين');
                    options[9] = new Option('راميان', 'راميان');
                    options[10] = new Option('سيمين شهر', 'سيمين شهر');
                    options[11] = new Option('علي آباد', 'علي آباد');
                    options[12] = new Option('فاضل آباد', 'فاضل آباد');
                    options[13] = new Option('كردكوي', 'كردكوي');
                    options[14] = new Option('كلاله', 'كلاله');
                    options[15] = new Option('گاليكش', 'گاليكش');
                    options[16] = new Option('گرگان', 'گرگان');
                    options[17] = new Option('گميش تپه', 'گميش تپه');
                    options[18] = new Option('گنبدكاوس', 'گنبدكاوس');
                    options[19] = new Option('مراوه تپه', 'مراوه تپه');
                    options[20] = new Option('مينودشت', 'مينودشت');
                }
                if (state == 15) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ابي بيگلو', 'ابي بيگلو');
                    options[2] = new Option('اردبيل', 'اردبيل');
                    options[3] = new Option('اصلاندوز', 'اصلاندوز');
                    options[4] = new Option('بيله سوار', 'بيله سوار');
                    options[5] = new Option('پارس آباد', 'پارس آباد');
                    options[6] = new Option('تازه كند انگوت', 'تازه كند انگوت');
                    options[7] = new Option('جعفرآباد', 'جعفرآباد');
                    options[8] = new Option('خلخال', 'خلخال');
                    options[9] = new Option('سرعين', 'سرعين');
                    options[10] = new Option('شهرك شهيد غفاري', 'شهرك شهيد غفاري');
                    options[11] = new Option('كلور', 'كلور');
                    options[12] = new Option('كوارئيم', 'كوارئيم');
                    options[13] = new Option('گرمي ', 'گرمي ');
                    options[14] = new Option('گيوي ـ كوثر', 'گيوي ـ كوثر');
                    options[15] = new Option('لاهرود', 'لاهرود');
                    options[16] = new Option('مشگين شهر', 'مشگين شهر');
                    options[17] = new Option('نمين', 'نمين');
                    options[18] = new Option('نير', 'نير');
                    options[19] = new Option('هشتجين', 'هشتجين');
                }
                if (state == 16) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اروميه', 'اروميه');
                    options[2] = new Option('اشنويه', 'اشنويه');
                    options[3] = new Option('ايواوغلي', 'ايواوغلي');
                    options[4] = new Option('بازرگان', 'بازرگان');
                    options[5] = new Option('بوكان', 'بوكان');
                    options[6] = new Option('پسوه', 'پسوه');
                    options[7] = new Option('پلدشت', 'پلدشت');
                    options[8] = new Option('پيرانشهر', 'پيرانشهر');
                    options[9] = new Option('تازه شهر', 'تازه شهر');
                    options[10] = new Option('تكاب', 'تكاب');
                    options[11] = new Option('چهاربرج قديم', 'چهاربرج قديم');
                    options[12] = new Option('خوي', 'خوي');
                    options[13] = new Option('ديزج', 'ديزج');
                    options[14] = new Option('ديزجديز', 'ديزجديز');
                    options[15] = new Option('ربط', 'ربط');
                    options[16] = new Option('زيوه', 'زيوه');
                    options[17] = new Option('سردشت', 'سردشت');
                    options[18] = new Option('سلماس', 'سلماس');
                    options[19] = new Option('سيلوانا', 'سيلوانا');
                    options[20] = new Option('سيلوه', 'سيلوه');
                    options[21] = new Option('سيه چشمه ـ چالدران', 'سيه چشمه ـ چالدران');
                    options[22] = new Option('شاهين دژ', 'شاهين دژ');
                    options[23] = new Option('شوط', 'شوط');
                    options[24] = new Option('قره ضياء الدين ـ چايپاره', 'قره ضياء الدين ـ چايپاره');
                    options[25] = new Option('قوشچي', 'قوشچي');
                    options[26] = new Option('كشاورز (اقبال)', 'كشاورز (اقبال)');
                    options[27] = new Option('ماكو', 'ماكو');
                    options[28] = new Option('محمد يار', 'محمد يار');
                    options[29] = new Option('محمودآباد', 'محمودآباد');
                    options[30] = new Option('مهاباد', 'مهاباد');
                    options[31] = new Option('مياندوآب', 'مياندوآب');
                    options[32] = new Option('مياوق', 'مياوق');
                    options[33] = new Option('ميرآباد', 'ميرآباد');
                    options[34] = new Option('نقده', 'نقده');
                    options[35] = new Option('نوشين شهر', 'نوشين شهر');
                }
                if (state == 17) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ازندريان', 'ازندريان');
                    options[2] = new Option('اسدآباد', 'اسدآباد');
                    options[3] = new Option('اسلام آباد', 'اسلام آباد');
                    options[4] = new Option('بهار', 'بهار');
                    options[5] = new Option('پايگاه نوژه', 'پايگاه نوژه');
                    options[6] = new Option('تويسركان', 'تويسركان');
                    options[7] = new Option('دمق', 'دمق');
                    options[8] = new Option('رزن', 'رزن');
                    options[9] = new Option('سامن', 'سامن');
                    options[10] = new Option('سركان', 'سركان');
                    options[11] = new Option('شيرين سو', 'شيرين سو');
                    options[12] = new Option('صالح آباد', 'صالح آباد');
                    options[13] = new Option('فامنين', 'فامنين');
                    options[14] = new Option('قروه درجزين', 'قروه درجزين');
                    options[15] = new Option('قهاوند', 'قهاوند');
                    options[16] = new Option('كبودرآهنگ', 'كبودرآهنگ');
                    options[17] = new Option('گيان', 'گيان');
                    options[18] = new Option('لالجين', 'لالجين');
                    options[19] = new Option('ملاير', 'ملاير');
                    options[20] = new Option('نهاوند', 'نهاوند');
                    options[21] = new Option('همدان', 'همدان');
                }
                if (state == 18) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اورامانتخت', 'اورامانتخت');
                    options[2] = new Option('بانه', 'بانه');
                    options[3] = new Option('بلبان آباد', 'بلبان آباد');
                    options[4] = new Option('بيجار', 'بيجار');
                    options[5] = new Option('دلبران', 'دلبران');
                    options[6] = new Option('دهگلان', 'دهگلان');
                    options[7] = new Option('ديواندره', 'ديواندره');
                    options[8] = new Option('سروآباد', 'سروآباد');
                    options[9] = new Option('سريش آباد', 'سريش آباد');
                    options[10] = new Option('سقز', 'سقز');
                    options[11] = new Option('سنندج', 'سنندج');
                    options[12] = new Option('قروه', 'قروه');
                    options[13] = new Option('كامياران', 'كامياران');
                    options[14] = new Option('مريوان', 'مريوان');
                    options[15] = new Option('موچش', 'موچش');
                }
                if (state == 19) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اسلام آباد غرب', 'اسلام آباد غرب');
                    options[2] = new Option('باينگان', 'باينگان');
                    options[3] = new Option('بيستون', 'بيستون');
                    options[4] = new Option('پاوه', 'پاوه');
                    options[5] = new Option('تازه آباد ـ ثلاث باباجاني', 'تازه آباد ـ ثلاث باباجاني');
                    options[6] = new Option('جوانرود', 'جوانرود');
                    options[7] = new Option('روانسر', 'روانسر');
                    options[8] = new Option('ريجاب', 'ريجاب');
                    options[9] = new Option('سراب ذهاب', 'سراب ذهاب');
                    options[10] = new Option('سرپل ذهاب', 'سرپل ذهاب');
                    options[11] = new Option('سنقر', 'سنقر');
                    options[12] = new Option('صحنه', 'صحنه');
                    options[13] = new Option('فرامان', 'فرامان');
                    options[14] = new Option('فش', 'فش');
                    options[15] = new Option('قصرشيرين', 'قصرشيرين');
                    options[16] = new Option('كرمانشاه', 'كرمانشاه');
                    options[17] = new Option('كنگاور', 'كنگاور');
                    options[18] = new Option('گيلانغرب', 'گيلانغرب');
                    options[19] = new Option('نودشه', 'نودشه');
                    options[20] = new Option('هرسين', 'هرسين');
                    options[21] = new Option('هلشي', 'هلشي');
                }
                if (state == 20) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ازنا', 'ازنا');
                    options[2] = new Option('الشتر ـ سلسله', 'الشتر ـ سلسله');
                    options[3] = new Option('اليگودرز', 'اليگودرز');
                    options[4] = new Option('برخوردار', 'برخوردار');
                    options[5] = new Option('بروجرد', 'بروجرد');
                    options[6] = new Option('پل دختر', 'پل دختر');
                    options[7] = new Option('تقي آباد', 'تقي آباد');
                    options[8] = new Option('چغلوندی', 'چغلوندی');
                    options[9] = new Option('چقابل', 'چقابل');
                    options[10] = new Option('خرم آباد', 'خرم آباد');
                    options[11] = new Option('دورود', 'دورود');
                    options[12] = new Option('زاغه', 'زاغه');
                    options[13] = new Option('سپيددشت', 'سپيددشت');
                    options[14] = new Option('شول آباد', 'شول آباد');
                    options[15] = new Option('كوناني', 'كوناني');
                    options[16] = new Option('كوهدشت', 'كوهدشت');
                    options[17] = new Option('معمولان', 'معمولان');
                    options[18] = new Option('نورآباد ـ دلفان', 'نورآباد ـ دلفان');
                    options[19] = new Option('واشيان نصيرتپه', 'واشيان نصيرتپه');
                }
                if (state == 21) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ابدان', 'ابدان');
                    options[2] = new Option('اهرم ـ تنگستان', 'اهرم ـ تنگستان');
                    options[3] = new Option('آباد', 'آباد');
                    options[4] = new Option('آبپخش', 'آبپخش');
                    options[5] = new Option('بادوله', 'بادوله');
                    options[6] = new Option('برازجان ـ دشتستان', 'برازجان ـ دشتستان');
                    options[7] = new Option('بردخون', 'بردخون');
                    options[8] = new Option('بندردير', 'بندردير');
                    options[9] = new Option('بندرديلم', 'بندرديلم');
                    options[10] = new Option('بندرريگ', 'بندرريگ');
                    options[11] = new Option('بندركنگان', 'بندركنگان');
                    options[12] = new Option('بندرگناوه', 'بندرگناوه');
                    options[13] = new Option('بوشهر', 'بوشهر');
                    options[14] = new Option('تنگ ارم', 'تنگ ارم');
                    options[15] = new Option('جزيره خارك', 'جزيره خارك');
                    options[16] = new Option('جم', 'جم');
                    options[17] = new Option('چغارك', 'چغارك');
                    options[18] = new Option('خورموج ـ دشتي', 'خورموج ـ دشتي');
                    options[19] = new Option('دلوار', 'دلوار');
                    options[20] = new Option('ريز', 'ريز');
                    options[21] = new Option('سعدآباد', 'سعدآباد');
                    options[22] = new Option('شبانكاره', 'شبانكاره');
                    options[23] = new Option('شنبه', 'شنبه');
                    options[24] = new Option('شول', 'شول');
                    options[25] = new Option('عالی شهر', 'عالی شهر');
                    options[26] = new Option('عسلويه', 'عسلويه');
                    options[27] = new Option('كاكي', 'كاكي');
                    options[28] = new Option('كلمه', 'كلمه');
                    options[29] = new Option('نخل تقي', 'نخل تقي');
                    options[30] = new Option('وحدتيه', 'وحدتيه');
                }
                if (state == 22) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اختيارآباد', 'اختيارآباد');
                    options[2] = new Option('ارزوئیه', 'ارزوئیه');
                    options[3] = new Option('امين شهر', 'امين شهر');
                    options[4] = new Option('انار', 'انار');
                    options[5] = new Option('باغين', 'باغين');
                    options[6] = new Option('بافت', 'بافت');
                    options[7] = new Option('بردسير', 'بردسير');
                    options[8] = new Option('بلوك', 'بلوك');
                    options[9] = new Option('بم', 'بم');
                    options[10] = new Option('بهرمان', 'بهرمان');
                    options[11] = new Option('پاريز', 'پاريز');
                    options[12] = new Option('جواديه فلاح', 'جواديه فلاح');
                    options[13] = new Option('جوشان', 'جوشان');
                    options[14] = new Option('جيرفت', 'جيرفت');
                    options[15] = new Option('چترود', 'چترود');
                    options[16] = new Option('خانوك', 'خانوك');
                    options[17] = new Option('دوساري', 'دوساري');
                    options[18] = new Option('رابر', 'رابر');
                    options[19] = new Option('راور', 'راور');
                    options[20] = new Option('راين', 'راين');
                    options[21] = new Option('رفسنجان', 'رفسنجان');
                    options[22] = new Option('رودبار', 'رودبار');
                    options[23] = new Option('ريگان', 'ريگان');
                    options[24] = new Option('زرند', 'زرند');
                    options[25] = new Option('زنگي آباد', 'زنگي آباد');
                    options[26] = new Option('سرچشمه', 'سرچشمه');
                    options[27] = new Option('سريز', 'سريز');
                    options[28] = new Option('سيرجان', 'سيرجان');
                    options[29] = new Option('شهربابك', 'شهربابك');
                    options[30] = new Option('صفائيه', 'صفائيه');
                    options[31] = new Option('عنبرآباد', 'عنبرآباد');
                    options[32] = new Option('فارياب', 'فارياب');
                    options[33] = new Option('فهرج', 'فهرج');
                    options[34] = new Option('قلعه گنج', 'قلعه گنج');
                    options[35] = new Option('كاظم آباد', 'كاظم آباد');
                    options[36] = new Option('كرمان', 'كرمان');
                    options[37] = new Option('كهنوج', 'كهنوج');
                    options[38] = new Option('كهنوج( مغزآباد)', 'كهنوج( مغزآباد)');
                    options[39] = new Option('كوهبنان', 'كوهبنان');
                    options[40] = new Option('كيان شهر', 'كيان شهر');
                    options[41] = new Option('گلباف', 'گلباف');
                    options[42] = new Option('ماهان', 'ماهان');
                    options[43] = new Option('محمدآباد ـ ريگان', 'محمدآباد ـ ريگان');
                    options[44] = new Option('محي آباد', 'محي آباد');
                    options[45] = new Option('منوجان', 'منوجان');
                    options[46] = new Option('نجف شهر', 'نجف شهر');
                    options[47] = new Option('نگار', 'نگار');
                }
                if (state == 23) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ابوموسي', 'ابوموسي');
                    options[2] = new Option('ايسين', 'ايسين');
                    options[3] = new Option('بستك', 'بستك');
                    options[4] = new Option('بندرخمير', 'بندرخمير');
                    options[5] = new Option('بندرعباس', 'بندرعباس');
                    options[6] = new Option('بندرلنگه', 'بندرلنگه');
                    options[7] = new Option('بندزك كهنه', 'بندزك كهنه');
                    options[8] = new Option('پارسيان', 'پارسيان');
                    options[9] = new Option('پدل', 'پدل');
                    options[10] = new Option('پل شرقي', 'پل شرقي');
                    options[11] = new Option('تياب', 'تياب');
                    options[12] = new Option('جاسك', 'جاسك');
                    options[13] = new Option('جزيره سيري', 'جزيره سيري');
                    options[14] = new Option('جزيره لاوان', 'جزيره لاوان');
                    options[15] = new Option('جزيره هنگام', 'جزيره هنگام');
                    options[16] = new Option('جزيرهلارك', 'جزيرهلارك');
                    options[17] = new Option('جناح', 'جناح');
                    options[18] = new Option('چارك', 'چارك');
                    options[19] = new Option('حاجي آباد', 'حاجي آباد');
                    options[20] = new Option('درگهان', 'درگهان');
                    options[21] = new Option('دشتي', 'دشتي');
                    options[22] = new Option('دهبارز ـ رودان', 'دهبارز ـ رودان');
                    options[23] = new Option('رويدر', 'رويدر');
                    options[24] = new Option('زيارت علي', 'زيارت علي');
                    options[25] = new Option('سردشت ـ بشاگرد', 'سردشت ـ بشاگرد');
                    options[26] = new Option('سندرك', 'سندرك');
                    options[27] = new Option('سيريك', 'سيريك');
                    options[28] = new Option('فارغان', 'فارغان');
                    options[29] = new Option('فين', 'فين');
                    options[30] = new Option('قشم', 'قشم');
                    options[31] = new Option('كنگ', 'كنگ');
                    options[32] = new Option('كيش', 'كيش');
                    options[33] = new Option('ميناب', 'ميناب');
                }
                if (state == 24) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اردل', 'اردل');
                    options[2] = new Option('آلوني', 'آلوني');
                    options[3] = new Option('باباحيدر', 'باباحيدر');
                    options[4] = new Option('بروجن', 'بروجن');
                    options[5] = new Option('بلداجي', 'بلداجي');
                    options[6] = new Option('بن', 'بن');
                    options[7] = new Option('جونقان', 'جونقان');
                    options[8] = new Option('چالشتر', 'چالشتر');
                    options[9] = new Option('چلگرد ـ كوهرنگ', 'چلگرد ـ كوهرنگ');
                    options[10] = new Option('دزك', 'دزك');
                    options[11] = new Option('دستنائ', 'دستنائ');
                    options[12] = new Option('دشتك', 'دشتك');
                    options[13] = new Option('سامان', 'سامان');
                    options[14] = new Option('سودجان', 'سودجان');
                    options[15] = new Option('سورشجان', 'سورشجان');
                    options[16] = new Option('شلمزار ـ كيار', 'شلمزار ـ كيار');
                    options[17] = new Option('شهركرد', 'شهركرد');
                    options[18] = new Option('فارسان', 'فارسان');
                    options[19] = new Option('فرادنبه', 'فرادنبه');
                    options[20] = new Option('فرخ شهر', 'فرخ شهر');
                    options[21] = new Option('كیان', 'كیان');
                    options[22] = new Option('گندمان', 'گندمان');
                    options[23] = new Option('گهرو', 'گهرو');
                    options[24] = new Option('لردگان', 'لردگان');
                    options[25] = new Option('مال خليفه', 'مال خليفه');
                    options[26] = new Option('ناغان', 'ناغان');
                    options[27] = new Option('هاروني', 'هاروني');
                    options[28] = new Option('هفشجان', 'هفشجان');
                    options[29] = new Option('وردنجان', 'وردنجان');
                }
                if (state == 25) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ابركوه', 'ابركوه');
                    options[2] = new Option('احمدآباد', 'احمدآباد');
                    options[3] = new Option('اردكان', 'اردكان');
                    options[4] = new Option('بافق', 'بافق');
                    options[5] = new Option('بفروئيه', 'بفروئيه');
                    options[6] = new Option('بهاباد', 'بهاباد');
                    options[7] = new Option('تفت', 'تفت');
                    options[8] = new Option('حميديا', 'حميديا');
                    options[9] = new Option('زارچ', 'زارچ');
                    options[10] = new Option('شاهديه', 'شاهديه');
                    options[11] = new Option('صدوق', 'صدوق');
                    options[12] = new Option('طبس', 'طبس');
                    options[13] = new Option('عشق آباد', 'عشق آباد');
                    options[14] = new Option('فراغه', 'فراغه');
                    options[15] = new Option('مروست', 'مروست');
                    options[16] = new Option('مهريز', 'مهريز');
                    options[17] = new Option('ميبد', 'ميبد');
                    options[18] = new Option('نير', 'نير');
                    options[19] = new Option('هرات ـ خاتم', 'هرات ـ خاتم');
                    options[20] = new Option('يزد', 'يزد');
                }
                if (state == 26) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اسپكه', 'اسپكه');
                    options[2] = new Option('ايرانشهر', 'ايرانشهر');
                    options[3] = new Option('بزمان', 'بزمان');
                    options[4] = new Option('بمپور', 'بمپور');
                    options[5] = new Option('بنت', 'بنت');
                    options[6] = new Option('بنجار', 'بنجار');
                    options[7] = new Option('پسكو', 'پسكو');
                    options[8] = new Option('تيموراباد', 'تيموراباد');
                    options[9] = new Option('جالق', 'جالق');
                    options[10] = new Option('چابهار', 'چابهار');
                    options[11] = new Option('خاش', 'خاش');
                    options[12] = new Option('دوست محمد ـ هيرمند', 'دوست محمد ـ هيرمند');
                    options[13] = new Option('راسك', 'راسك');
                    options[14] = new Option('زابل', 'زابل');
                    options[15] = new Option('زابلي', 'زابلي');
                    options[16] = new Option('زاهدان', 'زاهدان');
                    options[17] = new Option('زهك', 'زهك');
                    options[18] = new Option('ساربوك', 'ساربوك');
                    options[19] = new Option('سراوان', 'سراوان');
                    options[20] = new Option('سرباز', 'سرباز');
                    options[21] = new Option('سنگان', 'سنگان');
                    options[22] = new Option('سوران ـ سيب سوران', 'سوران ـ سيب سوران');
                    options[23] = new Option('سيركان', 'سيركان');
                    options[24] = new Option('فنوج', 'فنوج');
                    options[25] = new Option('قصرقند', 'قصرقند');
                    options[26] = new Option('كنارك', 'كنارك');
                    options[27] = new Option('كيتج', 'كيتج');
                    options[28] = new Option('گلمورتي ـ دلگان', 'گلمورتي ـ دلگان');
                    options[29] = new Option('گوهركوه', 'گوهركوه');
                    options[30] = new Option('محمدآباد', 'محمدآباد');
                    options[31] = new Option('ميرجاوه', 'ميرجاوه');
                    options[32] = new Option('نصرت آباد', 'نصرت آباد');
                    options[33] = new Option('نگور', 'نگور');
                    options[34] = new Option('نيك شهر', 'نيك شهر');
                    options[35] = new Option('هيدوچ', 'هيدوچ');
                }
                if (state == 27) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اركواز', 'اركواز');
                    options[2] = new Option('ارمو', 'ارمو');
                    options[3] = new Option('ايلام', 'ايلام');
                    options[4] = new Option('ايوان', 'ايوان');
                    options[5] = new Option('آبدانان', 'آبدانان');
                    options[6] = new Option('آسمان آباد', 'آسمان آباد');
                    options[7] = new Option('بدره', 'بدره');
                    options[8] = new Option('توحيد', 'توحيد');
                    options[9] = new Option('چشمه شيرين', 'چشمه شيرين');
                    options[10] = new Option('چوار', 'چوار');
                    options[11] = new Option('دره شهر', 'دره شهر');
                    options[12] = new Option('دهلران', 'دهلران');
                    options[13] = new Option('سرابله ـ شيروان و چرداول', 'سرابله ـ شيروان و چرداول');
                    options[14] = new Option('شباب ', 'شباب ');
                    options[15] = new Option('شهرك اسلاميه', 'شهرك اسلاميه');
                    options[16] = new Option('لومار', 'لومار');
                    options[17] = new Option('مهران', 'مهران');
                    options[18] = new Option('موسيان', 'موسيان');
                    options[19] = new Option('ميمه', 'ميمه');
                }
                if (state == 28) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('باشت', 'باشت');
                    options[2] = new Option('پاتاوه', 'پاتاوه');
                    options[3] = new Option('چرام', 'چرام');
                    options[4] = new Option('دهدشت ـ كهگيلويه', 'دهدشت ـ كهگيلويه');
                    options[5] = new Option('دوگنبدان ـ گچساران', 'دوگنبدان ـ گچساران');
                    options[6] = new Option('ديشموك', 'ديشموك');
                    options[7] = new Option('سپيدار', 'سپيدار');
                    options[8] = new Option('سوق', 'سوق');
                    options[9] = new Option('سي سخت ـ دنا', 'سي سخت ـ دنا');
                    options[10] = new Option('قلعه رئيسي', 'قلعه رئيسي');
                    options[11] = new Option('لنده', 'لنده');
                    options[12] = new Option('ليكك', 'ليكك');
                    options[13] = new Option('مادوان', 'مادوان');
                    options[14] = new Option('ياسوج ـ 7591', 'ياسوج ـ 7591');
                }
                if (state == 29) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اسفراين', 'اسفراين');
                    options[2] = new Option('ايور', 'ايور');
                    options[3] = new Option('آشخانه ـ مانه و سلمقان', 'آشخانه ـ مانه و سلمقان');
                    options[4] = new Option('بجنورد', 'بجنورد');
                    options[5] = new Option('جاجرم', 'جاجرم');
                    options[6] = new Option('درق', 'درق');
                    options[7] = new Option('راز', 'راز');
                    options[8] = new Option('شوقان', 'شوقان');
                    options[9] = new Option('شيروان', 'شيروان');
                    options[10] = new Option('فاروج', 'فاروج');
                    options[11] = new Option('گرمه', 'گرمه');
                }
                if (state == 30) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('ارسك', 'ارسك');
                    options[2] = new Option('اسديه ـ درميان', 'اسديه ـ درميان');
                    options[3] = new Option('آرين شهر', 'آرين شهر');
                    options[4] = new Option('آيسك', 'آيسك');
                    options[5] = new Option('بشرويه', 'بشرويه');
                    options[6] = new Option('بیرجند', 'بیرجند');
                    options[7] = new Option('حاجي آباد', 'حاجي آباد');
                    options[8] = new Option('خضري دشت بياض', 'خضري دشت بياض');
                    options[9] = new Option('خوسف', 'خوسف');
                    options[10] = new Option('زهان', 'زهان');
                    options[11] = new Option('سر بیشه', 'سر بیشه');
                    options[12] = new Option('سرايان', 'سرايان');
                    options[13] = new Option('سه قلعه', 'سه قلعه');
                    options[14] = new Option('فردوس', 'فردوس');
                    options[15] = new Option('قائن ـ قائنات', 'قائن ـ قائنات');
                    options[16] = new Option('گزيک', 'گزيک');
                    options[17] = new Option('مود', 'مود');
                    options[18] = new Option('نهبندان', 'نهبندان');
                    options[19] = new Option('نیمبلوك', 'نیمبلوك');
                }
                if (state == 31) {
                    options[0] = new Option('لطفا شهر را انتخاب نمایید', '0');
                    options[1] = new Option('اشتهارد', 'اشتهارد');
                    options[2] = new Option('آسارا', 'آسارا');
                    options[3] = new Option('چهارباغ', 'چهارباغ');
                    options[4] = new Option('سيف آباد', 'سيف آباد');
                    options[5] = new Option('شهر جديد هشتگرد', 'شهر جديد هشتگرد');
                    options[6] = new Option('طالقان', 'طالقان');
                    options[7] = new Option('كرج', 'كرج');
                    options[8] = new Option('كمال شهر', 'كمال شهر');
                    options[9] = new Option('كوهسار ـ چندار', 'كوهسار ـ چندار');
                    options[10] = new Option('گرمدره', 'گرمدره');
                    options[11] = new Option('ماهدشت', 'ماهدشت');
                    options[12] = new Option('محمدشهر', 'محمدشهر');
                    options[13] = new Option('مشکين دشت', 'مشکين دشت');
                    options[14] = new Option('نظرآباد', 'نظرآباد');
                    options[15] = new Option('هشتگرد ـ ساوجبلاغ', 'هشتگرد ـ ساوجبلاغ');
                }
            }
            $(".select").trigger("chosen:updated");
        }
    </script>

    
    <script>
        CityList(<?php echo e($Resume->user_tbl->province); ?>);
        const $select = document.querySelector('#city');
        $select.value = '<?php echo e($Resume->user_tbl->city); ?>'
        $(".select").trigger("chosen:updated");
    </script>

    <?php if(old("city")): ?>
        <script>CityList(<?php echo e(old("city")); ?>);</script>
    <?php endif; ?>

    <?php if(old("city")): ?>
        <script>
            $("#city option[value='<?php echo e(old("city")); ?>']").attr("selected", "selected");
            $(".select").trigger("chosen:updated");
        </script>
    <?php endif; ?>

    
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(input).prev().find('img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
    </script>


    
    <script>
        jQuery(document).ready(function () {
            var i = <?php echo e($ProblemKey); ?>;
            jQuery("#addRepeatItemProblem").click(function () {
                i += 1;
                jQuery("#repeat_list_problem").append("" +
                    "<div id='field-repeat-item-problem-" + i + "'>" +
                    "<div class='text-field'>" +
                    "<input placeholder='مشکل رزومه پلاس را وارد نمایید...' class='field-style input-text' type=\"text\" name=\"requirements[problem][" + i + "]\"> " +
                    "<span class='delete-row icon-close' onclick='delete_item_problem(" + i + ")'>" +
                    "<span class='zmdi zmdi-close'></span>" +
                    "</span>" +
                    "</div>" +
                    "</div>" +
                    "");
                return false;
            });

        });

        function delete_item_problem($id) {
            $('#field-repeat-item-problem-' + $id).remove();
        }
    </script>

    
    <script>
        jQuery(document).ready(function () {
            var i = <?php echo e($SuggestKey); ?>;
            jQuery("#addRepeatItemSuggest").click(function () {
                i += 1;
                jQuery("#repeat_list_suggest").append("" +
                    "<div id='field-repeat-item-suggest-" + i + "'>" +
                    "<div class='text-field'>" +
                    "<input placeholder='پیشنهاد رزومه پلاس را وارد نمایید...' class='field-style input-text' type=\"text\" name=\"requirements[suggest][" + i + "]\"> " +
                    "<span class='delete-row icon-close' onclick='delete_item_suggest(" + i + ")'>" +
                    "<span class='zmdi zmdi-close'></span>" +
                    "</span>" +
                    "</div>" +
                    "</div>" +
                    "");
                return false;
            });

        });

        function delete_item_suggest($id) {
            $('#field-repeat-item-suggest-' + $id).remove();
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard::layouts.dashboard.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/s/Desktop/Code/app/Modules/ResumeManager/Resources/views/edit.blade.php ENDPATH**/ ?>