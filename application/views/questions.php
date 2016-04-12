    <div id="container">
        <div id="main"> 
            <div class="wrapper">
                <div class="text_wrapper">
                    <h1>Do the personality test!</h1>
                    <p>Select your answers by clicking the corresponing text.</p>
                    <form id="form">                        
                        <?php loadQuestions();?>
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

<?php
    function loadQuestions() 
    {
        
        $string = file_get_contents("./js/questions.json");
        $json_a = json_decode($string, true );        
        foreach ($json_a as $category => $questions) 
        {
            echo "<h1>{$category}</h1>";
            
            foreach($questions as $question => $entry) {
                echo '<div class="question">';
                    foreach($entry as $char => $text) {
                        $id = $question .''.$char;                    
                        echo "<input required id=\"{$id}\" type=\"radio\" name=\"{$question}\" value=\"{$char}\">";
                        echo "<p><label for=\"{$id}\">{$text}</label></p></br>";
                    }   
                echo '<hr></div>';
            }
            /**/           
            
            
        }
    }


?>