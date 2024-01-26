<?php
class dashboard_TSWD_notes {

	function __construct() {
		add_action( 'init', array(&$this, 'dashboard_TSWD_notes_init') );
		add_action( 'wp_dashboard_setup', array(&$this, 'dashboard_TSWD_notes_wp_dashboard_setup') );
		add_action( 'add_meta_boxes', array(&$this, 'dashboard_TSWD_notes_add_meta_boxes') );
		add_action( 'save_post', array(&$this, 'dashboard_TSWD_notes_save_post'), 100 );
	}
	
	function dashboard_TSWD_notes_init() {
		if ( function_exists('load_plugin_textdomain') ) :
			if ( !defined('WP_PLUGIN_DIR') ) 
				load_plugin_textdomain('dashboard-TSWD-notes', str_replace( ABSPATH, '', dirname(__FILE__) ) );
			else
				load_plugin_textdomain('dashboard-TSWD-notes', false, dirname( plugin_basename(__FILE__) ) );
		endif;

		$labels = array(
			'name'               => __( 'Dashboard Notes', 'dashboard-TSWD-notes' ),
			'singular_name'      => __( 'Dashboard Note', 'dashboard-TSWD-notes' ),
			'menu_name'          => __( 'Dashboard Notes', 'dashboard-TSWD-notes' ),
			'name_admin_bar'     => __( 'Dashboard Note', 'dashboard-TSWD-notes' ),
			'add_new'            => __( 'Add New', 'dashboard-TSWD-notes' ),
			'add_new_item'       => __( 'Add New Dashboard Note', 'dashboard-TSWD-notes' ),
			'new_item'           => __( 'New TSWD Note', 'dashboard-TSWD-notes' ),
			'edit_item'          => __( 'Edit Dashboard Note', 'dashboard-TSWD-notes' ),
			'view_item'          => __( 'View Dashboard Note', 'dashboard-TSWD-notes' ),
			'all_items'          => __( 'All Dashboard Notes', 'dashboard-TSWD-notes' ),
			'search_items'       => __( 'Search Dashboard Notes', 'dashboard-TSWD-notes' ),
			'not_found'          => __( 'No Dashboard Notes found.', 'dashboard-TSWD-notes' ),
			'not_found_in_trash' => __( 'No Dashboard Notes found in Trash.', 'dashboard-TSWD-notes' )
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'query_var'           => false,
			'rewrite'             => false,
			'capability_type'     => 'post',
			'has_archive'         => false,
			'hierarchical'        => false,
			'menu_position'       => 100,
			'menu_icon'           => 'dashicons-welcome-write-blog',
			'supports'            => array( 'title', 'editor', 'author' )
		);
		register_post_type( 'dsn', $args );		
	}
	
	function dashboard_TSWD_notes_wp_dashboard_setup() {
		global $current_user;
		$posts = get_posts( array( 'post_type' => 'dsn' ) );

		if ( !empty($posts) && is_array($posts) ) :
			foreach ( $posts as $key => $post ) :
				$dsn_context  = get_post_meta($post->ID, 'dsn_context', true);
				$dsn_priority = get_post_meta($post->ID, 'dsn_priority', true);
				$dsn_target   = get_post_meta($post->ID, 'dsn_target', true);
			
				if ( is_array($dsn_target) && in_array($current_user->roles[0], $dsn_target) ) :
					add_meta_box( 'dsn-'.$post->ID, $post->post_title, array(&$this, 'dashboard_TSWD_notes_post_content'), 'dashboard', $dsn_context, $dsn_priority, $post );
				endif;
			endforeach;
		endif;
	}
	
	function dashboard_TSWD_notes_post_content( $var, $args ) {
		echo do_shortcode(wpautop($args['args']->post_content));
	}
	
	function dashboard_TSWD_notes_add_meta_boxes() {
		add_meta_box('dsndiv', __('Output Option', 'dashboard-TSWD-notes'), array(&$this, 'dashboard_TSWD_notes_add_meta_box'), 'dsn', 'side', 'core');		
	}
	
	function dashboard_TSWD_notes_add_meta_box() {
		global $post;

		$dsn_context  = get_post_meta($post->ID, 'dsn_context', true);
		$dsn_priority = get_post_meta($post->ID, 'dsn_priority', true);
		$dsn_target   = get_post_meta($post->ID, 'dsn_target', true);
		if ( empty($dsn_target) ) $dsn_target = array('administrator');
?>
<p><label for="dsn_context"><?php _e('Context', 'dashboard-TSWD-notes'); ?></label>
<select name="dsn_context" id="dsn_context">
<option value="normal"<?php selected('normal', $dsn_context); ?>><?php _e('Normal', 'dashboard-TSWD-notes'); ?></option>
<option value="side"<?php selected('side', $dsn_context); ?>><?php _e('Side', 'dashboard-TSWD-notes'); ?></option>
</select></p>

<p><label for="dsn_priority"><?php _e('Priority', 'dashboard-TSWD-notes'); ?></label>
<select name="dsn_priority" id="dsn_priority">
<option value="high"<?php selected('high', $dsn_priority); ?>><?php _e('High', 'dashboard-TSWD-notes'); ?></option>
<option value="low"<?php selected('low', $dsn_priority); ?>><?php _e('Low', 'dashboard-TSWD-notes'); ?></option>
</select></p>


<p><label for="dsn_target"><?php _e('Target', 'dashboard-TSWD-notes'); ?></label>
<select name="dsn_target[]" id="dsn_target" multiple="multiple">
<?php
	$editable_roles = array_reverse( get_editable_roles() );

	foreach ( $editable_roles as $role => $details ) :
		$name = translate_user_role($details['name'] );
		if ( in_array($role, $dsn_target) ) 
			echo "\n\t".'<option selected="selected" value="' . esc_attr($role) . '">' . $name . '</option>';
		else
			echo "\n\t".'<option value="' . esc_attr($role) . '">' . $name . '</option>';
	endforeach;
?>
</select></p>
<script type="text/javascript">
// <![CDATA[
jQuery('#dsn_target option').mousedown(function(e) {
    e.preventDefault();
    jQuery(this).prop('selected', !jQuery(this).prop('selected'));
    return false;
});
//-->
</script>
<?php
	}
	
	function dashboard_TSWD_notes_save_post() {
		global $post, $post_id;
		
		if ( !isset($post->post_type) || $post->post_type != 'dsn' ) return;
				
		$dsn_context  = isset($_POST['dsn_context']) ? $_POST['dsn_context'] : null;
		$dsn_priority = isset($_POST['dsn_priority']) ? $_POST['dsn_priority'] : null;
		$dsn_target   = isset($_POST['dsn_target']) ? $_POST['dsn_target'] : null;

		if ( !empty($dsn_context) ) update_post_meta( $post_id, 'dsn_context', $dsn_context );
		if ( !empty($dsn_priority) ) update_post_meta( $post_id, 'dsn_priority', $dsn_priority );
		if ( !empty($dsn_target) ) update_post_meta( $post_id, 'dsn_target', $dsn_target );
	}
}
$dashboard_TSWD_notes = new dashboard_TSWD_notes();
?>