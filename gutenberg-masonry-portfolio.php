<?php
/**
 * Plugin Name:       Gutenberg Masonry Portfolio
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       gutenberg-masonry-portfolio
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

class Gutenberg_Masonry_Porfolio {
	function __construct() {
		// Block API
		add_action( 'init', array( $this, 'create_block_gutenberg_masonry_portfolio_block_init' ) );

		// Post Type and Taxonomies
		add_action( 'init', array( $this, 'register_portfolio_categories_taxonomy' ) );
		add_action( 'init', array( $this, 'register_portfolio_tags_taxonomy' ) );
		add_action( 'init', array( $this, 'register_portfolio_post_type' ) );

		// Rest API
		add_filter( 'rest_prepare_bws_portfolio_post', array( $this, 'prepare_data_to_rest_bws_portfolio_post' ), 10, 3 );
	}

	function register_portfolio_categories_taxonomy() {
		register_taxonomy( 'bws_portfolio_cat', 'bws_portfolio_post', array(
			'show_in_rest'	=> true,
			'labels'		=> array(
				'name'							=> __( 'Portfolio Categories', 'gutenberg-masonry-portfolio' ),
				'singular_name'					=> __( 'Portfolio Category', 'gutenberg-masonry-portfolio' ),
				'search_items'					=> __( 'Search Portfolio Categories', 'gutenberg-masonry-portfolio' ),
				'popular_items' 				=> __( 'Popular Portfolio Categories', 'gutenberg-masonry-portfolio' ),
				'all_items'						=> __( 'All Portfolio Categories', 'gutenberg-masonry-portfolio' ),
				'parent_item'					=> __( 'Parent Portfolio Category', 'gutenberg-masonry-portfolio' ),
				'parent_item_colon'				=> __( 'Parent Portfolio Category:', 'gutenberg-masonry-portfolio' ),
				'edit_item'						=> __( 'Edit Portfolio Category', 'gutenberg-masonry-portfolio' ),
				'update_item'					=> __( 'Update Portfolio Category', 'gutenberg-masonry-portfolio' ),
				'add_new_item'					=> __( 'Add New Portfolio Category', 'gutenberg-masonry-portfolio' ),
				'view_item'						=> __( 'View Portfolio Category', 'gutenberg-masonry-portfolio' ),
				'not_found'						=> __( 'Portfolio Categories not found', 'gutenberg-masonry-portfolio' ),
				'back_to_items'					=> __( 'Go to Portfolio Categories', 'gutenberg-masonry-portfolio' ),
			),
			'hierarchical'	=> true
		) );
	}

	function register_portfolio_tags_taxonomy() {
		register_taxonomy( 'bws_portfolio_tag', 'bws_portfolio_post', array(
			'show_in_rest'	=> true,
			'labels'		=> array(
				'name'							=> __( 'Portfolio Tags', 'gutenberg-masonry-portfolio' ),
				'singular_name'					=> __( 'Portfolio Tag', 'gutenberg-masonry-portfolio' ),
				'search_items'					=> __( 'Search Portfolio Tags', 'gutenberg-masonry-portfolio' ),
				'popular_items' 				=> __( 'Popular Portfolio Tags', 'gutenberg-masonry-portfolio' ),
				'all_items'						=> __( 'All Portfolio Tags', 'gutenberg-masonry-portfolio' ),
				'edit_item'						=> __( 'Edit Portfolio Tag', 'gutenberg-masonry-portfolio' ),
				'update_item'					=> __( 'Update Portfolio Tag', 'gutenberg-masonry-portfolio' ),
				'add_new_item'					=> __( 'Add New Portfolio Tag', 'gutenberg-masonry-portfolio' ),
				'view_item'						=> __( 'View Portfolio Tag', 'gutenberg-masonry-portfolio' ),
				'separate_items_with_commas'	=> __( 'Separate Portfolio Tags with commas', 'gutenberg-masonry-portfolio' ),
				'add_or_remove_items'			=> __( 'Add or Remove Portfolio Tags', 'gutenberg-masonry-portfolio' ),
				'choose_from_most_used'			=> __( 'Choose from the most used Portfolio Tags', 'gutenberg-masonry-portfolio' ),
				'not_found'						=> __( 'Portfolio Tags not found', 'gutenberg-masonry-portfolio' ),
				'back_to_items'					=> __( 'Go to Portfolio Tags', 'gutenberg-masonry-portfolio' ),
			)
		) );
	}

	function register_portfolio_post_type() {
		register_post_type( 'bws_portfolio_post', array(
			'taxonomies'		=> array( 'bws_portfolio_cat', 'bws_portfolio_tag' ),
			'public' 			=> true,
			'show_in_rest'		=> true,
			'supports' 			=> array( 'title', 'editor', 'thumbnail' ),
			'menu_postition'	=> 4,
			'labels'			=> array(
				'name'                     => __( 'Portfolio Items', 'gutenberg-masonry-portfolio' ), // The main name for a post type, usually in the plural.
				'singular_name'            => __( 'Portfolio Item', 'gutenberg-masonry-portfolio' ), // The name for one post of that type.
				'add_new'                  => __( 'Add New', 'gutenberg-masonry-portfolio' ), // Text for adding a new post, like "add new" in posts in the admin panel.
												// If you want to use a translation of the title, type it like this: _x('Add New', 'product');
				'add_new_item'             => __( 'Add New Portfolio Item', 'gutenberg-masonry-portfolio' ), // Title text of the newly created post in the admin panel. As "Add New Post" for posts.
				'edit_item'                => __( 'Edit Portfolio Item', 'gutenberg-masonry-portfolio' ), // The text to edit the post type. Default: edit post/edit page.
				'new_item'                 => __( 'New Portfolio Item', 'gutenberg-masonry-portfolio' ), // New post text. Default: "New post."
				'view_item'                => __( 'View Portfolio Item', 'gutenberg-masonry-portfolio' ), // Text to view a post of this post type. Default: "View post"/"View page".
				'search_items'             => __( 'Search Portfolio Item', 'gutenberg-masonry-portfolio' ), // Search text for these post types. Default: "Find post"/"find page".
				'not_found'                => __( 'No Portfolio Items was found', 'gutenberg-masonry-portfolio' ), // Text if the search did not find anything.
												// Default: "No post was found"/"No page was found".
				'not_found_in_trash'       => __( 'No Portfolio Items was found in Trash', 'gutenberg-masonry-portfolio' ), // Text if nothing was found in the trash.
												// Default is: "No posts found in Trash"/"No pages found in Trash".
				'all_items'                => __( 'All Portfolio Items', 'gutenberg-masonry-portfolio' ), // All posts. The default is "All Posts"/"All Pages".
				//'archives'                 => '', // Posts Archives. Defaults to value of all_items field.
				'insert_into_item'         => __( 'Insert in Portfolio Item', 'gutenberg-masonry-portfolio' ), // Insert in post.
				'uploaded_to_this_item'    => __( 'Loaded for this Portfolio Item', 'gutenberg-masonry-portfolio' ), // Loaded for this post.
				'featured_image'           => __( 'Portfolio Items thumbnail', 'gutenberg-masonry-portfolio' ), // Posts thumbnail.
				'set_featured_image'       => __( 'Set Portfolio Item thumbnail', 'gutenberg-masonry-portfolio' ), // Set post thumbnail.
				'remove_featured_image'    => __( 'Delete Portfolio Item thumbnail', 'gutenberg-masonry-portfolio' ), // Delete post thumbnail.
				'use_featured_image'       => __( 'Use Portfolio Item thumbnail', 'gutenberg-masonry-portfolio' ), // Use as post thumbnail.
				'filter_items_list'        => __( 'Filter Portfolio Item list', 'gutenberg-masonry-portfolio' ), // Filter post list.
				'items_list_navigation'    => __( 'Naigate though Porfolio Items', 'gutenberg-masonry-portfolio' ), // Navigate through postings.
				'items_list'               => __( 'List of Portfolio Items', 'gutenberg-masonry-portfolio' ), // List of posts.
				'view_items'               => __( 'View Portfolio Items', 'gutenberg-masonry-portfolio' ), // Name in toolbar, for archive page of post type. Default: "View Posts" / "View Pages". FROM WP 4.7.
				'attributes'               => __( 'Portfolio Item attributes', 'gutenberg-masonry-portfolio' ), // Name for post attributes metabox (for pages it is "Page Attributes" metabox).
												// Default: "Post Attributes" or "Page Attributes". FROM WP 4.7.
				'item_updated'             => __( 'Portfolio Item updated', 'gutenberg-masonry-portfolio' ), // Note text in the post editor when the post is updated. FROM WP 5.0.
												// Default: "Post updated." / "Page updated."
				'item_published'           => __( 'Portfolio Item published', 'gutenberg-masonry-portfolio' ), // Note text in post editor when a post is published. FROM WP 5.0.
												// Default: "Post published." / "Page published."
				'item_published_privately' => __( 'Portfolio Item published privately', 'gutenberg-masonry-portfolio' ), // Note text in post editor when private post is published. FROM WP 5.0.
												// Default: "Post published privately." / "Page published privately."
				'item_reverted_to_draft'   => __( 'Portfolio Item reverted to draft', 'gutenberg-masonry-portfolio' ), // The text of a note in the post editor when the post is returned to draft. FROM WP 5.0.
												// Default: "Post reverted to draft." / "Page reverted to draft."
				'item_scheduled'           => __( 'Portfolio Item scheduled', 'gutenberg-masonry-portfolio' ), // Note text in the post editor when a post is scheduled for a future date. FROM WP 5.0.
												// Default: "Post scheduled." / "Page scheduled."
			)
		) );
	}

	function render_react_root( $attributes ) {
		/* if ( ! is_admin() ) {
			// Automatically load dependencies and version
			$asset_file = include( plugin_dir_path( __FILE__ ) . 'build/frontend.asset.php');
			wp_enqueue_script(
					'bws-gutenberg-masonry-portfolio-frontend',
					plugin_dir_url(__FILE__) . 'build/frontend.js',
					$asset_file['dependencies'],
					$asset_file['version']
			);
			wp_enqueue_style( 'bws-gutenberg-masonry-portfolio-frontend', plugin_dir_url(__FILE__) . 'build/frontend.css' );
		} */

		$root_element = "<div id='bws_gutenberg-masonry-portfolio'><pre style='display: none'>" . wp_json_encode( $attributes ) . "</pre></div>";
		return $root_element;
	}

	function create_block_gutenberg_masonry_portfolio_block_init() {
		register_block_type( __DIR__ . '/build', array(
			'render_callback'	=>	array( $this, 'render_react_root' )
		) );
	}

	function prepare_data_to_rest_bws_portfolio_post( $response, $post, $request ) {
		$thumbnail_permalink = get_the_post_thumbnail_url( $post, array( 768, 0 ) );
		$response->data['thumbnail_url'] = $thumbnail_permalink;

		return $response;
	}
}

new Gutenberg_Masonry_Porfolio();
