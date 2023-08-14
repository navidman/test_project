<?php

namespace Modules\Newsletter\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Newsletter\Entities\Newsletter;
use Modules\Newsletter\Http\Requests\NewsletterRequest;

class NewsletterController extends Controller
{
    public function SubmitMember(NewsletterRequest $request)
    {
        $NewsletterData = [];

        $NewsletterData['contact'] = $request->contact;

        if (filter_var($request->contact, FILTER_VALIDATE_EMAIL)) {
            $NewsletterData['type'] = 'email';
        } elseif (is_numeric($request->contact)) {
            if (preg_match("/^[0]{1}[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}$/", $request->contact)) {
                $NewsletterData['type'] = 'phone';
            } else {
                return response()->json(['status' => 'PhoneInvalid']);
            }
        }else{
            return response()->json(['status' => 'EmailInvalid']);
        }

        $NewsletterData['status'] = 'active';

        if (Newsletter::create($NewsletterData)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 'nok']);
        }
    }
}
