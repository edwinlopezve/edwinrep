<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 06:50 PM
 *
 * @var $controller \App\Http\Controllers\Controller
 */?>
<section id="bottom-breadcrumb">
    <div class="container-fluid">
        <div class="row">
            <div class="bread-crumb">
                <ul>
                    <li><a href="#">Spain</a>&gt;</li>
                    <?= $controller->getBreadcrum() ?>
                </ul>
            </div>
        </div>
    </div>
</section>
