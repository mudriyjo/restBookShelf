<?php
namespace app\controllers;

use app\exception\HttpAccessException;
use app\models\Users;
use \Phalcon\Di as Di;

class BaseController extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        Di::getDefault()->get('response')->setContentType('application/json', 'utf-8');
    }

    protected function _auth()
    {
        $login = Di::getDefault()->get('request')->getServer('PHP_AUTH_USER');
        $password = Di::getDefault()->get('request')->getServer('PHP_AUTH_PW');

        $user = Users::findFirstByLogin($login);
        if ($user && $this->security->checkHash($password, $user->password)) {
            return true;
        }
        throw new HttpAccessException();
    }
}