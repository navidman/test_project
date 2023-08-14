<?php

namespace Modules\Blog\Http\Controllers;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;
use Modules\Blog\Http\Requests\BlogCategoryRequest;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $BlogCategory = BlogCategory::paginate(10);
        $ParentCategories = BlogCategory::orderBy('created_at', 'desc')->get();


//        foreach ($BlogCategory as $key => $item) {
//            dd($item);
//            $Parents = BlogCategory::where('parent', $item->id)->select('id', 'title', 'slug')->get();
//            $BlogCategory[$key]['children'] = $Parents;
//
//            if ($Parents) {
//                foreach ($Parents as $key2 => $item2) {
//                    $Parents = BlogCategory::where('parent', $item2->id)->select('id', 'title', 'slug')->get();
//                    $BlogCategory[$key][$key2]['children'] = $Parents;
//                }
//            }
//        }

        $Data = [
            'BlogCategory',
            'ParentCategories'
        ];

        return view('blog::category.index', compact($Data));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('blog::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(BlogCategoryRequest $request)
    {
        $BlogCategory = new BlogCategory();
        $BlogCategory->title = $request['title'];

        if (empty($request['slug'])) {
            $request->slug = $request['title'];
        }

        if ($request->parent) {
            $BlogCategory->parent = $request['parent'];
        }

        $request->slug = strtolower($request->slug);
        $BlogCategory->slug = SlugService::createSlug(BlogCategory::class, 'slug', $request->slug);

        if ($BlogCategory->save()) {
            return redirect('/dashboard/blog-category')->with('notification', [
                'class' => 'success',
                'message' => 'دسته بندی با موفقیت ایجاد شد'
            ]);
        } else {
            return redirect('/dashboard/blog-category')->with('notification', [
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
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $ParentCategories = BlogCategory::orderBy('created_at', 'desc')->get();
        $BlogCategory = BlogCategory::find($id);


        $Data = [
            'ParentCategories',
            'BlogCategory',
        ];
        return view('blog::category.edit', compact($Data));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(BlogCategoryRequest $request, $id)
    {
        $BlogCategory = BlogCategory::find($id);
        $BlogCategoryData = $request->all();

        if ($BlogCategory->slug != $request['slug']) {
            if (empty($request['slug'])) {
                $request->slug = $request['title'];
            }

            $request->slug = strtolower($request->slug);
            $BlogCategoryData['slug'] = SlugService::createSlug(BlogCategory::class, 'slug', $request->slug);
        }

        if ($BlogCategory->update($BlogCategoryData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/blog-category')->with('notification', [
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
            $Blog = Blog::where('cat', $key)->get()->all();
            foreach ($Blog as $item_blog) {
                $BlogItem = Blog::find($item_blog->id);
                $BlogItem->cat = 0;
                $BlogItem->save();
            }
            BlogCategory::where('id', $key)->delete();
        }

        return redirect('/dashboard/blog-category')->with('notification', [
            'class' => 'success',
            'message' => 'دسته بندی مورد نظر حذف شد'
        ]);
    }
}
