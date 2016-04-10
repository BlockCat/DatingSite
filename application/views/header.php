<?php    
	defined('BASEPATH') OR exit('No direct script access allowed');	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php 
        $this->load->helper('html');
        echo link_tag('css/main.css');
        echo script_tag('js/jquery.js');
    ?>
</head>
<body>	
    <div class="header">
        <div id="header_content"> 
		<?php
		if(!isset($_SESSION['loggedIn'])){			
            echo '<a href="./register"><button>Register now!</button></a>';
            echo '<a href="./login"><button>Login now!</button></a>';
		}
		?>
        </div>
    </div>