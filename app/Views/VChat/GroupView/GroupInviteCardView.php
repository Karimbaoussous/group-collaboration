

<?
    $btnStyle = "
        background-color: var(--white);
        padding: var(--padding-h);
        border-radius: 10%;
    ";

?>

<section class="InviteContainer" >

    <div class="infos endText">
        <img src="<?=$group['image']?>" alt="group invite img">

        <div class="content endText">
            <div class="name endText" title="<?=$group['title']?>"> <!-- it show full text on hover in case of t... -->
                <?=$group['title']?>
            </div>
            <div class="description endText" title="<?=$group['description']?>">
                <?=$group['description']?>
            </div>
        </div>
    </div>

    <div class="btns">
        <?= 
            view("Global/iconBtn", array(
                "src" => base_url(relativePath: "icons/mark.png"),
                "onclick" => "handleAcceptGroupInvite(".$group['id'].", this)",
                "style" => $btnStyle,
                "size" => "2dvh"
            ))
        ?>
        <?= 
            view("Global/iconBtn", array(
                "src" => base_url(relativePath: "icons/cancel.png"),
                "onclick" => "handleRefuseGroupInvite(".$group['id'].", this)",
                "style" => $btnStyle,
                "size" => "2dvh"
            ))
        ?>
      
    </div>
    
</section>