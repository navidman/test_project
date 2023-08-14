<?php
//
//namespace App\Http\Controllers\Dashboard\Users;
//
//use App\Http\Controllers\Controller;
//use App\Http\Requests\Users\UsersRequest;
//use App\User;
//use Illuminate\Support\Facades\Gate;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
//use Modules\ResumeManager\Entities\ResumeManager;
//use Modules\Users\Entities\Users;
//
//class UsersController extends Controller {
//
//    public function __construct() {
//        $this->middleware('can:isAdmin');
//    }
//
//    public function index() {
//        if (isset($_GET['name']) && $_GET['name']){
//            $users = User::where('name', 'like', '%' . $_GET['name'] . '%')->orWhere('phone', 'like', '%' . $_GET['name'] . '%')->orderBy('created_at', 'desc')->paginate(20);
//        }else{
//            $users = User::orderBy('created_at', 'desc')->paginate(20);
//        }
//
//        return view('admin.users.index', compact('users'));
//    }
//
//    public function create() {
//        return view('admin.users.create');
//    }
//
//    public function store(UsersRequest $userRequest) {
//        $userRequest->validate([
//            'name' => 'required',
//            'email' => 'required',
//            'password' => 'required',
//            'role' => 'required',
//        ]);
//
//        function generateRandomString($length = 5) {
//            $characters = 'abcdefghijklmnopqrstuvwxyz';
//            $charactersLength = strlen($characters);
//            $randomString = '';
//            for ($i = 0; $i < $length; $i++) {
//                $randomString .= $characters[rand(0, $charactersLength - 1)];
//            }
//            return $randomString;
//        }
//
//        $users = new User;
//        $users->name = $userRequest->name;
//        $users->email = $userRequest->email;
//        $users->phone = $userRequest->phone;
//        $users->password = bcrypt($userRequest->password);
//        if ($userRequest->role == 'super_admin') {
//            $users->role = 'user';
//        } else {
//            $users->role = $userRequest->role;
//        }
//        $users->user_code = substr(time(), 5) . generateRandomString();
//        $users->save();
//
//        return redirect('/dashboard/users')->with('notification', [
//            'class' => 'success',
//            'message' => 'حساب کاربری جدید با موفقیت ایجاد شد'
//        ]);
//    }
//
//    public function edit($id) {
//        if ($id == auth()->user()->id || Gate::allows('isAdmin')) {
//            $users = User::find($id);
//            return view('admin.users.edit', compact('users'))->withInfo('کاربر مورد نظر با موفقیت ویرایش شد.');
//        } else {
//            return redirect('/dashboard/no-permissions');
//        }
//    }
//
//    public function update(Request $request, $id) {
//        if ($id == auth()->user()->id || Gate::allows('isAdmin')) {
//
//            $users = User::find($id);
//
//            $this->validate($request, [
//                'full_name' => 'required',
//                'email' => 'required|email|unique:users,email,' . $users->id,
//                'phone' => 'required|unique:users,phone,' . $users->id,
//                'role' => 'required',
//            ], [], [
//                'full_name' => 'نام و نام خانوادگی',
//                'email' => 'آدرس ایمیل',
//                'phone' => 'تلفن همراه',
//                'password' => 'رمز عبور',
//                'role' => 'سطح دسترسی',
//            ]);
//
//
//            $users->full_name = $request->full_name;
//            $users->email = $request->email;
//            $users->phone = $request->phone;
//            $users->role = $request->role;
//            if ($request->role == 'super_admin') {
//                $users->role = 'user';
//            } else {
//                $users->role = $request->role;
//            }
//
//            if (empty($request->password_change)) {
//            } else {
//                $users->password = Hash::make($request->password_change);
//            }
//            $users->update($request->all());
//
//            return back()->with('notification', [
//                'class' => 'success',
//                'message' => 'کاربر مورد نظر با موفقیت ویرایش شد.'
//            ]);
//        } else {
//            return redirect('/dashboard/no-permissions');
//        }
//    }
//
//    public function destroy(Request $request) {
//        foreach ($request->delete_item as $key => $item) {
//            /* Resume Delete */
//            $ResumeManager = ResumeManager::where('uid', $key)->get()->all();
//            foreach ($ResumeManager as $item_inner) {
//                ResumeManager::find($item_inner->id)->delete();
//            }
//
//            Users::where('id', $key)->delete();
//        }
//
//        return redirect('/dashboard/users')->with('notification', [
//            'class' => 'success',
//            'message' => 'کاربران مورد نظر حذف شد'
//        ]);
//    }
//
//    public function AuthRouteAPI(Request $request) {
//        return $request->user();
//    }
//}
