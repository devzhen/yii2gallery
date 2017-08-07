<?php

namespace backend\controllers;

class AlbumController extends \yii\web\Controller
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
                        'actions' => ['index', 'add', 'delete', 'sort', 'update-order-position', 'one', 'edit', 'upload-images'],
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'add' => ['post'],
                    'update-order-position' => ['post'],
                    'edit' => ['post'],
                    'upload-images' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $album_count = \common\models\Album::find()->count();

        $pagination = new \yii\data\Pagination();
        $pagination->totalCount = $album_count;
        $pagination->pageSize = \Yii::$app->params['count-albums-on-page'];

        $albums = \common\models\Album::find()
            ->with('firstImage')
            ->orderBy(['order_param' => SORT_ASC, 'date' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        \yii\helpers\Url::remember();

        return $this->render("index", ['albums' => $albums, 'pagination' => $pagination]);
    }

    public function actionAdd()
    {
        $dynamicModel = \Yii::$app->request->post('DynamicModel');

        $album = new \common\models\Album();

        $album->name = $dynamicModel['name'];

        $date = \DateTime::createFromFormat('d-m-Y', $dynamicModel['date']);
        $album->date = $date->getTimestamp();

        $album->description = $dynamicModel['description'];

        /*Если валидация прошла успешно и альбом сохранен в БД и в файловой системе*/
        if ($album->validate() && $album->save()) {
            $album->saveInFileSystem(\Yii::$app->params['upload-path']);
            $album->save();
        }

        return $this->redirect(\yii\helpers\Url::previous());
    }

    public function actionDelete()
    {
        $albumId = \Yii::$app->request->post('album-id');

        $album = \common\models\Album::findOne($albumId);

        /*Удаление из файловой системы*/
        $album->removeFromFileSystem();

        /*Удаление из БД*/
        $album->delete();

        return $this->redirect(\yii\helpers\Url::previous());
    }

    public function actionSort()
    {
        $albums = \common\models\Album::find()
            ->with('firstImage')
            ->orderBy(['order_param' => SORT_ASC, 'date' => SORT_DESC])
            ->asArray()
            ->all();

        \yii\helpers\Url::remember();

        return $this->render("sort", ['albums' => $albums]);
    }


    /**
     * Изменить порядок вывода альбомов на странице
     */
    public function actionUpdateOrderPosition()
    {
        $albums = json_decode(\Yii::$app->request->post('albums'));

        /*Изменить порядок вывода альбомов на странице*/
        foreach ($albums as $album) {

            $stored_album = \common\models\Album::findOne($album->id);
            $stored_album->order_param = $album->order_param;
            $stored_album->save();

        }
    }

    /**
     * Просмотр информации о конкретном альбоме
     * @return string
     */
    public function actionOne()
    {
        $album_id = \Yii::$app->request->get('album_id');
        $cryptKey = \Yii::$app->params['cryptKey'];

        $albumId = \Yii::$app->getSecurity()->decryptByKey($album_id, $cryptKey);


        try {

            $album = \common\models\Album::find()
                ->where("id=$albumId")
                ->with('images')
                ->one();

            return $this->render("detail", ['album' => $album]);

        } catch (\Exception $e) {

            $this->redirect(\yii\helpers\Url::previous());
        }
    }

    /**
     * Редактирование информации об альбоме
     */
    public function actionEdit()
    {
        $model = \Yii::$app->request->post('Album');

        $album_id = \intval($model['id']);

        $album = \common\models\Album::findOne($album_id);

        $album->name = $model['name'];

        $date = \DateTime::createFromFormat('d-m-Y', $model['date']);
        $album->date = $date->getTimestamp();

        $album->description = $model['description'];

        /*Если валидация прошла успешно и альбом сохранен в БД и переименован в файловой системе*/
        if ($album->validate() && $album->save()) {
            $album->renameInFileSystem();
            $album->save();
        }

        return $this->render("detail", ['album' => $album]);
    }

    /**
     * Загрузка изображения в альбом
     */
    public function actionUploadImages()
    {
        if (\Yii::$app->request->isPost) {

            $album_id = \Yii::$app->request->post('album-id');

            $model = new \backend\models\UploadForm();

            $model->imageFiles = \yii\web\UploadedFile::getInstancesByName('imageFiles');

            $model->upload($album_id);

            /*Ключ для шифрования ID альбома*/
            $cryptKey = \Yii::$app->params['cryptKey'];

            /*Шифрование ID альбома*/
            $albumId = \Yii::$app->getSecurity()->encryptByKey($album_id, $cryptKey);

            $this->redirect(['album/one', 'album_id' => $albumId]);
        }
    }
}