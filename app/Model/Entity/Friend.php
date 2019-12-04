<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 好友关系表
 * Class Friend
 *
 * @since 2.0
 *
 * @Entity(table="friend")
 */
class Friend extends Model
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
     * 用户id，用户b为用户a的好友
     *
     * @Column(name="user_id_a", prop="userIdA")
     *
     * @var int
     */
    private $userIdA;

    /**
     * 用户id
     *
     * @Column(name="user_id_b", prop="userIdB")
     *
     * @var int
     */
    private $userIdB;

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
     * @param int $userIdA
     *
     * @return void
     */
    public function setUserIdA(int $userIdA): void
    {
        $this->userIdA = $userIdA;
    }

    /**
     * @param int $userIdB
     *
     * @return void
     */
    public function setUserIdB(int $userIdB): void
    {
        $this->userIdB = $userIdB;
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
     * @return int
     */
    public function getUserIdA(): ?int
    {
        return $this->userIdA;
    }

    /**
     * @return int
     */
    public function getUserIdB(): ?int
    {
        return $this->userIdB;
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

    public static function getFriendsByUserId($uid)
    {
        return self::query()->where('user_id_a',$uid)
            ->leftJoin('user', 'friend.user_id_b', '=', 'user.id')
            ->get()->toArray();
    }
}
