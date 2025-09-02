// Responsiveness
const header = document.querySelector(".header__container");

const searchBar = document.querySelector(".search__bar");
const navContainer = document.querySelector(".nav__container");
const nav = document.querySelector("nav");
const accountContainer = document.querySelector(".account__container");

const mobileButtons = document.querySelector(".mobile__buttons");
const menu = document.querySelector(".menu__container");

const inputForm = document.querySelector(".search__bar form");
const inputQuery = document.querySelector(".search__bar form input");

const menuButton = document.getElementById("menu__toggle");

const breakPoint = 650;

let changed = false;
let change = false;

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
    if (!inputQuery.classList.contains("shrunken")) {
      change = true;
    }
    mobileButtons.prepend(searchBar);

    menu.insertBefore(nav, menu.children[1]);
    menu.append(accountContainer);

    changed = !changed;
  } else {
    if (changed) {
      return;
    }

    mobileButtons.classList.add("hidden");
    menu.classList.add("menu__hidden");

    header.insertBefore(nav, header[1]);
    if (!inputQuery.classList.contains("shrunken")) {
      change = true;
    }
    navContainer.append(searchBar);

    header.append(accountContainer);

    changed = !changed;
  }
}

window.addEventListener("resize", moveElements);
window.addEventListener("scroll", moveElements);

window.addEventListener("hashchange", () => {
  moveElements();
});

// Search bar

searchBar.addEventListener("click", () => {
  searchBar.classList.add("focused");
  inputForm.classList.remove("hidden");
  setTimeout(() => {
    inputQuery.classList.remove("shrunken");
  }, 10);
  inputQuery.focus();
  if (!offscreenHeader) {
    searchBar.classList.add("hover");
  }
  searchBarFocused = true;
});

inputQuery.addEventListener("blur", () => {
  if (change) {
    change = false;
    setTimeout(() => {
      inputQuery.focus();
    }, 10);
  } else {
    inputQuery.classList.add("shrunken");
    setTimeout(() => {
      inputForm.classList.add("hidden");
      searchBar.classList.remove("focused");
      searchBar.classList.remove("hover");
      searchBarFocused = false;
    }, 510);
  }
});

// Menu

document.addEventListener("click", (event) => {
  if (menuButton.contains(event.target)) {
    menu.classList.toggle("menu__hidden");
    return;
  }
  if (
    !menu.contains(event.target) ||
    event.target.tagName == "A" ||
    event.target.tagName == "I" ||
    event.target.tagName == "SPAN"
  ) {
    menu.classList.add("menu__hidden");
  }
});
