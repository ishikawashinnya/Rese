<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class CustomRegisterResponse implements RegisterResponseContract
{
    /**
     * @param  mixed $request
     * @return mixed
     */
    public function toResponse($request)
    {
        return $request->wantsJson()
                    ? new JsonResponse('', 201)
                    : redirect()->route('thanks');
    }
}