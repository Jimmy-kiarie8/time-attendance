<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as Response;

class RegisterResponse implements Response
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $request->wantsJson()
                    ? response()->json(['two_factor' => false])
                    : redirect()->intended('client/dashboard');
    }
}
