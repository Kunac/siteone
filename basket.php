<?include_once('header.php');?>
<?
function SetPrice()
{
	$price = 0;
	foreach ( $_SESSION['basket'] as $k=>$i )
	{
		$price += intval($i['PRICE']) * intval($i['NUM']);
	}
	return $price;
}


if ( isset($_GET['add']) && intval($_GET['add']) > 0 ) :
	
	if ( isset($_SESSION['basket'][$_GET['add']]['NUM']) ){
		$_SESSION['basket'][$_GET['add']]['NUM'] += 1;
	}else{
		$result = $conn->query("SELECT * FROM items WHERE ID=".$_GET['add']);
		while($row = $result->fetch_assoc()) {
			$item = $row;
		}
		
		$_SESSION['basket'][$_GET['add']] = array(
			'NAME' => $item['NAME'],
			'PRICE' => $item['PRICE'],
			'NUM' => 1
		);
	}
elseif(  isset($_GET['delete']) && isset($_SESSION['basket'][$_GET['delete']]['NUM']) ) :
	unset($_SESSION['basket'][$_GET['delete']]);
elseif(  isset($_GET['plus']) && isset($_SESSION['basket'][$_GET['plus']]['NUM']) ) :
	$_SESSION['basket'][$_GET['plus']]['NUM'] += 1;
elseif(  isset($_GET['minus']) && $_SESSION['basket'][$_GET['minus']]['NUM'] > 1 ) :
	$_SESSION['basket'][$_GET['minus']]['NUM'] -= 1;
endif;


?>
<div class="uk-padding">
    <h1 class="uk-heading-divider uk-text-center">Корзина</h1>
	<table class="uk-table uk-table-divider">
		<thead>
			<tr>
				<th>Название товара</th>
				<th>Количество</th>
				<th>Цена</th>
				<th>Удалить</th>
			</tr>
		</thead>
		<tbody>
			<? if ( count($_SESSION['basket']) > 0 ) : ?>
				<? foreach ( $_SESSION['basket'] as $k=>$i ) : ?>
				<tr>
					<td><?=$i['NAME']?></td>
					<td><a uk-icon="icon: minus-circle" href="?minus=<?=$k?>"></a> <?=$i['NUM']?> <a uk-icon="icon: plus-circle" href="?plus=<?=$k?>"></a></td>
					<td><?=$i['PRICE']?></td>
					<th><a href="?delete=<?=$k?>">X</a></th>
				</tr>
				<? endforeach; ?>
			<? else : ?>
				<tr>
					<td colspan="4">Нет товаров в корзине</td>
				</tr>
			<? endif; ?>
		</tbody>
	</table>
	<div class="uk-padding uk-child-width-1-3" uk-grid>
		<a class="uk-button uk-button-default" href="/index.php">На главную</a>
		<h3 class="uk-card-title">Цена: <?=SetPrice();?></h3>
		<a class="uk-button uk-button-primary uk-position-rigth" href="/order.php">Оформить заказ</a>
	</div>
</div>
<?include_once('footer.php');?>