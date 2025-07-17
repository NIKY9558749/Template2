/**
 * counter.js - contatori animati moderni
 * Usa IntersectionObserver invece di jQuery.appear
 */

document.addEventListener('DOMContentLoaded', function() {
  const counters = document.querySelectorAll('.counter-number');

  const startCount = (counter) => {
    const from = parseInt(counter.dataset.from) || 0;
    const to = parseInt(counter.dataset.to) || 0;
    const duration = parseInt(counter.dataset.speed) || 1000;

    let start = null;

    const step = (timestamp) => {
      if (!start) start = timestamp;
      const progress = Math.min((timestamp - start) / duration, 1);
      counter.textContent = Math.floor(progress * (to - from) + from);
      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        counter.textContent = to;
      }
    };

    window.requestAnimationFrame(step);
  };

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        startCount(entry.target);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counters.forEach(counter => {
    observer.observe(counter);
  });
});
