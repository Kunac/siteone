<?
include_once('header.php');
$result = $conn->query("SELECT * FROM items");
$items = array();
while($row = $result->fetch_assoc()) {
    $items[] = $row;
}
?>

    <div class="uk-padding">
        <h1 class="uk-heading-divider uk-text-center" >Микроконтроллеры</h1>
        <div class="uk-child-width-1-3@m uk-grid-small uk-grid-match" uk-grid>
            <? foreach ($items as $item) : ?> 
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    <a href="item.php?id=<?=$item['ID']?>">
                        <h3 class="uk-card-title"><?=$item['NAME']?></h3>
                    </a>
                    <p><?=$item['TEXT']?></p>
                </div>
            </div>
            <? endforeach; ?>
        </div>
    </div>
<?include_once('footer.php');?>