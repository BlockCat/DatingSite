<?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        echo "Logged in";
        
    } else {            
?>
    <div class="header">
        
        <div id="header_content">            
            <button>Log in now!</button>
            <button>Info!</button>
            <button>Safety!</button>
        </div>
    </div>

<?php 
    }
?>