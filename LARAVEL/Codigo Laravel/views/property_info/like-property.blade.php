<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 06:49 PM
 *
 * @var $otros \App\Models\Propiedad[
 */

$fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
?>
<section id="like-property">

    <div class="heading">
        <h3>@lang('property_info.like_too')</h3>
    </div>

    <div class="container-fluid">
        @foreach ($otros as $propiedad)
            <?php $propiedad->init(); ?>
            @include('partials.commons.property-item')
        @endforeach
    </div>

</section>
