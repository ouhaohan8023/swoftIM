<?php declare(strict_types=1);


namespace Database\Migration;


use Swoft\Db\Schema\Blueprint;
use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddFriend
 *
 * @since 2.0
 *
 * @Migration(time=20191204125501)
 */
class AddFriend extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->schema->createIfNotExists('friend', function (Blueprint $blueprint) {
            $blueprint->comment('好友关系表');

            $blueprint->increments('id')->comment('primary');
            $blueprint->integer('user_id_a')->comment('用户id，用户b为用户a的好友');
            $blueprint->integer('user_id_b')->comment('用户id');
            $blueprint->timestamps();

            $blueprint->index('user_id_a');

            $blueprint->engine  = 'Innodb';
            $blueprint->charset = 'utf8mb4';
        });

    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('friend');

    }
}
