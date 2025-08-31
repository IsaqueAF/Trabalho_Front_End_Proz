// Search bar
const searchBar = document.querySelector(".search__bar");
const inputForm = document.querySelector(".search__bar form");
const inputQuery = document.querySelector(".search__bar form input");
const mobileButtons = document.querySelector(".mobile__buttons");
const navContainer = document.querySelector(".nav__container");

const breakPoint = 650;

function moveElements() {
  if (window.innerWidth <= 650) {
    if (searchBar.parentElement == mobileButtons) {
      return;
    }
    mobileButtons.prepend(searchBar);
  } else {
    if (searchBar.parentElement == navContainer) {
      return;
    }
    navContainer.append(searchBar);
  }
}

window.addEventListener("resize", moveElements);

moveElements();

searchBar.addEventListener("click", () => {
  searchBar.classList.add("focused");
  inputForm.classList.remove("not__focused");
  inputQuery.focus();
});

inputQuery.addEventListener("blur", () => {
  searchBar.classList.remove("focused");
  inputForm.classList.add("not__focused");
});

// Menu
const menuButton = document.getElementById("menu__toggle");
const menu = document.querySelector(".menu__container");

menuButton.addEventListener("click", () => {
  menu.classList.toggle("active");
});
