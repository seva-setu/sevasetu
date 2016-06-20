jQuery(document).ready(function() {
	jQuery.each(jQuery('select[name="project_fund_type"] option'), function() {
		if (jQuery(this).attr('disabled') == 'disabled') {
			jQuery(this).remove();
		}
	});
	if (jQuery('select[name="project_fund_type"] option').length == 1) {
		jQuery('select[name="project_fund_type"]').closest('li').remove();
	}
	jQuery('form#fes').submit(function(e) {
		//console.log('submit');
		if (jQuery('textarea[name="project_long_description"]:visible').length == 0) {
			// MCE Mode
			//console.log('click');
			jQuery('#project_long_description-html').click();
			var mceMode = true;
		}
		else {
			var mceMode = false;
		}
		//e.preventDefault();
		var noError = true;
		var required = jQuery('.form-row .required');
		jQuery.each(required, function(k, v) {
			var value = jQuery(this).val();
			if (value == '' || value == undefined) {
				noError = false;
				jQuery(this).addClass('error');
			}
			else {
				//console.log(jQuery(this).val());
			}
			if (mceMode == true) {
				console.log('clickback');
				jQuery('#project_long_description-tmce').click();
			}
		});
		//console.log(noError);
		return noError;
	});
	if (jQuery('.id-fes-form-wrapper').length) {
		jQuery
		('.id-fes-form-wrapper .date').datepicker({});
	}
	var disableLevels = jQuery('input[name="disable_levels"]').attr('checked');
	showLevels(disableLevels);
	jQuery('input[name="disable_levels"]').click(function() {
		disableLevels = jQuery('input[name="disable_levels"]').attr('checked');
		showLevels(disableLevels);
	});
	var minLevels = jQuery('input[name="project_levels"]').attr('min');
	jQuery('#fes input[name="project_levels"]').change(function() {
		var fesLevels = countLevels();
		var newLevels = jQuery(this).val();
		if (jQuery.isNumeric(newLevels)) {
			levelChange = newLevels - fesLevels;
			formLevel(fesLevels, levelChange);
		}
		else {
			jQuery(this).val(fesLevels);
		}
		if (jQuery(this).val() < minLevels) {
			jQuery(this).val(minLevels);
		}
	});
	var thumbs = jQuery('#fes input[type="file"]');
	jQuery.each(jQuery(thumbs), function(k,v) {
		var url = jQuery(this).data('url');
		//console.log(url);
		if (url && url.length > 0) {
			var name = jQuery(this).attr('name');
			jQuery(this).after('<p class="image_url" data-url="' + url + '">' + url + '</p>');
			jQuery(this).replaceWith('<span class="image_swap"><img class="project_image" src="' + url + '"/><br/><a name="' + name + '" href="#" class="remove_image">Remove</a> | <a href="#" class="show_url" data-url="' + url + '">Show URL</a></span>');	
			jQuery('#fes .remove_image').click(function(e) {
				e.preventDefault();
				var name = jQuery(this).attr('name');
				jQuery(this).parent('.image_swap').replaceWith('<input type="file" name="' + name + '" class="' + name + '" accept="image/*"/>');
			});
		}
	});
	jQuery('#fes .show_url').click(function(e) {
		e.preventDefault();
		var text = jQuery(this).text();
		var thisURL = jQuery(this).data('url');
		if (text == 'Show URL') {
			jQuery(this).text('Hide URL');
		}
		else {
			jQuery(this).text('Show URL');
		}
		jQuery('#fes .image_url[data-url="' + thisURL + '"]').toggle();
	});
});
function showLevels(disableLevels) {
	if (disableLevels == 'checked') {
		jQuery('#project_levels').closest('.fes_section').hide();
	}
	else {
		jQuery('#project_levels').closest('.fes_section').show();
	}
}
function countLevels() {
	var fesLevels = jQuery('#fes .form-level:visible').length;
	return fesLevels;
}
function formLevel(fesLevels, levelChange) {
	//console.log(levelChange);
	if (levelChange < 0) {
		levelChange = Math.abs(levelChange);
		for (i = 1; i <= levelChange; i++) {
			jQuery('#fes .form-level:visible').last().toggle();
		}
	}
	else {
		for (i = 1; i <= levelChange; i++) {
			var clone = jQuery('#fes .form-level-clone').clone();
			jQuery(clone).removeClass('form-level-clone').addClass('form-level');
			//jQuery(clone).find('input').attr('id', '');
			jQuery(clone).find('input').removeAttr('disabled');
			//console.log(jQuery('#fes .form-level:hidden'));
			if (jQuery('#fes .form-level:hidden').length > 0) {
				jQuery('#fes .form-level:hidden').first().toggle();
			}
			else {
				// add clone
				jQuery('#fes .form-level-clone').last().before(clone);
				// clear text and values
				var last = jQuery('#fes .form-level').size();
				var cloneIn = jQuery('#fes .form-level').last();
				var cloneInput = jQuery(cloneIn).find('input');
				var cloneTextArea = jQuery(cloneIn).find('textarea');
				jQuery.each(cloneInput, function() {
					jQuery(this).val('');
				});
				jQuery.each(cloneTextArea, function() {					
					jQuery(this).text('');
				});
				jQuery(clone).find('input.project_level_1_title').attr('id', 'project_level_' + last + '_title').removeClass().addClass('required');
				jQuery(clone).find('input.project_level_1_price').attr('id', 'project_level_' + last + '_price').removeClass().addClass('required');
				jQuery(clone).find('input.project_level_1_limit').attr('id', 'project_level_' + last + '_limit').removeClass();
				jQuery(clone).find('input.project_level_1_description').attr('id', 'project_level_' + last + '_description').removeClass().addClass('required');
				jQuery(clone).find('textarea.project_level_1_long_description').attr('id', 'project_level_' + last + '_long_description').removeClass().addClass('required');
				jQuery(clone).find('#project_level_1_long_description-html').attr('id', 'project_level_' + last + '_long_description-html');
				jQuery(clone).find('#project_level_1_long_description-tmce').attr('id', 'project_level_' + last + '_long_description-tmce');
				jQuery(clone).find('#wp-project_level_1_long_description-wrap').attr('id', 'wp-project_level_' + last + '_long_description-wrap');
				jQuery(clone).find('#wp-project_level_1_long_description-editor-tools').attr('id', 'wp-project_level_' + last + '_long_description-editor-tools');
				jQuery(clone).find('label[for="project_level_1_long_description"]').attr('for', 'project_level_' + last + '_long_description');
		
				tinyMCE.execCommand('mceAddEditor', false, 'project_level_' + last + '_long_description');
				tinyMCE.execCommand('mceAddControl', false, 'project_level_' + last + '_long_description');
				quicktags( { buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,more,close", id: 'project_level_' + last + '_long_description' } );
				QTags._buttonsInit();
			}
		}
	}
}