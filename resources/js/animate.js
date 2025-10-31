import { animate, delay } from "motion";

function animateOnScroll(selector, keyframes, baseOptions = {}) {
    const elements = document.querySelectorAll(selector);

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            const el = entry.target;

            if (entry.isIntersecting) {
                const delayAttr = el.getAttribute("data-delay");
                const delay = delayAttr ? parseFloat(delayAttr) : baseOptions.delay || 0;

                const options = {
                    ...baseOptions,
                    delay
                };

                animate(el, keyframes, options);
            } else {
                animate(el, { opacity: 0, x: -50 }, { duration: 0 });
            }
        });
    }, { threshold: 0.3 });

    elements.forEach(el => {
        el.style.opacity = 0;
        el.style.transform = "translateX(-50px)";
        observer.observe(el);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    animateOnScroll(".title", { opacity: [0, 1], x: [-50, 0] }, { duration: 1, delay: 0.5 });
    animateOnScroll(".subtitle", { opacity: [0, 1], x: [-50, 0] }, { duration: 1, delay: 1 });
    animateOnScroll(".animate-button", { opacity: [0, 1], x: [-50, 0] }, { duration: 1, delay: 1.5 });

    animateOnScroll(".about-title", { opacity: [0, 1], x: [50, 0] }, { duration: 1 });
    animateOnScroll(".about-subtitle", { opacity: [0, 1], x: [50, 0] }, { duration: 1, delay: 0.5 });

    animateOnScroll(".team-title", { opacity: [0, 1], y: [50, 0] }, { duration: 1, delay: 0.5 });

    animateOnScroll(".card", { opacity: [0, 1], y: [50, 0] }, { duration: 1 });
});
