<?php
require_once('startsession.php');
$page_title = 'Страница входа в приложение.';
require_once('header.php');

require_once('appvars.php');
require_once('connectvars.php');

require_once('navmenu.php');

// Соиденение с базой данных
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$dbc->query('set names utf8');
$dbc->query("set lc_time_names='ru_RU'");

$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
$password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
$password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

if(isset($_POST['submit'])){
    if(!empty($username) && !empty($password1) && !empty($password2) && $password1 == $password2) {
        // Проверка на то, что таких пользователей с таким именем нет в базе
        $query = "SELECT * FROM mismatch_user WHERE username = '$username'";
        $data = mysqli_query($dbc, $query);
        if(mysqli_num_rows($data) == 0) {
            // Имя, введенное пользователем, не используется, поэтому добавляем данные в базу
            $query = "INSERT INTO mismatch_user(username, password, join_date)
                      VALUES ('$username', SHA('$password1'), NOW())";
            mysqli_query($dbc, $query);

            // Вывод подтверждения пользователю
            echo '<p>Ваша новая учетная запись успешно создана. Вы можете войти в приложение и '.
                '<a href="editprofile.php">отредактировать свой профиль</a></p>';
            mysqli_close($dbc);
            exit();
        }
        else{
            // Учетная запись с таким логином уже сувществует в базе
            echo '<p class="error">Учетная запись с таким именем уже сувществует. Введите пожалуйста другое.</p>';
            $username = "";
        }
    }
    else{
        echo '<p class="error">Вы должны ввести все даные для создания учетной записи, в том числе пароль дважды.</p>';
    }
}
mysqli_close($dbc);
?>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <fieldset>
            <legend>Входные данные</legend>
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>"><br>
            <label for="password1">Пароль:</label>
            <input type="password" id="password1" name="password1"><br>
            <label for="password2">Повторите пароль:</label>
            <input type="password" id="password2" name="password2"><br>
        </fieldset>
        <input type="submit" value="Создать" name="submit">
    </form>
<?php
require_once('footer.php');
?>
