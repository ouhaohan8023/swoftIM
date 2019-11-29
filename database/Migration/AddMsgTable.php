<?php declare(strict_types=1);


namespace Database\Migration;


use Swoft\Db\Schema\Blueprint;
use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddMsgTable
 *
 * @since 2.0
 *
 * @Migration(time=20191127103416)
 */
class AddMsgTable extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->schema->createIfNotExists('msg', function (Blueprint $blueprint) {
            $blueprint->comment('用户消息记录');

            $blueprint->increments('id')->comment('primary');
            $blueprint->string('channel_id')->comment('频道id');
            $blueprint->string('from')->default(0)->comment('发送者');
            $blueprint->string('to')->default(0)->comment('接收者');
            $blueprint->text('msg', 5000);
            $blueprint->tinyInteger('status')->default(0)->comment('0:未接收；1：已接收');
            $blueprint->timestamps();

            $blueprint->index('channel_id');
            $blueprint->index('from');
            $blueprint->index('to');
            $blueprint->engine  = 'Innodb';
            $blueprint->charset = 'utf8mb4';
        });

    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('msg_table');
    }
}
