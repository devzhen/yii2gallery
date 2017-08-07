<?php
/**@var $this \yii\web\View */
/**@var $album common\models\Album */
/**@var $uploadModel backend\models\UploadForm */
$this->title = "Album detail";

$date = new DateTime();
$date->setTimestamp($album->date);


/*При редактированиии, при отправке формы убедиться что данные изменились*/
$this->registerJs("
    $('#edit-album-form').on('submit', function (e) {

        e.preventDefault();
        e.stopImmediatePropagation();

        var album_name = $('#album-name').val();
        var album_date = $('#album-date').val();
        var album_description = $('#album-description').val();
        
        /*Если данные не изменились*/
        if (album_name == '$album->name' &&
            album_date == '{$date->format('d-m-Y')}' &&
            album_description == '$album->description') {

            $('#edit-album-modal').modal('hide')

        } else {
            e.currentTarget.submit();
        }

    });
");

$this->registerJsFile("@web/js/sortable.min.js", [
    'depends' => [
        \backend\assets\AppAsset::className()
    ]
]);
$this->registerJsFile("@web/js/gallery-images-sort.js", [
    'depends' => [
        \backend\assets\AppAsset::className()
    ]
]);
?>

<!-- Modal edit album-->
<div id="edit-album-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-edit-album-modal" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit album</h4>
                <div class="color-bar-1"></div>
                <div class="color-bar-2"></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $form = \yii\widgets\ActiveForm::begin([
                            'id' => 'edit-album-form',
                            'action' => \yii\helpers\Url::to(['album/edit'])
                        ]);
                        ?>

                        <?= $form->field($album, 'id')->hiddenInput()->label(false); ?>

                        <?= $form->field($album, 'name')->textInput(['autofocus' => true]); ?>

                        <?= $form->field($album, 'date')->widget(\yii\jui\DatePicker::className(), [
                            'dateFormat' => 'dd-MM-yyyy',
                            'clientOptions' => [
                                'defaultDate' => (new DateTime('now'))->format('d-m-Y'),
                            ]
                        ]) ?>

                        <?= $form->field($album, 'description')->textarea(['style' => 'resize:none']) ?>

                        <?= \yii\helpers\Html::resetButton('Reset', [
                            'id' => 'edit-album-reset-button',
                            'style' => 'display:none;',
                            'class' => 'btn btn-default modal-button',
                            'name' => 'album-edit-reset-button']) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= \yii\helpers\Html::submitButton('Edit', ['class' => 'btn btn-default modal-button',
                    'name' => 'album-edit-submit-button']) ?>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>

<!-- Upload image modal-->
<div id="upload-image-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-edit-album-modal" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload images</h4>
                <div class="color-bar-1"></div>
                <div class="color-bar-2"></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <?php

                        $form = \yii\widgets\ActiveForm::begin([
                            'id' => 'upload-images-form',
                            'action' => \yii\helpers\Url::to(['album/upload-images']),
                            'options' => [
                                'enctype' => 'multipart/form-data'
                            ]
                        ]);
                        ?>

                        <input type="hidden" name="album-id" value="<?= $album->id ?>">
                        <input type="file" id="imageFiles" name="imageFiles[]" multiple accept="image/*">

                        <?= \yii\helpers\Html::resetButton('Reset', [
                            'id' => 'upload-image-reset-button',
                            'style' => 'display:none;',
                            'name' => 'upload-images-reset-button']) ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?= \yii\helpers\Html::submitButton('Upload', ['class' => 'btn btn-default modal-button',
                    'name' => 'upload-images-submit-button']) ?>

                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>

<!-- Modal delete image-->
<div id="delete-image-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete the image?</h4>
                <div class="color-bar-1"></div>
                <div class="color-bar-2"></div>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this image?</p>
                <img class="img-responsive" id="deleted-image" src="#"/>
            </div>
            <div class="modal-footer">
                <form method="post" action="<?= \yii\helpers\Url::to(['image/delete']); ?>">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                           value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                    <input type="hidden" name="image-id" id="delete-image-id"/>
                    <button type="submit" class="btn btn-default modal-button">Delete</button>
                </form>
            </div>
        </div>

    </div>
</div>

<!--Navs and images-->
<div class="container">

    <!--Header-->
    <div class="row">

        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 logo">
            <h2><a href="<?= \Yii::$app->homeUrl ?>">Yii2 Gallery</a></h2>
        </div>

        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 navigation">
            <ul class="nav nav-pills">
                <li>
                    <a href="<?= \Yii::$app->homeUrl ?>">All albums</a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        Actions <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#" data-toggle="modal" data-target="#edit-album-modal">Edit album</a>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#upload-image-modal">Upload image(s)</a>
                        </li>
                        <li>
                            <a href="#" class="album-delete" data-toggle="modal" data-target="#delete-album-modal"
                               data-album-id="<?= $album->id ?>" data-album-name="<?= $album->name ?>">
                                Delete album
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <form method="post" action="<?= \yii\helpers\Url::to(['site/logout']) ?>">
                        <button type="submit" class="btn btn-link">Logout(<?= Yii::$app->user->identity->username ?>)
                        </button>
                        <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                    </form>
                </li>
            </ul>
        </div>

    </div>

    <div class="color-bar-1"></div>
    <div class="color-bar-2"></div>

    <!--Content-->
    <div id="album-container" class="row">

        <div class="col-lg-12">
            <ul class="album-info">
                <li>Name:<h4><?= $album->name ?></h4></li>
                <li>Date: <h4><?= $date->format("d-m-Y H:i:s") ?></h4></li>
                <li>Description:<h4> <?= $album->description ?></h4></li>
            </ul>
        </div>
    </div>

    <div id="image-container" class="row">

        <?php if (\count($album->images) == 0): ?>
            <h5>There are no images in the album</h5>
        <?php endif; ?>

        <?php foreach ($album->images as $image): ?>

            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 image">


                <!--Изображение галереи-->
                <img class="gallery-image img-responsive" src="<?= $image->src ?>" alt="">


                <a href="#" class="delete-image"
                   data-toggle="modal"
                   data-target="#delete-image-modal"
                   data-image-id="<?= $image->id ?>"
                   data-album-id="<?= $album->id ?>"
                   data-image-src="<?= $image->src ?>">

                    <!--Иконка удалить изображение-->
                    <img class="delete-gallery-image"
                         src="<?= \Yii::getAlias('@web/img/delete-album.png') ?>"
                         data-toggle="tooltip" title="Delete" draggable="false"/>

                </a>
            </div>

        <?php endforeach; ?>

    </div>
</div>
