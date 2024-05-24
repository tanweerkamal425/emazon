<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class UserController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;
        $q = request('q');
        $gender = request('gender');
        $is_active = request('is_active');


        $users = User::query();

        if ($q) {
            $users->where('first_name', 'LIKE', "%{$q}%")
                    ->orWhere('last_name', 'LIKE', "%{$q}%")
                    ->orWhere('phone', 'LIKE', "%{$q}%");
        }
        if ($gender) {
            $users->where('gender', $gender - 1);
        }
        if ($is_active) {
            $users->where('is_active', $is_active - 1);
        }
        if ($v = $request->input('from_date')) {
            $users->whereDate('created_at', '>=', date("Y-m-d 00:00:00", strtotime($v)));
        }

        if ($v = $request->input('to_date')) {
            $users->whereDate('created_at', '<=', date("Y-m-d 23:59:59", strtotime($v)));
        }

        $users = $users->orderBy('id', 'desc')->paginate($items);

        return UserResource::collection($users);
    }

    public function show(Request $request, int $id): JsonResource
    {
        $user = User::find($id);
        if (is_null($user)) {
            throw new NotFoundResourceException("User with ID '$id' does not exist");
        }


        return new UserResource($user);
    }
}
