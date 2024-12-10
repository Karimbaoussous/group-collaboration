

<?php 

    if(!isset($group)){

        $group["title"] = "group name";
        $group["image"] = base_url("imgs/img.png");
        
    }

    // create elements to test
    $groupMembers = [];

    function testUsersXInDB(){

        $list = [];

        for($i=0; $i< 100; $i++){
            $list[] = array(
                "id" => $i,
                "image" => base_url("imgs/img.png"),
                "username" => "username $i",
                "about" => "about me $i"
            );
        }

        return $list;

    }

    // $groupMembers =  testMembersOfGroup();

    if(isset($members)){
        $groupMembers = array_merge($groupMembers,esc( $members));
    }


?>


<aside class="groupMembersView">

    <section class="groupInfos">
    
        <header class="header">

            <?= view("Global/IconBtn", 
                array(
                    "src" => base_url('icons/cancel_white.png'),
                    "onclick" => 'handleRemoveGroupMembersView()',
                    "style" => "background-color: var(--black-30);",
                    "size" => "2dvh"
                )
            )?>

            <div class="infos">
                Group Information's
            </div>

        </header>
       
        <main class="mainInfos" >
                            
            <div class="img">
                <img 
                    src="<?= esc(data: $group["image"]) ?>" 
                    alt="group image"
                >
            </div>

            <div class="title">
                <?= $group["title"] ?>
            </div>

            <div class="title" id="membersNumber">
                <?= sizeof( $groupMembers). " members"?>
            </div>
            

        </main>

    </section>


    <div>
        
        <?= view("Global/SearchInput", 
            array(
                "onclickSearchInput" => "handleGroupMembersSearch"
            )
        )?>
    
    </div>


    <section class="members" id="groupMembers">
                            
        <? 
            foreach($groupMembers as $member){
                
                echo view(
                    "VChat/MembersOfGroupView/MemberOfGroupView",
                    array(
                        "member"=> $member
                    )
                );

            }
        ?>

    </section>


</aside>

