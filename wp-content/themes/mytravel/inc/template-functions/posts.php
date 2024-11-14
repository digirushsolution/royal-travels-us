<?php
/**
 * Template functions used in Post
 */

if ( ! function_exists( 'mytravel_loop_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail in the loop.
	 *
	 * @param string $size Image size of the post thumbnail. Default is 'full'.
	 */
	function mytravel_loop_post_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="d-block mb-4">
			<?php
			the_post_thumbnail( $size, array( 'class' => 'img-fluid rounded-xs mx-auto d-block' ) );
			?>
			</a>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_loop_post_grid_thumbnail' ) ) {
	/**
	 * Display post thumbnail in the loop.
	 *
	 * @param string $size Image size of the post thumbnail. Default is 'full'.
	 */
	function mytravel_loop_post_grid_thumbnail( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			?>
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="d-block mb-3">
			<?php
			the_post_thumbnail( $size, array( 'class' => 'img-fluid rounded-xs mx-auto d-block' ) );
			?>
			</a>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_loop_post_list_thumbnail_wrap' ) ) {
	/**
	 * Display post thumbnail in the list view.
	 *
	 * @param string $size Image size of the post thumbnail. Default is 'full'.
	 */
	function mytravel_loop_post_list_thumbnail_wrap( $size = 'full' ) {
		if ( has_post_thumbnail() ) {
			?>
			<div class="col-xl-4dot1">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="d-block">
				<?php
				the_post_thumbnail( $size, array( 'class' => 'img-fluid w-100 rounded-xs mb-3 mb-md-0' ) );
				?>
				</a>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'mytravel_loop_post_list_content_wrap_start' ) ) {
	/**
	 * Output post list view content wrap start.
	 */
	function mytravel_loop_post_list_content_wrap_start() {
		if ( has_post_thumbnail() ) {
			$additional_class = 'ml-md-3 pl-md-1';
		} else {
			$additional_class = 'col-inner';
		}

		?>
		<div class="col-xl-7dot9">
			<div class="<?php echo esc_attr( $additional_class ); ?>">
		<?php
	}
}

if ( ! function_exists( 'mytravel_loop_post_list_content_wrap_end' ) ) {
	/**
	 * Output post list view content wrap start.
	 */
	function mytravel_loop_post_list_content_wrap_end() {
		?>
			</div>
		</div>
		<?php
	}
}


if ( ! function_exists( 'mytravel_loop_post_title' ) ) {
	/**
	 * Display post title in the loop.
	 */
	function mytravel_loop_post_title() {
		$prepend = '';

		if ( is_sticky() ) {
			$prepend = '<span class="badge badge badge-dark font-size-14 font-weight-normal align-middle ml-1">' . esc_html__( 'Featured', 'mytravel' ) . '</span>';
		}

		the_title( sprintf( '<h5 class="entry-title font-weight-bold font-size-24 text-gray-3"><a href="%s" class="stretched-link text-gray-3" rel="bookmark">', esc_url( get_permalink() ) ), $prepend . '</a></h5>' );

	}
}

if ( ! function_exists( 'mytravel_loop_post_grid_title' ) ) {
	/**
	 * Display post grid title in the loop.
	 */
	function mytravel_loop_post_grid_title() {
		the_title( sprintf( '<h6 class="text-gray-6 font-size-17 pt-xl-1 font-weight-bold font-weight-bold mb-1"><a href="%s" class="stretched-link text-gray-3" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
	}
}

if ( ! function_exists( 'mytravel_loop_post_list_title' ) ) {
	/**
	 * Display post list title in the loop.
	 */
	function mytravel_loop_post_list_title() {
		the_title( sprintf( '<h4 class="font-size-21 font-weight-semi-bold text-gray-6"><a href="%s" class="stretched-link text-gray-6" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
	}
}

if ( ! function_exists( 'mytravel_get_post_date_string' ) ) {
	/**
	 * Returns post date time output string.
	 *
	 * @return string
	 */
	function mytravel_get_post_date_string() {
		// Posted on.
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published sr-only" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		return $time_string;
	}
}

if ( ! function_exists( 'mytravel_loop_post_meta' ) ) {
	/**
	 * Output loop post meta.
	 */
	function mytravel_loop_post_meta() {
		if ( 'post' !== get_post_type() ) {
			return;
		}
		$time_string        = mytravel_get_post_date_string();
		$output_time_string = sprintf( '<a href="%1$s" class="post-date text-gray-3 flex-shrink-0 d-block d-md-inline-block mb-2 mb-md-0" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

		// Author.
		$author       = sprintf(
			'<a href="%1$s" class="post-author text-primary" rel="author">%2$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
		$meta_divider = sprintf( '<span class="meta-divider"></span>' );

		if ( is_single() ) {
			$wrap_class = 'article__meta d-flex flex-wrap align-items-center';
		} else {
			$wrap_class = 'mb-3 d-flex flex-wrap align-items-center';

		}

		?>
		<div class="<?php echo esc_attr( $wrap_class ); ?>">
			<?php
			echo wp_kses(
				sprintf( '%1$s %2$s %3$s', $output_time_string, $meta_divider, $author ),
				array(
					'a'    => array(
						'href'  => array(),
						'title' => array(),
						'rel'   => array(),
						'class' => array(),
					),
					'time' => array(
						'datetime' => array(),
						'class'    => array(),
					),
					'span' => array(
						'class' => array(),
					),
				)
			);
			?>
		</div>
		<?php
	}
}


if ( ! function_exists( 'mytravel_loop_post_grid_meta' ) ) {
	/**
	 * Display post grid meta.
	 */
	function mytravel_loop_post_grid_meta() {
		?>
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-gray-1"><?php echo esc_html( get_the_date() ); ?></a>
		<?php

	}
}

if ( ! function_exists( 'mytravel_loop_post_excerpt' ) ) {
	/**
	 * Display post excerpt.
	 */
	function mytravel_loop_post_excerpt() {
		$excerpt = wp_strip_all_tags( get_the_excerpt() );
		?>
		<p class="short_desc text-lh-lg"><?php echo esc_html( $excerpt ); ?></p>
		<?php

	}
}

if ( ! function_exists( 'mytravel_blog_has_sidebar' ) ) {
	/**
	 * Check if the blog page has sidebar.
	 *
	 * @return bool
	 */
	function mytravel_blog_has_sidebar() {
		$layout      = mytravel_posts_sidebar();
		$has_sidebar = is_active_sidebar( 'blog-sidebar' ) && 'no-sidebar' !== $layout;

		return $has_sidebar;
	}
}


