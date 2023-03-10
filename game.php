<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="textures\logo.png"/>
    <title>Pixel-Perfect</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-keylayout.css">
    <link rel="stylesheet" href="style-tiles.css">
    <link rel="stylesheet" href="font.css">
</head>
<body>
    <div id="maingame">
        <a href="mapmenu.php" id="return-a">&#8634;</a>
        <div class="alertinfo">
            <svg viewBox="0 0 100 50"><text x="30" y="31" fill="black">Success</text></svg>
        </div>
        <div class="alertinfo">
            <svg viewBox="0 0 100 50"><text x="12" y="31" fill="black">Fell into the void</text></svg>
        </div>
        <div class="alertinfo">
            <svg viewBox="0 0 100 50"><text x="5" y="31" fill="black">End of instructions</text></svg>
        </div>
        <div id="infof1">
            <img src="textures/nodes/k_esc_alt.png"/>
            <div>
                <div><div class="tile_0_A"></div><span>0</span></div>
                <div><div class="tile_1_A"></div><span>1</span></div>
                <div><div class="tile_2_A"></div><span>2</span></div>
                <div><div class="tile_3_A"></div><span>3</span></div>
                <div><div class="tile_4_0"></div><span>4</span></div>
                <div><div class="tile_5_A">Void</div><span>5</span></div>
                <div><div class="tile_6_B1"></div><span>6</span></div>
                <div><div class="tile_7_A"></div><span>7</span></div>
            </div>
        </div>
        <div id="av-nodes">
            <svg viewBox="0 0 100 115">
            </svg>
            <!-- <div></div> -->
        </div>
        <div id="screen">
            <div id="grid">
                <div id="level">
                    <?php
                        if(isset($_GET['levelindex'])){
                            $levelindex = $_GET['levelindex'];
                        }else{
                            $levelindex = 1;
                        }
                        //map gen from loaded file
                        require_once("gen.php");
                    ?>
                </div>
            </div>
            <div id="seq">
                <svg viewBox="0 0 100 30" id="level-name-author">
                    <text y="22" x="-75"><?php echo '"'.$HL_mapname.'" by '.$HL_author;?></text>
                </svg>
                <div id="playerdeck">
                </div>
                <div title ="Clear Program" id="seq_b">
                </div>
            </div>
        </div>
        <div id="inv">
            <img title ="Available Nodes" src="textures/kafka.png" onclick="kawa();"/>
            <img src="textures/nodes/keyboard_l_2.png"/>
            <img title ="Execute" src="textures/mouse.png"/>
            <img src="textures/mousepad2.png"/>
            <div id="key">
                <img title ="Block Id Information" src="textures/nodes/Keyboard_f1.png"/>
                <div id="key_arrows">
                    <img title ="Move/Check North" src="textures/nodes/Keyboard_note_up.png"/>
                    <img title ="Move/Check South" src="textures/nodes/Keyboard_note_down.png"/>
                    <img title ="Move/Check East" src="textures/nodes/Keyboard_note_right.png"/>
                    <img title ="Move/Check West" src="textures/nodes/Keyboard_note_left.png"/>
                    <img title ="Check Below" src="textures/nodes/Keyboard_note_self.png"/>
                    <img title ="Check North, South, East, West" src="textures/nodes/Keyboard_note_else.png"/>
                </div>
                <div id="key_numpad" title ="Iteration Amount / Block Id">
                    <img src="textures/nodes/Keyboard_num_1.png"/>
                    <img src="textures/nodes/Keyboard_num_2.png"/>
                    <img src="textures/nodes/Keyboard_num_3.png"/>
                    <img src="textures/nodes/Keyboard_num_4.png"/>
                    <img src="textures/nodes/Keyboard_num_5.png"/>
                    <img src="textures/nodes/Keyboard_num_6.png"/>
                    <img src="textures/nodes/Keyboard_num_7.png"/>
                    <img src="textures/nodes/Keyboard_num_8.png"/>
                    <img src="textures/nodes/Keyboard_num_9.png"/>
                    <img src="textures/nodes/Keyboard_num_0.png"/>
                </div>
                <div id="key_main">
                    <!--B section instructions: -->
                    <!--a:-->
                    <img title ="Open For Loop" id="for1" src="textures/nodes/Keyboard_node_for.png"/>
                    <img title ="Close For Loop" id="for2" src="textures/nodes/Keyboard_node_-for.png"/>
                    <!--b:-->
                    <img title ="Open While Loop" id="while1" src="textures/nodes/Keyboard_node_while.png"/>
                    <img title ="Close While Loop" id="while2" src="textures/nodes/Keyboard_node_-while.png"/>
                    <!--c:-->
                    <img title ="Open If Clause" id="if1" src="textures/nodes/Keyboard_node_if.png"/>
                    <img title ="Close If Clause" id="if2" src="textures/nodes/Keyboard_node_-if.png"/>
                </div>
                <div id="key_conditions">
                    <img title ="The Block Id Is:" src="textures/nodes/Keyboard_note_equal.png"/>
                    <img title ="The Block Id Is Not:" src="textures/nodes/Keyboard_note_not.png"/>
                    <img title ="Close Instruction Condition" src="textures/nodes/Keyboard_note_close.png"/>
                    <img title ="Delete Recent Input" src="textures/nodes/k_backspace.png"/>
                </div>
            </div>
        </div>
    </div>
    <script>
        const seq = document.getElementById("seq");
        const seq_b = document.getElementById("seq_b");
        const av_nodes = document.getElementById("av-nodes")
        const notepad = document.getElementById("av-nodes").getElementsByTagName("svg")[0];//.getElementsByTagName("text")[0];
        //audio:
            //sfx:
            var boosterS = new Audio('audio/sfx/booster.mp3');
            var displayS = new Audio('audio/sfx/display.mp3');
            var gameoverS = new Audio('audio/sfx/gameover.mp3');
            var kafkaS = new Audio('audio/sfx/kafka.mp3');
            var pingS = new Audio('audio/sfx/ping.mp3');
            var teleportS = new Audio('audio/sfx/teleport.mp3');
            var walkS = new Audio('audio/sfx/walk.mp3');
            var winS = new Audio('audio/sfx/win.mp3');
            displayS.volume = 0.1;
            pingS.volume = 1;
            //ost:
            let ostrand = Math.floor(Math.random()*4);
            var mainS = new Audio('audio/ost/map'+ostrand+'.mp3');
            mainS.volume = 0.6;
            mainS.loop =true;
            mainS.play();

        kafka_mode = false;
        //true = display nodes, false = hide

        function kawa(){
            if(kafka_mode==false){
                kafka_mode = true;
                //show available nodes:
                kafkaS.play();
                av_nodes.style.zIndex = 10;
                notepad.innerHTML = "<text y='6' fill='blue'>Movement nodes:</text>";
                notepad.innerHTML += "<text y='12'>&#11161; x"+HL_a_temp[0]+"</text>";
                notepad.innerHTML += "<text y='18'>&#11163; x"+HL_a_temp[1]+"</text>";
                notepad.innerHTML += "<text y='24'>&#11162; x"+HL_a_temp[2]+"</text>";
                notepad.innerHTML += "<text y='30'>&#11160; x"+HL_a_temp[3]+"</text>";
                notepad.innerHTML += "<text y='36' fill='blue'>Instruction nodes:</text>";
                notepad.innerHTML += "<text y='42'>for x"+HL_b_temp[0]+"</text>";
                notepad.innerHTML += "<text y='48'>while x"+HL_b_temp[1]+"</text>";
                notepad.innerHTML += "<text y='54'>if x"+HL_b_temp[2]+"</text>";
                notepad.innerHTML += "<text y='60' fill='blue'>Condition nodes:</text>";
                notepad.innerHTML += "<text y='66'>&#11161; x"+HL_c_temp[0]+"</text>";
                notepad.innerHTML += "<text y='72'>&#11163; x"+HL_c_temp[1]+"</text>";
                notepad.innerHTML += "<text y='78'>&#11162; x"+HL_c_temp[2]+"</text>";
                notepad.innerHTML += "<text y='84'>&#11160; x"+HL_c_temp[3]+"</text>";
                notepad.innerHTML += "<text y='90'>&ocir; x"+HL_c_temp[4]+"</text>";
                notepad.innerHTML += "<text y='96'>&#10022; x"+HL_c_temp[5]+"</text>";

            }else{
                kafka_mode = false;
                av_nodes.style.zIndex = -2;
            }
        }
        
        <?php
        //============================================================//
        //Level grid load, pawn starting pos load, available nodes load:
        //============================================================//
        echo "let levelgrid = [";
        for($i = 0; $i<$levelcols; $i++){
            echo "[";
            for($j = 0; $j<$levelrows; $j++){
                // $templevelcell = explode(".", $levelgrid[$j][$i]);
                // echo $templevelcell[0];
                echo "'".$levelgrid[$j][$i]."'";
                if($j+1 != $levelrows){
                    echo ",";
                }
            }
            if($i+1 == $levelcols){
                echo "]";
            }else{
                echo "],";
            }
        }
        echo "];";
        echo "\n\t\t\t\t";
        echo "let pawnpos = [".$pawnpos[0].",".$pawnpos[1]."];";
        echo "\n\t\t\t\t";
        echo "let spawnpawnpos = [".$pawnpos[0].",".$pawnpos[1]."];";
        echo "\n\t\t\t\t";

        if(isset($iscustom)){
            if($iscustom != ""){
                echo "let iscustom = ".$iscustom.";";
            }else{
                echo "let iscustom = 0;";
            }
        }else{
            echo "let iscustom = 0;";
        };
        echo "\n\t\t\t\t";
        //===============================================
        // Nodes and conditions declarations
        //===============================================
        function HLphptojs($HL_sec, $HLsecName){
            echo "let ".$HLsecName." = [";
            for($i = 0; $i<count($HL_sec); $i++){
                echo $HL_sec[$i];
                if($i+1 != count($HL_sec)){
                    echo ",";
                }
            }
            echo "];";
            echo "\n\t\t\t\t";
        }
        HLphptojs($HL_a, "HL_a");
        HLphptojs($HL_b, "HL_b");
        HLphptojs($HL_c, "HL_c");
        HLphptojs($HL_d, "HL_d");

        echo "let levelindex = '$levelindex'";
        echo "\n\t\t\t\t";
        echo "let levelrows = '$levelrows'";
        echo "\n\t\t\t\t";
        echo "let levelcols = '$levelcols'";
        ?>
        //iscustom?
        let returna = document.getElementById("return-a");
        if(iscustom == 1){
            returna.href = "custom.php";
        }
        //==================================
        //game:
        //==================================

        //spawning:
        let MainMap = document.getElementById("MainMap");
        let Pawn = document.createElement("img");
        Pawn.src = "textures/sprite/sprite_front.png";
        Pawn.id = "pawnsprite";
        Pawn.style.position = "absolute";
        Pawn.style.width = 1/levelcols*100 +"%";
        Pawn.style.height = 1/levelrows*100 +"%";
        MainMap.appendChild(Pawn);

        //Moving the pawnsprite:
        let pawnsprite = document.getElementById("pawnsprite");
        function pawnX(n){
            n = Number(n);
            pawnsprite.style.left = n/levelcols*100+"%";
        };
        function pawnY(n){
            n = Number(n);
            pawnsprite.style.top = n/levelrows*100+"%";

        };

        //beginning position of a pawn:
        let startingpos = [];
        startingpos[0]= pawnpos[0];
        startingpos[1]= pawnpos[1];
        pawnX(pawnpos[0]);
        pawnY(pawnpos[1]);

        //=====================================================
        //player deck load
        //=====================================================

        //player's deck input section:
        //keyboard buttons:
        //f1:
        let k_infof1 =  document.getElementById("key").getElementsByTagName("img")[0];
        //arrows:
        let k_arrow_sec = document.getElementById("key_arrows");
        let k_arrow = [];
        for(let i = 0; i< 6; i++){
            k_arrow[i] = k_arrow_sec.getElementsByTagName("img")[i];
        }
        //numpad:
        let k_num_sec = document.getElementById("key_numpad");
        let k_num = [];
        for(i = 0; i <= 8; i++){
            k_num[i+1] = k_num_sec.getElementsByTagName("img")[i];
        }
        k_num[0] = k_num_sec.getElementsByTagName("img")[9];
        //main:
        let k_main_sec = document.getElementById("key_main");
        let k_for = document.getElementById("for1");
        let k_for_minus = document.getElementById("for2");
        let k_while = document.getElementById("while1");
        let k_while_minus = document.getElementById("while2");
        let k_if = document.getElementById("if1");
        let k_if_minus = document.getElementById("if2");
        //conditions:
        let k_conditions_sec = document.getElementById("key_conditions");
        let k_eq = k_conditions_sec.getElementsByTagName("img")[0];
        let k_not = k_conditions_sec.getElementsByTagName("img")[1];
        let k_close_condition = k_conditions_sec.getElementsByTagName("img")[2];
        let k_backspace = k_conditions_sec.getElementsByTagName("img")[3];
        //=====================================================
        //keyboard buttons listeners:
        //f1:
        k_infof1.addEventListener("click", (event)=>{showinfo(true);});
        //arrows:
        for(let i = 0; i< 6; i++){
            k_arrow[i].addEventListener("click", (event)=>{deck_add("arr"+i,0);});
        }
        k_arrow[5].addEventListener("click", (event)=>{ee();});
        //numpad:
        for(let i = 0; i<10; i++){
            k_num[i].addEventListener("click", (event)=>{deck_add(i,0);})
        }
        //main:
        k_for.addEventListener("click", (event)=>{deck_add("for",0);})
        k_for_minus.addEventListener("click", (event)=>{deck_add("for",1);})
        k_while.addEventListener("click", (event)=>{deck_add("while",0);})
        k_while_minus.addEventListener("click", (event)=>{deck_add("while",1);})
        k_if.addEventListener("click", (event)=>{deck_add("if",0);})
        k_if_minus.addEventListener("click", (event)=>{deck_add("if",1);})
        //conditions:
        k_eq.addEventListener("click", (event)=>{deck_add("equal",0);})
        k_not.addEventListener("click", (event)=>{deck_add("not",0);})
        k_close_condition.addEventListener("click", (event)=>{deck_add("close_condition",0);})
        k_backspace.addEventListener("click", (event)=>{
            if(type_mode == 0){
                backspacebutton();
            }
        })

        //info from f1:
        let infof1 = document.getElementById("infof1");
        infof1.getElementsByTagName("img")[0].addEventListener("click", (event)=>{showinfo(false);});
        function showinfo(showinfomode){
            switch(showinfomode){
                case true:
                    infof1.style.zIndex = 4;
                    break;
                case false:
                    infof1.style.zIndex = -5;
                    break;
            }
        }
        //=====================================================
        //=====================================================
        //tests:
                //lv1:
                //let playerdeck = ["ac","ac"];
                //lv2:
                //let playerdeck = ["ba1:2","aa","ba1","ba2:2","ac","ba2"];
                //lv3:
                //let playerdeck = ["f1:3","c","f2:2","b","f2","f1"];
                //lv4:
                //let playerdeck = ["ba1:6","ac","bc1:=c1","ab","bc1","ba1"];
                //lv5:
                //let playerdeck = ["bb1:!d1","ad","bb1","bb2:!b1","ab","bb2","bb3:!c1","ac","bb3","bb4:!a1","aa","bb4"];
                
        //playerdeck display & deck_add:
        let deckdisplay = document.getElementById("playerdeck");
        deckdisplay.innerHTML = "";
        let playerdeck = [];
        let da_i = 0; //player's deck add index
        
        //complex commands useful controlers for loading user data:
        //BA:
        let da_for_i = 0; //for loop's index incrementation
        let last_lv_index_for = []; //remember last index on each depth level
        let howdeep_for=0; //how deep are we?
        let recent_for=false; //was it header or tail?
        let max_index_for = 0; //max index value ever
        //BB:
        let da_w_i = 0;
        let last_lv_index_w = [];
        let howdeep_w=0;
        let recent_w=false;
        let max_index_w = 0;
        //BC:
        let da_g_i = 0;
        let last_lv_index_g = [];
        let howdeep_g=0;
        let recent_g=false;
        let max_index_g = 0;

        //temp HLs contain amount of nodes that can be used. Theese are exact copies of original HLs.
        HL_a_temp = [...HL_a];
        HL_b_temp = [...HL_b];
        HL_c_temp = [...HL_c];
        HL_d_temp = [...HL_d];

        //recent display dump
        let bsDS = [];

        //type mode changes typing: 0-node, 1-number (tile or iteration amount), 2-noe (not or equal), 3-scan (direction of tile searching)
        type_mode = 0;
        update_disabled_keys(0);

        //part -> header = 0, tail = 1;
        function deck_add(inputnode, part){
            if(type_mode == 0){
                switch(inputnode){
                    case "arr0":
                        if(HL_a_temp[0]<=0){
                            break;
                        }
                        playerdeck[da_i] = "aa";
                        //bs:
                        bsDS[da_i] = deckdisplay.innerHTML;

                        da_i++;
                        deckdisplay.innerHTML += "&#11161; ";
                        HL_a_temp[0]--;
                        update_disabled_keys(0);
                        break;
                    case "arr1":
                        if(HL_a_temp[1]<=0){
                            break;
                        }
                        playerdeck[da_i] = "ab";
                        //bs:
                        bsDS[da_i] = deckdisplay.innerHTML;

                        da_i++;
                        deckdisplay.innerHTML += "&#11163; ";
                        HL_a_temp[1]--;
                        update_disabled_keys(0);
                        break;
                    case "arr2":
                        if(HL_a_temp[2]<=0){
                            break;
                        }
                        playerdeck[da_i] = "ac";
                        //bs:
                        bsDS[da_i] = deckdisplay.innerHTML;

                        da_i++;
                        deckdisplay.innerHTML += "&#11162; ";
                        HL_a_temp[2]--;
                        update_disabled_keys(0);
                        break;
                    case "arr3":
                        if(HL_a_temp[3]<=0){
                            break;
                        }
                        playerdeck[da_i] = "ad";
                        //bs:
                        bsDS[da_i] = deckdisplay.innerHTML;

                        da_i++;
                        deckdisplay.innerHTML += "&#11160; ";
                        HL_a_temp[3]--;
                        update_disabled_keys(0);
                        break;
                    case "for":
                        if(HL_b_temp[0]<=0){
                            break;
                        }
                        if(part == 0){//header
                            //increase depth measure depending on header openings in a row
                            if(recent_for==true){
                                howdeep_for++;
                            }
                            da_for_i++;
                            max_index_for++;
                            //always have index higher than previous one:
                            if(max_index_for>da_for_i){
                                da_for_i = max_index_for;
                            }
                            //save last index on level (so when we are back to this depth we know what is supposed to be closed):
                            last_lv_index_for[howdeep_for] = da_for_i;
                            playerdeck[da_i] = "ba"+da_for_i+":";
                            recent_for = true;
                            //prepare for typing condition:
                            type_mode = 1;
                            //bs:
                            bsDS[da_i] = deckdisplay.innerHTML;
                            deckdisplay.innerHTML += "for(";
                            update_disabled_keys(1);
                        }else{//tail
                            //prevent adding more tails than headers:
                            if(da_for_i>0){
                                if(recent_for==false){
                                    //we are closer to surface (one tail closed)
                                    howdeep_for--;
                                }   
                                //use the last index of this level to close the instruction properly:
                                da_for_i = last_lv_index_for[howdeep_for];
                                //bs:
                                bsDS[da_i] = deckdisplay.innerHTML;
                                playerdeck[da_i] = "ba"+da_for_i;
                                deckdisplay.innerHTML += "} ";
                                
                                da_i++;
                                da_for_i--;
                                recent_for = false;
                                HL_b_temp[0]--;
                                update_disabled_keys(0);
                            }
                        }
                        break;
                    case "while":
                        if(HL_b_temp[1]<=0){
                            break;
                        }
                        if(part == 0){
                            if(recent_w==true){
                                howdeep_w++;
                            }
                            da_w_i++;
                            max_index_w++;
                            if(max_index_w>da_w_i){
                                da_w_i = max_index_w;
                            }
                            last_lv_index_w[howdeep_w] = da_w_i;
                            playerdeck[da_i] = "bb"+da_w_i+":";
                            //prepare for condition typing (noe mode):
                            type_mode = 2;
                            //bs:
                            bsDS[da_i] = deckdisplay.innerHTML;
                            deckdisplay.innerHTML += "while(";
                            recent_w = true;
                            update_disabled_keys(2);
                        }else{
                            if(da_w_i>0){
                                if(recent_w==false){
                                    howdeep_w--;
                                }   
                                da_w_i = last_lv_index_w[howdeep_w];
                                //bs:
                                bsDS[da_i] = deckdisplay.innerHTML;
                                playerdeck[da_i] = "bb"+da_w_i;
                                deckdisplay.innerHTML += "} ";
                                
                                da_i++;
                                da_w_i--;
                                recent_w = false;
                                HL_b_temp[1]--;
                                update_disabled_keys(0);
                            }
                        }
                        break;
                    case "if":
                        if(HL_b_temp[2]<=0){
                            break;
                        }
                        if(part == 0){
                            if(recent_g==true){
                                howdeep_g++;
                            }
                            da_g_i++;
                            max_index_g++;
                            if(max_index_g>da_g_i){
                                da_g_i = max_index_g;
                            }
                            last_lv_index_g[howdeep_g] = da_g_i;
                            playerdeck[da_i] = "bc"+da_g_i+":";
                            //prepare for condition typing (noe mode):
                            type_mode = 2;
                            //bs:
                            bsDS[da_i] = deckdisplay.innerHTML;
                            deckdisplay.innerHTML += "if(";
                            recent_g = true;
                            update_disabled_keys(2);
                        }else{
                            if(da_g_i>0){
                                if(recent_g==false){
                                    howdeep_g--;
                                }   
                                da_g_i = last_lv_index_g[howdeep_g];
                                //bs:
                                bsDS[da_i] = deckdisplay.innerHTML;
                                playerdeck[da_i] = "bc"+da_g_i;
                                deckdisplay.innerHTML += "} ";
                                
                                da_i++;
                                da_g_i--;
                                recent_g = false;
                                HL_b_temp[2]--;
                                update_disabled_keys(0);
                            }
                        }
                        break;
                    }
            }else{
                //check if user continues typing in condition:
                if(inputnode != "close_condition"){
                    switch(type_mode){
                        case 1:
                            if(inputnode >=0 && inputnode <=9){
                                //allow only number input:
                                playerdeck[da_i] += inputnode;
                                //show change onscreen:
                                deckdisplay.innerHTML += inputnode;
                                type_mode = 1;
                                update_disabled_keys(1);
                            }
                            break;
                        case 2:
                            switch(inputnode){
                                case "equal":
                                    playerdeck[da_i] += "=";
                                    deckdisplay.innerHTML += "=";
                                    type_mode = 3;
                                    update_disabled_keys(3);
                                    break;
                                case "not":
                                    playerdeck[da_i] += "!";
                                    deckdisplay.innerHTML += "!";
                                    type_mode = 3;
                                    update_disabled_keys(3);
                                    break;
                            }
                            break;
                        case 3:
                            switch(inputnode){
                                case "arr0":
                                    if(HL_c_temp[0]<=0){
                                        break;
                                    }
                                    playerdeck[da_i] += "a";
                                    deckdisplay.innerHTML += "&#11161;";
                                    //change mode to number typing
                                    type_mode = 1;
                                    HL_c_temp[0]--;
                                    update_disabled_keys(1);
                                    break;
                                case "arr1":
                                    if(HL_c_temp[1]<=0){
                                        break;
                                    }
                                    playerdeck[da_i] += "b";
                                    deckdisplay.innerHTML += "&#11163;";
                                    type_mode = 1;
                                    HL_c_temp[1]--;
                                    update_disabled_keys(1);
                                    break;
                                case "arr2":
                                    if(HL_c_temp[2]<=0){
                                        break;
                                    }
                                    playerdeck[da_i] += "c";
                                    deckdisplay.innerHTML += "&#11162;";
                                    type_mode = 1;
                                    HL_c_temp[2]--;
                                    update_disabled_keys(1);
                                    break;
                                case "arr3":
                                    if(HL_c_temp[3]<=0){
                                        break;
                                    }
                                    playerdeck[da_i] += "d";
                                    deckdisplay.innerHTML += "&#11160;";
                                    type_mode = 1;
                                    HL_c_temp[3]--;
                                    update_disabled_keys(1);
                                    break;
                                case "arr4":
                                    if(HL_c_temp[4]<=0){
                                        break;
                                    }
                                    playerdeck[da_i] += "e";
                                    deckdisplay.innerHTML += "&ocir;";
                                    type_mode = 1;
                                    HL_c_temp[4]--;
                                    update_disabled_keys(1);
                                    break;
                                case "arr5":
                                    if(HL_c_temp[5]<=0){
                                        break;
                                    }
                                    playerdeck[da_i] += "f";
                                    deckdisplay.innerHTML += "&#10022;";
                                    type_mode = 1;
                                    HL_c_temp[5]--;
                                    update_disabled_keys(1);
                                    break;
                            }
                            break;
                    }
                }else{
                    //comeback to default typing mode:
                    type_mode = 0;
                    deckdisplay.innerHTML += "){ ";
                    //next node:
                    da_i++;
                    update_disabled_keys(0);
                }
            }
        }

        //===============
        //erasing button:
        //===============

        seq_b.addEventListener("click", (event)=>{
            display_switch();
        })

        async function display_switch(){
            //clear the arrays:
            playerdeck.length = 0;
            HL_a_temp.length = 0;
            HL_b_temp.length = 0;
            HL_c_temp.length = 0;
            HL_d_temp.length = 0;
            HL_a_temp = [...HL_a];
            HL_b_temp = [...HL_b];
            HL_c_temp = [...HL_c];
            HL_d_temp = [...HL_d];
            da_i = 0;

            //restart pawn:
            pawnpos[0] = startingpos[0];
            pawnpos[1] = startingpos[1];
            pawnX(pawnpos[0]);
            pawnY(pawnpos[1]);
            Pawn.src = "textures/sprite/sprite_front.png";

            //clear the screen:
            deckdisplay.innerHTML = "";
            seq.style.backgroundImage = "url('textures/bg_seq_off.png')";
            update_disabled_keys(0);
            displayS.play();
            await new Promise(r => setTimeout(r, 500));
            seq.style.backgroundImage = "url('textures/bg_seq_on.png')";
        };

        function backspacebutton(){
            if(da_i != 0 && type_mode ==0){
                //backspace only allowed when last input was full finished node (for simplification)
                let pd_dump = playerdeck[da_i-1].split(":");

                //revive used nodes:
                switch(pd_dump[0].substring(0,1)){
                    case "a":
                        switch(pd_dump[0].substring(1,2)){
                            case "a":
                                HL_a_temp[0]++;
                                break;
                            case "b":
                                HL_a_temp[1]++;
                                break;
                            case "c":
                                HL_a_temp[2]++;
                                break;
                            case "d":
                                HL_a_temp[3]++;
                                break;
                        }
                        break;
                    case "b":
                        switch(pd_dump[0].substring(1,2)){
                            case "a":
                                if(pd_dump.length==1){
                                    HL_b_temp[0]++;
                                }
                                break;
                            case "b":
                                if(pd_dump.length==1){
                                HL_b_temp[1]++;
                                }else{
                                switch(pd_dump[1].substring(1,2)){
                                    case "a":
                                        HL_c_temp[0]++;
                                        break;
                                    case "b":
                                        HL_c_temp[1]++;
                                        break;
                                    case "c":
                                        HL_c_temp[2]++;
                                        break;
                                    case "d":
                                        HL_c_temp[3]++;
                                        break;
                                    case "e":
                                        HL_c_temp[4]++;
                                        break;
                                    case "f":
                                        HL_c_temp[5]++;
                                        break;
                                }}
                                break;
                            case "c":
                                if(pd_dump.length==1){
                                HL_b_temp[2]++;
                                }else{
                                switch(pd_dump[1].substring(1,2)){
                                    case "a":
                                        HL_c_temp[0]++;
                                        break;
                                    case "b":
                                        HL_c_temp[1]++;
                                        break;
                                    case "c":
                                        HL_c_temp[2]++;
                                        break;
                                    case "d":
                                        HL_c_temp[3]++;
                                        break;
                                    case "e":
                                        HL_c_temp[4]++;
                                        break;
                                    case "f":
                                        HL_c_temp[5]++;
                                        break;
                                }}
                                break;
                        }
                        break;
                }
                //final apply:
                playerdeck.pop();
                da_i--;
                deckdisplay.innerHTML = "";
                deckdisplay.innerHTML = bsDS[da_i];
                update_disabled_keys(0);
            }
        }

        //making disallowed buttons fade:
        function update_disabled_keys(activemode){
            //disable nodes that are disallowed in active mode:
            switch(activemode){
                case 0:
                    //arrows:
                    for(let i = 0; i< 4; i++){
                        k_arrow[i].classList.remove("key_disabled");
                    }
                    k_arrow[4].classList.add("key_disabled");
                    k_arrow[5].classList.add("key_disabled");
                    //numpad:
                    for(let i = 0; i<10; i++){
                        k_num[i].classList.add("key_disabled");
                    }
                    //main:
                    k_for.classList.remove("key_disabled");
                    k_for_minus.classList.remove("key_disabled");
                    k_while.classList.remove("key_disabled");
                    k_while_minus.classList.remove("key_disabled");
                    k_if.classList.remove("key_disabled");
                    k_if_minus.classList.remove("key_disabled");
                    //conditions:
                    k_eq.classList.add("key_disabled");
                    k_not.classList.add("key_disabled");
                    k_close_condition.classList.add("key_disabled");
                    break;
                case 1:
                    //arrows:
                    for(let i = 0; i< 6; i++){
                        k_arrow[i].classList.add("key_disabled");
                    }
                    //numpad:
                    for(let i = 0; i<10; i++){
                        k_num[i].classList.remove("key_disabled");
                    }
                    //main:
                    k_for.classList.add("key_disabled");
                    k_for_minus.classList.add("key_disabled");
                    k_while.classList.add("key_disabled");
                    k_while_minus.classList.add("key_disabled");
                    k_if.classList.add("key_disabled");
                    k_if_minus.classList.add("key_disabled");
                    //conditions:
                    k_eq.classList.add("key_disabled");
                    k_not.classList.add("key_disabled");
                    k_close_condition.classList.remove("key_disabled");
                    break;
                case 2:
                    //arrows:
                    for(let i = 0; i< 6; i++){
                        k_arrow[i].classList.add("key_disabled");
                    }
                    //numpad:
                    for(let i = 0; i<10; i++){
                        k_num[i].classList.add("key_disabled");
                    }
                    //main:
                    k_for.classList.add("key_disabled");
                    k_for_minus.classList.add("key_disabled");
                    k_while.classList.add("key_disabled");
                    k_while_minus.classList.add("key_disabled");
                    k_if.classList.add("key_disabled");
                    k_if_minus.classList.add("key_disabled");
                    //conditions:
                    k_eq.classList.remove("key_disabled");
                    k_not.classList.remove("key_disabled");
                    k_close_condition.classList.add("key_disabled");
                    break;
                case 3:
                    //arrows:
                    for(let i = 0; i< 6; i++){
                        k_arrow[i].classList.remove("key_disabled");
                    }
                    //numpad:
                    for(let i = 0; i<10; i++){
                        k_num[i].classList.add("key_disabled");
                    }
                    //main:
                    k_for.classList.add("key_disabled");
                    k_for_minus.classList.add("key_disabled");
                    k_while.classList.add("key_disabled");
                    k_while_minus.classList.add("key_disabled");
                    k_if.classList.add("key_disabled");
                    k_if_minus.classList.add("key_disabled");
                    //conditions:
                    k_eq.classList.add("key_disabled");
                    k_not.classList.add("key_disabled");
                    k_close_condition.classList.add("key_disabled");
                    break;
            }

            //disable used out nodes:
            switch(type_mode){
                case 0:
                    //arrows in contxt of movement
                    for(let i = 0; i< 4; i++){
                        if(HL_a_temp[i]==0){
                            k_arrow[i].classList.add("key_disabled");
                        }
                    }
                    break;
                case 3:
                    //arrows in contxt of testing surroundings
                    for(let i = 0; i< 6; i++){
                        if(HL_c_temp[i]==0){
                            k_arrow[i].classList.add("key_disabled");
                        }
                    }
                break;
            }
            
            if(HL_b_temp[0]==0){
                k_for.classList.add("key_disabled");
                k_for_minus.classList.add("key_disabled");
            }
            if(HL_b_temp[1]==0){
                k_while.classList.add("key_disabled");
                k_while_minus.classList.add("key_disabled");
            }
            if(HL_b_temp[2]==0){
                k_if.classList.add("key_disabled");
                k_if_minus.classList.add("key_disabled");
            }
            //todo: b[3], b[4]

            //backspace:
            if(type_mode ==0 && da_i != 0 ){
                k_backspace.classList.remove("key_disabled");
            }else{
                k_backspace.classList.add("key_disabled");
            }
            
        }
        //==========================================================================
        // Run the deck button:
        //==========================================================================
        //if true, you cannot activate the function begingame:
        let deckdone = false; 
        let k_mouse = document.getElementById("inv").getElementsByTagName("img")[2];
        k_mouse.addEventListener("click", (event)=>{
            if(deckdone == false){
                begingame();
            }
        })
        let ee_i = 0;
        async function ee(){
            if(type_mode==0){
                ee_i++;
            }
            if(ee_i==64){
                Pawn.src = "textures/titlescreen/sprite_ee.png";
                pingS.play();
                await new Promise(r => setTimeout(r, 500));
                display_switch();
                alert("The pawn has been torn apart!");
            }
        }
        //=======================================
        //player deck validation
        //=======================================
            // available nodes array test:
            // for(let i = 0; i<avnodes.length; i++){
            //     console.log(avnodes[i]);
            // }

        //=======================================
        // The game simulation:
        //=======================================

        //begingame();

        async function begingame(){
        deckdone = true;
        //Every "for" loop (ba1, ba2, ba3 ...) with it's position and amount of times left to be executed for each one:
        let ba_countdown = [];
        let ba_position = [];
        //same for while, but without countdown (it relys on condition being checked everytime on header)
        let bb_position = [];

        let pd_i = 0;

        let portal_temp = [];
        
        while(true){
            // console.log(levelgrid[pawnpos[0]][pawnpos[1]].split(".")[0]);
            // console.log(levelgrid[pawnpos[0]][pawnpos[1]].split(".")[1]);
            //Check if stepped on booster:
            if(levelgrid[pawnpos[0]][pawnpos[1]].split(".")[0]==6){
                boosterS.play();
                switch(levelgrid[pawnpos[0]][pawnpos[1]].split(".")[1]){
                    case 'B1':
                        //wait a little:
                        await new Promise(r => setTimeout(r, 500));
                        Pawn.src = "textures/sprite/sprite_back.png";
                        if(levelgrid[pawnpos[0]]===undefined){
                            break;
                        }else
                        if(levelgrid[pawnpos[0]][pawnpos[1]-1]===undefined){
                            break;
                        }
                        //Go up -> check if there is no wall above:
                        if(levelgrid[pawnpos[0]][pawnpos[1]-1].split(".")[0]!=1){
                            pawnpos[1]=pawnpos[1]-1;
                            pawnY(pawnpos[1]);
                            console.log("pawn: boosted up");
                        }else{
                            console.log("pawn: encountered wall north");
                        }
                        break;
                    case 'B3':
                        await new Promise(r => setTimeout(r, 500));
                        Pawn.src = "textures/sprite/sprite_front.png";
                        if(levelgrid[pawnpos[0]]===undefined){
                            break;
                        }else
                        if(levelgrid[pawnpos[0]][pawnpos[1]+1]===undefined){
                            break;
                        }
                        //Go down -> check if there is no wall below:
                        if(levelgrid[pawnpos[0]][pawnpos[1]+1].split(".")[0]!=1){
                            pawnpos[1]=pawnpos[1]+1;
                            pawnY(pawnpos[1]);
                            console.log("pawn: boosted down");
                        }else{
                            console.log("pawn: encountered wall south");
                        }
                        break;
                    case 'B2':
                        await new Promise(r => setTimeout(r, 500));
                        Pawn.src = "textures/sprite/sprite_right.png";
                        if(levelgrid[pawnpos[0]+1]===undefined){
                            break;
                        }else
                        if(levelgrid[pawnpos[0]+1][pawnpos[1]]===undefined){
                            break;
                        }
                        //Go right -> check if there is no wall east:
                        if(levelgrid[pawnpos[0]+1][pawnpos[1]].split(".")[0]!=1){
                            pawnpos[0]=pawnpos[0]+1;
                            pawnX(pawnpos[0]);
                            console.log("pawn: boosted right");
                        }else{
                            console.log("pawn: encountered wall east");
                        }
                        break;
                    case 'B4':
                        await new Promise(r => setTimeout(r, 500));
                        Pawn.src = "textures/sprite/sprite_left.png";
                        if(levelgrid[pawnpos[0]-1]===undefined){
                            break;
                        }else if(levelgrid[pawnpos[0]-1][pawnpos[1]]===undefined){
                            break;
                        }
                        //Go left -> check if there is no wall west:
                        if(levelgrid[pawnpos[0]-1][pawnpos[1]].split(".")[0]!=1){
                            pawnpos[0]=pawnpos[0]-1;
                            pawnX(pawnpos[0]);
                            console.log("pawn: boosted left");
                        }else{
                            console.log("pawn: encountered wall west");
                        }
                        break;
                }

            }

            else{

        //check first letter of a node to identify section
        if(playerdeck[pd_i]){
        
        switch(playerdeck[pd_i].substring(0, 1)){
            //============================================================ HL_a
            case 'a':
                walkS.play();
                //it's HL_a section (movement):
                switch (playerdeck[pd_i].substring(1, 2)){
                    case 'a':
                        //wait a little:
                        await new Promise(r => setTimeout(r, 500));
                        Pawn.src = "textures/sprite/sprite_back.png";
                        if(levelgrid[pawnpos[0]]===undefined){
                            break;
                        }else
                        if(levelgrid[pawnpos[0]][pawnpos[1]-1]===undefined){
                            break;
                        }
                        //Go up -> check if there is no wall above:
                        if(levelgrid[pawnpos[0]][pawnpos[1]-1].split(".")[0]!=1){
                            pawnpos[1]=pawnpos[1]-1;
                            pawnY(pawnpos[1]);
                            console.log("pawn: moved up");
                        }else{
                            console.log("pawn: encountered wall north");
                        }
                        break;
                    case 'b':
                        await new Promise(r => setTimeout(r, 500));
                        Pawn.src = "textures/sprite/sprite_front.png";
                        if(levelgrid[pawnpos[0]]===undefined){
                            break;
                        }else
                        if(levelgrid[pawnpos[0]][pawnpos[1]+1]===undefined){
                            break;
                        }
                        //Go down -> check if there is no wall below:
                        if(levelgrid[pawnpos[0]][pawnpos[1]+1].split(".")[0]!=1){
                            pawnpos[1]=pawnpos[1]+1;
                            pawnY(pawnpos[1]);
                            console.log("pawn: moved down");
                        }else{
                            console.log("pawn: encountered wall south");
                        }
                        break;
                    case 'c':
                        await new Promise(r => setTimeout(r, 500));
                        Pawn.src = "textures/sprite/sprite_right.png";
                        if(levelgrid[pawnpos[0]+1]===undefined){
                            break;
                        }else
                        if(levelgrid[pawnpos[0]+1][pawnpos[1]]==undefined){
                            break;
                        }
                        //Go right -> check if there is no wall east:
                        if(levelgrid[pawnpos[0]+1][pawnpos[1]].split(".")[0]!=1){
                            pawnpos[0]=pawnpos[0]+1;
                            pawnX(pawnpos[0]);
                            console.log("pawn: moved right");
                        }else{
                            console.log("pawn: encountered wall east");
                        }
                        break;
                    case 'd':
                        await new Promise(r => setTimeout(r, 500));
                        Pawn.src = "textures/sprite/sprite_left.png";
                        if(levelgrid[pawnpos[0]-1]===undefined){
                            break;
                        }else
                        if(levelgrid[pawnpos[0]-1][pawnpos[1]]===undefined){
                            break;
                        }
                        //Go left -> check if there is no wall west:
                        if(levelgrid[pawnpos[0]-1][pawnpos[1]].split(".")[0]!=1){
                            pawnpos[0]=pawnpos[0]-1;
                            pawnX(pawnpos[0]);
                            console.log("pawn: moved left");
                        }else{
                            console.log("pawn: encountered wall west");
                        }
                        break;
                    };
                break;
            //============================================================ HL_b
            // Loops and other more complex instructions:
            //============================================================
            case 'b':
                switch (playerdeck[pd_i].substring(1, 2)){
                    case 'a':
                    //It is a for loop:
                        //id of a present loop:
                        let ba_temp = playerdeck[pd_i].substring(2).split(":");
                        let ba_loopid = Number(ba_temp[0]);
                        //check if it is loop's header, not tail
                        if(ba_temp.length>1){
                            //start a loop if it's position isn't registered (set the countdown amount):
                            if(ba_position[ba_loopid] == null){
                                //set position relative to whole set of nodes:
                                ba_position[ba_loopid] = pd_i;
                                //set counter:
                                ba_countdown[ba_loopid] = Number(ba_temp[1]);
                                //logs:
                                console.log("loop ba"+ba_loopid+" begins, counts left: "+ba_countdown[ba_loopid]);
                            }
                        }else{
                            //It is a tail of a loop -> decrement counter, because one iteration is complete:
                            ba_countdown[ba_loopid]--;
                            //if any counts are left, jump back to loop's beginning. Else exit, by simply doing nothing
                            if(ba_countdown[ba_loopid]>0){
                                pd_i = ba_position[ba_loopid];
                                console.log("loop ba"+ba_loopid+", counts left: "+ba_countdown[ba_loopid]);
                            }else{
                                //reset register (in case this loop will be reused as a part of another loop)
                                ba_position[ba_loopid]=null;
                                ba_countdown[ba_loopid]=null;
                                console.log("loop ba"+ba_loopid+" finished");
                            }
                        }
                        break;
                    case 'b':
                        let bb_temp = playerdeck[pd_i].substring(2).split(":");
                        let bb_id = Number(bb_temp[0]);
                        //header of if:
                        if(bb_temp.length>1){
                        //start a loop if it's position isn't registered:
                            if(bb_position[bb_id] == null){
                                //set position relative to whole set of nodes:
                                bb_position[bb_id] = pd_i;
                                //logs:
                                console.log("loop bb"+bb_id+" begins");
                            }
                            let bb_condition = bb_temp[1];
                            //is it negated?:
                            let bb_neg = bb_condition.substring(0,1);
                            //direction:
                            let bb_direction = bb_condition.substring(1,2);
                            //detected tile:
                            let bb_tile = Number(bb_condition.substring(2)).toString();
                            let bb_conmet = false;
                            //if offset is out of array, change bb_con_tile. 0=north, 1=south, 2-east, 3-west, 4-self
                            let bb_con_tile = [];
                            if(levelgrid[pawnpos[0]]===undefined){bb_con_tile[0] = "5.0";}
                            else if(levelgrid[pawnpos[0]][pawnpos[1]-1]===undefined){bb_con_tile[0] = "5.0";}
                            else{
                                bb_con_tile[0] = String(levelgrid[pawnpos[0]][pawnpos[1]-1]);
                            }
                            if(levelgrid[pawnpos[0]]===undefined){bb_con_tile[1] = "5.0";}
                            else if(levelgrid[pawnpos[0]][pawnpos[1]+1]===undefined){bb_con_tile[1] = "5.0";}
                            else{
                                bb_con_tile[1] = String(levelgrid[pawnpos[0]][pawnpos[1]+1]);
                            }
                            if(levelgrid[pawnpos[0]+1]===undefined){bb_con_tile[2] = "5.0";}
                            else if(levelgrid[pawnpos[0]+1][pawnpos[1]]===undefined){bb_con_tile[2] = "5.0";}
                            else{
                                bb_con_tile[2] = String(levelgrid[pawnpos[0]+1][pawnpos[1]]);
                            }
                            if(levelgrid[pawnpos[0]-1]===undefined){bb_con_tile[3] = "5.0";}
                            else if(levelgrid[pawnpos[0]-1][pawnpos[1]]===undefined){bb_con_tile[3] = "5.0";}
                            else{
                                bb_con_tile[3] = String(levelgrid[pawnpos[0]-1][pawnpos[1]]);
                            }
                            if(levelgrid[pawnpos[0]]===undefined){bb_con_tile[4] = "5.0";}
                            else if(levelgrid[pawnpos[0]][pawnpos[1]]===undefined){bb_con_tile[4] = "5.0";}
                            else{
                                bb_con_tile[4] = String(levelgrid[pawnpos[0]][pawnpos[1]]);
                            }
                            // console.log("bbc0 "+bb_con_tile[0]);
                            // console.log("bbc1 "+bb_con_tile[1]);
                            // console.log("bbc2 "+bb_con_tile[2]);
                            // console.log("bbc3 "+bb_con_tile[3]);
                            // console.log("bbc4 "+bb_con_tile[4]);
                            //check if condition is met:
                            if(bb_neg=="="){
                                switch(bb_direction){
                                    case 'a':
                                        if(bb_con_tile[0].split(".")[0]==bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" north");
                                        }
                                        break;
                                    case 'b':
                                        if(bb_con_tile[1].split(".")[0]==bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" south");
                                        }
                                        break;
                                    case 'c':
                                        if(bb_con_tile[2].split(".")[0]==bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" east");
                                        }
                                        break;
                                    case 'd':
                                        if(bb_con_tile[3].split(".")[0]==bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" west");
                                        }
                                        break;
                                    case 'e':
                                        if(bb_con_tile[4].split(".")[0]==bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" self");
                                        }
                                        break;
                                    case 'f':
                                        if(bb_con_tile[0].split(".")[0]==bb_tile ||
                                            bb_con_tile[1].split(".")[0]==bb_tile ||
                                            bb_con_tile[2].split(".")[0]==bb_tile ||
                                            bb_con_tile[3].split(".")[0]==bb_tile
                                        ){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" anywhere around");
                                        }
                                        break;
                                }
                            }else{
                                switch(bb_direction){
                                    case 'a':
                                        if(bb_con_tile[0].split(".")[0]!=bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" not north");
                                        }
                                        break;
                                    case 'b':
                                        if(bb_con_tile[1].split(".")[0]!=bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" not south");
                                        }
                                        break;
                                    case 'c':
                                        if(bb_con_tile[2].split(".")[0]!=bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" not east");
                                        }
                                        break;
                                    case 'd':
                                        if(bb_con_tile[3].split(".")[0]!=bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" not west");
                                        }
                                        //console.log("halo");
                                        break;
                                    case 'e':
                                        if(bb_con_tile[4].split(".")[0]!=bb_tile){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" not self");
                                        }
                                        break;
                                    case 'f':
                                        if(bb_con_tile[0].split(".")[0]!=bb_tile &&
                                            bb_con_tile[1].split(".")[0]!=bb_tile &&
                                            bb_con_tile[2].split(".")[0]!=bb_tile &&
                                            bb_con_tile[3].split(".")[0]!=bb_tile
                                        ){
                                            bb_conmet = true;
                                            console.log("condition met: tile "+bb_tile+" nowhere around");
                                        }
                                        break;
                                }
                            }
                            //if condition is met do nothing, if not - skip all instructions inside clause
                            if(bb_conmet==false){
                                while(true){
                                    //search for closing tail
                                    pd_i++;
                                    //is a node a while instruction? Does it share the same id as header?:
                                    let bb_temp_tail = playerdeck[pd_i].substring(2).split(":");
                                    let bb_id_tail = Number(bb_temp_tail[0]);
                                    if(playerdeck[pd_i].substring(0, 2)=="bb" && bb_id_tail==bb_id){
                                        //if yes, it is a tail
                                        bb_conmet = true;
                                        bb_position[bb_id] = null;
                                        console.log("instruction bb"+bb_id+" (while) ended");
                                        //pd_i++;
                                        break;
                                    }
                                }
                            }
                        }else{
                            //jump back to header, but a space before, beecause it will be incremented again at the end of begingame function
                            pd_i = bb_position[bb_id]-1;
                            console.log("instruction's bb"+bb_id+" (while) iteration completed, jumping back to header");
                        }
                        break;
                    case 'c':
                        let bc_temp = playerdeck[pd_i].substring(2).split(":");
                        let bc_id = Number(bc_temp[0]);
                        //header of if:
                        if(bc_temp.length>1){
                            let bc_condition = bc_temp[1];
                            //is it negated?:
                            let bc_neg = bc_condition.substring(0,1);
                            //direction:
                            let bc_direction = bc_condition.substring(1,2);
                            //detected tile:
                            let bc_tile = Number(bc_condition.substring(2)).toString();
                            let bc_conmet = false;
                            //if offset is out of array, change bc_con_tile. 0=north, 1=south, 2-east, 3-west, 4-self
                            let bc_con_tile = [];
                            if(levelgrid[pawnpos[0]]===undefined){bc_con_tile[0] = "5.0";}
                            else if(levelgrid[pawnpos[0]][pawnpos[1]-1]===undefined){bc_con_tile[0] = "5.0";}
                            else{
                                bc_con_tile[0] = String(levelgrid[pawnpos[0]][pawnpos[1]-1]);
                            }
                            if(levelgrid[pawnpos[0]]===undefined){bc_con_tile[1] = "5.0";}
                            else if(levelgrid[pawnpos[0]][pawnpos[1]+1]===undefined){bc_con_tile[1] = "5.0";}
                            else{
                                bc_con_tile[1] = String(levelgrid[pawnpos[0]][pawnpos[1]+1]);
                            }
                            if(levelgrid[pawnpos[0]+1]===undefined){bc_con_tile[2] = "5.0";}
                            else if(levelgrid[pawnpos[0]+1][pawnpos[1]]===undefined){bc_con_tile[2] = "5.0";}
                            else{
                                bc_con_tile[2] = String(levelgrid[pawnpos[0]+1][pawnpos[1]]);
                            }
                            if(levelgrid[pawnpos[0]-1]===undefined){bc_con_tile[3] = "5.0";}
                            else if(levelgrid[pawnpos[0]-1][pawnpos[1]]===undefined){bc_con_tile[3] = "5.0";}
                            else{
                                bc_con_tile[3] = String(levelgrid[pawnpos[0]-1][pawnpos[1]]);
                            }
                            if(levelgrid[pawnpos[0]]===undefined){bc_con_tile[4] = "5.0";}
                            else if(levelgrid[pawnpos[0]][pawnpos[1]]===undefined){bc_con_tile[4] = "5.0";}
                            else{
                                bc_con_tile[4] = String(levelgrid[pawnpos[0]][pawnpos[1]]);
                            }
                            //check if condition is met:
                            if(bc_neg=="="){
                                switch(bc_direction){
                                    case 'a':
                                        if(bc_con_tile[0].split(".")[0]==bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" north");
                                        }
                                        break;
                                    case 'b':
                                        if(bc_con_tile[1].split(".")[0]==bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" south");
                                        }
                                        break;
                                    case 'c':
                                        if(bc_con_tile[2].split(".")[0]==bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" east");
                                        }
                                        break;
                                    case 'd':
                                        if(bc_con_tile[3].split(".")[0]==bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" west");
                                        }
                                        break;
                                    case 'e':
                                        if(bc_con_tile[4].split(".")[0]==bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" self");
                                        }
                                        break;
                                    case 'f':
                                        if(bc_con_tile[0].split(".")[0]==bc_tile ||
                                            bc_con_tile[1].split(".")[0]==bc_tile ||
                                            bc_con_tile[2].split(".")[0]==bc_tile ||
                                            bc_con_tile[3].split(".")[0]==bc_tile
                                        ){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" anywhere around");
                                        }
                                        break;
                                }
                            }else{
                                switch(bc_direction){
                                    case 'a':
                                        if(bc_con_tile[0].split(".")[0]!=bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" not north");
                                        }
                                        break;
                                    case 'b':
                                        if(bc_con_tile[1].split(".")[0]!=bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" not south");
                                        }
                                        break;
                                    case 'c':
                                        if(bc_con_tile[2].split(".")[0]!=bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" not east");
                                        }
                                        break;
                                    case 'd':
                                        if(bc_con_tile[3].split(".")[0]!=bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" not west");
                                        }
                                        break;
                                    case 'e':
                                        if(bc_con_tile[4].split(".")[0]!=bc_tile){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" not self");
                                        }
                                        break;
                                    case 'f':
                                        if(bc_con_tile[0].split(".")[0]!=bc_tile &&
                                            bc_con_tile[1].split(".")[0]!=bc_tile &&
                                            bc_con_tile[2].split(".")[0]!=bc_tile &&
                                            bc_con_tile[3].split(".")[0]!=bc_tile
                                        ){
                                            bc_conmet = true;
                                            console.log("condition met: tile "+bc_tile+" nowhere around");
                                        }
                                        break;
                                }
                            }
                            //if condition is met do nothing, if not - skip all instructions inside clause
                            if(bc_conmet==false){
                                while(true){
                                    //search for closing tail
                                    pd_i++;
                                    //is a node an if instruction? Does it share the same id as header?:
                                    let bc_temp_tail = playerdeck[pd_i].substring(2).split(":");
                                    let bc_id_tail = Number(bc_temp_tail[0]);
                                    if(playerdeck[pd_i].substring(0, 2)=="bc" && bc_id_tail==bc_id){
                                        //if yes, it is a tail
                                        bc_conmet=true;
                                        console.log("instruction bc"+bc_id+" (if) skipped");
                                        break;
                                    }
                                }
                            }
                        }else{
                            console.log("instruction bc"+bc_id+" (if) completed");
                        }
                        break;
                }
                break;
            }
        }
        //stepped on a portal:
        if(levelgrid[pawnpos[0]][pawnpos[1]].split(".")[0]==4){
            teleportS.play();
            await new Promise(r => setTimeout(r, 1200));
            portal_temp[0] = levelgrid[pawnpos[0]][pawnpos[1]].split(".")[1];
            portal_temp[1] = levelgrid[pawnpos[0]][pawnpos[1]].split(".")[2];
            pawnpos[0] = Number(portal_temp[0]);
            pawnpos[1] = Number(portal_temp[1]);
            pawnX(pawnpos[0]);
            pawnY(pawnpos[1]);
            console.log("encountered portal. Taking to: "+portal_temp[0]+":"+portal_temp[1]);
        }
        //game target found:
        if(levelgrid[pawnpos[0]][pawnpos[1]].split(".")[0]==3){
            //update save and savemain file in save.php:
            let lastdirlen = window.location.href.split("/").length;
            let wndw = "";
            for(let i = 0; i<lastdirlen-1; i++){
                wndw += window.location.href.split("/")[i]+"/";
            }
            await new Promise(r => setTimeout(r, 500));
            infoalert(1);
            winS.play();
            await new Promise(r => setTimeout(r, 3500));
            switch(iscustom){
                case 0:
                    //official levels:
                    window.location.href = wndw+"save.php?levelindex="+levelindex+"&wndw="+wndw;
                    break;
                case 1:
                    //custom player levels:
                    window.location.href = wndw+"custom.php";
                    //console.log(wndw+"custom.php");
                    break;
            }
            break;
        }
        //fell in to the void:
        if(levelgrid[pawnpos[0]][pawnpos[1]].split(".")[0]==5){
            await new Promise(r => setTimeout(r, 500));
            gameoverS.play();
            infoalert(2);
            await new Promise(r => setTimeout(r, 1500));
            deckdone = false;
            //alert("You fell off of the map!");
            
            resetpawn();
            // display_switch()
            break;
        }
        //end of player nodes, ignore if on booster -> let the player be accelerated even if out of nodes:
        if(pd_i >= playerdeck.length-1 && levelgrid[pawnpos[0]][pawnpos[1]].split(".")[0]!=6){
            await new Promise(r => setTimeout(r, 500));
            gameoverS.play();
            infoalert(3);
            await new Promise(r => setTimeout(r, 1500));
            deckdone = false;
            //alert("End of instructions. You failed.");
            
            resetpawn();
            // display_switch()
            break;
        }

        }
            if(levelgrid[pawnpos[0]][pawnpos[1]].split(".")[0]!=6){
                //console.log(pd_i);
                pd_i++;
            }

        //Pawn pos:
        console.log("Pawn pos: "+pawnpos[0]+" - "+pawnpos[1]);
        console.log("pd_i: "+pd_i);
        //console.log("pd_i: "+(playerdeck.length-1));
        }
        }
        
        async function infoalert(typealert){
            let tempalert = document.getElementsByClassName("alertinfo")[typealert-1];
            tempalert.style.zIndex = 12;
            if(typealert ==1){
                await new Promise(r => setTimeout(r, 3500));
            }else{
                await new Promise(r => setTimeout(r, 1500));
            }
            tempalert.style.zIndex = -5;
        }

        async function resetpawn(){
            pawnpos[0] = spawnpawnpos[0];
            pawnpos[1] = spawnpawnpos[1];
            pawnX(pawnpos[0]);
            pawnY(pawnpos[1]);
        }
    </script>
</body>
</html>