<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use RealRashid\SweetAlert\Facades\Alert;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {

        // if (! $request->expectsJson()) {
        //     Alert::warning('Akses Gagal', 'Akses tidak berhasil, Harap Login Terlebih Dahulu');
        //     return redirect('/login');
        // }

        // return $request;
        Alert::warning('Akses Gagal', 'Akses tidak berhasil, Harap Login Terlebih Dahulu');
        return route('login');

    }
}
