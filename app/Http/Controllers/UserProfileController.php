<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserStripeConnectedAccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function index()
    {
        $products = (new ProductController)->index();
        $stripeAccountInfo = UserStripeConnectedAccount::where(['user_id' => auth()->id(), 'is_active' => true])->first();

        return view('profile', ['products' => $products, 'stripeAccountInfo' => $stripeAccountInfo]);
    }

    public function update(Request $request, User $user)
    {

        $this->validate($request, [
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id,],
            // 'location' => ['required', 'max:255'],
            'phone' => ['required', 'numeric', 'digits:10'],
            // 'role' => ['required','numeric', Rule::in(1,2)],
            'editImage' => 'nullable | mimetypes:image/bmp,image/gif,image/png,image/jpeg,image/jpg,image/JPG,image/webp | max:50048'
        ]);


        try {
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            // $user->location = $request->location;
            $user->phone = $request->phone;

            if ($request->hasFile('editImage') && ($request->file('editImage') instanceof UploadedFile)) {
                $fileData = $this->uploads($request->file('editImage'), 'user/avatar/');

                if (!empty($fileData['filePath'])) {
                    if (Storage::exists('public/' . substr($user->avatar, strpos($user->avatar, '/') + 1))) {
                        Storage::delete('public/' . substr($user->avatar, strpos($user->avatar, '/') + 1));
                    }
                    $user->avatar = $fileData['filePath'] ?? null;
                }
            }

            $isUpdated = $user->save();

            if ($isUpdated) {
                $response = [
                    'key' => 'success',
                    'message' => 'Your profile has been updated successfully!!'
                ];
            } else {
                $response = [
                    'key' => 'fail',
                    'message' => 'Your profile could not be updated'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'key' => 'fail',
                'message' => 'Your profile could not be updated'
            ];
        }


        return redirect()->route('user.profile.view')->with($response['key'], $response['message']);
    }
}
