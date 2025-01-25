<?php

namespace App\Http\Middleware;

use App\Core\Session;

class GuestMiddleware
{
    public function handle()
    {
        if (isset($_SESSION['user'])) {
            Session::flash('flash_error', "Access denied for authenticated users!");

            redirect('/');

            // throw new \Exception("Access denied for authenticated users.", 403);
        }
    }
}
