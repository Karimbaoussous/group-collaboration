
<div class="membersContainer"
    <?if( esc( data: $isAdmin ) ):?>
        onmouseenter="handleAdminMousedown(this)"
        onmouseleave="handleAdminMouseleave(this)"
    <? elseif( $userID == $member['id'] ):  ?>
        onmouseenter="handleMemberMousedown(this)"
        onmouseleave="handleMemberMouseleave(this)"
    <?endif?>
>

    <div class="infos">
        
        <img 
            src="<?=esc(data: $member['image'])?esc($member['image']): "" ?>" 
            alt="member img"
        >

        <div class="content endText">
            <div class="name">
                <?= $userID == $member['id']? $member['username'] ." (YOU)": $member['username']?>
            </div>
            <div class="description endText">
                <?=esc($member['about'])? $member['about']: "Hi, i'm a new user."?>
            </div>
        </div>
    </div>

    <? if( esc( data: $member['isAdmin'] ) ):?>

        <div class="admin">Admin</div>
        
    <? elseif( esc( data: $isAdmin ) || $userID == $member['id'] ):?> <!-- admin mode -->

        <input type="hidden" value="<?=$member['id']?>" />

    <?endif?>

</div>

