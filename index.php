<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel-Perfect</title>
    <link rel="stylesheet" href="style-titlescreen.css">
    <link rel="icon" href="textures\logo.png"/>
    <link rel="stylesheet" href="font.css">
</head>
<body>
    <?php
        $savefile = fopen("save/save.txt", "r");
        $save = fgets($savefile);
        fclose($savefile);
        if($save == ""){
            $save = 1;
        }

        if(isset($_POST["hiddenname"]))
        {   
            $name = $_POST["hiddenname"];
            unlink("./levels/my/$name.txt");
        }
    ?>
    <div id="title-screen">
        <a href="game.php?levelindex=<?php echo $save ?>" title="Level: <?php echo $save ?>"></a>
        <a href="mapmenu.php"></a>
        <a href="mapedit.php"></a>
        <a href="credits.html"></a>
        <a href="custom.php">
            <svg viewBox="0 0 130 50">
                <text  x="7" y="31" fill="grey">Custom Maps</text>
            </svg>
        </a>
    </div>
    <script>
        var mainS = new Audio('audio/ost/menu0.mp3');
        mainS.volume = 0.6;
        mainS.loop =true;
        mainS.play();
    </script>
</body>
</html>