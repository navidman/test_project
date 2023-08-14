<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementCategory;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\FileLibrary\Http\Controllers\FileLibraryController;
use Modules\Payments\Entities\Wallet;
use Modules\ResumeManager\Entities\ResumeManager;
use Modules\Users\Entities\Users;
use Modules\Users\Http\Requests\CreateUserRequest;
use Modules\Users\Http\Requests\UpdateMyAccountRequest;
use Modules\Users\Http\Requests\UpdateUsersRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $Users = Users::where('full_name', 'like', '%' . $_GET['search'] . '%')->orWhere('email', 'like', '%' . $_GET['search'] . '%')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $Users = Users::orderBy('created_at', 'desc')->paginate(20);
        }
        return view('users::index', compact('Users'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('users::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateUserRequest $request)
    {
        $UserData = $request->all();


        if ($request->file('avatar')) {
            $UserData['avatar'] = FileLibraryController::upload($request->file('avatar'), 'image', 'users/avatar', 'users', array([35, 35, 'fit'], [46, 46, 'fit'], [63, 63, 'fit'], [70, 70, 'fit'], [92, 92, 'fit'], [126, 126, 'fit'], [246, 246, 'fit'], [600, 600, 'fit']));
        }

        $UserData['password'] = Hash::make($request->password);

        if ($User = Users::create($UserData)) {
            if ($User->role === 'employer') {
                Wallet::create(['uid' => $User->id]);
            }
            return redirect('dashboard/users')->with('notification', [
                'class' => 'success',
                'message' => 'حساب کاربری جدید با موفقیت ایجاد شد'
            ]);
        } else {
            return redirect()->back()->with('notification', [
                'class' => 'alert',
                'message' => 'حساب کاربری جدید با موفقیت ایجاد شد'
            ]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if ($id == auth()->user()->id || Gate::allows('isAdmin')) {
            $Users = Users::find($id);
            $Category = EmploymentAdvertisementCategory::get()->all();

            $JobGroupOptions = [
                'فروش و بازاریابی',
                'فروشنده، بازاریاب  و ویزیتور',
                'مدیر فروشگاه، رستوران',
                'خدمات پشتیبانی و امور مشتریان',
                'مدیریت بیمه',
                'دیجیتال مارکتینگ و سئو',
                'تولید و مدیریت محتوا',
                'ترجمه و ویراستاری',
                'برنامه نویسی و توسعه نرم افزار',
                'شبکه / DevOps / پشتیبانی سخت افزاری و نرم افزاری',
                'علوم داده / هوش مصنوعی',
                'طراحی',
                'سینما و تصویر',
                'موسیقی و صدا',
                'مدیر محصول',
                'تحلیل و توسعه کسب و کار / استراتژی / برنامه ریزی',
                'مهندسی صنایع / مدیریت تولید / مدیریت پروژه / مدیریت عملیات',
                'خرید و بازرگانی ',
                'لجستیک / حمل و نقل / انبارداری',
                'راننده / مسئول توزیع / پیک موتوری',
                'مالی و حسابداری',
                'معامله گر و تحلیل گر بازارهای مالی',
                'مسئول دفتر / کارمند اداری و ثبت اطلاعات / تایپیست',
                'منابع انسانی',
                'مدیر اجرایی / مدیر داخلی',
                'مدیرعامل / مدیر کارخانه',
                'مهندسی برق و الکترونیک',
                'مهندسی پزشکی',
                'مهندسی مکانیک / مهندسی هوا و فضا',
                'مهندسی صنایع غذایی',
                'مهندسی شیمی/ مهندسی نفت و گاز',
                'مهندسی عمران',
                'مهندسی معماری و شهرسازی',
                'مهندسی معدن / زمین شناسی',
                'مهندسی مواد و متالورژی',
                'مهندسی نساجی',
                'مهندسی پلیمر',
                'مهندسی کشاورزی / علوم دامی',
                'علوم زیستی و آزمایشگاهی',
                'داروسازی / شیمی دارویی / بیو شیمی',
                'پزشک / دندانپزشک / دامپزشک',
                'پرستار و بهیار / تکنسین حوزه سلامت و درمان / دستیار پزشک',
                'روانشناسی / مشاوره / علوم اجتماعی',
                'حقوقی',
                'روابط عمومی',
                'خبرنگار / روزنامه نگار',
                'آموزش / تدریس',
                'پژوهش',
                'نگهبان',
                'کارگر ساده / نیروی خدماتی',
                'تکنسین فنی / تعمیرکار / کارگر ماهر',
                'راهنمای تور / مهماندار',
                'ورزش / تربیت بدنی / تغذیه',
                'تاریخ / جغرافیا / باستان شناسی',
                'تحقیق بازار و تحلیل اقتصادی',
                'گردشگری و هتلداری',
                'تحقیق و توسعه',
            ];

            if ($Users->avatar) {
                $Users->avatar = HomeController::GetAvatar('full', 'full', $Users->avatar);
            }

            $Data = [
                'Users',
                'Category',
                'JobGroupOptions',
            ];
            return view('users::edit', compact($Data));
        } else {
            return redirect('/dashboard/no-permissions');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if ($id == auth()->user()->id || Gate::allows('isAdmin')) {
            $users = Users::find($id);
            $UserData = $request->all();

            $UserData['company_activity'] = json_encode($request->company_activity);
            $UserData['job_group'] = json_encode($request->job_group);

            if ($request->file('avatar')) {
                $UserData['avatar'] = FileLibraryController::upload($request->file('avatar'), 'image', 'users/avatar', 'users', array([35, 35, 'fit'], [46, 46, 'fit'], [63, 63, 'fit'], [70, 70, 'fit'], [84, null, 'resize'], [92, 92, 'fit'], [126, 126, 'fit'], [168, null, 'resize'], [246, 246, 'fit'], [600, 600, 'fit']));
            }

            if ($request->role == 'super_admin') {
                $UserData['role'] = 'user';
            } else {
                $UserData['role'] = $request->role;
            }

            if (!empty($request->password_change)) {
                $UserData['password'] = Hash::make($request->password_change);
            }

            if ($users->email != $request->email) {
                $UserData['email_verified_at'] = null;
                \auth()->user()->sendEmailVerificationNotification();
            }

            if ($users->update($UserData)) {
                if ($users->role === 'employer') {
                    if (Wallet::where('uid', $users->id)->count() === 0) {
                        Wallet::create(['uid' => $users->id]);
                    }
                }
            }

            return back()->with('notification', [
                'class' => 'success',
                'message' => 'کاربر مورد نظر با موفقیت ویرایش شد.'
            ]);
        } else {
            return redirect('/dashboard/no-permissions');
        }
    }

    public function resendVerifyEmail()
    {
        $User = Users::find(auth()->user()->id);
        if ($User->email_verified_at == null) {
            \auth()->user()->sendEmailVerificationNotification();
        }
        return response()->json(['status' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        foreach ($request->delete_item as $key => $item) {
            /* Resume Delete */
            $ResumeManager = ResumeManager::where('uid', $key)->get()->all();
            foreach ($ResumeManager as $item_inner) {
                ResumeManager::find($item_inner->id)->delete();
            }

            Users::where('id', $key)->delete();
        }

        return redirect('/dashboard/users')->with('notification', [
            'class' => 'success',
            'message' => 'کاربران مورد نظر حذف شد'
        ]);
    }

    public function MyAccount()
    {
        $User = Users::where('id', auth()->user()->id)->select('id', 'full_name', 'company_name_fa', 'company_name_en', 'province', 'city', 'phone', 'company_activity', 'website', 'shaba', 'number_of_staff', 'job_group', 'biography', 'email', 'email_verified_at', 'avatar', 'organization_level', 'economic_code', 'organization_phone', 'status')->first();

        if ($User->avatar) {
            $UserAvatar = FileLibrary::find(auth()->user()->avatar);

            if ($UserAvatar->extension != 'svg') {
                $User['avatar'] = [
                    'path' => url('storage/' . $UserAvatar->path . '126/' . $UserAvatar->file_name),
                    'pathX2' => url('storage/' . $UserAvatar->path . '246/' . $UserAvatar->file_name)
                ];
            } else {
                $User['avatar'] = [
                    'path' => url('storage/' . $UserAvatar->path . 'full/' . $UserAvatar->file_name),
                ];
            }
        } else {
            $User['avatar'] = [
                'path' => '',
                'pathX2' => ''
            ];
        }

        return response()->json($User);
    }

    public function UpdateMyAccount(UpdateMyAccountRequest $request)
    {
        $User = Users::find(auth()->user()->id);
        $UserData = $request->all();

        $verifyStatus = false;

        if ($User->email_verified_at == null) {
            $verifyStatus = true;
        } elseif ($User->email != $request->email) {
            $verifyStatus = true;
        }

        if ($request->company_activity != $User->company_activity) {
            if (explode(',', $request->company_activity)[0] != 'null' && count(explode(',', $request->company_activity)) <= 15) {
                $UserData['company_activity'] = json_encode(explode(',', $request->company_activity));
            } else {
                $UserData['company_activity'] = null;
            }
        } else {
            $UserData['company_activity'] = $User->company_activity;
        }

        if ($request->job_group != $User->job_group) {
            if (explode(',', $request->job_group)[0] != 'null' && count(explode(',', $request->job_group)) <= 3) {
                $UserData['job_group'] = json_encode(explode(',', $request->job_group));
            } else {
                $UserData['job_group'] = null;
            }
        } else {
            $UserData['job_group'] = $User->job_group;
        }

        if ($request->file('avatar_file')) {
            $UserData['avatar'] = FileLibraryController::upload($request->file('avatar_file'), 'image', 'users/avatar', 'users', array([35, 35, 'fit'], [46, 46, 'fit'], [63, 63, 'fit'], [70, 70, 'fit'], [84, null, 'resize'], [92, 92, 'fit'], [126, 126, 'fit'], [168, null, 'resize'], [246, 246, 'fit'], [600, 600, 'fit']));
        } else {
            if ($User->avatar) {
                $UserData['avatar'] = $User->avatar;
            } else {
                $UserData['avatar'] = null;
            }
        }

        if ($request->file('cover_image')) {
            $UserData['cover_image'] = FileLibraryController::upload($request->file('cover_image'), 'image', 'users/cover-image', 'users', array([1215, 248, 'fit'], [2430, 496, 'fit']));
        } else {
            if ($User->cover_image) {
                $UserData['cover_image'] = $User->cover_image;
            } else {
                $UserData['cover_image'] = null;
            }
        }

        if ($request->file('official_newspaper')) {
            $UserData['official_newspaper'] = FileLibraryController::upload($request->file('official_newspaper'), 'file', 'users/official-newspaper', 'users');
        } else {
            if ($User->official_newspaper) {
                $UserData['official_newspaper'] = $User->official_newspaper;
            } else {
                $UserData['official_newspaper'] = null;
            }
        }
        if ($verifyStatus) {
            $UserData['email_verified_at'] = null;
        }

        if ($User->update($UserData)) {
            if ($verifyStatus) {
                $User = User::find($User->id);
                $User->sendEmailVerificationNotification();
            }
            return response()->json(['status' => 200, $UserData, $verifyStatus]);
        }
    }

    public function UpdateMySecurityAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ], [], [
            'password' => 'کلمه عبور',
        ]);

        $User = Users::find(auth()->user()->id);
        $UserData = [
            'password' => Hash::make($request->password)
        ];

        if ($User->update($UserData)) {
            return response()->json(['status' => 200]);
        }
    }

    public function GetMembers()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Users = Users::where('parent_id', $User)->whereNotIn('id', [\auth()->user()->id])->select('id', 'full_name', 'email', 'phone', 'panel_access')->get()->all();

        return response()->json($Users);
    }
}
