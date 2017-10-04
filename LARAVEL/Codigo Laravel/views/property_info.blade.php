<?php
/**
 * @var $propiedad \App\Models\Propiedad
 * @var $otros \App\Models\Propiedad[]
 */

?>

<!DOCTYPE html>
<html lang="<?= $controller->getLang() ?>">

    <head>
        <title><?= \Illuminate\Support\Facades\Config::get('app.name') ?>: <?= $propiedad->getLabelDetail() ?></title>
        <meta name="description" content="<?= wordwrap($propiedad->getDescription(), 20) ?>">
        @include('partials.commons.head')
        @include('partials.property_info.fonts')
        @include('partials.property_info.styles')
    </head>

    <body id="page-top">

        @include('partials.property_info.property-header')
        @include('partials.property_info.single-page-property')
        @include('partials.property_info.pro-details')
        @include('partials.property_info.map')
        @include('partials.property_info.make-enquiry')
        @include('partials.property_info.like-property')
        @include('partials.property_info.bottom-breadcrumb')
        @include('partials.commons.footer-menu')
        @include('partials.commons.footer-scripts')
        @include('partials.property_info.scripts')
    </body>

</html>
