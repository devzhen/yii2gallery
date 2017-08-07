/*Передача ID альбома в модальное окно в качестве значения hidden input в  форме*/
(function ($) {

    /*Вывод модального окна удаления альбома*/
    $('#delete-album-modal').on('show.bs.modal', function (event) {

        /*Ссылка, которая вызвала модальное окно*/
        var a = $(event.relatedTarget);

        /*Получение id альбома из data-атрибута*/
        var album_id = a.data('album-id');

        /*Получение name альбома из data-атрибута*/
        var album_name = a.data('album-name');

        /*Установка id альбома в скрытый input, в форме, в модальном окне*/
        var modal = $(this);
        modal.find('input#delete-album-id').val(album_id);

        /*Установка name альбома в span модального окна*/
        modal.find('#delete-album-name').text(album_name);
    });


    /*Вывод модального окна удаления изображения*/
    $('#delete-image-modal').on('show.bs.modal', function (event) {

        /*Ссылка, которая вызвала модальное окно*/
        var a = $(event.relatedTarget);

        /*Получение id изображения из data-атрибута*/
        var image_id = a.data('image-id');

        /*Установка id изображения в скрытый input, в форме, в модальном окне*/
        var modal = $(this);
        modal.find('input#delete-image-id').val(image_id);

        /*Получение значения атрибута src удаляемого изображения*/
        var imageSrc = a.data('image-src');

        /*В модальном окне появится удаляемое изображение*/
        modal.find('img#deleted-image').attr('src', imageSrc);
    });


    /*При закрытии модального окна добавления альбома - очистить данные*/
    $('#add-album-modal').on('hidden.bs.modal', function (e) {

        /*Очистить форму*/
        $('#add-album-reset-button').trigger('click');
    });

    /*При закрытии модального окна добавления альбома - очистить данные*/
    $('#edit-album-modal').on('hidden.bs.modal', function (e) {

        /*Очистить форму*/
        $('#edit-album-reset-button').trigger('click');
    });

    /*При закрытии модального окна загрузки изображений - очистить данные*/
    $('#upload-image-modal').on('hidden.bs.modal', function (e) {

        /*Очистить форму*/
        $('#upload-image-reset-button').trigger('click');
    });

})(window.jQuery);