<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 04/05/17
 * Time: 04:27 PM
 *
 * @var $propiedad \App\Models\Propiedad
 * @var $controller \App\Http\Controllers\Controller
 */
?>

<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="property-content">
        <a href="{{ url( '/' . $controller->getLang() . '/' . $propiedad->getLinkPropiedad()) }}"
           style="background-image: url(<?= $propiedad->getFirstImageThumb() ?>);">
            <div class="pro-img">
            </div>
            <div class="pro-data">
                <span class="label-featured label label-success">@lang('commons.property_item.featured')</span>
                <span class="label-featured label label-color-129">@lang('commons.property_item.discount')</span>
            </div>
        </a>
    </div>
    <div class="product-details">
        <div class="pro-info">
            <h4 class="title"><?= ucfirst($propiedad->type) . ", " . $propiedad->town ?><span
                        class="price pull-right"><?= $fmt->formatCurrency($propiedad->price, $propiedad->currency) ?></span>
            </h4>
            <p class="text-content"
               style="height: 5em; overflow: hidden;"><?= $propiedad->getDescripcionExcerpt() ?></p>
            <div class="pull-right  icons">
                <ul class="actions">
                    <li>
                        <span data-placement="top" data-toggle="tooltip" data-original-title="Favorite">
                            <span class="add_fav" data-toggle="tooltip"
                                  data-original-title="@lang("commons.property_item.favorite")"
                                  data-propid="395"><i class="fa fa-heart-o"></i>
                            </span>
                        </span>
                    </li>
                    <li>
                        <span data-toggle="tooltip" data-placement="top" title=""
                              data-original-title="<?= $propiedad->getLabelTotal() ?>">
                            <i class="fa fa-camera"></i>
                        </span>
                    </li>
                    <li>
                        <span id="compare-link-395" class="compare-property" data-propid="395"
                              data-toggle="tooltip" data-placement="top" title=""
                              data-original-title="@lang("commons.property_item.compare")">
                            <i class="fa fa-plus"></i>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

