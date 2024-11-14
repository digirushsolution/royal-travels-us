<?php

namespace MASTravels;

/**
 * Share Plugin
 */

defined( 'ABSPATH' ) || exit;
/**
 * MyTravel Share
 *
 * @since 1.0.0
 */
class Share {
	/**
	 * Constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'mytravel_single_hotel_v1_sidebar_buttons', array( $this, 'display_share' ) );
	}
	/**
	 * Display share.
	 *
	 * @param string $args share button arguments.
	 */
	public function display_share( $args ) {
		$args['share'] = [
			'callback' => array( $this, 'share_button' ),
		];
		return $args;
	}
	/**
	 * Share button output.
	 */
	public function share_button() {

		$id       = uniqid( 'fancybox-share-' );
		$services = self::get_share_services();

		?><a href="javascript:;" class="js-fancybox height-45 width-45 border rounded border-width-2 flex-content-center" data-speed="700" data-src="#<?php echo esc_attr( $id ); ?>">
			<i class="flaticon-share font-size-18 text-dark"></i>
		</a>
		<div id="<?php echo esc_attr( $id ); ?>" class="clearfix" style="display: none; min-width: 400px;">
			<h5><?php esc_html_e( 'Share', 'mas-travels' ); ?></h5>
			<ul class="list-inline mb-0">
			<?php

			foreach ( $services as $key => $service ) :

				if ( ! isset( $service['share'] ) ||
					! isset( $service['icon'] ) ||
					! isset( $service['color'] )
				) {
					continue;
				}

				?>
					<li class="list-inline-item text-center">
						<a href="<?php echo esc_url( $service['share'] ); ?>" class="d-block" target="_blank" style="padding: 5px 1px 2px; margin: 1px;">
							<div style="font-size: 15px; color: <?php echo esc_attr( $service['color'] ); ?>; margin: 0 4px 8px;">
								<span class="fa-stack fa-2x">
									<i class="fas fa-circle fa-stack-2x"></i>
									<i class="<?php echo esc_attr( $service['icon'] ); ?> fa-stack-1x fa-inverse"></i>
								</span>
							</div>
							<?php

							if ( isset( $service['name'] ) ) :

								?>
							<div class="text-secondary" style="font-size:12px;"><?php echo esc_html( $service['name'] ); ?></div>
								<?php

						endif;

							?>
						</a>
					</li>
					<?php
				endforeach;

			?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Class for get_nice_names.
	 */
	public static function get_nice_names() {
		return [
			'blogger'          => 'Blogger',
			'diaspora'         => 'Diaspora',
			'douban'           => 'Douban',
			'email'            => 'Email',
			'evernote'         => 'EverNote',
			'getpocket'        => 'Pocket',
			'facebook'         => 'Facebook',
			'flipboard'        => 'FlipBoard',
			'google.bookmarks' => 'GoogleBookmarks',
			'instapaper'       => 'InstaPaper',
			'line.me'          => 'Line.me',
			'linkedin'         => 'LinkedIn',
			'livejournal'      => 'LiveJournal',
			'gmail'            => 'GMail',
			'hacker.news'      => 'HackerNews',
			'ok.ru'            => 'OK.ru',
			'pinterest.com'    => 'Pinterest',
			'qzone'            => 'QZone',
			'reddit'           => 'Reddit',
			'renren'           => 'RenRen',
			'skype'            => 'Skype',
			'sms'              => 'SMS',
			'telegram.me'      => 'Telegram.me',
			'threema'          => 'Threema',
			'tumblr'           => 'Tumblr',
			'twitter'          => 'Twitter',
			'vk'               => 'VK',
			'weibo'            => 'Weibo',
			'whatsapp'         => 'WhatsApp',
			'xing'             => 'Xing',
			'yahoo'            => 'Yahoo',
		];
	}

	/**
	 * Class for order_by_popularity.
	 */
	public static function order_by_popularity() {
		return [
			'google.bookmarks',
			'facebook',
			'reddit',
			'whatsapp',
			'twitter',
			'linkedin',
			'tumblr',
			'pinterest',
			'blogger',
			'livejournal',
			'evernote',
			'getpocket',
			'hacker.news',
			'flipboard',
			'instapaper',
			'diaspora',
			'qzone',
			'vk',
			'weibo',
			'ok.ru',
			'douban',
			'xing',
			'renren',
			'threema',
			'sms',
			'line.me',
			'skype',
			'telegram.me',
			'email',
			'gmail',
			'yahoo',
			'google',
		];
	}
	/**
	 * Class for order_by_name.
	 */
	public static function order_by_name() {
		$nice_names = self::get_nice_names();

		return array_keys( $nice_names );
	}
	/**
	 * Class for get_enabled.
	 */
	public static function get_enabled() {
		$enabled_services = apply_filters(
			'mas_travels_enabled_social_share',
			[
				'email'    => 'fas fa-envelope',
				'whatsapp' => 'fab fa-whatsapp',
				'facebook' => 'fab fa-facebook-f',
				'twitter'  => 'fab fa-twitter',
				'reddit'   => 'fab fa-reddit',
				'linkedin' => 'fab fa-linkedin-in',
			]
		);

		return $enabled_services;
	}
	/**
	 * Get brand colors.
	 */
	public static function get_brand_colors() {
		$brand_colors = apply_filters(
			'mas_travels_brand_colors',
			[
				'blogger'          => '#FF5722',
				'diaspora'         => 'Diaspora',
				'douban'           => 'Douban',
				'email'            => '#67747c',
				'evernote'         => '#00A82D',
				'getpocket'        => 'Pocket',
				'facebook'         => '#4267B2',
				'flipboard'        => 'FlipBoard',
				'google.bookmarks' => 'GoogleBookmarks',
				'instapaper'       => 'InstaPaper',
				'line.me'          => 'Line.me',
				'linkedin'         => '#2867B2',
				'livejournal'      => 'LiveJournal',
				'gmail'            => 'GMail',
				'hacker.news'      => 'HackerNews',
				'ok.ru'            => 'OK.ru',
				'pinterest.com'    => '#E60023',
				'qzone'            => 'QZone',
				'reddit'           => '#FF4500',
				'renren'           => 'RenRen',
				'skype'            => 'Skype',
				'sms'              => 'SMS',
				'telegram.me'      => 'Telegram.me',
				'threema'          => 'Threema',
				'tumblr'           => 'Tumblr',
				'twitter'          => '#1DA1F2',
				'vk'               => 'VK',
				'weibo'            => 'Weibo',
				'whatsapp'         => '#25D366',
				'xing'             => 'Xing',
				'yahoo'            => 'Yahoo',
			]
		);

		return $brand_colors;
	}
	/**
	 * Class for get_share_services.
	 */
	public static function get_share_services() {
		global $post;

		$args = apply_filters(
			'mas_travels_share_display_args',
			[
				'url'             => get_permalink( $post->ID ),
				'title'           => get_the_title( $post ),
				'image'           => get_the_post_thumbnail_url( $post ),
				'desc'            => get_the_excerpt( $post ),
				'appid'           => '',
				'redirecturl'     => '',
				'via'             => '',
				'hashtags'        => '',
				'provider'        => '',
				'language'        => '',
				'userid'          => '',
				'category'        => '',
				'phonenumber'     => '',
				'emailaddress'    => '',
				'ccemailaddress'  => '',
				'bccemailaddress' => '',
			],
			$post
		);

		$services = self::get_enabled();
		$links    = self::get_share_links( $args );
		$names    = self::get_nice_names();
		$colors   = self::get_brand_colors();

		$share_links = [];

		foreach ( $services as $key => $service ) {
			$share_links[ $key ]['icon'] = $service;

			if ( isset( $links[ $key ] ) ) {
				$share_links[ $key ]['share'] = $links[ $key ];
			}

			if ( isset( $names[ $key ] ) ) {
				$share_links[ $key ]['name'] = $names[ $key ];
			}

			if ( isset( $colors[ $key ] ) && '#' === substr( $colors[ $key ], 0, 1 ) ) {
				$share_links[ $key ]['color'] = $colors[ $key ];
			}
		}

		return $share_links;
	}
	/**
	 * Class for get_share_links.
	 *
	 * @param array $args share_links  arguments.
	 */
	public static function get_share_links( $args ) {
		$url               = rawurlencode( $args['url'] );
		$title             = rawurlencode( $args['title'] );
		$image             = rawurlencode( $args['image'] );
		$desc              = rawurlencode( $args['desc'] );
		$app_id            = rawurlencode( $args['appid'] );
		$redirect_url      = rawurlencode( $args['redirecturl'] );
		$via               = rawurlencode( $args['via'] );
		$hash_tags         = rawurlencode( $args['hashtags'] );
		$provider          = rawurlencode( $args['provider'] );
		$language          = rawurlencode( $args['language'] );
		$user_id           = rawurlencode( $args['userid'] );
		$category          = rawurlencode( $args['category'] );
		$phone_number      = rawurlencode( $args['phonenumber'] );
		$email_address     = rawurlencode( $args['emailaddress'] );
		$cc_email_address  = rawurlencode( $args['ccemailaddress'] );
		$bcc_email_address = rawurlencode( $args['bccemailaddress'] );

		$text = $title;

		if ( $desc ) {
			$text .= '%20%3A%20';   // This is just this, " : ".
			$text .= $desc;
		}

		// conditional check before arg appending.

		return [
			'blogger'          => 'https://www.blogger.com/blog-this.g?u=' . $url . '&n=' . $title . '&t=' . $desc,
			'diaspora'         => 'https://share.diasporafoundation.org/?title=' . $title . '&url=' . $url,
			'douban'           => 'http://www.douban.com/recommend/?url=' . $url . '&title=' . $text,
			'email'            => 'mailto:' . $email_address . '?subject=' . $title . '&body=' . $desc,
			'evernote'         => 'https://www.evernote.com/clip.action?url=' . $url . '&title=' . $text,
			'getpocket'        => 'https://getpocket.com/edit?url=' . $url,
			'facebook'         => 'http://www.facebook.com/sharer.php?u=' . $url,
			'flipboard'        => 'https://share.flipboard.com/bookmarklet/popout?v=2&title=' . $text . '&url=' . $url,
			'gmail'            => 'https://mail.google.com/mail/?view=cm&to=' . $email_address . '&su=' . $title . '&body=' . $url . '&bcc=' . $bcc_email_address . '&cc=' . $cc_email_address,
			'instapaper'       => 'http://www.instapaper.com/edit?url=' . $url . '&title=' . $title . '&description=' . $desc,
			'line.me'          => 'https://lineit.line.me/share/ui?url=' . $url . '&text=' . $text,
			'linkedin'         => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url,
			'livejournal'      => 'http://www.livejournal.com/update.bml?subject=' . $text . '&event=' . $url,
			'hacker.news'      => 'https://news.ycombinator.com/submitlink?u=' . $url . '&t=' . $title,
			'ok.ru'            => 'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=' . $url,
			'pinterest'        => 'http://pinterest.com/pin/create/button/?url=' . $url,
			'qzone'            => 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' . $url,
			'reddit'           => 'https://reddit.com/submit?url=' . $url . '&title=' . $title,
			'renren'           => 'http://widget.renren.com/dialog/share?resourceUrl=' . $url . '&srcUrl=' . $url . '&title=' . $text . '&description=' . $desc,
			'skype'            => 'https://web.skype.com/share?url=' . $url . '&text=' . $text,
			'sms'              => 'sms:' . $phone_number . '?body=' . str_replace( '+', ' ', $text ),
			'telegram.me'      => 'https://t.me/share/url?url=' . $url . '&text=' . $text . '&to=' . $phone_number,
			'threema'          => 'threema://compose?text=' . $text . '&id=' . $user_id,
			'tumblr'           => 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $url . '&title=' . $title . '&caption=' . $desc . '&tags=' . $hash_tags,
			'twitter'          => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $text . '&via=' . $via . '&hashtags=' . $hash_tags,
			'vk'               => 'http://vk.com/share.php?url=' . $url . '&title=' . $title . '&comment=' . $desc,
			'weibo'            => 'http://service.weibo.com/share/share.php?url=' . $url . '&appkey=&title=' . $title . '&pic=&ralateUid=',
			'whatsapp'         => 'https://api.whatsapp.com/send?text=' . $text . '%20' . $url,
			'xing'             => 'https://www.xing.com/spi/shares/new?url=' . $url,
			'yahoo'            => 'http://compose.mail.yahoo.com/?to=' . $email_address . '&subject=' . $title . '&body=' . $text,
			'google.bookmarks' => 'https://www.google.com/bookmarks/mark?op=edit&bkmk=' . $url . '&title=' . $title . '&annotation=' . $text . '&labels=' . $hash_tags . '',
		];
	}
}

new Share();
