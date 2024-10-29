<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.codeincept.com
 * @since      1.0.0
 *
 * @package    Advanced_Team
 * @subpackage Advanced_Team/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Advanced_Team
 * @subpackage Advanced_Team/public
 * @author     CodeIncept <codeincept@gmail.com>
 */
class ciat_Advanced_Team_Public {

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
		add_shortcode('advanced_team', array($this, 'ciat_advanced_team_shortcode_callback'));

	}
	public function ciat_advanced_team_shortcode_callback($atts){
		$atts=shortcode_atts(
			array(
				'items'		=>	4,
				'columns'	=>	4,
				'style'		=>	'style-1',
				'cat_ids'	=>	-1,
				),$atts);
		/* Switch to css styles */
		switch ($atts['style']) {
			case 'style-1':
				$atts['style']='iq_team_member';
				break;
			case 'style-2':
				$atts['style']='modern-style';
				break;
			case 'style-3':
				$atts['style']='classic-style';
				break;
			default:
				$atts['style']='modern-style';
				break;
		}
		/* Query */
			$args = array(
	          'post_type' => 'advanced_team',
	          'post_status'=> 'publish',
	          'posts_per_page'=> $atts['items'],
	          'orderby'=>'date',
	          'order'=>'ASC',
	          'cat' => $atts['cat_ids']
	        );
	        $loop = new WP_Query( $args );
	      	if ( $loop->have_posts()):
	      		wp_enqueue_style('font-awesome');
	      		?>
	      	<div class="team-container">

	      	<div class="iq_team_members iq_row myteam_carousel">

	      	<?php
	      		while($loop->have_posts()): 
	      			$loop->the_post();
	      		$image=get_the_post_thumbnail( get_the_ID() );
	      		$detals=get_post_meta(get_the_ID(),'iq_team_members',true);
	      		$columns=(in_array($atts['columns'], array(1,2,3,4))) ? 12/$atts['columns'] : 3;
			?>
			<div class="col_<?php echo $columns; ?>">
			<div class="<?php echo $atts['style']; ?> pa-15">
				<div class="team-inner">
				<div class="article-image">
					<?php echo $image; ?>
				</div>
				<div class="article-caption">
					<div class="iq_team_details">
							<?php echo isset($detals['name']) ? $detals['name'] : ''; ?>
						<span>
							<?php echo isset($detals['designation']) ? $detals['designation'] : ''; ?>
						</span>
					</div>
					<div class="iq_team_member_Social_icons">
						<ul class="social">
	                    <?php if(!empty($detals['fblink'])) echo '<li><a href="'.$detals['fblink'].'"><i class="fa fa-facebook"></i></a></li>'; 
	                    if(!empty($detals['twitterlink'])) echo '<li><a href="'.$detals['twitterlink'].'"><i class="fa fa-twitter"></i></a></li>'; 
	                    if(!empty($detals['gpluslink'])) echo '<li><a href="'.$detals['gpluslink'].'"><i class="fa fa-google-plus"></i></a></li>'; 
	                    if(!empty($detals['linkdinlink'])) echo '<li><a href="'.$detals['linkdinlink'].'"><i class="fa fa-linkedin"></i></a></li>'; 
	                    if(!empty($detals['pinterest'])) echo '<li><a href="'.$detals['pinterest'].'"><i class="fa fa-pinterest"></i></a></li>'; 
	                    if(!empty($detals['instagram'])) echo '<li><a href="'.$detals['instagram'].'"><i class="fa fa-instagram"></i></a></li>'; 
	                    if(!empty($detals['reddit'])) echo '<li><a href="'.$detals['reddit'].'"><i class="fa fa-reddit"></i></a></li>'; 
	                    if(!empty($detals['tumbler'])) echo '<li><a href="'.$detals['tumbler'].'"><i class="fa fa-tumblr"></i></a></li>'; 

	                   ?>
		                </ul>
					</div>
				</div>
			</div>
			</div>
		</div>
			<?php
				
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
				<?php
		endif;
	}
	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function ciat_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Team_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Team_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_style( 'font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-team-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function ciat_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advanced_Team_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advanced_Team_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-team-public.js', array( 'jquery' ), $this->version, false );

	}

}
