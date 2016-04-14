	<div id="container">
        <div id="main"> 
            <div class="wrapper">
                <div class="text_wrapper">
                    <h1>Log in!</h1>
                    <p >
                        <?php
                            if ($triedlogin) {
                                echo "We could not log you in, please try again ";
                            }
                        ?>
                    </p>
                    <?php echo form_open('login', array('id' => 'form'))?>
                        <table id="loginform">
                            <tr>
                                <td><label class="forlabel">Email:</label></td>
                                <td colspan="2"><input type="text" id="email" placeholder="example@example.com" value="<?php echo set_value('email')?>" name="email"></td>
                                <td><div class="error"><?php echo form_error('email')?></div></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">Password:</label></td>
                                <td colspan="2"><input type="text" id="password" placeholder="**********" name="password"></td>
                                <td><div class="error"><?php echo form_error('password')?></div></td>
                            </tr>
							<tr>
                                <td colspan="3"><input type="submit" name="submit"></td>
                            </tr>
                        </table>
                    </form>                   
                </div>                
            </div>
        </div>        
    </div>
</body>
</html>