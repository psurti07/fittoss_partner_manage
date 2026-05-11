if ($(".tf-sw-mobile").length > 0) {
    var preview = $(".tf-sw-mobile").data("preview");
    var spacing = $(".tf-sw-mobile").data("space");

    if (matchMedia("only screen and (max-width: 1440px)").matches) {
        var swiper = new Swiper(".tf-sw-mobile", {
            spaceBetween: spacing,
            speed: 1000,
            pagination: {
                el: ".sw-pagination-mb",
                clickable: true,
            },
            navigation: {
                clickable: true,
                nextEl: ".nav-next-mb",
                prevEl: ".nav-prev-mb",
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                700: {
                    slidesPerView: 2,
                },
                1440: {
                    slidesPerView: preview,
                },
            },
        });
    }
}
if ($(".slide-brand").length > 0) {
    var swiper = new Swiper(".slide-brand", {
        spaceBetween: 30,
        slidesPerView: 2,
        observer: true,
        observeParents: true,
        loop: true,
        autoplay: {
            delay: 0,
            disableOnInteraction: false,
        },
        speed: 10000,
        breakpoints: {
            450: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
            868: {
                slidesPerView: 5,
                spaceBetween: 30,
            },
            1400: {
                slidesPerView: 6,
                spaceBetween: 90,
            },
        },
    });
}
if ($(".slider-page-title").length > 0) {
    var swiper = new Swiper(".slider-page-title", {
        spaceBetween: 20,
        observer: true,
        observeParents: true,
        // loop: true,
        // autoplay: {
        //     delay: 0,
        //     disableOnInteraction: false,
        // },
        // speed: 10000,
        breakpoints: {
            0: {
                slidesPerView: 1.2,
            },
            768: {
                slidesPerView: 1.8,
            },
            992: {
                slidesPerView: 2,
            }
        },
        navigation: {
            clickable: true,
            nextEl: ".page-title-next",
            prevEl: ".page-title-prev",
        },
    });
}
if ($(".widget-saying-list").length > 0) {
    var swiper = new Swiper(".widget-saying-list", {
        slidesPerView: 3,
        centeredSlides: true,
        observer: true,
        observeParents: true,
        loop: true,
        pagination: {
            clickable: true,
        },
        navigation: {
            nextEl: ".widget-saying-next",
            prevEl: ".widget-saying-prev",
            clickable: true,
        },
        coverflowEffect: {
            scale: 0.9,
        },
        breakpoints: {
            0: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            450: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            868: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1400: {
                slidesPerView: 5,
                spaceBetween: 70,
            },
        },
    });
}
if ($(".slider-courses-3").length > 0) {
    var swiper = new Swiper(".slider-courses-3", {
        spaceBetween: 60,
        observer: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 1.2,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1440: {
                slidesPerView: 3,
            },
        },
        navigation: {
            clickable: true,
            nextEl: ".course-single-prev",
            prevEl: ".course-single-next",
        },
    });
}
if ($(".slider-courses-4").length > 0) {
    var swiper = new Swiper(".slider-courses-4", {
        spaceBetween: 40,
        observer: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 1.2,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1440: {
                slidesPerView: 4,
            },
        },
        pagination: {
            el: ".pagination-courses1",
            clickable: true,
        },
        navigation: {
            clickable: true,
            nextEl: ".courses1-next",
            prevEl: ".courses1-prev",
        },
    });
}
if ($(".slider-courses-5").length > 0) {
    var swiper = new Swiper(".slider-courses-5", {
        spaceBetween: 25,
        observer: true,
        observeParents: true,
        breakpoints: {
            425: {
                slidesPerView: 1.5,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 2.3,
            },
            1000: {
                slidesPerView: 3,
            },
            1440: {
                slidesPerView: 3,
            },
        },
        pagination: {
            el: ".pagination-courses5",
            clickable: true,
        },
        navigation: {
            clickable: true,
            nextEl: ".courses5-next",
            prevEl: ".courses5-prev",
        },
    });
}
if ($(".kg-section-service").length > 0) {
    var swiper = new Swiper(".kg-section-service", {
        spaceBetween: 25,
        observer: true,
        observeParents: true,
        breakpoints: {
            425: {
                slidesPerView: 1.5,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 2.3,
            },
            1000: {
                slidesPerView: 3,
            },
            1440: {
                slidesPerView: 3,
            },
        },
        pagination: {
            el: ".pagination-courses5",
            clickable: false,
        },
        navigation: {
            clickable: false,
            nextEl: ".courses5-next",
            prevEl: ".courses5-prev",
        },
    });
}
if ($(".slider-courses-5-blog").length > 0) {
    var swiper = new Swiper(".slider-courses-5-blog", {
        spaceBetween: 25,
        observer: true,
        observeParents: true,
        breakpoints: {
            425: {
                slidesPerView: 1,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 1,
            },
            1000: {
                slidesPerView: 1,
            },
            1440: {
                slidesPerView: 1,
            },
        },
        pagination: {
            el: ".pagination-courses5",
            clickable: true,
        },
        navigation: {
            clickable: true,
            nextEl: ".courses5-next",
            prevEl: ".courses5-prev",
        },
    });
}
if ($(".slider-courses-6").length > 0) {
    var swiper = new Swiper(".slider-courses-6", {
        spaceBetween: 28.75,
        observer: true,
        centeredSlides: true,
        loop: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 1.5,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 2,
            },
            1000: {
                slidesPerView: 3,
            },
            1440: {
                slidesPerView: 4,
            },
        },
        pagination: {
            el: ".pagination-courses1",
            clickable: true,
        },
        navigation: {
            clickable: true,
            nextEl: ".courses2-next",
            prevEl: ".courses2-prev",
        },
    });
}
if ($(".slider-courses-7").length > 0) {
    var swiper = new Swiper(".slider-courses-7", {
        spaceBetween: 20,
        observer: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 1.1,
                spaceBetween: 10,
            },
            360: {
                slidesPerView: 1.2,
                spaceBetween: 10,
            },
            420: {
                slidesPerView: 1.4,
                spaceBetween: 15,
            },
            576: {
                slidesPerView: 1.5,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 2.5,
                spaceBetween: 25,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 28.75,
            },
            1440: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
        pagination: {
            el: ".pagination-courses1",
            clickable: true,
        },
        navigation: {
            clickable: true,
            nextEl: ".courses2-next",
            prevEl: ".courses2-prev",
        },
    });
}
if ($(".slider-courses-8").length > 0) {
    var swiper = new Swiper(".slider-courses-8", {
        spaceBetween: 26.67,
        observer: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 1.2,
            },
            700: {
                slidesPerView: 2,
            },
            1440: {
                slidesPerView: 4,
            },
        },
        pagination: {
            el: ".pagination-courses1",
            clickable: true,
        },
        navigation: {
            clickable: true,
            nextEl: ".courses1-next",
            prevEl: ".courses1-prev",
        },
    });
}
if ($(".slider-courses-9").length > 0) {
    var swiper = new Swiper(".slider-courses-9", {
        spaceBetween: 28,
        observer: true,
        loop: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 1.5,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 2,
            },
            1000: {
                slidesPerView: 3,
            },
            1440: {
                slidesPerView: 4,
            },
        },
        pagination: {
            el: ".pagination-courses1",
            clickable: true,
        },
        navigation: {
            clickable: true,
            nextEl: ".courses2-next",
            prevEl: ".courses2-prev",
        },
    });
}
if ($(".slider-courses-10").length > 0) {
    var swiper = new Swiper(".slider-courses-10", {
        spaceBetween: 20,
        observer: true,
        loop: true,
        observeParents: true,
        breakpoints: {
            0: {
                slidesPerView: 1.5,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 4,
            },
            1000: {
                slidesPerView: 7,
            },
            1440: {
                slidesPerView: 10,
            },
        },
        pagination: {
            el: ".pagination-courses10",
            clickable: true,
        },
        navigation: {
            clickable: true,
            nextEl: ".courses10-next",
            prevEl: ".courses10-prev",
        },
    });
}
if ($(".slider-instagram").length > 0) {
    var preview = $(".slider-instagram").data("preview");
    var spacing = $(".slider-instagram").data("space");

    if (matchMedia("only screen and (max-width: 1440px)").matches) {
        var swiper = new Swiper(".slider-instagram", {
            spaceBetween: 15,
            observer: true,
            observeParents: true,
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 15,
                },
                700: {
                    slidesPerView: 3,
                },
                1000: {
                    slidesPerView: 5,
                },
                1440: {
                    slidesPerView: 7,
                },
            },
            pagination: {
                el: ".pagination-courses1",
                clickable: true,
            },
            navigation: {
                clickable: true,
                nextEl: ".courses2-next",
                prevEl: ".courses2-prev",
            },
        });
    }
}
if ($(".slider-category").length > 0) {
    var preview = $(".slider-category").data("preview");
    var spacing = $(".slider-category").data("space");

    if (matchMedia("only screen and (max-width: 1440px)").matches) {
        var swiper = new Swiper(".slider-category", {
            spaceBetween: 25,
            observer: true,
            observeParents: true,
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 15,
                },
                700: {
                    slidesPerView: 2,
                },
                1000: {
                    slidesPerView: 3,
                },
                1440: {
                    slidesPerView: 4,
                },
            },
            pagination: {
                el: ".pagination-courses1",
                clickable: true,
            },
            navigation: {
                clickable: true,
                nextEl: ".courses2-next",
                prevEl: ".courses2-prev",
            },
        });
    }
}
if ($(".slider-country").length > 0) {
    var preview = $(".slider-country").data("preview");
    var spacing = $(".slider-country").data("space");

    if (matchMedia("only screen and (max-width: 1440px)").matches) {
        var swiper = new Swiper(".slider-country", {
            spaceBetween: 10,
            observer: true,
            observeParents: true,
            breakpoints: {
                0: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                480: {
                    slidesPerView: 4,
                },
                700: {
                    slidesPerView: 6,
                },
                1000: {
                    slidesPerView: 8,
                },
                1440: {
                    slidesPerView: 10,
                },
            },
            pagination: {
                el: ".pagination-courses1",
                clickable: true,
            },
            navigation: {
                clickable: true,
                nextEl: ".courses2-next",
                prevEl: ".courses2-prev",
            },
        });
    }
}
if ($('div').hasClass("slider-popular-courses")) {
    var swiper = new Swiper(".slider-popular-courses", {
        spaceBetween: 40,
        observer: true,
        observeParents: true,
        pagination: {
            clickable: true,
            el: ".pagination-popular-courses",
        },
        navigation: {
            nextEl: ".popular-courses-next",
            prevEl: ".popular-courses-prev",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1.2,
                spaceBetween: 15,
            },
            700: {
                slidesPerView: 1,
                spaceBetween: 30,
            },
            1440: {
                slidesPerView: 1,
            },
        },
    });
}

var slider = new Swiper('.gallery-slider', {
    slidesPerView: 1,
    centeredSlides: true,
    loop: true,
    // loopedSlides: 1,
    loopedSlides: 5,
});

var thumbs = new Swiper('.gallery-thumbs', {
    // slidesPerView: 'auto',
    spaceBetween: 80,
    slidesPerView: 5,
    centeredSlides: true,
    loop: true,
    slideToClickedSlide: true,
    breakpoints: {
        0: {
            slidesPerView: 3,
            spaceBetween: 15,
        },
        450: {
            slidesPerView: 3,
            spaceBetween: 15,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 15,
        },
        868: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
        1400: {
            slidesPerView: 5,
        },
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

slider.controller.control = thumbs;
thumbs.controller.control = slider;

var titles = document.querySelectorAll('.slider-home9 .swiper-slide');
var title = [];
titles.forEach(function (element) {
    title.push(element.dataset.year);
});

var swiper = new Swiper('.slider-home9', {
    spaceBetween: 0,
    slidesPerView: 1,
    observer: true,
    observeParents: true,
    effect: "fade",
    fadeEffect: {
        crossFade: true,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        renderBullet: function (index, className) {
            return '<span class="' + className + '">' + title[index] + '</span>';
        },
    },
});