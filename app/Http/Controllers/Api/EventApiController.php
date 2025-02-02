<?php

namespace App\Http\Controllers\Api;

use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Models\Attendee;
use App\Models\Event;
use Exception;

class EventApiController extends Controller
{

    /**
     * Get schedule dates API
     *
     * @param Request $request
     * @return void
     */
    public function getEventSchedules(Request $request): void
    {
        $request->setSanitizationRules([
            'limit' => ['integer']
        ]);

        $data = $request->all();
        $limit = $data['limit'] ?? 500; // default limit is 500

        $params = array();
        $sql = "SELECT 
                    DISTINCT(DATE_FORMAT(start_time, '%Y-%m-%d')) date
                FROM events
                WHERE start_time >= ?
                    AND status = ?
                ORDER BY date ASC";

        $params[] = date('Y-m-d H:i:s');
        $params[] = 1;

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        try {
            $schedules = DB::query($sql, $params)->fetchAll();

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => $schedules,
            ), 200);
        } catch (Exception $e) {
            Response::json(array(
                'status' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ), 400);
        }
    }


    /**
     * Get events API
     *
     * @param Request $request
     * @return void
     */
    public function getEvents(Request $request): void
    {
        $request->setSanitizationRules([
            'date' => ['string'],
            'host_id' => ['integer'],
            'limit' => ['integer'],
        ]);

        $data = $request->all();

        $date = $data['date'] ?? '';
        $host_id = $data['host_id'] ?? '';
        $limit = $data['limit'] ?? 500; // default limit is 500

        $params = array();
        $sql = "SELECT
                    ev.event_id,
                    ev.name,
                    ev.location,
                    DATE_FORMAT(ev.start_time, '%Y-%m-%d %h:%i %p') start_time,
                    DATE_FORMAT(ev.end_time, '%Y-%m-%d %h:%i %p') end_time,
                    CONCAT('/uploads/', f.filepath, '/', f.filename) banner_image
                FROM events ev
                LEFT JOIN files f 
                    ON f.table_id=ev.event_id
                    AND f.operation_name = 'events'  
                    AND f.fileinfo = 'banner_image'
                    AND f.deleted_by IS NULL
                WHERE ev.status = ?
                    AND (ev.current_capacity > 0 OR ev.max_capacity = 0)";
        $params[] = 1;

        if (!empty($date)) {
            $sql .= " AND ev.start_time BETWEEN ? AND ?";
            $params[] = date('Y-m-d 00:00:00', strtotime($date));
            $params[] = date('Y-m-d 23:59:59', strtotime($date));
        }

        if (!empty($host_id)) {
            $sql .= " AND ev.user_id  = ?";
            $params[] = $host_id;
        }

        $sql .= " ORDER BY ev.start_time ASC, f.created_at DESC";

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        // echo $sql, '<br>';
        // print_r($params);
        // die;

        try {
            $events = DB::query($sql, $params)->fetchAll();

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => $events,
            ), 200);
        } catch (Exception $e) {
            Response::json(array(
                'status' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ), 400);
        }
    }

    /**
     * Get events details API
     *
     * @param Request $request
     * @return void
     */
    public function getEventDetails(Request $request): void
    {
        $request->setSanitizationRules([
            'event_id' => ['integer']
        ]);

        $data = $request->all();

        $event_id = $data['event_id'] ?? '';

        $params = array();
        $sql = "SELECT
                    ev.event_id,
                    ev.name,
                    ev.location,
                    ev.google_map_location,
                    ev.description,
                    ev.max_capacity,
                    ev.registration_fee,
                    ev.current_capacity,
                    ev.user_id host_id,
                    DATE_FORMAT(ev.start_time, '%Y-%m-%d %h:%i %p') start_time,
                    DATE_FORMAT(ev.end_time, '%Y-%m-%d %h:%i %p') end_time,
                    CONCAT('/uploads/', f.filepath, '/', f.filename) banner_image,
                    CONCAT('/uploads/', hf.filepath, '/', hf.filename) host_profile_image,
                    u.name host_name,
                    u.email host_email,
                    u.mobile host_mobile,
                    d.description host_details,
                    d.location host_address
                FROM events ev
                JOIN users u ON u.user_id = ev.user_id
                LEFT JOIN files f 
                    ON f.table_id = ev.event_id
                    AND f.operation_name = 'events'  
                    AND f.fileinfo = 'banner_image'
                    AND f.deleted_by IS NULL
                LEFT JOIN host_details d
                    ON d.user_id = ev.user_id
                LEFT JOIN files hf 
                    ON hf.table_id = ev.user_id
                    AND hf.operation_name = 'users'  
                    AND hf.fileinfo = 'profile_picture'
                    AND hf.deleted_by IS NULL
                WHERE ev.event_id = ?
                ORDER BY f.created_at DESC, hf.created_at DESC
                LIMIT 1";

        $params[] = $event_id;

        // echo $sql, '<br>';
        // print_r($params);
        // die;

        try {
            $events = DB::query($sql, $params)->fetchAll();

            if (empty($events)) {
                throw new Exception("Event not found!");
            }

            $event = $events[0];
            $event['google_map_location'] = html_entity_decode($event['google_map_location'] ?? '');
            $event['description'] = html_entity_decode($event['description'] ?? '');
            $event['host_details'] = html_entity_decode($event['host_details'] ?? '');

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => $event,
            ), 200);
        } catch (Exception $e) {
            Response::json(array(
                'status' => false,
                'message' => $e->getMessage(),
                'data' => array(),
            ), 400);
        }
    }


    /**
     * Event registration API
     *
     * @param Request $request
     * @return void
     */
    public function eventRegistration(Request $request): void
    {
        $request->setSanitizationRules([
            'event_id' => ['integer'],
            'user_id' => ['integer'],
            'name' => ['string'],
            'email' => ['email'],
            'mobile' => ['string'],
            'payment_trnx_no' => ['string'],
            'payment_amount' => ['integer'],
            'payment_account_no' => ['string']
        ]);

        // Validation rules
        $rules = [
            'event_id' => 'required|integer|min:1',
            'name' => 'required|string|max:128',
            'email' => 'required|email|max:255',
            'mobile' => 'required|mobile|max:15',
            'payment_trnx_no' => 'string|max:128',
            'payment_amount' => 'integer|min:0',
            'payment_account_no' => 'string|max:128',
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

            $event_id = filter_var($request->input('event_id'), FILTER_SANITIZE_NUMBER_INT);

            $event = (new Event)->find($event_id);

            if (!$event || $event->status != 1) {
                throw new Exception('Invalid action! Event data not found!');
            }

            if ($event->current_capacity == 0 && $event->max_capacity != 0) {
                throw new Exception('No seat available!');
            }

            if ($event->start_time < date('Y-m-d H:i:s')) {
                throw new Exception('Registration time expired!');
            }

            $paymentAmount = filter_var($request->input('payment_amount'), FILTER_SANITIZE_NUMBER_INT);
            $paymentTrnxNo = htmlspecialchars(trim($request->input('payment_trnx_no')), ENT_QUOTES, 'UTF-8');
            $paymentAccountNo = htmlspecialchars(trim($request->input('payment_account_no')), ENT_QUOTES, 'UTF-8');

            if ($event->registration_fee != 0) {
                if ($paymentAmount != $event->registration_fee) {
                    $errors['payment_amount'][] = "Invalid payment amount!";
                    $errorFound = true;
                }
                if ($paymentTrnxNo == "") {
                    $errors['payment_trnx_no'][] = "Payment transaction number is required!";
                    $errorFound = true;
                }
                if ($paymentAccountNo == "") {
                    $errors['payment_account_no'][] = "Payment account number is required!";
                    $errorFound = true;
                }
            }

            if ($errorFound) {
                throw new Exception('Validation error! Please try again!');
            }

            $data = $request->validated();

            $attendee = new Attendee();

            // check unique registration info
            $dataExists = DB::query(
                "SELECT * FROM attendees WHERE event_id = ? AND (email = ? OR mobile = ?)",
                array($event_id, $data['email'], $data['mobile'])
            )->fetchAll();

            if ($dataExists) {
                throw new Exception('Registration failed! Duplicate registration!');
            }

            // checking valid transaction
            if ($event->registration_fee != 0) {
                $dataExists = $attendee->where('payment_trnx_no', '=', $data['payment_trnx_no'])->where('payment_account_no', '=', $data['payment_account_no'])->get();

                if ($dataExists) {
                    throw new Exception('Invalid payment!');
                }
            }

            $bookingNumber = $attendee->generateBookingNumber($event_id);


            if ($data['user_id'] == '') unset($data['user_id']);
            if ($data['payment_amount'] == '') unset($data['payment_amount']);
            if ($data['payment_trnx_no'] == '') unset($data['payment_trnx_no']);
            if ($data['payment_account_no'] == '') unset($data['payment_account_no']);

            $data['booking_no'] = $bookingNumber;

            $attendee_id = $attendee->insert($data);

            $responseData = array(
                'booking_no' => $bookingNumber
            );
            if ($attendee_id) {
                $uniqueId = encodeData([$bookingNumber, $attendee_id]);
                $ticketPrintUrl = route("/tickets/$uniqueId/view-ticket");
                // $responseData['attendee_id'] = $attendee_id;
                $responseData['redirect_url'] = $ticketPrintUrl;

                // update seat capacity
                if ($event->max_capacity != 0) {
                    $event->update(['current_capacity' => $event->current_capacity - 1]);
                }
            } else {
                throw new Exception('Something went wrong! Please try again!');
            }

            Response::json(array(
                'status' => true,
                'message' => "Success",
                'data' => $responseData,
            ), 200);
        } catch (Exception $e) {
            setUnsetUniqueId();

            Response::error($e->getMessage(), 422, $errors);
        }
    }
}
