/**
 * front.js
 *
 * Handles behaviour of the theme
 */
( function( $, window ) {
    'use strict';

    var is_rtl = $('body,html').hasClass('rtl');

    $(window).on('load', function () {
        // initialization of HSMegaMenu component
        if( typeof $.fn.HSMegaMenu !== "undefined" ) {
            $('.js-mega-menu').HSMegaMenu({
                event: $('.js-mega-menu').data( 'dropdown-trigger' ) === 'click' ? 'click': 'hover',
                pageContainer: $('.container'),
                breakpoint: 1199.98,
                hideTimeOut: 0
            } );
        }
    });

    $(document).on('ready', function () {
        // initialization of header
        if ( $.HSCore.components.hasOwnProperty( 'HSHeader' ) ) {
            $.HSCore.components.HSHeader.init($('#header'));
        }

        // initialization of unfold component
        if ( $.HSCore.components.hasOwnProperty( 'HSUnfold' ) ) {
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'));
        }

        if ( $.HSCore.components.hasOwnProperty( 'HSSlickCarousel' ) ) {
            $.HSCore.components.HSSlickCarousel.init('.js-slick-carousel');
        }

        // initialization of sticky blocks
        if ( $.HSCore.components.hasOwnProperty( 'HSStickyBlock' ) ) {
            $.HSCore.components.HSStickyBlock.init('.js-sticky-block');
        }

        // initialization of datepicker
        if ( $.HSCore.components.hasOwnProperty( 'HSRangeDatepicker' ) ) {
            $.HSCore.components.HSRangeDatepicker.init('.js-range-datepicker');
        }

        // initialization of quantity counter
        if ( $.HSCore.components.hasOwnProperty( 'HSQantityCounter' ) ) {
            $.HSCore.components.HSQantityCounter.init('.js-quantity');
        }

        // initialization of counters
        if ( $.HSCore.components.hasOwnProperty( 'HSCounter' ) ) {
            $.HSCore.components.HSCounter.init('.js-counter');
        }

        // initialization of go to
        if ( $.HSCore.components.hasOwnProperty( 'HSGoTo' ) ) {
            $.HSCore.components.HSGoTo.init('.js-go-to');
        }

        // initialization of popups
        if ( $.HSCore.components.hasOwnProperty( 'HSFancyBox' ) ) {
            $.HSCore.components.HSFancyBox.init('.js-fancybox');
        }

        // initialization of autonomous popups
        if ( $.HSCore.components.hasOwnProperty( 'HSModalWindow' ) ) {
            $.HSCore.components.HSModalWindow.init('[data-modal-target]', '.js-modal-window', {
                autonomous: true
            });
        }

        // initialization of malihu scrollbar
        if ( $.HSCore.components.hasOwnProperty( 'HSMalihuScrollBar' ) ) {
            $.HSCore.components.HSMalihuScrollBar.init($('.js-scrollbar'));
        }

        // initialization of svg injector module
        if ( $.HSCore.components.hasOwnProperty( 'HSSVGIngector' ) ) {
            $.HSCore.components.HSSVGIngector.init('.js-svg-injector');
        }

        // initialization of HSScrollNav component
        if ( $.HSCore.components.hasOwnProperty( 'HSScrollNav' ) ) {
            $.HSCore.components.HSScrollNav.init($('.js-scroll-nav'), {
                duration: 700
            });
        }

        // initialization of video player
        if ( $.HSCore.components.hasOwnProperty( 'HSVideoPlayer' ) ) {
            $.HSCore.components.HSVideoPlayer.init('.js-inline-video-player');
        }

        // initialization of show animations
        if ( $.HSCore.components.hasOwnProperty( 'HSShowAnimation' ) ) {
            $.HSCore.components.HSShowAnimation.init('.js-animation-link');
        }


        if( typeof $.blockUI !== "undefined" ) {
            $.blockUI.defaults.message                   = null;
            $.blockUI.defaults.overlayCSS.background     = '#fff url(' + mytravel_options.ajax_loader_url + ') no-repeat center';
            $.blockUI.defaults.overlayCSS.backgroundSize = '16px 16px';
            $.blockUI.defaults.overlayCSS.opacity        = 0.6;
        }

        $( 'body' ).on( 'adding_to_cart', function( e, $btn, data){
            $btn.closest( '.geeks-list-view, .product .card' ).block();
        });

        $( 'body' ).on( 'added_to_cart', function(){
            $( '.product .card, .geeks-list-view' ).unblock();
        });

            $('#single-hotel__rooms + button.single_add_to_cart_button').prop('disabled',true);

    });

    $('a[href=#reviews]').click(function(){
         $('html, body').animate({
         scrollTop: $("#reviews").offset().top
        }, 1000);
    });





    const theme = {
        init: () => {
            theme.interactiveMap();
            theme.viewSwitcher();

        },

        /**
         * Interactive map
         * @requires https://github.com/Leaflet/Leaflet
        */
        interactiveMap: () => {
            var mapList = document.querySelectorAll('.interactive-map');
        
            if (mapList.length === 0) return;

            var _loop5 = function _loop5(i) {
                var mapOptions = mapList[i].dataset.mapOptions,
                    mapOptionsExternal = mapList[i].dataset.mapOptionsJson,
                    map = void 0; // Map options: Inline JSON data

                if (mapOptions && mapOptions !== '') {
                    var mapOptionsObj = JSON.parse(mapOptions),
                        mapLayer = mapOptionsObj.mapLayer || 'https://api.maptiler.com/maps/voyager/{z}/{x}/{y}.png?key=5vRQzd34MMsINEyeKPIs',
                        mapCoordinates = mapOptionsObj.coordinates ? mapOptionsObj.coordinates : [0, 0],
                        mapZoom = mapOptionsObj.zoom || 1,
                        scrollWheelZoom = mapOptionsObj.scrollWheelZoom === false ? false : true,
                        markers = mapOptionsObj.markers; // Map setup

                    map = L.map(mapList[i], {
                        scrollWheelZoom: scrollWheelZoom
                    }).setView(mapCoordinates, mapZoom); // Tile layer

                    L.tileLayer(mapLayer, {
                        tileSize: 512,
                        zoomOffset: -1,
                        minZoom: 1,
                        attribution: "<a href=\"https://www.maptiler.com/copyright/\" target=\"_blank\">&copy; MapTiler</a> <a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">&copy; OpenStreetMap contributors</a>",
                        crossOrigin: true
                    }).addTo(map); // Markers

                    if (markers) {
                        for (n = 0; n < markers.length; n++) {
                            var iconUrl = markers[n].iconUrl,
                                iconClass = markers[n].className,
                                markerIcon = L.icon({
                                    iconUrl: iconUrl || mytravel_options.theme_url + 'assets/img/map/marker-icon.png',
                                    iconSize: [25, 39],
                                    iconAnchor: [12, 39],
                                    shadowUrl: mytravel_options.theme_url + 'assets/img/map/marker-shadow.png',
                                    shadowSize: [41, 41],
                                    shadowAnchor: [13, 41],
                                    popupAnchor: [1, -28],
                                    className: iconClass
                                }),
                                popup = markers[n].popup;
                            var marker = L.marker(markers[n].coordinates, {
                                icon: markerIcon
                            }).addTo(map);

                            if (popup) {
                                marker.bindPopup(popup);
                            }
                        }
                    } // Map options: External JSON file

                } else if (mapOptionsExternal && mapOptionsExternal !== '') {
                    fetch(mapOptionsExternal).then(function (response) {
                        return response.json();
                    }).then(function (data) {
                        var mapLayer = data.mapLayer || 'https://api.maptiler.com/maps/voyager/{z}/{x}/{y}.png?key=5vRQzd34MMsINEyeKPIs',
                            mapCoordinates = data.coordinates ? data.coordinates : [0, 0],
                            mapZoom = data.zoom || 1,
                            scrollWheelZoom = data.scrollWheelZoom === false ? false : true,
                            markers = data.markers; // Map setup

                        map = L.map(mapList[i], {
                            scrollWheelZoom: scrollWheelZoom
                        }).setView(mapCoordinates, mapZoom); // Tile layer

                        L.tileLayer(mapLayer, {
                            tileSize: 512,
                            zoomOffset: -1,
                            minZoom: 1,
                            attribution: "<a href=\"https://www.maptiler.com/copyright/\" target=\"_blank\">&copy; MapTiler</a> <a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">&copy; OpenStreetMap contributors</a>",
                            crossOrigin: true
                        }).addTo(map); // Markers

                        if (markers) {
                            for (var n = 0; n < markers.length; n++) {
                                var _iconUrl = markers[n].iconUrl,
                                    _iconClass = markers[n].className,
                                    _markerIcon = L.icon({
                                        iconUrl: _iconUrl || mytravel_options.theme_url + 'assets/img/map/marker-icon.png',
                                        iconSize: [25, 39],
                                        iconAnchor: [12, 39],
                                        shadowUrl: mytravel_options.theme_url + 'assets/img/map/marker-shadow.png',
                                        shadowSize: [41, 41],
                                        shadowAnchor: [13, 41],
                                        popupAnchor: [1, -28],
                                        className: _iconClass
                                    }),
                                    _popup = markers[n].popup;

                                var _marker = L.marker(markers[n].coordinates, {
                                    icon: _markerIcon
                                }).addTo(map);

                                if (_popup) {
                                    _marker.bindPopup(_popup);
                                }
                            }
                        }
                    }); // Map option: No options provided
                } else {
                    map = L.map(mapList[i]).setView([0, 0], 1);
                    L.tileLayer('https://api.maptiler.com/maps/voyager/{z}/{x}/{y}.png?key=5vRQzd34MMsINEyeKPIs', {
                        tileSize: 512,
                        zoomOffset: -1,
                        minZoom: 1,
                        attribution: "<a href=\"https://www.maptiler.com/copyright/\" target=\"_blank\">&copy; MapTiler</a> <a href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\">&copy; OpenStreetMap contributors</a>",
                        crossOrigin: true
                    }).addTo(map);
                }
            };

            for (var i = 0; i < mapList.length; i++) {
                var n;

                _loop5(i);
            }
        },

        /**
         * Switch visibility of an element
         * @memberof theme
         * @method viewSwitcher
         */
        viewSwitcher: () => {
            let switcher = document.querySelectorAll('[data-view]'), hash = window.location.hash, defaultView = document.querySelector( '[data-view-default]');

            if (switcher.length > 0) {

                for (let i = 0; i < switcher.length; i++) {
                    switcher[i].addEventListener('click', function(e) {
                        let target = this.dataset.view;
                        viewSwitch(target);
                        if (this.getAttribute('href') === '#') e.preventDefault();
                    });
                }
            }

            let viewSwitch = (target) => {
                let targetView = document.querySelector(target),
                targetParent = targetView.parentNode,
                siblingViews = targetParent.querySelectorAll('.view');

                for (let n = 0; n < siblingViews.length; n++) {
                    siblingViews[n].classList.remove('show');
                }

                targetView.classList.add('show');
            }

            let defaultTarget = false;
            if ( hash ) {
                let hashTarget = document.querySelector( hash );
                if ( null !== hashTarget ) {
                    defaultTarget = hash;
                } 
            } else if ( null !== defaultView ) {
                defaultTarget = '#' + defaultView.getAttribute( 'id' );
            }

            if ( false !== defaultTarget ) {
                viewSwitch( defaultTarget );
            }
        },
    }

    /**
     * Init theme core
     */
    theme.init();
    $(document).ready(function() {
        var defaultButtonText = $(`#updateAvailability`).text();
        var failureButtonText = 'Failed';
        
        $('#updateAvailability').click(function() {
          $(this).text('Updated');
        });
      
        $('.js-range-datepicker').on('click input change', function() {
          $('#updateAvailability').text(defaultButtonText);
        });
        $('.guests-picker .rooms-count, .guests-picker .guests-count').on('DOMSubtreeModified', function() {
            $('#updateAvailability').text(defaultButtonText);
          });
        $(document).ajaxError(function() {
        $('#updateAvailability').text(failureButtonText);
        });
      });

} )( jQuery, window );
