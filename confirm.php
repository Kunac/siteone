<?include_once('header.php');?>
<?

function SetPrice()
{
	$price = 0;
	foreach ( $_POST['item'] as $k=>$i )
	{
		$price += intval($i['price']) * intval($i['num']);
	}
	return $price;
}

if ( count($_POST['item']) == 0 )
	die;

unset($_SESSION['basket']);

$result = $conn->query("INSERT INTO `orders`(`price`, `date`, `name`, `phone`, `status`, `delivery`, `payment`, `extra`) 
						VALUES (".SetPrice().",NOW(),'".$_POST['name']."','".$_POST['phone']."',0,'".$_POST['delivery']."','".$_POST['payment']."','".$_POST['extra']."')");
$ORDER_ID = $conn->insert_id;

foreach ( $_POST['item'] as $k=>$i ) :
	$result = $conn->query("INSERT INTO `order_items`(`order_id`, `item_id`, `quantity`) 
							VALUES (".$ORDER_ID.",".$k.",".$i['num'].")");

endforeach; 
?>

<div class="uk-padding">
    <h1 class="uk-heading-divider uk-text-center">Заказ №<?=$ORDER_ID?> оформлен</h1>
	<div class="uk-padding" uk-grid>
		<a class="uk-button uk-button-default" href="/index.php">На главную</a>
	</div>
</a>
<?include_once('footer.php');?>