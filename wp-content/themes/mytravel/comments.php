<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mytravel
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
$class_comments = 'blogPost';
if ( is_page() ) {
	$class_comments .= ' max-w-[75%]';
	if ( ! class_exists( 'MAS_Travels' ) ) {
		$class_comments .= ' mx-auto';
	}
}

?>
<div class="border-top border-color-8 pt-4 border-width-2 <?php echo esc_attr( $class_comments ); ?>" id="comments">
	<?php
	if ( have_comments() ) :
		?>
		<h2 class="font-weight-bold font-size-21 text-gray-3 mb-4">
			<?php
				// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
				echo sprintf(
					/* translators: 1: number of comments, 2: post title */
					esc_html( _nx( '%1$s Comment', '%1$s Comments', get_comments_number(), 'comments title', 'mytravel' ) ),
					number_format_i18n( get_comments_number() )
				);
				// phpcs:enable
			?>
		</h2>
		<div class="comment-list">
			<?php
				wp_list_comments(
					array(
						'style'      => 'div',
						'short_ping' => true,
						'callback'   => 'mytravel_comment',
					)
				);
			?>
		</div>
		<?php
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through.
			?>
			<nav id="comment-nav-below" class="comment-navigation mb-4" role="navigation" aria-label="<?php esc_attr_e( 'Comment Navigation Below', 'mytravel' ); ?>">
				<span class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'mytravel' ); ?></span>
				<div class="d-flex justify-content-between">
					<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'mytravel' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'mytravel' ) ); ?></div>
				</div>
			</nav><!-- #comment-nav-below -->
			<?php
		endif; // Check for comment navigation.

		if ( ! comments_open() && 0 !== intval( get_comments_number() ) && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
			<p class="no-comments alert alert-warning mb-0"><?php esc_html_e( 'Comments are closed.', 'mytravel' ); ?></p>
			<?php
		endif;
	endif;

	comment_form(
		apply_filters(
			'mytravel_comment_form_args',
			[
				'logged_in_as'         => '',
				'class_form'           => 'row mb-5 mb-lg-0',
				'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title font-size-21 font-weight-bold text-dark mb-4">',
				'title_reply_after'    => '</h3>',
				'submit_field'         => '<div class="col-sm-12 form-group form-submit mb-0">%1$s%2$s</div>',
				'submit_button'        => '<button type="submit" name="%1$s" id="%2$s" class="%3$s">%4$s</button>',
				'class_submit'         => 'btn rounded-xs bg-blue-dark-1 text-white p-2 height-51 width-190 transition-3d-hover submit',
				'comment_notes_after'  => '',
				'comment_notes_before' => sprintf(
					'<p class="col-sm-12 font-size-sm text-muted">%s %s <span class="text-danger">*</span></p>',
					esc_html_x( 'Your email address will not be published.', 'front-end', 'mytravel' ),
					/* translators: related to comment form; phrase follows by red mark*/
					esc_html_x( 'Required fields are marked', 'front-end', 'mytravel' )
				),
				'comment_field'        => sprintf(
					'<div class="col-sm-12 form-group comment-form-comment mb-5">
				<label class="form-label" for="comment">%s</label>
				<textarea id="comment" name="comment" class="form-control" rows="8" maxlength="65525" required></textarea>
			</div>',
					/* translators: label for textarea in comment form */
					esc_html_x( 'Comment', 'front-end', 'mytravel' )
				),
				'cancel_reply_before'  => ' <small class="ml-2">',
				'cancel_reply_after'   => '</small>',
			]
		)
	);
	?>
</div>
<?php
