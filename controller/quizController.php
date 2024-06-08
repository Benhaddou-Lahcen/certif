<?php
$action = $_GET['action'];
switch( $action ) 
{
    case 'post':
        $jsonFile = '../quiz-data/quiz-fullstack-webdev.json';

        // Read the file contents into a string
        $jsonString = file_get_contents($jsonFile);
        
        // Decode the JSON string into a PHP array
        $data = json_decode($jsonString, true);
        
        // Check if the decoding was successful
        if ($data === null) {
            echo "Error decoding JSON.";
            exit;
        };
        $score = 0;
        for ($i = 1; $i <= 30; $i++)
        {
            $question = $data["quiz-fullstack-webdev"]["questions"][$i - 1];
            
            if (isset($_POST["Q{$i}"]) && $_POST["Q{$i}"] == $question[($question["type"] == "scq" ? "answer" : "answers")]) {
                // echo "Q{$i} is correct<br>";
                $score++;
            }
            else 
            {
                // echo "user answer: ".$_POST["Q{$i}"]."<br>";
                // echo "correct answer: ".$question[($question["type"] == "scq" ? "answer" : "answers")]."<br>";
            }
        };
        $score = round($score * 10 / 3);
        if ($score >= 80) {
            header("Location:../certificate.php?score=".$score);
        } else {
            header("Location:../quiz-failed.php?score=".$score);
        };
        break;
    default:
        echo 'something went wrong';
        
}