import './scss/index.scss';

//-- Mobile navigation
document.querySelector('.nav-mobile-toggle').addEventListener('click', (e) => {
  e.preventDefault();
  e.stopPropagation();
  e.target.classList.toggle('is-active');
  document.querySelector('.nav-main').classList.toggle('is-open');
});
