<?php
session_start();

if (empty($_SESSION["user_role"]) || empty($_SESSION["user_id"])) {
    header("Location: ./register.php");
    exit;
}
require_once "./php/profileData.php";
// require_once "./php/profile/loadUserOrders.php";



?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="success-box" style="display:<?= !empty($_SESSION["success-auth"]) ? "block" : "none" ?>">
        <?php
        if (!empty($_SESSION["success-auth"])) {
            echo $_SESSION["success-auth"];
            unset($_SESSION["success-auth"]);
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
            <p><a href="./php/logout.php">Выйти</a></p>
        </div>
    </header>


    <section class="profile">
        <div class="container">
            <div class="profile__content">
                <div class="profile__info">
                    <div class="profile__info__menu">
                        <p class="profile__link"><a href="catalog.php?type=all">Каталог</a></p>


                        <?php if ($_SESSION["user_role"] === "admin"): ?>
                            <p class="profile__link"><a href="profile.php?page=orders">Заявки пользователей</a></p>
                            <p class="profile__link"><a href="profile.php?page=users">Список пользователей</a></p>
                        <?php endif; ?>


                        <h3>Профиль</h3>
                        <p><?php echo $data["login"]; ?></p>
                        <p><?php echo $data["phone"]; ?></p>
                        <p class="profile__link"><a href="./php/logout.php">Выйти из профиля</a></p>
                    </div>
                </div>







                <div class="profile__orders">
                    <?php if ($_SESSION['user_role'] === "admin" && $_GET["page"] === "orders"): ?>
                        <h2>Заявки пользователей</h2>

                    <?php elseif ($_SESSION['user_role'] === "admin" && $_GET["page"] === "users"): ?>
                        <h2>Пользователи</h2>
                    <?php elseif ($_SESSION['user_role'] === "admin" && $_GET["page"] === "user_orders"): ?>
                        <h2>Заявки</h2>

                    <?php else: ?>
                        <h2>Ваши заявки</h2>
                    <?php endif; ?>



                    <div class="profile__list">
                        <?php
                        if ($_SESSION["user_role"] !== "admin"):
                            ?>
                            <?php
                            require_once "./php/loadUserBikes.php";
                            foreach ($data as $key => $order): ?>
                                <div class="profile__item">
                                    <div class="profile__item__content">
                                        <img src="./php/products/image.php?id=<?php echo $order['product_id']; ?>">


                                        <div class="profile__item__content__info">
                                            <div class="profile__item__main">
                                                <p class="profile__item__title"><?php echo $order["title"] ?></p>
                                                <p class="profile__item__price"><?php echo $order["price_per_hour"] ?> Р/день
                                                </p>
                                            </div>
                                            <div class="profile__item__status">
                                                <p><?php
                                                if ($order["name"] === "wait") {
                                                    echo "<span style='color:#657610'>ОЖИДАНИЕ</span>";
                                                } else if ($order["name"] === "approve") {
                                                    echo "<span style='color:#127610'>ОДОБРЕН</span>";
                                                } else if ($order["name"] === "cancel") {
                                                    echo "<span style='color:#761010'>ОТКЛОНЕН</span>";
                                                }
                                                ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile__item__date">
                                        <p>заявка подана <?php echo $order["start_datetime"] ?></p>
                                        <p>арендован до <?php echo $order["end_datetime"] ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                  
                        <?php endif; ?>


                        <?php if ($_SESSION["user_role"] === "admin" && $_GET["page"] === "orders"): ?>
                            <?php
                            require_once "./php/profile/loadAllOrders.php";
                            foreach ($orders as $key => $order): ?>
                                <div class="profile__item_container">
                                    <div class="profile__item">
                                        <div class="profile__item__content">
                                            <img src="./php/products/image.php?id=<?php echo $order['product_id']; ?>">


                                            <div class="profile__item__content__info">
                                                <div class="profile__item__main">
                                                    <p class="profile__item__title"><?php echo $order["title"] ?></p>
                                                    <p class="profile__item__price"><?php echo $order["price_per_hour"] ?>
                                                        Р/день
                                                    </p>
                                                </div>
                                                <div class="profile__item__status">
                                                    <p><?php
                                                    if ($order["name"] === "wait") {
                                                        echo "<span style='color:#657610'>ОЖИДАНИЕ</span>";
                                                    } else if ($order["name"] === "approve") {
                                                        echo "<span style='color:#127610'>ОДОБРЕН</span>";
                                                    } else if ($order["name"] === "cancel") {
                                                        echo "<span style='color:#761010'>ОТКЛОНЕН</span>";
                                                    }
                                                    ?></p>
                                                    <form class="change-status-form" action="./php/profile/changeStatus.php"
                                                        method="post">
                                                        <input type="number" name="order_id" hidden
                                                            value="<?php echo $order['order_id'] ?>">
                                                        <select name="status">
                                                            <option value="approve" selected>одобрить</option>
                                                            <option value="cancel">отклонить</option>
                                                            <option value="wait">в ожидание</option>
                                                        </select>
                                                        <button class="btn-black">изменить</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile__item__date">
                                            <p>заявка подана <?php echo $order["start_datetime"] ?></p>
                                            <p>арендован до <?php echo $order["end_datetime"] ?></p>
                                        </div>
                                    </div>

                                    <div class="profile__item__user__info">
                                        <div class="user__info__login"><b>Логин: </b><?php echo $order["login"] ?> </div>
                                        <div class="user__info__phone"><b>Тел: </b><?php echo $order["phone"] ?> </div>
                                        <div class="user__info__name"><b>Имя: </b><?php echo $order["user_name"] ?> </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php elseif ($_SESSION["user_role"] === "admin" && $_GET["page"] === "users"): ?>
                            <?php
                            require_once "./php/profile/loadAllUsers.php";
                            foreach ($users as $key => $user): ?>
                                <div class="profile__item_container">
                                    <div class="profile__item page__user-orders">
                                        <div class="profile__item__content__user">
                                            <p>Логин <b><?php echo $user["login"] ?></b></p>
                                            <p>Имя <b><?php echo $user["name"] ?></b></p>
                                            <p>Телефон <b>+<?php echo $user["phone"] ?></b></p>
                                        </div>
                                        <div class="profile__item__user__btn">
                                            <a href="./php/profile/loadUserOrders.php?id=<?= $user["id"] ?>">Заявки</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>


                        <?php elseif ($_SESSION["user_role"] === "admin" && $_GET["page"] === "user_orders"): ?>
                            <?php
                            $orders = [];

                            if (!empty($_GET['orders'])) {
                                $orders = json_decode($_GET['orders'], true);
                            }
                            ?>
                            <?php foreach ($orders as $key => $order): ?>
                                <div class="profile__item_container">
                                    <div class="profile__item">
                                        <div class="profile__item__content">
                                            <img src="./php/products/image.php?id=<?php echo $order['product_id']; ?>">


                                            <div class="profile__item__content__info">
                                                <div class="profile__item__main">
                                                    <p class="profile__item__title"><?php echo $order["title"] ?></p>
                                                    <p class="profile__item__price"><?php echo $order["price_per_hour"] ?>
                                                        Р/день
                                                    </p>
                                                </div>
                                                <div class="profile__item__status">
                                                    <p><?php
                                                    if ($order["name"] === "wait") {
                                                        echo "<span style='color:#657610'>ОЖИДАНИЕ</span>";
                                                    } else if ($order["name"] === "approve") {
                                                        echo "<span style='color:#127610'>ОДОБРЕН</span>";
                                                    } else if ($order["name"] === "cancel") {
                                                        echo "<span style='color:#761010'>ОТКЛОНЕН</span>";
                                                    }
                                                    ?></p>
                                                    <form class="change-status-form"
                                                        action="./php/profile/changeStatus.php?page=user_orders" method="post">
                                                        <input type="number" name="order_id" hidden
                                                            value="<?php echo $order['order_id'] ?>">
                                                        <select name="status">
                                                            <option value="approve" selected>одобрить</option>
                                                            <option value="cancel">отклонить</option>
                                                            <option value="wait">в ожидание</option>
                                                        </select>
                                                        
                                                        <button class="btn-black">изменить</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile__item__date">
                                            <p>заявка подана <?php echo $order["start_datetime"] ?></p>
                                            <p>арендован до <?php echo $order["end_datetime"] ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>



                </div>
            </div>
        </div>
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
</body>

</html>