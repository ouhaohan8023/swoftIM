<?php declare(strict_types=1);

namespace App\Http\Controller;

use App\Model\Entity\Channel;
use App\Model\Entity\UserTokenFd;
use Swoft;
use Swoft\Http\Message\Response;
use Swoft\Http\Message\ContentType;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;

// use Swoft\Http\Message\Response;

/**
 * Class ChatController
 *
 * @Controller(prefix="/chat")
 * @package App\Http\Controller
 */
class ChatController
{
    /**
     * @RequestMapping(route="/chat/channel/{uid}", method=RequestMethod::GET)
     * @param  string  $uid
     * @return array
     */
    public function channel(int $uid): Response
    {
        $response = \context()->getResponse();
        $data = [1, $uid];
        $number = Channel::getChannelNumber($data);
        if (!Channel::findUserGroup($number)) {
            Channel::startNewChannel($data);
        }
        Swoft\Console\Helper\Show::aList($data,'内容');
        return $response->redirect("/chat/".$number."/".$uid, 302);
        //        return $response->redirect("www.baidu.com", 302);
    }

    /**
     * Get data list. access uri path: /chat
     * @RequestMapping(route="/chat/{channel_id}/{uid}", method=RequestMethod::GET)
     * @param  string  $channel_id
     * @param  string  $uid
     * @return array
     */
    public function index(string $channel_id, int $uid): Response
    {
        if (!Channel::findUserGroup($channel_id)) {
            return view('chat/forbidden');
        } else {
            $token = UserTokenFd::createNewToken($channel_id, $uid);
            return view('chat/index', ['token' => $token,'channel_id'=>$channel_id]);
        }
    }


    public function admin(): Response
    {

    }

    /**
     * Get one by ID. access uri path: /chat/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::GET)
     * @return array
     */
    public function get(): array
    {
        return ['item0'];
    }

    /**
     * Create a new record. access uri path: /chat
     * @RequestMapping(route="/chat", method=RequestMethod::POST)
     * @return array
     */
    public function post(): array
    {
        return ['id' => 2];
    }

    /**
     * Update one by ID. access uri path: /chat/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::PUT)
     * @return array
     */
    public function put(): array
    {
        return ['id' => 1];
    }

    /**
     * Delete one by ID. access uri path: /chat/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::DELETE)
     * @return array
     */
    public function del(): array
    {
        return ['id' => 1];
    }
}
