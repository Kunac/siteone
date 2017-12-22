<?
include_once('header.php');
if ( isset($_GET['id']) ) :
    $result = $conn->query("SELECT * FROM items WHERE ID=".$_GET['id']);
    while($row = $result->fetch_assoc()) {
        $items = $row;
    }
else:
    die;
endif;

?>
    <div class="uk-padding">
        <h1 class="uk-heading-divider uk-text-center"><?=$items['NAME']?> <span class="uk-badge"><?=$items['PRICE']?>руб.</span></h1>
		
        <div class="uk-text-center" uk-grid>
            <div class="uk-width-2-4">
                <div class="uk-card uk-card-default uk-card-body">
                    <? if ($items['PICTURE'] != '') : ?>
                        <img src="<?=$items['PICTURE']?>">
                    <? endif; ?>
                </div>
            </div>
            <div class="uk-width-3-3">
				<div class="uk-card uk-card-primary uk-card-body" uk-grid>
					<div class="uk-width-1-2@s">
						<a class="uk-button uk-button-secondary" href="/basket.php?add=<?=$items['ID']?>">Добавить в корзину</a>
					</div>
				</div>
                <div class="uk-card uk-card-default uk-card-body">
                    <?=$items['TEXT']?>				
                </div>
				
            </div>
        </div>
        <div class="uk-padding" uk-grid>
            <a class="uk-button uk-button-default" href="/index.php">На главную</a>
        </div>
    </div>
<?include_once('footer.php');?>