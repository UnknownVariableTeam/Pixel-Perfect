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
        <svg viewBox="0 0 160 20">
            <text x="0" y = "12" fill="#444" >Custom level menu</text>
        </svg>
        <form action="game.php" method="post">
        <?php            
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
                echo "LVL:<br/> <select name='customname' id='customname'>";
    
                for ($i=0; $i < count($files); $i++) 
                {
                    $name = substr($files[$i], 0, -4);
    
                    echo "<option value='$name'>$name</option>";
                }
                echo "</select>";    
            }else{
                return;
            }
        ?>
        <input type="submit" value="Play" id="Play">
    </form>
    <form action="index.php" method="post">
        <script>
        function DeleteFile()
        {
            document.getElementById("hiddenname").value = document.getElementById("customname").value;
        }
        </script>
        <input type="submit" value="Delete" id="Delete" onclick="DeleteFile();">
        <input type="hidden" name="hiddenname" id="hiddenname">
    </form>
    </div>
    <script>
        var mainS = new Audio('audio/ost/menu0.mp3');
        mainS.volume = 0.6;
        mainS.loop =true;
        mainS.play();
    </script>
</body>
</html>