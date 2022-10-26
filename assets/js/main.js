(function ($) {
    'use strict';

    // Preloader
    window.onload = function () {
        document.body.classList.add('loaded_hiding');
        window.setTimeout(function () {
            document.body.classList.add('loaded');
            document.body.classList.remove('loaded_hiding');
        }, 1000);
    }

    // Slick slider on the listing page
    $('.listing-slider').slick({
        infinite: false,
        dots: true,
        autoplay: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });

    // Back to top button
    const goTopBtn = document.querySelector('.back_to_top');

    const trackScroll = () => {
        let scrolled = window.pageYOffset;
        let coords = document.documentElement.clientHeight;
        if (scrolled > coords) {
            goTopBtn.classList.add('back_to_top-show');
        } else if (scrolled < coords) {
            goTopBtn.classList.remove('back_to_top-show');
        };
    };

    const backToTop = () => {
        window.scrollTo(0, 0);
    };

    window.addEventListener('scroll', trackScroll);
    goTopBtn.addEventListener('click', backToTop);

    // Reviews color (0 - gray, 1-3 - purple, 4-5 - green)
    const reviewsColor = () => {
        const reviewsNumb = document.querySelectorAll('.reviews__number span#num');
        const reviewsBox = document.querySelectorAll('.listings__item-reviews-box');
        for (let i = 0, length = reviewsBox.length; i < length; i++) {
            for (let i = 0, length = reviewsNumb.length; i < length; i++) {
                let reviewResult = reviewsNumb[i].textContent;
                if (reviewResult >= 4) {
                    reviewsBox[i].classList.add('bg-green');
                } else if ((reviewResult < 4 && reviewResult > 0)) {
                    reviewsBox[i].classList.add('bg-purple');
                } else if (reviewResult == 0) {
                    reviewsBox[i].classList.add('bg-gray');
                } else {
                    reviewsBox[i].classList.add('bg-gray');
                };
            };
        };
    };

    reviewsColor();

    // Sort list/grid
    const sort = () => {
        const sortList = document.querySelector('.listings__sort-list');
        const sortGrid = document.querySelector('.listings__sort-grid');
        const listingsItems = document.querySelector('.listings__items');
        const listingsItem = document.querySelectorAll('.listings__item');

        const list = () => {
            sortList.classList.add('color-purple');
            sortGrid.classList.remove('color-purple');
            listingsItems.classList.add('list');
            listingsItems.classList.remove('grid');
            for (let i = 0, length = listingsItem.length; i < length; i++) {
                listingsItem[i].classList.remove('grid-item');
                listingsItem[i].classList.add('list-item');
            };
            localStorage.setItem('sort', 'list');
        };

        const grid = () => {
            sortGrid.classList.add('color-purple');
            sortList.classList.remove('color-purple');
            listingsItems.classList.add('grid');
            listingsItems.classList.remove('list');
            for (let i = 0, length = listingsItem.length; i < length; i++) {
                listingsItem[i].classList.remove('list-item');
                listingsItem[i].classList.add('grid-item');
            };
            localStorage.setItem('sort', 'grid');
        };

        const localStorageSort = () => {
            let localSort = localStorage.getItem('sort');
            switch (localSort) {
                case 'list':
                    list();
                    break;
                case 'grid':
                    grid();
                    break;
            };
        };

        localStorageSort();
        sortList.addEventListener('click', list);
        sortGrid.addEventListener('click', grid);
    };

    document.querySelector('.listings__sort') && sort();

    // PageViews
    /* const view = document.querySelectorAll('.pageviews-placeholder');

    const pageView = () => {
        for (let i = 0, length = view.length; i < length; i++) {
            let count = view[i].getAttribute('data-key');
            view[i].textContent = count;
        };
    };

    pageView(); */


})(jQuery);

