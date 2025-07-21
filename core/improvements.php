<?php
// Logo de connexion = favicon
function tswd_custom_login_logo() {
    $tswd_site_icon_id = get_option('site_icon');
    if (!$tswd_site_icon_id) return;
    $tswd_favicon_url = wp_get_attachment_image_url($tswd_site_icon_id, 'full');
    echo '<style>
        h1 a {
            background-image: url("'.$tswd_favicon_url.'") !important;
        }
    </style>';
}
add_action('login_head', 'tswd_custom_login_logo');

//show_admin_bar(false);

// default_image_size original
function tswd_set_default_image_size() {
    update_option('image_default_size', 'full');
}
add_action('after_setup_theme', 'tswd_set_default_image_size');

// Désactiver les notifications de mise à jour du core pour les utilisateurs non administrateurs
add_action('admin_init', function() { if (!current_user_can('administrator')) remove_action('admin_notices', 'update_nag', 3); });

//CLASSIC WIDGETS

add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );


//Enlver logo wp

function remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
}
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );


/*--------Made with love-------*/
function remove_footer_admin()
{
    echo 'Made with ♥';
}

add_filter('admin_footer_text', 'remove_footer_admin');


/* -----  [year] ------ -----------*/

function year_shortcode()
{
    $year = date('Y');
    return $year;
}
add_shortcode('year', 'year_shortcode');

/* -----  [lorem x=300] ------ -----------*/

function custom_lorem_function($clf_attributes)
{
    $dummyLorem = explode(" ", "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, se d diam voluptua. At vero eos et accusam et jus to duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata  sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt  ut labore et dolore magna aliquyam erat, sed d iam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.  Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.");
    extract(shortcode_atts(array(
        'x' => 300
    ), $clf_attributes));
    $counter    = 0;
    $returnText = array();

    while ($counter <= $x) {
        array_push($returnText, $dummyLorem[$counter % count($dummyLorem)]);
        $counter++;
    }
    return implode(" ", $returnText);
}
add_shortcode('lorem', 'custom_lorem_function');






//Rester connecté 1an
add_filter('auth_cookie_expiration', 'stay_logged_in_for_1_year');
function stay_logged_in_for_1_year($expire)
{
    return 31556926; // 1 year in seconds
}
//WP turns normal quotes to smart codes, which could break the code snippet you're about to publish
remove_filter('the_content', 'wptexturize');


//------------------épure le noms des fichiers médias
add_filter('sanitize_file_name', 'remove_accents');

//----------------- se souvenir de moi coché
function sf_check_rememberme()
{
    global $rememberme;
    $rememberme = 1;
}
add_action("login_form", "sf_check_rememberme");

//------------------ phrase du bas panneau admin
/*function remove_footer_admin () {
echo '<span>Merci d\'avoir fait appel à <a href="https://www.tswd.fr">Nous</a> pour votre site.';
}
add_filter('admin_footer_text', 'remove_footer_admin');*/

//-------------------CLEAN THE HEADER
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wp_resource_hints', 2);
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
function my_deregister_scripts()
{
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'my_deregister_scripts');


// ----------------- virer versions wordpress
//function remove_version() {
//  return '';
//}
//add_filter('the_generator', 'remove_version');
//// ------------------ virer notifications de MAJ
//// supprimer les notifications du core MAJ
//add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );
//// supprimer les notifications de thèmes MAJ
//remove_action( 'load-update-core.php', 'wp_update_themes' );
//add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );
//// supprimer les notifications de plugins MAJ
//remove_action( 'load-update-core.php', 'wp_update_plugins' );
//add_filter( 'pre_site_transient_update_plugins', create_function( '$a', "return null;" ) );

//------------------Duplicate posts and pages

function rd_duplicate_post_as_draft()
{
    global $wpdb;
    if (!(isset($_GET['post']) || isset($_POST['post']) || (isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action']))) {
        wp_die('No post to duplicate has been supplied!');
    }
    if (!isset($_GET['duplicate_nonce']) || !wp_verify_nonce($_GET['duplicate_nonce'], basename(__FILE__)))
        return;
    $post_id         = (isset($_GET['post']) ? absint($_GET['post']) : absint($_POST['post']));
    $post            = get_post($post_id);
    $current_user    = wp_get_current_user();
    $new_post_author = $current_user->ID;
    if (isset($post) && $post != null) {
        $args        = array(
            'comment_status' => $post->comment_status,
            'ping_status' => $post->ping_status,
            'post_author' => $new_post_author,
            'post_content' => $post->post_content,
            'post_excerpt' => $post->post_excerpt,
            'post_name' => $post->post_name,
            'post_parent' => $post->post_parent,
            'post_password' => $post->post_password,
            'post_status' => 'draft',
            'post_title' => $post->post_title,
            'post_type' => $post->post_type,
            'to_ping' => $post->to_ping,
            'menu_order' => $post->menu_order
        );
        $new_post_id = wp_insert_post($args);
        $taxonomies  = get_object_taxonomies($post->post_type);
        foreach ($taxonomies as $taxonomy) {
            $post_terms = wp_get_object_terms($post_id, $taxonomy, array(
                'fields' => 'slugs'
            ));
            wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
        }
        $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
        if (count($post_meta_infos) != 0) {
            $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            foreach ($post_meta_infos as $meta_info) {
                $meta_key = $meta_info->meta_key;
                if ($meta_key == '_wp_old_slug')
                    continue;
                $meta_value      = addslashes($meta_info->meta_value);
                $sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
            }
            $sql_query .= implode(" UNION ALL ", $sql_query_sel);
            $wpdb->query($sql_query);
        }
        wp_redirect(admin_url('post.php?action=edit&post=' . $new_post_id));
        exit;
    } else {
        wp_die('Post creation failed, could not find original post: ' . $post_id);
    }
}
add_action('admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft');

function rd_duplicate_post_link($actions, $post)
{
    if (current_user_can('edit_posts')) {
        $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce') . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
    }
    return $actions;
}
add_filter('post_row_actions', 'rd_duplicate_post_link', 10, 2);
add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);



// set different colors for pages/posts in different statuses
add_action('admin_footer', 'posts_status_color');
function posts_status_color()
{
?>
   <style>
        .status-draft{background: rgba(255, 255, 76, 0.12) !important;}
        .status-pending{background: rgba(0, 200, 255, 0.18) !important;}
        .status-publish{/* no background keep wp alternating colors */}
        .status-future{background: #C6EBF5 !important;}
        .status-private{background: rgba(255, 0, 0, 0.12) !important;}
.post-password-required{background: rgba(0, 0, 0, 0.12) !important;}
    </style>
    <?php
}


// Add ID's to posts & pages overviews
add_filter('manage_posts_columns', 'posts_columns_id', 5);
add_action('manage_posts_custom_column', 'posts_custom_id_columns', 5, 2);
add_filter('manage_pages_columns', 'posts_columns_id', 5);
add_action('manage_pages_custom_column', 'posts_custom_id_columns', 5, 2);

function posts_columns_id($defaults)
{
    $defaults['wps_post_id'] = __('ID');
    return $defaults;
}
function posts_custom_id_columns($column_name, $id)
{
    if ($column_name === 'wps_post_id') {
        echo $id;
    }
}
add_action('admin_head', 'custom_admin_styling');
function custom_admin_styling()
{
    echo '<style type="text/css">';
    echo 'th#wps_post_id{width:50px;}';
    echo '</style>';
}
//-----------------page url in listing !!
add_filter('manage_page_posts_columns', 'my_custom_column', 10);
add_action('manage_page_posts_custom_column', 'add_my_custom_column', 10, 2);


function my_custom_column($defaults)
{
    $defaults['url'] = 'URL';
    return $defaults;
}

function add_my_custom_column($column_name, $post_id)
{
    if ($column_name == 'url') {
        echo get_permalink($post_id);
    }
}

// Show full URL in media library overview !
function muc_column($cols)
{
    $cols["media_url"] = "URL";
    return $cols;
}
function muc_value($column_name, $id)
{
    if ($column_name == "media_url")
        echo '<input type="text" width="100%" onclick="jQuery(this).select();" value="' . wp_get_attachment_url($id) . '" />';
}
add_filter('manage_media_columns', 'muc_column');
add_action('manage_media_custom_column', 'muc_value', 10, 2);


// Add itemprop image markup to img tags
add_filter('the_content', 'vmf_add_itemprop_image_markup', 2);
function vmf_add_itemprop_image_markup($content)
{
    $string  = '<img';
    $replace = '<img itemprop="image"';
    $content = str_replace($string, $replace, $content);
    return $content;
}


// User agent and OS detection & add body class
function mv_browser_body_class($classes)
{
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    if ($is_lynx)
        $classes[] = 'lynx';
    elseif ($is_gecko)
        $classes[] = 'gecko';
    elseif ($is_opera)
        $classes[] = 'opera';
    elseif ($is_NS4)
        $classes[] = 'ns4';
    elseif ($is_safari)
        $classes[] = 'safari';
    elseif ($is_chrome)
        $classes[] = 'chrome';
    elseif ($is_IE) {
        $classes[] = 'ie';
        if (preg_match('/MSIE ([0-9]+)([a-zA-Z0-9.]+)/', $_SERVER['HTTP_USER_AGENT'], $browser_version))
            $classes[] = 'ie' . $browser_version[1];
    } else
        $classes[] = 'unknown';
    if ($is_iphone)
        $classes[] = 'iphone';
    if (stristr($_SERVER['HTTP_USER_AGENT'], "mac")) {
        $classes[] = 'osx';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "linux")) {
        $classes[] = 'linux';
    } elseif (stristr($_SERVER['HTTP_USER_AGENT'], "windows")) {
        $classes[] = 'windows';
    }
    return $classes;
}
add_filter('body_class', 'mv_browser_body_class');


?>
