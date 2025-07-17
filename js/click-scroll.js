// Sezioni da osservare
const sections = document.querySelectorAll('section[id^="section_"]');
const navLinks = document.querySelectorAll('.navbar-nav .nav-item .nav-link');

// Attiva link corrispondente mentre scrolli
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    const id = entry.target.getAttribute('id');
    const link = document.querySelector(`.navbar-nav .nav-item .nav-link[href="#${id}"]`);

    if (entry.isIntersecting) {
      navLinks.forEach(link => link.classList.remove('active'));
      if (link) link.classList.add('active');
    }
  });
}, {
  root: null,
  rootMargin: '0px 0px -70% 0px', // Triggera prima
  threshold: 0
});

// Osserva ogni sezione
sections.forEach(section => observer.observe(section));

// Scroll su click (opzionale, scroll-behavior: smooth fa già il suo)
$('.click-scroll').on('click', function (e) {
  e.preventDefault();
  const target = $(this).attr('href');
  const offset = $(target).offset().top - 90;

  $('html, body').animate({
    scrollTop: offset
  }, 0);
});

// Bottone Back to Top con fade
const backToTopBtn = document.getElementById("backToTopBtn");
if (backToTopBtn) {
  // Nascondi il bottone all'avvio
  backToTopBtn.style.display = "none";

  window.addEventListener('scroll', () => {
    if (window.scrollY > 200) {
      backToTopBtn.style.display = "block";
      backToTopBtn.classList.add('show');
    } else {
      backToTopBtn.style.display = "none";
      backToTopBtn.classList.remove('show');
    }
  });

  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}
