<?php declare(strict_types=1);


namespace Database\Migration;


use Swoft\Db\Schema\Blueprint;
use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddUser
 *
 * @since 2.0
 *
 * @Migration(time=20191203163113)
 */
class AddUser extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->schema->createIfNotExists('user', function (Blueprint $blueprint) {
            $blueprint->comment('用户表');

            $blueprint->increments('id')->comment('primary');
            $blueprint->string('name')->comment('昵称');
            $blueprint->string('username', 500)->comment('账户');
            $blueprint->string('password',500)->comment('密码');
            $blueprint->string('avatar',500)->nullable(true)->comment('头像');
            $blueprint->tinyInteger('online')->default(0)->comment('0:不在线；1：在线');
            $blueprint->timestamps();

            $blueprint->index('id');
            $blueprint->index('username');

            $blueprint->engine  = 'Innodb';
            $blueprint->charset = 'utf8mb4';
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('user');
    }
}
