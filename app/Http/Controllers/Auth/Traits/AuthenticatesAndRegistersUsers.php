<?php

namespace Dojo\Http\Controllers\Auth\Traits;

use Dojo\Http\Controllers\Auth\Traits\AuthenticatesUsers as AuthenticatesUsers;
use Dojo\Http\Controllers\Auth\Traits\RegistersUsers as RegistersUsers;

trait AuthenticatesAndRegistersUsers
{
    use AuthenticatesUsers, RegistersUsers {
        AuthenticatesUsers::redirectPath insteadof RegistersUsers;
    }
}