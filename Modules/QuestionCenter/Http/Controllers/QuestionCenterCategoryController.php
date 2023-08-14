<?php

namespace Modules\QuestionCenter\Http\Controllers;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\QuestionCenter\Entities\QuestionCenter;
use Modules\QuestionCenter\Entities\QuestionCenterCategory;
use Modules\QuestionCenter\Http\Requests\QuestionCenterCategoryRequest;

class QuestionCenterCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $QuestionCenterCategory = QuestionCenterCategory::orderBy('created_at', 'desc')->paginate(20);

        return view('questioncenter::category.index', compact('QuestionCenterCategory'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('questioncenter::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(QuestionCenterCategoryRequest $request)
    {
        $QuestCenterCategory = new QuestionCenterCategory();
        $QuestCenterCategory->title = $request['title'];

        if (empty($request['slug'])) {
            $request->slug = $request['title'];
        }

        $request->slug = strtolower($request->slug);
        $QuestCenterCategory->slug = SlugService::createSlug(QuestionCenterCategory::class, 'slug', $request->slug);

        if ($QuestCenterCategory->save()) {
            return redirect('/dashboard/question-center-category')->with('notification', [
                'class' => 'success',
                'message' => 'دسته بندی با موفقیت ایجاد شد'
            ]);
        } else {
            return redirect('/dashboard/question-center-category')->with('notification', [
                'class' => 'alert',
                'message' => 'ذخیره سازی اطلاعات با مشکل روبرو شد.'
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
        $QuestionCenterCategory = QuestionCenterCategory::find($id);

        return view('questioncenter::category.edit', compact('QuestionCenterCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $QuestionCenterCategory = QuestionCenterCategory::find($id);
        $QuestionCategoryData = $request->all();

        if ($QuestionCenterCategory->slug != $request['slug']) {
            if (empty($request['slug'])) {
                $request->slug = $request['title'];
            }

            $request->slug = strtolower($request->slug);
            $QuestionCategoryData['slug'] = SlugService::createSlug(QuestionCenterCategory::class, 'slug', $request->slug);
        }

        if ($QuestionCenterCategory->update($QuestionCategoryData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/question-center-category')->with('notification', [
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
            $QuestionCenter = QuestionCenter::where('cat', $key)->get()->all();
            foreach ($QuestionCenter as $item_question) {
                $BlogItem = QuestionCenter::find($item_question->id);
                $BlogItem->cat = 0;
                $BlogItem->save();
            }
            QuestionCenterCategory::where('id', $key)->delete();
        }

        return redirect('/dashboard/question-center-category')->with('notification', [
            'class' => 'success',
            'message' => 'دسته بندی مورد نظر حذف شد'
        ]);
    }
}
