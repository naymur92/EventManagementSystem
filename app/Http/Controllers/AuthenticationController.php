<?php

namespace App\Http\Controllers;

use App\Core\Authenticator;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\User;

class AuthenticationController extends Controller
{
    /**
     * Login form
     *
     * @return void
     */
    public function index()
    {
        view('admin.pages.auth.login', array('title' => "Login"));
    }

    /**
     * Attempt login
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $request->setSanitizationRules([
            'email' => ['email'],
            'password' => ['string']
        ]);

        $rules = [
            'email' => 'required|email|max:127',
            'password' => 'required|string|min:6',
        ];

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        $errorFound = false;

        if (!empty($errors)) {
            $errorFound = true;
        }

        // attempt login
        if (!$errorFound) {
            $data = $request->validated();

            $signedIn = (new Authenticator)->attempt(
                $data['email'],
                $data['password']
            );

            if (!$signedIn) {
                $errorFound = true;
                $errors['email'][] = "Credentials not matched!";
            }
        }

        if ($errorFound) {
            // set errors and old data into session
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $request->all();

            return redirect('/login');
        }

        Session::flash('flash_success', "Login success.");

        if ($_SESSION['user']['type'] == 3) {
            redirect('/');
        }
        return redirect('/admin');
    }

    /**
     * Attempt logout
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        (new Authenticator)->logout();

        return redirect('/');
    }


    /**
     * Register a user
     *
     * @return void
     */
    public function registerPage()
    {
        view('admin.pages.auth.register', array('title' => "Register"));
    }

    /**
     * Store registered user
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request)
    {
        // Define sanitization rules
        $request->setSanitizationRules([
            'name' => ['string'],
            'email' => ['email'],
            'mobile' => ['string'],
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

            return redirect('/register');
        }

        $data = $request->validated();

        $usersModel = new User();

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        if (isset($data['host']) && $data['host'] == 'on') {
            $data['type'] = 2;
            $data['status'] = 1;

            unset($data['host']);
        } else {
            $data['type'] = 3;
            $data['status'] = 1;
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $usersModel->insert($data);

        Session::setPopup('popup_success', "Registration successfull. Please contact with admin to active your account!");

        return redirect('/login');
    }
}
