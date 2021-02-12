<?php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['find-pokemon'])) {

    function getPokemon(string $input): array
    {
        return json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $input), true);
    }

    $input = $_GET['pokemon-id'];
    $pokemon = getPokemon($input);
    $pokeName = $pokemon['name'];
    $id = $pokemon['id'];

    function displayPicture(array $pokemon)
    {
        $imgUrl = $pokemon['sprites']['front_default'];
        echo '<img id=img-pokemon src="'. $imgUrl .'" alt="pokemon">';
    }

    function echoMoves(array $pokemon)
    {
        echo '<h4>Moves</h4>
                    <div id="get-moves">';

        $movesArray = $pokemon['moves'];
        shuffle($movesArray);
        $moves = array_slice($movesArray, 0, 4);

        foreach ($moves as $move) {
            echo '<p>' . $move['move']['name'] . '</p>';
        }

        echo '</div> </h4>';

    }

    function findEvolutionsAndDisplayThem(array $pokemon)
    {
        function getSpecies(array $pokemon): array
        {
            $speciesUrl = $pokemon['species']['url'];
            $speciesObject = file_get_contents($speciesUrl);
            return json_decode($speciesObject, true);
        }


        function getEvolutionChain(array $species): array
        {
            $evolutionChainUrl = $species['evolution_chain']['url'];
            $evolutionChainObject = file_get_contents($evolutionChainUrl);
            return json_decode($evolutionChainObject, true);
        }

        $species = getSpecies($pokemon);
        $evolutionChain = getEvolutionChain($species);

        $elementsInArray1 = count($evolutionChain['chain']['evolves_to']);
        $elementsInArray2 = count($evolutionChain['chain']['evolves_to'][0]['evolves_to']);

        $evolution0 = $evolutionChain['chain']['species']['name'];
        $evolution1 = $evolutionChain['chain']['evolves_to'][0]['species']['name'];

        function displayEvolutionPicture($evolutionName)
        {
            $pokemonToDisplay = getPokemon($evolutionName);
            $src = $pokemonToDisplay['sprites']['front_default'];
            echo '
                        <div id='.$evolutionName.'>
                            <img src="' . $src . '" alt="evolution">
                        </div>
                        ';
        }


        if ($elementsInArray1 === 1 && $elementsInArray2 === 0) {

            echo '<h4>Evolutions</h4>
                        <div id="evolution-images">';

            displayEvolutionPicture($evolution0);
            displayEvolutionPicture($evolution1);

            echo '
                        </div>
                        ';
        } else if ($elementsInArray2 === 1) {

            $evolution2 = $evolutionChain['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'];

            echo '<h4>Evolutions</h4>
                        <div id="evolution-images">';

            displayEvolutionPicture($evolution0);
            displayEvolutionPicture($evolution1);
            displayEvolutionPicture($evolution2);

            echo '
                        </div>
                        ';
        } else if ($elementsInArray1 > 1) {

            echo '<h4>Evolutions</h4>
                        <div id="evolution-images">';

            $evolutions = $evolutionChain['chain']['evolves_to'];
            foreach ($evolutions as $evolution) {
                $pokemonName = $evolution['species']['name'];
                displayEvolutionPicture($pokemonName);
            }

            echo ' </div> ';
        }
    }

//    document.getElementById("all-evolutions").querySelectorAll("img").forEach((img, index) => {
//        img.addEventListener("click", () => {
//            document.getElementById("pokemon-id").value = img.id;
//            let event = document.createEvent('KeyboardEvent');
//                event.initEvent('keyup', false, false);
//                document.getElementById("pokemon-id").dispatchEvent(event);
//            })
//        })
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src=""></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Pokedex</title>
</head>
<body>

<img id="logo" src="imgs/pokedex.png" alt="pokedex-logo">
<div class="container">
    <div class="search-wrapper">
        <div class="input-container">
            <label for="pokemonId"></label>
            <form method="GET" action="">
                <input type="text" name="pokemon-id" id="pokemon-id" placeholder="Pokemon ID or Name"/>
                <input class="button" type="submit" name="find-pokemon" value="GO!">
            </form>
        </div>
    </div>
    <div id="tpl-pokemon">
        <ul>
            <div class="pokemon-wrapper">
                <li class="pokemon">
                    <h4 class="title">
                        <em class="ID-number">
                            <?php echo $id ?>
                        </em>
                        <strong class="name">
                            <?php echo $pokeName ?>
                        </strong>
                    </h4>
                    <?php
                    displayPicture($pokemon);
                    ?>
                </li>
                <li id="moves">
                    <?php
                    echoMoves($pokemon);
                    ?>
                </li>
                <div class="right-container">
                    <li id="all-evolutions">
                        <?php
                        findEvolutionsAndDisplayThem($pokemon)
                        ?>
                    </li>
                </div>
            </div>
        </ul>
    </div>
</div>

</body>
</html>