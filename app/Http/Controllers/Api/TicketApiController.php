<?php

namespace App\Http\Controllers\Api;

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
            'user_id' => 'required|integer|min:1',
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

            $attendee = new Attendee();

            [$bookingNo, $attendeeId] = decodeData($data['uniqueId']);
            $attendeeData = $attendee->where('booking_no', '=', $bookingNo)
                ->where('attendee_id', '=', $attendeeId)
                ->where('user_id', '=', $data['user_id'])
                ->where('status', '=', 1)
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
}
