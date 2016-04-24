<div id="main">
    <div class="wrapper">
        <div class="flashy_wrapper">
                <?php echo validation_errors(); ?>
            <form id="form" method='post' action="<?php site_url('search');?>">

                Gender: <label for="genderm">Male</label> <input id="genderm" type="radio" name="gender" value="m" <?php echo set_radio('gender', 'm', $gender == 'm')?>>,
                        <label for="genderv">Female</label><input id="genderv" type="radio" name="gender" value="v"<?php echo set_radio('gender', 'v', $gender == 'v')?>><br>
                Preference:
                        <label for="preferencem">Males</label><input id="preferencem" type="checkbox" name="preference[]" value="m" <?php echo set_checkbox('preference[]', 'm', ($sexpref == 'm' || $sexpref=='b'))?>>,
                        <label for="preferencev">Females</label><input id="preferencev" type="checkbox" name="preference[]" value="v" <?php echo set_checkbox('preference[]', 'v', ($sexpref == 'v' || $sexpref=='b'))?>><br>
                Minimum preferred age: <input type="number" name="minage" value="<?php echo set_value('minage', $minage)?>"></br>
                Maximum preferred age: <input type="number" name="maxage" value="<?php echo set_value('maxage', $maxage)?>"></br>

                Amount of extrovert: <input type="number" name="e" value="<?php echo set_value('e', $prefpersonality['e'] / 10)?>"></br>
                Amount of intuitive: <input type="number" name="n" value="<?php echo set_value('n', $prefpersonality['n'] / 10)?>"></br>
                Amount of thinking: <input type="number" name="t" value="<?php echo set_value('t', $prefpersonality['t'] / 10)?>"></br>
                Amount of feeling : <input type="number" name="f" value="<?php echo set_value('f', $prefpersonality['f'] / 10)?>"></br>
                <input type="hidden" name="search" value="1">
                <table id="brandTable" cellspacing="0" cellpadding="0">
                    <?php loadBrands($brands, $selectedBrands);?>
                </table>

                <input type="hidden" value="0" name="page" id="page">
                <input type="submit">

            </form>

        </div>
    </div>
</div>


<?php
function loadBrands($brands, $selectedBrands)
{
    $index = 0;
    echo '<tr>';
    $nsbrands = array();
    if (count($selectedBrands) > 0) {
        foreach ($selectedBrands as $k => $v) {
            $nsbrands[$k] = $v['brand'];
        }
    }
    foreach ($brands as $entry) {
        $name = $entry['brandName'];
        $value = $name;//strtolower(trim($name, ' '));
        echo "<td>";
        echo '<div>';

        echo "<input id='brand_{$name}' type='checkbox' name='brands[]' value='{$value}' ".set_checkbox('brands', $value, in_array($value, $nsbrands)).">";
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