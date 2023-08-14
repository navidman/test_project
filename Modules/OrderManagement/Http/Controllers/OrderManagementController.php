<?php

namespace Modules\OrderManagement\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\OrderManagement\Entities\OrderManagement;

class OrderManagementController extends Controller
{
    /*
     * Get Orders
     * Route: /api/orders
     * GET
     * */
    public function ShowOwnerOrders()
    {
        if (Auth::user()->parent_id) {
            $User = Auth::user()->parent_id;
        } else {
            $User = auth()->user()->id;
        }

        $Orders = OrderManagement::where('uid', $User)->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($Orders);
    }
}
