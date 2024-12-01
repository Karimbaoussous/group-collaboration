
<style>

    .searchInput{

        display: flex;

        background-color: var(--black-30);

        padding: var(--padding-h);
        gap: var(--gap-w);

    }

    .searchInput .search{

        width: 100%;
        
    }



</style>


<div class="searchInput">


    <?
  
        $jsFunction = esc($onclickSearchInput)? $onclickSearchInput . "(input.value)": '';

        $jsCode = "
            (
                (btn)=>{
                    const container = btn.parentElement;
                    if(container.tagName == 'IMG'){
                        container = container.parentElement;
                    }

                    let input = container.children[2];
                    
                    $jsFunction
                }

            )(this)
        ";

    ?>


    <?=  view(
        "Global/IconBtn",
        array(
                "src"       => base_url('icons/search.png'),
                "onclick"   =>  $jsCode,
                "style"     => "background-color: var(--white); padding: var(--padding-h); border-radius: 10%;",
                "size"      => '2dvh',
            )
    ) ?>
  
    <input type="text" name="search" class="search">

</div>


