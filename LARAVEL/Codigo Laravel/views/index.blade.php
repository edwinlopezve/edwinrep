<?php
/**
 * @var $propiedades \App\Models\Propiedad[]
 * @var $controller \App\Http\Controllers\IndexController
 */
?>
 
<!DOCTYPE html>
<html lang="<?= $controller->getLang(); ?>">

    <head>
<title><?= \Illuminate\Support\Facades\Config::get('app.name'); ?>: @lang('index.header.estate_msj')</title>
        @include('partials.commons.head')
        @include('partials.index.fonts')
        @include('partials.index.styles')
    </head>

    <body id="page-top">
    	<?php $controller->getLang(); ?>
        @include('partials.index.header')
        @include('partials.index.portafolio')
        @include('partials.index.feature_properties')
        @include('partials.index.spanish_property_content')
        @include('partials.commons.footer')
        @include('partials.commons.languages')
        @include('partials.commons.footer-menu')
        @include('partials.commons.footer-scripts')
        @include('partials.index.script-search')
        
    </body>

</html>