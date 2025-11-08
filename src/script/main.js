// Elements
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

// variables and constants
const breakPoint = 650;

let changed = true;
let change = false;

let offscreenHeader = false;
let searchBarFocused = false;

// funcions

function checkHeaderOnScreen(header) {
  return header.getBoundingClientRect().bottom <= 0;
}

function MoveElementsToDesktop() {
  mobileButtons.classList.remove("hidden");
  mobileButtons.prepend(searchBar);
  menu.insertBefore(nav, menu.children[1]);
  menu.append(accountContainer);
}

function MoveElementsToMobile() {
  mobileButtons.classList.add("hidden");
  menu.classList.add("menu__hidden");
  header.insertBefore(nav, header[1]);
  navContainer.append(searchBar);
  header.append(accountContainer);
}

// responsiveness javascript

function MoveElements() {
  offscreenHeader = checkHeaderOnScreen(header);

  if (window.innerWidth <= breakPoint || offscreenHeader) {
    searchBar.classList.remove("hover");

    if (!changed) {
      return;
    }
    change = !inputQuery.classList.contains("shrunken");

    MoveElementsToDesktop();

    changed = !changed;
  } else {
    if (searchBarFocused) {
      searchBar.classList.add("hover");
    } else {
      searchBar.classList.remove("hover");
    }

    if (changed) {
      return;
    }
    change = !inputQuery.classList.contains("shrunken");

    MoveElementsToMobile();

    changed = !changed;
  }
}

window.addEventListener("resize", MoveElements);
window.addEventListener("scroll", MoveElements);
document.addEventListener("DOMContentLoaded", MoveElements);

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

// carousel
function SetCarousel(carouselSelector) {
  const carousel = document.querySelector(carouselSelector);
  const radios = carousel.querySelectorAll('input[type="radio"]');
  const leftArrow = carousel.querySelector(".nav > .left");
  const rightArrow = carousel.querySelector(".nav > .right");

  radios[0].checked = true;

  function moveSlide(direction) {
    const activeRadio = carousel.querySelector('input[type="radio"]:checked');
    let currentIndex = Array.from(radios).indexOf(activeRadio);
    let nextIndex = currentIndex + direction;

    if (nextIndex >= radios.length) {
      nextIndex = 0;
    } else if (nextIndex < 0) {
      nextIndex = radios.length - 1;
    }

    radios[nextIndex].checked = true;
  }

  setInterval(() => moveSlide(1), 30000);

  leftArrow.addEventListener("click", () => moveSlide(-1));
  rightArrow.addEventListener("click", () => moveSlide(1));
}
