<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://swoft.org/docs
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Http\Controller;

use App\Model\Entity\Channel;
use App\Model\Entity\Friend;
use App\Model\Entity\Msg;
use App\Model\Entity\User;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Session\HttpSession;

use Swoft\Http\Message\Response;

/**
 * Class IndexController
 *
 * @Controller(prefix="/index")
 * @package App\Http\Controller
 */
class IndexController
{
    /**
     * Get data list. access uri path: /index
     * @RequestMapping(route="/index", method=RequestMethod::GET)
     * @return Response
     */
    public function index(): Response
    {
        $user = HttpSession::current()->get(User::SESSION_KEY);
        $friends = Friend::getFriendsByUserId($user['id']);
        $channels = Channel::getChannels($user['id']);
        $msg = Msg::getLastMsg($channels);
        return view('index/index.php', ['user' => $user,'friends'=>$friends,'msg'=>$msg]);
    }

    /**
     * @RequestMapping(route="/logout", method=RequestMethod::GET)
     * @return Response
     */
    public function logout(): Response
    {
        HttpSession::current()->delete(User::SESSION_KEY);
        return context()->getResponse()->redirect("/login",302);
    }

    /**
     * Create a new record. access uri path: /index
     * @RequestMapping(route="/index", method=RequestMethod::POST)
     * @return array
     */
    public function post(): array
    {
        return ['id' => 2];
    }

    /**
     * Update one by ID. access uri path: /index/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::PUT)
     * @return array
     */
    public function put(): array
    {
        return ['id' => 1];
    }

    /**
     * Delete one by ID. access uri path: /index/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::DELETE)
     * @return array
     */
    public function del(): array
    {
        return ['id' => 1];
    }
}
