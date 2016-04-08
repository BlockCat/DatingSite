<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <?php 
        $this->load->helper('html');
        echo link_tag('css/main.css');
    ?>
	<title>Register</title>	
</head>
<body>
    <?php
        //load header
        $this->view('header');
    ?>
    <div id="container">
        <div id="main"> 
            <div class="wrapper">
                <div class="text_wrapper">
                    <h1>Find your perfect partner!</h1>
                    <form id="register_form">
                        <table>
                            <tr>
                                <td><label>First name:</label></td>
                                <td colspan="2"><input type="text" name="firstname"></td>
                            </tr>
                            <tr>
                                <td><label>Last name:</label></td>
                                <td colspan="2"><input type="text" name="secondname"></td>
                            </tr>                        
                            <tr>
                                <td><label>Email:</label></td>
                                <td colspan="2"><input type="email" name="secondname"></td>
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
                                <td colspan="3"><input type="submit" name="submit"></td>
                            </tr>
                        </table>
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