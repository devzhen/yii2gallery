<?php

namespace common\models;

/**
 * Class Album
 * @package common\models
 * @property $id integer. ID альбома.
 * @property $name string. Название альбома.
 * @property $date string. Дата создания альбома.
 * @property $description string. Описание альбома.
 * @property $firstImage \yii\db\ActiveRecord. Первое изображение в альбоме.
 * @property $images [] \yii\db\ActiveQuery. Массив изображений.
 * @property $dir string. Путь к каталогу, где хранится альбом.
 * @property $order_param integer. Параметр сортировки.
 */
class Album extends \yii\db\ActiveRecord
{
    /**
     * Название таблицы в БД
     * @return string
     */
    public static function tableName()
    {
        return "album";
    }

    /**
     * Связанная таблица изображений
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(\common\models\Image::className(), ["album_id" => "id"])
            ->orderBy('[[order_param]]');
    }

    /**
     * Связанная таблица изображений
     * @return \yii\db\ActiveQuery
     */
    public function getFirstImage()
    {
        return $this->hasOne(\common\models\Image::className(), ["album_id" => "id"])
            ->orderBy('[[order_param]]');

    }

    /**
     * Правила валидации
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            [['name', 'description'], 'trim']
        ];
    }

    /**
     * Метод создает каталог с именем альбома по указанноу пути
     * @param $path string = null. Путь для сохранения.
     * @return bool
     */
    public function saveInFileSystem($path = null)
    {
        $pathToAlbum = static::getFileSystemPath() . $this->id . '_' . \mb_strtolower($this->name);

        /*Создать каталог*/
        if (!file_exists($pathToAlbum)) {

            if (\mkdir($pathToAlbum)) {

                $this->dir = $pathToAlbum;
                return true;
            }
        }
    }

    /**
     * Метод переименовывет каталог с именем альбома при редактировании имени альбома
     * @return bool
     */
    public function renameInFileSystem()
    {
        $pathToAlbum = static::getFileSystemPath() . $this->id . '_' . $this->name;

        /*Переименовать каталог*/
        if (\rename($this->dir, $pathToAlbum)) {

            $this->dir = $pathToAlbum;
            return true;
        }

    }

    /**
     * Метод удаляет каталог с именем альбома из файловой системы со всеми фото
     */
    public function removeFromFileSystem()
    {
        if (\is_dir($this->dir)) {

            $dir_handle = \opendir($this->dir);

            if (!$dir_handle) {
                return;
            }

            while ($file = \readdir($dir_handle)) {

                if ($file != "." && $file != "..") {
                    \unlink($this->dir . "/" . $file);
                }
            }
            \closedir($dir_handle);
            \rmdir($this->dir);
        }
    }

    /**
     * Путь в файловой системе, где будут храниться альбомы
     */
    public static function getFileSystemPath()
    {
        return \Yii::$app->params['pathToAlbums'];
    }
}