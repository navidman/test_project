<?php

namespace Modules\Review\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Review\Entities\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('review::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('review::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, $id)
    {
        $ReviewData = $request->all();

        $ch = curl_init("https://api.ipdata.co?api-key=9805792c951567357ab5f75d87a7327a52d8f57bf4d129b07b00c5f2");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $MyIP = curl_exec($ch);
        curl_close($ch);

        $MyIP = json_decode($MyIP)->ip;

        $ReviewCheck = Review::where('post_id', $id)->where('ip', $MyIP)->where('post_type', $request->post_type)->get()->count();

        if ($ReviewCheck == 0) {
            $ReviewData['post_id'] = $id;
            $ReviewData['ip'] = $MyIP;
            Review::create($ReviewData);
            $Data = [
                'reviewCheck' => $ReviewCheck,
                'status' => 'ok'
            ];
            return response()->json($Data);
        } else {
            $Data = [
                'reviewCheck' => $ReviewCheck,
                'status' => 'nok'
            ];
            return response()->json($Data);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($type, $id)
    {
        $Review = Review::where('post_type', $type)->where('post_id', $id)->get()->all();


        $ReviewData = [];
        $ReviewData['currentRate'] = 0;

        if ($Review) {
            foreach ($Review as $item) {
                $ReviewData['currentRate'] += $item->rate;
            }

            $ReviewData['currentRate'] /= count($Review);
            $ReviewData['currentRate'] = floor($ReviewData['currentRate']);
        }

        $ReviewData['RateCount'] = count($Review);

        return response()->json($ReviewData);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('review::edit');
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
