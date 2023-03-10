<?php
    if(isset($_GET['levelindex'])){
        $li = $_GET['levelindex'];
        $wndw = $_GET['wndw'];

        //main save:
        $savemainfile = fopen("save/savemain.txt", "r");
        $saveline = fgets($savemainfile);
        $savearr = explode(":", $saveline);
        fclose($savemainfile);
        $looprange = 0;

        if(count($savearr)<$li){
            $looprange = $li;
        }else{
            $looprange = count($savearr);
        }
        $sinput = "";
        for($i = 0; $i < $looprange; $i++){
            if($i+1 == $li){
                $sinput .= 1;
            }
            else
            if(isset($savearr[$i])){
                if(count($savearr)>1){
                    $sinput .= $savearr[$i];
                }else{
                    $sinput .= 0;
                }
            }else{
                $sinput .= 0;
            }

            if($i != $looprange-1){
                $sinput .= ":";
            }
        }
        $smf = fopen("save/savemain.txt", "w");
        fwrite($smf, $sinput);
        fclose($smf);
        
        //recent save:
        $li++;
        if($li <= count(scandir("levels"))-3){
            $savefiler = fopen("save/save.txt", "r");
            fseek($savefiler, 0);
            $hs = (int)fgets($savefiler);
            fclose($savefiler);

            if($li > $hs){
                $savefilew = fopen("save/save.txt", "w");
                fwrite($savefilew, $li);
                fclose($savefilew);
            }
            header("Location: ".$wndw."game.php?levelindex=".$li);
        }else{
            header("Location: $wndw");
        }
    }
?>