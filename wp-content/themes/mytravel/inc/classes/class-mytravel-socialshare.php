<?php
/**
 * MyTravel_SocialMedia class.
 *
 * @since    1.0.0
 * @package mytravel
 */

defined( 'ABSPATH' ) || exit;

/**
 * Setup class.
 *
 * @since 1.0
 */
class Mytravel_SocialShare {
	/**
	 * Class for get_nice_names.
	 */
	public static function get_nice_names() {
		return array(
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
			'pinterest'        => 'Pinterest',
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
		);
	}
	/**
	 * Class for order_by_popularity.
	 */
	public static function order_by_popularity() {
		return array(
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
		);
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
			'mytravel_enabled_social_share',
			array(
				'facebook'  => 'fab fa-facebook-f',
				'twitter'   => 'fab fa-twitter',
				'instagram' => 'fab fa-instagram',
				'linkedin'  => 'fab fa-linkedin-in',
			)
		);

		return $enabled_services;
	}
	/**
	 * Class for get_share_services.
	 */
	public static function get_share_services() {
		global $post;

		$args = apply_filters(
			'mytravel_share_display_args',
			array(
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
			),
			$post
		);

		$services = self::get_enabled();
		$links    = self::get_share_links( $args );
		$names    = self::get_nice_names();

		$share_links = array();

		foreach ( $services as $key => $service ) {
			$share_links[ $key ]['icon'] = $service;

			if ( isset( $links[ $key ] ) ) {
				$share_links[ $key ]['share'] = $links[ $key ];
			}

			if ( isset( $names[ $key ] ) ) {
				$share_links[ $key ]['name'] = $names[ $key ];
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

		return array(
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
		);
	}
}
