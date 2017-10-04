<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 02/05/17
 * Time: 11:19 PM
 */
?>

<!-- jQuery -->
<script src="{!! asset('assets/jquery/jquery.min.js') !!}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{!! asset('assets/bootstrap/js/bootstrap.min.js') !!}"></script>

<!-- Plugin JavaScript -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="vendor/scrollreveal/scrollreveal.min.js"></script>
 <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script> 

<!-- Theme JavaScript -->
<script src="{!! asset('assets/scrollreveal/scrollreveal.min.js') !!}"></script>
<script src="{!! asset('assets/magnific-popup/jquery.magnific-popup.min.js') !!}"></script>
<!--<script src="{!! asset('assets/typeahead/dist/typeahead.bundle.min.js') !!}"></script>-->
<script src="{!! asset('assets/JQuery-autoComplete/jquery.auto-complete.min.js') !!}"></script>
<script src="{!! asset('assets/js/creative.js') !!}"></script>
	<script>

$( "#estate" ).click(function() {
  $("#estate_content").show();
  $("#vistor_content").hide();
});

</script>
	<script>

$( "#vistor" ).click(function() {
  $("#estate_content").hide();
  $("#vistor_content").show();
});

					</script>					
<script>
    $(document).ready(function () {
        console.log($('.cc-link'))
        $('.cc-link').each(function () {
            console.log(this);
            $(this).text("<?= trans('commons.cookies.learn_more'); ?>");
        });
    })
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-32096442-10', 'auto');
  ga('send', 'pageview');

</script>
