<?php if (!jakit_has_cookie_info()): ?>
    <div class="w100p zindex100 pfixed cookie-info mauto color-white">
        <div class="br-solid-white-1 pabsolute cookie-closer">X</div>
        <div class="cookie-info-text w100p txt-cnt">
            This <u>web site uses cookies</u> to deliver content.
        </div>
    </div>
    <script>
        document.getElementsByClassName("cookie-closer").item(0).addEventListener('click', function () {
            let date = new Date();
            let expireTime = date.getTime() + 1000*360000;

            date.setTime(expireTime);

            document.getElementsByClassName("cookie-info").item(0).style.display = 'none';
            document.cookie = "cookie_info=yes;path=/;expires='" + date.toUTCString() + "'";
        });
    </script>
<?php endif ?>