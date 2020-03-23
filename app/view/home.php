<?php

use core\Url;

/** @var $text controller\MainController */

?>
<div id="particles-js"></div>

<ul class="cb-slideshow">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>

<div class="container-fluid">
    <div class="row cb-slideshow-text-container ">
        <div class="tm-content col-xl-6 col-sm-8 col-xs-8 ml-auto section">
            <header class="mb-5">
                <a href="<?php echo Url::home() ?>">
                    <img style="width: 300px" src="/app/view/img/usex-logo.svg" alt="UseX logo">
                </a>
            </header>
            <p class="mb-5">
                <?php echo $text; ?>
            </p>
            <form action="#" method="get" class="subscribe-form">
                <div class="row form-section">
                    <div class="col-md-7 col-sm-7 col-xs-7">
                        <input name="email" type="text" class="form-control" id="contact_email"
                               placeholder="Your Email..." required/>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-5">
                        <button type="submit" class="tm-btn-subscribe">Subscribe</button>
                    </div>
                </div>
            </form>
            <div class="tm-social-icons-container text-xs-center">
                <a href="#" class="tm-social-link"><i class="fa fa-facebook"></i></a>
                <a href="#" class="tm-social-link"><i class="fa fa-google-plus"></i></a>
                <a href="#" class="tm-social-link"><i class="fa fa-twitter"></i></a>
                <a href="#" class="tm-social-link"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-link">
        <p>Copyright © 2020 UseX</p>
    </div>
</div>
