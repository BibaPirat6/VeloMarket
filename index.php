<?php
session_start();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ВелоМаркет</title>
    <link rel="stylesheet" href="styles/reset.css">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="index.php"><img src="assets/images/logo.svg" alt="logo"></a>
        </div>
        <button class="burger-open">☰</button>
        <div class="burger-modal">
            <div class="burger-content">
                <button class="burger-close">✖</button>

                <div class="burger__item"><a href="#header">Главная</a></div>
                <div class="burger__item"><a href="catalog.php?type=all">Аренда</a></div>
                <div class="burger__item"><a href="#how">Как оплатить</a></div>
                <div class="burger__item"><a href="#footer">Контакты</a></div>
                <div class="header__contact burger"><a href="tel:+79025052211">+7 902 505-22-11</a></div>
            </div>
        </div>
        <nav class="header__nav">
            <div class="header__nav__item"><a href="#header">Главная</a></div>
            <div class="header__nav__item"><a href="catalog.php?type=all">Аренда</a></div>
            <div class="header__nav__item"><a href="#how">Как оплатить</a></div>
            <div class="header__nav__item"><a href="#footer">Контакты</a></div>
        </nav>
        <div class="header__contact"><a href="tel:+79025052211">+7 902 505-22-11</a></div>
        <div class="header__profile">
            <div class="header__profile__user">
                <img src="assets/images/user-icon.svg" alt="profile-icon">
            </div>
            <p><a href="profile.php?page=orders">Профиль</a></p>
        </div>
    </header>

    <section class="banner" id="header">
        <div class="banner__content">
            <h1>Поехали кататься уже сегодня</h1>
            <button class="btn-yellow"><span><a href="catalog.php?type=all">Арендовать велосипед</a></span></button>
        </div>
    </section>

    <section class="rent" id="rent">
        <div class="container">
            <h2>Варианты аренды</h2>
            <div class="rent__list">
                <div class="rent__list__item">
                    <a href="catalog.php?type=all"><img src="assets/images/rent1.jpg" alt="электровелосипед"></a>
                    <h3>Электровелосипеды</h3>
                    <p>Быстро добраться куда угодно без усилий. Идеально для города и длительных поездок.</p>
                </div>
                <div class="rent__list__item">
                    <a href="catalog.php?type=all"><img src="assets/images/rent2.jpg" alt="городской велосипед"></a>
                    <h3>Городские велосипеды</h3>
                    <p>Комфортные, лёгкие и простые в управлении. Лучший выбор для неспешных поездок по городу.</p>
                </div>
                <div class="rent__list__item">
                    <a href="catalog.php?type=all"><img src="assets/images/rent3.jpg" alt="скоростной велосипед"></a>
                    <h3>Скоростные велосипеды</h3>
                    <p>Для тех, кто любит скорость. Идеальны для трасс и дальних маршрутов.</p>
                </div>
                <div class="rent__list__item">
                    <a href="catalog.php?type=all"><img src="assets/images/rent4.jpg" alt="семейный велосипед"></a>
                    <h3>Семейные велосипеды</h3>
                    <p>Для прогулок всей семьёй. Удобные модели для детей и взрослых.</p>
                </div>
            </div>
        </div>
    </section>



    <section class="instruction" id="how">
        <div class="container">
            <h2>Как купить и получить велосипед за 5 минут</h2>
            <div class="instruction__list">
                <div class="instruction__list__item">
                    <img src="assets/images/instruction1.svg" alt="фоточка">
                    <div class="instruction__text">
                        <h4>1 Найдите ближайший велосипед или точку выдачи</h4>
                        <p>На карте выберите велосипед поблизости — он может стоять в городе или на специальной
                            станции.Доступные модели отмечены разными цветами: обычные, скоростные, семейные и электро.
                        </p>
                    </div>
                </div>
                <div class="instruction__list__item">
                    <img src="assets/images/instruction2.svg" alt="фоточка">
                    <div class="instruction__text">
                        <h4>2 Выберите тип велосипеда</h4>
                        <p>Электровелосипед — доступен для онлайн-оплаты.
                            Обычный / скоростной / премиум / семейный — оплачиваются у продавца на точке.</p>
                    </div>
                </div>
                <div class="instruction__list__item">
                    <img src="assets/images/instruction3.svg" alt="фоточка">
                    <div class="instruction__text">
                        <h4>3А Электровелосипеды — оплачивайте онлайн</h4>
                        <p>Оплатите по СБП или картой прямо на сайте. После подтверждения оплаты велосипед
                            автоматически
                            разблокируется, и можно ехать.</p>
                    </div>
                </div>
                <div class="instruction__list__item">
                    <img src="assets/images/instruction4.svg" alt="фоточка">
                    <div class="instruction__text">
                        <h4>3Б Обычные велосипеды — оплатите на точке</h4>
                        <p>Подойдите к продавцу в пункте выдачи. Он проверит велосипед, примет оплату и разблокирует
                            замок.
                        </p>
                    </div>
                </div>
                <div class="instruction__list__item">
                    <img src="assets/images/instruction5.svg" alt="фоточка">
                    <div class="instruction__text">
                        <h4>4 Езжайте — велосипед уже ваш</h4>
                        <p>Настройте сидение, проверьте тормоза и отправляйтесь в путь. Пользуйтесь по тарифу или
                            возвращайте на любую доступную точку.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="minimap">
        <div class="container">
            <h2>Наши точки по всему городу</h2>
            <div class="yandex-map" style="position:relative;overflow:hidden;"><a
                    href="https://yandex.ru/maps/org/trial_sport/1019652895/?utm_medium=mapframe&utm_source=maps"
                    style="color:#eee;font-size:12px;position:absolute;top:0px;">Триал-Спорт</a><a
                    href="https://yandex.ru/maps/20/arkhangelsk/category/sports_store/184107345/?utm_medium=mapframe&utm_source=maps"
                    style="color:#eee;font-size:12px;position:absolute;top:14px;">Спортивный магазин в
                    Архангельске</a><a
                    href="https://yandex.ru/maps/20/arkhangelsk/category/bicycle_shop/184107325/?utm_medium=mapframe&utm_source=maps"
                    style="color:#eee;font-size:12px;position:absolute;top:28px;">Веломагазин в Архангельске</a><iframe
                    src="https://yandex.ru/map-widget/v1/?display-text=%D0%92%D0%B5%D0%BB%D0%BE%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD&ll=40.534500%2C64.539797&mode=search&oid=1019652895&ol=biz&sctx=ZAAAAAgBEAAaKAoSCR3HD5VGRERAEfvOL0rQIlBAEhIJmZtvRPesmz8RQj7o2az6fD8iBgABAgMEBSgKOABAkacNSAFqAnJ1nQHNzMw9oAEAqAEAvQEIf4jGwgEVn9aa5gOrkYaJjAP56vjRBp2qr6EGggIbKChjYXRlZ29yeV9pZDooMTg0MTA3MzI1KSkpigIJMTg0MTA3MzI1kgIAmgIMZGVza3RvcC1tYXBz&sll=40.534500%2C64.539797&sspn=0.032364%2C0.008473&text=%7B%22text%22%3A%22%D0%92%D0%B5%D0%BB%D0%BE%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%22%2C%22what%22%3A%5B%7B%22attr_name%22%3A%22category_id%22%2C%22attr_values%22%3A%5B%22184107325%22%5D%7D%5D%7D&utm_source=share&z=15.43"
                    width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
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
                        <p><a href="#header">Главная</a></p>
                        <p><a href="#rent">Виды велосипедов</a></p>
                        <p><a href="#how">Как арендовать</a></p>
                        <p><a href="catalog.php?type=all">Каталог товаров</a></p>
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
</body>

</html>