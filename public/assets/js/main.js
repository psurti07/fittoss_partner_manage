/**

 * Parallax
 * Content box
 * Counter
 * Sidebar Toggle
 * Lightbox
 * Preloader
 * Show Pass
 * Button Quantity
 * Input file
 * Delete image
 * Handle Search Form
 * Datepicker
 * One Page
 * Handle dashboard
 * Go Top
 * Cursor

**/

(function ($) {
    ("use strict");

    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return (
                isMobile.Android() ||
                isMobile.BlackBerry() ||
                isMobile.iOS() ||
                isMobile.Opera() ||
                isMobile.Windows()
            );
        },
    };

    var tabs = function () {
        $(".widget-tabs").each(function () {
            $(this).find(".widget-content-tab").children().hide();
            $(this).find(".widget-content-tab").children(".active").show();
            $(this)
                .find(".widget-menu-tab")
                .children(".item-title")
                .on("click", function () {
                    var liActive = $(this).index();
                    var contentActive = $(this)
                        .siblings()
                        .removeClass("active")
                        .parents(".widget-tabs")
                        .find(".widget-content-tab")
                        .children()
                        .eq(liActive);
                    contentActive.addClass("active").fadeIn("slow");
                    contentActive.siblings().removeClass("active");
                    $(this)
                        .addClass("active")
                        .parents(".widget-tabs")
                        .find(".widget-content-tab")
                        .children()
                        .eq(liActive)
                        .siblings()
                        .hide();
                });
        });
    };

    var collapse_item = function () {
        var args = { duration: 250 };
        $(".tf-collapse-item").each(function () {
            if ($(this).is(".collapsed")) {
                $(this).find(".tf-collapse-content").hide();
            } else {
                $(this).find(".tf-collapse-content").show();
            }
        });
        $(".tf-collapse-title").on("click", function () {
            $(this).parent(".tf-collapse-item").toggleClass("collapsed");
            if ($(this).parent(".tf-collapse-item").is(".collapsed")) {
                $(this)
                    .parent(".tf-collapse-item")
                    .find(".tf-collapse-content")
                    .slideUp(args);
            } else {
                $(this)
                    .parent(".tf-collapse-item")
                    .find(".tf-collapse-content")
                    .slideDown(args);
            }
        });
    };

    var headerSticky = function () {
        let didScroll;
        let lastScrollTop = 0;
        let delta = 5;
        let navbarHeight = $("header").outerHeight();
        $(window).scroll(function (event) {
            didScroll = true;
        });

        setInterval(function () {
            if (didScroll) {
                let st = $(this).scrollTop();

                // Make scroll more than delta
                if (Math.abs(lastScrollTop - st) <= delta) return;
                // If scrolled down and past the navbar, add class .nav-up.
                if (st > lastScrollTop && st > navbarHeight) {
                    // Scroll Down
                    $("header").css("top", `-${navbarHeight}px`);
                } else {
                    // Scroll Up
                    if (st + $(window).height() < $(document).height()) {
                        $("header").css("top", "0px");
                    }
                }
                lastScrollTop = st;
                didScroll = false;
            }
        }, 250);
    };

    var action_click = function () {
        $(".tf-action-btns").on("click", function () {
            $(this).toggleClass("active");
        });
    };

    var preloader = function () {
        setTimeout(function () {
            $(".preload").fadeOut("slow", function () {
                $(this).remove();
            });
        }, 200);
    };
    // Video
    var video = function () {
        if ($(".widget-video").length) {
            $(".play-button").on("click", function () {
                var videoUrl = "https://www.youtube.com/embed/MLpWrANjFbI?autoplay=1"; 
    
                var iframe = `
                    <iframe width="100%" height="100%" style="border-radius: 15px;"
                        src="${videoUrl}" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                `;
    
                $(this).parent(".video-wrapper").html(iframe);
            });
        }
    };
    // Quantity
    var btnQuantity = function () {
        $(".minus-btn").on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest(".wg-quantity").find("input");
            var value = parseInt($input.val());

            if (value > 1) {
                value = value - 1;
            }
            $input.val(value);
        });

        $(".plus-btn").on("click", function (e) {
            e.preventDefault();
            var $this = $(this);
            var $input = $this.closest(".wg-quantity").find("input");
            var value = parseInt($input.val());

            if (value > 0) {
                value = value + 1;
            }

            $input.val(value);
        });
    };

    // click close .widget.message-box-item --Manh--
    var btnDeleteBoxItem = function () {
        $(".icon-close-ms-box").on("click", function () {
            $(this).closest(".message-box-item").hide();
        });
    };

    //
    var tooltips = function () {
        $('[data-bs-toggle="tooltip"]').each(function () {
            new bootstrap.Tooltip(this);
        });
    };

    // xoa cart-shop
    var btnCloseCartShop = function () {
        $(".icon-close-cart-item").on("click", function () {
            $(this).closest(".shop-cart-item").hide();
        });
    };
    //selectContry
    var selectCountry = function () {
        $(".tf-select-label select").focus(function () {
            $(this).parents(".tf-select-label").addClass("focused");
        });

        $(".tf-select-label select").blur(function () {
            var inputValue = $(this).val();
            if (inputValue == "") {
                $(this).removeClass("filled");
                $(this).parents(".tf-select-label").removeClass("focused");
            } else {
                $(this).addClass("filled");
            }
        });
        $(".tf-select-label select").each(function () {
            if (this.value) {
                $(this).parents(".tf-select-label").addClass("focused");
                $(this).addClass("filled");
            }
        });
    };

    // var scrollSticky = function () {

    //     $(window).on("scroll", function () {
    //         const header = $(".sidebar-course");
    //         if ( $(window).scrollTop() > 0 ) {
    //             header.css('transform','translateY(100px)');
    //         } else {
    //             header.css('transform','translateY(0px)');
    //         }
    //     })
    // }

    var btnShowMoreText = function () {
        const showMoreBtn = $(".show-more");
        const moreText = $(".more-text");

        showMoreBtn.on("click", function () {
            moreText.toggleClass("active");
            // if (moreText.hasClass('active')) {
            //    showMoreButton.html('Show Short <i class="icon-arrow-top"></i>');

            // } else {
            //     showMoreButton.html('Show More <i class="icon-arrow-top"></i>');

            // }
        });
    };
    //
    var scrollIntoView = function () {
        $(".widget-menu-tab .course-single-v5").click(function () {
            const targetID = $(this).data("target");
            $("html, body").animate(
                {
                    scrollTop: $(targetID).offset().top,
                },
                0
            );
        });
    };

    // zoom img
    //     var section_zoom = function () {
    //     $(".tf-image-zoom").on("mouseover", function () {
    //         $(this).closest(".section-image-zoom").addClass("zoom-active");
    //     });
    //     $(".tf-image-zoom").on("mouseleave", function () {
    //         $(this).closest(".section-image-zoom").removeClass("zoom-active");
    //     });
    // }

    // var image_zoom = function () {
    //     var driftAll = document.querySelectorAll('.tf-image-zoom');
    //     var pane = document.querySelector('.tf-zoom-main');
    //     $(driftAll).each(function(i, el) {
    //         new Drift(
    //             el, {
    //             zoomFactor: 2,
    //             paneContainer: pane,
    //             inlinePane: false,
    //             handleTouch: false,
    //             hoverBoundingBox: true,
    //             containInline: true,
    //             }
    //         );
    //     });
    // }

    // var image_zoom_magnifier = function () {
    //     var driftAll = document.querySelectorAll('.tf-image-zoom-magnifier');
    //     $(driftAll).each(function(i, el) {
    //         new Drift(
    //             el, {
    //             zoomFactor: 2,
    //             inlinePane: true,
    //             containInline: false,
    //             }
    //         );
    //     });
    // }

    // var image_zoom_inner = function () {
    //     var driftAll = document.querySelectorAll('.tf-image-zoom-inner');
    //     var pane = document.querySelector('.tf-product-zoom-inner');
    //     $(driftAll).each(function(i, el) {
    //         new Drift(
    //             el, {
    //             paneContainer: pane,
    //             zoomFactor: 2,
    //             inlinePane: false,
    //             containInline: false,
    //             }
    //         );
    //     });
    // }

    // var lightboxswiper = function () {

    //     const lightbox = new PhotoSwipeLightbox({
    //         gallery: '#gallery-swiper-started',
    //         children: 'a',
    //         pswpModule: PhotoSwipe,
    //         bgOpacity: 1,
    //         secondaryZoomLevel: 2,
    //         maxZoomLevel: 3,
    //     });
    //     lightbox.init();

    //     lightbox.on('change', () => {
    //         const { pswp } = lightbox;
    //         main.slideTo(pswp.currIndex, 0, false);
    //     });

    //     lightbox.on('afterInit', () => {
    //         if (main.params.autoplay.enabled) {
    //             main.autoplay.stop();
    //         };
    //     });

    //     lightbox.on('closingAnimationStart', () => {
    //         const { pswp } = lightbox;
    //         main.slideTo(pswp.currIndex, 0, false);
    //         if (main.params.autoplay.enabled) {
    //             main.autoplay.start();
    //         }
    //     });

    // }

    // var lightbox = function () {

    //     const lightbox = new PhotoSwipeLightbox({
    //         gallery: '#gallery-started',
    //         children: 'a',
    //         pswpModule: PhotoSwipe,
    //         bgOpacity: 1,
    //         secondaryZoomLevel: 2,
    //         maxZoomLevel: 3,
    //     });
    //     lightbox.init();

    // }

    // var model_viewer = function () {

    //     if ($(".tf-model-viewer").length) {

    //         $(".tf-model-viewer-ui-button").on("click", function (e) {
    //             $(this).closest(".tf-model-viewer").find("model-viewer").removeClass("disabled");
    //             $(this).closest(".tf-model-viewer").toggleClass("active");
    //         });
    //         $(".tf-model-viewer-ui").on("dblclick", function (e) {
    //             $(this).closest(".tf-model-viewer").find("model-viewer").addClass("disabled");
    //             $(this).closest(".tf-model-viewer").toggleClass("active");
    //         });
    //     }

    // }

    var openLessonCourse = function () {
        const btnNavLesson = $(".btn-nav-lesson");
        const siderBa = $(".lesson-page-sidebar");
        const closeSideBar = $(".sidebar-title-close");
        const lessonPageContent = $(".lesson-page-content")
        // const pageLearn

        btnNavLesson.on("click", () => {
            siderBa.addClass("open-lesson-sidebar");
            lessonPageContent.addClass("lesson-page-close")
        });

        closeSideBar.on("click", () => {
            siderBa.removeClass("open-lesson-sidebar");
            lessonPageContent.removeClass("lesson-page-close")

        })
    };

    // manh end
    var counter = function () {
        if ($(document.body).hasClass("counter-scroll")) {
            var a = 0;
            $(window).scroll(function () {
                var counterElement = $(".counter");
                if (counterElement.length) {
                    var oTop = counterElement.offset().top - window.innerHeight;
                    if (a == 0 && $(window).scrollTop() > oTop) {
                        if ($().countTo) {
                            counterElement.find(".number").each(function () {
                                var to = $(this).data("to"),
                                    speed = $(this).data("speed");
                                $(this).countTo({
                                    to: to,
                                    speed: speed,
                                });
                            });
                        }
                        a = 1;
                    }
                }
            });
        }
    };

    var reaction = function () {
        $(".btn-like").click(function () {
            $(this).toggleClass("active");
            $(".btn-dislike").removeClass("active");
        });

        $(".btn-dislike").click(function () {
            $(this).toggleClass("active");
            $(".btn-like").removeClass("active");
        });
    };

    var rotateArrow = function () {
        $(".rotate-arrow").click(function () {
            $(this).find(".icon").toggleClass("rotate");
        });
    };

    // QUYNH-----------
    var UploadFlie = function () {
        $(".btn-update").on("click", function (e) {
            document.getElementById("file-input").click();
        });
        if ($("#file-input").length) {
            document
                .getElementById("file-input")
                .addEventListener("change", function (event) {
                    var file = event.target.files[0];
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var imgElement = document.getElementById("profile-img");
                        imgElement.src = e.target.result;
                        var filename = document.getElementById("name-file");
                        filename.textContent = file.name;
                    };

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                });
        }
    };
    var InstructorAnswer = function () {
        if ($(".answer").length) {
            document.querySelectorAll(".answer").forEach(function (el) {
                el.addEventListener("click", function () {
                    document
                        .querySelectorAll(".answer")
                        .forEach(function (answer) {
                            answer.classList.remove("selected");
                        });
                    this.classList.add("selected");
                });
            });
        }
    };
    var progresslevel = function () {
        if ($('div').hasClass('progress-bars')) {
            var bars = document.querySelectorAll('.progress-bars-line > div');
            setInterval(function () {
                bars.forEach(function (bar) {
                    var t1 = parseFloat(bar.dataset.progress);
                    var t2 = parseFloat(bar.dataset.max);
                    var getWidth = (t1 / t2) * 100;
                    bar.style.width = getWidth + '%';
                });
            }, 500);
        }
    }
    // // QUYNH_END-----------
    var infiniteScroll = function () {
        $(".fl-item").slice(0, 15).show();

        $(".fl-item2").slice(0, 5).show();
        $(".fl-item3").slice(0, 4).show();
        $(".fl-item4").slice(0, 5).show();

        $(".fl-filter-item5").slice(0, 5).show();
        $(".fl-filter-item6").slice(0, 4).show();
        $(".fl-filter-item7").slice(0, 5).show();

        if ($(".showmore-item").length > 0) {
            $(".btn-showmore").on("click", function () {
                setTimeout(() => {
                    $(".fl-item2:hidden").slice(0, 2).show();
                    if ($(".fl-item2:hidden").length == 0) {
                        $(".view-more-button").hide();
                    }
                }, 600);
            });
        }

        if ($(".showmore-item2").length > 0) {
            $(".btn-showmore2").on("click", function () {
                setTimeout(() => {
                    $(".fl-item3:hidden").slice(0, 2).show();
                    if ($(".fl-item3:hidden").length == 0) {
                        $(".view-more-button2").hide();
                    }
                }, 600);
            });
        }

        if ($(".showmore-item3").length > 0) {
            $(".btn-showmore3").on("click", function () {
                setTimeout(() => {
                    $(".fl-item4:hidden").slice(0, 2).show();
                    if ($(".fl-item4:hidden").length == 0) {
                        $(".view-more-button3").hide();
                    }
                }, 600);
            });
        }

        if ($(".showmore-item4").length > 0) {
            $(".btn-showmore4").on("click", function () {
                setTimeout(() => {
                    $(".fl-filter-item5:hidden").slice(0, 2).show();
                    if ($(".fl-filter-item5:hidden").length == 0) {
                        $(".view-more-button4").hide();
                    }
                }, 600);
            });
        }

        if ($(".showmore-item5").length > 0) {
            $(".btn-showmore5").on("click", function () {
                setTimeout(() => {
                    $(".fl-filter-item6:hidden").slice(0, 2).show();
                    if ($(".fl-filter-item6:hidden").length == 0) {
                        $(".view-more-button5").hide();
                    }
                }, 600);
            });
        }

        if ($(".showmore-item6").length > 0) {
            $(".btn-showmore6").on("click", function () {
                setTimeout(() => {
                    $(".fl-filter-item7:hidden").slice(0, 2).show();
                    if ($(".fl-filter-item7:hidden").length == 0) {
                        $(".view-more-button6").hide();
                    }
                }, 600);
            });
        }

        if ($(".loadmore-item").length > 0) {
            $(".btn-loadmore").on("click", function () {
                setTimeout(() => {
                    $(".fl-item:hidden").slice(0, 5).show();
                    if ($(".fl-item:hidden").length == 0) {
                        $(".view-more-button").hide();
                    }
                }, 600);
            });
        }
    };
    var loadmoreParagraph = function () {
        if ($(".show-more-desc-item").length > 0) {
            $(".btn-show-more-decs").on("click", function () {
                $(this).closest(".show-more-desc-item").find(".showmore-paragraph").slideDown();
                $(this).closest(".show-more-desc-item").find(".btn-hide-decs").show();
                $(this).hide();
            });
            $(".btn-hide-decs").on("click", function () {
                $(this).closest(".show-more-desc-item").find(".showmore-paragraph").slideUp();
                $(this).closest(".show-more-desc-item").find(".btn-show-more-decs").show();
                $(this).hide();
            });
        }

    };
    var gotop = function () {
        if ($('div').hasClass('progress-wrap')) {
            var progressPath = document.querySelector('.progress-wrap path');
            var pathLength = progressPath.getTotalLength();
            progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
            progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
            progressPath.style.strokeDashoffset = pathLength;
            progressPath.getBoundingClientRect();
            progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
            var updateprogress = function () {
                var scroll = $(window).scrollTop();
                var height = $(document).height() - $(window).height();
                var progress = pathLength - (scroll * pathLength / height);
                progressPath.style.strokeDashoffset = progress;
            }
            updateprogress();
            $(window).scroll(updateprogress);
            var offset = 150;
            var duration = 300;
            jQuery(window).on('scroll', function () {
                if (jQuery(this).scrollTop() > offset) {
                    jQuery('.progress-wrap').addClass('active-progress');
                } else {
                    jQuery('.progress-wrap').removeClass('active-progress');
                }
            });
            jQuery('.progress-wrap').on('click', function (event) {
                event.preventDefault();
                jQuery('html, body').animate({ scrollTop: 0 }, duration);
                return false;
            })
        }
    }
    var preloader = function () {
        setTimeout(function () {
            $(".preload-container").fadeOut("slow", function () {
                $(this).remove();
            });
        }, 1000);
    };

    const eventItems = document.querySelectorAll(".hover-images");

    function followImageCursor(event, eventItems) {
        const contentBox = eventItems.getBoundingClientRect();
        const dx = event.clientX - contentBox.x;
        const dy = event.clientY - contentBox.y;
        eventItems.children[2].style.transform = `translate(${dx}px, ${dy}px) rotate(0)`;
    }

    eventItems.forEach((item, i) => {
        item.addEventListener("mousemove", (event) => {
            setInterval(followImageCursor(event, item), 1000);
        });
    });

    var dashboard=function(){

        $(document).on('click',function(e){
            var clickID=e.target.id;if((clickID!=='s')){
                $('.instructors-dashboard').removeClass('show');
            }});
        $(document).on('click',function(e){
            var clickID=e.target.class;if((clickID!=='a111')){
                $('.dropbtn').removeClass('show');
        }});

        $('.dropbtn').on('click',function(event){
            event.stopPropagation();});
        $('.instructors-dashboard').on('click',function(event){
            event.stopPropagation();});

        $('.dropbtn').on('click',function(event){
            if(!$('.instructors-dashboard').hasClass("show")){
                $('.instructors-dashboard').addClass('show');
                    event.preventDefault();
                }
            else
                $('.instructors-dashboard').removeClass('show');
                event.preventDefault();
                if(!$('.dropbtn').hasClass("show"))
                    $('.dropbtn').addClass('show');
                else
                    $('.dropbtn').removeClass('show');
        })
    ;}

    // Dom Ready
    $(function () {
        tabs();
        collapse_item();
        headerSticky();
        action_click();
        video();
        btnQuantity();
        btnDeleteBoxItem();
        tooltips();
        selectCountry();
        btnCloseCartShop();
        UploadFlie();
        InstructorAnswer();
        preloader();
        counter();
        reaction();
        rotateArrow();
        infiniteScroll();
        // scrollSticky();
        btnShowMoreText();
        scrollIntoView();
        openLessonCourse();
        loadmoreParagraph();
        progresslevel();
        gotop();
        dashboard();
        // btnShowProductSub();
        // img zoom
        // section_zoom();
        // image_zoom();
        // image_zoom_magnifier();
        // image_zoom_inner();
        // lightboxswiper();
        // lightbox();
        // model_viewer();
        // </img zoom
    });


})(jQuery);
