<?php

/* labels SUR DASHBOARD*/
add_action('admin_menu', 'TSWD_plugin_setup_menu');
function TSWD_plugin_setup_menu()
{
    if (current_user_can('administrator')) {

        add_menu_page('TSWD Front-End Page', /*labels->*/ 'TSWD Front-End', 'manage_options', 'tswd-front-end-page', 'function_tswd_init', 'dashicons-editor-code');
        add_submenu_page('tswd-front-end-page', 'Submenu Page Title', 'Edit CSS', 'manage_options', 'plugin-editor.php?file=tswd-front-end%2Ffront-css.css&plugin=tswd-front-end%2Findex.php');
        add_submenu_page('tswd-front-end-page', 'Submenu Page Title', 'Edit JS', 'manage_options', 'plugin-editor.php?file=tswd-front-end%2Ffront-js.js&plugin=tswd-front-end%2Findex.php');
        add_submenu_page('tswd-front-end-page', 'Submenu Page Title', 'Edit FONTS', 'manage_options', 'plugin-editor.php?file=tswd-front-end%2Ffont-lib%2F-front-fonts.css&plugin=tswd-front-end%2Findex.php');
        add_submenu_page('tswd-front-end-page', 'Submenu Page Title', 'Admin Notes', 'manage_options', 'edit.php?post_type=dsn');
    }
}
add_action('admin_head', 'adminCss');

function adminCss()
{
    if (current_user_can('administrator')) {

        echo '<style>
#adminmenuwrap {
      min-height:100vh;
    }
  </style>';
    }
}
function function_tswd_init()
{

    if (current_user_can('administrator')) {

        echo '<div class="card-container">';
        echo '<div class="card" style="text-align:center;">';
        echo "<p><br /></p>";
        echo '<h1 style="text-align:center; white-space:nowrap;"><strong>TSWD</strong> Front-End Plugin</h1>';
        echo "<br /><br />";

        echo "<p>Import de tswd-front-css, fontFace.css et tswd-front-js<p/>";
        echo "<p>Monokai Thm / SVG Support / Agent BodyClass<p/>";
        echo "<p>Urls & ID's in listing / Duplicate posts<p/>";
        echo "<p>[lorem x=300] [year]<p/>";
        echo "<p>CTRL+S / Admin Notes / Server infos...<p/>";
        echo "<br />";
        echo "<br />";
        echo "<h2>EDITER FICHIERS</h2>";


        echo '<p><a href="' . get_bloginfo("wpurl") . '/wp-admin/plugin-editor.php?file=tswd-front-end%2Ffront-js.js&plugin=tswd-front-end%2Findex.php">tswd-front-js</a></p>';
        echo '<p><a href="' . get_bloginfo("wpurl") . '/wp-admin/plugin-editor.php?file=tswd-front-end%2Ffront-css.css&plugin=tswd-front-end%2Findex.php">tswd-front-css</a></p>';
        echo '<p><a href="' . get_bloginfo("wpurl") . '/wp-admin/plugin-editor.php?file=tswd-front-end%2Ffont-lib%2F-front-fonts.css&plugin=tswd-front-end%2Findex.php">Font-Face</a></p>';
        echo "<br />";
        echo "<h2>ADMIN NOTES</h2>";
        echo '<p><a href="' . get_bloginfo("wpurl") . '/wp-admin/post-new.php?post_type=dsn">Créer une note </a></p>';
        echo '<p><a href="' . get_bloginfo("wpurl") . '/wp-admin/edit.php?post_type=dsn">Liste des notes </a></p>';


        //echo'<img src="' . plugin_dir_url( __FILE__ ) . '/dist/Capture.JPG" style="width:99px; height:99px; border-radius:50%; box-shadow: 0px 0px 5px dimgray;opacity:0.9;">';
        echo "<br />";

        echo '<audio controls="" style="margin: .7em 2em 1em;" src="https://millepattes.ice.infomaniak.ch:80/millepattes-high"> </audio>';

        echo '<br /><br /><br /><br /><br /><span style="">TSWD</span><br /><br /></div>';
        echo '<div class="card" style="text-align:center;">';

        echo "<p><br /></p>";
        echo "<h2>DB INFOS</h2>";
        global $wpdb;
        echo "<p>dbname : $wpdb->dbname</p>";
        //echo"<p>dbuser : $wpdb->dbuser</p>";
        //echo"<p>dbhost : $wpdb->dbhost</p>";
        //echo"<i>db : ***$wpdb->dbpassword***</i>";
        echo "<br />";
        echo "<h2>PHPINFO</h2>";
        echo "<p>realpath : " . realpath("index.php") . "</p>";
        echo '<a target=_blank href="' . plugin_dir_url(__FILE__) . '/phpinfo.php';
        echo '">Go vers la page php_info</a>';

        echo "<p><br /></p>";


        echo '<h2>CODE MIRROR</h2>
<p><b>Auto-indent the current line or selection</b></p>
<p>Shift + Tab (CodeMirror)</p>

<p>https://defkey.com/codemirror-shortcuts#21246</p>
<p> </p>
<p><b>Replace</b></p>
<p>Shift + Ctrl + F (CodeMirror)</p>


<p>https://defkey.com/codemirror-shortcuts#21256</p>

<p>Shift + Alt + F</p>
</div>';


        echo '</div>';

        echo '<style>
audio{
	position:absolute;
	left:0;
	opacity: 0.6;
	transition-duration:500ms;
	width:40%;
}
audio:hover{
	opacity: 0.9;
	width:50%;

}
.card span{
font-weight: bold;
    font-size: 4em;
    color: #d5f1f2b3;
    font-style: italic;
    position: absolute;
    right: 40px;
    bottom: 80px;
    text-shadow: 0px 0px 1px grey;
    opacity: 0.5;
}
.card h1 strong{
font-weight: bold;
font-size: 1.5em;
position: relative;
text-shadow: 0px 0px 1px gray;
font-style: italic;
}
.card-container{
    display:flex;
        padding: 3% 0;

}
.card {

    width: 50%;
    margin:0 1%;
}

@media screen and (max-width:980px){

.card-container{
    flex-direction:column;
}
.card {

      width: 97%;
    max-width: 97%;
}
}

</style>';
    }
}



// ADMINBAR TSWD !!!!
// Add a parent shortcut link

function custom_toolbar_link($wp_admin_bar)
{
    if (current_user_can('administrator')) {


        $args = array(
            'id' => 'tswd-adminbar',
            'title' => '<span class="ab-icon dashicons dashicons-editor-code"></span> TSWD Front-End',
            'href' => 'admin.php?page=tswd-front-end-page',
            'meta' => array(
                'class' => 'tswd-adminbarr',
                'title' => 'Enjoy !'
            )
        );
        $wp_admin_bar->add_node($args);

        // Add the first child link

        $args = array(
            'id' => 'tswd-adminbar-tswd-front-css',
            'title' => 'Edit CSS',
            'href' => 'plugin-editor.php?file=tswd-front-end%2Ffront-css.css&plugin=tswd-front-end%2Findex.php',
            'parent' => 'tswd-adminbar',
            'meta' => array(
                'class' => 'tswd-adminbar-tswd-front-css'
            )
        );
        $wp_admin_bar->add_node($args);

        // Add another child link
        $args = array(
            'id' => 'tswd-adminbar-tswd-front-js',
            'title' => 'Edit JS',
            'href' => 'plugin-editor.php?file=tswd-front-end%2Ffront-js.js&plugin=tswd-front-end%2Findex.php',
            'parent' => 'tswd-adminbar',
            'meta' => array(
                'class' => 'tswd-adminbar-tswd-front-js'
            )
        );
        $wp_admin_bar->add_node($args);

        // Add another child link
        $args = array(
            'id' => 'tswd-adminbar-tswd-fonts',
            'title' => 'Edit FONTS',
            'href' => 'plugin-editor.php?file=tswd-front-end%2Ffont-lib%2F-front-fonts.css&plugin=tswd-front-end%2Findex.php',
            'parent' => 'tswd-adminbar',
            'meta' => array(
                'class' => 'tswd-adminbar-tswd-fonts'
            )
        );
        $wp_admin_bar->add_node($args);

        // Add another child link
        $args = array(
            'id' => 'tswd-adminbar-notes',
            'title' => 'Admin Notes',
            'href' => 'edit.php?post_type=dsn',
            'parent' => 'tswd-adminbar',
            'meta' => array(
                'class' => 'tswd-adminbar-notes'
            )
        );
        $wp_admin_bar->add_node($args);
    }
}
add_action('admin_bar_menu', 'custom_toolbar_link', 999);



/* ---------  Page listing  --------*/

add_action('admin_bar_menu', 'page_admin_bar_function', 999);

function page_admin_bar_function($wp_admin_bar)
{

    $args = array(
        'id' => 'page_list',
        'title' => 'Listing des pages',
        'href' => home_url() . '/wp-admin/edit.php?post_type=page'
    );
    $wp_admin_bar->add_node($args);

    $pages = recently_edited_pages();

    foreach ($pages as $page) {

        $args = array(
            'id' => 'page_item_' . $page->ID,
            'title' => $page->post_title,
            'parent' => 'page_list',
            'href' => home_url() . '/wp-admin/post.php?post=' . $page->ID . '&action=edit'
        );
        $wp_admin_bar->add_node($args);
    }
}

function recently_edited_pages()
{

    $args = array(
        'number' => 99,
        'sort_column' => 'post_modified',
        'sort_order' => 'desc'
    );

    $pages = get_pages($args);
    return $pages;
}

/********* POSTS ********/

add_action('admin_bar_menu', 'post_admin_bar_function', 999);

function post_admin_bar_function($wp_admin_bar)
{
    $posts = recently_edited_posts();

    if ( ! empty($posts) ) {
        $args = array(
            'id' => 'post_list',
            'title' => 'Listing des articles',
            'href' => home_url() . '/wp-admin/edit.php?post_type=post'
        );
        $wp_admin_bar->add_node($args);

        foreach ($posts as $post) {
            $args = array(
                'id' => 'post_item_' . $post->ID,
                'title' => $post->post_title,
                'parent' => 'post_list',
                'href' => home_url() . '/wp-admin/post.php?post=' . $post->ID . '&action=edit'
            );
            $wp_admin_bar->add_node($args);
        }
    }
}

function recently_edited_posts()
{
    $args = array(
        'numberposts' => 99,
        'orderby' => 'post_modified',
        'order' => 'DESC',
        'post_type' => 'post' // Assurez-vous que ce type correspond bien
    );

    $posts = get_posts($args);
    return $posts;
}

/********* PROJECTS DIVI ********/

add_action('admin_bar_menu', 'divi_project_admin_bar_function', 999);

function divi_project_admin_bar_function($wp_admin_bar)
{
    $projects = recently_edited_divi_projects();

    if ( ! empty($projects) ) {
        $args = array(
            'id' => 'divi_project_list',
            'title' => 'Listing des projets Divi',
            'href' => home_url() . '/wp-admin/edit.php?post_type=project'
        );
        $wp_admin_bar->add_node($args);

        foreach ($projects as $project) {
            $args = array(
                'id' => 'divi_project_item_' . $project->ID,
                'title' => $project->post_title,
                'parent' => 'divi_project_list',
                'href' => home_url() . '/wp-admin/post.php?post=' . $project->ID . '&action=edit'
            );
            $wp_admin_bar->add_node($args);
        }
    }
}

function recently_edited_divi_projects()
{
    $args = array(
        'numberposts' => 99,
        'orderby' => 'post_modified',
        'order' => 'DESC',
        'post_type' => 'project' // Assurez-vous que ce type correspond bien
    );

    $projects = get_posts($args);
    return $projects;
}
