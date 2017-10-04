<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 06:43 PM
 *
 * @var $propiedad \App\Models\Propiedad
 */
$fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
?>

<section id="property-header">
    @include('partials.commons.main-nav')
    <div class="container-fluid page-detail">
        <div class="row">
            <div class="col-sm-1 arow-div">
                <a href="{{ url()->previous() }}" class="left-arow">
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>
            <div class="col-sm-11">
                <h2><?= $propiedad->getLabelDetail() ?> <?= $fmt->formatCurrency($propiedad->price, $propiedad->currency) ?></h2>
            </div>
        </div>
    </div>
</section>
