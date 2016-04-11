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
            echo '<a href="./login"><button>Sign in</button></a>';			
            echo '<a href="./register"><button>Create account</button></a>';
            echo '<a href="./"><button>Home</button></a>';
		}
		else{
			echo '<a href="./signout"><button>Sign out</button></a>';
		}
		?>
        </div>
    </div>