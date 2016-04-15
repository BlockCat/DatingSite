    <div id="container">
        <div id="main"> 
            <div class="wrapper">
                <div class="text_wrapper">
                    <h1>Find your perfect partner!</h1>
                        <?php echo form_open('register', array('id' => 'form'));?>
                        <table>
                            <tr>
                                <td><label class="forlabel">Username:</label></td>
                                <td colspan="2"><input type="text" name="username" value="<?php echo set_value('username'); ?>" ></td>
                                <td><div class="error"><?php echo form_error('username'); ?></div></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">First name:</label></td>
                                <td colspan="2"><input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>" ></td>
                                <td><div class="error"><?php echo form_error('firstname'); ?></div></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">Last name:</label></td>
                                <td colspan="2"><input type="text" name="lastname" value="<?php echo set_value('lastname'); ?>" ></td>
                                <td><label class="error"><?php echo form_error('lastname'); ?></label></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">Email:</label></td>
                                <td colspan="2"><input type="email" name="email" value="<?php echo set_value('email'); ?>" ></td>
                                <td><label class="error"><?php echo form_error('email'); ?></label></td>
                            </tr>                        
                            <tr>
                                <td><label class="forlabel">Password:</label></td>
                                <td colspan="2"><input type="password" name="password" ></td>
                                <td><label class="error"><?php echo form_error('password'); ?></label></td>
                            </tr>                        
                            <tr>
                                <td><label class="forlabel">Retype password:</label></td>
                                <td colspan="2"><input type="password" name="passwordconfirmation"></td>
                                <td><label class="error"><?php echo form_error('passwordconfirmation'); ?></label></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">Profile picture:</label></td>
                                <td colspan="2"><input type="file" name="profilepicture" ></td>
                                <td><label class="error"><?php echo form_error('profilepicture'); ?></label></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">Birthdate:</label></td>
                                <td colspan="2"><input type="date" name="date" value="<?php echo set_value('date'); ?>"></td>
                                <td><label class="error"><?php echo form_error('date'); ?></label></td>
                            </tr>
                            <tr>
                                <td>I am:</td>
                                <td>                                    
                                    <input id="male" type="radio" name="gender" value="m" <?php echo set_radio('gender', 'm', TRUE);?>>
                                    <label for="male">Male </label>
                                   
                                </td>
                                <td>
                                    <input id="female" type="radio" name="gender" value="v" <?php echo set_radio('gender', 'v');?> >
                                    <label for="female">Female </label>
                                </td>
                            </tr> 
                            <tr>
                                <td>I like:</td>
                                <td>                                    
                                    <input id="male" type="checkbox" name="attraction" value="male" <?php echo set_checkbox('attraction', 'male');?>>
                                    <label for="male">Males </label>
                                   
                                </td>
                                <td>
                                    <input id="female" type="checkbox" name="attraction" value="female" <?php echo set_checkbox('attraction', 'female');?>>
                                    <label for="female">Females </label>
                                </td>
                                <td><label class="error"><?php echo form_error('attraction'); ?></label></td>
                            </tr>                             
                            <tr>
                            <tr>
                                <td><label class="forlabel">Minimum age preference:</label></td>
                                <td colspan="2"><input type="number" name="minAge" value="<?php echo set_value('minAge', 18); ?>"></td>
                                <td><label class="error"><?php echo form_error('minAge'); ?></label></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">Maximum age preference:</label></td>
                                <td colspan="2"><input type="number" name="maxAge" value="<?php echo set_value('maxAge', 99); ?>"></td>
                                <td><label class="error"><?php echo form_error('maxAge'); ?></label></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">Description:</label></td>
                                <td colspan="2" rowspan="4">
                                    <textarea cols="40" rows="4" type="text" name="description" placeholder="Write a description about yourself, this should have at least 100 characters"><?php echo set_value('description'); ?></textarea></td>
                                <td><label class="error"><?php echo form_error('description'); ?></label></td>
                            </tr>

                            </tr>
                        </table>
                    <div id="brandsTest">
                        <?php
                        echo $brands;
                        ?>
                    </div>
                    <div id="personalityTest">
                        <?php
                            echo $questions;
                        ?>
                    </div>

                    <input type="submit" name="submit">
                    </form>

                    <p>
                        Congratulations, you are one step closer to finding your partner.
                    </p>                    
                </div>                
            </div>
        </div>        
    </div>

</body>
</html>