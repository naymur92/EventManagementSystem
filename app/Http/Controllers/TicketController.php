<?php

namespace App\Http\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\DB;
use App\Core\Session;
use App\Models\Event;

class TicketController extends Controller
{
    /**
     * Event registration page
     *
     * @return void
     */
    public function eventRegistrationPage($event_id): void
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->status != 1) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/');
        }

        if (Auth::user() && Auth::user()->type != 3) {
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

        view('pages.events.registration', array('title' => "Event Registration", 'event' => $event));
    }


    /**
     * View and print ticket copy
     *
     * @param string $unique_id
     * @return void
     */
    public function viewTicket(string $unique_id)
    {
        $decoded = base64_decode($unique_id);
        [$bookingNo, $attendeeId] = explode('|', $decoded);



        view('pages.events.print-ticket', array('title' => "Print Ticket"));
    }
}
