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
                animate(el, { opacity: 0 }, { duration: 0.4 });
            }
        });
    }, { threshold: 0.3 });

    elements.forEach(el => {
        el.style.opacity = 0;
        observer.observe(el);
    });
}

function closeMessage() {
    const successMessage = document.getElementById('success-message');
    const closeButton = document.getElementById('message-close');

    animate(successMessage, { opacity: [1, 0], x: [0, -150] }, { duration: 1 });
}

document.addEventListener("DOMContentLoaded", () => {
    animateOnScroll(".title", { opacity: [0, 1], x: [-50, 0] }, { duration: 1, delay: 0.5 });
    animateOnScroll(".subtitle", { opacity: [0, 1], x: [-50, 0] }, { duration: 1, delay: 1 });
    animateOnScroll(".animate-button", { opacity: [0, 1], x: [-50, 0] }, { duration: 1, delay: 1.5 });
    
    animateOnScroll(".about-title", { opacity: [0, 1], x: [50, 0] }, { duration: 1 });
    animateOnScroll(".about-subtitle", { opacity: [0, 1], x: [50, 0] }, { duration: 1, delay: 0.5 });
    animateOnScroll(".about-button", { opacity: [0, 1], x: [50, 0] }, { duration: 1, delay: 1 });

    animateOnScroll(".team-title", { opacity: [0, 1], y: [50, 0] }, { duration: 1, delay: 0.5 });

    animateOnScroll(".card", { opacity: [0, 1], y: [50, 0] }, { duration: 0.6 });

    animateOnScroll(".form", { opacity: [0, 1] }, { duration: 1, delay: 0.5 });

    animateOnScroll(".ball-green", { opacity: [0, 1] }, { duration: 1 });
    animateOnScroll(".ball-yellow", { opacity: [0, 1] }, { duration: 1, delay: 0.5 });
    
    animateOnScroll(".success", { opacity: [0, 1], x: [-150, 0] }, { duration: 1 });

    setTimeout(() => {
        closeMessage();
    }, 10000);

    const closeButton = document.getElementById('message-close');
    closeButton.addEventListener('click', closeMessage);
});