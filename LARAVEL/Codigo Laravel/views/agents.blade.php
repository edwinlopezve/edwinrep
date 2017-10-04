<?php
/**
 * @var $propiedades \App\Models\Propiedad[]
 * @var $controller \App\Http\Controllers\SearchController
 */

?>
<!DOCTYPE html>
<html lang="<?= $controller->getLang(); ?>">

    <head>
        <title>Properties for agent <?php echo $controller->agent_name; ?></title>
        @include('partials.commons.head')
        @include('partials.search.fonts')
        @include('partials.search.styles')
    </head>

    <body id="search-page" class="inner-page">
        @include('partials.commons.main-nav')
        @include('partials.commons.search-bar')
        
        @include('partials.search.property-list-agents')

        @include('partials.commons.footer-menu')
        @include('partials.commons.footer-scripts')
        @include('partials.search.scripts')
        @include('partials.commons.script-search')
    </body>

</html>