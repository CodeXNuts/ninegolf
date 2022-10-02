<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Administrator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class AdminController extends Controller
{
    public function index()
    {
        return view('administrator.profile.index');
    }

    public function update(Administrator $administrator, Request $request)
    {
        $res = [
            'key' => 'fail',
            'msg' =>'Profile has not been updated'
        ];
        if (!empty($administrator)) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:administrators',
                'password' => 'required|string|confirmed|min:8',
                'image' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/jpg,image/JPG,image/webp | max:50048',
                'phone' => 'required',
                'address' => 'required',
                'zip' => 'required',
                'country' => 'required'
            ]);

            if ($request->hasFile('image') && ($request->file('image') instanceof UploadedFile)) {

                $fileData = $this->uploads($request->file('image'), 'admin/avatar/');
            }

            $administrator->name = $request->name;
            $administrator->email = $request->email;
            $administrator->phone = $request->phone;
            $administrator->address = $request->address;
            $administrator->zip = $request->zip;
            $administrator->country = $request->country;
            $administrator->avatar = $fileData['filePath'] ?? null;

            try {

                $isUpdated = $administrator->save();

                if(!empty($isUpdated))
                {
                    $res = [
                        'key' => 'success',
                        'msg' =>'Profile has been updated successfully'
                    ];
                }
            } catch (Exception $e) {
                dd($e);
                $res = [
                    'key' => 'fail',
                    'msg' =>'Profile has been updated successfully'
                ];
            }
        }

        return redirect()->route('administrator.profile')->with($res['key'],$res['msg']);
    }
}
