// document.addEventListener("DOMContentLoaded", function () {
//     const marquee = document.getElementById("newsMarquee");
//     const toggleBtn = document.getElementById("toggleMarquee");

//     let isPaused = false;

//     toggleBtn.addEventListener("click", function () {
//         if (isPaused) {
//             marquee.start();
//             toggleBtn.innerHTML = '<i class="fa fa-pause"></i>';
//         } else {
//             marquee.stop();
//             toggleBtn.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
//         }
//         isPaused = !isPaused;
//     });
// });

// // -------------------scrollmsg--------------------------
// document.addEventListener("DOMContentLoaded", function () {
//     const marquee = document.getElementById("scrollMarquee");
//     const toggleBtn = document.getElementById("toggleScrollMarquee");

//     let isPaused = false;

//     toggleBtn.addEventListener("click", function () {
//         if (isPaused) {
//             marquee.start();
//             toggleBtn.innerHTML = '<i class="fa fa-pause"></i>';
//         } else {
//             marquee.stop();
//             toggleBtn.innerHTML = '<i class="fa fa-play" aria-hidden="true"></i>';
//         }
//         isPaused = !isPaused;
//     });
// });


// -----------------homeslider--------------------

let swiper;

    document.addEventListener("DOMContentLoaded", function () {
        swiper = new Swiper("#homeBannerSlider", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            navigation: {
                nextEl: ".banner-slider-button-next",
                prevEl: ".banner-slider-button-prev",
            },
        });

        const stopBtn = document.querySelector(".stop-slider");
        let isPaused = false;

        stopBtn.addEventListener("click", function () {
            if (!isPaused) {
                swiper.autoplay.stop();
                stopBtn.innerHTML = '<i class="fa fa-play"></i>';
            } else {
                swiper.autoplay.start();
                stopBtn.innerHTML = '<i class="fa fa-pause"></i>';
            }
            isPaused = !isPaused;
        });
    });

