<?php
$besked = "Email sent from the Email Reporting Widget: \n 
***************************************************************************
*********              Project and access information               *******
***************************************************************************

Student name: " .  utf8_decode($_POST['userID']). "
Project name: " . utf8_decode($_POST['projectName']). "
Date completed: " . $_POST['dateCompleted']. "
Time completed: " . $_POST['timeCompleted']. "
Total time spent in course: " . $_POST['timeSpent']. " 

***************************************************************************
*********                 Quizzing Information                      *******
***************************************************************************

Quiz score in percent: " . $_POST['quiz_user_quiz_percentage']. "
Total Points Scored: " . $_POST['quiz_user_scored_points']. "
Total Points Available: " . $_POST['quiz_total_available_points']. "
Points needed for a pass: " . $_POST['quiz_points_needed_for_a_pass']. "

Number of quiz attempts: " . $_POST['quizAttempts']. "
Total number of quiz questions: " . $_POST['quizQuestions']. "
Total number of correct answers: " . $_POST['quizCorrect']. "
Total number of unanswered questions: " . $_POST['quizUnanswered']."
";

if(isset($_POST['sendCustomVars']) && (strcasecmp($_POST['sendCustomVars'], 'true') == 0)) {
$besked .= "
***************************************************************************
*********                   Custom Variables                        *******
***************************************************************************

Custom variable 1: " . utf8_decode($_POST['custom1']). "
Custom variable 2: " . utf8_decode($_POST['custom2']). "
Custom variable 3: " . utf8_decode($_POST['custom3']). "
Custom variable 4: " . utf8_decode($_POST['custom4']). "
Custom variable 5: " . utf8_decode($_POST['custom5']). "
Custom variable 6: " . utf8_decode($_POST['custom6']). "
Custom variable 7: " . utf8_decode($_POST['custom7']). "
Custom variable 8: " . utf8_decode($_POST['custom8']). "
Custom variable 9: " . utf8_decode($_POST['custom9']). "
Custom variable 10: " . utf8_decode($_POST['custom10']). "
Custom variable 11: " . utf8_decode($_POST['custom11']). "
Custom variable 12: " . utf8_decode($_POST['custom12']). "
Custom variable 13: " . utf8_decode($_POST['custom13']). "
Custom variable 14: " . utf8_decode($_POST['custom14']). "
Custom variable 15: " . utf8_decode($_POST['custom15']). "
Custom variable 16: " . utf8_decode($_POST['custom16']). "
Custom variable 17: " . utf8_decode($_POST['custom17']). "
Custom variable 18: " . utf8_decode($_POST['custom18']). "
Custom variable 19: " . utf8_decode($_POST['custom19']). "
Custom variable 20: " . utf8_decode($_POST['custom20']). "
Custom variable 21: " . utf8_decode($_POST['custom21']). "
Custom variable 22: " . utf8_decode($_POST['custom22']). "
Custom variable 23: " . utf8_decode($_POST['custom23']). "
Custom variable 24: " . utf8_decode($_POST['custom24']). "
Custom variable 25: " . utf8_decode($_POST['custom25']). "
Custom variable 26: " . utf8_decode($_POST['custom26']). "
Custom variable 27: " . utf8_decode($_POST['custom27']). "
Custom variable 28: " . utf8_decode($_POST['custom28']). "
Custom variable 29: " . utf8_decode($_POST['custom29']). "
Custom variable 30: " . utf8_decode($_POST['custom30']);
}

$fields = array(
    "interactionID" => array("Interaction ID", ""),
    "questionText" => array("Question Text", ""),
    "interactionType" => array("Interaction Type", ""),
    "curDateAsString2" => array("Current Date", ""),
    "curTimeAsString" => array("Current Time", ""),
    "latencyAsString" => array("Latency for question", ""),
    "isQuestionSkipped" => array("Question was skipped", ""),
    "answeredCorrectly" => array("Question answered correctly", ""),
    "chosenAnswersAsString" => array("Users answer", ""),
    "correctAnswersAsString" => array("Correct answer", ""),
    "numTries" => array("Number of tries", ""),
    "weighting" => array("Points for question", "")
);

// reset variables - scope will reach variables above
function reset_question($fields) {
        foreach($fields as $value) {
                $value[1] = "";
        }
}
function advance($str, $delim, $pos, &$token) {
        $nextpos = strpos($str, $delim, $pos+1);
        if($nextpos) {
                $token = substr($str, $pos+1, $nextpos - $pos - 1);
                $nextpos += strlen($delim) - 1;
        }
        return $nextpos;
}
# Name  Character       Unicode code point (decimal)    Standard        Description
# quot  "       U+0022 (34)     XML 1.0         double quotation mark
# amp   &       U+0026 (38)     XML 1.0         ampersand
# apos  '       U+0027 (39)     XML 1.0         apostrophe (= apostrophe-quote)
# lt    <       U+003C (60)     XML 1.0         less-than sign
# gt    >       U+003E (62)     XML 1.0         greater-than sign
function normaliseXML($str) {
        return str_replace('&quot;', '"',
                        str_replace('&amp;', '&',
                        str_replace('&apos;', "'",
                        str_replace('&lt;', '<',
                        str_replace('&gt;', '>', $str)))));
}

if(isset($_POST['sendQuizData']) && (strcasecmp($_POST['sendQuizData'], 'true') == 0)) {
$besked .= "

***************************************************************************
********* Quiz / Interaction Data *******
***************************************************************************
";

$quizdata = $_POST['quizData'];
$question = '';
$qpos = -1;
while(true) {
        reset_question($fields); // reset variables
        $qpos = advance($quizdata, '<question>', $qpos, $question); // go to next <question>
        if($qpos) {
                $qpos = advance($quizdata, '</question>', $qpos, $question); // extract question fragment
        }
        if(!$qpos) {
                break;
        }
        
        $pos = -1;
        $tag = '';
        $token = '';
        // !Important! - this does NOT handle self-closing tags nor opening tags with attributes
        while(($pos = advance($question, '<', $pos, $token)) && ($pos = advance($question, '>', $pos, $token))) {
                $tag = $token;
                if(($pos = advance($question, "</$tag>", $pos, $token)) && array_key_exists($tag, $fields)) {
                        $fields[$tag][1] = normaliseXML($token);
                }
        }

        foreach($fields as $value) {
                $besked .= "\n" . $value[0] . ": " . $value[1];
        }
        $besked .= "\n";
} // while
} // if sendQuizData

// You can move the variables around in the PHP file so that they are in your own prefered order. However you need to take extra notice of the "Custom variable 30" as that 
// have a different finished code that the others in the PHP file. The last variable you are display NEED to end like ]; - all other variables need to end like ]. " 
 
 
// No need to edit anything below this line 
 
// e-mail recipient
$recipient = utf8_decode($_POST['recipient']);
 
// e-mail subject
$subject = utf8_decode($_POST['subject']);
 
// e-mail sender
$sender = utf8_decode($_POST['email']);
 
// send e-mailen
mail($recipient, $subject, $besked, "From: $sender");
?>
