<?php

/**
 * View to play yazty!
 */

declare(strict_types=1);

use function Mos\Functions\url;

$header = $header ?? null;
$message = $message ?? null;

?>

<div class="container"> 

    <div class = "left"> 
        <h1><?= $header ?></h1>

        <p><?= $message ?> <?= 3-$thisround ?></p>
        <br>
        <form action="<?= url("/yatzy/roll") ?>" method="post">
            <?php foreach ($rolled as $key => $value) { ?> 
                <label for="<?= $key ?>"> <?= $value ?> </label>
                <?php if ($thisround < 3) { ?>
                    <input type="checkbox" name="<?= $key ?>" value="<?= $value?> ">
                <?php } ?>
                <br>
                
            <?php } ?>
            <br>
            <?php if ($thisround < 3 && $gameover != true ) { ?>
            <input type="submit" value="Kasta om resten">

            <?php } else if ($gameover == true) { ?>
                <p> Omgången är över. Resultatet är <?= $score ?> </p>
            <?php } else {?>
            <p> Inga slag kvar, välj hur du vill bokföra slagen till höger </p>
            <?php } ?>
        </form>
        <br>

        <p> <?php if ($yatzy) {?> YATZY <?php } ?></p>
    </div>

    <div class = "right"> 
        <br>
        <form action="<?= url("/yatzy/save") ?>" method="post">
            <table>
                <tr>
                    
                    <th>  </th>
                    <th> Summa </th>
                    <th> Valbara </th>
                    
                </tr>
                <?php foreach ($scoreboard as $key => $value) { ?> 
                    <tr>
                        <td> <?= $key ?> </td>
                        <td> 
                            <?php if (isset($value)) { ?>
                                <?= $value ?>
                            <?php } ?>
                        </td>
                        <td> 
                            <?php if (is_null($value)) { ?>
                                <?php if ($key != "yatzy" && $key != "bonus") { ?>
                                
                                    <input type="radio" name="values" value="<?= $key ?>">
                                    <label for="<?= $key ?>"></label><br>
                                <?php } ?>
                            <?php } ?> 
                        </td>
                    </tr>
                <?php } ?>
                <?php foreach ($scoreextra as $key => $value) { ?> 
                    <tr>
                       <td> <?= $key ?> </td>
                    </tr>
                <?php } ?>
            </table>
            <?php if ($gameover != true) { ?>
                <input type="submit" value="Välj">

            <?php } ?>
        </form>
    </div>

</div>


