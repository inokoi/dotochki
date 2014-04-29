<html>
    <head>
        <link type="text/css" rel="stylesheet" href="<?=base_url();?>css/style.css" />
    </head>
    <body>
        <div class="menu">
        <?foreach($menu as $menu_item){?>
        <a href="<?=base_url();?>page/show/<?=$menu_item;?>"> Сраничка №<?=$menu_item;?></a>
        <?}?>
        </div>
    
        <center>
        <?=$content;?>
        </center>
    </body>
</html>