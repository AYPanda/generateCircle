<?php

namespace BL\Repository;

use core\BaseRepository;

class AuthorizeRepository extends BaseRepository
{
    public function login($login, $password)
    {
        $sql = "select id from users where login = :login and password = :password";
        $params = ["login" => $login, "password" => $this->hash($password)];
        $user = $this->db->queryRow($sql, $params);
        if (is_numeric($user["id"])) {
            $_SESSION['id'] = $user["id"];
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        return "/authorize";
    }

    private function hash($password)
    {
        $salt = "frsqws53";
        return md5($password . $salt);
    }
}