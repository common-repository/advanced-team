<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.codeincept.com
 * @since      1.0.0
 *
 * @package    Advanced_Team
 * @subpackage Advanced_Team/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Team
 * @subpackage Advanced_Team/admin
 * @author     CodeIncept <codeincept@gmail.com>
 */
class ciat_Advanced_Team_Admin {

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
		add_action( 'init', array($this, 'ciat_team_register'), 0 );
		add_action( 'init', array($this, 'ciat_register_team_taxonomies'));
		add_action( 'add_meta_boxes', array($this, 'ciat_team_register_metabox' ));
		add_action( 'save_post_advanced_team', array($this, 'save_team_meta_box_data' ));
		//add_shortcode('iq_team_members', array($this, 'iq_team_members_callback'));
	}
	public function ciat_team_register() {

		$labels = array(
			'name'                  => __( 'Team Members', 'advanced-team' ),
			'singular_name'         => __( 'Team Member', 'advanced-team' ),
			'menu_name'             => __( 'Team Members', 'advanced-team' ),
			'name_admin_bar'        => __( 'Team Members', 'advanced-team' ),
			'archives'              => __( 'Item Archives', 'advanced-team' ),
			'attributes'            => __( 'Item Attributes', 'advanced-team' ),
			'parent_item_colon'     => __( 'Parent Item:', 'advanced-team' ),
			'all_items'             => __( 'All Items', 'advanced-team' ),
			'add_new_item'          => __( 'Add New Item', 'advanced-team' ),
			'add_new'               => __( 'Add New', 'advanced-team' ),
			'new_item'              => __( 'New Item', 'advanced-team' ),
			'edit_item'             => __( 'Edit Item', 'advanced-team' ),
			'update_item'           => __( 'Update Item', 'advanced-team' ),
			'view_item'             => __( 'View Item', 'advanced-team' ),
			'view_items'            => __( 'View Items', 'advanced-team' ),
			'search_items'          => __( 'Search Item', 'advanced-team' ),
			'not_found'             => __( 'Not found', 'advanced-team' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'advanced-team' ),
			'featured_image'        => __( 'Featured Image', 'advanced-team' ),
			'set_featured_image'    => __( 'Set featured image', 'advanced-team' ),
			'remove_featured_image' => __( 'Remove featured image', 'advanced-team' ),
			'use_featured_image'    => __( 'Use as featured image', 'advanced-team' ),
			'insert_into_item'      => __( 'Insert into item', 'advanced-team' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'advanced-team' ),
			'items_list'            => __( 'Items list', 'advanced-team' ),
			'items_list_navigation' => __( 'Items list navigation', 'advanced-team' ),
			'filter_items_list'     => __( 'Filter items list', 'advanced-team' ),
		);
		$args = array(
			'label'                 => __( 'Team Member', 'advanced-team' ),
			'description'           => __( 'Team for your site', 'advanced-team' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor','thumbnail','excerpt','comments' ),
			'taxonomies'            => array( 'team_category', 'advanced_team' ),
			'hierarchical'          => false,
			'rewrite' 				=> array( 'slug' => 'team' ),
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 30,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => false,
			'menu_icon'				=>	'dashicons-groups',
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => false,
			'capability_type'       => 'post',
		);
		register_post_type( 'advanced_team', $args );

	}
	public function ciat_register_team_taxonomies(){
		register_taxonomy(
			'team_category',
			'advanced_team',
			array(
				'label' => __( 'Category','advanced-team' ),
				'rewrite' => array( 'slug' => 'team_category' ),
				'hierarchical' => true,
			)
		);
	}
	public function ciat_team_register_metabox(){
		add_meta_box( 
			'team-meta-box-id', 
			__('Team Member Details','advanced-team'), 
			array($this,'team_metabox_callback'), 
			'advanced_team', 
			'normal', 
			'high' );
	}
	public function team_metabox_callback($post){
		wp_nonce_field( 'team_meta_box_nonce', 'team_meta_box_nonce' );
		$member=get_post_meta($post->ID,'iq_team_members');
		if(is_array($member))
			$member=reset($member);
		
		//echo $post->ID;
		?>
		<table style="width: 100%; text-align: left;">
			<tbody>
				<tr>
				<th><label for="member_name"> <?php _e('Name','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[name]" id="member_name" value="<?php echo isset($member['name']) ? esc_attr($member['name']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
				<th><label for="designation"> <?php _e('Designation','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[designation]" id="designation" value="<?php echo isset($member['designation']) ? esc_attr($member['designation']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
					<th colspan="2"> <h1><?php _e('Social Links','advanced-team'); ?></h1></th>
				</tr>
				<tr>
				<th><label for="fblink"> <?php _e('Facebook Link','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[fblink]" id="fblink" value="<?php echo isset($member['fblink']) ? esc_attr($member['fblink']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
				<th><label for="linkdinlink"> <?php _e('LinkdIn Link','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[linkdinlink]" id="linkdinlink" value="<?php echo isset($member['linkdinlink']) ? esc_attr($member['linkdinlink']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
				<th><label for="twitterlink"> <?php _e('Twitter Link','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[twitterlink]" id="twitterlink" value="<?php echo isset($member['twitterlink']) ? esc_attr($member['twitterlink']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
				<th><label for="gpluslink"> <?php _e('Google Plus Link','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[gpluslink]" id="gpluslink" value="<?php echo isset($member['gpluslink']) ? esc_attr($member['gpluslink']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
				<th><label for="pinterest"> <?php _e('Pinterest Link','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[pinterest]" id="pinterest" value="<?php echo isset($member['pinterest']) ? esc_attr($member['pinterest']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
				<th><label for="instagram"> <?php _e('Instagram Link','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[instagram]" id="instagram" value="<?php echo isset($member['instagram']) ? esc_attr($member['instagram']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
				<th><label for="reddit"> <?php _e('Reddit Link','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[reddit]" id="reddit" value="<?php echo isset($member['reddit']) ? esc_attr($member['reddit']) :''; ?>" class="widefat"></td>
				</tr>
				<tr>
				<th><label for="tumbler"> <?php _e('Tumblr Link','advanced-team'); ?></label></th>
				<td><input type="text" name="teammember[tumbler]" id="tumbler" value="<?php echo isset($member['tumbler']) ? esc_attr($member['tumbler']) :''; ?>" class="widefat"></td>
				</tr>
			</tbody>
		</table>
		<?php
	}
	public function save_team_meta_box_data($post_id){
		// Bail if we're doing an auto save
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	     
	    // if our nonce isn't there, or we can't verify it, bail
	    if( !isset( $_POST['team_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['team_meta_box_nonce'], 'team_meta_box_nonce' ) ) return;
	     
	    // if our current user can't edit this post, bail
	    if( !current_user_can( 'edit_post' ) ) return;
	    
	    // save 
	    if(isset($_POST['teammember'])){
	    	update_post_meta($post_id,'iq_team_members',$_POST['teammember']);
	    }
	}
	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advanced-team-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advanced-team-admin.js', array( 'jquery' ), $this->version, false );

	}

}
