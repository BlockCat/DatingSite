<hr>
<h1>Select your favourite brands!</h1>
<p>By selecting your favourite brvands we can match you with people with simmilar interests.</p>
<p>Select your answers by clicking the corresponing text.</p>
    <?php echo form_error('brandslist') ?>
    <table id="brandTable" cellspacing="0" cellpadding="0">
        <?php loadBrands($brands);?>
    </table>
<p>
</p>


<?php
    function loadBrands($brands)
    {
        $index = 0;
        echo '<tr>';
        foreach ($brands as $entry) {
            $name = $entry['brandName'];
            $value = $name;//strtolower(trim($name, ' '));
            echo "<td>";
            echo '<div>';
                echo "<input id='brand_{$name}' type='checkbox' name='brandslist[]' value='{$value}' ".set_checkbox('brandslist', $value).">";
                echo "<label for='brand_{$name}'>{$name}</label>";
            echo '</div>';
            echo "</td>";

            $index++;
            if ($index % 4 == 0) {
                echo '</tr><tr>';
            }
        }
        while($index % 4 != 0) {
            echo '</td><td>';
            $index++;
        }

        echo '</td></tr>';
    }


?>