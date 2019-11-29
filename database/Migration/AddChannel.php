<?php declare(strict_types=1);


namespace Database\Migration;


use Swoft\Db\Schema\Blueprint;
use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddChannel
 *
 * @since 2.0
 *
 * @Migration(time=20191128145313)
 */
class AddChannel extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->schema->createIfNotExists('channel', function (Blueprint $blueprint) {
            $blueprint->comment('聊天频道');

            $blueprint->increments('id')->comment('primary');
            $blueprint->string('number',255)->comment('频道识别码');
            $blueprint->integer('user_id')->comment('用户');
            $blueprint->timestamps();

            $blueprint->index('number');
            $blueprint->index('user_id');
            $blueprint->engine  = 'Innodb';
            $blueprint->charset = 'utf8mb4';
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {

    }
}
