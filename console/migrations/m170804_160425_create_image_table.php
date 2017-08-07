<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m170804_160425_create_image_table extends Migration
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

        $this->createTable('{{image}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'src' => $this->string(512),
            'path' => $this->string(512),
            'album_id' => $this->integer(),
            'order_param' => $this->integer()->defaultValue(-1)
        ], $tableOptions);

        /*Внешний ключ, указывающий на альбом*/
        $this->addForeignKey(
            "fk-image-album_id",
            "{{image}}",
            "[[album_id]]",
            "{{album}}",
            "[[id]]",
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey("fk-image-album_id", "{{image}}");

        $this->dropTable('{{image}}');
    }
}
