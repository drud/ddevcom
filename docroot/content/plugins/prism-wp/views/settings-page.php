<?php if(!defined('ABSPATH')) die('Direct access denied.'); ?>

<div class="wrap">
	<?php echo $screen_icon; ?>
	<h2><?php echo $page_title; ?></h2>
	<div class="intro">
		<p><?php _e('Play with these Prism settings.', 'prism-wp'); ?></p>
	</div>
	<?php echo $debug; ?>
	<form method="post" action="options.php">
		<?php
		echo $settings_fields;
		?>
		<table class="form-table">
			<tr>
				<th><label for="prism-wp-settings-theme"><?php _e('Appearance:', 'prism-wp'); ?></label></th>
				<td>
					<select name="<?php echo esc_attr( $option_name."[theme]" ); ?>" id="prism-wp-settings-load_scripts_in">
						<option value="default" <?php selected($settings_data['theme'], 'default'); ?>><?php _e('Default', 'prism-wp'); ?></option>
						<option value="coy" <?php selected($settings_data['theme'], 'coy'); ?>><?php _e('Coy', 'prism-wp'); ?></option>
						<option value="dark" <?php selected($settings_data['theme'], 'dark'); ?>><?php _e('Dark', 'prism-wp'); ?></option>
						<option value="funky" <?php selected($settings_data['theme'], 'funky'); ?>><?php _e('Funky', 'prism-wp'); ?></option>
						<option value="okaidia" <?php selected($settings_data['theme'], 'okaidia'); ?>><?php _e('Okaidia', 'prism-wp'); ?></option>
						<option value="tomorrow" <?php selected($settings_data['theme'], 'tomorrow'); ?>><?php _e('Tomorrow', 'prism-wp'); ?></option>
						<option value="twilight" <?php selected($settings_data['theme'], 'twilight'); ?>><?php _e('Twilight', 'prism-wp'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for=""><?php _e('Languages:', 'prism-wp'); ?></label></th>
				<td>
					<label for="prism-wp-settings-language_bash">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_bash]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_bash" name="<?php echo esc_attr( $option_name."[language_bash]" ); ?>" value="1" <?php checked($settings_data['language_bash'], 1); ?> />
						<span><em><?php _e('Bash', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_c">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_c]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_c" name="<?php echo esc_attr( $option_name."[language_c]" ); ?>" value="1" <?php checked($settings_data['language_c'], 1); ?> />
						<span><em><?php _e('C', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_coffeescript">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_coffeescript]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_coffeescript" name="<?php echo esc_attr( $option_name."[language_coffeescript]" ); ?>" value="1" <?php checked($settings_data['language_coffeescript'], 1); ?> />
						<span><em><?php _e('CoffeeScript', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_cpp">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_cpp]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_cpp" name="<?php echo esc_attr( $option_name."[language_cpp]" ); ?>" value="1" <?php checked($settings_data['language_cpp'], 1); ?> />
						<span><em><?php _e('C++', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_csharp">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_csharp]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_csharp" name="<?php echo esc_attr( $option_name."[language_csharp]" ); ?>" value="1" <?php checked($settings_data['language_csharp'], 1); ?> />
						<span><em><?php _e('C#', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_css">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_css]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_css" name="<?php echo esc_attr( $option_name."[language_css]" ); ?>" value="1" <?php checked($settings_data['language_css'], 1); ?> />
						<span><em><?php _e('CSS', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_css_extras">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_css_extras]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_css_extras" name="<?php echo esc_attr( $option_name."[language_css_extras]" ); ?>" value="1" <?php checked($settings_data['language_css_extras'], 1); ?> />
						<span><em><?php _e('CSS Extras', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_gherkin">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_gherkin]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_gherkin" name="<?php echo esc_attr( $option_name."[language_gherkin]" ); ?>" value="1" <?php checked($settings_data['language_gherkin'], 1); ?> />
						<span><em><?php _e('Gherkin', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_groovy">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_groovy]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_groovy" name="<?php echo esc_attr( $option_name."[language_groovy]" ); ?>" value="1" <?php checked($settings_data['language_groovy'], 1); ?> />
						<span><em><?php _e('Groovy', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_http">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_http]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_http" name="<?php echo esc_attr( $option_name."[language_http]" ); ?>" value="1" <?php checked($settings_data['language_http'], 1); ?> />
						<span><em><?php _e('HTTP', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_java">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_java]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_java" name="<?php echo esc_attr( $option_name."[language_java]" ); ?>" value="1" <?php checked($settings_data['language_java'], 1); ?> />
						<span><em><?php _e('Java', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_javascript">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_javascript]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_javascript" name="<?php echo esc_attr( $option_name."[language_javascript]" ); ?>" value="1" <?php checked($settings_data['language_javascript'], 1); ?> />
						<span><em><?php _e('JavaScript', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_markup">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_markup]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_markup" name="<?php echo esc_attr( $option_name."[language_markup]" ); ?>" value="1" <?php checked($settings_data['language_markup'], 1); ?> />
						<span><em><?php _e('Markup', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_php">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_php]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_php" name="<?php echo esc_attr( $option_name."[language_php]" ); ?>" value="1" <?php checked($settings_data['language_php'], 1); ?> />
						<span><em><?php _e('PHP', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_php_extras">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_php_extras]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_php_extras" name="<?php echo esc_attr( $option_name."[language_php_extras]" ); ?>" value="1" <?php checked($settings_data['language_php_extras'], 1); ?> />
						<span><em><?php _e('PHP Extras', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_python">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_python]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_python" name="<?php echo esc_attr( $option_name."[language_python]" ); ?>" value="1" <?php checked($settings_data['language_python'], 1); ?> />
						<span><em><?php _e('Python', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_ruby">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_ruby]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_ruby" name="<?php echo esc_attr( $option_name."[language_ruby]" ); ?>" value="1" <?php checked($settings_data['language_ruby'], 1); ?> />
						<span><em><?php _e('Ruby', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_scss">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_scss]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_scss" name="<?php echo esc_attr( $option_name."[language_scss]" ); ?>" value="1" <?php checked($settings_data['language_scss'], 1); ?> />
						<span><em><?php _e('SCSS', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-language_sql">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[language_sql]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-language_sql" name="<?php echo esc_attr( $option_name."[language_sql]" ); ?>" value="1" <?php checked($settings_data['language_sql'], 1); ?> />
						<span><em><?php _e('SQL', 'prism-wp'); ?></em></span>
					</label> <br />
				</td>
			</tr>
			<tr>
				<th><label for=""><?php _e('Additional Options:', 'prism-wp'); ?></label></th>
				<td>
					<label for="prism-wp-settings-line_highlight">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[line_highlight]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-line_highlight" name="<?php echo esc_attr( $option_name."[line_highlight]" ); ?>" value="1" <?php checked($settings_data['line_highlight'], 1); ?> />
						<span><em><?php _e('Line Highlight', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-line_numbers">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[line_numbers]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-line_numbers" name="<?php echo esc_attr( $option_name."[line_numbers]" ); ?>" value="1" <?php checked($settings_data['line_numbers'], 1); ?> />
						<span><em><?php _e('Line Numbers', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-show_invisibles">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[show_invisibles]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-show_invisibles" name="<?php echo esc_attr( $option_name."[show_invisibles]" ); ?>" value="1" <?php checked($settings_data['show_invisibles'], 1); ?> />
						<span><em><?php _e('Show Invisibles', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-autolinker">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[autolinker]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-autolinker" name="<?php echo esc_attr( $option_name."[autolinker]" ); ?>" value="1" <?php checked($settings_data['autolinker'], 1); ?> />
						<span><em><?php _e('Autolinker', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-wpd">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[wpd]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-wpd" name="<?php echo esc_attr( $option_name."[wpd]" ); ?>" value="1" <?php checked($settings_data['wpd'], 1); ?> />
						<span><em><?php _e('Webplatform Docs', 'prism-wp'); ?></em></span>
					</label> <br />
					<label for="prism-wp-settings-file_highlight">
						<input type="hidden" name="<?php echo esc_attr( $option_name."[file_highlight]" ); ?>" value="0">
						<input type="checkbox" id="prism-wp-settings-file_highlight" name="<?php echo esc_attr( $option_name."[file_highlight]" ); ?>" value="1" <?php checked($settings_data['file_highlight'], 1); ?> />
						<span><em><?php _e('File Highlight', 'prism-wp'); ?></em></span>
					</label> <br />
				</td>
			</tr>
			<tr>
				<th><label for="prism-wp-settings-load_scripts_in"><?php _e('Load scripts in:', 'prism-wp'); ?></label></th>
				<td>
					<select name="<?php echo esc_attr( $option_name."[load_scripts_in]" ); ?>" id="prism-wp-settings-load_scripts_in">
						<option value="header" <?php selected($settings_data['load_scripts_in'], 'header'); ?>><?php _e('Header', 'prism-wp'); ?></option>
						<option value="footer" <?php selected($settings_data['load_scripts_in'], 'footer'); ?>><?php _e('Footer', 'prism-wp'); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="prism-wp-settings-script_priority"><?php _e('Scripts loading priority:', 'prism-wp'); ?></label></th>
				<td>
					<input type="number" id="<?php echo esc_attr( 'script_priority' ); ?>" name="<?php echo esc_attr( $option_name."[script_priority]" ); ?>" value="<?php echo esc_attr( $settings_data['script_priority'] ); ?>" />
					<em><?php _e('Make this value bigger to load scripts last.', 'prism-wp'); ?></em>
				</td>
			</tr>
		</table>
		<br /><br />
		<?php submit_button( __('Restore Defaults', 'prism-wp'), 'secondary', 'reset', false) ?> &nbsp;
		<?php submit_button( __('Save Options', 'prism-wp'), 'primary', 'submit', false) ?>
	</form>
	
</div>