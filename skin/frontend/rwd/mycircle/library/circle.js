/**
 * Main theme logic
 *
 * @author Seventhqueen
 */

var CIRCLE = CIRCLE || {};
(function ($) {

    // USE STRICT
    "use strict";

    CIRCLE.main = {

        circleContainer: $(".circle-text"),
        /* checked */
        init: function () {

            CIRCLE.main.circleContainer.each(function() {
                var $this = $(this);
                var margT = $this.outerWidth() / 2;
                $this.children(".circle_number").css("left", Math.max(0, (margT + parseInt($this.css("margin-left"))))  + "px");

                //$this.children( ".circle_number" ).html(margT);
            });

            //var positionContainer = CIRCLE.main.circleContainer.innerWidth();
            //var offsetcontainer = CIRCLE.main.circleContainer.offset().left;
            //
            //
            //
            //CIRCLE.main.circleElement.css("left", Math.max(0, ((positionContainer) / 2) +
            //        $(window).scrollLeft() + offsetcontainer) + "px");


        }

    };

    var $window = $(window),
        $body = $('body'),
        $wrapper = $('#page-wrapper');

    $(document).ready(CIRCLE.main.init);


})(jQuery);
