<?php

namespace App\Http\Middleware;

use App\Core\Authenticator;
use App\Core\Session;

class HostUserMiddleware
{
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            // Session::flash('flash_error', "Unauthorized!");

            redirect('/login');

            // throw new \Exception("Unauthorized", 401);
        }

        if ($_SESSION['user']['type'] != 2) {
            Session::flash('flash_error', "Unauthorized!");

            if ($_SESSION['user']['type'] == 1) {
                redirect('/admin');
            } else {
                redirect('/');
            }

            // throw new \Exception("Unauthorized! Invalid user!", 401);
        }
    }
}
