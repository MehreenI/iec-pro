document.addEventListener("DOMContentLoaded", () => {
    function setupAnimations(selector, delay = 500) {
        const paths = document.querySelectorAll(selector);
        const observerOptions = { root: null, rootMargin: '0px', threshold: 0.3 };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const index = Array.from(paths).indexOf(target);
                    setTimeout(() => {
                        target.classList.add("animate");
                        // Debugging logs
                        console.log(`Class 'animate' added to ${target}`);
                    }, index * delay);
                    observer.unobserve(target);
                }
            });
        }, observerOptions);

        paths.forEach(path => {
            observer.observe(path);
        });
    }

    function initAnimations() {
        if (window.innerWidth > 768) {
            setupAnimations(".starlink-wrapper .right .items svg path");
            setupAnimations(".benefits-content .left .benefits-items .item .left .bottom svg path");
            setupAnimations(".benefits-content .right .benefits-items .item .bottom svg path", 600);
            setupAnimations(".iec_benefits_box .left .iec_benefits_item_warpper .bottom svg path");
            setupAnimations(".iec_benefits_box .right .iec_benefits_item_warpper .bottom svg path", 600);
            setupAnimations(".standart .left .image-with-item svg path", 600);
        }
    }

    // Initial check
    initAnimations();

    // Optional: Add an event listener to handle window resize
    window.addEventListener("resize", () => {
        if (window.innerWidth > 1024) {
            initAnimations();
        }
    });
});
