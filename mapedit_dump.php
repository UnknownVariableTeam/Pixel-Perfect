<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-mapedit.css">
    <link rel="stylesheet" href="style-tiles.css">
    <link rel="icon" href="textures\logo.png"/>
    <title>Map Generator</title>
</head>
<body>
    <div id="mapedit-header">
        <a href="index.php" id="BackButton">Return</a>
        <span id="editgridinfo"></span>
    </div>
    <div id="grid-container">
        <table id="grid-table">
        </table>
    </div>
    <div id="tiles_parent">
        <div class="tiles_border">
            <div class="tiles tile_0_A" onclick="selectTile(this);"></div>
            <div class="tiles tile_7_A" onclick="selectTile(this);"></div>
            <div class="tiles tile_2_A" onclick="selectTile(this);"></div>
            <div class="tiles tile_3_A" onclick="selectTile(this);"></div>
            <div class="tiles tile_4_0" onclick="selectTile(this);"></div>
            <div class="tiles tile_1_A" onclick="selectTile(this);"></div>
            <div class="tiles tile_6_B1" onclick="selectTile(this);" oncontextmenu="rotateTile(this, 4);"></div>
        </div>
        <div class="tiles_border">
            <div class="tiles tile_x_A" onclick="selectTile(this);"></div>
            <div class="tiles tile_x_B1" onclick="selectTile(this);" oncontextmenu="rotateTile(this, 4);"></div>
            <div class="tiles tile_x_C1" onclick="selectTile(this);" oncontextmenu="rotateTile(this, 4);"></div>
            <div class="tiles tile_x_D1" onclick="selectTile(this);" oncontextmenu="rotateTile(this, 2);"></div>
        </div>
    </div>
    
    <form action="mapedit.php" method="post">
        <div>
            <div>
                <label for="">X:</label>
                <input type="number" name="x" id="x" value="5" min="2" onchange="onSizeChange(this);">
            </div>
            <div>
                <label for="">Y:</label>
                <input type="number" name="y" id="y" value="5" min="2" onchange="onSizeChange(this);">
            </div>
        </div>
        <br>
        <div id="fA" class="fnodes">
            <span>Movements:</span>
            <div>Up: <input type="number" name="up" id="up" min="0" value="0"></div>
            <div>Down: <input type="number" name="down" id="down" min="0" value="0"></div>
            <div>Right: <input type="number" name="right" id="right" min="0" value="0"></div>
            <div>Left: <input type="number" name="left" id="left" min="0" value="0"></div>
        </div>
        <div id="fB" class="fnodes">
            <span>Instructions:</span>
            <div>For: <input type="number" name="for" id="for" min="0" value="0"></div>
            <div>While: <input type="number" name="while" id="while" min="0" value="0"></div>
            <div>If: <input type="number" name="if" id="if" min="0" value="0"></div>
        </div>
        <div id="fC" class="fnodes">
            <span>Conditions:</span>
            <div>Up: <input type="number" name="cup" id="cup" min="0" value="0"></div>
            <div>Down: <input type="number" name="cdown" id="cdown" min="0" value="0"></div>
            <div>Right: <input type="number" name="cright" id="cright" min="0" value="0"></div>
            <div>Left: <input type="number" name="cleft" id="cleft" min="0" value="0"></div>
            <div>Self: <input type="number" name="cself" id="cself" min="0" value="0"></div>
            <div>Else: <input type="number" name="celse" id="celse" min="0" value="0"></div>
        </div>
    <div>
    <?php
        $selected = "";

        if(isset($_POST['saveButton']))
        {
            $selected = SaveLevel();
        }

        $files = [];
        $files = loadFiles();

        function loadFiles(){
            $dir = 'levels/my/';
            $allFiles = [];

            if ($handle = opendir($dir)) 
            {
                while (false !== ($entry = readdir($handle))) 
                {
                    if ($entry != "." && $entry != "..") {
                        array_push($allFiles, $entry);
                    }
                }
                
                closedir($handle);
                return $allFiles;
            }
        }

        if(count($files) != 0){
            echo "LVL: <select name='selectlvl' id='selectlvl' onchange='this.form.submit();'>";

            if(!isset($_POST['saveButton']))
            {
                $selected = $_POST["selectlvl"];

                if($selected == "")
                {
                    $selected = $files[0];
                }
            }

            for ($i=0; $i < count($files); $i++) 
            {
                $name = substr($files[$i], 0, -4);

                if($selected == $files[$i])
                {
                    echo "<option value='$files[$i]' selected>$name</option>";
                    continue;
                }
                echo "<option value='$files[$i]'>$name</option>";
            }
            echo "</select>";    
        }
        
        ?>
        </div>
        <div>
            Name:<input type="text" name="levelName" id="levelName" required><br/>
            Author:<input type="text" name="authorName" id="authorName" required><br/>
            <input type="submit" value="Save" id="saveButton" name="saveButton" onclick="SaveLevel();">
            <input type="hidden" name="grid_layout" id="grid_layout" value="">
        </div>
    </div>
    </form>
<script type="text/javascript">
    window.addEventListener("contextmenu", e => e.preventDefault());

    const table = document.getElementById("grid-table");
    const editgridinfo = document.getElementById("editgridinfo");
    const x_input = document.getElementById("x");
    const y_input = document.getElementById("y");
    const grid_layout = document.getElementById("grid_layout");
    let gridSize = [y_input.value, x_input.value];
    let grid = [[]];

    let SelectedTile = null;
    let SelectedVariant = null;
    let PreviousTile = null;
    let Portal = [];
    addEventListener("resize", (event) => {FitTableContainRatio();});

    function onSizeChange(size){
        if(size.name == "y")
            gridSize[0] = size.value;
        else if(size.name == "x"){
            gridSize[1] = size.value;
        }

        editgridinfo.innerHTML = `Map Size: ${gridSize[1]}x${gridSize[0]}`;

        createGrid();
        FitTableContainRatio();
    }

    function FitTableContainRatio(){
        let grid_container_sec = document.getElementById("grid-container");
        let ratioP = grid_container_sec.offsetWidth/grid_container_sec.offsetHeight;
        let ratioC = Number(gridSize[1]) / Number(gridSize[0]);
        let tbody_sec = document.getElementById("grid-table").getElementsByTagName("tbody")[0];
        //console.log(ratioP+":"+ratioC);
        if(ratioC > ratioP)
        {
            //fill the horizontal space, align height by ratio
            tbody_sec.style.width = "80vw";
            tbody_sec.style.height = 80/ratioC+"vw";
        }else{
            //fill the vertical space, align width by ratio
            tbody_sec.style.height = "60vh"
            tbody_sec.style.width = 60*ratioC+"vh";
        }
    }

    function createGrid(){
        //reset grid
        Array.from(table.rows).forEach((tr) => {
            tr.remove();
        });

        //create new grid   
        for(let y = 0; y < gridSize[0]; y++){
            let row = table.insertRow(-1);
            
            if(grid.length < y + 1)
            {
                grid[y] = new Array();
            }

            for (let x = 0; x < gridSize[1]; x++) 
            {   
                let cell = row.insertCell(-1);
                
                let newTile = document.createElement("div");
                newTile.setAttribute("onClick", "SetTile(this, this);");
                newTile.setAttribute("oncontextmenu", "SetTile(this, null);");
                newTile.classList.add('item');
                newTile.setAttribute('id', `${y}x${x}`);
                
                if(grid[y][x] !== undefined)
                {
                    newTile = grid[y][x];
                }
                cell.appendChild(newTile);
                
                grid[y][x] = newTile;
            }
        }

        checkIfCanSave();
        FitTableContainRatio();
    }

    function SetTile(tile, value){
        if(Portal[0] == "" && Portal[1] == "")
        {
            let Coords = tile.id.split("x");

            Portal = [Coords[0], Coords[1]];
            
            PreviousTile.classList.add(`${Coords[0]}x${Coords[1]}`);
            PreviousTile = tile;

            alert(`Ok. ${Coords[0]}x${Coords[1]}`);
            Portal = [];
            checkIfCanSave();
            return;
        }

        if(value == null && Portal[0] != "")
        {
            tile.classList.remove(tile.classList[1]);
            checkIfCanSave();
            PreviousTile = tile;
            return;
        }
        if(SelectedTile != null && SelectedVariant != null)
        {
            if(tile.classList.length > 1){
                tile.classList.remove(tile.classList[1]);

                if(tile.classList.length > 1)
                    tile.classList.remove(tile.classList[1]);
            }

            let newVariant = SelectedVariant.split("_")[2];
            let newClass = SelectedTile.split("_");
            let fusionClass = `${newClass[0]}_${newClass[1]}_${newVariant}`;

            if(SelectedTile.split("_")[1] == "4")
            {
                fusionClass = SelectedTile;
            }

            tile.classList.add(fusionClass);

            checkIfCanSave();
        }
        if(SelectedTile.split("_")[1] == "4")
        {
            if(tile.classList.length > 1){
                tile.classList.remove(tile.classList[1]);
                if(tile.classList.length > 1)
                    tile.classList.remove(tile.classList[1]);
            }

            fusionClass = SelectedTile;
            tile.classList.add(fusionClass);

            alert("Choose target:");
            Portal = ["", ""];
        }   
        if(SelectedTile.split("_")[1] == "6")
        {
            if(tile.classList.length > 1){
                tile.classList.remove(tile.classList[1]);
                if(tile.classList.length > 1)
                    tile.classList.remove(tile.classList[1]);
            }

            fusionClass = SelectedTile;
            //console.log(SelectedTile)
            tile.classList.add(fusionClass);
        }   

        PreviousTile = tile;
    }   

    function rotateTile(tile, maxValue){

        let lastClass = tile.classList[tile.classList.length - 1];
        let selected = false;
        for (let i = 0; i < tile.classList.length; i++) {
            if(tile.classList[i] == "selected")
            {
                if(i == 1)
                {
                    lastClass = tile.classList[tile.classList.length - 1];
                }else if(i == 2)
                {
                    lastClass = tile.classList[tile.classList.length - 2];
                }
                selected = true;
            }
        }
        let name = lastClass.split("_");

        maxValue = Number(maxValue);
        curValue = Number(name[2][1]);

        if(curValue >= maxValue)
        {
            curValue = 1;
        }else{
            curValue++;
        }

        let newClass = "";

        if(name[1] == "x")
        {
            newClass = `${name[0]}_x_${name[2][0]}${curValue}`;
        }else{
            newClass = `${name[0]}_${name[1]}_${name[2][0]}${curValue}`;
        }

        tile.classList.remove(lastClass);
        tile.classList.add(newClass);

        if(selected)
        {
            SelectedVariant = newClass;
        }

        if(SelectedTile.split("_")[1] == "6")
        {
            SelectedTile = newClass;
        }
    }

    function checkIfCanSave(){
        let start = undefined;
        let end = undefined;

        for (let y = 0; y < gridSize[0]; y++) 
        {
            for (let x = 0; x < gridSize[1]; x++) 
            {
                if(grid[y][x].classList.length > 1)
                {
                    let checkClass = grid[y][x].classList[1];
                    let cName = checkClass.split("_");

                    if(cName[1] == "2")
                    {
                        start = grid[y][x];
                    }
                    if(cName[1] == "3")
                    {
                        end = grid[y][x];
                    }
                }
            }
        }
    }

    function selectTile(tile){
        let allTiles = document.getElementsByClassName("tiles");

        let myClass = tile.classList[1];
        let tileName = myClass.split("_");
        
        if(tileName[1] == "x")
        {
            for (const key of allTiles) 
            {
                if(key.classList.contains('selected') && key.classList[1].split("_")[1] == "x")
                {
                    key.classList.remove('selected');
                    continue;
                }
            }
            SelectedVariant = myClass;
        }else
        {
            for (const key of allTiles) 
            {
                if(key.classList.contains('selected') && key.classList[1].split("_")[1] != "x")
                {
                    key.classList.remove('selected');
                    continue;
                }
            }
            SelectedTile = myClass;
        }
        tile.classList.add('selected');
    }

    function LoadGrid(g){
        y_input.value = g.length;
        x_input.value = g[0].length;
        
        gridSize[0] = y_input.value;
        gridSize[1] = x_input.value;
        
        createGrid();
        //console.table(g);

        for (let y = 0; y < gridSize[0]; y++) 
        { 
            for (let x = 0; x < gridSize[1]; x++) 
            {
                let temptile = g[y][x].split('.');
                temptile[0] = Number(temptile[0]);

                let c = "";
                let t = "";

                if(temptile[0] == "4")
                {
                    c = `tile_4_0`;  
                    t = `${temptile[0]}x${temptile[1]}`;
                }
                else{
                    c = `tile_${temptile[0]}_${temptile[1]}`;  
                }
                
                grid[y][x].classList.add(c);
                
                if(t != ""){
                    grid[y][x].classList.add(t);
                }
            }
        }

        editgridinfo.innerText = `Map Size: ${x_input.value}x${y_input.value}`;
    }
    
    function SaveLevel(){
        let classArray = "";

        for (let y = 0; y < gridSize[0]; y++) 
        {
            for (let x = 0; x < gridSize[1]; x++) 
            {
                let c = grid[y][x].classList[1];
                let teleport = grid[y][x].classList[2];

                if(c == undefined)
                {
                    c = "tile_5_0";
                }
                if(teleport != undefined)
                {
                    let coords = teleport.split("x");
                    let t = `4.${coords[0]}.${coords[1]}`;
                    classArray += t;
                }else
                {
                    let e = c.replace("tile_", "");
                    classArray += e.replace("_", ".");
                }
                if(x != gridSize[1] - 1)
                {
                    classArray += ":";
                }
            }   

            if(y != gridSize[0] - 1)
            {
                classArray += '!';
            }
        }

        grid_layout.value = classArray.substring(-1);
    }

    createGrid();
    editgridinfo.innerText = `Map Size: ${x_input.value}x${y_input.value}`;

    <?php
    function LoadLevel($lvl){
        if($lvl == "")
            return;

        $lvlfile = fopen("levels/my/$lvl", "r");

        //Rows and cols calculation:
        $levelrows =-1; //first row is node info
        //$levelcols =-1;

        while(!feof($lvlfile)){
            fgets($lvlfile);
            $levelrows++;
        }

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
        for($i = 0; $i<count($HL_a); $i++){
            $HL_a[$i] = (int)$HL_a[$i];
            //echo $HL_a[$i];
        }
        //echo "<br/>";
        for($i = 0; $i<count($HL_b); $i++){
            $HL_b[$i] = (int)$HL_b[$i];
            //echo $HL_b[$i];
        }
        //echo "<br/>";
        for($i = 0; $i<count($HL_c); $i++){
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
        echo "let levelgrid = [";
        for($i = 0; $i<$levelrows; $i++){
            echo "[";
            for($j = 0; $j<$levelcols; $j++){
                echo "'".$levelgrid[$i][$j]."'";
                if($j+1 != $levelcols){
                    echo ",";
                }
            }
            if($i+1 == $levelrows){
                echo "]";
            }else{
                echo "],";
            }
        }
        echo "]; ";
        echo " LoadGrid(levelgrid);";

        echo " document.getElementById('levelName').value = "."'$HL_mapname';";
        echo " document.getElementById('authorName').value = "."'$HL_author';";

        fclose($lvlfile);
    }

    function SaveLevel()
    {
        //Map info
        $g = $_POST['grid_layout'];
        $levelName = $_POST["levelName"];
        $authorName = $_POST["authorName"];
        $x = (int)$_POST['x'];
        $y = (int)$_POST['y'];

        //Map details
        $up = $_POST["up"];
        $down = $_POST["down"];
        $left = $_POST["left"];
        $right = $_POST["right"];
        
        $for = $_POST["for"];
        $while = $_POST["while"];
        $if = $_POST["if"];

        $cup = $_POST["cup"];
        $cdown = $_POST["cdown"];
        $cleft = $_POST["cleft"];
        $cright = $_POST["cright"];
        $cself = $_POST["cself"];
        $celse = $_POST["celse"];


        $all = str_replace("!", "\n", $g);
        $lines = explode("\n", $all);
        
        $lvl = "$levelName:$authorName:$up.$down.$right.$left:$for.$while.$if.0.0:$cup.$cdown.$cright.$cleft.$cself.$celse:n\n";
        
        for ($i=0; $i < count($lines); $i++) 
        { 
            $element = explode(':', $lines[$i]);

            for ($l=0; $l < count($element); $l++) 
            { 
                $lvl .= $element[$l];
                if($l != (count($element) - 1))
                {
                    $lvl .= ":";
                }
            }

            if($i != count($lines) - 1)
            {
                $lvl .= "\n";
            }
        }

        $myfile = fopen("levels/my/$levelName.txt", "w") or die("Unable to open file!");
        fwrite($myfile, $lvl);
        fclose($myfile);
        
        return "$levelName.txt";
    }

    LoadLevel($selected);
    ?>
</script>
</body>
</html>