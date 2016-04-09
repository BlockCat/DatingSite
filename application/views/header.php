<?php    
    session_start();
    
?>
    <div class="header">
        <div id="header_content">            
<?php
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1){
        echo "Logged in: ";        
        if (isset($_SESSION['username'])) echo $_SESSION['username'];
?>
            <a href="./login"><button>Log out!</button></a>
            
            <script>
                function logout() {
                    $.post("login/logout", function() {
                        location.href = "./";
                    });
                }
            </script>
<?php
    } else {            
?>            
            <button>Info!</button>
            <button>Safety!</button>
            <a href="./register"><button>Register now!</button></a>
            <a href="./login"><button>Login now!</button></a>
<?php 
    }
?>
        </div>
    </div>