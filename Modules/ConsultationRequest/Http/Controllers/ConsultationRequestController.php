<?php

namespace Modules\ConsultationRequest\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ConsultationRequest\Entities\ConsultationRequest;
use Modules\ConsultationRequest\Http\Requests\ConsultationRequestRequest;

class ConsultationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (isset($_GET['search']) && $_GET['search']) {
            $ConsultationRequest = ConsultationRequest::where('name', 'like', '%' . $_GET['search'] . '%')->orWhere('email', 'like', '%' . $_GET['search'] . '%')->orWhere('phone', 'like', '%' . $_GET['search'] . '%')->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $ConsultationRequest = ConsultationRequest::orderBy('created_at', 'desc')->paginate(20);
        }

        return view('consultationrequest::index', compact('ConsultationRequest'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('consultationrequest::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ConsultationRequestRequest $request)
    {
        $ContactUsData = $request->all();
        $ContactUsData['status'] = 'new';

        if (ConsultationRequest::create($ContactUsData)) {
            return response()->json(['status' => 200, $ContactUsData]);
        }else {
            return response()->json(['status' => 'nok']);
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('consultationrequest::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $ConsultationRequest = ConsultationRequest::find($id);
        $ConsultationRequestData['status'] = 'viewed';
        $ConsultationRequest->update($ConsultationRequestData);

        return view('consultationrequest::edit', compact('ConsultationRequest'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
