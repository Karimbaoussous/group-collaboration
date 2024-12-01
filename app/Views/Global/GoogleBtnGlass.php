
<head>

    <style>

        .google-glass-btn{
            text-decoration: none;
        }
        
        .google-glass-btn div{

            background: red;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255,255,255,0.27);
            color: #eaf0fb;
            text-align: center;

        }

        .google-glass-btn div:hover{
            background-color: rgba(255,255,255,0.47);
        }


    </style>

</head>


<a href="<?= base_url( esc($href))?>" class="google-glass-btn">
    <div class="go">
        <?if(isset($src)):?>
            <img src="<?esc($src)?>" alt="icon"> 
        <?else:?>
            <i class="fab fa-google"></i> 
        <?endif?>
        <?= esc($tittle); ?>
    </div>
</a>