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
     * Ticket list of users
     *
     * @return void
     */
    public function myTickets()
    {

        if (!Auth::user() || Auth::user()->type != 3) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/');
        }

        $params = array();
        $sql = "SELECT
                    ev.event_id,
                    ev.name,
                    ev.location,
                    ev.registration_fee,
                    DATE_FORMAT(ev.start_time, '%Y-%m-%d %h:%i %p') start_time,
                    DATE_FORMAT(ev.end_time, '%Y-%m-%d %h:%i %p') end_time,
                    u.name host_name,
                    a.attendee_id,
                    a.booking_no,
                    a.payment_trnx_no,
                    a.payment_amount,
                    a.payment_account_no,
                    a.registration_time,
                    a.status
                FROM attendees a
                JOIN events ev
                    ON a.event_id = ev.event_id
                JOIN users u
                    ON u.user_id = ev.user_id
                WHERE a.user_id = ?
                ORDER BY registration_time DESC
                LIMIT 500";

        $params[] = Auth::user()->user_id;

        try {
            $ticketList = DB::query($sql, $params)->fetchAll();

            // dd($ticketList);

            view('pages.tickets.ticket-list', array('title' => "Ticket List", 'ticketList' => $ticketList));
        } catch (Exception $e) {
            Session::setPopup('popup_error', $e->getMessage());
            // redirect('/');
        }
    }


    /**
     * View and print ticket copy
     *
     * @param string $unique_id
     * @return void
     */
    public function viewTicket(string $unique_id)
    {
        $unique_id = htmlspecialchars(trim($unique_id), ENT_QUOTES, 'UTF-8');
        [$bookingNo, $attendeeId] = decodeData($unique_id);

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

            view('pages.tickets.ticket-copy', array('title' => "Event Ticket", 'ticketData' => $ticketData[0]));
        } catch (Exception $e) {
            Session::setPopup('popup_error', $e->getMessage());
            redirect('/');
        }
    }
}
