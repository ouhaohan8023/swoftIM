<?php declare(strict_types=1);


namespace Database\Migration;


use Swoft\Db\Schema\Blueprint;
use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddUserTokenFdTable
 *
 * @since 2.0
 *
 * @Migration(time=20191127145725)
 */
class AddUserTokenFdTable extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $this->schema->createIfNotExists('user_token_fd', function (Blueprint $blueprint) {
            $blueprint->comment('用户，token，fd关联表');

            $blueprint->increments('id')->comment('primary');
            $blueprint->string('channel_id')->nullable(true)->comment('频道');
            $blueprint->integer('user_id')->default(0)->comment('用户');
            $blueprint->string('token',500)->comment('ws token');
            $blueprint->integer('fid')->default(0)->comment('tcp fid');
            $blueprint->tinyInteger('status')->default(0)->comment('0:未使用；1：已使用');
            $blueprint->timestamps();

            $blueprint->index('user_id');
            $blueprint->index('token');
            $blueprint->index('fid');

            $blueprint->engine  = 'Innodb';
            $blueprint->charset = 'utf8mb4';
        });

    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('user_token_fd');
    }
}
