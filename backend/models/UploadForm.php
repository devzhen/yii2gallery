<?php

namespace backend\models;

class UploadForm extends \yii\base\Model
{
    /**
     * @var \yii\web\UploadedFile[]
     */
    public $imageFiles;

    /**
     * Загрузка изображений в файловую систему и сохранение в БД
     * @param $albumId integer. ID альбома
     * @return bool
     */
    public function upload($albumId)
    {

        $album = \common\models\Album::findOne($albumId);


        foreach ($this->imageFiles as $file) {

            /*Если это изображение*/
            if (preg_match('#(jpg|png|jpeg|gif)#', $file->extension)) {

                /*Уникальный ID*/
                $uniqueId = uniqid("image_", true);

                /*Сохранить в каталог альбома*/
                $path = $album->dir . '/' . $uniqueId . $file->baseName . '.' . $file->extension;

                $image = new \common\models\Image();

                /*Альбом, которому принадлежит изображение*/
                $image->album_id = $albumId;

                /*Название изображения*/
                $image->name = $file->baseName . '.' . $file->extension;

                /*Путь в файловой системе, где расположено изображение*/
                $image->path = $path;

                /*Значение атрибута src изображения*/
                $image->src = \Yii::$app->params['urlToImages'] . '/albums/' .
                    $album->id . '_' . \mb_strtolower($album->name) .
                    '/' . $uniqueId . $file->baseName . '.' . $file->extension;

                /*Сохранить в БД*/
                $image->save();

                /*Сохранить в файловой системе*/
                $file->saveAs($path);
            };
        }

        return true;

    }
}