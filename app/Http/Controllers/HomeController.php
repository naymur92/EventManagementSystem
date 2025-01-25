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
     * Database connection testing route
     *
     * @return void
     */
    public function testDbConnection()
    {
        // $data = DB::query("SELECT gateway, card_type, TotalAmount FROM online_payment_transaction ORDER BY created_at DESC LIMIT 500")->fetchAll();
        $data = DB::getInstance()->table('online_payment_transaction')
            ->whereBetween('created_at', '2024-00-01 00:00:00', '2024-04-01 00:00:00')
            // ->where('gateway', '=', 'bkash')
            ->when(true, function ($q) {
                $q->where('status', '=', 2)
                    ->orWhere('status', '=', 1);
            })
            ->where('is_refund', '=', 0)
            ->select(array('gateway', 'TotalAmount', 'status'))
            ->addSelect(array('is_refund'))
            ->get();
        dd($data);
    }
}
