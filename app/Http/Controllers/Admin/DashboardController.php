<?php

namespace App\Http\Controllers\Admin;

use App\Core\Controller;

class DashboardController extends Controller
{
    /**
     * Dashboard page
     *
     * @return void
     */
    public function index()
    {
        view('admin.pages.dashboard', array('title' => "Dashboard"));
    }
}
