<?php
add_filter('idc_protect_terms', 'add_project_category_protection');

function add_project_category_protection($terms) {
	$terms[] = 'project_category';
	return $terms;
}
?>