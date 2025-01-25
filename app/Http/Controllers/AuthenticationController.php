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
}
