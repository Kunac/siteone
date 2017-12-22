<?php 
session_start();
$servername = "localhost";
$username = "hellorhw_site";
$password = "AtG5yn9%";
$dbname = "hellorhw_site";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?
if ( isset($_POST['password']) && $_POST['password'] == "admin228" ) :
	$_SESSION['admin_panel'] = 'Y';
elseif ( isset($_POST['password']) ) :
	$ERROR = 'Y';
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Администраторская панель</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.35/js/uikit-icons.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=PT+Sans&amp;subset=cyrillic,latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Caption&amp;subset=cyrillic,latin-ext" rel="stylesheet">
    </head>
<body>
<?
	if ( $_SESSION['admin_panel'] != 'Y' ) :?>
		<?if ( $ERROR == 'Y' ) :?> 
			<script>
				UIkit.notification({message: 'Пароль не правильный!', status: 'danger'});
			</script>
		<? endif; ?>
		<form method="POST" action="">
			<div class="uk-padding">
				<div class="uk-card uk-card-primary uk-card-body uk-position-center uk-width-1-2@m">
					<h3 class="uk-card-title">Введите пароль для входа в административную панель</h3>
					<div class="uk-margin uk-child-width-1-2" uk-grid>						
						<div class="uk-inline">
							<span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
							<input class="uk-input" name="password" type="password" placeholder="Введите пароль">
						</div>
						<input type="submit" class="uk-button uk-button-primary uk-position-rigth" value="Войти">
					</div>
				</div>
			</div>
		</form>
		<?
		die;
	endif;
?>
<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">

        <ul class="uk-navbar-nav">
            <li><a href="/admin/">Главная страница</a></li>
            <li>
                <a href="/admin/items.php">Товары</a>
                <div class="uk-navbar-dropdown">
                    <ul class="uk-nav uk-navbar-dropdown-nav">
                        <li><a href="/admin/items.php">Просмотреть все</a></li>
                        <li><a href="/admin/items.php?view=add">Добавить новый</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="/admin/orders.php">Заказы</a></li>
			<li><a href="/">На сайт</a></li>
        </ul>

    </div>
</nav>