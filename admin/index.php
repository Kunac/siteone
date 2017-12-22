<?include_once('header.php');?>
<?
$result = $conn->query("SELECT COUNT(*) AS NUM FROM items WHERE 1");
while($row = $result->fetch_assoc()) {
	$ITEMS_COUNT = $row['NUM'];
}
$result = $conn->query("SELECT COUNT(*) AS NUM FROM orders WHERE 1");
while($row = $result->fetch_assoc()) {
	$ORDER_COUNT_ALL = $row['NUM'];
}
$result = $conn->query("SELECT COUNT(*) AS NUM FROM orders WHERE DATE(`date`) = CURDATE()");
while($row = $result->fetch_assoc()) {
	$ORDER_COUNT_TODAY = $row['NUM'];
}
?>
<div class="uk-padding uk-child-width-1-2@m" uk-grid>
	<div>
		<div class="uk-card uk-card-default uk-card-body">
		    <a href="/admin/items.php">
			<h3 class="uk-card-title">Товары</h3>
			<p>Доступно <?=$ITEMS_COUNT?> товарa(ов) на сайте.</p></a>
		</div>
	</div>
	<div>
		<div class="uk-card uk-card-default uk-card-body">
		    <a href="/admin/orders.php">
			<h3 class="uk-card-title">Заказы</h3>
			<p>В системе находится <?=$ORDER_COUNT_ALL?> заказа(ов) из них <?=$ORDER_COUNT_TODAY?> создано сегодня.</p>
		</a>
		</div>
	</div>
</div>
<?include_once('footer.php');?>