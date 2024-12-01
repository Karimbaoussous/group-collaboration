
<div class="membersContainer"
    <?if( esc( data: $isAdmin ) ):?>
        onmouseenter="handleMemberMousedown(this)"
        onmouseleave="handleMemberMouseleave(this)"
    <?endif?>
>

    <div class="infos">
        <img 
            src="<?=esc(data: $member['image'])?esc($member['image']): "" ?>" 
            alt="member img"
        >

        <div class="content">
            <div class="name">
                <?=$member['username']?>
            </div>
            <div class="description">
                <?=esc($member['about'])? $member['about']: "Hi, i'm a new user."?>
            </div>
        </div>
    </div>

    <? if( esc( $member['isAdmin'] ) ):?>

        <div class="admin">Admin</div>
        
    <? elseif( esc( data: $isAdmin ) ):?>

        <input type="hidden" value="<?=$member['id']?>" />

    <?endif?>

</div>

