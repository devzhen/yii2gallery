<?php

use yii\db\Migration;

class m170727_163135_fill_album_table extends Migration
{
    public function safeUp()
    {
        $this->fillAlbumTableRow(
            "Dogs",
            "This album contains images of dogs"
        );

        $this->fillAlbumTableRow(
            "Cats",
            "This album contains images of cats"
        );

        $this->fillAlbumTableRow(
            "Nature",
            "This album contains images of nature"
        );

        $this->fillAlbumTableRow(
            "Moto",
            "This album contains images of motorcycles"
        );

        $this->fillAlbumTableRow(
            "temp",
            "This album contains images of ..."
        );

        $this->fillAlbumTableRow(
            "some",
            ""
        );
    }

    public function safeDown()
    {
        return false;
    }

    public function fillAlbumTableRow($album_name, $album_description)
    {
        $tableName = 'album';

        /*Сохранить в БД*/
        $album_id = \intval($this->db->lastInsertID) + 1;
        $album_date = (new \DateTime('now'))->getTimestamp();
        $album_dir = \common\models\Album::getFileSystemPath() . "/" . $album_id . "_" . $album_name;

        $this->insert($tableName, [
            'id' => $album_id,
            'name' => $album_name,
            'date' => $album_date,
            'description' => $album_description,
            'dir' => $album_dir,
        ]);

        echo $album_dir . PHP_EOL;

        /*Создать каталог в файловой системе*/
        if (!file_exists($album_dir)) {
            \mkdir($album_dir);
        }
    }
}
