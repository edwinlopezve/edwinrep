<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 05:20 PM

 */


function getValue($key){
    return isset($_GET[$key]) ? $_GET[$key] : '';
}

$value_money = [0, 100000, 250000, 500000, 1000000, 5000000];
$value_type = ["Adosados", "Aticos", "Bungalows", "Casa de pueblo", "Chalets Independientes",
                "Duplex", "Locales Comerciales", "Naves Industriales", "Oficinas", "Pisos", "Solar urbano", "Terrenos"];
$value_beds = [
        [1, "1 " . trans('commons.searchbar.bedroom')],
        [2, "2 " . trans('commons.searchbar.bedrooms')],
        [3, "3 " . trans('commons.searchbar.bedrooms')],
        [4, "4 " . trans('commons.searchbar.bedrooms')],
        [100, trans('commons.searchbar.more_than_4_bedrooms')]
];

$value_baths = [
        [1, "1 " . trans('commons.searchbar.bathroom')],
        [2, "2 " . trans('commons.searchbar.bathrooms')],
        [3, "3 " . trans('commons.searchbar.bathrooms')],
        [4, "4 " . trans('commons.searchbar.bathrooms')],
        [100, trans('commons.searchbar.more_than_4_bathrooms')]
];

$value_search = getValue('search');
$value_min_price = getValue('min-price');
$value_max_price = getValue('max-price');
$value_property_type = getValue('property-type');
$value_bedrooms = getValue('bedrooms');
$value_bathrooms = getValue('bathrooms');
$value_pool = isset($_GET['pool']);
$value_new_build = isset($_GET['new_build']);
?>
<div class="navbar navbar-default searchnav">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <p class="pull-left top-input">
                <input type="text" class="form-control" placeholder="Search"></p>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#searchmenu" aria-expanded="false">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="searchmenu">
            <form id="formulario" class="navbar-form navbar-left" action="{{ url( '/' . $controller->getLang() . '/' . $controller->getFuncionality())}}" method="get">
                <div id="prefetch" class="form-group searchbox">
                    <input type="text" id="search" class="form-control" placeholder="Search" value="<?= $controller->getLabelSearch() ?>">
                </div>

                <input type="hidden" name="type" value="<?= $controller->getMode() ?>" />

                <select class="form-control min-price" name="min-price">
                    <option value="-1">@lang('commons.searchbar.min_price')</option>
                    @foreach($value_money as $value)
                        <option value="<?= $value ?>" <?php echo $value_min_price!=='' && $value_min_price == $value? 'selected' : '' ?>>€ <?= $value ?></option>
                    @endforeach
                </select>
                @lang('commons.searchbar.to')
                <select class="form-control max-price" name="max-price">
                    <option value="-1">@lang('commons.searchbar.max_price')</option>
                    @foreach($value_money as $value)
                        <option value="<?= $value ?>"  <?php echo $value_min_price!=='' && $value_max_price == $value? 'selected' : '' ?>>€ <?= $value ?></option>
                    @endforeach
                </select>

                <select class="form-control property-type" name="property-type">
                    <option value="">@lang('commons.searchbar.property_type')</option>
                    <!--<option>Cave house</option>
                    <option>Wooden home</option>
                    <option>Country house</option>
                    <option>Land</option>-->
                    @foreach($value_type as $value)
                        <option value="<?= $value ?>"  <?php echo $value_property_type == $value? 'selected' : '' ?>><?= $value ?></option>
                    @endforeach

                </select>

                <select class="form-control bedrooms" name="bedrooms">
                    <option value="-1">@lang('commons.searchbar.bedrooms')</option>
                    @foreach($value_beds as $value)
                        <option value="<?= $value[0] ?>"  <?php echo $value_bedrooms == $value[0]? 'selected' : '' ?>><?= $value[1] ?></option>
                    @endforeach
                </select>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle more-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">@lang('commons.searchbar.more')<span class="caret"></span></a>
                        <ul class="dropdown-menu more-menu">
                            <select class="form-control bedrooms" name="bathrooms">
                                <option value="-1">@lang('commons.searchbar.bathrooms')</option>
                                @foreach($value_baths as $value)
                                    <option value="<?= $value[0] ?>"  <?php echo $value_bathrooms == $value[0]? 'selected' : '' ?>><?= $value[1] ?></option>
                                @endforeach
                            </select>

                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="pool" <?php echo $value_pool ? "checked" : "" ?>>@lang('commons.searchbar.swimming_pool')
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="new_build" <?php echo $value_new_build ? "checked" : "" ?>>@lang('commons.searchbar.new_build')
                                </label>
                            </div>
                            <li role="separator" class="divider"></li>
                            <li class="search-by"><a href="#">@lang('commons.searchbar.search_by_property_reference')</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="view-pro"><a href="#">@lang('commons.searchbar.view_properties_to_rent_in_balearic_island')</a></li>

                        </ul>
                    </li>
                    <li><button name="normal_button" type="submit" value="true" class="btn btn-default search-btn" id="search">@lang('commons.searchbar.search')</button></li>
                </ul>
                <input name="page" value="1" type="hidden" />
                <input name="size" value="10" type="hidden" />
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</div>
