<?php

$output->post_check();
ob_start();
global $page, $output, $data, $cat, $mod,$conf;
?>


<div id="YMapsID" style="width:220px;height:300px"></div>

<script type="text/javascript">
window.onload = function () {
        var map = new YMaps.Map(YMaps.jQuery("#YMapsID")[0]);
        map.setCenter(new YMaps.GeoPoint(30.232406,59.946266),14);
	map.openBalloon(new YMaps.GeoPoint(30.232406, 59.946266), "Арктикa", {maxWidth:100});
    };
</script>

<?
$page[] = ob_get_contents();
ob_end_clean();
?>
