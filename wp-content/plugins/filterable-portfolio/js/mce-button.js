(function() {
	tinymce.PluginManager.add('filterable_portfolio_mce_button', function( editor, url ) {
		editor.addButton( 'filterable_portfolio_mce_button', {

            title : 'Add Filterable Portfolio',
			image : url + '/icon.png',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Filterable Portfolio Shortcode',
					body: 
					[
						{
							type: 'textbox',
							name: 'thumbnail',
							label: 'Image per Column',
							value: '2'
						},
						{
							type: 'textbox',
							name: 'thumbnail_size',
							label: 'Portfolio Image Size',
							value: 'full'
						},
						{
							type: 'listbox',
							name: 'prettyphoto_theme',
							label: 'Choose Prettyphoto Theme',
								'values': 
								[
									{text: 'Default', value: 'default'},
									{text: 'Dark Rounded', value: 'dark_rounded'},
									{text: 'Dark Square', value: 'dark_square'},
									{text: 'Light Rounded', value: 'light_rounded'},
									{text: 'Light Square', value: 'light_square'},
									{text: 'Facebook', value: 'facebook'}
								]
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[filterable_portfolio thumbnail="' + e.data.thumbnail + '" thumbnail_size="' + e.data.thumbnail_size + '" prettyphoto_theme="' + e.data.prettyphoto_theme + '"]');
						}
					}
				);
			}

		});
	});
})();