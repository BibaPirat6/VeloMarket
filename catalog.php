<?php
session_start();

$mysqli = new mysqli("MySQL-8.0", "root", "", "db_bikes");

$search = trim($_GET['search'] ?? '');

$type = $_GET['type'] ?? null;

$limit = 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if ($search) {
    $searchTerm = "%" . $search . "%";
    if ($type && $type !== "all") {
        $stmt_count = $mysqli->prepare("SELECT COUNT(*) as total FROM `products` WHERE `type`=? AND (`title` LIKE ? OR `price_per_hour` LIKE ?)");
        $stmt_count->bind_param("sss", $type, $searchTerm, $searchTerm);
    } else {
        $stmt_count = $mysqli->prepare("SELECT COUNT(*) as total FROM `products` WHERE `title` LIKE ? OR `price_per_hour` LIKE ?");
        $stmt_count->bind_param("ss", $searchTerm, $searchTerm);
    }
} else {
    if ($type && $type !== "all") {
        $stmt_count = $mysqli->prepare("SELECT COUNT(*) as total FROM `products` WHERE `type`=?");
        $stmt_count->bind_param("s", $type);
    } else {
        $stmt_count = $mysqli->prepare("SELECT COUNT(*) as total FROM `products`");
    }
}

$stmt_count->execute();
$res_count = $stmt_count->get_result();
$total_products = $res_count->fetch_assoc()['total'];
$stmt_count->close();

$total_pages = ceil($total_products / $limit);

if ($search) {
    $searchTerm = "%" . $search . "%";
    if ($type && $type !== "all") {
        $stmt = $mysqli->prepare("SELECT * FROM `products` WHERE `type`=? AND (`title` LIKE ? OR `price_per_hour` LIKE ?) LIMIT ? OFFSET ?");
        $stmt->bind_param("sssii", $type, $searchTerm, $searchTerm, $limit, $offset);
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM `products` WHERE `title` LIKE ? OR `price_per_hour` LIKE ? LIMIT ? OFFSET ?");
        $stmt->bind_param("ssii", $searchTerm, $searchTerm, $limit, $offset);
    }
} else {
    if ($type && $type !== "all") {
        $stmt = $mysqli->prepare("SELECT * FROM `products` WHERE `type`=? LIMIT ? OFFSET ?");
        $stmt->bind_param("sii", $type, $limit, $offset);
    } else {
        $stmt = $mysqli->prepare("SELECT * FROM `products` LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
    }
}

$stmt->execute();
$res = $stmt->get_result();
$products = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();


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
    <div class="error-box" style="display: <?= !empty($_SESSION["add_product_errors"]) ? "block" : "none" ?>"> <?php
          if (!empty($_SESSION["add_product_errors"])) {
              foreach ($_SESSION["add_product_errors"] as $err) {
                  echo "<p>$err</p>";
              }
              unset($_SESSION["add_product_errors"]);
          }
          ?>
    </div>

    <div class="success-box" style="display:<?= !empty($_SESSION["add_product_success"]) ? "block" : "none" ?>">
        <?php
        if (!empty($_SESSION["add_product_success"])) {
            echo $_SESSION["add_product_success"];
            unset($_SESSION["add_product_success"]);
        }
        ?>
    </div>

    <div class="success-box" style="display:<?= !empty($_SESSION["success_create_order"]) ? "block" : "none" ?>">
        <?php
        if (!empty($_SESSION["success_create_order"])) {
            echo $_SESSION["success_create_order"];
            unset($_SESSION["success_create_order"]);
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


    <?php if (isset($_SESSION['user_id'], $_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <div class="admin-panel">
            <div class="panel-add" title="добавить новый велосипед"><img src="assets/images/plus.svg" alt="add"></div>
        </div>
        <div class="admin-modal__overlay">
            <div class="admin-modal">
                <form class="form-add-product" method="post" action="./php/addProduct.php" enctype="multipart/form-data">
                    <h3>Добавление нового велосипеда</h3>
                    <label for="input-name">Название:*</label>
                    <input data-input="name" type="text" placeholder="Введите название" name="name" id="input-name">
                    <small class="error-message"></small>

                    <label for="input-photo">Выберите фото товара:*</label>
                    <input data-input="img" type="file" placeholder="Выбрать фотку" name="img" id="input-photo">
                    <small class="error-message"></small>

                    <label for="input-price">Укажите стоимость р/день:*</label>
                    <input data-input="price" type="number" placeholder="Введите стоимость аренды" name="price" id="input-price">
                    <small class="error-message"></small>
                    
                    
                    <label for="input-price">Выберите тип велосипеда:*</label>
                    <select data-input="type" name="type">
                        <option value="city">Городские</option>
                        <option value="electro">Электро</option>
                        <option value="family">Семейные</option>
                        <option value="speed">Скоростные</option>
                    </select>
                    <small class="error-message"></small>



                    <button type="submit" class="btn-black">Создать объявление</button>
                </form>
            </div>
        </div>
    <?php endif; ?>


    <section class="catalog">
        <div class="container">
            <h2>Наши велосипеды</h2>
            <div class="catalog__filter">
                <div class="filter__type">
                    <div class="filter__type__item"><a href="./php/products/products.php?type=all">Все</a></div>
                    <div class="filter__type__item"><a href="./php/products/products.php?type=city">Городские</a></div>
                    <div class="filter__type__item"><a href="./php/products/products.php?type=electro">Электро</a></div>
                    <div class="filter__type__item"><a href="./php/products/products.php?type=family">Семейные</a></div>
                    <div class="filter__type__item"><a href="./php/products/products.php?type=speed">Скоростные</a>
                    </div>
                </div>
                <div class="filter__search">
                    <form action="catalog.php" method="get">
                        <input type="search" placeholder="Поиск" name="search">
                        <button type="submit" class="btn-black">Найти</button>
                    </form>
                </div>
            </div>
            <div class="catalog__list">
                <?php foreach ($products as $key => $item): ?>
                    <div class="catalog__item">
                        <div class="catalog__item__text">
                            <p class="catalog__item__title"><?php echo $item["title"]; ?></p>
                            <p class="catalog__item__price"><?php echo $item["price_per_hour"]; ?> р/день</p>
                        </div>


                        <img class='catalog__item__img' src="/php/products/image.php?id=<?php echo $item["id"]; ?>">

                        <a href="rent.php?id=<?= $item['id'] ?>" class="btn-black rent-btn"
                            data-logged="<?= isset($_SESSION['user_id']) ? '1' : '0' ?>">
                            Арендовать
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="catalog__pagination">

                <?php if ($page > 1): ?>
                    <a href="?search=<?= urlencode($search) ?>&type=<?= urlencode($type) ?>&page=<?= $page - 1 ?>"
                        class="pagination__item big">← Назад</a>
                <?php endif; ?>

                <?php
                $start = max(1, $page - 2);
                $end = min($total_pages, $page + 2);

                for ($i = $start; $i <= $end; $i++):
                    $active = ($i == $page) ? "background-color:#b8b7b7;" : "";
                    ?>
                    <a href="?search=<?= urlencode($search) ?>&type=<?= urlencode($type) ?>&page=<?= $i ?>"
                        class="pagination__item" style="<?= $active ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?search=<?= urlencode($search) ?>&type=<?= urlencode($type) ?>&page=<?= $page + 1 ?>"
                        class="pagination__item big">Вперед →</a>
                <?php endif; ?>

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
    <script src="scripts/validation.js" data-form="catalog"></script>

</body>

</html>