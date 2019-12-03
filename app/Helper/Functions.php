<?php

use App\Model\Entity\UserTokenFd;

/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

function user_func(): string
{
    return 'hello';
}

function sendOnLineUserNumberToAll()
{
    $num = UserTokenFd::updateOnlineNums();
    $cc['type'] = 'number';
    $cc['code'] = 200;
    $cc['msg'] = $num;
    server()->sendToAll(json_encode($cc));
}
