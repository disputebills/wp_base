<?php 
      
  register_sidebar(array(
    'name' => 'Sidebar Widgets',
    'id'   => 'sidebar-widgets',
    'description'   => 'These are widgets for the sidebar.',
    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
    'after_widget'  => '</div>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ));

  add_theme_support('nav-menus');
  add_action( 'init', 'register_my_menu' );
  function register_my_menu() {
    register_nav_menu( 'main-nav', __( 'Main Nav' ) );
  }
  
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'automatic_feed_links' );
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
  
    
  add_filter('widget_text', 'do_shortcode');
  
  function category_id_class($classes) {
    global $post;
    foreach((get_the_category($post->ID)) as $category)
      $classes [] = 'cat-' . $category->cat_ID . '-id';
    return $classes;
  }
  add_filter('post_class', 'category_id_class');
  add_filter('body_class', 'category_id_class');

  add_action('wp_enqueue_scripts', 'base_register_scripts');
  function base_register_scripts() {
    wp_deregister_script('jquery');
    wp_deregister_script( 'l10n' );

    $jQuery = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js";
    $test   = @fopen($jQuery,'r'); 
    if ( $test === false ) { 
      $jQuery = get_template_directory_uri() . '/js/jquery.min.js';
    }

    wp_register_script('jquery', $jQuery, false, '1.8.2', true);
    wp_enqueue_script('jquery');
     
    wp_register_script('base_plugins', '/wp-content/themes/base/js/plugins.min.js', array('jquery'), '1', true );
    wp_enqueue_script('base_plugins');
    
    wp_register_script('base_functions', '/wp-content/themes/base/js/script.min.js', array('jquery', 'base_plugins'), '1', true );
    wp_enqueue_script('base_functions');    
    
    wp_register_style('base_styles', '/wp-content/themes/base/css/style.css', '', '1', 'all');
    wp_enqueue_style('base_styles');
    
  }

  function complete_version_removal() { return ''; }
  add_filter('the_generator', 'complete_version_removal');
  remove_filter('pre_user_description',    'wp_filter_kses');
  remove_filter('pre_comment_content',     'wp_rel_nofollow');
  add_filter   ('get_comment_author_link', 'xwp_dofollow');
  add_filter   ('post_comments_link',      'xwp_dofollow');
  add_filter   ('comment_reply_link',      'xwp_dofollow');
  add_filter   ('comment_text',            'xwp_dofollow');
  
  function jtd_allow_rel() {
    global $allowedtags;
    $allowedtags['a']['rel'] = array ();
  }
  add_action( 'wp_loaded', 'jtd_allow_rel' );
  
  function jtd_add_google_profile( $contactmethods ) {
    // Add Google Profiles
    $contactmethods['google_profile'] = 'Google Profile URL';
    $contactmethods['facebook']       = 'Facebook';
    $contactmethods['twitter']        = 'Twitter';
    unset($contactmethods['aim']);
    unset($contactmethods['yim']);    
    unset($contactmethods['jabber']);
    return $contactmethods;
  }
  add_filter( 'user_contactmethods', 'jtd_add_google_profile', 10, 1);

add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
      global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	if($is_lynx) $classes[] = 'lynx';
	elseif($is_gecko) $classes[] = 'gecko';
	elseif($is_opera) $classes[] = 'opera';
	elseif($is_NS4) $classes[] = 'ns4';
	elseif($is_safari) $classes[] = 'safari';
	elseif($is_chrome) $classes[] = 'chrome';
	elseif($is_IE) $classes[] = 'ie';
	else $classes[] = 'unknown';

	if($is_iphone) $classes[] = 'iphone';
	return $classes;
}


function jtd_googleplus_contactmethod( $contactmethods ) {
    if ( ! isset( $contactmethods['googleplus'] ) )
        $contactmethods['googleplus'] = 'Google+';
    return $contactmethods;
}
add_filter( 'user_contactmethods', 'jtd_googleplus_contactmethod' );
add_action( 'wp_head', 'jtd_googleplus_header' );
function jtd_googleplus_header() {
    if ( is_singular() ) {
        $gplus_link = get_the_author_meta( 'googleplus', get_current_user_id() );
        if ( $gplus_link )
            echo '<link rel="author" href="' . $gplus_link . '" />';
    }
}

function jtd_opengraph_for_posts() {
    if ( is_singular() ) {
        global $post;
        setup_postdata( $post );
        $output = '<meta property="og:type" content="article" />' . "\n";
        $output .= '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '" />' . "\n";
        $output .= '<meta property="og:url" content="' . get_permalink() . '" />' . "\n";
        $output .= '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '" />' . "\n";
        if ( has_post_thumbnail() ) {
            $imgsrc = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
            $output .= '<meta property="og:image" content="' . $imgsrc[0] . '" />' . "\n";
        }
        echo $output;
    }
}
add_action( 'wp_head', 'jtd_opengraph_for_posts' );