/* global mytravel_book_now_params */
jQuery( function( $ ) {

    var BookNowHandler = function() {
       $( document ).ready( this.updateBookingDates );

        $( '#updateAvailability' ).on ( 'click', this.updateBookingDates );
        $( '#updateAvailability' ).on ( 'click', this.updateBookingRooms );
        $( '#updateAvailability' ).on ( 'click', this.toggleBookNowButton );

        $( '.single_add_to_cart_button' ).on ( 'click', this.updateBookingDates );

        $( '.rooms-required' ).on( 'js-result-change', this.updateBookingRooms );
        $( '.rooms-required' ).on( 'js-result-change', this.updateGuestPicker );
        $( '.rooms-required' ).on( 'js-result-change', this.toggleBookNowButton );

        $( '.guests-adults' ).on( 'js-result-change', this.updateGuestPicker );
        $( '.guests-adults' ).on( 'js-result-change', this.updateGuests );
        $( '.guests-adults' ).on( 'js-result-change', this.toggleBookNowButton );

        $( '.guests-children' ).on( 'js-result-change', this.updateGuestPicker );
        $( '.guests-children' ).on( 'js-result-change', this.updateGuests );
        $( '.guests-children' ).on( 'js-result-change', this.toggleBookNowButton );

        $( '.guests-infant' ).on( 'js-result-change', this.updateGuestPicker );
        $( '.guests-infant' ).on( 'js-result-change', this.updateGuests );
        $( '.guests-infant' ).on( 'js-result-change', this.toggleBookNowButton );

    };

    BookNowHandler.prototype.updateBookingDates = function() {
        const selection = document.querySelector( '.js-range-datepicker' );
        if( selection !== null ) {
            const fp             = selection._flatpickr;
            if( fp.selectedDates.length === 2 ) {
                var startDate    = fp.formatDate( fp.selectedDates[0], 'Y-m-d' ),
                endDate          = fp.formatDate( fp.selectedDates[1], 'Y-m-d' ),
                $submitStartDate = $( 'input[name="start_date_submit"]' ),
                $submitEndDate   = $( 'input[name="end_date_submit"]' );
                $submitStartDate.val( startDate );
                $submitEndDate.val( endDate );
                $( '.start-date .wapf-input' ).val( startDate );
                $( '.end-date .wapf-input' ).val( endDate );
            } else {
                var date        = fp.formatDate( fp.selectedDates[0], 'Y-m-d' ),
                $submitStartDate = $( 'input[name="start_date_submit"]' ),
                $submitEndDate   = $( 'input[name="end_date_submit"]' );
                $submitStartDate.val( date );
                $submitEndDate.val( date );
            }

        }

    };

    BookNowHandler.prototype.updateBookingRooms = function() {
        var roomsRequired = parseInt( $( '.rooms-required' ).val() ),
            adults        = parseInt( $( '.guests-adults' ).val() );
        if ( adults < roomsRequired ) {
            $( '.guests-adults' ).val( roomsRequired );
            $( '.guests-adults' ).trigger( 'js-result-change' );
        }

        $( '.qty' ).val( roomsRequired );
    };

    BookNowHandler.prototype.updateGuestPicker = function() {
        var roomsRequired = parseInt( $( '.rooms-required' ).val() ),
            adults        = parseInt( $( '.guests-adults' ).val() ),
            children      = parseInt( $( '.guests-children').val() ),
            guests        = adults + children,
            roomSingular  = $( '.rooms-count' ).data( 'textSingular' ),
            roomPlural    = $( '.rooms-count' ).data( 'textPlural' ),
            guestSingular = $( '.guests-count' ).data( 'textSingular' ),
            guestPlural   = $( '.guests-count' ).data( 'textPlural' ),
            roomsCount    = '',
            guestsCount   = '';

        if ( roomsRequired == 1 ) {
            roomsCount = roomsRequired + ' ' + roomSingular;
        } else {
            roomsCount = roomsRequired + ' ' + roomPlural;
        }

        if ( guests == 1 ) {
            guestsCount = guests + ' ' + guestSingular;
        } else {
            guestsCount = guests + ' ' + guestPlural;
        }

        $( '.rooms-count' ).html( roomsCount );
        $( '.guests-count' ).html( guestsCount );
    };

    BookNowHandler.prototype.updateGuests = function() {
        var adults   = parseInt( $( '.guests-adults' ).val() ),
            children = parseInt( $( '.guests-children').val() );
            infant   = parseInt( $( '.guests-infant').val() );


        $( 'input[name="guests_adults"]' ).val( adults );
        $( 'input[name="guests_children"]' ).val( children );
        $( 'input[name="guests_infant"]' ).val( infant );

        $( '.adults .wapf-input' ).val( adults );
        $( '.children .wapf-input' ).val( children );
        $( '.infant .wapf-input' ).val( infant );

    };

    BookNowHandler.prototype.toggleBookNowButton = function() {
        $( '.single_add_to_cart_button' ).each( function() {
            var $btn             = $( this ),
                maxAdults        = parseInt( $btn.data( 'maxAdults' ) ),
                maxChildren      = parseInt( $btn.data( 'maxChildren' ) ),
                maxInfant        = parseInt( $btn.data( 'maxInfant' ) ),
                adults           = parseInt( $( '.guests-adults' ).val() ),
                children         = parseInt( $( '.guests-children').val() ),
                infant           = parseInt( $( '.guests-infant' ).val() ),
                rooms            = parseInt( $( '.rooms-required' ).val() ),
                totalMaxAdults   = rooms * maxAdults,
                totalMaxChildren = rooms * maxChildren;

            $is_disabled = ( adults > totalMaxAdults || children > totalMaxChildren );
            $btn.prop( 'disabled', $is_disabled );
        });
    };

    /**
     * Init BookNowHandler.
     */
    new BookNowHandler();
});