	<div id="container">
        <div id="main"> 
            <div class="wrapper">
                <div class="text_wrapper">
                    <h1>Log in:</h1>
                     <?php
 					    /*if(isset($_SESSION['triedlogin'])){
 							echo "<h1>We could not validate you, try to login again:</h1>";
 						}
 						else{
 							echo "<h1>Log in:</h1>";

 						}
                        */
 					?>
                    <?php echo form_error('submit');?>
                     <form method="post" id="form" accept-charset="utf-8"/>
                        <table id="loginform">
                            <tr>
                                <td><label class="forlabel">Email:</label></td>
								<td colspan="2"><input type="text" id="email" placeholder="example@example.com" name="email" value="<?php echo set_value('email'); ?>"></td>
                                <td><label class="error"><?php echo form_error('email')?></label></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">Password:</label></td>
                                <td colspan="2"><input type="text" id="password" placeholder="**********" name="password"></td>
                                <td><label class="error"><?php echo form_error('password')?></label></td>
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