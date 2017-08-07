(function ($) {

    var image_container = document.getElementById('image-container');

    var sortable = Sortable.create(image_container, {

        onStart: function (event) {

            event.item.style.border = '1px solid #d8450b';
        },

        onEnd: function (event) {

            event.item.style.border = 'none';

            if (event.oldIndex === event.newIndex) {
                return;
            }

            /*Данные для отправки*/
            var jsonImages = [];

            /*Определение позиции альбома*/
            var htmlImages = image_container.getElementsByClassName('image');
            for (var i = 0; i < htmlImages.length; i++) {
                jsonImages.push({
                    "id": (htmlImages[i].getElementsByClassName('delete-image'))[0].getAttribute('data-image-id'),
                    "order_param": i
                });
            }

            /*Отправка запроса на сохранение в БД позиции альбома*/
            var request = new XMLHttpRequest();
            request.open("POST", "/index.php?r=image/update-order-position");
            request.setRequestHeader("X-Requested-With", "XMLHttpRequest");

            var csrfParam = yii.getCsrfParam();
            var csrfToken = yii.getCsrfToken();

            var formData = new FormData();
            formData.append(csrfParam, csrfToken);
            formData.append('images', JSON.stringify(jsonImages));

            request.send(formData);
        }

    });


})(window.jQuery);