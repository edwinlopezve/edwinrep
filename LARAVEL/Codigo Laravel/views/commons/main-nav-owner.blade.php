<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 02:40 PM
 */
?>
<nav id="mainNav" class="navbar navbar-default agents-nav">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="{{ url('/')}}" class="logo-img"><img src="{!! asset('assets/images/logo_pisosclick.png') !!}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#">@lang('agents.menu.advertise')</a></li>
                <li><a href="#">@lang('agents.menu.why_kyero')</a></li>
                <li><a href="#">@lang('agents.menu.news')</a></li>
                <li><a href="#">@lang('agents.menu.market_data')</a></li>
                <li class="dropdown">
                    @if($controller->getLang() === 'en')
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">@lang('agents.menu.english') <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-lang="/es" class="navigator">@lang('agents.menu.espanol')</a></li>
                        </ul>
                    @else
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">@lang('agents.menu.espanol') <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-lang="/en" class="navigator">@lang('agents.menu.english')</a></li>
                        </ul>
                    @endif
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
