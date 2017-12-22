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
?>
<div class="uk-padding">
    <h1 class="uk-heading-divider uk-text-center">Оформление заказа</h1>
	<table class="uk-table uk-table-divider">
		<thead>
			<tr>
				<th>Название товара</th>
				<th>Количество</th>
				<th>Цена</th>
			</tr>
		</thead>
		<tbody>
			<? if ( count($_SESSION['basket']) > 0 ) : ?>
				<? foreach ( $_SESSION['basket'] as $k=>$i ) : ?>
				<tr>
					<td><?=$i['NAME']?></td>
					<td><?=$i['NUM']?></td>
					<td><?=$i['PRICE']?></td>
				</tr>
				<? endforeach; ?>
			<? else : ?>
				<tr>
					<td colspan="4">Нет товаров для заказа</td>
				</tr>
			<? endif; ?>
		</tbody>
	</table>
	<form class="uk-form-stacked" action="confirm.php" method="POST">
		<? foreach ( $_SESSION['basket'] as $k=>$i ) : ?>
			<input type="hidden" name="item[<?=$k?>][num]" value="<?=$i['NUM']?>">
			<input type="hidden" name="item[<?=$k?>][price]" value="<?=$i['PRICE']?>">
		<? endforeach; ?>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-stacked-name">Ваше имя</label>
			<div class="uk-form-controls">
				<input required name="name" class="uk-input" id="form-stacked-name" type="text" placeholder="Введите ваше имя">
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-stacked-phone">Ваш телефон</label>
			<div class="uk-form-controls">
				<input required name="phone" class="uk-input" id="form-stacked-phone" type="text" placeholder="Введите ваш телефон">
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-stacked-payment">Оплата</label>
			<div class="uk-form-controls">
				<select name="payment" class="uk-select" id="form-stacked-payment">
					<option value="cash">Наличными при получении</option>
					<option value="card">Банковской картой при получении</option>
				</select>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-stacked-delivery">Доставка</label>
			<div class="uk-form-controls">
				<select name="delivery" class="uk-select" id="form-stacked-delivery">
					<option value="pickup">Самовывоз</option>
					<option value="curier">Курьером</option>
				</select>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-stacked-extra">Примечания</label>
			<div class="uk-form-controls">
				<textarea name="extra" class="uk-textarea" id="form-stacked-extra" rows="2" placeholder="Введите ваши пожелания и адрес доставки"></textarea>
			</div>
		</div>

		<div class="uk-padding uk-child-width-1-3" uk-grid>
			<a class="uk-button uk-button-default" href="/basket.php">В корзину</a>
			<h3 class="uk-card-title">Цена: <?=SetPrice();?></h3>
			<input type="submit" class="uk-button uk-button-primary uk-position-rigth"	value="Подтвердить">
		</div>
	</form>
</div>
<?include_once('footer.php');?>