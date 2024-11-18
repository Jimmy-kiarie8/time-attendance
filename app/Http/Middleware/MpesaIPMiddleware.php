<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaIPMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedIPs = [
            '196.201.214.200',
            '196.201.214.206',
            '196.201.213.114',
            '196.201.214.207',
            '196.201.214.208',
            '196.201.213.44',
            '196.201.212.127',
            '196.201.212.138',
            '196.201.212.129',
            '196.201.212.136',
            '196.201.212.74',
            '196.201.212.69'
        ];

        $requestIP = $request->ip();

        if (!in_array($requestIP, $allowedIPs)) {

            // Invalid source IP address
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
