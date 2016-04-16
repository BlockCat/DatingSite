
    <div class="wrapper">
        <div class="flashy_wrapper">
            <?php echo validation_errors(); ?>
            <form id="form" method='post' action="<?php base_url('search');?>">
                Gender: <label for="genderm">Male</label> <input id="genderm" type="radio" name="gender" value="m" <?php echo set_radio('gender', $gender == 'm')?>>,
                <label for="genderv">Female</label><input id="genderv" type="radio" name="gender" value="v"<?php echo set_radio('gender', $gender == 'v')?>><br>
                Preference:
                <label for="preferencem">Males</label><input id="preferencem" type="checkbox" name="preference" value="m">,
                <label for="preferencev">Females</label><input id="preferencev" type="checkbox" name="preference" value="v"><br>
                Minimum preferred age: <input type="number" name="minage" value="<?php echo set_value('minage', $minage)?>"></br>
                Maximum preferred age: <input type="number" name="maxage" value="<?php echo set_value('maxage', $maxage)?>"></br>
                Amount of extrovert: <input type="number" name="e" value="<?php echo set_value('e', $prefpersonality['e'])?>"></br>
                Amount of intuitive: <input type="number" name="n" value="<?php echo set_value('n', $prefpersonality['n'])?>"></br>
                Amount of thinking: <input type="number" name="t" value="<?php echo set_value('t', $prefpersonality['t'])?>"></br>
                Amount of feeling : <input type="number" name="f" value="<?php echo set_value('f', $prefpersonality['f'])?>"></br>
                <table id="brandTable" cellspacing="0" cellpadding="0">
                    <?php loadBrands($brands);?>
                </table>
                <input type="submit">

            </form>

        </div>
    </div>
