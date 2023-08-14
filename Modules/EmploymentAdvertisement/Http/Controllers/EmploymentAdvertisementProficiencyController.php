<?php

namespace Modules\EmploymentAdvertisement\Http\Controllers;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisement;
use Modules\EmploymentAdvertisement\Entities\EmploymentAdvertisementProficiency;
use Modules\EmploymentAdvertisement\Http\Requests\EmploymentAdvertisementCategoryRequest;

class EmploymentAdvertisementProficiencyController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $EmploymentAdvertisementProficiency = EmploymentAdvertisementProficiency::orderBy('created_at', 'desc')->paginate(20);
        return view('employmentadvertisement::proficiency.index', compact('EmploymentAdvertisementProficiency'));
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
        $EmploymentAdvertisementProficiencyData = $request->all();

        if (empty($request['slug'])) {
            $request->slug = $request['title'];
        }

        $request->slug = strtolower($request->slug);
        $EmploymentAdvertisementProficiencyData['slug'] = SlugService::createSlug(EmploymentAdvertisementProficiency::class, 'slug', $request->slug);

        if (EmploymentAdvertisementProficiency::create($EmploymentAdvertisementProficiencyData)) {
            return redirect('/dashboard/advertisement-proficiency')->with('notification', [
                'class' => 'success',
                'message' => 'تخصص با موفقیت ایجاد شد'
            ]);
        } else {
            return redirect('/dashboard/advertisement-proficiency')->with('notification', [
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
        $EmploymentAdvertisementProficiency = EmploymentAdvertisementProficiency::find($id);
        return view('employmentadvertisement::proficiency.edit', compact('EmploymentAdvertisementProficiency'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $EmploymentAdvertisementProficiency = EmploymentAdvertisementProficiency::find($id);
        $EmploymentAdvertisementProficiencyData = $request->all();

        if ($EmploymentAdvertisementProficiency->slug != $request['slug']) {
            if (empty($request['slug'])) {
                $request->slug = $request['title'];
            }

            $request->slug = strtolower($request->slug);
            $EmploymentAdvertisementProficiencyData['slug'] = SlugService::createSlug(EmploymentAdvertisementCategory::class, 'slug', $request->slug);
        }

        if ($EmploymentAdvertisementProficiency->update($EmploymentAdvertisementProficiencyData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/advertisement-proficiency')->with('notification', [
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
            $EmploymentAdvertisement = EmploymentAdvertisement::where('proficiency', $key)->get()->all();
            foreach ($EmploymentAdvertisement as $item_inner) {
                $Element = EmploymentAdvertisement::find($item_inner->id);
                $Element->proficiency = 0;
                $Element->save();
            }
            EmploymentAdvertisementProficiency::where('id', $key)->delete();
        }

        return redirect('/dashboard/advertisement-proficiency')->with('notification', [
            'class' => 'success',
            'message' => 'تخصص مورد نظر حذف شد'
        ]);
    }
}
