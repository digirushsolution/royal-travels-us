jQuery( function( $ ) {

    // mytravel_single_product_params is required to continue.
    if ( typeof mytravel_single_product_params === 'undefined' ) {
        return false;
    }

    $( 'body' )
        .on( 'init', '.rating_category', function() { 
            $( this )
                .hide()
                .before(
                    '<p class="rating-category-stars mb-0">\
                        <span>\
                            <a class="star-1" title="' + mytravel_single_product_params.i18n_star_1_text + '" href="#">1</a>\
                            <a class="star-2" title="' + mytravel_single_product_params.i18n_star_2_text + '" href="#">2</a>\
                            <a class="star-3" title="' + mytravel_single_product_params.i18n_star_3_text + '" href="#">3</a>\
                            <a class="star-4" title="' + mytravel_single_product_params.i18n_star_4_text + '" href="#">4</a>\
                            <a class="star-5" title="' + mytravel_single_product_params.i18n_star_5_text + '" href="#">5</a>\
                        </span>\
                    </p>'
                );
        } )
        .on( 'click', 'p.rating-category-stars a', function() { 
            var $star       = $( this ),
                $rating     = $( this ).closest( '.respond__rating-category' ).find( '.rating_category' ),
                $container  = $( this ).closest( '.rating-category-stars' );

            $rating.val( $star.text() );
            $star.siblings( 'a' ).removeClass( 'active' );
            $star.addClass( 'active' );
            $container.addClass( 'selected' );

            return false;
        } );

    $( '.rating_category' ).trigger( 'init' );

} );