<?php

namespace Modules\QuestionCenter\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\QuestionCenter\Entities\QuestionCenter;
use Modules\QuestionCenter\Entities\QuestionCenterCategory;
use Modules\QuestionCenter\Http\Requests\QuestionCenterRequest;

class QuestionCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $QuestionCenter = QuestionCenter::where('title', 'like', '%' . $_GET['search'] . '%')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $QuestionCenter = QuestionCenter::orderBy('created_at', 'desc')->paginate(20);
        }

        return view('questioncenter::question.index', compact('QuestionCenter'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $QuestionCenterCategory = QuestionCenterCategory::get()->all();
        return view('questioncenter::question.create', compact('QuestionCenterCategory'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(QuestionCenterRequest $request)
    {
        $User = auth()->user();
        $QuestionCenter = $request->all();
        $QuestionCenter['uid'] = $User->id;

        if (QuestionCenter::create($QuestionCenter)) {
            return redirect('dashboard/question-center')->with('notification', [
                'class' => 'success',
                'message' => 'سوال با موفقیت ثبت شد.'
            ]);
        } else {
            return redirect()->back()->with('notification', [
                'class' => 'alert',
                'message' => 'ذخیره اطلاعات با مشکل روبرو شد.'
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
        return view('questioncenter::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $QuestionCenter = QuestionCenter::find($id);
        $QuestionCenterCategory = QuestionCenterCategory::get()->all();


        $Data = [
            'QuestionCenter',
            'QuestionCenterCategory'
        ];
        return view('questioncenter::question.edit', compact($Data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $QuestionCenter = QuestionCenter::find($id);
        $QuestionCenterData = $request->all();

        if ($QuestionCenter->update($QuestionCenterData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/question-center')->with('notification', [
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
            QuestionCenter::where('id', $key)->delete();
        }

        return redirect('/dashboard/question-center')->with('notification', [
            'class' => 'success',
            'message' => 'سوال مورد نظر حذف شد'
        ]);
    }
}
