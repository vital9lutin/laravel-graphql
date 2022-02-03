<?php

namespace App\GraphQL\Messages;

class AuthMessage extends Message
{
    public const YOU_ARE_NOT_AUTHORIZED = 'You are not authorized';
    public const FAILED = 'The username or password you entered is incorrect.';
    public const YOUR_ACCOUNT_IS_BLOCKED = 'Your account is blocked.';
    public const USER_DOES_NOT_EXIST = 'User does not exist';
    public const USER_IS_ALREADY_REGISTERED = 'User is already registered';
}