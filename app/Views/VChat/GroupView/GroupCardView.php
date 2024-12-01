
<section class="groupContainer" onclick="handleGroupClick('<?=$group['id']?>')">

    <img src="<?=$group['image']?>" alt="group img">

    <div class="content">
        <div class="name">
            <?=$group['title']?>
        </div>
        <div class="description">
            <?=$group['description']?>
        </div>
    </div>
    
</section>