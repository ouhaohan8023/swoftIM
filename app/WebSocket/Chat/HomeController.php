<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\WebSocket\Chat;

use App\Model\Entity\Msg;
use App\Model\Entity\UserTokenFd;
use phpDocumentor\Reflection\Types\Void_;
use Swoft\Console\Helper\Show;
use Swoft\Session\Session;
use Swoft\WebSocket\Server\Annotation\Mapping\MessageMapping;
use Swoft\WebSocket\Server\Annotation\Mapping\WsController;
use Swoft\WebSocket\Server\Message\Message;
use Swoft\WebSocket\Server\Message\Request;

/**
 * Class HomeController
 *
 * @WsController()
 */
class HomeController
{
    /**
     * Message command is: 'home.index'
     *
     * @return void
     * @MessageMapping()
     */
    public function index(): void
    {
        Session::mustGet()->push('hi, this is home.index');
    }

    /**
     * @param  Request $request
     *
     * @return void
     * @MessageMapping()
     */
    public function bind(Request $request): void
    {
        $msg = $request->getMessage()->getData();
        $fd = $request->getFd();
        if (UserTokenFd::bindTokenFD($msg['token'],$fd)) {
            server()->sendTo($fd,'连接建立成功！');
        } else {
            server()->sendTo($fd,'恢复上次链接');
//            server()->disconnect($fd);
        }
    }


    /**
     * @param  Request $request
     *
     * @return void
     * @MessageMapping()
     */
    public function echo(Request $request): void
    {
        $fid = $request->getFd();

        $msg = $request->getMessage()->getData();
        if ($token_user_id = UserTokenFd::checkToken($msg['channel_id'],$msg['token'],$fid)){
            $group = UserTokenFd::getChannelFIdGroup($msg['channel_id']);
            foreach ($group as $f => $user_id) {
                $user = UserTokenFd::getUserByToken($msg['token']);
                if (Session::has((string)$f)) {
                    $ctx['user_id'] = $user->getUserId();
                    $ctx['msg'] = $msg['msg'];
                    $ctx['me'] = $token_user_id==$user_id?true:false;
                    $status = server()->sendTo($f,json_encode($ctx));
                } else {
                    $status = false;
                }
                Msg::create(
                    [
                        'channel_id' => $msg['channel_id'],
                        'from' => $user->getUserId(),
                        'to' => $user_id,
                        'msg' => $msg['msg'],
                        'status' => $status?Msg::ALREADY_RECEIVED:Msg::NOT_RECEIVED
                    ]
                );
            }
        } else {
            server()->sendTo($fid,'异常登陆');
            server()->disconnect($fid);
        }
    }

    /**
     * @return void
     * @MessageMapping("reply_to_some_one")
     */
    public function replyToSomeOne(Message $data): void
    {
        $msg = $data->getData();
        Session::mustGet($msg['fid'])->push($msg['msg']);
    }

    /**
     * Message command is: 'home.ar'
     *
     * @param  string  $data
     * @MessageMapping("ar")
     *
     * @return string
     */
    public function autoReply(string $data): string
    {
        return '(home.ar)Recv: '.$data;
    }
}
