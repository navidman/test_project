<?php

namespace Modules\EmploymentAdvertisement\Http\Controllers;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementCategory;
use Modules\EmploymentAdvertisement\Http\Requests\EmploymentAdvertisementCategoryRequest;

class EmploymentAdvertisementCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $EmploymentAdvertisementCategory = EmploymentAdvertisementCategory::orderBy('created_at', 'desc')->paginate(20);

        return view('employmentadvertisement::category.index', compact('EmploymentAdvertisementCategory'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employmentadvertisement::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(EmploymentAdvertisementCategoryRequest $request)
    {
        $EmploymentAdvertisementCategoryData = $request->all();

        if (empty($request['slug'])) {
            $request->slug = $request['title'];
        }

        $request->slug = strtolower($request->slug);
        $EmploymentAdvertisementCategoryData['slug'] = SlugService::createSlug(EmploymentAdvertisementCategory::class, 'slug', $request->slug);

        if (EmploymentAdvertisementCategory::create($EmploymentAdvertisementCategoryData)) {
            return redirect('/dashboard/advertisement-category')->with('notification', [
                'class' => 'success',
                'message' => 'گروه شغلی با موفقیت ایجاد شد'
            ]);
        } else {
            return redirect('/dashboard/advertisement-category')->with('notification', [
                'class' => 'alert',
                'message' => 'ذخیره سازی اطلاعات با مشکل روبرو شد.',
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
        return view('employmentadvertisement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $EmploymentAdvertisementCategory = EmploymentAdvertisementCategory::find($id);
        return view('employmentadvertisement::category.edit', compact('EmploymentAdvertisementCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(EmploymentAdvertisementCategoryRequest $request, $id)
    {
        $EmploymentAdvertisementCategory = EmploymentAdvertisementCategory::find($id);
        $EmploymentAdvertisementCategoryData = $request->all();

        if ($EmploymentAdvertisementCategory->slug != $request['slug']) {
            if (empty($request['slug'])) {
                $request->slug = $request['title'];
            }

            $request->slug = strtolower($request->slug);
            $EmploymentAdvertisementCategoryData['slug'] = SlugService::createSlug(EmploymentAdvertisementCategory::class, 'slug', $request->slug);
        }

        if ($EmploymentAdvertisementCategory->update($EmploymentAdvertisementCategoryData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/advertisement-category')->with('notification', [
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
            $EmploymentAdvertisement = EmploymentAdvertisement::where('cat', $key)->get()->all();
            foreach ($EmploymentAdvertisement as $item_inner) {
                $Element = EmploymentAdvertisement::find($item_inner->id);
                $Element->cat = 0;
                $Element->save();
            }
            EmploymentAdvertisementCategory::where('id', $key)->delete();
        }

        return redirect('/dashboard/advertisement-category')->with('notification', [
            'class' => 'success',
            'message' => 'گروه شغلی مورد نظر حذف شد'
        ]);
    }
}
