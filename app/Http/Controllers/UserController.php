<?php

namespace App\Http\Controllers;

//use App\Http\Resources\v1\UserResource;
use App\Models\MobileVerifyCode;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Modules\FileLibrary\Entities\FileLibrary;
use Modules\Payments\Entities\Wallet;
use Modules\SmsHandler\Http\Controllers\SmsHandlerController;
use Modules\Users\Entities\Users;

class UserController extends Controller
{
    /* Login and Register Client */
    public function login(Request $request)
    {
        function userData() {
            if (Auth::user()->parent_id) {
                $User = Auth::user()->parent_id;
            } else {
                $User = auth()->user()->id;
            }

            $User = Users::find($User);
            $UserData = [];

            if ($User->avatar) {
                $UserAvatar = FileLibrary::find($User->avatar);

                if ($UserAvatar->extension != 'svg') {
                    $UserData['avatar']['path'] = url('storage/' . $UserAvatar->path . '63/' . $UserAvatar->file_name);
                    $UserData['avatar']['pathX2'] = url('storage/' . $UserAvatar->path . '126/' . $UserAvatar->file_name);
                } else {
                    $UserData['avatar']['path'] = url('storage/' . $UserAvatar->path . 'full/' . $UserAvatar->file_name);
                }
            } else {
                $UserData['avatar']['path'] = '';
                $UserData['avatar']['pathX2'] = '';
            }

            if ($User->role === 'employer' || $User->role === 'admin') {
                $UserData['company_name_fa'] = $User->company_name_fa;
                $Wallet = Wallet::where('uid', $User->id)->first();
                $Topli = $Wallet->topli + $Wallet->topli_score;
            }else {
                $Topli = 0;
            }

            $UserData['full_name'] = $User->full_name;
            $UserData['wallet'] = $Topli;
            $UserData['role'] = $User->role;
            $UserData['status'] = $User->status;

            return $UserData;
        }

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $ValidData = $request->validate([
                'email' => 'required',
            ], [], [
                'email' => 'ایمیل',
            ]);

            if (Users::where('email', $request->email)->exists()) {
                $User = Users::where('email', $request->email)->first();

                $AccessLogin = true;
                if ($User->parent_id && $User->panel_access == 'false') {
                    $AccessLogin = false;
                }

                if ($AccessLogin) {
                    if ($ValidData && $request->password == null && $request->emailConfirm == false) {
                        return response()->json([
                            'email_confirm' => true,
                        ]);
                    }

                    if ($ValidData) {
                        $ValidData = $request->validate([
                            'email' => 'required|exists:users',
                            'password' => 'required'
                        ], [], [
                            'email' => 'ایمیل',
                            'password' => 'کلمه عبور'
                        ]);

//            return response()->json($ValidData);
                    }

                    if (!Auth::attempt($ValidData)) {
                        return response()->json([
                            'status' => 401,
                            'message' => 'اعتبار نامعتبر'
                        ]);
                    } else {
                        auth()->user()->tokens()->delete();
                        $token = auth()->user()->createToken('API for app browser')->plainTextToken;

                        return response()->json(
                            [
                                'status' => 200,
                                'token' => $token,
                                'userData' => userData()
                            ]
                        );
                    }
                }
            } else {
                if ($request->emailConfirm == true) {
                    $ValidData = $request->validate([
                        'email' => 'required',
                        'full_name' => 'required',
                        'password' => 'required|min:8|confirmed',
                    ], [], [
                        'email' => 'ایمیل',
                        'full_name' => 'نام و نام خانوادگی',
                        'password' => 'کلمه عبور',
                    ]);

                    $User = User::create([
                        'full_name' => $request->full_name,
                        'email' => $request->email,
                        'role' => 'employer',
                        'status' => 'deactivate',
                        'password' => Hash::make($request->password),
                    ]);


                    if ($User) {
                        Wallet::create(['uid' => $User->id]);
                    }

                    event(new Registered($User));

                    Auth::loginUsingId($User->id);
                    $token = auth()->user()->createToken('API for app browser')->plainTextToken;

                    return response()->json(
                        [
                            'action' => 'register_done',
                            'token' => $token,
                            'userData' => userData()
                        ]
                    );
                } else {
                    return response()->json([
                        'email_confirm' => true,
                        'action' => 'register'
                    ]);
                }
            }
        } elseif (is_numeric($request->email)) {
            if (preg_match("/^[0]{1}[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}$/", $request->email)) {
                $ValidData = $request->validate([
                    'email' => 'required',
                ], [], [
                    'email' => 'موبایل',
                ]);
                if (Users::where('phone', $request->email)->exists()) {
                    $User = Users::where('phone', $request->email)->first();

                    $AccessLogin = true;
                    if ($User->parent_id && $User->panel_access == 'false') {
                        $AccessLogin = false;
                    }

                    if ($AccessLogin) {
                        if ($ValidData && $request->password == null && $request->emailConfirm == false) {
                            if ($VerifyCode = SmsHandlerController::SmsVerify($request->email)) {
                                $Data = [
                                    'mobile_number' => $request->email,
                                    'code' => $VerifyCode
                                ];
                                MobileVerifyCode::create($Data);
                            }

//                    $send = smsir::Send();
//
//                    $VerifyCode = rand(10000, 99999);
//                    $parameter = new \Cryptommer\Smsir\Objects\Parameters('CODE', $VerifyCode);
//                    $parameters = array($parameter);
//                    if ($send->Verify($request->email, 100000, $parameters)) {
//                        $Data = [
//                            'mobile_number' => $request->email,
//                            'code' => $VerifyCode
//                        ];
//                        MobileVerifyCode::create($Data);
//                    }

                            return response()->json([
                                'email_confirm' => true,
                                'is_mobile' => true,
                            ]);
                        }

                        if ($ValidData) {
                            $ValidData = $request->validate([
                                'verifyCode' => 'required'
                            ], [], [
                                'verifyCode' => 'کد تایید'
                            ]);

//            return response()->json($ValidData);
                        }

                        if (MobileVerifyCode::where('mobile_number', $request->email)->where('code', $request->verifyCode)->count()) {
                            $user = Users::where('phone', $request->email)->first();
                            Auth::loginUsingId($user->id);

                            auth()->user()->tokens()->delete();
                            $token = auth()->user()->createToken('API for app browser')->plainTextToken;
                            $user = auth()->user();

                            $MobileVerifyCode = MobileVerifyCode::where('mobile_number', $request->email)->where('code', $request->verifyCode);
                            $MobileVerifyCode->delete();

                            return response()->json(
                                [
                                    'status' => 200,
                                    'token' => $token,
                                    'userData' => userData()
                                ]
                            );
                        } else {
                            return response()->json(
                                [
                                    'email_confirm' => true,
                                    'is_mobile' => true,
                                    'error_list' => [
                                        'verifyCode' => 'کد تایید صحیح نیست'
                                    ]
                                ]
                            );
                        }
                    }
                } else {
                    if ($request->emailConfirm == true) {
                        $ValidData = $request->validate([
                            'email' => 'required',
                            'full_name' => 'required',
                            'verifyCode' => 'required',
                        ], [], [
                            'email' => 'موبایل',
                            'full_name' => 'نام و نام خانوادگی',
                            'verifyCode' => 'کد تایید',
                        ]);

                        if (MobileVerifyCode::where('mobile_number', $request->email)->where('code', $request->verifyCode)->count()) {
                            $User = Users::create([
                                'full_name' => $request->full_name,
                                'phone' => $request->email,
                                'role' => 'employer',
                                'status' => 'deactivate',
                            ]);

                            if ($User) {
                                Wallet::create(['uid' => $User->id]);
                            }

                            Auth::loginUsingId($User->id);
                            $token = auth()->user()->createToken('API for app browser')->plainTextToken;

                            $MobileVerifyCode = MobileVerifyCode::where('mobile_number', $request->email)->where('code', $request->verifyCode);
                            $MobileVerifyCode->delete();


                            return response()->json(
                                [
                                    'action' => 'register_done',
                                    'token' => $token,
                                    'userData' => userData()
                                ]
                            );
                        } else {
                            return response()->json(
                                [
                                    'email_confirm' => true,
                                    'is_mobile' => true,
                                    'action' => 'register',
                                    'error_list' => [
                                        'verifyCode' => 'کد تایید صحیح نیست'
                                    ]
                                ]
                            );
                        }
                    } else {
                        if ($VerifyCode = SmsHandlerController::SmsVerify($request->email)) {
                            $Data = [];
                            $Data['mobile_number'] = $request->email;
                            $Data['code'] = $VerifyCode;
                            MobileVerifyCode::create($Data);
                        }

                        return response()->json([
                            'email_confirm' => true,
                            'is_mobile' => true,
                            'action' => 'register'
                        ]);
                    }
                }
            } else {
                return response()->json(['status' => 'PhoneInvalid']);
            }
        }else{
            return response()->json(['status' => 'EmailInvalid']);
        }
    }

    public function addMember(Request $request)
    {
        $ValidData = $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'unique:users,phone|required|digits:11|numeric|regex:/^[0]{1}[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}$/',
            'password' => ['required', 'string', 'min:8'],
        ], [], [
            'full_name' => 'نام و نام خانوادگی',
            'email' => 'ایمیل',
            'phone' => 'موبایل',
            'password' => 'کلمه عبور',
        ]);

        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $User = Users::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'parent_id' => $User,
            'panel_access' => true,
            'role' => 'employer',
            'status' => 'active',
            'password' => Hash::make($request->password),
        ]);

        if ($User) {
            return response()->json([
                'status' => 'ok'
            ]);
        } else {
            return response()->json([
                'status' => 'nok'
            ]);
        }
    }

    public function ChangeMemberActiveToggle(Request $request)
    {
        if (Auth::user()->parent_id) {
            $UserID = Auth::user()->parent_id;
        } else {
            $UserID = auth()->user()->id;
        }

        $Member = Users::find($request->id);
        if ($Member->parent_id === $UserID) {
            if ($Member->panel_access == 'true') {
                $Member->update([
                    'panel_access' => 'false'
                ]);
            } else {
                $Member->update([
                    'panel_access' => 'true'
                ]);
            }
        }
    }

    public function DeleteMember(Request $request)
    {
        if (Auth::user()->parent_id) {
            $UserID = Auth::user()->parent_id;
        } else {
            $UserID = auth()->user()->id;
        }

        $Member = Users::find($request->id);
        if ($Member->parent_id === $UserID) {
            User::find($request->id)->delete();
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('optimize:clear');
        \Cookie::queue(\Cookie::forget('userData'));
        \Cookie::queue(\Cookie::forget('toplicant_session'));
        \Cookie::queue(\Cookie::forget('XSRF-TOKEN'));
        \Cookie::queue(\Cookie::forget('auth_token'));

        return response()->json([
            'status' => 200,
        ]);
    }

//    public function register(Request $request)
//    {
//        $ValidData = $request->validate([
//            'full_name' => ['required', 'string', 'max:255'],
//            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:8'],
//        ]);
//
//        $User = User::create([
//            'full_name' => $ValidData['full_name'],
//            'email' => $ValidData['email'],
//            'role' => 'user',
//            'status' => 'deactivate',
//            'password' => Hash::make($ValidData['password']),
//        ]);
//
//        $token = $User->createToken('API for app browser')->plainTextToken;
//
//        return response()->json([
//            'status' => 200,
//            'fullName' => $User->full_name,
//            'token' => $token
//        ]);
//    }

    public function UserData()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $User = Users::find($User);
        $UserData = [];

        if ($User->avatar) {
            $UserAvatar = FileLibrary::find($User->avatar);

            if ($UserAvatar->extension != 'svg') {
                $UserData['avatar']['path'] = url('storage/' . $UserAvatar->path . '63/' . $UserAvatar->file_name);
                $UserData['avatar']['pathX2'] = url('storage/' . $UserAvatar->path . '126/' . $UserAvatar->file_name);
            } else {
                $UserData['avatar']['path'] = url('storage/' . $UserAvatar->path . 'full/' . $UserAvatar->file_name);
            }
        } else {
            $UserData['avatar']['path'] = '';
            $UserData['avatar']['pathX2'] = '';
        }

        if ($User->role === 'employer' || $User->role === 'admin') {
            $UserData['company_name_fa'] = $User->company_name_fa;
        }

        $Wallet = Wallet::where('uid', $User->id)->first();

        $UserData['full_name'] = $User->full_name;
        $UserData['wallet'] = $Wallet->topli + $Wallet->topli_score;
        $UserData['role'] = $User->role;
        $UserData['status'] = $User->status;

        return response()->json($UserData);
    }
}
