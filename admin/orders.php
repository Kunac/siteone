<?include_once('header.php');?>
<?
if ( isset($_POST['status']) ) :
	$result = $conn->query("UPDATE `orders` SET `status`=".$_POST['status']." WHERE id=".$_POST['id']);
endif;

function checkStatus($status)
{
	switch($status){
		case 0:
			return "Создан, ожидает подтверждения";
			break;
		case 1:
			return "Принят, обрабатывается";
			break;
		case 2:
			return "Отправлен курьером";
			break;
		case 3:
			return "В пункте выдаче";
			break;
		case 4:
			return "Получен клиентом, закрыт";
			break;
		default:
			return "Статус неизвестен";
			break;
	}

}
function Status($status)
{
	switch($status){
		case 'pickup':
			return "Самовывоз";
			break;
		case 'curier':
			return "Курьером";
			break;
		case 'cash':
			return "Наличными при получении";
			break;
		case 'card':
			return "Банковской картой при получении";
			break;
		default:
			return "Нет информации";
			break;
	}
}
switch( $_GET['view'] ){
	case 'edit':
		$VIEW = 'EDIT';
		if ( isset($_GET['id']) && intval($_GET['id']) >= 0) :
			$result = $conn->query("SELECT * FROM orders WHERE id=".$_GET['id']);
			while($row = $result->fetch_assoc()) {
				$ITEM = $row;
			}
			$result = $conn->query("SELECT ord.quantity AS COUNT, i.NAME, i.PRICE FROM order_items ord LEFT JOIN items i ON i.ID = ord.item_id WHERE ord.order_id = ".$_GET['id']);
			while($row = $result->fetch_assoc()) {
				$ITEM['ITEMS'][] = $row;
			}
			
			
			
			
		endif;
		break;
	default:
		$result = $conn->query("SELECT * FROM orders");
		$LIST = array();
		while($row = $result->fetch_assoc()) {
			$LIST[] = $row;
		}
		$VIEW = 'LIST';
		break;
}
?>
<div class="uk-padding">
<? if ( $VIEW == 'LIST' ) : ?>
	<h1 class="uk-heading-divider uk-text-center">Список всех заказов</h1>
	<table class="uk-table uk-table-divider">
		<thead>
			<tr>
				<th>ID</th>
				<th>Имя покупателя</th>
				<th>Телефон</th>					
				<th>На сумму</th>
				<th>Статус</th>
				<th>Просмотреть</th>
			</tr>
		</thead>
		<tbody>
			<? if ( count($LIST) > 0 ) : ?>
				<? foreach ( $LIST as $k=>$i ) : ?>
				<tr>
					<td><?=$i['id']?></td>
					<td><?=$i['name']?></td>
					<td><?=$i['phone']?></td>
					<td><?=$i['price']?></td>
					<th><?=checkStatus($i['status'])?></th>
					<th><a uk-icon="icon: cog" href="?view=edit&id=<?=$i['id']?>"></a></th>					
				</tr>
				<? endforeach; ?>
			<? else : ?>
				<tr>
					<td colspan="4">Нет заказов</td>
				</tr>
			<? endif; ?>
		</tbody>
	</table>
<? elseif ( $VIEW == 'EDIT' && count($ITEM) > 0 ) : ?>
	<form method="POST" action="">
		<input type="hidden" name="id" value="<?=$ITEM['id']?>">
		<h1 class="uk-heading-divider uk-text-center">Заказ №<?=$ITEM['id']?></h1>
		<table class="uk-table uk-table-divider">
			<thead>
				<tr>
					<th>Имя покупателя</th>
					<th>Телефон</th>					
					<th>На сумму</th>
					<th>Статус</th>
					<th>Доставка</th>
					<th>Оплата</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?=$ITEM['name']?></td>
					<td><?=$ITEM['phone']?></td>
					<td><?=$ITEM['price']?></td>
					<th> 
						<select name="status" class="uk-select">
						<? for ( $i = intval($ITEM['status']); $i <= 4; $i++  ) { ?>					
							<option value="<?=$i?>"><?=checkStatus($i)?></option>
						<? } ?>
						</select>
					</th>
					<th><?=Status($ITEM['delivery'])?></th>	
					<th><?=Status($ITEM['payment'])?></th>
				</tr>
			</tbody>
		</table>
		<div>
			<div>
				<div class="uk-card uk-card-default uk-card-body">
					<h3 class="uk-card-title">Комментарий пользователя</h3>
					<p><?=$ITEM['extra']?></p>
				</div>
			</div>
			<div>
				<h1 class="uk-heading-divider">Список товаров</h1>
				<table class="uk-table uk-table-divider">
					<thead>
						<tr>
							<th>Название товара</th>
							<th>Количество</th>					
							<th>Цена за единицу</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($ITEM['ITEMS'] as $k=>$i) : ?>
							<tr>
								<td><?=$i['NAME']?></td>
								<td><?=$i['COUNT']?></td>
								<td><?=$i['PRICE']?></td>
							</tr>
						<? endforeach; ?>
					</tbody>
				</table>	
			</div>
		</div>
		<div class="uk-padding uk-child-width-1-3" uk-grid>
			<a class="uk-button uk-button-default" href="orders.php">К списку заказов</a>
			<h3 class="uk-card-title"></h3>
			<input type="submit" class="uk-button uk-button-primary uk-position-rigth"	value="Сохранить">
		</div>
	</form>
<? endif; ?>
</div>
<?include_once('footer.php');?>