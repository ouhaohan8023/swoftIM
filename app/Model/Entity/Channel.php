<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Console\Helper\Show;
use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 聊天频道
 * Class Channel
 *
 * @since 2.0
 *
 * @Entity(table="channel")
 */
class Channel extends Model
{
    /**
     * primary
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 频道识别码
     *
     * @Column()
     *
     * @var string
     */
    private $number;

    /**
     * 用户
     *
     * @Column(name="user_id", prop="userId")
     *
     * @var int
     */
    private $userId;

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
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $number
     *
     * @return void
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * @param int $userId
     *
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param string|null $createdAt
     *
     * @return void
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param string|null $updatedAt
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
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
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

    public static function startNewChannel(array $user_group)
    {
        $number = self::getChannelNumber($user_group);
        $data = [];
        foreach ($user_group as $k => $v) {
            $data[$k]['number'] = $number;
            $data[$k]['user_id'] = $v;
        }
        Show::aList($data,'批量');

        self::insert($data);
        return $number;
    }

    public static function findUserGroup($channel_id)
    {
        $data = self::query()->where('number',$channel_id);
        if (!$data->exists()) {
            return false;
        } else {
            return $data->pluck('user_id');
        }
    }

    public static function getChannelNumber(array $arr)
    {
        return md5(json_encode($arr));
    }
}
