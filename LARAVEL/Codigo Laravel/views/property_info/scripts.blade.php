<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 03/05/17
 * Time: 06:54 PM
 */?>
<script>
    jQuery(document).ready(function($) {
        $('#myCarousel').carousel({
            interval: 5000
        });
        $('#carousel-text').html($('#slide-content-0').html());
        //Handles the carousel thumbnails
        $('[id^=carousel-selector-]').click( function(){
            var id = this.id.substr(this.id.lastIndexOf("-") + 1);
            var id = parseInt(id);
            $('#myCarousel').carousel(id);
        });
        // When the carousel slides, auto update the text
        $('#myCarousel').on('slid.bs.carousel', function (e) {
            var id = $('.item.active').data('slide-number');
            $('#carousel-text').html($('#slide-content-'+id).html());
        });
        
        $.ajax({
          url: "https://api.pisos.click/Stats.php?city=<?php echo $propiedad->location_id; ?>&customer=<?php echo $propiedad->usuario_id; ?>&item=<?php echo $propiedad->id; ?>"
        }).done(function() {
        });
        
    });
</script>

