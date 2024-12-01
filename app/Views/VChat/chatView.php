<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?= base_url('/css/chatView.css')?>">
    <link rel="stylesheet" href="<?= base_url('/css/global.css')?>">
    <link rel="stylesheet" href="<?= base_url(relativePath: 'css/MembersOFGroupView.css')?>">

    <style>

        .chatView .left .main .greeting{

            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--white);

        }


    </style>



</head>

<body>

    <script src="<?= base_url('js/Global.js')?>"></script>

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
            
            <?= 
                view("Global/iconBtn", array(
                    "src" => base_url(relativePath: "icons/log-out.png"),
                    "onclick" => "window.location = '".base_url(relativePath: '/logout')."'",
                    "style" => $btnStyle,
                    "size" => "5dvh"
                ))
            ?>

        </aside>


        <?= view("VChat/GroupView/GroupView")?>


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
                            "title" => "hackers test",
                            "image" => base_url("img/0"),
                            "id"    => 10
                        ),
                        "user" =>  array(
                            "username"  => "hamada test",
                            "image"     => base_url("img/1")
                        )

                    )
                )?>

            </main>

            <aside class="aside" id="chatViewLeftAside">

                <?= view("VChat/MembersOFGroupView/MembersOFGroupView") ?>
                    
            </aside>

        </aside>


    </section>


    <script src="<?= base_url('js/RightMsgView.js')?>"></script>
    
    <script src="<?= base_url(relativePath: 'js/LeftMsgView.js')?>"></script>

    <script src="<?= base_url(relativePath: 'js/MsgInputView.js')?>"></script>

    <script src="<?= base_url(relativePath: 'js/GroupInfosView.js')?>"></script>

    <script  src="<?= base_url(relativePath: 'js/MembersOFGroupView.js')?>"></script>
    
    <script src="<?=base_url(relativePath: 'js/MemberOfGroup.js')?>"></script>

    <script src="<?=base_url(relativePath: 'js/JoinGroupView.js')?>"></script>

    <script>

    
    </script>
    

</body>
</html>