<?php

namespace App\Http\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\Event;
use App\Models\File;

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
        $events = $eventsModel->getAll();

        dd($events);

        view('admin.pages.events.index', array('title' => "Events", 'events' => $events));
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
            'email' => ['email'],
            'mobile' => ['string'],
            'type' => ['integer'],
            'status' => ['integer'],
            'password' => ['string'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:127',
            'mobile' => 'string|max:15',
            'type' => 'required|integer',
            'password' => 'required|string|min:8',
        ];

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        $errorFound = false;

        if (!empty($errors)) {
            $errorFound = true;
        }

        $email = $request->input('email');
        if ($email != "") {
            $usersModel = new User();
            $user = $usersModel->where('email', '=', $email)->get();

            if (count($user) > 0) {
                $errorFound = true;
                $errors['email'][] = "Email must be unique!";
            }
        }

        if ($errorFound) {
            // set errors and old data into session
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $request->all();

            return redirect('/admin/events/create');
        }

        $data = $request->validated();

        $usersModel = new User();

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['created_by'] = Auth::user()->user_id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $usersModel->insert($data);

        Session::flash('flash_success', "User created successfully.");

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

        $hostDetails = $user->getHostDetail();

        view('admin.pages.users.show', array('title' => "View User", 'user' => $user, 'hostDetails' => $hostDetails));
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

        view('admin.pages.users.edit', array('title' => "Edit User", 'user' => $user));
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
