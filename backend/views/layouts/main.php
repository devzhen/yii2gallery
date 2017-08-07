<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

$now = new DateTime('now');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Modal delete album-->
<div id="delete-album-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete the album?</h4>
                <div class="color-bar-1"></div>
                <div class="color-bar-2"></div>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this album '<span id="delete-album-name"></span>'?</p>
            </div>
            <div class="modal-footer">
                <form method="post" action="<?= \yii\helpers\Url::to(['album/delete']); ?>">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                           value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                    <input type="hidden" name="album-id" id="delete-album-id"/>
                    <button type="submit" class="btn btn-default modal-button">Delete</button>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Modal add album-->
<div id="add-album-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-add-album-modal" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create new album</h4>
                <div class="color-bar-1"></div>
                <div class="color-bar-2"></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $model = new yii\base\DynamicModel([
                            'name',
                            'date' => (new \DateTime('now'))->format('d-m-Y'),
                            'description'
                        ]);
                        $model->addRule('name', 'required');

                        $form = \yii\widgets\ActiveForm::begin([
                            'id' => 'add-album-form',
                            'action' => \yii\helpers\Url::to(['album/add'])
                        ]);
                        ?>

                        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                        <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::className(), [
                            'dateFormat' => 'dd-MM-yyyy',
                            'clientOptions' => [
                                'defaultDate' => $now->format('d-m-Y'),
                            ]
                        ]) ?>

                        <?= $form->field($model, 'description')->textarea(['style' => 'resize:none']) ?>


                        <?= \yii\helpers\Html::resetButton('Reset', [
                            'id' => 'add-album-reset-button',
                            'style' => 'display:none;',
                            'class' => 'btn btn-default modal-button',
                            'name' => 'album-add-button']) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= \yii\helpers\Html::submitButton('Create', ['class' => 'btn btn-default modal-button',
                    'name' => 'album-add-button']) ?>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>

<!--Color bars-->
<div class="color-bar-1"></div>
<div class="color-bar-2"></div>

    <?= $content ?>

<button onclick="scrollToTop()" id="scroll-to-top" title="Go to top"></button>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
