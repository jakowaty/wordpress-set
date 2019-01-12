(function () {

    function unfade() {
        var workElements = document.getElementsByClassName("fadeiner");

        for (var elem in workElements) {
            // var current = workElements.item(elem);
            roll(workElements.item(elem));
        }
    }

    function roll(current) {

            setTimeout(
                function (current) {
                    console.log("Moving fade");
                    if (current.style.opacity === "") {
                        current.style.opacity = 0.0;
                    }

                    current.style.opacity = parseFloat(current.style.opacity) + 0.02;
                    if (parseFloat(current.style.opacity) <= 1.0) {
                        roll(current);
                    }
                },
                50,
                current
            );

    }

    window.onload = unfade();
})();