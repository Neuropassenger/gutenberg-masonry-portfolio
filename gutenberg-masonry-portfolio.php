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
		add_action( 'init', array( $this, 'create_block_gutenberg_masonry_portfolio_block_init' ) );
		add_action( 'init', array( $this, 'register_portfolio_taxonomy' ) );
		add_action( 'init', array( $this, 'register_portfolio_post_type' ) );
	}

	/**
	 * Register the Portfolio Taxonomy
	 */
	function register_portfolio_taxonomy() {
		// Register a Taxonomy for the Portfolio Post Type
		register_taxonomy( 'bws_portoflio_cat', 'portfolio', array(
			'show_in_rest'	=> true,
			'labels'		=> array(
				'name'							=> 'Portfolio Tags',
				'singular_name'					=> 'Portfolio Tag',
				'search_items'					=> 'Search Portfolio Tags',
				'popular_items' 				=> 'Popular Portfolio Tags',
				'all_items'						=> 'All Portfolio Tags',
				'edit_item'						=> 'Edit Portfolio Tag',
				'update_item'					=> 'Update Portfolio Tag',
				'add_new_item'					=> 'Add New Portfolio Tag',
				'view_item'						=> 'View Portfolio Tag',
				'separate_items_with_commas'	=> 'Separate Portfolio Tags with commas',
				'add_or_remove_items'			=> 'Add or Remove Portfolio Tags',
				'choose_from_most_used'			=> 'Choose from the most used Portfolio Tags',
				'not_found'						=> 'Portfolio Tags not found',
				'back_to_items'					=> 'Go to Portfolio Tags'
			)
		) );
	}

	/**
	 * Register the Portfolio Post Type
	 */
	function register_portfolio_post_type() {
		register_post_type( 'bws_portfolio_post', array(
			'taxonomies'		=> array( 'bws_portoflio_cat' ),
			'public' 			=> true,
			'show_in_rest'		=> true,
			'supports' 			=> array( 'title', 'editor', 'thumbnail' ),
			'menu_postition'	=> 4,
			'labels'			=> array(
				'name'                     => 'Portfolio Items', // The main name for a post type, usually in the plural.
				'singular_name'            => 'Portfolio Item', // The name for one post of that type.
				'add_new'                  => 'Add New', // Text for adding a new post, like "add new" in posts in the admin panel.
												// If you want to use a translation of the title, type it like this: _x('Add New', 'product');
				'add_new_item'             => 'Add New Portfolio Item', // Title text of the newly created post in the admin panel. As "Add New Post" for posts.
				'edit_item'                => 'Edit Portfolio Item', // The text to edit the post type. Default: edit post/edit page.
				'new_item'                 => 'New Portfolio Item', // New post text. Default: "New post."
				'view_item'                => 'View Portfolio Item', // Text to view a post of this post type. Default: "View post"/"View page".
				'search_items'             => 'Search Portfolio Item', // Search text for these post types. Default: "Find post"/"find page".
				'not_found'                => 'No Portfolio Items was found', // Text if the search did not find anything.
												// Default: "No post was found"/"No page was found".
				'not_found_in_trash'       => 'No Portfolio Items was found in Trash', // Text if nothing was found in the trash.
												// Default is: "No posts found in Trash"/"No pages found in Trash".
				'all_items'                => 'All Portfolio Items', // All posts. The default is "All Posts"/"All Pages".
				//'archives'                 => '', // Posts Archives. Defaults to value of all_items field.
				'insert_into_item'         => 'Insert in Portfolio Item', // Insert in post.
				'uploaded_to_this_item'    => 'Loaded for this Portfolio Item', // Loaded for this post.
				'featured_image'           => 'Portfolio Items thumbnail', // Posts thumbnail.
				'set_featured_image'       => 'Set Portfolio Item thumbnail', // Set post thumbnail.
				'remove_featured_image'    => 'Delete Portfolio Item thumbnail', // Delete post thumbnail.
				'use_featured_image'       => 'Use Portfolio Item thumbnail', // Use as post thumbnail.
				'filter_items_list'        => 'Filter Portfolio Item list', // Filter post list.
				'items_list_navigation'    => 'Naigate though Porfolio Items', // Navigate through postings.
				'items_list'               => 'List of Portfolio Items', // List of posts.
				'view_items'               => 'View Portfolio Items', // Name in toolbar, for archive page of post type. Default: "View Posts" / "View Pages". FROM WP 4.7.
				'attributes'               => 'Portfolio Item attributes', // Name for post attributes metabox (for pages it is "Page Attributes" metabox).
												// Default: "Post Attributes" or "Page Attributes". FROM WP 4.7.
				'item_updated'             => 'Portfolio Item updated', // Note text in the post editor when the post is updated. FROM WP 5.0.
												// Default: "Post updated." / "Page updated."
				'item_published'           => 'Portfolio Item published', // Note text in post editor when a post is published. FROM WP 5.0.
												// Default: "Post published." / "Page published."
				'item_published_privately' => 'Portfolio Item published privately', // Note text in post editor when private post is published. FROM WP 5.0.
												// Default: "Post published privately." / "Page published privately."
				'item_reverted_to_draft'   => 'Portfolio Item reverted to draft', // The text of a note in the post editor when the post is returned to draft. FROM WP 5.0.
												// Default: "Post reverted to draft." / "Page reverted to draft."
				'item_scheduled'           => 'Portfolio Item scheduled', // Note text in the post editor when a post is scheduled for a future date. FROM WP 5.0.
												// Default: "Post scheduled." / "Page scheduled."
			)
		) );
	}

	function create_block_gutenberg_masonry_portfolio_block_init() {
		register_block_type( __DIR__ . '/build' );
	}
}

new Gutenberg_Masonry_Porfolio();
