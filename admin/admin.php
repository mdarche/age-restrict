<?php
add_action( 'admin_menu', 'ar_add_admin_menu' );
add_action( 'admin_init', 'ar_settings_init' );
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');


function enqueue_media_uploader() {
  wp_enqueue_script( 'file-uploader-js', plugins_url( 'js/file-uploader.js', __FILE__ ), array( 'jquery' ), false, true );
  wp_enqueue_style( 'admin-style', plugins_url( 'css/style.css', __FILE__ ) );


  wp_enqueue_media();
}


function ar_add_admin_menu(  ) {
	add_options_page( 'Age Restrict', 'Age Restrict', 'manage_options', 'age_restrict', 'ar_options_page' );
}


function ar_settings_init(  ) {

	register_setting( 'pluginPage', 'ar_settings' );

	add_settings_section(
		'ar_pluginPage_section',
		__( 'Settings', 'age-restrict' ),
		'ar_settings_section_callback',
		'pluginPage'
	);

	add_settings_field(
		'ar_image_field',
		__( 'Upload a main image', 'age-restrict' ),
		'ar_image_field_render',
		'pluginPage',
		'ar_pluginPage_section'
	);

	add_settings_field(
		'ar_warning_msg',
		__( 'Add a custom warning message.', 'age-restrict' ),
		'ar_warning_msg_render',
		'pluginPage',
		'ar_pluginPage_section'
	);

	add_settings_field(
		'ar_deny_msg',
		__( 'Add a custom deny message', 'age-restrict' ),
		'ar_deny_msg_render',
		'pluginPage',
		'ar_pluginPage_section'
	);

}


function ar_image_field_render(  ) {

  $options = get_option('ar-settings');
  $default_image = 'https://www.placehold.it/115x115';

  if (!empty($options['ar_image_field'])) {
      $image_attributes = wp_get_attachment_image_src($options['ar_image_field'], 'full');
      $src = $image_attributes[0];
      $value = $options['ar_image_field'];
  } else {
      $src = $default_image;
      $value = '';
  }

  // Print HTML field
  echo '
      <div class="upload" style="max-width:400px;">
          <img data-src="' . $default_image . '" src="' . $src . '" style="max-width:100%; height:auto;"/>
          <div>
              <input type="hidden" name="' . $optionName . '" id="' . $optionName . '" value="' . $value . '" />
              <button type="submit" class="upload_image_button button" title="Upload Image">' . __('Upload', 'igsosd') . '</button>
              <button type="submit" class="remove_image_button button" title="Remove Image">&times;</button>
          </div>
      </div>
  ';
}


function ar_warning_msg_render(  ) {

	$options = get_option( 'ar_settings' );
	?>
	<textarea cols='40' rows='5' name='ar_settings[ar_warning_msg]'><?php echo $options['ar_warning_msg'];?></textarea>
	<?php
}


function ar_deny_msg_render(  ) {

	$options = get_option( 'ar_settings' );
	?>
	<textarea cols='40' rows='5' name='ar_settings[ar_deny_msg]'><?php echo $options['ar_deny_msg']; ?></textarea>
	<?php
}


function ar_settings_section_callback(  ) {
	echo __( 'Control how the Age Restrict appears to users', 'age-restrict' );
}


function ar_options_page() {

	?>
	<form action='options.php' method='post'>
		<h1>Age Restrict</h1>
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
	</form>
	<?php

}
