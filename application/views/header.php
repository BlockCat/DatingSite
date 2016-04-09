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
            <button onclick="logout();">Log out!</button>
            
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
            <button id="login_button" onclick="showLogin();">Log in now!</button>
            <div id="header_login">
                <form id="login_form" method="POST">
                    <label for="input_username">Username:</label><input id="input_username" type="text" name="username">
                    <label for="input_password">Password:</label><input id="input_password" type="text" name="password">
                </form>
                
            </div>
            <div id="error">
                <?php echo session_status(); ?>
            </div>
        
    
    
    <script>
        function showLogin() {
            $("#header_login").show(100);
            $("#login_button").css("background-color", "#FF0343");
            $("#login_button").click(function() {                                
                var username = $("#input_username").val();
                var password = $("#input_password").val();
                $("#error").html("Logging in...");
                $.post("login/loginUser", {'username': username, 'password': password} ,function(data) {
                    console.log(data.state);
                    if (data.state === "success") {
                        //You are now logged in.
                        $("#error").html("Logged in.");
                        location.href = "./";
                        //location.href = "./user";
                    } else if (data.state === "error") {
                        //An error occured while loging in
                        $("#error").html("Error occured.");
                    } else {
                        //Wrong username and or password
                        $("#error").html("Wrong username or password.");
                    }
                    
                }).fail(function() {
                    $("#error").html("Connection timeout.");
                });
            });
        }
    </script>

<?php 
    }
?>
        </div>
    </div>