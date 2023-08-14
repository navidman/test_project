<?php

namespace Modules\CommentSystem\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CommentSystem\Entities\CommentSystem;
use Modules\Users\Entities\Users;

class CommentSystemController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $CommentSystem = CommentSystem::where('name', 'like', '%' . $_GET['search'] . '%')->orWhere('email', 'like', '%' . $_GET['search'] . '%')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $CommentSystem = CommentSystem::orderBy('created_at', 'desc')->paginate(20);
        }

        return view('commentsystem::admin.index', compact('CommentSystem'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('commentsystem::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $CommentData = $request->all();

        $CommentData['status'] = 'new';

        if (auth()->check()) {
            $User = auth()->user();
            $CommentData['uid'] = $User->id;
            $CommentData['name'] = $User->full_name;
            $CommentData['email'] = $User->email;

            $ValidationMeta = [
                'message' => 'required',
            ];

            $CommentValidate = $request->validate($ValidationMeta, [], [
                'message' => 'متن دیدگاه'
            ]);
        } else {
            $ValidationMeta = [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'message' => 'required',
            ];
            $CommentValidate = $request->validate($ValidationMeta, [], [
                'name' => 'نام',
                'email' => 'ایمیل',
                'message' => 'متن دیدگاه'
            ]);
        }


        $CommentData['post_type'] = $request->post_type;
        $CommentData['post_id'] = $request->post_id;

        CommentSystem::create($CommentData);

        return response()->json([
            'status' => 200,
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($type, $id)
    {
        $Comments = CommentSystem::where('post_type', $type)->where('post_id', $id)->where('parent_id', null)->where('status', 'accepted')->select('id', 'uid', 'name', 'message', 'like', 'created_at')->get()->all();

        foreach ($Comments as $key => $item) {
            $Comments[$key]['parents'] = CommentSystem::where('post_type', $type)->where('post_id', $id)->where('parent_id', $item->id)->where('status', 'accepted')->select('id', 'uid', 'name', 'message', 'like', 'created_at')->get()->all();

            foreach ($Comments[$key]['parents'] as $itemInner) {
                if ($itemInner->uid) {
                    $Uid = Users::find($itemInner->uid);
                    if ($Uid->role == 'author' || $Uid->role == 'admin' || $Uid->role == 'operator') {
                        $itemInner['role'] = 'کارمند تاپلیکنت';
                    }
                }
            }

            if ($item->uid) {
                $Uid = Users::find($item->uid);
                if ($Uid->role == 'author' || $Uid->role == 'admin' || $Uid->role == 'operator') {
                    $Comments[$key]['role'] = 'کارمند تاپلیکنت';
                }
            }

            if (!count($Comments[$key]['parents'])) {
                unset($Comments[$key]['parents']);
            }
        }

        return response()->json(
            [
                'data' => $Comments,
                'status' => 200
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $CommentSystem = CommentSystem::find($id);
        if ($CommentSystem->status == 'new') {
            $CommentSystemData['status'] = 'viewed';
            $CommentSystem->update($CommentSystemData);
        }

        return view('commentsystem::admin.edit', compact('CommentSystem'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $CommentSystem = CommentSystem::find($id);
        $CommentSystemData = $request->all();

        if ($CommentSystem->update($CommentSystemData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/comment')->with('notification', [
                'class' => 'danger',
                'message' => 'بروزرسانی با خطا روبرو شد'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        foreach ($request->delete_item as $key => $item) {
            $CommentSystem = CommentSystem::where('parent_id', $key)->get()->all();
            foreach ($CommentSystem as $item_comment) {
                $CommentItem = CommentSystem::find($item_comment->id);
                $CommentItem::where('parent_id', $key)->delete();
            }

            CommentSystem::where('id', $key)->delete();
        }

        return redirect('/dashboard/comment')->with('notification', [
            'class' => 'success',
            'message' => 'دیدگاه مورد نظر حذف شد'
        ]);
    }

    /* Submit Like */
    public function like($id) {
        $Comment = CommentSystem::find($id);
        $CommentData = [];
        $CommentData['like'] = $Comment->like + 1;

        $Comment->update($CommentData);

        return response()->json(
            [
                'like' => $CommentData['like'],
                'status' => 200
            ]
        );
    }
}
