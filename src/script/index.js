// Search bar
const searchBar = document.querySelector('.search__bar');
const icon = document.querySelector('.search__bar i')
const inputForm = document.querySelector('.search__bar form');
const inputQuery = document.querySelector('.search__bar form input');

icon.addEventListener('click', () => {
  console.log('not__focused')
  inputForm.classList.remove('not__focused');
  inputQuery.classList.remove('not__focused');
  searchBar.classList.add('focused');
  inputQuery.focus();
})

inputQuery.addEventListener('focus', () => {
  searchBar.classList.add('hover__search__bar');
});

inputQuery.addEventListener('blur', () => {
  searchBar.classList.remove('hover__search__bar');
  inputForm.classList.add('not__focused');
  inputQuery.classList.add('not__focused');
  searchBar.classList.remove('focused');
});

// Menu
const menuButton = document.getElementById('menu__toggle');
const menu = document.querySelector('.menu__container');

menuButton.addEventListener('click', PointerEvent => {
  menu.classList.toggle('active');
})