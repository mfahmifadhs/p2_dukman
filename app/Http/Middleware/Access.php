<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Access
{
    public function handle(Request $request, Closure $next, string $status)
    {
        if(Auth::user() == null){
            return redirect('/')->with('failed','Anda tidak memiliki akses!');
        }

        $id    = Auth::user()->id;
        $role  = Auth::user()->role_id;
        $akses = Auth::user()->akses_id;


        if ($status == 'master')
        {
            if ($role == 1) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        if ($status == 'admin')
        {
            if ($role == 1 || $role == 2) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        if ($status == 'admin-atk')
        {
            if ($role == 1 || $akses == 3) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        if ($status == 'admin-aadb')
        {
            if ($role == 1 || $akses == 4) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        if ($status == 'admin-bmhp')
        {
            if ($role == 1 || $akses == 5) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        if ($status == 'monitor')
        {
            if ($role != 4) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        if ($status == 'user' || $id == 25)
        {
            if ($role == 4 || $id == 25) {
                return $next($request);
            } else {
                return back()->with('failed','Anda tidak memiliki akses!');
            }
        }

        return $next($request);
    }
}
