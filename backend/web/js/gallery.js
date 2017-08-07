(function ($) {

    $(document).ready(function () {

        /*Всплывающие подсказки*/
        $('[data-toggle="tooltip"]').tooltip();


        /*Отображать кнопки при наведении на альбом */
        $(document).on('mouseenter', '.album', function (e) {
            var target = e.currentTarget;

            $(target).find('.album-view').css('display', 'block');
            $(target).find('.album-delete').css('display', 'block');

        });

        $(document).on('mouseleave', '.album', function (e) {
            var target = e.currentTarget;

            $(target).find('.album-view').css('display', 'none');
            $(target).find('.album-delete').css('display', 'none');
        });


        /*Изменение изображения подробного просмотра альбома*/
        $(document).on('mouseenter', '.album-view-icon', function (e) {
            $(e.currentTarget).attr('src', '/img/view-active.png');
        });

        $(document).on('mouseleave', '.album-view-icon', function (e) {
            $(e.currentTarget).attr('src', '/img/view-album.png');
        });


        /*Изменение изображения удаления альбома*/
        $(document).on('mouseenter', '.album-delete-icon', function (e) {
            $(e.currentTarget).attr('src', '/img/delete-album-active.png');
        });

        $(document).on('mouseleave', '.album-delete-icon', function (e) {
            $(e.currentTarget).attr('src', '/img/delete-album.png');
        });


        /*Изменение изображения удаления изображения*/
        $(document).on('mouseenter', '.delete-gallery-image', function (e) {
            $(e.currentTarget).attr('src', '/img/delete-album-active.png');
        });

        $(document).on('mouseleave', '.delete-gallery-image', function (e) {
            $(e.currentTarget).attr('src', '/img/delete-album.png');
        });
    });

})(window.jQuery);