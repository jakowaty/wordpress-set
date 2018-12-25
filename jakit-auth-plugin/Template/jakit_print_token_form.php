<?php

/**
 * @Package Jakit Auth Plugin
 * @Version 1.0
 * @Description Verry simple two factor auth login just for personal use
 * @Author Piotr B. herbalist@herbalist.hekko24.pl
 */

return <<<FORM
    <article class="content-article w65p mauto mbot1e">
        
        <div class="jakit-entry-header">
            <div>$message</div>
            
            <h3 class="jakit-entry-title color-monochrome">
                Confirm login with SMS code
            </h3>
        </div>
        
        <hr class="jakit-separator mtop2p color-monochrome">
        
    
        <form name="codeform" action="" class="codeform txt-cnt" method="post">    
            
            <div class="w100p">    
                <input type="text" class="jakit_user_token-input w98p h3em br-solid-monochrome-1 txt-cnt " name="jakit_user_token" value="" autofocus/>
                <button type="submit" class="jakit_user_token-button w98p h3em br-solid-monochrome-1 bg-monochrome color-white">Send</button>
            </div>
            
        </form>
        
    </article>
FORM;
