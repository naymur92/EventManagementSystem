<?php

namespace App\Http\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Event;
use App\Models\File;
use App\Models\User;

class EventController extends Controller
{
    /**
     * index page of Events
     *
     * @return void
     */
    public function index()
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
    public function create()
    {
        view('admin.pages.events.create', array('title' => "Events | Create Event"));
    }

    /**
     * Store Event
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        // Define sanitization rules
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

            return redirect('/admin/events/create');
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
            return redirect('/admin/events/create');
        }


        return redirect('/admin/events');
    }


    /**
     * View Event
     *
     * @param integer $event_id
     * @return void
     */
    public function show(int $event_id)
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->user_id != Auth::user()->user_id) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/events');
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
    public function edit(int $event_id)
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->user_id != Auth::user()->user_id) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/events');
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
    public function update(Request $request, int $event_id)
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->user_id != Auth::user()->user_id) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/events');
        }

        // Define sanitization rules
        $request->setSanitizationRules([
            'name' => ['string'],
            'mobile' => ['string'],
            'type' => ['integer'],
            'status' => ['integer'],
            'password' => ['string'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'mobile' => 'string|max:15',
            'type' => 'required|integer',
            'password' => 'string|min:8',
        ];

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        if (!empty($errors)) {
            // set errors and old data into session
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $request->all();

            return redirect("/admin/events/$user_id/edit");
        }

        $data = $request->validated();

        if (strlen($data['password'] > 0)) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        $data['updated_by'] = Auth::user()->user_id;
        $data['updated_at'] = date('Y-m-d H:i:s');

        $user->update($data);

        Session::flash('flash_success', "User updated successfully!");

        return redirect('/admin/events');
    }



    /**
     * Change user status
     *
     * @param integer $event_id
     * @return void
     */
    public function delete(int $event_id)
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->user_id != Auth::user()->user_id) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/events');
        }

        $event->delete();

        Session::flash('flash_success', "Event deleted successfully!");

        return redirect('/admin/events');
    }


    /**
     * Change user status
     *
     * @param Request $request
     * @param integer $event_id
     * @return void
     */
    public function changeStatus(Request $request, int $event_id)
    {
        $event = (new Event)->find($event_id);

        if (!$event || $event->user_id != Auth::user()->user_id) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/events');
        }

        $event->update(['status' => $request->input('status'), 'updated_at' => date('Y-m-d H:i:s')]);

        Session::flash('flash_success', "Status changed successfully!");

        return redirect('/admin/events');
    }
}
