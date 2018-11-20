<!DOCTYPE html>
<html lang=en>
  <head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
      <style>
      body{
        background-color:lightblue;
        font-family: Arial, Helvetica, sans-serif;
        margin:0;
        }
      </style>  
  </head>
<body>
  <div id="navBar">
      <a class="active" href="index.php">Home</a>
      <a href="help.php">Help Page</a>
      <a href="scores.php">High Scores Page</a>
  </div>
    <link rel="stylesheet" type="text/css" href="Index.css">
    <link rel="stylesheet" type="text/css" href="Common.css">
  <?php
      $qNo;
      $option1;
      $option2;
      $option3;
      $is_correct1;
      $is_correct2;
      $is_correct3;
      $is_correct4;
      $is_correct5;
      $score;
      $correct;
      $diff;//difficulty of question.
      $xmlfile="questions.xml";
      $xml= simplexml_load_file("questions.xml") or die("Error: Loading data from xml file");
      $easy=$xml->easy->question;
      $medium=$xml->medium->question;
      $hard=$xml->hard->question;
      $ecounter=0;
      $mcounter=0;
      $hcounter=0;
      $quest=rand(0,24);
      function Question($question)
      {
        $rnd = rand(0,24);
        while($question[$rnd]["answered"]==true)
          $rnd=rand(0,24); 
        $GLOBALS['quest']=$question[$rnd]->name;
        $GLOBALS['option1']=$question[$rnd]->option1;
        $GLOBALS['option2']=$question[$rnd]->option2;
        $GLOBALS['option3']=$question[$rnd]->option3;
        $GLOBALS['answer']=$question[$rnd]->answer;
        $GLOBALS['answered']=true;
      }
      if($_SERVER['REQUEST_METHOD']=='GET')
      {
        echo 
        "<div class=\"container\">
            <h1>Welcome to the Quiz Game</h1>
              <form action=\"\" method=\"post\">
                <img src=\"start.png\" class=\"button\"/>
              <input type=\"submit\" class=\"behind\" name=\"start\"/>
              <input type=\"hidden\" name=\"first\" value=\"true\"/>
              </form>
         </div>
         ";
      }
      else//start of quiz
      {
        if(isset($_POST['quit']) || isset($_POST['retry']))
        {
          echo 
        "<div class=\"container\">
            <h1>Welcome to the Quiz Game</h1>
              <form action=\"\" method=\"post\">
                <img src=\"start.png\" class=\"button\"/>
              <input type=\"submit\" class=\"behind\" name=\"start\"/>
              </form>
         </div>";
        }
        
        if(isset($_POST['save']))
        {
          $f ='highscores.txt';
          $username =$_POST['username']." ";
          $file = fopen($f,'w') or die("En doulefkei...here is my code:<br>f ='highscores.txt';<br>file = fopen($f,'w');");
          $score =$_POST['score']."\n";
          fwrite($file,$username);
          fwrite($file,$score);
          fclose($file);
        }
        if(isset($_POST['start']) || isset($_POST['next']))
        { 
          if($_POST['first']=='true')
          {
            for($i=1;$i<=5;$i++)
              $GLOBALS['is_correct'.$i]=="";
            $_POST['first']=false;
            $GLOBALS['score'] = 0;
            $GLOBALS['diff']="medium";
            Question($GLOBALS['medium']);
            $GLOBALS['qNo']=$_POST['qNo']+1;
            if(isset($_POST['next']) && isset($_POST['answer']))
            {
              echo "<br>answer: ".$_POST['answer']." correct: ".$_POST['correct'];
              //check for correct answer
              if($_POST['answer']==$_POST['correct'])
              {
                for($i=1;$i<=5;$i++)
                  if($_POST['qNo']==$i-1)
                    $GLOBALS['is_correct'.$i]="true";
                if($_POST['diff']=="easy")
                {
                  $GLOBALS['score']=$_POST['score']+5;
                  $_POST['diff']="medium";
                }
                else if($_POST['diff']=="medium")
                {
                  $GLOBALS['score']=$_POST['score']+10;
                  $_POST['diff']="hard";
                }
                else if($_POST['diff']=="hard")
                {
                  $GLOBALS['score']=$_POST['score']+20;
                  $_POST['diff']="hard";
                }
                echo "line 125:".$GLOBALS['score']."<br>";
              }
              else
              {
                for($i=1;$i<=5;$i++)
                  if($_POST['qNo']==$i-1)
                    $GLOBALS['is_correct'.$i]="false";
                 if($_POST['diff']=="easy")
                  $_POST['diff']="easy";
                else if($_POST['diff']=="medium")
                  $_POST['diff']="easy";
                else if($_POST['diff']=="hard")
                  $_POST['diff']="medium";
              }
              $GLOBALS['diff']=$_POST['diff'];
              $GLOBALS['qNo']=$_POST['qNo']+1;
              $GLOBALS['is_correct1']=$_POST['is_correct1'];
              $GLOBALS['is_correct2']=$_POST['is_correct2'];
              $GLOBALS['is_correct3']=$_POST['is_correct3'];
              $GLOBALS['is_correct4']=$_POST['is_correct4'];
              $GLOBALS['is_correct5']=$_POST['is_correct5'];
            }
            //printing radio buttons...
            $str;
            if($GLOBALS['qNo']<5)
              $str="Next";
            else
               $str="Finish";
            echo "<form action=\"\" method=\"post\">
            <p>Question:" .$GLOBALS['qNo']. "/ 5</p>
            <div class=\"center\">
              <h2>".$GLOBALS['quest']."</h2>
              <input type=\"radio\" value=\"".$GLOBALS['option1']."\" name=\"answer\" />".$GLOBALS['option1']."
              <input type=\"radio\" value=\"".$GLOBALS['option2']."\" name=\"answer\" />".$GLOBALS['option2']."
              <input type=\"radio\" value=\"".$GLOBALS['option3']."\" name=\"answer\" />".$GLOBALS['option3']."
              <input type=\"submit\" name=\"next\"  value=\"".$str."\"/>
              <input type=\"submit\" name=\"quit\" value=\"quit\"/>
              
              <input type=\"hidden\" name=\"qNo\" value=\"".$GLOBALS['qNo']."\"/>
              <input type=\"hidden\" name=\"diff\" value=\"".$GLOBALS['diff']."\"/>
              <input type=\"hidden\" name=\"is_correct1\" value=\"".$GLOBALS['is_correct1']."\"/>
              <input type=\"hidden\" name=\"is_correct2\" value=\"".$GLOBALS['is_correct2']."\"/>
              <input type=\"hidden\" name=\"is_correct3\" value=\"".$GLOBALS['is_correct3']."\"/>
              <input type=\"hidden\" name=\"is_correct4\" value=\"".$GLOBALS['is_correct4']."\"/>
              <input type=\"hidden\" name=\"is_correct5\" value=\"".$GLOBALS['is_correct5']."\"/>
              <input type=\"hidden\" name=\"correct\" value=\"".$GLOBALS['answer']."\"/>
              <input type=\"hidden\" name=\"score\" value=\"".$GLOBALS['score']."\"/>
            </div>
           </form>"; 
          }
        else//rest questions
        {
          for($i=1;$i<=5;$i++)
            $GLOBALS['is_correct'.$i]=$_POST['is_correct'.$i];
          $GLOBALS['diff']=$_POST['diff'];
          $GLOBALS['score']=$_POST['score'];
          if($_POST['qNo']<5)
          {
            if($_POST['diff']=="medium")
              Question($GLOBALS['medium']);
            else if($_POST['diff']=="easy")
              Question($GLOBALS['easy']);
            else
              Question($GLOBALS['hard']);
            if(isset($_POST['next']) && isset($_POST['answer']))
            {
              if($_POST['answer']==$_POST['correct'])
              {
                $GLOBALS['is_correct'.$_POST['qNo']]="true";
                if($_POST['diff']=="easy")
                {
                  $GLOBALS['score']=$_POST['score']+5;
                  $_POST['diff']="medium";
                }
                else if($_POST['diff']=="medium")
                {
                  $GLOBALS['score']=$_POST['score']+10;
                  $_POST['diff']="hard";
                }
                else
                {
                  $GLOBALS['score']=$_POST['score']+20;
                  $_POST['diff']="hard";
                }
              }
              else
              {
                $GLOBALS['is_correct'.$_POST['qNo']]="false";
                if($_POST['diff']=="easy")
                  $_POST['diff']="easy";
                else if($_POST['diff']=="medium")
                  $_POST['diff']="easy";
                else
                  $_POST['diff']="medium";
              }
              $GLOBALS['diff']=$_POST['diff'];
              $GLOBALS['qNo']=$_POST['qNo']+1;
            }
            $str;
              if($GLOBALS['qNo']<5)
                $str="Next";
              else
                 $str="Finish";
              echo "<form action=\"\" method=\"post\">
              <p>Question:" .$GLOBALS['qNo']. "/ 5</p>
              <div class=\"center\">
                <h2>".$GLOBALS['quest']."</h2>
                <input type=\"radio\" value=\"".$GLOBALS['option1']."\" name=\"answer\" />".$GLOBALS['option1']."
                <input type=\"radio\" value=\"".$GLOBALS['option2']."\" name=\"answer\" />".$GLOBALS['option2']."
                <input type=\"radio\" value=\"".$GLOBALS['option3']."\" name=\"answer\" />".$GLOBALS['option3']."
                <input type=\"submit\" name=\"next\"  value=\"".$str."\"/>
                <input type=\"submit\" name=\"quit\" value=\"quit\"/>
                
                <input type=\"hidden\" name=\"qNo\" value=\"".$GLOBALS['qNo']."\"/>
                <input type=\"hidden\" name=\"diff\" value=\"".$GLOBALS['diff']."\"/>
                <input type=\"hidden\" name=\"is_correct1\" value=\"".$GLOBALS['is_correct1']."\"/>
                <input type=\"hidden\" name=\"is_correct2\" value=\"".$GLOBALS['is_correct2']."\"/>
                <input type=\"hidden\" name=\"is_correct3\" value=\"".$GLOBALS['is_correct3']."\"/>
                <input type=\"hidden\" name=\"is_correct4\" value=\"".$GLOBALS['is_correct4']."\"/>
                <input type=\"hidden\" name=\"is_correct5\" value=\"".$GLOBALS['is_correct5']."\"/>
                <input type=\"hidden\" name=\"correct\" value=\"".$GLOBALS['answer']."\"/>
                <input type=\"hidden\" name=\"score\" value=\"".$GLOBALS['score']."\"/>
              </div>
             </form>"; 
          }
          else
          {
            if(isset($_POST['quit'])||isset($_POST['retry']))
            {
              echo 
              "<div class=\"container\">
                  <h1>Welcome to the Quiz Game</h1>
                    <form action=\"\" method=\"post\">
                      <img src=\"start.png\" class=\"button\"/>
                    <input type=\"submit\" class=\"behind\" name=\"start\"/>
                    </form>
               </div>";
            }
            if(isset($_POST['next'])&&isset($_POST['answer']))
            {
              if($_POST['answer']==$_POST['correct'])
              {
                $GLOBALS['is_correct'.$_POST['qNo']]="true";
                if($_POST['diff']=="easy")
                {
                  $GLOBALS['score']=$_POST['score']+5;
                  $_POST['diff']="medium";
                }
                else if($_POST['diff']=="medium")
                {
                  $GLOBALS['score']=$_POST['score']+10;
                  $_POST['diff']="hard";
                }
                else
                {
                  $GLOBALS['score']=$_POST['score']+20;
                  $_POST['diff']="hard";
                }
              }
              else
              {
                $GLOBALS['is_correct'.$_POST['qNo']]="false";
                if($_POST['diff']=="easy")
                  $_POST['diff']="easy";
                else if($_POST['diff']=="medium")
                  $_POST['diff']="easy";
                else
                  $_POST['diff']="medium";
              }
              $GLOBALS['diff']=$_POST['diff'];
              $GLOBALS['qNo']=$_POST['qNo']+1;
            }
            echo "
              <p>Congrats you finished the game</p>
              <div class=\"center\">
                <p>Question 1: ".$GLOBALS['is_correct1']."</p>
                <p>Question 2: ".$GLOBALS['is_correct2']."</p>
                <p>Question 3: ".$GLOBALS['is_correct3']."</p>
                <p>Question 4: ".$GLOBALS['is_correct4']."</p>
                <p>Question 5: ".$GLOBALS['is_correct5']."</p>
                <p><strong>FINAL SCORE</strong>: ".$GLOBALS['score']."</p>
                <p><br>Save Game?</p>
                <form action=\"index.php\" method=\"post\">
                  <input type=\"submit\" name=\"save\" value=\"Save\"/>
                  <input type=\"submit\" name=\"retry\" value=\"retry\"/>
                  <br>
                  <input type=\"text\" name=\"username\" placeholder=\"Enter username\"/>
                  <input type=\"hidden\" name=\"score\" value=\"".$GLOBALS['score']."\"/>                
                </form>
              </div>";
          }
           } 
        }
      }
   echo "<button  onclick=\"topFunction()\" class=\"Topbutton\">^ </button>"?>
  <script>
    window.onscroll = function(){Bar()};
    var navbar = document.getElementById("navBar");
    var stick = navbar.offsetTop;
    function Bar()
    {
      if(window.pageYOffset >= stick)
        {navbar.classList.add("stick");}
        else
        {navbar.classList.remove("stick");}
    }
    function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }
  </script>
</body>
  <div class="footer">
    <div class="column">
      <img src="facebook.png" style="width:10%">
       <img src="twitter.png" style="width:10%">
        <img src="linkedin.png" style="width:11.8%">
    </div>
  </div>
