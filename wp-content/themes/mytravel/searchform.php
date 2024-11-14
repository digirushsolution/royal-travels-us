<form role="search" method="get" class="search-form input-group input-group-borderless" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<!-- Input -->
	<div class="js-focus-state w-100">
		<div class="input-group border border-color-8 border-width-2 rounded d-flex align-items-center">
			<input type="search" class="form-control font-size-14 placeholder-1 ml-1" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'mytravel' ); ?>" value="<?php echo get_search_query(); ?>" name="s"
			title="<?php echo esc_attr_x( 'Search for:', 'label', 'mytravel' ); ?>">
			<input type="hidden" class="form-control" name="post_type" value="post">

			<div class="input-group-append">
				<span class="input-group-text">
					<i class="flaticon-magnifying-glass-1 font-size-20 text-gray-8 mr-1"></i>
				</span>
			</div>
		</div>
	</div>
	<!-- End Input -->
</form>
