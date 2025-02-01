<?php

namespace App\Http\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\DB;
use App\Core\Session;
use App\Models\Event;
use Exception;

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

        $params = array();
        $sql = "SELECT
                    ev.event_id,
                    ev.name,
                    ev.location,
                    ev.registration_fee,
                    DATE_FORMAT(ev.start_time, '%Y-%m-%d %h:%i %p') start_time,
                    DATE_FORMAT(ev.end_time, '%Y-%m-%d %h:%i %p') end_time,
                    u.name host_name,
                    u.email host_email,
                    u.mobile host_mobile,
                    a.attendee_id,
                    a.booking_no,
                    a.name attendee_name,
                    a.email attendee_email,
                    a.mobile attendee_mobile,
                    a.payment_trnx_no,
                    a.payment_amount,
                    a.payment_account_no,
                    a.registration_time
                FROM attendees a
                JOIN events ev
                    ON a.event_id = ev.event_id
                JOIN users u
                    ON u.user_id = ev.user_id
                WHERE a.status = ? AND a.booking_no = ? AND a.attendee_id = ?";

        $params[] = 1;
        $params[] = $bookingNo;
        $params[] = $attendeeId;

        try {
            $ticketData = DB::query($sql, $params)->fetchAll();

            if (empty($ticketData)) {
                throw new Exception("Invalid access! Ticket not found!");
            }

            // dd($ticketData);

            view('pages.events.ticket-copy', array('title' => "Event Ticket", 'ticketData' => $ticketData[0]));
        } catch (Exception $e) {
            Session::setPopup('popup_error', $e->getMessage());
            // redirect('/');
        }
    }
}
