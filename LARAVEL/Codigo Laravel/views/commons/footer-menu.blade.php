<?php
/**
 * Created by PhpStorm.
 * User: Edwin
 * Date: 03/05/17
 * Time: 11:37 AM
 *
 * @var $controller \App\Http\Controllers\Controller
 */
use \App\Http\Controllers\Controller;
?>
<section id="footer-menu">
    <div class="container-fluid">
        <div class="row">
            <ul class="footer-menu-link">
                <li><a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_FOR_SALE) )}}">@lang('commons.footer_menu.for_sale')</a></li>
                <li><a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_TO_RENT) )}}">@lang('commons.footer_menu.to_rent')</a></li>
                <li><a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_HELP) )}}">@lang('commons.footer_menu.help')</a></li>
                <li><a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_AGENTS) )}}">@lang('commons.footer_menu.agents')</a></li>
                <li><a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_ADVERTISE) )}}">@lang('commons.footer_menu.advertise')</a></li>
                <li><a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_SITEMAP) )}}">@lang('commons.footer_menu.sitemap')</a></li>
                <li><a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_TERMS) )}}">@lang('commons.footer_menu.legal')</a></li>
                <li><a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_CONTACT_US) )}}">@lang('commons.footer_menu.contact_us')</a></li>
            </ul>
            <div id="copyright" style="color: white; text-align: right; padding-right: 45px;">&copy; 2017 Cloudpro Networks S.L.</div>
        </div>
    </div>
</section>


<li>
<a href="{{ url( '/' . $controller->getLang() . '/' . $controller->getSpecialURL(Controller::URL_FOR_SALE) )}}">
    @lang('commons.footer_menu.for_sale')</a>
</li>