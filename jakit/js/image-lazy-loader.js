(function () {
    'use strict';

    function jakitImgll(classes, defaultsrc) {
        classes.forEach(
            (val, index, object) => {
                var images = document.getElementsByClassName(val);

                if (images.length === 0) {
                    return false;
                }

                for (var imgIndex in images) {
                    var currentItem = images.item(imgIndex);
                    if (currentItem.src.indexOf(defaultsrc) === -1) {
                        continue;
                    }

                    currentItem.src = currentItem.getAttribute('data-src');
                }
            }
        );
    }

    window.onload = function () {
        while (true) {
            var docStr = document.documentElement.innerHTML;
            if (typeof docStr === "string") {
                if (docStr.indexOf('</body>') !== -1) {
                    jakitImgll(['jakit-loadable-image'], 'default_img.jpg');
                    break;
                }
            }
        }
    }

})();