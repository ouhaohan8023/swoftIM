<?php declare(strict_types=1);


namespace App\Model\Entity;

use Swoft\Db\Annotation\Mapping\Column;
use Swoft\Db\Annotation\Mapping\Entity;
use Swoft\Db\Annotation\Mapping\Id;
use Swoft\Db\Eloquent\Model;


/**
 * 用户消息记录
 * Class Msg
 *
 * @since 2.0
 *
 * @Entity(table="msg")
 */
class Msg extends Model
{
    const NOT_RECEIVED = 0;
    const ALREADY_RECEIVED = 1;
    /**
     * primary
     * @Id()
     * @Column()
     *
     * @var int
     */
    private $id;

    /**
     * 频道id
     *
     * @Column(name="channel_id", prop="channelId")
     *
     * @var string
     */
    private $channelId;

    /**
     * 发送者
     *
     * @Column()
     *
     * @var string
     */
    private $from;

    /**
     * 接收者
     *
     * @Column()
     *
     * @var string
     */
    private $to;

    /**
     *
     *
     * @Column()
     *
     * @var string
     */
    private $msg;

    /**
     * 0:未接收；1：已接收
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
     * @param int $id
     *
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $channelId
     *
     * @return void
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @param string $from
     *
     * @return void
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * @param string $to
     *
     * @return void
     */
    public function setTo(string $to): void
    {
        $this->to = $to;
    }

    /**
     * @param string $msg
     *
     * @return void
     */
    public function setMsg(string $msg): void
    {
        $this->msg = $msg;
    }

    /**
     * @param int $status
     *
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
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
    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    /**
     * @return string
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getMsg(): ?string
    {
        return $this->msg;
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

    public function saveMsg()
    {

    }
}
