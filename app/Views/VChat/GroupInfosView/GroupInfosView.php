

<? 

    if(isset($test)){

        $group = array(
            "id" => "1",
            "image" => base_url('imgs/img.png'),
            "title" => "name of group",
            "description" => "description of group",
        );

    }


?>


<header class="groupInfosView" onclick="handleGroupInfosClick('<?=$group['id']?>')">

    <img src="<?=$group['image']?>" alt="group img">

    <div class="content">
        <div class="name endText">
            <?=$group['title']?>
        </div>
        <div class="description endText">
            <?=$group['description']?>
        </div>
    </div>

</header>


