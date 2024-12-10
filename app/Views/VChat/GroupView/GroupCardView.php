
<section class="groupContainer" onclick="handleGroupClick('<?=$group['id']?>')">

    <img src="<?=$group['image']?>" alt="group img">

    <div class="content">
        <div class="name endText">
            <?=$group['title']?>
        </div>
        <div class="description endText">
            <?=$group['description']?>
        </div>
    </div>
    
</section>