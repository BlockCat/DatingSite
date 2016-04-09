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
	<title>Welcome to Dates</title>	
</head>
<body>
    <?php
        //load header
        $this->view('header');
    ?>
    <div id="container">
        <div id="main"> 
            <div class="wrapper">
                <div class="flashy_wrapper">
                    <h1>Find your perfect partner!</h1>
                    <p>
                        So you want to find the perfect partner?
                        At Dates you'll find your parnter in a matter of minutes.                        
                    </p>
                    <h3>
                        <a href="register">Go to our exclusive test here &#8594;</a>
                    </h3>
                </div>                
            </div>
        </div>
        <div id="info">
            <div class="wrapper">
                <div class="text_wrapper">
                    <h2>Why us?</h2>
                    <p>
                        Our speciality is that our dating paradigms are based on unique and scientific studies about matching, 
                        taking both personality and lifestyle in the equation and 
                        continues reinforcement learning based on preferences of the user themselves to optimize their experience.
                        This technique has been tested in the real world and has proven itself to be very reliable. 
                        However, we can still do better. Our algorithm builds on this with our "playing field changing" technologie.
                    </p>
                </div>
                <div class="text_wrapper">
                    <h2>With us, you are safe</h2>
                    <p>
                        Our experts have build this site so that not even a single malicious byte is send or received without us detecting it. Moreover, your data is securely encrypted by the latest hashing technologies.
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>