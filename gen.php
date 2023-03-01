<?php
    if($levelindex > count(scandir("levels"))-3){
        header("Location: index.php");
    }

    $iscustom = false;
    if(isset($_POST['customname'])){
        $iscustom = true;
        $customname = $_POST['customname'];
    }else{
        $iscustom = false;
    }

    //is it devs official level or custom? load index based or name based:
    switch($iscustom){
        case true:
            $lvlfile = fopen("levels/my/".$customname.".txt", "r");
            break;
        case false:
            $lvlfile = fopen("levels/lv".$levelindex.".txt", "r");
            break;
    }
    
    //Rows and cols calculation:
    $levelrows =-1;//first row is node info
    //$levelcols =-1;

    while(!feof($lvlfile)){
        fgets($lvlfile);
        // $levelcols = strlen($line);
        $levelrows++;
    }

    // echo $levelrows;
    // echo $levelcols;
    // count the available nodes and load them:

    //array containing level info excluding grid (map name, author, available nodes with allowed conditions to use);
    rewind($lvlfile);
    $levelheader = fgets($lvlfile);
    $HL = explode(":", $levelheader);
    rewind($lvlfile);

    $headerlen = strlen(fgets($lvlfile));
    $headerlen-=2;
    rewind($lvlfile);
    //[0] Level Header section MapName.
    //[1] Level Header section Author.
    //[2] Level Header section A. Contains available movement nodes
    //[3] Level Header section B. Contains available complex instruction nodes (for loop, while loop, if, break, continue);
    //[4] Level Header section C. Contains available condition nodes (scanning surroundings for presence of stated tile in specific directions)
    //[5] Level Header section D. Contains available tiles with amount to be used as conditions in nodes.
    $HL_mapname = $HL[0];
    $HL_author = $HL[1];
    $HL_a = explode(".", $HL[2]);
    $HL_b = explode(".", $HL[3]);
    $HL_c = explode(".", $HL[4]);
    $HL_d = explode(".", $HL[5]);

    //convert values to numbers:
    for($i = 0; $i<4; $i++){
        $HL_a[$i] = (int)$HL_a[$i];
        //echo $HL_a[$i];
    }
    //echo "<br/>";
    for($i = 0; $i<5; $i++){
        $HL_b[$i] = (int)$HL_b[$i];
        //echo $HL_b[$i];
    }
    //echo "<br/>";
    for($i = 0; $i<6; $i++){
        $HL_c[$i] = (int)$HL_c[$i];
        //echo $HL_c[$i];
    }
    //echo "<br/>";
    for($i = 0; $i<count($HL_d); $i++){
        $HL_d[$i] = (int)$HL_d[$i];
        //echo $HL_d[$i];
    }

    //====================================
    // Levelgrid load:
    //====================================
    rewind($lvlfile);
    fgets($lvlfile);
    //count columns:
    $levelcols = count(explode(":", fgets($lvlfile)));

    //skip first row (the one with nodes):
    rewind($lvlfile);
    fgets($lvlfile);

    for($i = 0; $i < $levelrows; $i++){
        $temprow_load = trim(fgets($lvlfile));
        $temprow_arr = explode(":", $temprow_load);

        for($j = 0; $j < $levelcols; $j++){
            $levelgrid[$i][$j] = $temprow_arr[$j];
        }
    }
    //print_r($levelgrid);

    fclose($lvlfile);
    //==========================================================================================
    //cell width calculation:
    //level window ratio: 1.26 / 0.5676 = 2.2198731501057082452431289640592..
    //h = 100, w = 221.98731501057082452431289640592..
    //contents of the whiteboard to whiteboard itself proportions: h = 0.90(18), w = 0,932307...
    //ratio of whiteboard insides: 2,4435483870967741935483870967742...
    //padding top+bottom: 1 - 0.90(18) = 0,09(81)
    //padding left+right: 1 - 0,932307 = 0,066793...
    //==========================================================================================
    $windowratio = 2.4435483870967742;
    $gridratio = $levelcols / $levelrows;
    //1. fit the height, calculate width with ratio, correct scale
    if($gridratio > $windowratio){
        $gridw = 100;
        $gridh = 100 / $gridratio;
        $gridh = $gridh * $windowratio;
    }else{
    //2. basically the same but reverse - for horizontal levels
        $gridh = 100;
        $gridw = 100*$gridratio;
        $gridw = $gridw / $windowratio;
    }
    //Levelgrid draw:
    echo "<div id='MainMap' style='width: $gridw%; height: $gridh%;'>";
    for($i = 0; $i<$levelrows; $i++){
        echo "<div>";
        for($j = 0; $j<$levelcols; $j++){
            echo "<div ";
            //separate the tile type from it's variation type
            $temptile = explode(".", $levelgrid[$i][$j]);
            $temptile[0] = (int)$temptile[0];
            //dont convert variation to int - it revolves around values beetween 0-f (string)
            //insert tile type and variation into class, to be controled in css:
            if($temptile[0]==4){
                //portal comes without variant:
                echo "class='tile_".$temptile[0]."_0'";
            }else{
                echo "class='tile_".$temptile[0]."_".$temptile[1]."'";
            }
            //playerpos (put in spawn):
            if($temptile[0]==2){
                $pawnpos[0] = $j;
                $pawnpos[1] = $i;
            }
            echo "></div>";
        }
        echo "</div>";
    }
    echo "</div>";
    //pawnpos:
    // echo $pawnpos[0];
    // echo $pawnpos[1];
?>