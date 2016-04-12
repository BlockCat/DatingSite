    
<div class="text_wrapper" >
    <h1>You have done the test!</h1>      
    <p> These are the results:</p>
    
    <?php display($E, $N, $T, $J); ?>
</div>                    

<?php
    function display($E, $N, $T, $J) {
        $E = $E / 10;
        $N = $N / 10;
        $T = $T / 10;
        $J = $J / 10;
        echo "<p>You are {$E}% ";
        if ($E <= 50) {
            echo "Extrovert";
        } else {
            echo "Introvert";
        }
        echo "</p>";
        echo "<p>You are {$N}% ";
        if ($N <= 50) {
            echo "Intuitive";
        } else {
            echo "Sensing";
        }
        echo "</p>";
        echo "<p>You are {$T}% ";
        if ($N <= 50) {
            echo "Thinking";
        } else {
            echo "Feeling";
        }
        echo "</p>";
        echo "<p>You are {$J}% ";
        if ($N <= 50) {
            echo "Judging";
        } else {
            echo "Perceiving";
        }
        echo "</p>";
    }


?>