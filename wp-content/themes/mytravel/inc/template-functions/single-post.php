<?php
/**
 * Template functions used in Single Post
 */

if ( ! function_exists( 'mytravel_archive_header' ) ) {
	/**
	 * Display the Page Title in blog (posts listing)
	 *
	 * This function uses "mytravel_is_posts_title" filter, which allows to control
	 * Page Title visibility. You can completely disable page title:
	 *
	 *     add_filter( 'mytravel_is_posts_title', '__return_false' );
	 *
	 * @hooked mytravel_posts_before 50
	 */
	function mytravel_archive_header() {
		if ( ! (bool) apply_filters( 'mytravel_is_posts_title', true ) ) {
			return;
		}

		if ( is_home() && is_front_page() ) {
			$title = esc_html__( 'Blog', 'mytravel' );
		} elseif ( is_home() ) {
			$blog_page_id = get_option( 'page_for_posts', true );
			$title        = get_the_title( $blog_page_id );
		} elseif ( is_search() ) {
			/* translators: %s : Search Result */
			$title = sprintf( esc_html__( 'Search Results for "%s"', 'mytravel' ), get_search_query() );
		} else {
			$title = get_the_archive_title();
		}

		$is_header_image = get_header_image();
		$header_bg_image = '';

		if ( $is_header_image ) {
			$header_bg_image = 'background-image:url(' . esc_url( $is_header_image ) . ')';
		}

		?>

		<header class="entry-header bg-img-hero text-center mb-5 mb-lg-8 bg-dark" style="<?php echo esc_attr( $header_bg_image ); ?>">
			<div class="container space-top-xl-3 py-6 py-xl-0">
				<div class="row justify-content-center py-xl-4">
					<div class="py-xl-10 py-5">
						<h1 class="entry-title font-size-40 font-size-xs-30 text-white font-weight-bold mb-0"><?php echo wp_kses( $title, 'post-title' ); ?></h1>
						<?php Mytravel_Breadcrumb(); ?>
					</div>
				</div>
			</div>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_post_header' ) ) {
	/**
	 * Displays single post cover image
	 *
	 * This function uses "mytravel_is_post_title" filter, which allows to control
	 * Page Title visibility. You can completely disable page title:
	 *
	 * @hooked mytravel_single_before 50
	 */
	function mytravel_single_post_header() {
		$single_post_title = get_the_title();
		$title             = apply_filters( 'mytravel_single_post_title', $single_post_title );
		$cover_image_class = '';
		$cover_image       = mytravel_acf_post_cover_image();

		$post_bg_image = '';

		if ( ! empty( $cover_image ) ) {
			$post_bg_image = 'url(' . esc_url( $cover_image ) . ')';
		}

		if ( ! empty( $cover_image ) ) {
			$cover_image_class = ' cover-image';
		}

		?>
		<div class="entry-header bg-img-hero text-center mb-5 mb-lg-8 bg-dark<?php echo esc_attr( $cover_image_class ); ?>" style="background-image: <?php echo esc_attr( $post_bg_image ); ?>">
			<div class="container space-top-xl-3 py-6 py-xl-0">
				<div class="row justify-content-center py-xl-4">
					<div class="py-xl-10 py-5 container">
						<?php if ( ! empty( $title ) ) : ?>
							<h1 class="font-size-40 font-size-xs-30 text-white font-weight-bold mb-0 text-break"><?php echo wp_kses( $title, 'post-title' ); ?></h1>
						<?php endif; ?>

						<?php Mytravel_Breadcrumb(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_post_content' ) ) {
	/**
	 * Display single post content.
	 */
	function mytravel_single_post_content() {
		?>
		<div class="article__content space-y-4">
			<?php mytravel_loop_post_meta(); ?>
			<div class="d-flex flex-column space-y-4">
				<div class="prose max-w-none">
					<?php
					the_content();
					?>
				</div>
				<?php
					$link_pages = wp_link_pages(
						array(
							'before'      => '<div class="page-links mb-0"><span class="d-block text-dark mb-2">' . esc_html__( 'Pages:', 'mytravel' ) . '</span><nav class="pagination mb-0">',
							'after'       => '</nav></div>',
							'link_before' => '<span class="page-link">',
							'link_after'  => '</span>',
							'echo'        => 0,
						)
					);
					$link_pages = str_replace( 'post-page-numbers', 'post-page-numbers page-item', $link_pages );
					$link_pages = str_replace( 'current', 'current active', $link_pages );
					echo wp_kses_post( $link_pages );
				?>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_post_get_categories' ) ) {
	/**
	 * Display post category in the loop.
	 *
	 * @param string $cat_link_class Class for the category list.
	 */
	function mytravel_post_get_categories( $cat_link_class = '' ) {
		$get_cat_link_classes = trim( 'text-primary font-weight-normal ' . $cat_link_class );
		$find                 = 'rel="category';
		$replace              = 'class="' . esc_attr( $get_cat_link_classes ) . '" rel="category';
		$categories_list      = get_the_category_list( esc_html__( ', ', 'mytravel' ) );
		$categories_list      = str_replace( $find, $replace, $categories_list );
		?>
		<span class="text-primary"><?php echo wp_kses( $categories_list, 'category-list' ); ?></span>
		<?php
	}
}

if ( ! function_exists( 'mytravel_post_get_tags' ) ) {
	/**
	 * Display post tags in the loop
	 */
	function mytravel_post_get_tags() {
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'mytravel' ) );
		if ( $tags_list && apply_filters( 'mytravel_single_post_tags_enable', false ) ) :
			?>
			<div class="tags-links">
				<?php echo esc_html( _n( 'Tag:', 'Tags:', count( get_the_tags() ), 'mytravel' ) ); ?> <?php echo wp_kses( $tags_list, 'tags-list' ); ?>
			</div>
			<?php
	endif;

	}
}


if ( ! function_exists( 'mytravel_paging_nav' ) ) {
	/**
	 * Pagination for Posts
	 *
	 * @param string $ul_class Additional class to the ul element.
	 * @return void
	 */
	function mytravel_paging_nav( $ul_class ) {
		global $wp_query;
		$pages = null;

		if ( $wp_query->max_num_pages <= 1 ) {
			return;
		}

		$ul_class = empty( $ul_class ) ? 'list-pagination-1 pagination border border-color-4 rounded-sm mb-5 mb-lg-0 overflow-auto overflow-xl-visible justify-content-md-center align-items-center py-2' : $ul_class;

		mytravel_bootstrap_pagination( $pages, $wp_query, true, $ul_class, 'font-size-14 text-nowrap' );
	}
}

if ( ! function_exists( 'mytravel_single_post_container_start' ) ) {
	/**
	 * Single post container wrap start
	 */
	function mytravel_single_post_container_start() {
		?>
		<div class="container mb-5 mb-lg-8">
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_post_row_start' ) ) {
	/**
	 * Single post row wrap start
	 */
	function mytravel_single_post_row_start() {
		$has_sidebar = mytravel_blog_has_sidebar();
		?>
		<div class="row">
		<?php
	}
}

if ( ! function_exists( 'mytravel_single_post_meta' ) ) {
	/**
	 * Single post meta
	 */
	function mytravel_single_post_meta() {
		?>
		<div class="article__meta">
			<?php do_action( 'mytravel_single_post_meta_before' ); ?>
			<span class="text-gray-3 d-block d-md-inline-block mb-2 mb-md-0 mr-md-3 pr-md-1"><?php echo esc_html( get_the_date() ); ?></span>
			<?php echo wp_kses_post( $author ); ?>
			<?php do_action( 'mytravel_single_post_meta_after' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'mytravel_post_navigation' ) ) {
	/**
	 * Displays navigation for Single Posts
	 */
	function mytravel_post_navigation() {
		if ( apply_filters( 'mytravel_enable_post_navigation', filter_var( get_theme_mod( 'enable_post_navigation', true ), FILTER_VALIDATE_BOOLEAN ) ) ) {
			?>
		<div class="article__navigation">
			<div class="article__navigation--inner py-6 px-4 bg-light rounded">
			<h2 class="sr-only"><?php echo esc_html__( 'Post navigation', 'mytravel' ); ?></h2>
			<div class="post-navigation d-md-flex justify-content-between align-items-center row">

				<?php
					$prev_post = get_previous_post();
					$next_post = get_next_post();
				?>
				<div class="col-md-6">
					<?php if ( $prev_post ) : ?>
						<a class="d-flex justify-content-center justify-content-md-start mb-4 mb-md-0 text-color-1" href="<?php the_permalink( $prev_post ); ?>">
							<div class="related-nav__arrow mr-3">
								<i class="flaticon-left-arrow font-size-15"></i>
							</div>
							<div class="related-nav__content">
								<span class="prev font-weight-normal font-size-14 text-uppercase"><?php echo esc_html__( 'Prev', 'mytravel' ); ?></span>
								<div class="text pt-md-1 font-weight-normal mb-0">
									<?php echo wp_kses( get_the_title( $prev_post ), 'post-title' ); ?>
								</div>
							</div>
						</a>
					<?php endif; ?>
				</div>
				
				<div class="col-md-6">
				<?php if ( $next_post ) : ?>
					<a class="d-flex justify-content-center justify-content-md-end text-color-1" href="<?php the_permalink( $next_post ); ?>">
						<div class="related-nav__content text-right">
							<span class="next font-weight-normal font-size-14 text-uppercase"><?php echo esc_html__( 'Next', 'mytravel' ); ?></span>
							<div class="text font-weight-normal mb-0 text-right pt-md-1"> 
								<?php echo wp_kses( get_the_title( $next_post ), 'post-title' ); ?>
							</div>       
						</div>
						<div class="related-nav__arrow ml-3">
							<i class="text-dark flaticon-right-arrow font-size-15"></i>
						</div>

					</a>
				   
				<?php endif; ?>
			</div>

			</div>
		</div>
	</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_single_post_container_end' ) ) {
	/**
	 * Single post container wrap end
	 */
	function mytravel_single_post_container_end() {
		?>
		</div>
		<?php
		if ( class_exists( 'MAS_Travels' ) ) {
			?>
			<div class="border border-color-8"></div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_single_post_row_end' ) ) {
	/**
	 * Single post row wrap end
	 */
	function mytravel_single_post_row_end() {
		?>
		</div>
		<?php
	}
}


if ( ! function_exists( 'mytravel_comments_navigation' ) ) {
	/**
	 * Displays navigation to next/previous set of comments, when applicable.
	 */
	function mytravel_comments_navigation() {
		if ( absint( get_comment_pages_count() ) === 1 ) {
			return;
		}

		/* translators: label for link to the previous comments page */
		$prev_text = esc_html_x( 'Older comments', 'front-end', 'mytravel' );
		$prev_link = get_previous_comments_link( '<i class="flaticon-left-arrow font-size-15 mr-2"></i>' . $prev_text );

		/* translators: label for link to the next comments page */
		$next_text = esc_html_x( 'Newer comments', 'front-end', 'mytravel' );
		$next_link = get_next_comments_link( $next_text . '<i class="flaticon-right-arrow font-size-15 ml-2"></i>' );

		?>
		<nav class="navigation comment-navigation d-flex justify-content-between my-6" role="navigation">
			<h3 class="sr-only">
			<?php
				/* translators: navigation through comments */
				echo esc_html_x( 'Comment navigation', 'front-end', 'mytravel' );
			?>
				</h3>
			<?php if ( $prev_link ) : ?>
				<ul class="pagination mb-0">
					<li class="page-item mx-0">
						<?php echo wp_kses_post( str_replace( '<a ', '<a class="page-link" ', $prev_link ) ); ?>
					</li>
				</ul>
			<?php endif; ?>
			<?php if ( $next_link ) : ?>
				<ul class="pagination mb-0 ml-auto">
					<li class="page-item mx-0">
						<?php echo wp_kses_post( str_replace( '<a ', '<a class="page-link" ', $next_link ) ); ?>
					</li>
				</ul>
			<?php endif; ?>
		</nav>
		<?php
	}
}

if ( ! function_exists( 'mytravel_comment_reply_link' ) ) {
	/**
	 * Edit comment reply link markup
	 *
	 * 1. Update set of classes
	 * 2. Add icon inside <a> element
	 *
	 * @param string $link The HTML markup for the comment reply link.
	 * @param array  $args An array of arguments overriding the defaults.
	 *
	 * @return string
	 */
	function mytravel_comment_reply_link( $link, $args ) {
		return str_replace(
			[
				'comment-reply-link',
				'\'>',
			],
			[
				'comment-reply-link nav-link-style font-weight-normal font-size-14',
				'\'>',
			],
			$link
		);
	}
}

if ( ! function_exists( 'mytravel_post_protected_password_form' ) ) :
	/**
	 * Display Post password protected form.
	 */
	function mytravel_post_protected_password_form() {
		global $post;

		$label = 'pwbox-' . ( empty( $post->ID ) ? wp_rand() : $post->ID );
		?>

		<form class="protected-post-form input-group mytravel-protected-post-form flex-column" action="<?php echo esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" method="post">
			<p><?php echo esc_html__( 'This content is password protected. To view it please enter your password below:', 'mytravel' ); ?></p>
			<div class="d-flex align-items-center w-md-85">
				<label class="mb-0 mr-3 d-none d-md-block" for="<?php echo esc_attr( $label ); ?>"><?php echo esc_html__( 'Password:', 'mytravel' ); ?></label>
				<div class="d-flex flex-grow-1">
					<input class="input-text form-control" name="post_password" id="<?php echo esc_attr( $label ); ?>" type="password" style="border-top-right-radius: 0; border-bottom-right-radius: 0;"/>
					<input type="submit" name="submit" class="btn btn-primary btn-sm" value="<?php echo esc_attr( 'Submit' ); ?>" style="border-top-left-radius: 0; border-bottom-left-radius: 0; transform: none;"/>
				</div>
			</div>
		</form>
		<?php
	}
endif;


if ( ! function_exists( 'mytravel_comment' ) ) {
	/**
	 * Comment Template.
	 *
	 * @param WP_Comment $comment The comment object.
	 * @param array      $args Array of arguments.
	 * @param int        $depth Depth of the comment.
	 */
	function mytravel_comment( $comment, $args, $depth ) {
		if ( 'div' === $args['style'] ) {
			$tag       = 'div';
			$add_below = 'comment-reply-target';
		} else {
			$tag       = 'li';
			$add_below = 'div-comment';
		}

		static $count = 1;

		$comment_class = [];

		if ( empty( $args['has_children'] ) ) {
			$comment_class[] = 'parent';
		}

		if ( 1 === $depth ) {
			$comment_class[] = 'mb-5';
		}

		if ( 1 !== $count && 1 === $depth ) {
			$comment_class[] = 'mb-5';
		}

		if ( $depth > 1 ) {
			$comment_class[] = 'mt-4 pl-3 pl-md-6 pl-xl-12';
		}

		$comment_class = implode( ' ', $comment_class );
		?>

		<<?php echo esc_attr( $tag ); ?> <?php comment_class( $comment_class ); ?> id="comment-<?php comment_ID(); ?>">
			<div class="media flex-column flex-md-row align-items-center align-items-md-start position-relative">
				<?php
					echo get_avatar( $comment, 85, '', esc_html__( 'author', 'mytravel' ), [ 'class' => 'rounded-circle mr-md-5' ] )
				?>

				<div class="media-body w-100 <?php echo esc_attr( ! empty( get_avatar( $comment ) ) ? 'mt-6 mt-md-0' : '' ); ?>">
					<div class="d-flex justify-content-between align-items-center mb-2">
						<h6 class="comment-author-name font-weight-bold text-gray-3 mb-0"><?php echo esc_html( get_comment_author( $comment ) ); ?></h6>
						<ul class="text-nowrap nav comment-footer d-flex align-items-center ml-0">
							<?php
							comment_reply_link(
								array_merge(
									$args,
									[
										'add_below' => 'comment-reply-target',
										'depth'     => $depth,
										'max_depth' => $args['max_depth'],
										'before'    => '<li>',
										'after'     => '</li>',
									]
								),
								$comment
							);
							?>
							<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
								<li><a class="comment-edit-link font-weight-normal font-size-14" href="<?php echo esc_url( get_edit_comment_link( $comment ) ); ?>">
									<?php esc_html_e( 'Edit', 'mytravel' ); ?>
								</a></li>
							<?php endif; ?>
						</ul>
					</div>

					<div class="mb-2">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>" class="font-weight-normal font-size-14 text-gray-9">
							<?php echo esc_html( get_comment_date( '', $comment ) ); ?>
						</a>
					</div>

					<div class="comment-text mb-0 pr-lg-5 mb-0-last-child">
						<?php
						if ( '0' === $comment->comment_approved ) :
							$commenter = wp_get_current_commenter();
							if ( $commenter['comment_author_email'] ) {
								echo esc_html_x( 'Your comment is awaiting moderation.', 'front-end', 'mytravel' );
							} else {
								echo esc_html_x(
									'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.',
									'front-end',
									'mytravel'
								);
							}
						else :
							?>
							<div class="comments__text prose prose-sm max-w-none">
								<?php
								comment_text();
								?>
							</div>
							<?php
						endif;
						?>
					</div>
				</div>
			</div>

			<div id="comment-reply-target-<?php comment_ID(); ?>" class="comment-reply-target"></div>

		<?php if ( 'div' !== $args['style'] ) : ?>
		</div>
			<?php
		endif;

		$count++;
	}
}

if ( ! function_exists( 'mytravel_display_comments' ) ) :
	/**
	 * Display comments
	 *
	 * @since  1.0.0
	 */
	function mytravel_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || 0 !== intval( get_comments_number() ) ) :
			comments_template();
		endif;
	}

endif;

