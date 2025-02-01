<?php

namespace App\Http\Controllers\Api;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\Attendee;
use App\Models\Event;
use Exception;

class TicketApiController extends Controller
{
    /**
     * Cancel Ticket API
     *
     * @param Request $request
     * @return void
     */
    public function cancelTicket(Request $request): void
    {
        $request->setSanitizationRules([
            'uniqueId' => ['string'],
            'user_id' => ['integer'],
            'cancel_reason' => ['string']
        ]);

        // Validation rules
        $rules = [
            'uniqueId' => 'required|string',
            'user_id' => 'integer|min:1',
            'cancel_reason' => 'required|string|max:128'
        ];

        if (!setUnsetUniqueId('get')) {
            Response::error("Unauthorized operation! Please try again!");
        }

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        $errorFound = false;

        if (!empty($errors)) {
            $errorFound = true;
        }

        try {
            if ($errorFound) {
                throw new Exception('Validation error! Please try again!');
            }

            $data = $request->validated();

            if ($data['user_id'] == "" && !Auth::user()) {
                throw new Exception('Invalid request!');
            }

            $attendee = new Attendee();

            [$bookingNo, $attendeeId] = decodeData($data['uniqueId']);
            $attendee->where('booking_no', '=', $bookingNo)
                ->where('attendee_id', '=', $attendeeId);
            if ($data['user_id'] != '')
                $attendee->where('user_id', '=', $data['user_id']);
            $attendeeData = $attendee->where('status', '=', 1)
                ->get();

            // validate data existing
            if (empty($attendeeData)) {
                throw new Exception('Invalid request!');
            }

            $event = (new Event())->find($attendeeData[0]['event_id']);

            // validate cancel time
            if (strtotime("-6 hours", strtotime($event->start_time)) < time()) {
                throw new Exception('Invalid request! Cancel time expired!');
            }

            // database update
            $attendee->update(['status' => 0, 'cancel_reason' => $data['cancel_reason']], $attendeeData[0]['attendee_id']);
            if ($event->max_capacity != 0) {
                $event->update(['current_capacity' => $event->current_capacity + 1]);
            }

            Session::flash('flash_success', "Ticket cancelled succesfully.");

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => array(),
            ), 200);
        } catch (Exception $e) {
            setUnsetUniqueId();

            Response::error($e->getMessage(), 422, $errors);
        }
    }


    /**
     * Find Ticket API
     *
     * @param Request $request
     * @return void
     */
    public function findTicket(Request $request): void
    {
        $request->setSanitizationRules([
            'booking_no' => ['string'],
            'mobile' => ['string'],
            'email' => ['string']
        ]);

        // Validation rules
        $rules = [
            'booking_no' => 'required|string"|max:128',
            'mobile' => 'string|max:15',
            'email' => 'email|max:128'
        ];

        if (!setUnsetUniqueId('get')) {
            Response::error("Unauthorized operation! Please try again!");
        }

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        $errorFound = false;

        if (!empty($errors)) {
            $errorFound = true;
        }

        try {
            if ($errorFound) {
                throw new Exception('Validation error! Please try again!');
            }

            $data = $request->validated();

            // validation          
            if ($data['mobile'] == '' && $data['email'] == '') {
                $errors['mobile'][] = "Enter mobile no!";
                $errors['email'][] = "Enter email!";

                $errorFound = true;
            }

            if ($errorFound) {
                throw new Exception('Validation error! Please try again!');
            }


            // check unique registration info
            $params = array();
            $sql = "SELECT * FROM attendees WHERE booking_no = ?";
            $params[] = $data['booking_no'];
            if ($data['mobile'] == '' || $data['email'] == '') {
                if ($data['mobile'] != '') {
                    $sql .= " AND mobile = ?";
                    $params[] = $data['mobile'];
                } else {
                    $sql .= " AND email = ?";
                    $params[] = $data['email'];
                }
            } else {
                $sql .= " AND (email = ? OR mobile = ?)";
                $params[] = $data['email'];
                $params[] = $data['mobile'];
            }
            // $sql .= " AND status = ?";
            // $params[] = 1;

            $ticketData = DB::query($sql, $params)->fetchAll();

            if (!$ticketData) {
                throw new Exception('Ticket data not found!');
            }

            if ($ticketData[0]['status'] != 1) {
                throw new Exception('Ticket was cancelled!');
            }

            // Session::flash('flash_success', "Ticket found!");

            $responseData = array();

            $uniqueId = encodeData([$ticketData[0]['booking_no'], $ticketData[0]['attendee_id']]);
            $ticketPrintUrl = route("/tickets/$uniqueId/view-ticket");
            $responseData['redirect_url'] = $ticketPrintUrl;

            Response::json(array(
                'status' => true,
                'message' => "Ticket found!",
                'data' => $responseData,
            ), 200);
        } catch (Exception $e) {
            setUnsetUniqueId();

            Response::error($e->getMessage(), 422, $errors);
        }
    }
}
