<?php    
	defined('BASEPATH') OR exit('No direct script access allowed');	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<?php 
        $this->load->helper('html');
        $this->load->helper('url');
        echo link_tag('css/main.css');
        echo script_tag('js/jquery.js');
    ?>
</head>
<body>	
    <div class="header">
        <div id="header_content"> 
		<?php
		if(!isset($_SESSION['loggedIn'])){
            $loginUrl = base_url('login');
            $registerUrl = base_url('register');
            $searchUrl = base_url('search');
            $homeUrl = base_url('/');
            echo "<a href='$loginUrl'><button>Sign in</button></a>";
            echo "<a href='$registerUrl'><button>Create account</button></a>";
            echo "<a href='$searchUrl'><button>Search</button></a>";
            echo "<a href='$homeUrl'><button>Home</button></a>";
		}
		else{
            $signoutUrl = base_url('signout');
            $profileUrl = base_url('ownprofilepage');
            $searchUrl = base_url('matching');
			$adminUrl = base_url('admin');
            $homeUrl = base_url('/');
			echo "<a href='$signoutUrl'><button>Sign out</button></a>";
			if($_SESSION['userAdmin'] == 1){
				echo "<a href='$adminUrl'><button>admin</button></a>";
			}
			echo "<a href='$searchUrl'><button>Matching</button></a>";
            echo  "<a href='$profileUrl'><button>My profile</button></a>";
            echo "<a href='$homeUrl'><button>Home</button></a>";
		}
		?>
        </div>
    </div>