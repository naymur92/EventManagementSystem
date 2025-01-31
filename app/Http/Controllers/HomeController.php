<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\DB;
use App\Core\Session;
use PDO;

class HomeController extends Controller
{
    /**
     * Display the home page
     *
     * @return void
     */
    public function index()
    {
        view('pages.homepage', array('title' => "Home"));
    }

    /**
     * Events pages for user
     *
     * @return void
     */
    public function eventPage(): void
    {
        view('pages.events.all-events', array('title' => "Events"));
    }
}
