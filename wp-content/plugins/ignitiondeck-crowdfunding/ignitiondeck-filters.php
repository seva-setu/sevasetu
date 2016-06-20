<?php
/**
Project Filters
*/

/**
 * The filter to format the currency display anywhere for project
 * @param integer $amount The amount to be formatted
 * @param integer $post_id The post id of the project
 */
function id_funds_raised($amount, $post_id) {
	return apply_filters('id_price_format', $amount, $post_id);
}
add_filter('id_funds_raised', 'id_funds_raised', 100, 2);

/**
 * Filter for Percentage pledged for a project
 * @param double  $percentage The percentage value of the project goal
 * @param double  $pledged 		  Pledged of project
 * @param integer $post_id 		  Post ID of the project
 * @param double  $goal 		  Total Goal for the project
 */
function id_percentage_raised($percentage, $pledged, $post_id, $goal) {
	return apply_filters('id_percentage_format', $percentage);
}
add_filter('id_percentage_raised', 'id_percentage_raised', 100, 4);

/**
 * The filter to format the currency display anywhere for project
 * @param integer $goal The amount to be formatted
 * @param integer $post_id The post id of the project
 */
function id_project_goal($goal, $post_id) {
	return apply_filters('id_price_format', $goal, $post_id);
}
add_filter('id_project_goal', 'id_project_goal', 100, 2);

/**
 * The filter to format the currency display anywhere for project
 * @param integer $pledges The amount to be formatted
 * @param integer $post_id The post id of the project
 */
function id_number_pledges($pledges, $post_id) {
	return apply_filters('id_number_format', $pledges);
}
add_filter('id_number_pledges', 'id_number_pledges', 100, 2);

/**
 * The filter to format the currency display anywhere for project
 * @param integer $amount The amount to be formatted
 * @param integer $post_id The post id of the project
 */
function id_price_selection($amount, $post_id) {
	return apply_filters('id_price_format', $amount, $post_id);
}
add_filter('id_price_selection', 'id_price_selection', 100, 2);

/**
General Filters
*/

/**
 * The filter to format the currency display anywhere for project
 * @param integer $amount  The amount to be formatted
 * @param integer $post_id The post id of the project
 */
function id_price_format($amount, $post_id) {
	// Getting the currency of the project, first getting project id if currency code is not coming in the arguments
	$project_id = get_post_meta($post_id, 'ign_project_id', true);
	// Now getting currency
	$project = new ID_Project($project_id);
	$currency_code = apply_filters('id_display_currency', $project->currency_code());

	// Formatting the amount with currency code
	if ($amount > 0) {
		$amount = number_format($amount, 2, '.', ',');
	}
	//$amount = apply_filters('id_price_total_selection', $amount, $post_id);
	return $currency_code.$amount;
}
add_filter('id_price_format', 'id_price_format', 10, 2);

function id_number_format($number) {
	if ($number > 0) {
		$number = number_format($number);
	}
	return $number;
}
add_filter('id_number_format', 'id_number_format');

/**
 * Filter for Percentage pledged for a project
 * @param double  $percentage The percentage value of the project goal
 */
function id_percentage_format($percentage) {
	return ($percentage > 0 ? number_format($percentage, 2) : '0');
}
add_filter('id_percentage_format', 'id_percentage_format');

/**
Parent/Child Filters
*/

/**
 * The filter to format the currency display anywhere for project
 * @param integer $amount  The amount of the project
 * @param integer $post_id The post id of the project
 */
function filter_total_currency_display($amount, $post_id) {
	// Getting the children projects if any to add the total in $amount
	$project_children = get_post_meta($post_id, 'ign_project_children', true);
	// this has been applied in the wrong place
	if (!empty($project_children)) {
		$total_children_fund = 0;
		foreach ($project_children as $child_project) {
			$child_project_id = get_post_meta($child_project, 'ign_project_id', true);
			$deck = new Deck($child_project_id);
			$the_deck = $deck->the_deck();
			$total_children_fund += $the_deck->p_current_sale;
		}
		$amount += $total_children_fund;
	}
	
	// $amount = apply_filters('id_price_selection', $amount, $post_id);
	return $amount;
}
//add_filter('id_price_total_selection', 'filter_total_currency_display', 10, 2);

/**
 * The filter to format the currency display anywhere for project
 * @param integer $amount  The amount to be formatted
 * @param integer $post_id The post id of the project
 */
function filter_goal_currency_display($goal, $post_id) {
	// Getting the currency of the project, first getting project id if currency code is not coming in the arguments
	$project_id = get_post_meta($post_id, 'ign_project_id', true);
	// Now getting currency
	$project = new ID_Project($project_id);
	$currency_code = apply_filters('id_display_currency', $project->currency_code());

	// Formatting the goal amount with currency code
	if ($goal > 0) {
		$goal = number_format($goal, 2, '.', ',');
	}
	$goal = apply_filters('id_project_total_goal', $goal, $post_id);
	return $currency_code.$goal;
}
//add_filter('id_project_goal', 'filter_goal_currency_display', 10, 2);

/**
 * The filter to format the currency display anywhere for project
 * @param integer $amount  The amount to be formatted
 * @param integer $post_id The post id of the project
 */
function filter_total_goal_display($goal, $post_id) {
	// Getting the children projects if any to add the total in $goal
	$project_children = get_post_meta($post_id, 'ign_project_children', true);
	// this has not yet been properly implemented
	if (!empty($project_children)) {
		$total_children_goal = 0;
		foreach ($project_children as $child_project) {
			$child_project_id = get_post_meta($child_project, 'ign_project_id', true);
			$deck = new Deck($child_project_id);
			$the_deck = $deck->the_deck();
			$total_children_goal += $the_deck->project->goal;
		}
		$goal += $total_children_goal;
	}
	// $goal = apply_filters('id_project_goal', $goal, $post_id);
	return $goal;
}
//add_filter('id_project_total_goal', 'filter_total_goal_display', 10, 2);

/**
 * Filter to show the number of pledgers of a project and its children
 */
function filter_id_number_pledges($pledgers, $post_id) {
	// Getting the children projects if any to add the total in $amount
	$project_children = get_post_meta($post_id, 'ign_project_children', true);
	$total_children_pledgers = 0;
	if (!empty($project_children)) {
		foreach ($project_children as $child_project) {
			$child_project_id = get_post_meta($child_project, 'ign_project_id', true);
			$deck = new Deck($child_project_id);
			$the_deck = $deck->the_deck();
			$total_children_pledgers += (($the_deck->p_count->p_number != "" || $the_deck->p_count->p_number != 0) ? $the_deck->p_count->p_number : 0);
		}
	}
	$pledgers += $total_children_pledgers;
	return $pledgers;
}
//add_filter('id_number_pledges', 'filter_id_number_pledges', 10, 2);

/**
 * Filter for Percentage pledged for a project
 * @param double  $rating_percent The percentage value of the project goal
 * @param double  $pledged 		  Pledged of project
 * @param integer $post_id 		  Post ID of the project
 * @param double  $goal 		  Total Goal for the project
 */
function filter_id_percentage_raised($rating_percent, $pledged, $post_id, $goal) {
	// Getting the children projects if any to add the total in $amount
	$project_children = get_post_meta($post_id, 'ign_project_children', true);
	$total_children_goal = 0;
	$total_children_pledged = 0;
	if (!empty($project_children)) {
		foreach ($project_children as $child_project) {
			$child_project_id = get_post_meta($child_project, 'ign_project_id', true);
			$deck = new Deck($child_project_id);

			$the_deck = $deck->the_deck();
			$total_children_goal += $the_deck->project->goal;
			$total_children_pledged += $the_deck->p_current_sale;
			// $total_percent += $the_deck->rating_per;
		}
	}
	// Calculating the new percentage with children
	$total_percent = ($total_children_pledged + $pledged) / ($total_children_goal + $goal) * 100;
	return $total_percent;
}
//add_filter('id_percentage_raised', 'filter_id_percentage_raised', 10, 4);
?>