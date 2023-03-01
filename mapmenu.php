<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel-Perfect</title>
    <link rel="icon" href="textures\logo.png"/>
    <link rel="stylesheet" href="style-mapmenu.css">
    <link rel="stylesheet" href="font.css">
</head>
<body>
    <div id="map-menu">
        <a href="index.php" id="return-a">&#8634;</a>
        <svg viewBox="0 0 125 20">
            <text x="12" y = "12" fill="#444" >Level menu</text>
        </svg>
        <?php
            //which iteration of this page is it?
            if(isset($_GET['mapmenusub'])){
                $mapmenusub = $_GET['mapmenusub'];
            }else{
                $mapmenusub = 1;
            }
            //check how many levels are in dir:
            $levelcount = count(scandir("levels"))-3;
            //recent level unlocked:
            $savefile = fopen("save/save.txt", "r");
            $save = fgets($savefile);
            fclose($savefile);
            //all level status:
            $savemainfile = fopen("save/savemain.txt", "r");
            $savemain = fgets($savemainfile);
            fclose($savemainfile);
            $savearr = explode(":", $savemain);

            //generate level icons:
            for($j = 1; $j<=3; $j++){
                echo "<div>";
                for($i=1+($j-1)*8+($mapmenusub-1)*24; $i<=8*$j+($mapmenusub-1)*24; $i++){
                    $iscompleted = "";
                    if($i > $levelcount){
                        $iscompleted = "empty";
                    }else{
                        if(isset($savearr[$i-1])){
                            if($savearr[$i-1]==1){
                                $iscompleted = "complete";
                            }else{
                                $iscompleted = "incomplete";
                            }
                        }else{
                            $iscompleted = "incomplete";
                        }
                    }

                    $temp_addr = "href='game.php?levelindex=${i}'";
                    echo "<a ";
                    if($iscompleted != "empty"){
                        echo $temp_addr;
                    }
                    echo " class=".$iscompleted.">";
                    if($iscompleted != "empty"){
                        echo $i;
                    }
                    echo "</a>";
                }
                echo "</div>";
            }

            //next and prev buttons:
            if($mapmenusub>1){
                $tprev = "href='mapmenu.php?mapmenusub=".($mapmenusub-1)."'";
            }else{
                $tprev = "none";
            }

            if($mapmenusub < ceil(count($savearr)/24)){
                $tnext = "href='mapmenu.php?mapmenusub=".($mapmenusub+1)."'";
            }else{
                $tnext = "none";
            }
            
        ?>
        <div id="mapnav">
            <a class="turn" <?php
                if($tprev != "none"){
                    echo $tprev;
                }
            ?> >&#11160;</a>
            <a class="turn" <?php
                if($tnext != "none"){
                    echo $tnext;
                }
            ?> >&#11162;</a>
        </div>
    </div>
    <script>
        var mainS = new Audio('audio/ost/menu0.mp3');
        mainS.volume = 0.6;
        mainS.loop =true;
        mainS.play();
    </script>
</body>
</html>