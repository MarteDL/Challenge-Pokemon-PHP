<?php








?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="index.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">
    <title>Pokedex</title>
</head>
<body>

<img id="logo" src="imgs/pokedex.png" alt="pokedex-logo">
<div class="container">
    <div class="search-wrapper">
        <div class="input-container">
            <label for="pokemon-id"></label>
            <input type="text" name="pokemon-id" id="pokemon-id" placeholder="Pokemon ID or Name"/>
        </div>
    </div>
    <div id="tpl-pokemon">
        <ul>
            <div class="pokemon-wrapper">
                <li class="pokemon">
                    <h4 class="title">
                        <em class="ID-number"></em>
                        <strong class="name"></strong>
                    </h4>
                    <img id="img-pokemon" src="" class="hidden" alt="pokemon">
                </li>
                <li id="moves" class="hidden">
                    <h4>Moves</h4>
                    <div id="get-moves"></div>
                </li>
                <div class="right-container">
                    <li id="all-evolutions" class="hidden">
                        <h4>Evolutions</h4>
                        <div id="evolution-images" class="hidden">
                            <div id="evolution0">
                                <img src="" alt="evolution">
                            </div>
                            <div id="evolution1">
                                <img src="" alt="evolution">
                            </div>
                            <div id="evolution2">
                                <img src="" alt="evolution">
                            </div>
                            <div id="evolution3">
                                <img src="" alt="evolution">
                            </div>
                        </div>
                        <div class="hidden" id="extra-evolutions">
                        </div>
                    </li>
                </div>
            </div>
        </ul>
    </div>
</div>

</body>
</html>