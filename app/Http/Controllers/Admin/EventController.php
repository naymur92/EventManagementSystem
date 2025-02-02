<?php

namespace App\Http\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\DB;
use App\Core\Request;
use App\Core\Session;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\File;
use App\Models\User;
use App\Utils\CSVExporter;
use Exception;

class EventController extends Controller
{
    /**
     * index page of Events
     *
     * @return void
     */
    public function index(): void
    {
        $eventsModel = new Event();

        if (Auth::user()->type == 2)
            $eventsModel->where('user_id', '=', Auth::user()->user_id);

        $events = $eventsModel->orderBy('created_at', 'DESC')->get();

        $userModel = new User();
        $hostUsers = $userModel->where('type', '=', 2)
            ->where('status', '=', 1)
            ->select(['user_id', 'name'])
            ->orderBy('name', "ASC")
            ->get();

        $hostUsers = array_combine(
            array_column($hostUsers, 'user_id'),
            array_column($hostUsers, 'name')
        );

        // dd($hostUsers);

        view('admin.pages.events.index', array('title' => "Events", 'events' => $events, 'hostUsers' => $hostUsers));
    }

    /**
     * Event create page
     *
     * @return void
     */
    public function create(): void
    {
        view('admin.pages.events.create', array('title' => "Events | Create Event"));
    }

    /**
     * Store Event
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $request->setSanitizationRules([
            'name' => ['string'],
            'location' => ['string'],
            'google_map_location' => ['string'],
            'description' => ['string'],
            'max_capacity' => ['integer'],
            'registration_fee' => ['integer'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'google_map_location' => 'string|max:1024',
            'start_time' => 'required',
            'max_capacity' => 'integer|min:0',
            'registration_fee' => 'integer|min:0',
        ];

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        $errorFound = false;

        if (!empty($errors)) {
            $errorFound = true;
        }

        // image validation
        if (empty($_FILES) || !isset($_FILES['banner_image'])) {
            Session::setPopup('popup_error', "Please select an image first!");

            $errorFound = true;
        }

        $maxSize    = 1024 * 1024;  // 1 MB
        $acceptable = array(
            'image/jpeg',
            'image/jpg',
            'image/gif',
            'image/png'
        );

        if (($_FILES['banner_image']['size'] >= $maxSize) || ($_FILES["banner_image"]["size"] == 0)) {
            Session::flash('flash_error', 'File too large. File must be less than 1 megabyte.');
            $errorFound = true;
        }

        if (!in_array($_FILES['banner_image']['type'], $acceptable) && (!empty($_FILES["banner_image"]["type"]))) {
            Session::flash('flash_error', 'Invalid file type. Only JPG, GIF and PNG types are accepted.');
            $errorFound = true;
        }


        if ($errorFound) {
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $request->all();

            redirect('/admin/events/create');
        }

        $data = $request->validated();

        $data['user_id'] = Auth::user()->user_id;

        // format datetime
        if ($data['start_time'] != '')
            $data['start_time'] = date('Y-m-d H:i:s', strtotime($data['start_time']));
        if ($data['end_time'] != '')
            $data['end_time'] = date('Y-m-d H:i:s', strtotime($data['end_time']));

        // if data is empty then handle them with default value by not passing
        if ($data['max_capacity'] == '') unset($data['max_capacity']);
        else {
            $data['current_capacity'] = $data['max_capacity'];
        }
        if ($data['registration_fee'] == '') unset($data['registration_fee']);
        if ($data['start_time'] == '') unset($data['start_time']);
        if ($data['end_time'] == '') unset($data['end_time']);

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $event = new Event();
        $event_id = $event->insert($data);

        // start file upload
        if ($event_id) {
            $filePath = 'events';

            $ext = pathinfo($_FILES["banner_image"]["name"], PATHINFO_EXTENSION);

            $fileName = $event->event_id . '_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['banner_image']['tmp_name'], UPLOAD_DIR . "$filePath/$fileName");

            $event->saveFile([
                'filepath' => $filePath,
                'filename' => $fileName,
                'fileinfo' => "banner_image",
                'created_by' => Auth::user()->user_id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            Session::flash('flash_success', "Event created successfully. View it carefully and publish.");
        } else {
            Session::flash('flash_error', "Something went wrong. Please try again!");
            redirect('/admin/events/create');
        }


        redirect('/admin/events');
    }


    /**
     * View Event
     *
     * @param integer $event_id
     * @return void
     */
    public function show(int $event_id): void
    {
        $event = (new Event)->find($event_id);

        if (!$event || ($event->user_id != Auth::user()->user_id && Auth::user()->type != 1)) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/events');
        }

        $hostDetails = $event->getHostDetail();
        // dd($hostDetails);

        view('admin.pages.events.show', array('title' => "Events | View Event", 'event' => $event, 'hostDetails' => $hostDetails));
    }


    /**
     * Edit user
     *
     * @param integer $event_id
     * @return void
     */
    public function edit(int $event_id): void
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->user_id != Auth::user()->user_id) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/events');
        }

        view('admin.pages.events.edit', array('title' => "Events | Edit Event", 'event' => $event));
    }


    /**
     * Update user
     *
     * @param Request $request
     * @param integer $event_id
     * @return void
     */
    public function update(Request $request, int $event_id): void
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->user_id != Auth::user()->user_id) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/events');
        }

        $request->setSanitizationRules([
            'name' => ['string'],
            'location' => ['string'],
            'google_map_location' => ['string'],
            'description' => ['string'],
            'max_capacity' => ['integer'],
            'registration_fee' => ['integer'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'google_map_location' => 'string|max:1024',
            'start_time' => 'required',
            'max_capacity' => 'integer|min:0',
            'registration_fee' => 'integer|min:0',
        ];

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        $errorFound = false;

        if (!empty($errors)) {
            $errorFound = true;
        }


        // image validation
        $updateBanner = false;
        if (isset($_FILES["banner_image"]["name"]) && strlen($_FILES["banner_image"]["name"]) > 0) {
            $maxSize    = 1024 * 1024;  // 1 MB
            $acceptable = array(
                'image/jpeg',
                'image/jpg',
                'image/gif',
                'image/png'
            );

            if (($_FILES['banner_image']['size'] >= $maxSize) || ($_FILES["banner_image"]["size"] == 0)) {
                Session::flash('flash_error', 'File too large. File must be less than 1 megabyte.');
                $errorFound = true;
            }

            if (!in_array($_FILES['banner_image']['type'], $acceptable) && (!empty($_FILES["banner_image"]["type"]))) {
                Session::flash('flash_error', 'Invalid file type. Only JPG, GIF and PNG types are accepted.');
                $errorFound = true;
            }

            $updateBanner = true;
        }

        $totalRegistered = $event->max_capacity - $event->current_capacity;

        // validate max capacity available capacity
        if ($request->input('max_capacity') < $event->max_capacity && $totalRegistered > (int) $request->input('max_capacity')) {
            $errorFound = true;
            $errors['max_capacity'][] = "Invalid seat capacity to reduce!";
        }

        if ($errorFound) {
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $request->all();

            redirect("/admin/events/{$event->event_id}/edit");
        }

        $data = $request->validated();

        // format datetime
        if ($data['start_time'] != '')
            $data['start_time'] = date('Y-m-d H:i:s', strtotime($data['start_time']));
        if ($data['end_time'] != '')
            $data['end_time'] = date('Y-m-d H:i:s', strtotime($data['end_time']));

        // recalculate current capacity when changed max capacity
        if ($data['max_capacity'] < $event->max_capacity) {
            $data['current_capacity'] = $data['max_capacity'] - $totalRegistered;
        }

        if ($data['registration_fee'] == '') unset($data['registration_fee']);
        if ($data['start_time'] == '') unset($data['start_time']);
        if ($data['end_time'] == '') unset($data['end_time']);

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $event->update($data);

        // banner update
        if ($updateBanner) {
            $existingFile = $event->getBanner();

            $filePath =  'events';

            $ext = pathinfo($_FILES["banner_image"]["name"], PATHINFO_EXTENSION);
            $fileName = $event->event_id . '_' . time() . '.' . $ext;
            move_uploaded_file($_FILES['banner_image']['tmp_name'], UPLOAD_DIR . "$filePath/$fileName");

            $event->saveFile([
                'filepath' => $filePath,
                'filename' => $fileName,
                'fileinfo' => "banner_image",
                'created_by' => Auth::user()->user_id,
                'created_at' => date('Y-m-d H:i:s'),
            ]);


            // delete existing files
            if (!empty($existingFile)) {
                // set deleted in DB
                (new File())->update(array(
                    'deleted_by' => Auth::user()->user_id,
                    'deleted_at' => date('Y-m-d H:i:s')
                ), $existingFile['file_id']);

                // remove file from storage
                $existingFilePath = "{$existingFile['filepath']}/{$existingFile['filename']}";
                if (file_exists(UPLOAD_DIR . $existingFilePath))
                    unlink(UPLOAD_DIR . $existingFilePath);
            }
        }

        Session::flash('flash_success', "Event updated successfully!");

        redirect('/admin/events');
    }



    /**
     * Change user status
     *
     * @param integer $event_id
     * @return void
     */
    public function delete(int $event_id): void
    {
        $event = (new Event)->find($event_id);

        if (!$event || ($event->user_id != Auth::user()->user_id && Auth::user()->type != 1)) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/events');
        }

        $existingFile = $event->getBanner();

        $event->delete();

        // delete existing files
        if (!empty($existingFile)) {
            // set deleted in DB
            (new File())->update(array(
                'deleted_by' => Auth::user()->user_id,
                'deleted_at' => date('Y-m-d H:i:s')
            ), $existingFile['file_id']);

            // remove file from storage
            $existingFilePath = "{$existingFile['filepath']}/{$existingFile['filename']}";
            if (file_exists(UPLOAD_DIR . $existingFilePath))
                unlink(UPLOAD_DIR . $existingFilePath);
        }

        Session::flash('flash_success', "Event deleted successfully!");

        redirect('/admin/events');
    }


    /**
     * Change user status
     *
     * @param Request $request
     * @param integer $event_id
     * @return void
     */
    public function changeStatus(Request $request, int $event_id): void
    {
        $event = (new Event)->find($event_id);

        $status = filter_var($request->input('status'), FILTER_SANITIZE_NUMBER_INT);

        $errorFound = false;
        if (!$event || ($event->user_id != Auth::user()->user_id && Auth::user()->type != 1)) {
            $errorFound = true;
        }

        // verify if have any registration
        if ($event->max_capacity != $event->current_capacity && Auth::user()->type != 1) {
            $errorFound = true;
        }

        if ($errorFound) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/events');
        }

        $event->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);

        if ($status == 0) {
            Session::flash('flash_warning', "Event unpublished!");
        } elseif ($status == 1) {
            Session::flash('flash_success', "Event published!");
        } else {
            Session::flash('flash_warning', "Event blocked!");
        }


        redirect('/admin/events');
    }


    /**
     * View Attendee List
     *
     * @param integer $event_id
     * @return void
     */
    public function attendeeList(int $event_id)
    {
        $event = (new Event)->find($event_id);

        if (!$event) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/events');
        }

        setUnsetUniqueId();

        $attendees = (new Attendee())->where('event_id', '=', $event_id)->get();

        view('admin.pages.events.attendee-list', array('title' => "Events", 'event' => $event, 'attendees' => $attendees));
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

        try {
            $ticketData = Attendee::generateTicketData($unique_id);

            if (empty($ticketData)) {
                throw new Exception("Invalid access! Ticket not found!");
            }

            view('admin.pages.events.ticket-copy', array('title' => "View Ticket", 'ticketData' => $ticketData[0]));
        } catch (Exception $e) {
            Session::setPopup('popup_error', $e->getMessage());
            redirect('/');
        }
    }


    public function downloadAttendeeList($event_id)
    {
        $event = (new Event)->find($event_id);

        if (!$event) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/events');
        }

        $sql = "SELECT
                    u.name host_name,
                    ev.name event_name,
                    ev.start_time,
                    ev.end_time,
                    CASE 
                        WHEN ev.status = 0 THEN 'Pending'
                        WHEN ev.status = 1 THEN 'Published'
                        WHEN ev.status = 2 THEN 'Blocked'
                        ELSE 'Unknown' 
                    END AS event_status,
                    a.booking_no,
                    a.name attendee_name,
                    a.email attendee_email,
                    a.mobile attendee_mobile,
                    ev.registration_fee,
                    a.payment_amount,
                    a.payment_trnx_no,
                    a.payment_account_no,
                    a.registration_time,
                    IF(a.status = 0, 'Cancelled', 'Confirmed') status
                FROM attendees a
                JOIN events ev
                    ON a.event_id = ev.event_id
                JOIN users u
                    ON u.user_id = ev.user_id
                WHERE a.event_id = ?";

        $params[] = $event_id;

        $attendees = DB::query($sql, $params)->fetchAll();

        $headers = ["Host Name", "Event Name", "Start Time", "End Time", "Event Status", "Booking Number", "Attendee Name", "Attendee Email", "Attendee Mobile", "Registration Fee", "Payment Amount", "Payment Trnx No", "Payment Account No", "Registration Time", "Status"];

        $fileName = 'attendees_' . $event_id . '.csv';

        $csvExporter = new CSVExporter($attendees, $fileName);
        $csvExporter->setHeaders($headers);

        $csvExporter->download();
    }
}
