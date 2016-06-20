<?php
	if (isset($_GET['purchaseform']) && $_GET['purchaseform'] == 500) {
		if (function_exists('is_id_licensed') && is_id_licensed()) {
			get_template_part('project', 'purchase-form');
		}
		else {
			global $post;
			$post_id = $post->ID;
			$project_id = get_post_meta($post_id, 'ign_project_id', true);
			apply_filters('id_project_content', get_template_part('project','content'), $project_id);
		}
	}
	else if (isset($_GET['purchaseform']) && $_GET['purchaseform'] == 1) {
		if (function_exists('is_id_licensed') && is_id_licensed()) {
			get_template_part('project', 'purchase-form');
		}
		else {
			global $post;
			$post_id = $post->ID;
			$project_id = get_post_meta($post_id, 'ign_project_id', true);
			apply_filters('id_project_content', get_template_part('project','content'), $project_id);
		}
	}
	else if ( is_front_page() ) {
		get_template_part('project', 'summary');
	}
	else if ( is_home() || is_archive() || is_search()) {
		get_template_part('project','summary');
	}
	else if (is_page_template('page-grid-template.php')) {
		get_template_part('project', 'summary');
	}
	else if (is_single()) {
		global $post;
		$post_id = $post->ID;
		$project_id = get_post_meta($post_id, 'ign_project_id', true);
		apply_filters('id_project_content', get_template_part('project','content'), $project_id);
	}
	else  {
		the_content(); 
	}
?>