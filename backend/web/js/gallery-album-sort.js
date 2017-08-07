(function ($) {

    $('.album').css('cursor', 'move');

    var album_container = document.getElementById('album-container');

    var sortable = Sortable.create(album_container, {

        onStart: function (event) {

            event.item.style.border = '1px solid #d8450b';
        },

        onEnd: function (event) {

            event.item.style.border = 'none';

            if (event.oldIndex === event.newIndex) {
                return;
            }

            /*Данные для отправки*/
            var jsonAlbums = [];

            /*Определение позиции альбома*/
            var htmlAlbums = album_container.getElementsByClassName('album');
            for (var i = 0; i < htmlAlbums.length; i++) {
                jsonAlbums.push({
                    "id": (htmlAlbums[i].getElementsByClassName('album-delete'))[0].getAttribute('data-album-id'),
                    "order_param": i
                });
            }

            /*Отправка запроса на сохранение в БД позиции альбома*/
            var request = new XMLHttpRequest();
            request.open("POST", "/index.php?r=album/update-order-position");
            request.setRequestHeader("X-Requested-With", "XMLHttpRequest");

            var csrfParam = yii.getCsrfParam();
            var csrfToken = yii.getCsrfToken();

            var formData = new FormData();
            formData.append(csrfParam, csrfToken);
            formData.append('albums', JSON.stringify(jsonAlbums));

            request.send(formData);
        }

    });


})(window.jQuery);