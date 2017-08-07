<?php

namespace backend\controllers;

class ImageController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'error'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', 'update-order-position'],
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'update-order-position' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Удалить изображение
     */
    public function actionDelete()
    {
        $imageId = \Yii::$app->request->post('image-id');

        $image = \common\models\Image::findOne($imageId);

        /*Удаление из файловой системы*/
        if (\file_exists($image->path)) {
            \unlink($image->path);
        }

        /*Удаление из БД*/
        $image->delete();

        /*Ключ для шифрования ID альбома*/
        $cryptKey = \Yii::$app->params['cryptKey'];

        /*Шифрование ID альбома*/
        $albumId = \Yii::$app->getSecurity()->encryptByKey($image->album_id, $cryptKey);

        $this->redirect(['album/one', 'album_id' => $albumId]);
    }

    /**
     * Изменить порядок вывода изображений на странице
     */
    public function actionUpdateOrderPosition()
    {
        $images = json_decode(\Yii::$app->request->post('images'));

        /*Изменить порядок вывода изображений на странице*/
        foreach ($images as $image) {

            $stored_image = \common\models\Image::findOne(\intval($image->id));

            $stored_image->order_param = $image->order_param;
            $stored_image->save();
        }
    }
}