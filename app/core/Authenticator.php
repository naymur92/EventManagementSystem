<?php

namespace App\Core;

class Authenticator
{
    /**
     * Attempt user login
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function attempt(string $email, string $password): bool
    {
        $user = App::resolve('App\Core\DB')
            ->query('select * from users where email = :email', [
                'email' => $email
            ])->fetchAll();

        if ($user && isset($user[0]['password'])) {
            if (password_verify($password, $user[0]['password']) && $user[0]['status'] == 1) {
                $this->login($user[0]);

                return true;
            }
        }

        return false;
    }

    /**
     * Add user data to session
     *
     * @param array $user
     * @return void
     */
    public function login(array $user): void
    {
        if (isset($user['password'])) {
            unset($user['password']);
        }
        if (isset($user['remember_token'])) {
            unset($user['remember_token']);
        }
        if (isset($user['updated_at'])) {
            unset($user['updated_at']);
        }

        $_SESSION['user'] = $user;

        session_regenerate_id(true);
    }

    /**
     * Destroy session data on logout
     *
     * @return void
     */
    public function logout(): void
    {
        Session::destroy();
    }
}
