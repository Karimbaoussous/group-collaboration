


<?php 
    // create elements to test
    $grps = [];


    function testGroups(){

        $groupLocal = [];
        
        for($i=0; $i< 10;$i++){
            $groupLocal[$i] = array(
                "id" => $i,
                "image" => base_url("imgs/img.png"),
                "title" => "group $i",
                "description" => " description $i"
            );
        }

        return $groupLocal;
    }

    // $grps = testGroups();


    if(isset($groups)){
        $grps = array_merge($grps, $groups);
    }



?>


<aside class="groupsView">


    <?= view("Global/SearchInput", 
        array(
            "onclickSearchInput" => "handleSearchGroupsViewClick"
        )
    )?>

    <div class="title" id="groupsNumber">
        <?= sizeof( value: $grps). " groups"?>
    </div>


    <section class="groups" id="groupsView">

        <? 
            foreach($grps as $group){

                echo view(
                    "VChat/GroupView/GroupCardView", 
                    array(
                        "group" => $group
                    )
                );
                
            }

            if(isset($invitations)){

                foreach($invitations as $group){

                    echo view(
                        "VChat/GroupView/GroupInviteCardView", 
                        array(
                            "group" => $group
                        )
                    );
                    
                }

            }

        ?>

    </section>
  

</aside>

