<?php
/**
 * Created by PhpStorm.
 * User: edwin
 * Date: 04/05/17
 * Time: 09:37 AM
 */
?>

<style>

    img.ri {
        position: absolute;
        height: 550px;
    }

    img.ri:empty {
        top: 50%;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -o-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    @media screen and (orientation: portrait) {
        img.ri { max-width: 90%; }
    }

    @media screen and (orientation: landscape) {
        img.ri { max-height: 90%; }
    }
</style>

