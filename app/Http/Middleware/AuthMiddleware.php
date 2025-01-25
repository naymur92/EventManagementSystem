<?php

namespace App\Http\Middleware;

use App\Core\Authenticator;
use App\Core\Session;

class AuthMiddleware
{
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            // Session::flash('flash_error', "Unauthorized!");

            redirect('/login');

            // throw new \Exception("Unauthorized", 401);
        }

        if ($_SESSION['user']['status'] != 1) {
            (new Authenticator)->logout();

            redirect('/');

            // throw new \Exception("Unauthorized! Invalid user!", 401);
        }
    }
}
