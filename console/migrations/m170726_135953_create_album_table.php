<?php

use yii\db\Migration;

/**
 * Handles the creation of table `album`.
 */
class m170726_135953_create_album_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{album}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'date' => $this->integer(),
            'description' => $this->string(512),
            'dir' => $this->string(512),
            'order_param' => $this->integer()->defaultValue(-1)
        ], $tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{album}}');
    }
}
