<?php

namespace common\models;

/**
 * Class Image
 * @package common\models
 * @property $id integer. ID изображения.
 * @property $name string. Название изображения.
 * @property $src string. Путь к изображению из web
 * @property $path string. Путь к изображению в файловой системе.
 * @property $album_id integer. ID альбома.
 * @property $order_param integer. Параметр сортировки.
 * @property $album Album. Альбом, которому принадлежит изображение.
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * Название таблицы в БД
     * @return string
     */
    public static function tableName()
    {
        return "image";
    }

    /**
     * Связанная таблица.
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(\common\models\Album::className(), ["id" => "album_id"]);
    }
}