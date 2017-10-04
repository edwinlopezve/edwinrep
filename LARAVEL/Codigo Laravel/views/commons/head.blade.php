<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="">

<link rel="apple-touch-icon" sizes="180x180" href="{!! asset('assets/images/favicon//apple-touch-icon.png') !!}">
<link rel="icon" type="image/png" href="{!! asset('assets/images/favicon//favicon-32x32.png" sizes="32x32') !!}">
<link rel="icon" type="image/png" href="{!! asset('assets/images/favicon//favicon-16x16.png" sizes="16x16') !!}">
<link rel="manifest" href="{!! asset('assets/images/favicon//manifest.json') !!}">
<link rel="mask-icon" href="{!! asset('assets/images/favicon//safari-pinned-tab.svg') !!}" color="#5bbad5">
<meta name="theme-color" content="#ffffff">
<?php
	$uri_var = $_SERVER['REQUEST_URI'];
	$new_uri = str_replace('/en/','/es/',$uri_var);
	$new_uri_en = str_replace('/es/','/en/',$uri_var);
?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>

<link rel="alternate" hreflang="en" href="<?php echo 'https://pisos.click'.$new_uri_en; ?>">
<link rel="alternate" hreflang="es" href="<?php echo 'https://pisos.click'.$new_uri; ?>">

<!-- Bootstrap Core CSS -->
<link href="{!! asset('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-formhelpers/2.3.0/css/bootstrap-formhelpers.min.css" />

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<!-- Plugin CSS -->
<!--
<link href="{!! asset('assets/magnific-popup/magnific-popup.css') !!}" rel="stylesheet">-->

<!-- Theme CSS -->
<link href="{!! asset('assets/css/creative.css') !!}" rel="stylesheet">
<link href="{!! asset('assets/JQuery-autoComplete/jquery.auto-complete.css') !!}" rel="stylesheet">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script>
    window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#eaf7f7",
                    "text": "#5c7291"
                },
                "button": {
                    "background": "#56cbdb",
                    "text": "#ffffff"
                }
            },
            "position": "top",
            "static": true,
            "content": {
                "message": "<?= trans('commons.cookies.msj') ?>",
                "dismiss": "<?= trans('commons.cookies.got_it') ?>",
                "href": "www.pisos.click/cookiespolicies"
            }
        })});
</script>
