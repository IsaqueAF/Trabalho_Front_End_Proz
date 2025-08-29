const searchBar = document.querySelector('.search__bar');
const inputQuery = document.querySelector('.search__bar form input');

searchBar.addEventListener('click', () => {
  inputQuery.focus();  
  inputQuery.computedStyleMap.color = "red";
});

inputQuery.addEventListener('focus', () => {
  searchBar.classList.add("hover__search__bar");
});

inputQuery.addEventListener('blur', () => {
  searchBar.classList.remove("hover__search__bar");
});