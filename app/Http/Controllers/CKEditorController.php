<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller {
    public function upload(Request $request, $path) {
//        $user = auth()->user();
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('upload')->move(storage_path('app/attachments/media/' . $path . '/full/'), $fileName);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/app/attachments/media/' . $path . '/full/' . $fileName);

//            if ($path = $item->store('attachments/tickets')) {
//                $Attachments = new Attachments();
//                $Attachments->uid = $user->id;
//                $Attachments->orgname = $item->getClientOriginalName();
//                $Attachments->path = $path;
//                $Attachments->type = $item->extension();
//                $Attachments->created_at = time();
//                $Attachments->save();
//            }

            $msg = 'Image successfully uploaded';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
