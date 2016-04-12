    <div id="container">
        <div id="main"> 
            <div class="wrapper">
                <div class="text_wrapper">
                    <h1>Find your perfect partner!</h1>
                    <form id="form">
                        <table>
                            <tr>
                                <td><label class="forlabel">Username:</label></td>
                                <td colspan="2"><input type="text" name="username"></td>
                                <td><label class="error">Username already exists</label></td>
                            </tr>
                            <tr>
                                <td><label class="forlabel">First name:</label></td>
                                <td colspan="2"><input type="text" name="firstname"></td>                                
                            </tr>
                            <tr>
                                <td><label class="forlabel">Last name:</label></td>
                                <td colspan="2"><input type="text" name="secondname"></td>                                
                            </tr>                        
                            <tr>
                                <td><label class="forlabel">Email:</label></td>
                                <td colspan="2"><input type="email" name="secondname"></td>
                                <td><label class="error">Incorrect email</label></td>
                            </tr>                        
                            <tr>
                                <td><label class="forlabel">Password:</label></td>
                                <td colspan="2"><input type="email" name="secondname"></td>
                                <td><label class="error">Password needs more than 2 characters</label></td>
                            </tr>                        
                            <tr>
                                <td><label class="forlabel">Retype password:</label></td>
                                <td colspan="2"><input type="email" name="secondname"></td>
                                <td><label class="error">Passwords don't match</label></td>
                            </tr>                        
                            <tr>
                                <td>I am:</td>
                                <td>                                    
                                    <input id="male" type="radio" name="gender" value="male" checked>
                                    <label for="male">Male </label>
                                   
                                </td>
                                <td>
                                    <input id="female" type="radio" name="gender" value="female">
                                    <label for="female">Female </label>
                                </td>
                            </tr> 
                            <tr>
                                <td>I like:</td>
                                <td>                                    
                                    <input id="male" type="checkbox" name="gender" value="male">
                                    <label for="male">Males </label>
                                   
                                </td>
                                <td>
                                    <input id="female" type="checkbox" name="gender" value="female">
                                    <label for="female">Females </label>
                                </td>
                                <td><label class="error">Please select one</label></td>
                            </tr>                             
                            <tr>
                                <td colspan="3"><input type="submit" name="submit"></td>
                            </tr>
                        </table>
                    </form>
                    <div id="personalityTest">
                        <?php 
                            $this->load->view('questions');
                        ?>                    
                    </div>
                    <p>
                        Congratulations, you are one step closer to finding your partner.
                    </p>                    
                </div>                
            </div>
        </div>        
    </div>

</body>
</html>