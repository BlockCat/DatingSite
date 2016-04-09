<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <?php 
        $this->load->helper('html');
        echo link_tag('css/main.css');
        echo script_tag('js/jquery.js');
    ?>
	<title>Login</title>	
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
                    <h1>Log in: </h1>
                    <form id="form">
                        <table>
                            <tr>
                                <td><label>Username:</label></td>
                                <td colspan="2"><input type="text" name="username"></td>
                            </tr>
                            <tr>
                                <td><label>Password:</label></td>
                                <td colspan="2"><input type="text" name="password"></td>
                            </tr>                            
                            <tr>
                                <td>Remember me:</td>
                                <td>                                    
                                    <input type="checkbox" name="remember" value="remember">
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