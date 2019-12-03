<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\WebSocket;

use App\Model\Entity\UserTokenFd;
use App\WebSocket\Chat\HomeController;
use Swoft\Console\Helper\Show;
use Swoft\Http\Message\Request;
use Swoft\WebSocket\Server\Annotation\Mapping\OnOpen;
use Swoft\WebSocket\Server\Annotation\Mapping\OnClose;
use Swoft\WebSocket\Server\Annotation\Mapping\WsModule;
use Swoft\WebSocket\Server\MessageParser\JsonParser;
use Swoole\WebSocket\Server;
use function server;

/**
 * Class ChatModule
 *
 * @WsModule(
 *     "/chat",
 *     messageParser=JsonParser::class,
 *     controllers={HomeController::class}
 * )
 */
class ChatModule
{
    /**
     * @OnOpen()
     * @param  Request  $request
     * @param  int  $fd
     */
    public function onOpen(Request $request, int $fd): void
    {
        $ctx['type'] = 'system';
        $ctx['code'] = 200;
        $ctx['msg'] = '准备建立星际通讯！';
        server()->push($request->getFd(), json_encode($ctx));
    }

    /**
     * On connection closed
     * - you can do something. eg. record log
     *
     * @OnClose()
     * @param  Server  $server
     * @param  int  $fd
     */
    public function onClose(Server $server, int $fd): void
    {
        $ctx['type'] = 'system';
        $ctx['code'] = 500;
        $ctx['msg'] = '很遗憾，星际通讯已断开！';
        UserTokenFd::destroyToken($fd);
        server()->push($fd, json_encode($ctx));

        sendOnLineUserNumberToAll();
    }
}
