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

use App\Model\Entity\User;
use Swoft\Console\Helper\Show;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Message\Response;

// use Swoft\Http\Message\Response;

/**
 * Class LoginController
 *
 * @Controller(prefix="/login")
 * @package App\Http\Controller
 */
class LoginController
{
    /**
     * Get data list. access uri path: /login
     * @RequestMapping(route="/login")
     * @return array
     */
    public function index(): Response
    {
        return view('login.php');
    }

    /**
     * Get one by ID. access uri path: /login/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::GET)
     * @return array
     */
    public function get(): array
    {
        return ['item0'];
    }

    /**
     * Create a new record. access uri path: /login
     * @RequestMapping(route="/login", method=RequestMethod::POST)
     * @return array
     */
    public function post(): Response
    {
        $request = context()->getRequest();
        $resp = context()->getResponse();
        if (User::login($request->input('username'), $request->input('password'))) {
            return $resp->redirect("/index",302);
        } else {
            return $resp->withContent('you are not al');
        }
    }

    /**
     * Update one by ID. access uri path: /login/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::PUT)
     * @return array
     */
    public function put(): array
    {
        return ['id' => 1];
    }

    /**
     * Delete one by ID. access uri path: /login/{id}
     * @RequestMapping(route="{id}", method=RequestMethod::DELETE)
     * @return array
     */
    public function del(): array
    {
        return ['id' => 1];
    }
}
