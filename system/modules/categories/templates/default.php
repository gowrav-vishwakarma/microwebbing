<?php

/*

type: layout

name: Default

description: List Navigation

*/

?>

<?php
    $params['ul_class'] = 'nav nav-list';
	$params['ul_class_deep'] = 'nav nav-list';
?>

<div class="category-nav category-nav-default">
	<div class="well">
		<?php  mw('category')->tree($params);  ?>
	</div>
</div>

