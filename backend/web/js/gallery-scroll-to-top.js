(function () {

    window.onscroll = function (e) {
        scrollHandler(e);
    };

    window.onload = function (e) {
        scrollHandler(e);
    };


    function scrollHandler(e) {

        // When the user scrolls down 20px from the top of the document, show the button
        if (
            document.body.scrollTop > 20 ||
            document.documentElement.scrollTop > 20
        ) {

            document.getElementById('scroll-to-top').style.display = 'block';

        } else {
            document.getElementById('scroll-to-top').style.display = 'none';
        }
    }

    this.scrollToTop = function () {
        document.body.scrollTop = 0; // For Chrome, Safari and Opera
        document.documentElement.scrollTop = 0; // For IE and Firefox
    }

})();