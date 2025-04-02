<?php

namespace App\Repositories;

use App\Helpers\Helper;
use App\Models\Profile;
use App\Services\FileUploaderService;
use Illuminate\Support\Facades\Auth;

class ProfileRepository
{

    public function __construct()
    {
    }

    public function handleStore($request)
    {


        if (!Profile::query()->where('user_id', Auth::id())->exists()) {

            $fileArray['avatar_image'] = null;

            if ($request->has('avatar_image')) {
                $fileArray['avatar_image'] = FileUploaderService::uploadFile($request->avatar_image, null, 'avatars');
                $this->updateUserAvatarImage($fileArray['avatar_image']);
            }

            $password = bcrypt($request->password);
            $newData = $this->prepareData($request, $password);

            $this->updateUserPassword($password);
            return Profile::query()->create($newData);

        } else {

            return false;

        }

    }

    private function prepareData($request, $password): array
    {

        return [
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'last_name'     => $request->last_name,
            'password'      => $password,
            'gender'        => $request->gender,
            'date_of_brith' => Helper::timestampToDateTime($request->date_of_brith),
            'about'         => $request->about,
        ];
    }

    private function updateUserPassword($password): void
    {
        Auth::user()->update([
            'password' => $password
        ]);
    }

    private function updateUserAvatarImage($path)
    {
        Auth::user()->update([
            'avatar' => $path
        ]);
    }


}
