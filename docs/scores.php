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
      <a href="index.php">Home</a>
      <a href="help.php">Help Page</a>
      <a class="active" href="scores.php">High Scores Page</a>
  </div>
    <link rel="stylesheet" type="text/css" href="Index.css">
    <link rel="stylesheet" type="text/css" href="Common.css">
  <div class="container">
    <h1><center>High Scores</center></h1>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php
      $file=fopen("highscores.txt","r") or  die("no text file to show scores...");
      while(!feof($file))
      {
        $score=fgets($file);
        echo "<p>".$score."</br></p>";
      }
      fclose($file);
      ?>
  </div>
    <button  onclick="topFunction()" class="Topbutton" > ^ </button>
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