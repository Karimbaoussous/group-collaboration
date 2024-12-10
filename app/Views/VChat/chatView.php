<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
    <link rel="stylesheet" href="<?= base_url('/css/chatView.css')?>">
    <link rel="stylesheet" href="<?= base_url('/css/global.css')?>">
    <link rel="stylesheet" href="<?= base_url(relativePath: 'css/MembersOFGroupView.css')?>">
    <link rel="stylesheet" href="<?= base_url(relativePath: 'css/groupView.css')?>">
    <link rel="stylesheet" href="<?= base_url(relativePath: 'css/NothingView.css')?>">
 
    <link rel="stylesheet" href="<?= base_url(relativePath: 'css/JoinChatView.css')?>">

    <link rel="stylesheet" href="<?= base_url(relativePath: 'css/IconBtnComponent.css')?>">
    <link rel="stylesheet" href="<?= base_url(relativePath: 'css/GroupInfosView.css')?>">
    
    <style>

        .chatView .left .main .greeting{

            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--white);

        }

        .groupsView{

       
            display: flex;
            flex-direction: column;
            gap: 1dvh;

            background-color: var(--black-10); 
            /* padding: var(--padding-h) 0 var(--padding-h) 0 ; */

            overflow: hidden;


        }


    </style>



</head>

<body>

    <script>

        const globalUsername = "<?= esc( data: $user['username']) ?>";

    </script>

    <script src="<?= base_url('js/Global.js')?>"></script>

    <script src="<?= base_url("js/UploadImage.js")?>"></script>
    

    <script src="<?= base_url(relativePath: 'js/ChatView.js')?>"></script>

    <script src="<?= base_url(relativePath: 'js/GroupView.js')?>"></script>

    <script src="<?= base_url(relativePath: 'js/GlobalMsgView.js')?>" ></script>
    
    <script src="<?= base_url(relativePath: 'js/IconBtn.js')?>" ></script>

    <script src="<?= base_url('js/RightMsgView.js')?>"></script>
    
    <script src="<?= base_url(relativePath: 'js/LeftMsgView.js')?>"></script>

    <script src="<?= base_url(relativePath: 'js/MsgInputView.js')?>"></script>

    <script src="<?= base_url(relativePath: 'js/GroupInfosView.js')?>"></script>

    <script  src="<?= base_url(relativePath: 'js/MembersOFGroupView.js')?>"></script>
    
    <script src="<?=base_url(relativePath: 'js/MemberOfGroup.js')?>"></script>

    <script src="<?=base_url(relativePath: 'js/JoinGroupView.js')?>"></script>



    <section class="chatView">

        <aside class="right">

            <? $btnStyle = "background-color:white; border-radius: 1dvh; padding: 1dvh;" ?>

            <?= 
                view("Global/iconBtn", array(
                    "src" => base_url(relativePath: "icons/user.png"),
                    "onclick" => "window.location = '".base_url(relativePath: '/profile')."'",
                    "style" =>  $btnStyle,
                    "size" => "5dvh"
                ))
            ?>

            <div style="display: grid; gap: var(--gap-w);">

                <?= 
                    view("Global/iconBtn", array(
                        "src" => base_url(relativePath: "icons/people.png"),
                        "onclick" => "window.location = '".base_url(relativePath: '/grpManage')."'",
                        "style" => $btnStyle,
                        "size" => "5dvh"
                    ))
                ?>

                <?= 
                    view("Global/iconBtn", array(
                        "src" => base_url(relativePath: "icons/join_group.png"),
                        "onclick" => "window.location = '".base_url(relativePath: '/panel')."'",
                        "style" => $btnStyle,
                        "size" => "5dvh"
                    ))
                ?>

            </div>
            
            <?= 
                view("Global/iconBtn", array(
                    "src" => base_url(relativePath: "icons/log-out.png"),
                    "onclick" => "window.location = '".base_url(relativePath: '/logout')."'",
                    "style" => $btnStyle,
                    "size" => "5dvh"
                ))
            ?>

        </aside>


        <aside id="groupsAside" >

            <?= view("VChat/GroupView/GroupView")?>


        </aside>
     

        <aside class="left"  id="chatViewLeft">

            <main class="main" id="chatViewLeftMain">

                <div class="greeting">
                    what's up  <?= esc( data: $user['username']) ?> , let's chat
                </div>

                <? view(
                    "VChat/GroupInfosView/GroupInfosView",
                    array("test" => true)
                )?>

                <? view(
                    "VChat/ChatAreaView/ChatAreaView",
                    array("test" => false)
                )?>

                <? view("VChat/MsgInputView/MsgInputView")?>

                <? view("VChat/JoinChatView/JoinChatView",
                    array(
                                            
                        "group" => array(
                            "title" => '$invitations[0]["title"]',
                            "image" => '$invitations[0]["image"]',
                            "id"    => '$invitations[0]["grp"]'
                        ),
                        "user" =>  array(
                            "username"  => '$invitations[0]["username"]',
                            "image"     => '$invitations[0]["photo"]'
                        )

                    )
                )?>

            </main>

            <aside class="aside" id="chatViewLeftAside">

                <? 
                    // view("VChat/MembersOFGroupView/MembersOFGroupView") 
                ?>
                    
            </aside>

        </aside>


    </section>


    
   


  

</body>
</html>