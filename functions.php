<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

/************* INCLUDE NEEDED FILES ***************/

/*
1. library/bones.php
	- head cleanup (remove rsd, uri links, junk css, ect)
	- enqueueing scripts & styles
	- theme support functions
	- custom menu output & fallbacks
	- related post function
	- page-navi function
	- removing <p> from around images
	- customizing the post excerpt
	- custom google+ integration
	- adding custom fields to user profiles
*/
require_once( 'library/bones.php' ); // if you remove this, bones will break
/*
2. library/custom-post-type.php
	- an example custom post type
	- example custom taxonomy (like categories)
	- example custom taxonomy (like tags)
*/
// require_once( 'library/custom-post-type.php' ); // you can disable this if you like
/*
3. library/admin.php
	- removing some default WordPress dashboard widgets
	- an example custom dashboard widget
	- adding custom login css
	- changing text in footer of admin
*/
// require_once( 'library/admin.php' ); // this comes turned off by default
/*
4. library/translation/translation.php
	- adding support for other languages
*/
// require_once( 'library/translation/translation.php' ); // this comes turned off by default

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php
				/*
					this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
					echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<?php // custom gravatar call ?>
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<?php // end custom gravatar call ?>
				<?php printf(__( '<cite class="fn">%s</cite>', 'bonestheme' ), get_comment_author_link()) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>
				<?php edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
	<?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<label class="screen-reader-text" for="s">' . __( 'Search for:', 'bonestheme' ) . '</label>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . esc_attr__( 'Search the Site...', 'bonestheme' ) . '" />
	<input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
	</form>';
	return $form;
} // don't remove this bracket!


/************* INCBook Implementations *****************/

// Remove Post Types
add_action('admin_menu','remove_default_post_type');
function remove_default_post_type() {
	remove_menu_page('edit.php');
}

//Custom Post Article
function my_custom_post_article() {
	$labels = array(
		'name'               => _x( 'Articles', 'post type general name' ),
		'singular_name'      => _x( 'Article', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'article' ),
		'add_new_item'       => __( 'Add New Article' ),
		'edit_item'          => __( 'Edit Article' ),
		'new_item'           => __( 'New Article' ),
		'all_items'          => __( 'All Articles' ),
		'view_item'          => __( 'View Article' ),
		'search_items'       => __( 'Search Articles' ),
		'not_found'          => __( 'No articles found' ),
		'not_found_in_trash' => __( 'No articles found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Articles'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Book\'s articles' ,
		'public'        => true,
		'menu_position' => 5,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'revisions', 'author' ),
		'taxonomies' 	=> array('post_tag', 'category'),
		'has_archive'   => true,
	);
	register_post_type( 'article', $args );	
}
add_action( 'init', 'my_custom_post_article' );

// Create an Option Page for the theme
// http://net.tutsplus.com/tutorials/wordpress/how-to-create-a-better-wordpress-options-panel/
ob_start();

$themename = "IncBook";  
$shortname = "ib";

// add languages
$languages = array('en_GB');

$options = array (  
	array( "name" => $themename." Options",
	"type" => "title"),  
	  
	array( "name" => "General",  
	    "type" => "section"),  
	array( "type" => "open"),
	
	array( "name" => "Title",
	    "desc" => "Enter the title of the book",
	    "id" => $shortname."_title_text",
	    "type" => "text",
	    "std" => "Here goes the title of your book"),

	array( "name" => "Subtitle",
	    "desc" => "Enter the subtitle of the book",
	    "id" => $shortname."_subtitle_text",
	    "type" => "text",
	    "std" => "Here goes the subtitle of your book"),

	// how to add metadata for them?
	// std doesn't work...
	array( "name" => "Editors",
	    "desc" => "Enter the editors of the book",
	    "id" => $shortname."_editors",
	    "type" => "text",
	    "std" => "Here goes the subtitle of your book"),
	
	array( "name" => "Language",
	    "desc" => "Enter the language of the book",
	    "id" => $shortname."_lg",
	    "type" => "select",
	    "options" => $languages,
	    "std" => ""),
	
	array( "name" => "ISBN",
	    "desc" => "Enter the ISBN of the book",
	    "id" => $shortname."_isbn",
	    "type" => "text",
	    "std" => ""),

	array( "name" => "Publisher",
	    "desc" => "Enter the Publisher of the book",
	    "id" => $shortname."_publisher",
	    "type" => "text",
	    "std" => ""),

	array( "name" => "Subject",
	    "desc" => "Enter the subject of the book as keywords separated by a comma",
	    "id" => $shortname."_subject",
	    "type" => "textarea",
	    "std" => ""),

	array( "name" => "Description",
	    "desc" => "Enter a short description of the book",
	    "id" => $shortname."_desc",
	    "type" => "textarea",
	    "std" => ""),
	
	array( "name" => "Publication date",
	    "desc" => "Enter the publication date of the book",
	    "id" => $shortname."_date",
	    "type" => "text",
	    "std" => ""),
	    
	array( "name" => "Rights",
	    "desc" => "Enter the rights of the book",
	    "id" => $shortname."_rights",
	    "type" => "textarea",
	    "std" => ""),
	    	    	    	      
	array( "type" => "close")   
); 

function mytheme_add_init() {  
	$file_dir=get_bloginfo('template_directory');  
	wp_enqueue_style("functions", $file_dir."/functions/functions.css", false, "1.0", "all");
}

function mytheme_add_admin() {
global $themename, $shortname, $options;
	if ( $_GET['page'] == basename(__FILE__) ) {
		if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {  
	    	foreach ($options as $value) {
	        	if (isset($value['id']) && isset($_REQUEST[ $value['id'] ])) {
	        		update_option( $value['id'], $_REQUEST[ $value['id'] ] );
	        	}
	        }
	        foreach ($options as $value) {  
	    		if (isset($value['id']) && isset( $_REQUEST[ $value['id'] ])) {
	    			update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); 
	    		} else if (isset($value['id']) && isset($_REQUEST[ $value['id'] ])) { 
	    			delete_option( $value['id'] ); 
	    		} 
	    	}  
	    	header("Location: admin.php?page=functions.php&saved=true");  
	    	die;
	    } else if( isset($_REQUEST['action']) && 'reset' == $_REQUEST['action'] ) {  
	    	foreach ($options as $value) {  
	        	delete_option( $value['id'] ); 
	        }  
	        header("Location: admin.php?page=functions.php&reset=true");  
	        die;  
	    }  
	}    
	add_menu_page($themename, $themename, 'administrator', basename(__FILE__), 'mytheme_admin');  
}
 
function mytheme_admin() {
 
global $themename, $shortname, $options;
$i=0;
 
if(isset($_REQUEST['saved'])) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if(isset($_REQUEST['reset'])) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
 
?>
<div class="wrap rm_wrap">
	<h2><?php echo $themename; ?> Settings</h2>
	<div class="rm_opts">
		<form method="post">
		<?php foreach ($options as $value) {  
		switch ( $value['type'] ) {  
			case "open": ?>  
			<?php break;  
			case "close": ?>
	</div>  
</div>  
<br />
	  		<?php break;  
		  	case "title": ?>  
		  	<p>To easily use the <?php echo $themename;?> theme, you can use the menu below.</p>  
		  	<?php break;  
			case 'text': ?>    
			<div class="rm_input rm_text">  
		    	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>  
		    	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />  
		    	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>  
		    </div>  
		    <?php break;
		    case 'textarea':?>    
		    <div class="rm_input rm_textarea">  
		    	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>  
		    	<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>  
		    	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>  
		    </div>  
		    <?php break;  
		    case 'select': ?>  
		    <div class="rm_input rm_select">  
		    	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>  
		    	<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">  
		    <?php foreach ($value['options'] as $option) { ?>  
			    	<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>  
		    	</select>  
		    	<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>  
		    </div>  
		    <?php break;  
			case "checkbox": ?>  
			<div class="rm_input rm_checkbox">  
				<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>  
				<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>  
				<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />  
				<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>  
			</div>  
			<?php break; 
			case "section":  
			$i++;
			?>  
			<div class="rm_section">  
				<div class="rm_title">
					<h3><?php echo $value['name']; ?></h3>
					<span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="Save changes" /></span>
					<div class="clearfix">
				</div>
			</div>  
			<div class="rm_options">  
			<?php break;
				}  
			}  
			?>  
			<input type="hidden" name="action" value="save" />  
		</form>  
		<form method="post">  
			<p class="submit">  
				<input name="reset" type="submit" value="Reset" />  
				<input type="hidden" name="action" value="reset" />  
			</p>  
		</form>
	</div>
<?php  
}  
?>
<?php  
add_action('admin_init', 'mytheme_add_init');  
add_action('admin_menu', 'mytheme_add_admin');  

// Create Colophon Page on theme activation (it created 4 of them)
/*
add_action( 'after_setup_theme', 'colophon_page_create' );

function colophon_page_create() {
	$my_post = array(
	  'post_title'    => 'Colophon',
	  'post_content'  => 'This is the book colophon',
	  'post_status'   => 'publish',
	  'post_author'   => 1,
	  'post_type'     => 'page'
	);
	
	// Insert the post into the database
	wp_insert_post( $my_post );
}
*/

?>
