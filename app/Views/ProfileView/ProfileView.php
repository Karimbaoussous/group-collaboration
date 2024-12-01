<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?= base_url('/css/global.css')?>">

    <style>

        :root{
            --padding: 5dvh;
            --corder-padding: calc(var(--padding) *0.5);
        }

        body{

            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--black-240);

        }

        form{

            /* margin: var(--padding-h); */
            display: grid;
            grid-template-columns: 1fr 2fr;
 
        }


        .left{

            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(to right, #ee5a6f, #f29263);
            padding: var(--padding);
            border-radius: var(--corder-padding) 0 0 var(--corder-padding);
            color: var(--white);

        }

        .right{

            padding: var(--padding);
            border-radius: 0 var(--corder-padding) var(--corder-padding) 0;
            background-color: var(--white);
            color: var(--black);

        }

        .textarea{

            resize: none;
        }

        .row{

            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 3dvh;

        }

        .row .description{
            color: var(--black-150);
        }


        .links{

            display: flex;
            gap: var(--gap-w);

        }

    </style>

</head>

<body>

    <form action="/profile/update">

        <aside class="left">
            
            <?=  view("Global/UploadImage")?>
            <div>
                <h2>
                    <?= esc(data: $username )?>
                    <!-- <label for="username">
                        Your Name
                    </label> -->
                </h2>
                <!-- <input type="text" name="username"> -->
            </div>

            <div>
                <h2>
                    <?= isset($about)? esc(data: $about ): "Hi"?>
                    <!-- <label for="about">
                        About
                    </label> -->
                </h2>
                <!-- <textarea name="about" class="textarea"></textarea> -->
            </div>

            <div>

                <?= 
                    view("Global/IconBtn", 
                        array(
                            "onclick" => "window.location = '/profile/edit'",
                            "src" => base_url('/imgs/img.png'),
                            "style" => "",
                        )
                    )
                ?>

            </div>
        </aside>

        <aside class="right">

            <h2>Information</h2>
            <hr>

            <div class="row">

                <div>
                    <h2>Email</h2>
                    <div class="description">
                        <?= esc($email) ?>
                    </div>
                </div>

                <div>
                    <h2>Phone</h2>
                    <div class="description">
                        0606060606
                    </div>
                </div>

            </div>

            <h2>Projects</h2>
            <hr>
            
            <div class="row">

                <div>
                    <h2>Recent</h2>
                    <div class="description">
                        Sam Disuja
                    </div>
                </div>

                <div>
                    <h2>Most Viewed</h2>
                    <div class="description">
                        Dinoter husainm
                    </div>
                </div>

            </div>

            <div class="links">
                <?= 
                    view("Global/IconBtn", 
                        array(
                            "redirect" => "/profile/edit",
                            "src" => base_url('/imgs/img.png')
                        )
                    )
                ?>   
                <?= 
                    view("Global/IconBtn", 
                        array(
                            "redirect" => "/profile/edit",
                            "src" => base_url('/imgs/img.png')
                        )
                    )
                ?>  
                <?= 
                    view("Global/IconBtn", 
                        array(
                            "redirect" => "/profile/edit",
                            "src" => base_url('/imgs/img.png')
                        )
                    )
                ?>
            </div>


        </aside>

    </form>

</body>

