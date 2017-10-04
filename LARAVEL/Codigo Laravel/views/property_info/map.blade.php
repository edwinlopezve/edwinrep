<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 06:47 PM
 *
 * @var $propiedad \App\Models\Propiedad
 */

?>

@if($propiedad->latitude != null && $propiedad->longitude != null)
    <section id="map">
        <iframe src="https://www.google.com/maps/embed/v1/place?key=<?= \Illuminate\Support\Facades\Config::get('gmaps.key') ?><?= $propiedad->getQueryGMaps() ?>"
                width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
    </section>
@endif
