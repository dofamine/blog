<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 11.04.2018
 * Time: 13:30
 */

class ControllerAuth extends Controller
{
    private static function is_empty()
    {
        foreach (func_get_args() as $arg) {
            if (empty($arg)) return true;
        }
        return false;
    }

    public function action_register()
    {
        $login = trim(@$_POST["login"]);
        $pass = trim(@$_POST["pass"]);
        $pass_c = trim(@$_POST["conf"]);
        $mail = trim(@$_POST["mail"]);
        $phone = trim(@$_POST["phone"]);
        try {
            if (self::is_empty($login, $pass, $pass_c, $mail, $phone))
                throw new Exception("Enter all fields");
            if ($pass_c !== $pass) throw new Exception("Passwords are not similar");
            try {
                ModuleAuth::instance()->register($login, $pass, ["email" => $mail, "phone" => $phone]);
                $this->redirect(URLROOT);
            } catch (Exception $e) {throw new Exception($e->getMessage());}
        } catch (Exception $e) {
            $_SESSION["validate_error"] = $e->getMessage();
            $_SESSION["old"] = [
                "login" => @$_POST["login"],
                "mail" => @$_POST["mail"],
                "phone" => @$_POST["phone"]
            ];
            $this->redirect(URLROOT."register");
        }
    }

    public function action_login()
    {
        $login = trim(@$_POST["login"]);
        $pass = trim(@$_POST["pass"]);
        $remember = isset($_POST["remember"]);
        try {
            if (self::is_empty($login,$pass)) throw new Exception("Enter all fields to log in");
            ModuleAuth::instance()->login($login, $pass, $remember);
        } catch (Exception $e) {
            $_SESSION["login_error"] = $e->getMessage();
            $_SESSION["login"] = @$_POST["login"];
        }
        $this->redirect(URLROOT);
    }

    public function action_logout()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        ModuleAuth::instance()->logout();
        $this->redirect(URLROOT);
    }

    public function action_logoutAll()
    {
        if (!ModuleAuth::instance()->isAuth()) $this->redirect(URLROOT);
        ModuleAuth::instance()->logout(true);
        $this->redirect(URLROOT);
    }
}