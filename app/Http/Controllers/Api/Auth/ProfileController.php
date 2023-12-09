<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AvatarRequest;
use App\Http\Requests\Auth\RoleRequest;
use App\Http\Requests\Auth\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    // GET: /users
    public function all()
    {
        $users = User::orderBy('id', 'DESC')->paginate(8);
        return response()->json($users);
    }
    // GET: /users/{user}
    public function get(int $user_id)
    {
        $user = User::where('id', $user_id)->first();
        return response()->json($user);
    }
    // PUT: /users/{user}
    public function update(UserRequest $request, int $user_id)
    {
        $user = $request->only('name', 'email', 'password', 'address', 'gender', 'phone_number');
        $createdUser = User::where('id', $user_id)->update($user);
        if ($createdUser) {
            return response()->json(['message' => 'Updated']);
        }
        return response()->json(['message' => 'Has a error'], 400);
    }
    // PUT: /users/{user}/role
    public function role(RoleRequest $request, int $user_id) {
        $user = User::find($user_id);
        if ($user) {
            $user->role = $request->role;
            $user->save();
            return response()->json(['message' => 'Role Changed: '. $request->role]);
        }
        return response()->json(['message' => 'User doesn\'t not Exists' ], 404);
    }
    // POST: /users/{user}/avatar
    public function avatar(AvatarRequest $request, int $user_id)
    {
        if (!$request->hasFile('avatar')) {
            return response()->json(['message' => 'Please upload avatar'], 400);
        }
        $user = User::where('id', $user_id)->first();
        $image = $request->avatar;
        $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        $imageExtension = strtolower($image->getClientOriginalExtension());

        if (!in_array($imageExtension, $allowedImageExtensions)) {
            return response()->json(['error' => 'Invalid image format'], 400);
        }

        $maxSize = 5 * 1024 * 1024;
        if ($image->getSize() > $maxSize) {
            return response()->json(['error' => 'File size exceeds 5MB limit'], 400);
        }

        $imageName = Str::slug($user->name, '-') . '.' . $image->extension();
        Storage::putFileAs('public/avatar', $image, $imageName);
        $user->avatar = env('APP_URL') . '/storage/avatar/' . $imageName;
        $user->save();
        return response()->json(['message' => 'Avatar Changed']);
    }
    // DELETE: /users/{user}
    public function destroy(int $user_id)
    {
        User::destroy($user_id);
        return response()->json(['message' => 'Deleted']);
    }
}
