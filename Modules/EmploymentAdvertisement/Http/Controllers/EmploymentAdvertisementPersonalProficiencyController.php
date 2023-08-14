<?php

namespace Modules\EmploymentAdvertisement\Http\Controllers;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementPersonalProficiency;
use Modules\EmploymentAdvertisement\Http\Requests\EmploymentAdvertisementCategoryRequest;

class EmploymentAdvertisementPersonalProficiencyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $EmploymentAdvertisementPersonalProficiency = EmploymentAdvertisementPersonalProficiency::orderBy('created_at', 'desc')->paginate(20);
        return view('employmentadvertisement::personal-proficiency.index', compact('EmploymentAdvertisementPersonalProficiency'));
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
        $EmploymentAdvertisementPersonalProficiencyData = $request->all();

        if (empty($request['slug'])) {
            $request->slug = $request['title'];
        }

        $request->slug = strtolower($request->slug);
        $EmploymentAdvertisementPersonalProficiencyData['slug'] = SlugService::createSlug(EmploymentAdvertisementPersonalProficiency::class, 'slug', $request->slug);

        if (EmploymentAdvertisementPersonalProficiency::create($EmploymentAdvertisementPersonalProficiencyData)) {
            return redirect('/dashboard/ads-personal-proficiency')->with('notification', [
                'class' => 'success',
                'message' => 'تخصص فردی با موفقیت ایجاد شد'
            ]);
        } else {
            return redirect('/dashboard/ads-personal-proficiency')->with('notification', [
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
        $EmploymentAdvertisementPersonalProficiency = EmploymentAdvertisementPersonalProficiency::find($id);
        return view('employmentadvertisement::personal-proficiency.edit', compact('EmploymentAdvertisementPersonalProficiency'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(EmploymentAdvertisementCategoryRequest $request, $id)
    {
        $EmploymentAdvertisementPersonalProficiency = EmploymentAdvertisementPersonalProficiency::find($id);
        $EmploymentAdvertisementPersonalProficiencyData = $request->all();

        if ($EmploymentAdvertisementPersonalProficiency->slug != $request['slug']) {
            if (empty($request['slug'])) {
                $request->slug = $request['title'];
            }

            $request->slug = strtolower($request->slug);
            $EmploymentAdvertisementPersonalProficiencyData['slug'] = SlugService::createSlug(EmploymentAdvertisementPersonalProficiency::class, 'slug', $request->slug);
        }

        if ($EmploymentAdvertisementPersonalProficiency->update($EmploymentAdvertisementPersonalProficiencyData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/ads-personal-proficiency')->with('notification', [
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
//        foreach ($request->delete_item as $key => $item) {
//            $EmploymentAdvertisement = EmploymentAdvertisement::where('personal_proficiency', $key)->get()->all();
//            foreach ($EmploymentAdvertisement as $item_inner) {
//                $Element = EmploymentAdvertisement::find($item_inner->id);
//                $Element->personal_proficiency = 0;
//                $Element->save();
//            }
//            EmploymentAdvertisementPersonalProficiency::where('id', $key)->delete();
//        }
//
//        return redirect('/dashboard/ads-personal-proficiency')->with('notification', [
//            'class' => 'success',
//            'message' => 'تخصص فردی مورد نظر حذف شد'
//        ]);
    }
}
