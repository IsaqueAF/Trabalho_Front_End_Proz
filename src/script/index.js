const searchBar = document.querySelector('.search__bar');
const inputQuery = document.querySelector('.search__bar form input');

const CPFMask = [
  [4, "."],
  [8, "."],
  [12, "-"],
]

function mask (values, textElement, input, end, number) {
  if (number) {
    number = Number(input.data)
  }
  if (isNaN(number) || input.data == " ") {
    textElement.value = textElement.value.slice(0, -1)
  }
  values.forEach(value => {
    if (textElement.value.length === end + 1) {
      textElement.value = textElement.value.slice(0, -1)
    }
    if (textElement.value.length === value[0]) {
      textElement.value = textElement.value.slice(0, -1)
      textElement.value += value[1]
      if (input.data) {
        textElement.value += input.data
      }
    }
    if (textElement.value.length === value[0] + value[1].length - 1 && input.data === null) {
      textElement.value = textElement.value.slice(0, -value[1].length)
    }
  });
}

searchBar.addEventListener('click', () => {
  inputQuery.focus();  
  inputQuery.computedStyleMap.color = "red";
})

inputQuery.addEventListener('focus', () => {
  searchBar.classList.add("hover__search__bar");
});

inputQuery.addEventListener('blur', () => {
  searchBar.classList.remove("hover__search__bar");
});

inputQuery.addEventListener("input", input => {
  mask(CPFMask, inputQuery, input, 14, false)
})