<?include_once('header.php');?>
<div class="uk-padding">
<?
$VIEW = '';
$NOTIFICATION = '';
if ( isset($_POST['type']) &&  $_POST['type'] == 'edit' ) :
	$picture = '';
	if ( count($_FILES["image"]) > 0 ) :
		if ( $_FILES['error'] == 0 && $_FILES["image"]["tmp_name"] != '' ) :
			$tmp_name = $_FILES["image"]["tmp_name"];			
			$name = $_SERVER['DOCUMENT_ROOT'].'/upload/'.basename($_FILES["image"]["name"]);
			$picture = ", PICTURE = '/upload/".basename($_FILES["image"]["name"])."'";
			$upload_result = move_uploaded_file($tmp_name, $name);
		endif;
	endif;		
	if ( isset($_GET['id']) && intval($_GET['id']) >= 0) :
		$result = $conn->query("UPDATE `items` SET `NAME`='".strip_tags($_POST['name'])."',
			`PRICE`='".strip_tags($_POST['price'])."',`TEXT`='".strip_tags($_POST['desc'])."' ".$picture." WHERE ID=".intval($_GET['id']) );
	endif;
	$NOTIFICATION = 'SAVE';

endif;
if ( isset($_POST['type']) &&  $_POST['type'] == 'new' ) :
	$name_image = '';
	if ( count($_FILES["image"]) > 0 ) :
		if ( $_FILES['error'] == 0 ) :
			$tmp_name = $_FILES["image"]["tmp_name"];			
			$name = $_SERVER['DOCUMENT_ROOT'].'/upload/'.basename($_FILES["image"]["name"]);
			$name_image = '/upload/'.basename($_FILES["image"]["name"]);
			$upload_result = move_uploaded_file($tmp_name, $name);
		endif;
	endif;			 
	$result = $conn->query("INSERT INTO `items`(`NAME`, `PRICE`, `TEXT`, `PICTURE`) 
		VALUES ('".strip_tags($_POST['name'])."','".intval($_POST['price'])."','".strip_tags($_POST['desc'])."','".$name_image."')");	
	$NOTIFICATION = 'NEW';
endif;

if ( isset($_GET['delete']) && intval($_GET['delete']) >= 0 ) :
	$result = $conn->query("DELETE FROM `items` WHERE ID = ".intval($_GET['delete']));
	$NOTIFICATION = 'DELETE';
endif;

switch( $_GET['view'] ){
	case 'add':
		$VIEW = 'ADD';
		break;
	case 'edit':
		$VIEW = 'EDIT';
		if ( isset($_GET['id']) && intval($_GET['id']) >= 0) :
			$result = $conn->query("SELECT * FROM items WHERE ID=".$_GET['id']);
			while($row = $result->fetch_assoc()) {
				$ITEM = $row;
			}
		endif;
		break;
	default:
		$result = $conn->query("SELECT * FROM items");
		$LIST = array();
		while($row = $result->fetch_assoc()) {
			$LIST[] = $row;
		}
		$VIEW = 'LIST';
		break;
}
?>
<? if ($NOTIFICATION == 'NEW' ) : ?>
	<script>
		UIkit.notification({message: 'Создан новый товар!', status: 'default'});
	</script>
<? elseif ($NOTIFICATION == 'DELETE' ): ?>
	<script>
		UIkit.notification({message: 'Товар удалён!', status: 'default'});
	</script>
<? elseif ($NOTIFICATION == 'SAVE' ): ?>
	<script>
		UIkit.notification({message: 'Сохранено!', status: 'default'});
	</script>
<? endif; ?>
<? if ( $VIEW == 'LIST' ) : ?>
	<h1 class="uk-heading-divider uk-text-center">Список всех товаров</h1>
	<table class="uk-table uk-table-divider">
		<thead>
			<tr>
				<th>ID</th>
				<th>Название товара</th>				
				<th>Цена</th>
				<th>Редактировать</th>
				<th>Удалить</th>
			</tr>
		</thead>
		<tbody>
			<? if ( count($LIST) > 0 ) : ?>
				<? foreach ( $LIST as $k=>$i ) : ?>
				<tr>
					<td><?=$i['ID']?></td>
					<td><?=$i['NAME']?></td>
					<td><?=$i['PRICE']?></td>
					<th><a uk-icon="icon: cog" href="?view=edit&id=<?=$i['ID']?>"></a></th>
					<th><a uk-icon="icon: trash" href="?delete=<?=$i['ID']?>"></a></th>
				</tr>
				<? endforeach; ?>
			<? else : ?>
				<tr>
					<td colspan="4">Нет товаров</td>
				</tr>
			<? endif; ?>
		</tbody>
	</table>
	<div class="uk-padding" uk-grid>
		<a class="uk-button uk-button-default" href="?view=add">Добавить новый товар</a>
	</div>
<? elseif ( $VIEW == 'EDIT' && count($ITEM) > 0 ) : ?>
	<h1 class="uk-heading-divider uk-text-center">Редактирование "<?=$ITEM['NAME']?>"</h1>
	<form enctype="multipart/form-data" class="uk-form-horizontal" action="?view=edit&id=<?=$ITEM['ID']?>" method="POST">
		<input type="hidden" name="type" value="edit">
		<div class="uk-margin">
			<label class="uk-form-label" for="form-horizontal-name">Название товара</label>
			<div class="uk-form-controls">
				<input required name="name" value="<?=$ITEM['NAME']?>" class="uk-input" id="form-horizontal-name" type="text" placeholder="Введите название нового товара">
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-horizontal-price">Цена товара</label>
			<div class="uk-form-controls">
				<input name="price" value="<?=$ITEM['PRICE']?>" class="uk-input" id="form-horizontal-price" type="text" placeholder="Введите цену нового товара">
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-horizontal-desc">Описание товара</label>
			<div class="uk-form-controls">
				<textarea name="desc" class="uk-textarea" id="form-stacked-desc" rows="5" placeholder="Введите описание товара"><?=$ITEM['TEXT']?></textarea>
			</div>
		</div>		
		<div class="uk-margin">
			<label class="uk-form-label" for="form-horizontal-image">Картинка товара</label>
			
			<div class="uk-form-controls">
				<? if ( $ITEM['PICTURE'] != '' ) : ?>
				<img src="<?=$ITEM['PICTURE']?>" width="100">
				<? endif; ?>
				<input name="image" class="uk-input" id="form-horizontal-image" type="file" accept="image/*">
			</div>
		</div>
		<div class="uk-padding uk-child-width-1-3" uk-grid>
			<a class="uk-button uk-button-default" href="items.php">Отменить</a>
			<h3 class="uk-card-title"></h3>
			<input type="submit" class="uk-button uk-button-primary uk-position-rigth"	value="Сохранить">
		</div>
	</form>
<? elseif ( $VIEW == 'ADD' ) : ?>
	<h1 class="uk-heading-divider uk-text-center">Создание нового товара</h1>
	<form enctype="multipart/form-data" class="uk-form-horizontal" action="items.php" method="POST">
		<input type="hidden" name="type" value="new">
		<div class="uk-margin">
			<label class="uk-form-label" for="form-horizontal-name">Название товара</label>
			<div class="uk-form-controls">
				<input required name="name" class="uk-input" id="form-horizontal-name" type="text" placeholder="Введите название нового товара">
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-horizontal-price">Цена товара</label>
			<div class="uk-form-controls">
				<input name="price"  class="uk-input" id="form-horizontal-price" type="text" placeholder="Введите цену нового товара">
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-horizontal-desc">Описание товара</label>
			<div class="uk-form-controls">
				<textarea name="desc" class="uk-textarea" id="form-stacked-desc" rows="2" placeholder="Введите описание товара"></textarea>
			</div>
		</div>
		<div class="uk-margin">
			<label class="uk-form-label" for="form-horizontal-image">Картинка товара</label>
			<div class="uk-form-controls">
				<input name="image" class="uk-input" id="form-horizontal-image" type="file" accept="image/*">
			</div>
		</div>
		<div class="uk-padding uk-child-width-1-3" uk-grid>
			<a class="uk-button uk-button-default" href="items.php">Отменить</a>
			<h3 class="uk-card-title"></h3>
			<input type="submit" class="uk-button uk-button-primary uk-position-rigth"	value="Создать">
		</div>
	</form>
<? endif; ?>
</div>
<?include_once('footer.php');?>