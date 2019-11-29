<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 用户，token，fd关联表
 * Class UserTokenFd
 *
 * @since 2.0
 *
 * @Entity(table="user_token_fd")
 */
class UserTokenFd extends Model
{
    const NEVER_USE = 0;
    const ALREADY_USED = 1;
    /**
     * primary
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 频道
     *
     * @Column(name="channel_id", prop="channelId")
     *
     * @var string
     */
    private $channelId;

    /**
     * 用户
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

    /**
     * ws token
     *
     * @Column()
     *
     * @var string
     */
    private $token;

    /**
     * tcp fid
     *
     * @Column()
     *
     * @var int
     */
    private $fid;

    /**
     * 0:未使用；1：已使用
     *
     * @Column()
     *
     * @var int
     */
    private $status;

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
     * @param  string  $channelId
     *
     * @return void
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @param  int  $userId
     *
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param  string  $token
     *
     * @return void
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @param  int  $fid
     *
     * @return void
     */
    public function setFid(int $fid): void
    {
        $this->fid = $fid;
    }

    /**
     * @param  int  $status
     *
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
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
    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getFid(): ?int
    {
        return $this->fid;
    }

    /**
     * @return int
     */
    public function getStatus(): ?int
    {
        return $this->status;
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

    /**
     * 新建token
     * @param $uid
     * @param $channel_id
     * @return string
     */
    public static function createNewToken($channel_id, $uid)
    {
        $token = md5(md5('123456').'Swoft'.$uid.time());
        $search = [
            'channel_id' => $channel_id,
            'user_id'    => $uid,
            'status' => self::NEVER_USE
        ];
//        $data = self::query()->where($search)->first();
//        if ($data) {
//            return $data->getToken();
//        } else {
//            self::create([
//                'channel_id' => $channel_id,
//                'user_id'    => $uid,
//                'status' => self::NEVER_USE,
//                'token'
//            ]);
//        }
        $data = self::firstOrCreate($search, [
            'token' => $token,
        ]);
        return $data->token;
    }

    /**
     * 检查token是否存在
     * @param $token
     * @param $channel_id
     * @param $fd
     * @return bool
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function checkToken($channel_id, $token, $fd)
    {
        $data = self::query()
            ->where('channel_id', $channel_id)
            ->where('token', $token)
            ->where('fid', $fd)
            ->where('status', self::ALREADY_USED)->first();
        return $data->getUserId();
    }

    /**
     * 销毁token
     * @param $fid
     * @param $channel_id
     * @return int|mixed
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function destroyToken($fd)
    {
        return self::query()->where('fid', $fd)->delete();
    }

    /**
     * 将用户token和fid绑定
     * @param $token
     * @param $fd
     * @return bool
     * @throws \ReflectionException
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function bindTokenFD($token, $fd)
    {
        if ($data = self::query()->where('token', $token)->first()) {
            if ($data->status == self::NEVER_USE) {
                $data->status = self::ALREADY_USED;
                $data->fid = $fd;
                $data->save();
                return true;
            } else {
                self::create([
                    "token" => $token,
                    "fid" => $fd,
                    "user_id" => $data->getUserId(),
                    "channel_id" => $data->getChannelId(),
                ]);
            }
        } else {
            return false;
        }

    }

    /**
     * 检查用户当前是否在线
     * @param $channel_id
     * @param $uid
     * @return bool
     * @throws \Swoft\Db\Exception\DbException
     */
    public static function checkLoginStatus($channel_id, $uid)
    {
        return self::query()->where('channel_id', $channel_id)->where('user_id', $uid)->where('status',
                self::ALREADY_USED)->exists();
    }

    public static function getUnReadMsg($uid)
    {
        //        self::query()->where('to',$uid)->groupBy('')
    }

    public static function getUserGroupByUserId($user_id)
    {
        return self::query()->where('user_id',$user_id)->pluck('fid')->toArray();
    }

    public static function getChannelFIdGroup($channel_id)
    {
        return self::query()->where('channel_id',$channel_id)->pluck('user_id','fid')->toArray();
    }

    public static function getUserByToken($token)
    {
        $data = self::query()->select('user_id')->where('token',$token)->first();
        return $data;
    }

}
