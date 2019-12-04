<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Console\Helper\Show;
use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;
use Swoft\Http\Session\HttpSession;
use Swoft\Redis\Redis;


/**
 * 用户表
 * Class User
 *
 * @since 2.0
 *
 * @Entity(table="user")
 */
class User extends Model
{
    const SESSION_KEY = 'user:profile';
    /**
     * primary
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 昵称
     *
     * @Column()
     *
     * @var string
     */
    private $name;

    /**
     * 账户
     *
     * @Column()
     *
     * @var string
     */
    private $username;

    /**
     * 密码
     *
     * @Column(hidden=true)
     *
     * @var string
     */
    private $password;

    /**
     * 头像
     *
     * @Column()
     *
     * @var string
     */
    private $avatar;

    /**
     * 0:不在线；1：在线
     *
     * @Column()
     *
     * @var int
     */
    private $online;

    /**
     *
     *
     * @Column(name="created_at", prop="createdAt")
     *
     * @var string|null
     */
    private $createdAt;

    /**
     *
     *
     * @Column(name="updated_at", prop="updatedAt")
     *
     * @var string|null
     */
    private $updatedAt;


    /**
     * @param  int  $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param  string  $name
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param  string  $username
     *
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param  string  $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param  string  $avatar
     *
     * @return void
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @param  int  $online
     *
     * @return void
     */
    public function setOnline(int $online): void
    {
        $this->online = $online;
    }

    /**
     * @param  string|null  $createdAt
     *
     * @return void
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param  string|null  $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @return int
     */
    public function getOnline(): ?int
    {
        return $this->online;
    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public static function getUserId($username)
    {
        $user = self::query()->where('username', $username)->first();
        if ($user) {
            return $user->getId();
        } else {
            return false;
        }
    }

    public static function isLogin($username)
    {
        $id = self::getUserId($username);
        if ($id) {
            $user = Redis::get('user:profile:'.$id);
            if ($user) {
                return $user;
            }
        }
        return false;
    }

    public static function makePwd($pwd, $salt = 'GOD')
    {
        return md5($salt.$pwd.$salt);
    }

    public static function login($username, $password)
    {
        $user = self::query()->where('username', $username)->first();
        Show::aList([$username,self::makePwd($password)], '账号'.$username);
        if ($user) {
            if ($user->getPassword() == self::makePwd($password)) {
                HttpSession::current()->set(User::SESSION_KEY, $user->toArray());
//                Redis::set('user:profile:'.$user->getId(), $user->toArray(), 120);
                return true;
            }
        }
        return false;
    }

    public static function getAvatarByCache($user_id)
    {
        $redis = Redis::get('user_avatar_'.$user_id);
        if ($redis) {
            return $redis;
        } else {
            $avatar = User::find($user_id)->getAvatar();
            Redis::set('user_avatar_'.$user_id,$avatar,500);
            return $avatar;
        }
    }

}
