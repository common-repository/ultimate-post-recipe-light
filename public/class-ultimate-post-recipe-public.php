<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://codecanyon.net/user/dedalx/
 * @since      1.0.0
 *
 * @package    Ultimate_Post_Recipe
 * @subpackage Ultimate_Post_Recipe/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ultimate_Post_Recipe
 * @subpackage Ultimate_Post_Recipe/public
 * @author     dedalx <dedalx.rus@gmail.com>
 */
class Ultimate_Post_Recipe_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-post-recipe-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ultimate-post-recipe-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Show post recipe data on single post page.
	 *
	 * @since    1.0.0
	 */
	public function show_post_recipe_single( $content ) {

		$uprc_options = get_option( 'uprc_options' );
		$post_recipe_enabled = get_post_meta( get_the_ID(), '_uprc_post_recipe_enabled', true );

		if( is_single() && $post_recipe_enabled && $uprc_options['enable_single_post_recipe'] ) {

			$content .= $this->get_post_recipe_block();

		}

		return $content;

	}

	/**
	 * Show post recipe block as shortcode
	 *
	 * @since    1.0.0
	 */
	public function post_recipe_block_shortcode() {

		echo $this->get_post_recipe_block();

	}

	/**
	 * Get post recipe block HTML for display anywhere
	 *
	 * @since    1.0.0
	 */
	private function get_post_recipe_block() {

		$uprc_options = get_option( 'uprc_options' );

		// Get post recipe settings
		$post_recipe_image = get_post_meta( get_the_ID(), '_uprc_post_recipe_image', true );
		$post_recipe_title = get_post_meta( get_the_ID(), '_uprc_post_recipe_title', true );
		$post_recipe_summary = get_post_meta( get_the_ID(), '_uprc_post_recipe_summary', true );
		$post_recipe_equipment = get_post_meta( get_the_ID(), '_uprc_post_recipe_equipment', true );
		$post_recipe_equipment = !empty($post_recipe_equipment) ? explode("\n", str_replace("\r", "", $post_recipe_equipment)) : '';
		$post_recipe_ingredients = get_post_meta( get_the_ID(), '_uprc_post_recipe_ingredients', true );
		$post_recipe_ingredients = !empty($post_recipe_ingredients) ? explode("\n", str_replace("\r", "", $post_recipe_ingredients)) : array();
		$post_recipe_notes = get_post_meta( get_the_ID(), '_uprc_post_recipe_notes', true );
		$post_recipe_instructions_group = get_post_meta( get_the_ID(), '_uprc_recipe_instructions_group', true );

		// Icons
		$post_recipe_prep_time = get_post_meta( get_the_ID(), '_uprc_post_recipe_prep_time', true );
		$post_recipe_time = get_post_meta( get_the_ID(), '_uprc_post_recipe_time', true );
		$post_recipe_servings = get_post_meta( get_the_ID(), '_uprc_post_recipe_servings', true );
		$post_recipe_total_time = get_post_meta( get_the_ID(), '_uprc_post_recipe_total_time', true );

		if(isset($post_recipe_image) && ($post_recipe_image !== '')) {
		  $post_recipe_image_style = 'background-image: url('.$post_recipe_image.');';
		  $post_recipe_class = ' with-bg';
		} else {
		  $post_recipe_image_style = '';
		  $post_recipe_class = '';
		}

		$instructions = array();

		foreach ( (array) $post_recipe_instructions_group as $key => $value ) {

		    $instruction_title = !empty($value['instruction_title']) ? $value['instruction_title'] : '';
		    $instruction_text = !empty($value['instruction_text']) ? $value['instruction_text'] : '';

		    $instructions[] = array(
		        'title' => $instruction_title,
		        'text' => $instruction_text
		    );
		}

		ob_start();
		?>
		<div class="post-recipe-block<?php echo esc_attr($post_recipe_class); ?> post-recipe-block-style-<?php echo esc_attr($uprc_options['style']); ?>" vocab="https://schema.org/" typeof="Recipe">
		    <?php if(!empty($post_recipe_image_style)): ?>
		    <div class="post-recipe-image" style="<?php echo esc_attr($post_recipe_image_style); ?>" data-speed="0.1">
		        <?php do_action('post_recipe_image_inside'); // this action called from plugin ?>
		        <img src="<?php echo esc_url($post_recipe_image); ?>" class="rdf-hidden" alt="<?php echo esc_attr($post_recipe_title); ?>" property="image"/>
		    </div>
		    <?php endif; ?>

		    <div class="post-recipe-header"><h3 property="name"><?php echo esc_html($post_recipe_title); ?></h3></div>
		    <div class="rdf-hidden" property="author"><?php echo get_the_author_meta( 'user_nicename' ); ?></div>
		    <?php if(!empty($post_recipe_summary)): ?>
		    <div class="post-recipe-summary" property="description">
		        <?php echo wp_kses_post($post_recipe_summary); ?>
		    </div>
		    <?php endif; ?>
		    <div class="post-recipe-icons-row">
		        <?php if($post_recipe_prep_time): ?>
		        <div class="post-recipe-icon">
		            <i class="fa fa-cutlery" aria-hidden="true"></i>
		            <div class="post-recipe-icon-details">
		                <div class="post-recipe-icon-title"><?php esc_html_e('prep time', 'ultimate-post-recipe'); ?></div>
		                <div class="post-recipe-icon-value"><?php echo esc_html($post_recipe_prep_time); ?></div>
		            </div>
		        </div>
		        <?php endif; ?>
		        <?php if($post_recipe_time): ?>
		        <div class="post-recipe-icon">
		            <i class="fa fa-clock-o" aria-hidden="true"></i>
		            <div class="post-recipe-icon-details">
		                <div class="post-recipe-icon-title"><?php esc_html_e('cooking time', 'ultimate-post-recipe'); ?></div>
		                <div class="post-recipe-icon-value"><?php echo esc_html($post_recipe_time); ?></div>
		            </div>
		        </div>
		        <?php endif; ?>
		        <?php if($post_recipe_servings): ?>
		        <div class="post-recipe-icon">
		            <i class="fa fa-users" aria-hidden="true"></i>
		            <div class="post-recipe-icon-details">
		                <div class="post-recipe-icon-title"><?php esc_html_e('servings', 'ultimate-post-recipe'); ?></div>
		                <div class="post-recipe-icon-value"><?php echo esc_html($post_recipe_servings); ?></div>
		            </div>
		        </div>
		        <?php endif; ?>
		        <?php if($post_recipe_total_time): ?>
		        <div class="post-recipe-icon">
		            <i class="fa fa-check-square-o" aria-hidden="true"></i>
		            <div class="post-recipe-icon-details">
		                <div class="post-recipe-icon-title"><?php esc_html_e('total time', 'ultimate-post-recipe'); ?></div>
		                <div class="post-recipe-icon-value"><?php echo esc_html($post_recipe_total_time); ?></div>
		            </div>
		        </div>
		        <?php endif; ?>
		    </div>

		    <?php if(count($post_recipe_equipment) > 0 || count($post_recipe_ingredients) > 0): ?>
		    <div class="post-recipe-details">
		        <?php if(count($post_recipe_equipment) > 0): ?>
		        <div class="post-recipe-details-column">
		            <h4><?php esc_html_e('Equipment', 'ultimate-post-recipe'); ?></h4>
		            <ul>
		                <?php
		                $post_recipe_equipment = array_slice($post_recipe_equipment, 0, 5); foreach ($post_recipe_equipment as $value) {
		                    echo '<li><i class="fa fa-check" aria-hidden="true"></i><p>'.esc_html($value).'</p></li>';
		                }
		                ?>
		            </ul>
		        </div>
		        <?php endif; ?>
		        <?php if(count($post_recipe_ingredients) > 0): ?>
		        <div class="post-recipe-details-column">

		            <h4><?php esc_html_e('Ingredients', 'ultimate-post-recipe'); ?></h4>
		            <ul>
		                <?php
		                $post_recipe_ingredients = array_slice($post_recipe_ingredients, 0, 5); foreach ($post_recipe_ingredients as $value) {
		                    echo '<li><i class="fa fa-check" aria-hidden="true"></i><p property="recipeIngredient">'.esc_html($value).'</p></li>';
		                }
		                ?>
		            </ul>

		        </div>
		        <?php endif; ?>
		    </div>
		    <?php endif; ?>

		    <?php $i = 0; if(count($instructions) > 0): ?>
		    <div class="post-recipe-instructions-group">
		        <h4><?php esc_html_e('Instructions', 'ultimate-post-recipe'); ?></h4>
		        <?php $instructions = array_slice($instructions, 0, 5); foreach ($instructions as $instruction): ?>
		        <?php $i++; ?>
		        <div class="post-recipe-instruction">
		            <div class="post-recipe-step"><?php echo esc_html($i); ?></div>
		            <div class="post-recipe-instruction-content">
		                <?php if(!empty($instruction['title'])): ?>
		                <div class="post-recipe-instruction-title"><h4 property="recipeInstructions"><?php echo esc_html($instruction['title']); ?></h4></div>
		                <?php endif; ?>
		                <?php if(!empty($instruction['text'])): ?>
		                <div class="post-recipe-instruction-text" property="recipeInstructions"><?php echo esc_html($instruction['text']); ?></div>
		                <?php endif; ?>
		            </div>
		        </div>
		        <?php endforeach; ?>
		    </div>
		    <?php endif; ?>

		    <?php if(!empty($post_recipe_notes)): ?>
		    <div class="post-recipe-notes">
		        <h4><?php esc_html_e('Notes', 'ultimate-post-recipe'); ?></h4>
		        <?php echo esc_html($post_recipe_notes); ?>
		    </div>
		    <?php endif; ?>
		</div>
		<?php

		$post_recipe_html = ob_get_contents();
		ob_end_clean();

		return $post_recipe_html;

	}

}
