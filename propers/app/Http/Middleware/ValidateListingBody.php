<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class ValidateListingBody
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $validator = Validator::make($request->all(), [
            'property_id' => 'integer',
            'rooms' => 'required|array|min:1',
            'rooms.*.room_id' => 'integer',
            'rooms.*.date' => 'required|date_format:Y-m-d',
            'rooms.*.max_' => 'required|integer|min:1',
            'rooms.*.price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid request body',
                'details' => $validator->errors()
            ], 422);
        }

        return $next($request);
    }
}
