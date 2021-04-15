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

        <p><?= $message ?></p>
        <br>
        <form action="<?= url("/yatzy/roll") ?>" method="post">
            <?php foreach ($rolled as $key => $value) { ?> 
                <label for="<?= $key ?>"> <?= $value ?> </label>
                <input type="checkbox" name="<?= $key ?>" value="<?= $value?> ">
                <br>
                
            <?php } ?>
            <br>
            <input type="submit" value="Kasta om resten">
            
        </form>
        <br>

        <h2> Nuvarande score: <?= $score ?> </h2>

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
                                
                                    <input type="radio" name="values" id="<?= $key ?>">
                                    <label for="<?= $key ?>"></label><br>
                                <?php } ?>
                            <?php } ?> 
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <input type="submit" value="Välj">
        </form>
    </div>

</div>


