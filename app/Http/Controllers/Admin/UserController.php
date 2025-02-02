<?php

namespace App\Http\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Models\File;
use App\Models\User;

class UserController extends Controller
{
    /**
     * index page of Users
     *
     * @return void
     */
    public function index(): void
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
    public function create(): void
    {
        view('admin.pages.users.create', array('title' => "Users | Create User"));
    }

    /**
     * Store user
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
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
            'mobile' => 'mobile|max:15',
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

            redirect('/admin/users/create');
        }

        $data = $request->validated();

        $usersModel = new User();

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['created_by'] = Auth::user()->user_id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $usersModel->insert($data);

        Session::flash('flash_success', "User created successfully.");

        redirect('/admin/users');
    }


    /**
     * View user
     *
     * @param integer $user_id
     * @return void
     */
    public function show(int $user_id): void
    {
        $user = (new User)->find($user_id);

        if (!$user) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/users');
        }

        $hostDetails = $user->getHostDetail();

        view('admin.pages.users.show', array('title' => "Users | View User", 'user' => $user, 'hostDetails' => $hostDetails));
    }


    /**
     * Edit user
     *
     * @param integer $user_id
     * @return void
     */
    public function edit(int $user_id): void
    {
        $user = (new User)->find($user_id);

        if (!$user || $user_id == 1) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/users');
        }

        view('admin.pages.users.edit', array('title' => "Users | Edit User", 'user' => $user));
    }


    /**
     * Update user
     *
     * @param Request $request
     * @param integer $user_id
     * @return void
     */
    public function update(Request $request, int $user_id): void
    {
        $user = (new User)->find($user_id);

        if (!$user || $user_id == 1) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/users');
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
            'mobile' => 'mobile|max:15',
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

            redirect("/admin/users/$user_id/edit");
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

        redirect('/admin/users');
    }



    /**
     * Change user status
     *
     * @param integer $user_id
     * @return void
     */
    public function delete(int $user_id): void
    {
        $user = (new User)->find($user_id);

        if (!$user || $user_id == 1) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/users');
        }

        (new User)->delete($user_id);

        Session::flash('flash_success', "User deleted successfully!");

        redirect('/admin/users');
    }


    /**
     * Change user status
     *
     * @param Request $request
     * @param integer $user_id
     * @return void
     */
    public function changeStatus(Request $request, int $user_id): void
    {
        $user = (new User)->find($user_id);

        $status = filter_var($request->input('status'), FILTER_SANITIZE_NUMBER_INT);

        if (!$user || $user_id == 1) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/admin/users');
        }

        $user->update(['status' => $status, 'updated_by' => Auth::user()->user_id, 'updated_at' => date('Y-m-d H:i:s')]);

        Session::flash('flash_success', "Status changed successfully!");

        redirect('/admin/users');
    }



    /**
     * Show prfile info
     *
     * @return void
     */
    public function userProfile(): void
    {
        $user = (new User)->find(Auth::user()->user_id);

        if (!$user) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/');
        }

        $hostDetails = $user->getHostDetail();

        view('admin.pages.user-profile.show', array('title' => "User Profile | Show", 'user' => $user, 'hostDetails' => $hostDetails));
    }


    /**
     * Change profile picture
     *
     * @param Request $request
     * @return void
     */
    public function changeProfilePicture(Request $request): void
    {
        $user = Auth::user();

        $errorFound = false;

        if (!$user) {
            Session::flash('flash_error', "Invalid action!");

            $errorFound = true;
        }

        if (empty($_FILES) || !isset($_FILES['profile_picture'])) {
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

        // dd($_FILES);
        if (($_FILES['profile_picture']['size'] >= $maxSize) || ($_FILES["profile_picture"]["size"] == 0)) {
            Session::flash('flash_error', 'File too large. File must be less than 1 megabyte.');
            $errorFound = true;
        }

        if (!in_array($_FILES['profile_picture']['type'], $acceptable) && (!empty($_FILES["profile_picture"]["type"]))) {
            Session::flash('flash_error', 'Invalid file type. Only JPG, GIF and PNG types are accepted.');
            $errorFound = true;
        }

        if ($errorFound) {
            redirect('/user-profile');
        }

        $user = (new User)->find(Auth::user()->user_id);

        $existingFile = $user->getProfilePicture();

        $filePath =  'users';

        $ext = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);

        $fileName = $user->user_id . '_' . time() . '.' . $ext;
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], UPLOAD_DIR . "$filePath/$fileName");

        // save it to files table
        $user->saveFile([
            'filepath' => $filePath,
            'filename' => $fileName,
            'fileinfo' => "profile_picture",
            'created_by' => Auth::user()->user_id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);


        // delete existing files
        if (!empty($existingFile)) {
            foreach ($existingFile as $file) {
                // set deleted in DB
                (new File())->update(array(
                    'deleted_by' => Auth::user()->user_id,
                    'deleted_at' => date('Y-m-d H:i:s')
                ), $file['file_id']);

                // remove file from storage
                $existingFilePath = "{$file['filepath']}/{$file['filename']}";
                if (file_exists(UPLOAD_DIR . $existingFilePath))
                    unlink(UPLOAD_DIR . $existingFilePath);
            }
        }

        Session::setPopup('popup_success', "Profile picture updated successfully!");
        redirect('/user-profile');
    }



    /**
     * Auth user prfile edit
     *
     * @return void
     */
    public function editProfile(): void
    {
        $user = (new User)->find(Auth::user()->user_id);

        if (!$user) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/user-profile');
        }

        $hostDetails = $user->getHostDetail();

        view('admin.pages.user-profile.edit', array('title' => "User Profile | Edit", 'user' => $user, 'hostDetails' => $hostDetails));
    }

    /**
     * Update user profile
     *
     * @param Request $request
     * @return void
     */
    public function updateProfile(Request $request): void
    {
        $user = (new User)->find(Auth::user()->user_id);

        if (!$user) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/user-profile');
        }

        // Define sanitization rules
        $request->setSanitizationRules([
            'name' => ['string'],
            'mobile' => ['string'],
            'description' => ['string'],
        ]);

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'mobile' => 'mobile|max:15',
            'description' => 'string',
        ];

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        if (!empty($errors)) {
            // set errors and old data into session
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $request->all();

            redirect("/edit-profile");
        }

        $data = $request->validated();

        // Ready HostDetail if the user is of type 2
        $hostDetailData = array();
        if ($user->type == 2) {
            $hostDetailData['description'] = $data['description'];
            $hostDetailData['location'] = $data['location'];

            // unset data
            unset($data['description']);
            unset($data['location']);
        }

        $data['updated_by'] = Auth::user()->user_id;
        $data['updated_at'] = date('Y-m-d H:i:s');

        $user->update($data);

        // save HostDetail data
        $user->saveHostDetail($hostDetailData);

        Session::flash('flash_success', "Profile updated successfully!");

        redirect('/user-profile');
    }


    /**
     * Change password
     *
     * @return void
     */
    public function changePassword(): void
    {
        $user = (new User)->find(Auth::user()->user_id);

        if (!$user) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/');
        }

        view('admin.pages.user-profile.change-password', array('title' => "User Profile | Change Password"));
    }

    /**
     * Store new password
     *
     * @param Request $request
     * @return void
     */
    public function saveChangedPassword(Request $request): void
    {
        $user = (new User)->find(Auth::user()->user_id);

        if (!$user) {
            Session::flash('flash_error', "Invalid action!");

            redirect('/user-profile');
        }

        // Define sanitization rules
        $request->setSanitizationRules([
            'password' => ['string'],
            'password_confirmation' => ['string'],
        ]);

        // Validation rules
        $rules = [
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8',
        ];

        // Validate data
        $request->validate($rules);

        $errors = $request->errors();

        $errorFound = false;

        if (!empty($errors)) {
            $errorFound = true;
        }

        if ($request->input('password') != $request->input('password_confirmation')) {
            $errors['password'][] = "Password not match!";
            $errors['password_confirmation'][] = "Password not match!";

            $errorFound = true;
        }

        if ($errorFound) {
            // set errors and old data into session
            $_SESSION['error'] = $errors;
            $_SESSION['old'] = $request->all();

            redirect("/change-password");
        }

        $data = $request->validated();

        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['updated_by'] = Auth::user()->user_id;
        $data['updated_at'] = date('Y-m-d H:i:s');

        $user->update($data);

        Session::flash('flash_success', "Password updated successfully!");

        redirect('/user-profile');
    }
}
