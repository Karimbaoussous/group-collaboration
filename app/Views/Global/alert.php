
<? if(isset($redirect)): ?>

    <link rel="stylesheet" href="<?php echo base_url('css/global.css'); ?>">

    <style>

        body{
            color: var(--white);
            background: var(--black);
        }

        
        .main{

            position: absolute;
            bottom: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);

            display: flex;
            flex-direction: column;
            gap: var(--gap-w);

            padding: var(--padding-w);
            user-select: none;

            /* background-color: var(--red); */
            border: 1px var(--blue) solid;
            border-radius:  var(--padding-w);

        }

        .main div::first-letter{
            text-transform: capitalize;
        }

        button{

            padding: var(--padding-w);
            border-radius:  var(--padding-w);
            background-color: var(--blue);
            color: var(--white);
            border: 0;
            text-transform: capitalize;
            cursor: pointer;

        }

    </style>

    <div class="main">
        <div>
            <? echo $msg; ?>
        </div>

        <button onclick="window.location = '<? echo base_url($redirect); ?>'">
            ok
        </button>

    </div>


<? else: ?>

    <script>
        alert('<? echo $msg; ?>')
    </script>

<? endif ?>

