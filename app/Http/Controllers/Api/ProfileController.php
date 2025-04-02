<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Resources\Api\ProfileResource;
use App\Models\Profile;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProfileController extends Controller
{

    public function __construct(private readonly ProfileRepository $repository)
    {
    }

    public function index()
    {

        try {

            $profile = Profile::query()
                ->where('user_id', Auth::id())->first();

            return Response::success('لیست پروفایل کاربر', new ProfileResource($profile), 200);


        } catch (\Exception $exception) {

            return Response::failed('خطایی رخ داده است', null, '500');

        }
    }

    public function store(StoreProfileRequest $request)
    {

        try {

            $createdProfile = $this->repository->handleStore($request);

            if ($createdProfile)
                return Response::success('پروفایل با موفقیت ایجاد شد', new ProfileResource($createdProfile), 200);
            else
                return Response::success('این کاربر پروفایل دارد', null, 200);


        } catch (\Exception $e) {

            return Response::failed('خطایی رخ داده است', null, '500');

        }

    }

}
