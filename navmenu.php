<?php

echo '<hr>';
// Generate the navigation menu
echo '<div class="menu">';
if(isset($_SESSION['username'])) {
    echo '<a href="viewprofile.php">Просмотр профиля</a>';
    echo '<a href="editprofile.php">Редактирование профиля</a>';
    echo '<a href="logout.php">'. $_SESSION['username'] .' кликните для выхода с приложения</a>';
}
else {
    echo '<a href="login.php">Вход в приложение</a>';
    echo '<a href="signup.php">Создание учетной записи</a>';
}
echo '</div>';
echo '<hr>';

