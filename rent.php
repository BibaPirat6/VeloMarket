<?php
session_start();

$mysqli = new mysqli("MySQL-8.0", "root", "", "db_bikes");

if (empty($_SESSION["user_role"]) || empty($_SESSION["user_id"])) {
    header("Location: ./register.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>


    <div class="error-box" style="display: <?= !empty($_SESSION["create_order_errors"]) ? "block" : "none" ?>"> <?php
          if (!empty($_SESSION["create_order_errors"])) {
              foreach ($_SESSION["create_order_errors"] as $err) {
                  echo "<p>$err</p>";
              }
              unset($_SESSION["create_order_errors"]);
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



    <div class="order-modal__overlay">
        <div class="order-modal">
            <form class="form-order" method="post" action="./php/makeOrder.php">
                <h3>Арендовать велосипед</h3>

                <input type="number" hidden name="product_id" value="<?= !empty($_GET["id"]) ? $_GET["id"] : '' ?>">


                <label for="order-end-datetime">Выберите дату окончания аренды:*</label>
                <input data-input="end_date" type="date" name="date" id="order-end-datetime">
                <small class="error-message"></small>

                <button type="submit" class="btn-black">Арендовать</button>
            </form>
        </div>
    </div>



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
    <script src="scripts/validation.js" data-form="rent"></script>
</body>

</html>