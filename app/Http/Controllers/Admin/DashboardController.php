<?php

namespace App\Http\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard page
     *
     * @return void
     */
    public function index()
    {
        $hosts = $this->getTotalHosts();
        $events = $this->getTotalEvents();
        $upcomingEvents = $this->getTotalUpcomingEvents();
        $attendees = $this->getTotalAttendees();

        view('admin.pages.dashboard', array('title' => "Dashboard", 'hosts' => $hosts, 'events' => $events, 'upcomingEvents' => $upcomingEvents, 'attendees' => $attendees));
    }

    /**
     * Get total hosts form DB and return
     *
     * @return integer
     */
    private function getTotalHosts(): int
    {
        if (Auth::user()->type == 2) {
            $hosts = DB::query("SELECT COUNT(*) total_hosts FROM users WHERE type=? AND status=? AND user_id = ?", [2, 1, Auth::user()->user_id])->fetchAll();
        } else {
            $hosts = DB::query("SELECT COUNT(*) total_hosts FROM users WHERE type=? AND status=?", [2, 1])->fetchAll();
        }

        return $hosts[0]['total_hosts'] ?? 0;
    }

    /**
     * Get total published events form DB and return
     *
     * @return integer
     */
    private function getTotalEvents(): int
    {
        if (Auth::user()->type == 2) {
            $events = DB::query("SELECT COUNT(*) total_events FROM events WHERE status=? AND user_id = ?", [1, Auth::user()->user_id])->fetchAll();
        } else {
            $events = DB::query("SELECT COUNT(*) total_events FROM events WHERE status=?", [1])->fetchAll();
        }

        return $events[0]['total_events'] ?? 0;
    }

    /**
     * Get total upcoming events form DB and return
     *
     * @return integer
     */
    private function getTotalUpcomingEvents(): int
    {
        if (Auth::user()->type == 2) {
            $upcomingEvents = DB::query("SELECT COUNT(*) upcoming_events FROM events WHERE status=? AND start_time >= ? AND user_id=?", [1, date('Y-m-d H:i:s'), Auth::user()->user_id])->fetchAll();
        } else {
            $upcomingEvents = DB::query("SELECT COUNT(*) upcoming_events FROM events WHERE status=? AND start_time >= ?", [1, date('Y-m-d H:i:s')])->fetchAll();
        }

        return $upcomingEvents[0]['upcoming_events'] ?? 0;
    }

    /**
     * Get registered attendees form DB and return
     *
     * @return integer
     */
    private function getTotalAttendees(): int
    {
        if (Auth::user()->type == 2) {
            $attendees = DB::query("SELECT COUNT(*) total_registration FROM attendees a JOIN events ev ON ev.event_id=a.event_id WHERE a.status=? AND ev.status=? AND ev.user_id=?", [1, 1, Auth::user()->user_id])->fetchAll();
        } else {
            $attendees = DB::query("SELECT COUNT(*) total_registration FROM attendees a JOIN events ev ON ev.event_id=a.event_id WHERE a.status=? AND ev.status=?", [1, 1])->fetchAll();
        }

        return $attendees[0]['total_registration'] ?? 0;
    }
}
