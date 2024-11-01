<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://codecanyon.net/user/dedalx/
 * @since      1.0.0
 *
 * @package    Ultimate_Post_Recipe
 * @subpackage Ultimate_Post_Recipe/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Post_Recipe
 * @subpackage Ultimate_Post_Recipe/admin
 * @author     dedalx <dedalx.rus@gmail.com>
 */
class Ultimate_Post_Recipe_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Post_Recipe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Post_Recipe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-post-recipe-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ultimate_Post_Recipe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Post_Recipe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}


	/**
	 * Check for CMB2 plugin installation
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function display_cmb2_warning() {

		$plugin_name = 'cmb2';
		$install_cmb2_link = '<a href="' . esc_url( network_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $plugin_name ) ) . '" target="_blank">install and activate CMB2 plugin</a>';

	    $message_html = '<div class="notice notice-error"><p><strong>WARNING:</strong> Ultimate Post Recipe plugin use CMB2 plugin. Please '.$install_cmb2_link.'.</p></div>';

	    echo wp_kses_post($message_html);

	}

	/**
	 * Add recipe options metaboxes
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function add_metaboxes() {

		// Start with an underscore to hide fields from custom fields list
		$prefix = '_uprc_';

		// POST SETTINGS METABOX
		$cmb_post_recipe_settings = new_cmb2_box( array(
			'id'           => $prefix . 'post_recipe_metabox',
			'title'        => esc_html__( 'Post Recipe', 'ultimate-post-recipe' ),
			'object_types' => array( 'post' ), // Post type
			'context'      => 'normal',
			'priority'     => 'high',
			'show_names'   => true, // Show field names on the left
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name' => 'You are using Free version of Ultimate Post Recipe plugin',
			'desc' => 'Purchase PRO version to unlock more features and remove all limits:<br><br>
			<ul>
				<li>- Unlimited cooking steps</li>
				<li>- Unlimited ingredients and equipments display</li>
				<li>- Mark items as done/undone in any list by mouse click</li>
				<li>- HTML and affiliate links support in cooking steps, ingredients and equipments lists</li>
				<li>- Rounded and squared elements styles</li>
				<li>- Google Rich Snippets Support (RDF, schema.org)</li>
				<li>- Shortcodes and custom functions for custom placing review badges anywhere in your theme</li>
				<li>- Free Plugin updates and dedicated support</li>
			</ul><br>
			<a href="https://codecanyon.net/item/ultimate-post-recipe-responsive-wordpress-posts-cooking-recipes-plugin/32470950" target="_blank" class="button button-primary">Purchase PRO version</a>',
			'type' => 'title',
			'id'   =>  $prefix .'free_version_text'
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name' => esc_html__( 'Enable recipe block', 'ultimate-post-recipe' ),
			'desc' => esc_html__( 'Enable to show recipe block for post and set recipe settings below.', 'ultimate-post-recipe' ),
			'id'   => $prefix . 'post_recipe_enabled',
			'type' => 'checkbox',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Preparation time', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Displayed in recipe box. Ex.: "15 min"', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_prep_time',
			'type'    => 'text_medium',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Cooking time', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Displayed in recipe box. Ex.: "2 hours"', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_time',
			'type'    => 'text_medium',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Servings', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Displayed in recipe box. Ex.: "4"', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_servings',
			'type'    => 'text_medium',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Total time', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Displayed in recipe box. Ex.: "2 hours 15 min"', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_total_time',
			'type'    => 'text_medium',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'         => esc_html__( 'Recipe block image', 'ultimate-post-recipe' ),
			'id'           => $prefix . 'post_recipe_image',
			'type'         => 'file',
			'options' => array(
			    'url' => false, // Hide the text input for the url
			    'add_upload_file_text' => 'Select or Upload Image'
			),
			'precipe_size' => array( 100, 100 ),
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Recipe block title', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Displayed in recipe block header.', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_title',
			'type'    => 'text_medium',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Recipe block summary', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Short summary for recipe (HTML allowed).', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_summary',
			'type'    => 'textarea_small',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Equipment (5 items limit in FREE version)', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Equipment list (1 per line, HTML allowed)', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_equipment',
			'type'    => 'textarea_small',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Ingredients (5 items limit in FREE version)', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Ingredients list (1 per line, HTML allowed in PRO version)', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_ingredients',
			'type'    => 'textarea_small',
		) );

		$cmb_post_recipe_settings->add_field( array(
			'name'    => esc_html__( 'Recipe special notes', 'ultimate-post-recipe' ),
			'desc'    => esc_html__( 'Displayed at the bottom of recipe box, HTML allowed in PRO version', 'ultimate-post-recipe' ),
			'default' => '',
			'id'      => $prefix . 'post_recipe_notes',
			'type'    => 'textarea_small',
		) );

		$cmb_recipe_criteria_group = $cmb_post_recipe_settings->add_field( array(
			'id'          => $prefix . 'recipe_instructions_group',
			'type'        => 'group',
			// 'repeatable'  => false, // use false if you want non-repeatable group
			'options'     => array(
			  'group_title'       => esc_html__( 'Cooking instruction step {#}', 'ultimate-post-recipe' ),
			  'add_button'        => esc_html__( 'Add cooking instruction (5 items limit in FREE version)', 'ultimate-post-recipe' ),
			  'remove_button'     => esc_html__( 'Remove cooking instruction', 'ultimate-post-recipe' ),
			  'sortable'          => true,
			  // 'closed'         => true, // true to have the groups closed by default
			  // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
			),
		) );

		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$cmb_post_recipe_settings->add_group_field( $cmb_recipe_criteria_group, array(
			'name' => esc_html__( 'Cooking instruction title', 'ultimate-post-recipe' ),
			'id'   => 'instruction_title',
			'type' => 'text',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$cmb_post_recipe_settings->add_group_field( $cmb_recipe_criteria_group, array(
			'name' => esc_html__( 'Cooking instruction text, HTML allowed in PRO version', 'ultimate-post-recipe' ),
			'id'   => 'instruction_text',
			'type' => 'textarea',
			// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

	}

	/**
	 * Add admin settings page
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function add_admin_page() {
		add_options_page(esc_html__('Ultimate Post Recipe', 'ultimate-post-recipe'), esc_html__('Ultimate Post Recipe', 'ultimate-post-recipe'), 'manage_options', 'uprc_settings', array( $this, 'uprc_settings' ));
	}

	/**
	 * Register settings
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function uprc_register_settings() {

		$uprc_options_default = array(
			'enable_single_post_recipe' 		=> 1,
			'style'   		=> 'square',
		);

		/* Install the default plugin options */
        if ( ! get_option( 'uprc_options' ) ){
            add_option( 'uprc_options', $uprc_options_default, '', 'yes' );
        }
	}

	/**
	 * Print all plugin options.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function uprc_settings() {

		$this->uprc_register_settings();

		$display_add_options = $message = $error = $result = '';

		$uprc_options = get_option( 'uprc_options' );

		if ( isset( $_POST['uprc_form_submit'] ) && check_admin_referer( plugin_basename( __FILE__ ), 'uprc_nonce_name' ) ) {
			/* Update settings */
			$uprc_options['enable_single_post_recipe'] = isset( $_POST['enable_single_post_recipe'] ) ? sanitize_text_field($_POST['enable_single_post_recipe']) : '0';
			$uprc_options['style'] = isset( $_POST['style'] ) ? sanitize_text_field($_POST['style']) : 'square';

			/* Update settings in the database */
			if ( empty( $error ) ) {
				if($_POST['save_form'] == 1 && check_admin_referer( plugin_basename( __FILE__ ), 'uprc_nonce_name' )) {
					update_option( 'uprc_options', $uprc_options );
					$message .= esc_html__( "Settings saved.", 'ultimate-post-recipe' );
				}
			} else {
				$error .= " " . esc_html__( "Settings are not saved.", 'ultimate-post-recipe' );
			}
		}

		// All available styles
		$uprc_styles_list['square'] = 'Square edges';
		$uprc_styles_list['rounded'] = 'Rounded edges (PRO only)';

		?>
		<div class="upr-settings wrap" id="upr-settings">
			<h2><?php esc_html_e( "Ultimate Post Recipe", 'ultimate-post-recipe' ); ?></h2>
			<p>Thanks for using plugin developed by <a href="https://magniumthemes.com/" target="blank">MagniumThemes</a> company.</p>
			<a href="https://magniumthemes.com/themes" target="blank" class="button button-secondary">Our Premium Themes</a> <a href="https://magniumthemes.com/wordpress-plugins/" target="blank" class="button button-secondary">Our Ultimate Plugins</a> <a href="https://magniumthemes.com/go/bluehost/" target="blank" class="button button-secondary">WordPress Hosting</a> <a href="https://codecanyon.net/item/ultimate-post-recipe-responsive-wordpress-posts-cooking-recipes-plugin/32470950" target="blank" class="button button-primary">Purchase PRO version</a><br><br>
			<div class="updated fade" <?php if( empty( $message ) ) echo "style=\"display:none\""; ?>>
				<p><strong><?php echo esc_html($message); ?></strong></p>
			</div>

			<div class="upr-settings-wrapper">

				<form id="uprc_settings_form" method="post" action="">
						<input type="hidden" name="save_form" id="save_form" value="1"/>
						<h3><?php esc_html_e( 'Getting started', 'ultimate-post-recipe' ); ?></h3>
						<p><strong>Purchase PRO version to unlock more features and remove all limits:</strong><br>
			<ul>
				<li>- Unlimited cooking steps</li>
				<li>- Unlimited ingredients and equipments display</li>
				<li>- Mark items as done/undone in any list by mouse click</li>
				<li>- HTML and affiliate links support in cooking steps, ingredients and equipments lists</li>
				<li>- Rounded and squared elements styles</li>
				<li>- Google Rich Snippets Support (RDF, schema.org)</li>
				<li>- Shortcodes and custom functions for custom placing review badges anywhere in your theme</li>
				<li>- Free Plugin updates and dedicated support</li>
			</ul>
			<a href="https://codecanyon.net/item/ultimate-post-recipe-responsive-wordpress-posts-cooking-recipes-plugin/32470950" target="_blank" class="button button-primary">Purchase PRO version</a></p>

						<table class="form-table">
						<tr valign="top">
							<th scope="row">How to add recipes</th>
							<td>
								<div class="option-info"><?php echo wp_kses_post(__('<strong>Edit/Add your Posts</strong> and you will see new <strong>Post Recipe</strong> settings metabox for every post at the bottom after post content editor.', 'ultimate-post-recipe' )); ?></div>
							</td>
						</tr>
						</table>
						<h3><?php esc_html_e( 'Display settings', 'ultimate-post-recipe' ); ?></h3>
						<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php esc_html_e( "Single post page", 'ultimate-post-recipe' ); ?></th>
							<td>
								<?php if(isset($uprc_options['enable_single_post_recipe']) && $uprc_options['enable_single_post_recipe'] == 1) {
									$enable_single_post_recipe = ' checked';
								} else {
									$enable_single_post_recipe = '';
								}
								?>
								<label><input type="checkbox" name="enable_single_post_recipe" value="1"<?php echo esc_attr($enable_single_post_recipe); ?>/>
								<span><?php esc_html_e( "Add post recipe block after post content automatically", 'ultimate-post-recipe' ); ?></span></label>
								<div class="option-info"><?php echo wp_kses_post(__( "PRO version only: If automatical position does not work well in your theme or you want to display block in custom position you can disable this option and place post recipe block manually:<ul><li>Add <strong>[post_recipe_block]</strong> shortcode in your post content.</li><li><strong>OR</strong> add code <strong>&lt;?php ultimate_post_recipe_display_post_recipe_block(); ?&gt;</strong> to your theme <strong>single.php</strong> template file (or other template file used in your theme for single post display).</li></ul>", 'ultimate-post-recipe' )); ?></div>
							</td>
						</tr>
						</table>
						<h3><?php esc_html_e( 'Styles settings', 'ultimate-post-recipe' ); ?></h3>
						<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php esc_html_e( "Post recipe elements style", 'ultimate-post-recipe' ); ?></th>
							<td>
								<select name="style">
								    <?php
								    $i = 0;
								    foreach ($uprc_styles_list as $style => $inner_html) {
								    	if($style == $uprc_options['style']) {
								    		$style_selected = ' selected';
								    	} else {
								    		$style_selected = '';
								    	}
								    	echo '<option data-id="'.esc_attr($i).'" value="'.$style.'"'.$style_selected.'>'.$inner_html.'</option>';
								    	$i++;
								    }
								    ?>
							    </select>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php esc_html_e( "Additional styles", 'ultimate-post-recipe' ); ?></th>
							<td>
								<div class="option-info"><?php echo wp_kses_post(__( "You can restyle any element in our plugin with Custom CSS code added in <strong>Appearance > Customize > Additional CSS</strong>.<br><br>Please <a href='https://help.magniumthemes.com/hc/en-us/articles/115001505454-How-to-change-theme-elements-styles-move-or-hide-elements' target='_blank'>read this help guide</a> about using Custom CSS and feel free to <a href='https://support.magniumthemes.com/' target='_blank'>contact our support</a> if you will have any questions.", 'ultimate-post-recipe' )); ?></div>
							</td>
						</tr>
						</table>

						<p class="submit">
							<input type="submit" id="settings-form-submit" class="button-primary" value="<?php esc_html_e( 'Save Changes', 'upr' ) ?>" />

							<input type="hidden" name="uprc_form_submit" value="submit" />
							<?php wp_nonce_field( plugin_basename( __FILE__ ), 'uprc_nonce_name' ); ?>
						</p>
				</form>

			</div>

		</div>

		<?php
	}

}
