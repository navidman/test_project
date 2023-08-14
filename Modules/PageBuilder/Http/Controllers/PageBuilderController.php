<?php

namespace Modules\PageBuilder\Http\Controllers;

use App\Http\Controllers\HomeController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PageBuilder\Entities\PageBuilder;
use Modules\PageBuilder\Http\Requests\PageBuilderRequest;

class PageBuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $Pages = PageBuilder::where('title', 'like', '%' . $_GET['search'] . '%')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $Pages = PageBuilder::orderBy('created_at', 'desc')->paginate(20);
        }
        return view('pagebuilder::index', compact('Pages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('pagebuilder::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PageBuilderRequest $request)
    {
        $User = auth()->user();
        $PageData = $request->all();
        $PageData['author'] = $User->id;

        if (PageBuilder::create($PageData)) {
            return redirect('dashboard/page-builder')->with('notification', [
                'class' => 'success',
                'message' => 'برگه با موفقیت ثبت شد.'
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
    public function show($slug)
    {
        if (auth()->check() && auth()->user()->role == 'admin') {
            $Page = PageBuilder::where('slug', $slug)->orWhere('id', $slug)->first();
        } else {
            $Page = PageBuilder::where('slug', $slug)->where('status', 'published')->orWhere('id', $slug)->firstOrFail();
        }

        if ($Page) {
            $PageData['visited'] = $Page->visited + 1;
            $Page->update($PageData);

            $Page['author'] = HomeController::GetUserData($Page->author);
        }

        return response()->json($Page);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $Page = PageBuilder::find($id);
        return view('pagebuilder::edit', compact('Page'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PageBuilderRequest $request, $id)
    {
        $Page = PageBuilder::find($id);
        $PageData = $request->all();

        if ($Page->update($PageData)) {
            return redirect()->back()->with('notification', [
                'class' => 'success',
                'message' => 'اطلاعات بروزرسانی شد'
            ]);
        } else {
            return redirect('dashboard/page-builder')->with('notification', [
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
    public function destroy($id)
    {
        //
    }
}
