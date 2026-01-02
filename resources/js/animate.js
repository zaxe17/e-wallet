import { animate, delay, scale } from "motion";

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
                    delay,
                    easing: 'ease-in'
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

    animate(successMessage, { opacity: [1, 0], x: [0, -250] }, { duration: 1 });
}

document.addEventListener("DOMContentLoaded", () => {
    animateOnScroll(".left", { opacity: [0, 1], x: [-50, 0] }, { duration: 0.5 });

    animateOnScroll(".right", { opacity: [0, 1], x: [50, 0] }, { duration: 0.5 });

    animateOnScroll(".up", { opacity: [0, 1], y: [50, 0] }, { duration: 0.5 });

    animateOnScroll(".show", { opacity: [0, 1] }, { duration: 0.5 });

    animateOnScroll(".openModal", { opacity: [0, 1] }, { duration: 0.3 });



    animateOnScroll(".card", { opacity: [0, 1], y: [50, 0] }, { duration: 0.6 });

    animateOnScroll(".form-animation", { opacity: [0, 1] }, { duration: 1, delay: 0.5 });

    animateOnScroll(".ball-green", { opacity: [0, 1] }, { duration: 1 });
    animateOnScroll(".ball-yellow", { opacity: [0, 1] }, { duration: 1, delay: 0.6 });

    animateOnScroll(".success", { opacity: [0, 1], x: [-250, 0] }, { duration: 1 });

    animateOnScroll(".boxes", { opacity: [0, 1], y: [25, 0] }, { duration: 0.3 });

    animateOnScroll(".table-row", { opacity: [0, 1] }, { duration: 0.5 });

    animateOnScroll(".line", { opacity: [0, 1], width: ['0%', '100%'] }, { duration: 1 });

    


    setTimeout(() => {
        closeMessage();
    }, 10000);

    const closeButton = document.getElementById('message-close');
    if (closeButton) {
        closeButton.addEventListener('click', closeMessage);
    }
});