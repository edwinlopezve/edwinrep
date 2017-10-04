<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 03:00 PM
 */?>
<nav id="mainNav" class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span><i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand page-scroll" href="{{ url('/')}}" class="logo-img"><img src="{!! asset('assets/images/logo_pisosclick.png') !!}"></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right header-btns">
                <li>
                    <a class="login-btn" href="https://pisos.click/admin/login">@lang('commons.navbar.login')</a>
                </li>
                <li>
                    <a class="signup-btn" href="https://pisos.click/admin/register">@lang('commons.navbar.signup')</a>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
