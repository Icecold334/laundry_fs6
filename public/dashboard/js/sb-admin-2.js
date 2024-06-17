if (window.innerWidth < 768) {
    // Add the 'toggled' class to the sidebar
    document.getElementById("accordionSidebar").classList.add("toggled");
} else {
    // Remove the 'toggled' class from the sidebar
    document.getElementById("accordionSidebar").classList.remove("toggled");
}
(function ($) {
    "use strict"; // Start of use strict

    // Toggle the side navigation
    $("#sidebarToggle, #sidebarToggleTop").on("click", function (e) {
        let img = $("#logo-app");
        $("body").toggleClass("sidebar-toggled");
        $(".sidebar").toggleClass("toggled");

        if (window.matchMedia("(max-width: 767px)").matches) {
            // Small screen behavior
            if ($(".sidebar").hasClass("toggled")) {
                img.css("width", "30%"); // Shrink when sidebar is shown
            } else {
                img.css("width", "60%"); // Expand when sidebar is hidden
            }
        } else {
            // Larger screen behavior
            if ($(".sidebar").hasClass("toggled")) {
                img.css("width", "60%"); // Expand when sidebar is shown
            } else {
                img.css("width", "30%"); // Shrink when sidebar is hidden
            }
        }

        // if ($(".sidebar").hasClass("toggled")) {
        //     img.css("width", "60%");
        //     $(".sidebar .collapse").collapse("hide");
        // } else {
        //     img.css("width", "30%");
        // }
    });

    // Close any open menu accordions when window is resized below 768px
    $(window).resize(function () {
        if ($(window).width() < 768) {
            $(".sidebar .collapse").collapse("hide");
        }

        // Toggle the side navigation when window is resized below 480px
        if ($(window).width() < 480 && !$(".sidebar").hasClass("toggled")) {
            $("body").addClass("sidebar-toggled");
            $(".sidebar").addClass("toggled");
            $(".sidebar .collapse").collapse("hide");
        }
    });

    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
    $("body.fixed-nav .sidebar").on(
        "mousewheel DOMMouseScroll wheel",
        function (e) {
            if ($(window).width() > 768) {
                var e0 = e.originalEvent,
                    delta = e0.wheelDelta || -e0.detail;
                this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                e.preventDefault();
            }
        }
    );

    // Scroll to top button appear
    $(document).on("scroll", function () {
        var scrollDistance = $(this).scrollTop();
        if (scrollDistance > 100) {
            $(".scroll-to-top").fadeIn();
        } else {
            $(".scroll-to-top").fadeOut();
        }
    });

    // Smooth scrolling using jQuery easing
    $(document).on("click", "a.scroll-to-top", function (e) {
        var $anchor = $(this);
        $("html, body")
            .stop()
            .animate(
                {
                    scrollTop: $($anchor.attr("href")).offset().top,
                },
                1000,
                "easeInOutExpo"
            );
        e.preventDefault();
    });
})(jQuery); // End of use strict
