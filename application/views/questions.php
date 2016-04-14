                    <div class="text_wrapper">
                        <h1>Do the personality test!</h1>
                        <p>By searching your personality type we can give you better results by giving people that match your personality.</p>
                        <p>Select your answers by clicking the corresponing text.</p>

                            <?php loadQuestions();?>
                        <p>
                        </p>
                    </div>


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
                        echo "<input required id=\"{$id}\" type=\"radio\" name=\"{$question}\" value=\"{$char}\"". set_radio($question, $char, ($char == "c")). ">";
                        echo "<p><label for=\"{$id}\">{$text}</label></p></br>";
                    }   
                echo '<hr></div>';
            }            
        }
    }


?>