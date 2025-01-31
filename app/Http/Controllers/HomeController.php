<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\DB;
use App\Core\Session;
use App\Models\Event;
use PDO;

class HomeController extends Controller
{
    /**
     * Display the home page
     *
     * @return void
     */
    public function index(): void
    {
        view('pages.homepage', array('title' => "Home"));
    }

    /**
     * Events pages for
     *
     * @return void
     */
    public function eventPage(): void
    {
        view('pages.events.all-events', array('title' => "Events"));
    }

    /**
     * Events details page
     *
     * @return void
     */
    public function eventDetailsPage($event_id): void
    {
        $event = (new Event)->find($event_id);

        if (!$event) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/');
        }

        view('pages.events.events-details', array('title' => "Event Details", 'event_id' => $event_id));
    }

    /**
     * Book ticket page
     *
     * @return void
     */
    public function getTicketPage($event_id): void
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->status != 1) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/');
        }

        if ($event->current_capacity == 0 && $event->max_capacity != 0) {
            Session::setPopup('popup_error', "Seat full!");

            redirect('/');
        }

        if ($event->start_time < date('Y-m-d H:i:s')) {
            Session::setPopup('popup_error', "Registration Expired!");

            redirect('/');
        }

        setUnsetUniqueId();

        view('pages.events.get-ticket', array('title' => "Get Ticket", 'event' => $event));
    }
}
