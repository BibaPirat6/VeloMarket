document.addEventListener("DOMContentLoaded", () => {
    const script = document.querySelector('script[src="scripts/validation.js"]');
    if (!script) return;
    const formType = script.dataset.form;


    switch (formType) {
        case "register":
            testRegister()
            break;
        case "auth":
            testAuth();
            break;
        case "catalog":
            testCatalog();
            break;
        case "rent":
            testRent();
            break;
        default:
            console.log("на этой странице нету формы");
            break;
    }
})

function testRegister() {
    const form = document.querySelector(".form-register");
    if (!form) return;

    const inputs = form.querySelectorAll("[data-input]");

    const rules = {
        login(value) {
            if (!value) return "Заполните поле логина";
            if (!/^[a-zA-Z0-9]{5,255}$/.test(value)) {
                return "Логин должен содержать 5–255 символов: только английские буквы и цифры, без пробелов.";
            }
            return "";
        },
        phone(value) {
            if (!value) return "Заполните поле телефона";
            if (!/^[78][0-9]{10,19}$/.test(value)) {
                return "Телефон должен начинаться с 7 или 8 и содержать от 11 до 20 цифр.";
            }
            return "";
        },
        name(value) {
            if (!value) return "Заполните поле имени";
            if (!/^[A-Za-zА-Яа-яЁё]{2,255}$/u.test(value)) {
                return "Имя может содержать только русские и английские буквы, без пробелов. Длина: 2–255 символов.";
            }
            return "";
        },
        pwd(value) {
            if (!value) return "Заполните поле пароля";
            if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:,.?\/<>|~`]).{8,20}$/.test(value)) {
                return "Пароль должен быть от 8 до 20 символов и содержать минимум: 1 заглавную букву, 1 строчную букву, 1 цифру и 1 символ.";
            }
            return "";
        },
        reppwd(value, form) {
            const pwd = form.querySelector("[data-input='pwd']").value;
            if (!value) return "Повторите пароль";
            if (value !== pwd) return "Пароли не совпадают";
            return "";
        }
    };


    inputs.forEach(input => {
        input.addEventListener("input", () => {
            const ruleName = input.dataset.input;
            const value = input.value.trim();
            const errorMessage = rules[ruleName](value, form);

            const small = input.nextElementSibling.tagName === "SMALL" ? input.nextElementSibling : null;

            if (small) {
                if (errorMessage) {
                    input.classList.add("error");
                    input.classList.remove("success");
                    small.textContent = errorMessage;
                } else {
                    input.classList.remove("error");
                    input.classList.add("success");
                    small.textContent = "";
                }
            }
        });
    });

    const button = form.querySelector("button[type='submit']");
    form.addEventListener("input", () => {
        const hasErrors = Array.from(inputs).some(input => rules[input.dataset.input](input.value.trim(), form));
        button.disabled = hasErrors;
    });
}


function testAuth() {
    const form = document.querySelector(".auth");
    if (!form) return;

    const inputs = form.querySelectorAll("[data-input]");
    const button = form.querySelector("button[type='submit']");

    const rules = {
        phone(value) {
            if (!value) return "Заполните поле телефона";
            if (!/^[78][0-9]{10,19}$/.test(value)) {
                return "Телефон должен начинаться с 7 или 8 и содержать от 11 до 20 цифр.";
            }
            return "";
        },
        pwd(value) {
            if (!value) return "Заполните поле пароля";
            if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:,.?\/<>|~`]).{8,20}$/.test(value)) {
                return "Пароль должен быть от 8 до 20 символов и содержать минимум: 1 заглавную букву, 1 строчную букву, 1 цифру и 1 символ.";
            }
            return "";
        },
    };

    function validateField(input) {
        const ruleName = input.dataset.input;
        const value = input.value.trim();

        const phoneValue = form.querySelector("[data-input='phone']").value.trim();
        const pwdValue = form.querySelector("[data-input='pwd']").value.trim();
        if (phoneValue === "admin" && pwdValue === "admin") {
            input.classList.remove("error");
            input.classList.add("success");
            input.nextElementSibling.textContent = "";
            return "";
        }

        const errorMessage = rules[ruleName](value, form);
        const small = input.nextElementSibling.tagName === "SMALL" ? input.nextElementSibling : null;

        if (small) {
            if (errorMessage) {
                input.classList.add("error");
                input.classList.remove("success");
                small.textContent = errorMessage;
            } else {
                input.classList.remove("error");
                input.classList.add("success");
                small.textContent = "";
            }
        }

        return errorMessage;
    }

    inputs.forEach(input => {
        input.addEventListener("input", () => {
            validateField(input);

            const allErrors = Array.from(inputs).some(input => {
                const phoneValue = form.querySelector("[data-input='phone']").value.trim();
                const pwdValue = form.querySelector("[data-input='pwd']").value.trim();
                if (phoneValue === "admin" && pwdValue === "admin") return false;

                return rules[input.dataset.input](input.value.trim(), form);
            });

            button.disabled = allErrors;
        });
    });

    button.disabled = Array.from(inputs).some(input => rules[input.dataset.input](input.value.trim(), form));
}

function testRent() {
    const form = document.querySelector(".form-order");
    if (!form) return;

    const input = form.querySelector("[data-input='end_date']");
    const button = form.querySelector("button[type='submit']");

    function validateDate() {
        const value = input.value.trim();
        const small = input.nextElementSibling.tagName === "SMALL" ? input.nextElementSibling : null;
        const today = new Date();
        const maxDate = new Date();
        maxDate.setMonth(maxDate.getMonth() + 1);

        if (!value) {
            if (small) small.textContent = "Вы не заполнили поле";
            input.classList.add("error");
            input.classList.remove("success");
            return false;
        }

        const selectedDate = new Date(value + "T00:00:00");

        if (selectedDate < today.setHours(0, 0, 0, 0)) {
            if (small) small.textContent = "Дата окончания аренды не может быть раньше сегодняшнего числа";
            input.classList.add("error");
            input.classList.remove("success");
            return false;
        }

        if (selectedDate > maxDate) {
            if (small) small.textContent = "Нельзя выбрать дату больше чем на 1 месяц вперёд!";
            input.classList.add("error");
            input.classList.remove("success");
            return false;
        }

        if (small) small.textContent = "";
        input.classList.remove("error");
        input.classList.add("success");
        return true;
    }

    input.addEventListener("input", validateDate);

    form.addEventListener("input", () => {
        button.disabled = !validateDate();
    });

    button.disabled = !validateDate();
}

function testCatalog() {
    const form = document.querySelector(".form-add-product");
    if (!form) return;

    const inputs = form.querySelectorAll("[data-input]");
    const button = form.querySelector("button[type='submit']");

    const rules = {
        name(value) {
            if (!value) return "Заполните название велосипеда";
            if (!/^[a-zA-Zа-яА-ЯёЁ0-9 ]+$/u.test(value)) {
                return "Название может содержать только буквы, цифры и пробелы";
            }
            return "";
        },
        img(fileInput) {
            if (!fileInput.files || fileInput.files.length === 0) {
                return "Вы не выбрали изображение";
            }
            return "";
        },
        price(value) {
            if (!value) return "Введите цену";
            if (!/^(?:[5-9]\d|[1-9]\d{2}|[1-9]\d{3}|10000)$/.test(value)) {
                return "Цена должна быть от 50 до 10000";
            }
            return "";
        },
        type(value) {
            if (!value) return "Выберите тип велосипеда";
            if (!/^(city|electro|family|speed)$/.test(value)) {
                return "Некорректный тип велосипеда";
            }
            return "";
        },
    };

    function validateField(input) {
        const ruleName = input.dataset.input;
        let value = input.value.trim();

        if (input.type === 'file') {
            value = input;
        }

        const errorMessage = rules[ruleName](value);
        const small = input.nextElementSibling.tagName === "SMALL" ? input.nextElementSibling : null;

        if (small) {
            if (errorMessage) {
                input.classList.add("error");
                input.classList.remove("success");
                small.textContent = errorMessage;
            } else {
                input.classList.remove("error");
                input.classList.add("success");
                small.textContent = "";
            }
        }
    }

    inputs.forEach(input => {
        input.addEventListener("input", () => validateField(input));
        if (input.type === "file") {
            input.addEventListener("change", () => validateField(input));
        }
    });

    function validateForm() {
        const hasErrors = Array.from(inputs).some(input => {
            if (input.type === "file") {
                return rules[input.dataset.input](input) !== "";
            }
            return rules[input.dataset.input](input.value.trim()) !== "";
        });

        button.disabled = hasErrors;
    }

    form.addEventListener("input", validateForm);
    form.addEventListener("change", validateForm);

    validateForm();
}