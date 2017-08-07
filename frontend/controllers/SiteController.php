<?php

namespace frontend\controllers;

/**
 * Site controller
 */
class SiteController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Отображение всех альбомов галереи
     */
    public function actionIndex()
    {
        $album_count = \common\models\Album::find()->count();

        $pagination = new \yii\data\Pagination();
        $pagination->totalCount = $album_count;
        $pagination->pageSize = \Yii::$app->params['count-albums-on-page'];

        $albums = \common\models\Album::find()
            ->with('firstImage')
            ->orderBy('[[order_param]]')
            ->asArray()
            ->all();

        return $this->render('index', [
            'albums' => $albums,
            'pagination' => $pagination
        ]);
    }


    /**
     * Отображение одного альбома.
     *
     * @return mixed
     */
    public function actionOne()
    {
        $albumId = \Yii::$app->request->get('album-id');

        $cryptKey = \Yii::$app->params['cryptKey'];
        $albumId = \Yii::$app->getSecurity()->decryptByKey($albumId, $cryptKey);

        $album = \common\models\Album::find()
            ->with('images')
            ->where("id=$albumId")
            ->one();

        if ($album == null) {

            $this->redirect(\Yii::$app->homeUrl);

        } else {

            return $this->render('detail', [
                'album' => $album
            ]);
        }


    }
}
