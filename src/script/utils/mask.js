export default function mask (model, textElement, input) {
    let number = model.isNumber
    if (number) {
        number = Number(input.data)
    }
    if (isNaN(number) || !model.hasSpace && input.data == " ") {
        textElement.value = textElement.value.slice(0, -1)
    }
    model.syntax.forEach(value => {
        if (textElement.value.length == model.end + 1) {
        textElement.value = textElement.value.slice(0, -1)
        }
        if (textElement.value.length == value[0]) {
        textElement.value = textElement.value.slice(0, -1)
        textElement.value += value[1]
        if (input.data) {
            textElement.value += input.data
        }
        }
        if (textElement.value.length == value[0] + value[1].length - 1 && input.data == null) {
        textElement.value = textElement.value.slice(0, -value[1].length)
        }
    });
}

export const models = {
    'CPF': {
        'syntax': [
            [4, '.'],
            [8, '.'],
            [12, '-']
        ],
        'end': 14,
        'isNumber': true,
        'hasSpace': false
    },
    'PhoneNumber': {
        'syntax': [
            [1, '('],
            [4, ') '],
            [11, '-'],
        ],
        'end': 15,
        'isNumber': true,
        'hasSpace': false
    }
}