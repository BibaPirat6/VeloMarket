<?php

session_start();

if (!empty($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}

if (!empty($_SESSION['reg-data'])) {
    unset($_SESSION['reg-data']);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="error-box" style="display: <?= !empty($_SESSION["errors_auth"]) ? "block" : "none" ?>"> <?php
          if (!empty($_SESSION["errors_auth"])) {
              foreach ($_SESSION["errors_auth"] as $err) {
                  echo "<p>$err</p>";
              }
              unset($_SESSION["errors_auth"]);
          }
          ?>
    </div>


    <div class="success-box" style="display:<?= !empty($_SESSION["success-reg"]) ? "block" : "none" ?>">
        <?php
        if (!empty($_SESSION["success-reg"])) {
            echo $_SESSION["success-reg"];
            unset($_SESSION["success-reg"]);
        }
        ?>
    </div>

    <header class="header" id="header" style="position: static;">
        <div class="logo">
            <a href="index.php"><img src="assets/images/logo.svg" alt="logo"></a>
        </div>
        <button class="burger-open">☰</button>
        <div class="burger-modal">
            <div class="burger-content">
                <button class="burger-close">✖</button>

                <div class="burger__item"><a href="index.php#header">Главная</a></div>
                <div class="burger__item"><a href="catalog.php?type=all">Аренда</a></div>
                <div class="burger__item"><a href="index.php#how">Как оплатить</a></div>
                <div class="burger__item"><a href="index.php#footer">Контакты</a></div>
                <div class="header__contact burger"><a href="tel:+79025052211">+7 902 505-22-11</a></div>
            </div>
        </div>
        <nav class="header__nav">
            <div class="header__nav__item"><a href="index.php#header">Главная</a></div>
            <div class="header__nav__item"><a href="catalog.php?type=all">Аренда</a></div>
            <div class="header__nav__item"><a href="index.php#how">Как оплатить</a></div>
            <div class="header__nav__item"><a href="index.php#footer">Контакты</a></div>
        </nav>
        <div class="header__contact"><a href="tel:+79025052211">+7 902 505-22-11</a></div>
        <div class="header__profile">
            <div class="header__profile__user">
                <img src="assets/images/user-icon.svg" alt="profile-icon">
            </div>
            <p><a href="profile.php?page=orders">Профиль</a></p>
        </div>
    </header>


    <section class="auth">
        <form class="form-auth" method="post" action="./php/authorization.php">
            <label for="input-tel">Введите ваш телефон</label>
            <input data-input="phone" value="<?php echo $_SESSION["old-reg-data"]["phone"] ?? $_SESSION["auth_data"]["tel"] ?? "" ?>" required type="tel"
                placeholder="+79009112233" name="tel" id="input-tel">
            <small class="error-message"></small>

            <label for="input-pwd">Введите ваш пароль</label>
            <input data-input="pwd" value="<?php echo $_SESSION["old-reg-data"]["pwd"] ?? $_SESSION["auth_data"]["pwd"] ?? "" ?>" required type="text" name="pwd"
                id="input-pwd">
            <small class="error-message"></small>

            <button type="submit" class="btn-black">Войти</button>
            <p class="form-register-auth"><span>Нет аккаунта?</span> <a href="register.php">Регистрация</a></p>
        </form>
    </section>


    <footer id="footer">
        <div class="container">
            <div class="footer__box">
                <div class="footer__nav">
                    <div class="footer__item">
                        <h4>Велосипеды</h4>
                        <p><a href="./php/products/products.php?type=electro">Электровелосипеды</a></p>
                        <p><a href="./php/products/products.php?type=city">Городские</a></p>
                        <p><a href="./php/products/products.php?type=speed">Скоростные</a></p>
                        <p><a href="./php/products/products.php?type=family">Семейные</a></p>
                    </div>
                    <div class="footer__item">
                        <h4>Карта сайта</h4>
                        <p><a href="index.php#header">Главная</a></p>
                        <p><a href="index.php#rent">Виды велосипедов</a></p>
                        <p><a href="index.php#how">Как арендовать</a></p>
                        <p><a href="profile.php?page=orders">Профиль</a></p>
                    </div>
                    <div class="footer__item">
                        <h4>О компании</h4>
                        <p><a href="tel:+79025052211">+7 902 505-22-11</a></p>
                        <p><a href="mailto:rider@gmail.com">rider@gmail.com</a></p>
                        <p><a href="assets/dogovor_prokata_v_Pushkine.pdf" style="text-decoration: underline;"
                                target="_blank">Правила использования</a></p>
                    </div>
                </div>
                <div class="footer__social">
                    <a href="https://web.telegram.org/"><img src="assets/images/tg.svg" alt="tg"></a>
                    <a href="https://vk.com/"><img src="assets/images/vk.svg" alt="vk"></a>
                    <a href="https://ok.ru/"><img src="assets/images/ok.svg" alt="ok"></a>
                </div>
            </div>
            <div class="footer-copyrigth">© 2025 ВелоМаркет. Аренда и обслуживание велосипедов в вашем городе.</div>
        </div>
    </footer>

    <script src="scripts/script.js"></script>
    <script src="scripts/validation.js" data-form="auth"></script>
</body>

</html>