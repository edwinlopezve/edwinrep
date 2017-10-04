<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 11:40 AM
 */
?>
<!-- footer -->
<section id="footer">
    <div class="container-fluid">
        <div class="row">
            
            <?php
                $provinces=array( "Barcelona","Girona","Lleida","Tarragona","Madrid","Málaga","Mallorca","Ibiza y Formentera","Gran Canaria","Navarra","Albacete","Alicante","Almería","Asturias","Badajoz","Burgos","Cáceres","Cádiz","Cantabria","Castellón","Ceuta y Melilla","Ciudad Real","Córdoba","Cuenca","Granada","Guadalajara","Guipúzcoa","Huelva","Huesca","Jaén","La Coruña", "La Rioja","Lanzarote", "León","Lugo","Menorca","Murcia","Ourense","Palencia","Pontevedra","Salamanca","Segovia","Sevilla","Soria","Tenerife","Teruel","Toledo","Valencia","Valladolid","Vizcaya","Zamora","Zaragoza","Álava","Ávila","Andorra","Fuerteventura","El Hierro","La Gomera","La Palma" );
            
                $random = array_rand($provinces, 32);
            ?>
            
            
            <div class="col-md-2 col-md-offset-1 col-sm-4">
                <div class="four-footer-widget">
                    <h3 class="heading">@lang('commons.footer.spanish_provinces')</h3>
                    <ul class="footer-links">
                        <?php for($x=0;$x<12;$x++) { ?>
                              <li><a href="{{ url( '/' . $controller->getLang() . "/" .$provinces[$random[$x]] ) }}"><?php echo $provinces[$random[$x]]; ?></a></li>               
                        <?php } ?>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-2 col-sm-4">
                <div class="four-footer-widget">
                    <h3 class="heading">&nbsp;</h3>
                    <ul class="footer-links">
                        <?php for($x=12;$x<24;$x++) { ?>
                              <li><a href="{{ url( '/' . $controller->getLang() . "/" .$provinces[$random[$x]] ) }}"><?php echo $provinces[$random[$x]]; ?></a></li>               
                        <?php } ?>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-2 col-sm-4">
                <div class="four-footer-widget">
                    <h3 class="heading">&nbsp;</h3>
                    <ul class="footer-links">
                        <?php for($x=24;$x<32;$x++) { ?>
                              <li><a href="{{ url( '/' . $controller->getLang() . "/" .$provinces[$random[$x]] ) }}"><?php echo $provinces[$random[$x]]; ?></a></li>               
                        <?php } ?>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-2 col-sm-6">
                <div class="second-footer-widget">
                    <h3 class="heading">Spanish Islands</h3>
                    <ul class="footer-links">
                        <li><a href="{{ url( '/' . $controller->getLang() . '/El Hierro') }}">El Hierro</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/Ibiza y Formentera') }}">Formentera</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/Fuerteventura') }}">Fuerteventura</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/Gran Canaria') }}">Gran Canaria</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/Ibiza y Formentera') }}">Ibiza</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/La Gomera') }}">La Gomera</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/Lanzarote') }}">Lanzarote</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/La Palma') }}">La Palma</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/Mallorca') }}">Mallorca</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/Menorca') }}">Menorca</a></li>
                        <li><a href="{{ url( '/' . $controller->getLang() . '/Tenerife') }}">Tenerife</a></li>
                    </ul>
                </div>
            </div><!-- second -->
            
            <div class="col-md-2 col-sm-6">
                <div class="third-footer-widget">
                    <h3 class="heading">Spanish Costas</h3>
                    <ul class="footer-links">
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Málaga/Mijas">Mijas</a></li>
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Girona/Cadaqués">Cadaqués</a></li>
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Cádiz/Cádiz">Cádiz</a></li>
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Alicante/Alicante">Alicante</a></li>
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Málaga/Marbella">Marbella</a></li>
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Málaga/Nerja">Nerja</a></li>
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Almería/Almería">Almería</a></li>
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Barcelona/Badalona">Badalona</a></li>
                        <li><a href="https://pisos.click/<?php echo $controller->getLang(); ?>/Girona/Tossa-de-Mar">Tossa del Mar</a></li>
                    </ul>
                </div>
            </div><!-- thirst -->

        </div><!-- row --->
    </div><!-- container--->

</section><!-- / footer --->
