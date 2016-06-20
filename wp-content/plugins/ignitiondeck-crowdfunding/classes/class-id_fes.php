<?php
/*
Things we will need
user info (before or after reg?)
*/

/*
Meta Keys:

FAQ
Update
T&C

*/
class ID_FES {

	var $form;
	var $vars;

	function __construct($form = null, $vars = null) {
		if (empty($form)) {
			$this->form = array(
				array(
					'before' => '<div class="fes_section"><h3>'.apply_filters('fes_team_information_label', __('Team Information', 'ignitiondeck')).'</h3>',
					'label' => __('Company Name', 'ignitiondeck'),
					'value' => (isset($vars['company_name']) ? $vars['company_name'] : ''),
					'name' => 'company_name',
					'id' => 'company_name',
					'type' => 'text',
					'class' => 'required',
					'wclass' => 'form-row half left'
				),
				array(
					'label' => __('Company Logo', 'ignitiondeck'),
					'value' => (isset($vars['company_logo']) ? $vars['company_logo'] : ''),
					'misc' => (isset($vars['company_logo']) ? 'data-url="'.$vars['company_logo'].'" accept="image/*"' : 'accept="image/*"'),
					'name' => 'company_logo',
					'id' => 'company_logo',
					'type' => 'file',
					'wclass' => 'form-row half',
					),
				array(
					'label' => __('Company Location', 'ignitiondeck'),
					'value' => (isset($vars['company_location']) ? $vars['company_location'] : ''),
					'name' => 'company_location',
					'id' => 'company_location',
					'type' => 'text',
					'class' => 'required',
					'wclass' => 'form-row half left'
				),
				array(
					'label' => __('Company URL', 'ignitiondeck'),
					'value' => (isset($vars['company_url']) ? $vars['company_url'] : ''),
					'name' => 'company_url',
					'id' => 'company_url',
					'type' => 'text',
					'class' => 'required',
					'wclass' => 'form-row half'
				),
				array(
					'label' => __('Company Facebook', 'ignitiondeck'),
					'value' => (isset($vars['company_fb']) ? $vars['company_fb'] : ''),
					'name' => 'company_fb',
					'id' => 'company_fb',
					'type' => 'text',
					'class' => '',
					'wclass' => 'form-row half left'
				),
				array(
					'label' => __('Company Twitter', 'ignitiondeck'),
					'value' => (isset($vars['company_twitter']) ? $vars['company_twitter'] : ''),
					'name' => 'company_twitter',
					'id' => 'company_twitter',
					'type' => 'text',
					'class' => '',
					'wclass' => 'form-row half',
					'after' => '</div>'
				)
			);
			$this->form[] = array(
				'before' => '<div class="fes_section"><h3>'.apply_filters('fes_project_information_label', __('Project Information', 'ignitiondeck')).'</h3>',
				'label' => __('Project Title', 'ignitiondeck'),
				'value' => (isset($vars['project_name']) ? $vars['project_name'] : ''),
				'name' => 'project_name',
				'id' => 'project_name',
				'type' => 'text',
				'class' => 'required',
				'wclass' => 'form-row twothird left'
				);
			if (empty($vars['status']) || strtoupper($vars['status']) !== 'PUBLISH') {	
				$this->form[] = array(
						'label' => __('Goal Amount', 'ignitiondeck'),
						'value' => (isset($vars['project_goal']) ? $vars['project_goal'] : ''),
						'name' => 'project_goal',
						'id' => 'project_goal',
						'type' => 'number',
						'class' => 'required',
						'wclass' => 'form-row third'
						);
				$args = array(
					'type' => 'ignition_product',
					'taxonomy' => 'project_category',
					'hide_empty' => false
				);
				$categories = get_categories($args);
				$cat_form = array(
					'label' => 'Project Category',
					'value' => (isset($vars['project_category']) ? $vars['project_category'] : ''),
					'name' => 'project_category',
					'id' => 'project_category',
					'type' => 'select',
					'wclass' => 'form-row pretty_dropdown'
				);
				$cat_options = array();
				foreach ($categories as $category) {
					$cat_options[] = array('value' => $category->slug, 'title' => $category->name);
					//$cat_form['misc'] = (isset($vars['project_category']) && $vars['project_category'] == $category->slug ? 'selected="selected"' : null);
				}
				$cat_form['options'] = $cat_options;
				$this->form[] = $cat_form;
				$this->form[] = array(
						'label' => __('Start Date', 'ignitiondeck'),
						'value' => (isset($vars['project_start']) ? $vars['project_start'] : ''),
						'name' => 'project_start',
						'id' => 'project_start',
						'type' => 'text',
						'class' => 'required date',
						'wclass' => 'form-row third left'
						);
				$this->form[] = array(
						'label' => __('End Date', 'ignitiondeck'),
						'value' => (isset($vars['project_end']) ? $vars['project_end'] : ''),
						'name' => 'project_end',
						'id' => 'project_end',
						'type' => 'text',
						'class' => 'required date',
						'wclass' => 'form-row third left'
						);
				$this->form[] = array(
						'label' => __('Anticipated Ship Date', 'ignitiondeck'),
						'value' => (isset($vars['project_ship_date']) ? $vars['project_ship_date'] : ''),
						'name' => 'project_ship_date',
						'id' => 'project_ship_date',
						'type' => 'text',
						'class' => 'date',
						'wclass' => 'form-row third'
						);
				if (isset($vars['project_fund_type'])) {
					$this->form[] = array(
						'label' => __('Project Fund Type', 'ignitiondeck'),
						'name' => 'project_fund_type',
						'id' => 'project_fund_type',
						'type' => 'select',
						'wclass' => 'form-row pretty_dropdown',
						'after' => '</div>',
						'options' => apply_filters('ide_fund_options', array(
							array('value' => 'capture', 'title' => 'Immediately Deliver Funds', 'misc' => ($vars['project_fund_type'] == 'preauth' ? 'disabled="disabled"' : '')), 
							array('value' => 'preauth', 'title' => '100% Threshold', 'misc' => ($vars['project_fund_type'] == 'capture' || $vars['project_fund_type'] == 'c_sub' ? 'disabled="disabled"' : '')),))
						);
				}

				/*foreach ($fund_type_form['options'] as $options) {
					$fund_type_form['misc'] = (isset($vars['project_fund_type']) && $vars['project_fund_type'] == $options['value'] ? 'selected="selected"' : null);
				}

				$this->form[] = $fund_type_form;*/
					/*array(
						'before' => '<div class="form-row half"><h3>Project Type</h3>',
						'label' => __('Level Based', 'ignitiondeck'),
						'name' => 'project_type',
						'id'	=> 'level-based',
						'type' => 'radio',
						'value' => 'level-based',
						'wclass' => 'half radio',
						'misc' => 'checked="checked"'
						),
					array(
						'label' => __('Pledge What You Want', 'ignitiondeck'),
						'name' => 'project_type',
						'id'	=> 'pwyw',
						'type' => 'radio',
						'value' => 'pwyw',
						'wclass' => 'half radio',
						'after' => '</div>'
						),*/
				$this->form[] = array(
						'before' => '<div class="fes_section"><div class="form-row half"><h3>'.apply_filters('fes_campaign_end_options_label', __('Campaign End Options', 'ignitiondeck')).'</h3>',
						'label' => __('Close on End', 'ignitiondeck'),
						'name' => 'project_end_type',
						'id'	=> 'closed',
						'type' => 'radio',
						'value' => 'closed',
						'wclass' => 'half radio',
						'misc' => ((isset($vars['project_end_type']) && $vars['project_end_type'] == 'closed') || !isset($vars['project_end_type']) ? 'checked="checked"' : '')
						);
				$this->form[] = array(
						'label' => __('Leave Open', 'ignitiondeck'),
						'name' => 'project_end_type',
						'id' => 'open',
						'type' => 'radio',
						'value' => 'open',
						'wclass' => 'half radio',
						'misc' => (isset($vars['project_end_type']) && $vars['project_end_type'] == 'open' ? 'checked="checked"' : ''),
						'after' => '</div>'
						);
			}
			$this->form[] = array(
					'before' => '</div>'
					);
			$this->form[] = array(
					'before' => '<div class="fes_section"><h3>'.apply_filters('fes_project_details_label', __('Project Details', 'ignitiondeck')).'</h3>',
					'label' => __('Project Short Description', 'ignitiondeck'),
					'value' => (isset($vars['project_short_description']) ? $vars['project_short_description'] : ''),
					'name' => 'project_short_description',
					'id' => 'project_short_description',
					'type' => 'text',
					'class' => 'required',
					'wclass' => 'form-row'
					);
			$this->form[] = array(
				'label' => __('Project Video', 'ignitiondeck'),
				'value' => (isset($vars['project_video']) ? $vars['project_video'] : ''),
				'name' => 'project_video',
				'id' => 'project_video',
				'type' => 'textarea',
				'wclass' => 'form-row'
			);
			$this->form[] = array(
					'label' => __('Project Long Description', 'ignitiondeck'),
					'value' => (isset($vars['project_long_description']) ? $vars['project_long_description'] : ''),
					'name' => 'project_long_description',
					'id' => 'project_long_description',
					'type' => 'wpeditor',
					'wclass' => 'form-row wpeditor',
					'class' => 'required'
					);
			$this->form[] = array(
					'label' => __('Project FAQ', 'ignitiondeck'),
					'value' => (isset($vars['project_faq']) ? $vars['project_faq'] : ''),
					'name' => 'project_faq',
					'id' => 'project_faq',
					'type' => 'wpeditor',
					'after' => '</div>',
					'wclass' => 'form-row wpeditor'
					);
			if (isset($vars['status']) && strtoupper($vars['status']) == 'PUBLISH') {
				$this->form[] = array(
						'before' => '<div class="fes_section">'
						);
				$this->form[] = apply_filters('fes_updates_before', null);
				$this->form[] = apply_filters('fes_updates_form', array(
						'label' => __('Project Updates', 'ignitiondeck'),
						'value' => (isset($vars['project_updates']) ? $vars['project_updates'] : ''),
						'name' => 'project_updates',
						'id' => 'project_updates',
						'type' => 'wpeditor',
						'wclass' => 'form-row wpeditor'
						));
				$this->form[] = apply_filters('fes_updates_after', null);
				$this->form[] = array(
						'after' => '</div>'
						);
			}
			$this->form[] = array(
					'before' => '<div class="fes_section"><h3>'.apply_filters('fes_project_images_label', __('Project Images', 'ignitiondeck')).'</h3>',
					'label' => __('Featured Image', 'ignitiondeck'),
					'value' => (isset($vars['project_hero']) ? $vars['project_hero'] : ''),
					'misc' => (isset($vars['project_hero']) ? 'data-url="'.$vars['project_hero'].'" accept="image/*"' : 'accept="image/*"'),
					'name' => 'project_hero',
					'id' => 'project_hero',
					'type' => 'file',
					'wclass' => 'form-row half left'
					);
			$this->form[] = array(
					'label' => __('Project Image 2', 'ignitiondeck'),
					'value' => (isset($vars['project_image2']) ? $vars['project_image2'] : ''),
					'misc' => (isset($vars['project_image2']) ? 'data-url="'.$vars['project_image2'].'" accept="image/*"' : 'accept="image/*"'),
					'name' => 'project_image2',
					'id' => 'project_image2',
					'type' => 'file',
					'wclass' => 'form-row half'
					);
			$this->form[] = array(
					'label' => __('Project Image 3', 'ignitiondeck'),
					'value' => (isset($vars['project_image3']) ? $vars['project_image3'] : ''),
					'misc' => (isset($vars['project_image3']) ? 'data-url="'.$vars['project_image3'].'" accept="image/*"' : 'accept="image/*"'),
					'name' => 'project_image3',
					'id' => 'project_image3',
					'type' => 'file',
					'wclass' => 'form-row half left'
					);
			$this->form[] = array(
					'label' => __('Project Image 4', 'ignitiondeck'),
					'value' => (isset($vars['project_image4']) ? $vars['project_image4'] : ''),
					'misc' => (isset($vars['project_image4']) ? 'data-url="'.$vars['project_image4'].'" accept="image/*"' : 'accept="image/*"'),
					'name' => 'project_image4',
					'id' => 'project_image4',
					'type' => 'file',
					'wclass' => 'form-row half',
					'after' => '</div>'
					);
			/*$this->form[] = array(
					'before' => '<div class="fes_section">',
					'label' => __('Disable Levels', 'ignitiondeck'),
					'value' => '1',
					'name' => 'disable_levels',
					'id' => 'disable_levels',
					'type' => 'checkbox',
					'wclass' => 'form-row inline',
					'misc' => (isset($vars['disable_levels']) && $vars['disable_levels'] == '1' ? 'checked="checked"' : ''),
					'after' => '</div>'
					);*/
			$this->form[] = array(
					'before' => '<div class="fes_section">'
					);
			$this->form[] = array(
					'before' => '<h3>'.apply_filters('fes_project_reward_levels_label', __('Project Reward Levels', 'ignitiondeck')).'</h3>',
					'label' => __('Number of Levels', 'ignitiondeck'),
					'value' => (isset($vars['project_levels']) ? $vars['project_levels'] : '1'),
					'name' => 'project_levels',
					'id' => 'project_levels',
					'type' => 'number',
					'wclass' => 'form-row half',
					'class' => 'required',
					'misc' => (isset($vars['project_levels']) && isset($vars['status']) && strtoupper($vars['status']) == 'PUBLISH' ? 'min="'.$vars['project_levels'].'"' : 'min="1"')
					);
				if (empty($vars['project_levels']) || $vars['project_levels'] == 1) {
					if (!isset($vars['status']) || strtoupper($vars['status']) !== 'PUBLISH') {
						$this->form[] = array(
						'before' => '<div class="form-level">',
						'label' => __('Level Title', 'ignitiondeck'),
						'value' => (isset($vars['levels'][0]['title']) ? $vars['levels'][0]['title'] : ''),
						'name' => 'project_level_title[]',
						'id' => 'project_level_1_title',
						'type' => 'text',
						'wclass' => 'form-row',
						'class' => 'required'
						);
						$this->form[] =array(
							'label' => __('Level Price', 'ignitiondeck'),
							'value' => (isset($vars['levels'][0]['price']) ? $vars['levels'][0]['price'] : ''),
							'name' => 'project_level_price[]',
							'id' => 'project_level_1_price',
							'type' => 'text',
							'wclass' => 'form-row half left',
							'class' => ''
							);
						$this->form[] = array(
							'label' => __('Level Limit', 'ignitiondeck'),
							'value' => (isset($vars['levels'][0]['limit']) ? $vars['levels'][0]['limit'] : ''),
							'name' => 'project_level_limit[]',
							'id' => 'project_level_1_limit',
							'type' => 'number',
							'wclass' => 'form-row half'
							);
					}
					else {
						$this->form[] = array(
								'before' => '<div class="form-level">',
								'label' => __('Level Title', 'ignitiondeck'),
								'value' => (isset($vars['levels'][0]['title']) ? $vars['levels'][0]['title'] : ''),
								'name' => 'project_level_title[]',
								'id' => 'project_level_1_title',
								'type' => 'hidden',
								'wclass' => 'form-row',
								'class' => 'required'
								);
							$this->form[] = array(
								'label' => __('Level Price', 'ignitiondeck'),
								'value' => (isset($vars['levels'][0]['price']) ? $vars['levels'][0]['price'] : ''),
								'name' => 'project_level_price[]',
								'id' => 'project_level_1_price',
								'type' => 'hidden',
								'wclass' => 'form-row half left',
								'class' => ''
								);
							$this->form[] = array(
								'label' => __('Level Limit', 'ignitiondeck'),
								'value' => (isset($vars['levels'][0]['limit']) ? $vars['levels'][0]['limit'] : ''),
								'name' => 'project_level_limit[]',
								'id' => 'project_level_1_limit',
								'type' => 'hidden',
								'wclass' => 'form-row half'
								);
					}
					$this->form[] =array(
						'label' => __('Level Description', 'ignitiondeck'),
						'value' => (isset($vars['levels'][0]['short']) ? $vars['levels'][0]['short'] : ''),
						'name' => 'level_description[]',
						'id' => 'project_level_1_description',
						'type' => 'text',
						'wclass' => 'form-row'
						);
					$this->form[] =array(
						'label' => __('Level Long Description', 'ignitiondeck'),
						'value' => (isset($vars['levels'][0]['long']) ? $vars['levels'][0]['long'] : ''),
						'name' => 'level_long_description[]',
						'id' => 'project_level_1_long_description',
						'type' => 'wpeditor',
						'wclass' => 'form-row wpeditor',
						'after' => '</div>'
						);
				}
				else if (isset($vars['project_levels']) && $vars['project_levels'] > 1) {
					for ($i = 0; $i <= $vars['project_levels'] - 1; $i++) {
						if (!isset($vars['status']) || strtoupper($vars['status']) !== 'PUBLISH') {
							$this->form[] = array(
								'before' => '<div class="form-level">',
								'label' => __('Level Title', 'ignitiondeck'),
								'value' => (isset($vars['levels'][$i]['title']) ? $vars['levels'][$i]['title'] : ''),
								'name' => 'project_level_title[]',
								'id' => 'project_level_'.($i + 1).'_title',
								'type' => 'text',
								'wclass' => 'form-row',
								'class' => 'required'
								);
							$this->form[] = array(
								'label' => __('Level Price', 'ignitiondeck'),
								'value' => (isset($vars['levels'][$i]['price']) ? $vars['levels'][$i]['price'] : ''),
								'name' => 'project_level_price[]',
								'id' => 'project_level_'.($i + 1).'_price',
								'type' => 'text',
								'wclass' => 'form-row half left',
								'class' => 'required'
								);
							$this->form[] = array(
								'label' => __('Level Limit', 'ignitiondeck'),
								'value' => (isset($vars['levels'][$i]['limit']) ? $vars['levels'][$i]['limit'] : ''),
								'name' => 'project_level_limit[]',
								'id' => 'project_level_'.($i + 1).'_limit',
								'type' => 'number',
								'wclass' => 'form-row half'
								);
						}
						else {
							$this->form[] = array(
								'before' => '<div class="form-level">',
								'label' => __('Level Title', 'ignitiondeck'),
								'value' => (isset($vars['levels'][$i]['title']) ? $vars['levels'][$i]['title'] : ''),
								'name' => 'project_level_title[]',
								'id' => 'project_level_'.($i + 1).'_title',
								'type' => 'hidden',
								'wclass' => 'form-row',
								'class' => 'required'
								);
							$this->form[] = array(
								'label' => __('Level Price', 'ignitiondeck'),
								'value' => (isset($vars['levels'][$i]['price']) ? $vars['levels'][$i]['price'] : ''),
								'name' => 'project_level_price[]',
								'id' => 'project_level_'.($i + 1).'_price',
								'type' => 'hidden',
								'wclass' => 'form-row half left',
								'class' => ''
								);
							$this->form[] = array(
								'label' => __('Level Limit', 'ignitiondeck'),
								'value' => (isset($vars['levels'][$i]['limit']) ? $vars['levels'][$i]['limit'] : ''),
								'name' => 'project_level_limit[]',
								'id' => 'project_level_'.($i + 1).'_limit',
								'type' => 'hidden',
								'wclass' => 'form-row half'
								);
						}
						$this->form[] = array(
							'label' => __('Level Description', 'ignitiondeck'),
							'value' => (isset($vars['levels'][$i]['short']) ? $vars['levels'][$i]['short'] : ''),
							'name' => 'level_description[]',
							'id' => 'project_level_'.($i + 1).'_description',
							'type' => 'text',
							'wclass' => 'form-row'
							);
						$this->form[] = array(
							'label' => __('Level Long Description', 'ignitiondeck'),
							'value' => (isset($vars['levels'][$i]['long']) ? $vars['levels'][$i]['long'] : ''),
							'name' => 'level_long_description[]',
							'id' => 'project_level_'.($i + 1).'_long_description',
							'type' => 'wpeditor',
							'wclass' => 'form-row wpeditor',
							'after' => '</div>'
							);
					}
				}
				$this->form[] = array(
					'before' => '<div class="form-level-clone">',
					'label' => __('Level Title', 'ignitiondeck'),
					'name' => 'project_level_title[]',
					'id' => 'project_level_1_title',
					'type' => 'text',
					'wclass' => 'form-row',
					'misc' => 'disabled="disabled"'
					);
				$this->form[] = array(
					'label' => __('Level Price', 'ignitiondeck'),
					'name' => 'project_level_price[]',
					'id' => 'project_level_1_price',
					'type' => 'text',
					'wclass' => 'form-row half left',
					'misc' => 'disabled="disabled"'
					);
				$this->form[] = array(
					'label' => __('Level Limit', 'ignitiondeck'),
					'name' => 'project_level_limit[]',
					'id' => 'project_level_1_limit',
					'type' => 'number',
					'wclass' => 'form-row half',
					'misc' => 'disabled="disabled"'
					);
				$this->form[] = array(
					'label' => __('Level Description', 'ignitiondeck'),
					'name' => 'level_description[]',
					'id' => 'project_level_1_description',
					'type' => 'text',
					'wclass' => 'form-row'
					);
				$this->form[] = array(
					'label' => __('Level Long Description', 'ignitiondeck'),
					'name' => 'level_long_description[]',
					'id' => 'project_level_1_long_description',
					'type' => 'wpeditor',
					'wclass' => 'form-row wpeditor',
					'after' => '</div>'
					);
				$this->form[] = 	array(
					'after' => '</div>'
					);
				$this->form[] = array(
					'value' => __('Submit', 'ignitiondeck'),
					'name' => 'project_fesubmit',
					'type' => 'submit'
					);
			if (isset($vars['post_id']) && $vars['post_id'] > 0) {
				$this->form[] = array(
					'value' => $vars['post_id'],
					'name' => 'project_post_id',
					'type' => 'hidden');
			}
		}
		else {
			$this->form = $form;
		}
		$this->vars = $vars;
	}

	function display_form() {
		$id_form = new ID_Form($this->form);
		$output = $id_form->build_form($this->vars);
		return $output;
	}
}
?>