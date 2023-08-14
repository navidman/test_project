<?php

namespace Modules\FileLibrary\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Modules\FileLibrary\Entities\FileLibrary;
use Illuminate\Support\Facades\File;

class FileLibraryController extends Controller
{
    /* Upload Function */
    public static function upload($request, $file_type, $folder_name, $used, $sizes = null)
    {
        if ($attachment_path = $request) {
            if (auth()->check()) {
                $User_id = auth()->user()->id;

            } else {
                $User_id = 0;
            }
            $attachments_id = array();

            if ($file_type == 'image') {
                File::makeDirectory(storage_path().'/app/public/' . $folder_name . '/full', $mode = 0755, true, true);
                if ($path = $attachment_path->store('public/' . $folder_name . '/full')) {
                    $Attachments = new FileLibrary();
                    $Attachments->uid = $User_id;
                    $Attachments->used = $used;
                    $Attachments->org_name = $attachment_path->getClientOriginalName();
                    $Attachments->file_name = pathinfo($path)['filename'] . '.' . pathinfo($path)['extension'];

                    $Attachments->path = 'app/public/' . $folder_name . '/';
                    $Attachments->extension = $attachment_path->extension();
                    $Attachments->file_type = $file_type;

                    if ($Attachments->extension != 'svg' && $Attachments->extension != 'gif' && $file_type == 'image') {
                        $img = Image::make(storage_path('app/public/' . $folder_name . '/full/' . $Attachments->file_name));

                        $img->backup();

                        foreach ($sizes as $size) {
                            $img->reset();

                            if ($size[2] == 'crop') {
                                $img->crop($size[0], $size[1]);
                                if (!file_exists(storage_path('app/public/' . $folder_name . '/' . $size[0]))) {
                                    File::makeDirectory(storage_path().'/app/public/' . $folder_name . '/' . $size[0], $mode = 0755, true, true);
                                }
                            } elseif ($size[2] == 'fit') {
                                $img->fit($size[0], $size[1], function ($constraint) {
                                    $constraint->upsize();
                                }, 'top');
                                if (!file_exists(storage_path('app/public/' . $folder_name . '/' . $size[0]))) {
                                    File::makeDirectory(storage_path().'/app/public/' . $folder_name . '/' . $size[0], $mode = 0755, true, true);
                                }
                            } elseif ($size[2] == 'resize') {
                                $img->resize($size[0], $size[1], function ($constraint) {
                                    $constraint->aspectRatio();
                                    $constraint->upsize();
                                });
                                if (!file_exists(storage_path('app/public/' . $folder_name . '/' . $size[0]))) {
                                    File::makeDirectory(storage_path().'/app/public/' . $folder_name . '/' . $size[0], $mode = 0755, true, true);
                                }
                            }
                            $img->save(storage_path('app/public/' . $folder_name . '/' . $size[0] . '/' . pathinfo($path)['filename'] . '.' . pathinfo($path)['extension'], 100));
                        }
                    }

                    if ($Attachments->save()) {
                        array_push($attachments_id, $Attachments->id);
                    } else {
                        return redirect()->back()->with('notification', [
                            'status' => 'danger',
                            'message' => 'فایل های پیوست شده آپلود نشد!',
                        ]);
                    }
                }
            } elseif ($file_type == 'file') {
                File::makeDirectory(storage_path().'/app/public/' . $folder_name , $mode = 0755, true, true);
                if ($path = $attachment_path->store('public/' . $folder_name)) {
                    $Attachments = new FileLibrary();
                    $Attachments->uid = $User_id;
                    $Attachments->used = $used;
                    $Attachments->org_name = $attachment_path->getClientOriginalName();
                    $Attachments->file_name = pathinfo($path)['filename'] . '.' . pathinfo($path)['extension'];
                    $Attachments->path = 'app/public/' . $folder_name . '/';
                    $Attachments->extension = $attachment_path->extension();
                    $Attachments->file_type = $file_type;
                    if ($Attachments->save()) {
                        array_push($attachments_id, $Attachments->id);
                    } else {
                        return redirect()->back()->with('notification', [
                            'status' => 'danger',
                            'message' => 'فایل های پیوست شده آپلود نشد!',
                        ]);
                    }
                }
            }

            return end($attachments_id);
        }
    }
}
