// Responsiveness
const header = document.querySelector(".header__container");

const searchBar = document.querySelector(".search__bar");
const navContainer = document.querySelector(".nav__container");
const nav = document.querySelector("nav");
const accountContainer = document.querySelector(".account__container");

const mobileButtons = document.querySelector(".mobile__buttons");
const menu = document.querySelector(".menu__container");

const breakPoint = 650;

let changed = false;
let offscreenHeader = false;
let searchBarFocused = false;

function moveElements() {
  const headerRect = header.getBoundingClientRect();

  if (headerRect.bottom <= 0) {
    searchBar.classList.remove("hover");
    offscreenHeader = true;
  } else {
    if (searchBarFocused) {
      searchBar.classList.add("hover");
    } else {
      searchBar.classList.remove("hover");
    }
    offscreenHeader = false;
  }

  if (window.innerWidth <= breakPoint || offscreenHeader) {
    if (!changed) {
      return;
    }
    mobileButtons.classList.remove("hidden");
    mobileButtons.prepend(searchBar);
    menu.insertBefore(nav, menu.children[1]);
    menu.append(accountContainer);
    changed = !changed;
  } else {
    if (changed) {
      return;
    }
    mobileButtons.classList.add("hidden");
    menu.classList.add("hidden");
    header.insertBefore(nav, header[1]);
    navContainer.append(searchBar);
    header.append(accountContainer);
    changed = !changed;
  }
}

window.addEventListener("resize", moveElements);
window.addEventListener("scroll", moveElements);

moveElements();

// Search bar
const inputForm = document.querySelector(".search__bar form");
const inputQuery = document.querySelector(".search__bar form input");

searchBar.addEventListener("click", () => {
  searchBar.classList.add("focused");
  inputForm.classList.remove("hidden");
  inputQuery.focus();
  if (!offscreenHeader) {
    searchBar.classList.add("hover");
  }
  searchBarFocused = true;
});

inputQuery.addEventListener("blur", () => {
  searchBar.classList.remove("focused");
  searchBar.classList.remove("hover");
  inputForm.classList.add("hidden");
  searchBarFocused = false;
});

// Menu
const menuButton = document.getElementById("menu__toggle");

document.addEventListener("click", (event) => {
  if (menuButton.contains(event.target)) {
    menu.classList.toggle("hidden");
    return;
  }
  if (
    !menu.contains(event.target) ||
    event.target.tagName == "A" ||
    event.target.tagName == "I" ||
    event.target.tagName == "SPAN"
  ) {
    menu.classList.add("hidden");
  }
});
