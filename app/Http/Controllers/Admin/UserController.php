<?php

namespace App\Http\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\User;

class UserController extends Controller
{
    /**
     * index page of Users
     *
     * @return void
     */
    public function index()
    {
        $usersModel = new User();
        $users = $usersModel->getAll();
        // dd($users);
        view('admin.pages.users.index', array('title' => "Users", 'users' => $users));
    }

    /**
     * Create user
     *
     * @return void
     */
    public function create()
    {
        view('admin.pages.users.create', array('title' => "Create User"));
    }

    /**
     * Store user
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
            'status' => ['integer'],
            'password' => ['string'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:127',
            'mobile' => 'string|max:15',
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

            return redirect('/admin/users/create');
        }

        $data = $request->validated();

        $usersModel = new User();

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['created_by'] = Auth::user()->user_id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $usersModel->insert($data);

        Session::flash('flash_success', "User created successfully.");

        return redirect('/admin/users');
    }


    /**
     * View user
     *
     * @param integer $user_id
     * @return void
     */
    public function show(int $user_id)
    {
        $user = (new User)->find($user_id);

        if (!$user) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/users');
        }

        view('admin.pages.users.show', array('title' => "Create User", 'user' => $user));
    }


    /**
     * Edit user
     *
     * @param integer $user_id
     * @return void
     */
    public function edit(int $user_id)
    {
        $user = (new User)->find($user_id);

        if (!$user || $user_id == 1) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/users');
        }

        view('admin.pages.users.edit', array('title' => "Create User", 'user' => $user));
    }


    /**
     * Update user
     *
     * @param Request $request
     * @param integer $user_id
     * @return void
     */
    public function update(Request $request, int $user_id)
    {
        $user = (new User)->find($user_id);

        if (!$user || $user_id == 1) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/users');
        }

        // Define sanitization rules
        $request->setSanitizationRules([
            'name' => ['string'],
            'mobile' => ['string'],
            'status' => ['integer'],
            'password' => ['string'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'mobile' => 'string|max:15',
            'password' => 'string|min:8',
        ];

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        if (!empty($errors)) {
            // set errors and old data into session
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $request->all();

            return redirect("/admin/users/$user_id/edit");
        }

        $data = $request->validated();

        if (strlen($data['password'] > 0)) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            unset($data['password']);
        }
        $data['updated_by'] = Auth::user()->user_id;
        $data['updated_at'] = date('Y-m-d H:i:s');

        (new User)->update($user_id, $data);

        Session::flash('flash_success', "User updated successfully!");

        return redirect('/admin/users');
    }



    /**
     * Change user status
     *
     * @param integer $user_id
     * @return void
     */
    public function delete(int $user_id)
    {
        $user = (new User)->find($user_id);

        if (!$user || $user_id == 1) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/users');
        }

        (new User)->delete($user_id);

        Session::flash('flash_success', "User deleted successfully!");

        return redirect('/admin/users');
    }


    /**
     * Change user status
     *
     * @param Request $request
     * @param integer $user_id
     * @return void
     */
    public function changeStatus(Request $request, int $user_id)
    {
        $user = (new User)->find($user_id);

        if (!$user || $user_id == 1) {
            Session::flash('flash_error', "Invalid action!");

            return redirect('/admin/users');
        }

        (new User)->update($user_id, ['status' => $request->input('status'), 'updated_by' => Auth::user()->user_id, 'updated_at' => date('Y-m-d H:i:s')]);

        Session::flash('flash_success', "Status changed successfully!");

        return redirect('/admin/users');
    }
}
