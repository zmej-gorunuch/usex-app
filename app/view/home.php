<?php

use library\Url;

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
            <div class="row form-section">
                <div class="col-md-7 col-sm-7 col-xs-7">
                    <a href="https://github.com/zmej-gorunuch/usex-app" target="_blank"
                       class="btn tm-btn-subscribe">Переглянути на GitHub</a>
                </div>
            </div>
            <div class="tm-social-icons-container text-xs-center">
                <a href="#" target="_blank" class="tm-social-link">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="https://github.com/zmej-gorunuch" target="_blank" class="tm-social-link">
                    <i class="fa fa-github"></i>
                </a>
                <a href="#" target="_blank" class="tm-social-link">
                    <i class="fa fa-linkedin"></i>
                </a>
                <a href="mailto:z.g-web@ukr.net" class="tm-social-link">
                    <i class="fa fa-envelope"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="footer-link">
        <p>Всі права не захистити. © 2020 UseX</p>
    </div>
</div>
