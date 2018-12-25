<?php
/*
Template Name: Contact Page
*/

/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

$settings = jakit_contactpage_settings_valid();
$siteKeyPublic = ($settings) ? $settings['sitekey'] : '__NIL__';
$classCss = ($settings) ? 'contact-block-none' : 'contact-block-error';
$controllerTxtResponse = ($settings) ? '' : 'Contact disabled';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $settings) {
    $postScore = jakit_contactpage_post_action($settings['secret'], $settings['api_url'], $settings['contact_mail']);
    $classCss = $postScore['success'] ? 'contact-block-success' : 'contact-block-error';
    $controllerTxtResponse = $postScore['txt'];
}
?>

<?php get_header(); ?>

<article class="content-article w96p mauto mbot1e">

    <div class="jakit-entry-header">
        <div class="<?= $classCss; ?>">
            <?= $controllerTxtResponse ?>
        </div>

        <h3 class="jakit-entry-title color-monochrome">
            Contact me
        </h3>
    </div>

    <hr class="jakit-separator mtop2p color-monochrome">

    <form class="form w90p mauto block" method="post">
        <textarea class="contact-block-textarea br-solid-monochrome-1 color-monochrome w100p" name="text-msg" autofocus="autofocus"></textarea>
        <div class="w100p">
            <?php if ($settings): ?>
                <!-- GOOGLE RE-CAPTCHA -->
                <div>
                    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    <div class="g-recaptcha br-solid-monochrome-1 inline-block" data-sitekey="<?= $siteKeyPublic ?>"></div>
                </div>
                <!-- GOOGLE RE-CAPTCHA -->
                <button class="br-solid-monochrome-1 color-monochrome">
                    Send
                </button>
            <?php endif ?>
        </div>
    </form>

</article>
<?php get_footer(); ?>
