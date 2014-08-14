<?php namespace Twitter\Api\User;

use Twitter\Api\ApiController;
use Twitter\Api\User\User;

class UsersController extends ApiController {


    public static $modelName = "User";

    public function tweets($userId) {

        $user = User::find($userId);

        return $user->tweets()->get();
    }

    public function messagesFrom($userId) {

        $user = User::find($userId);

        return $user->messagesFrom()->get();
    }

    public function messagesTo($userId) {

        $user = User::find($userId);

        return $user->messagesTo()->get();
    }

    public function favorites($userId) {

        $user = User::find($userId);

        return $user->favorites();
    }
}