<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Algorekt</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  </head>
  <body>
    <img class = "gif" id = "smoke" src = "https://media.giphy.com/media/11gTDDQCEAfom4/giphy.gif"></img>
    <img class = "gif" id = "cat" src = "http://vignette3.wikia.nocookie.net/clashofclans/images/3/30/NYAN_CAT.gif/revision/latest?cb=20150415221840"></img>
    <img class = "gif" id = "snoop" src = "https://media.giphy.com/media/O0Xo8Tpk5QxTW/giphy.gif"></img>
    <img class = "gif" id = "doge" src = "https://media.giphy.com/media/1XqJuLSmrZPhe/giphy.gif"></img>
    <canvas id="myCanvas" width="800" height="200" style="border:1px solid #000000;">
    </canvas>
     <div style="width:100%">
        <div style="width:50%; top:0px;float:left;">
          <div id= "myName" onClick="this.contentEditable='false';" style="width:50%; top:0px;float;"><h2><?PHP echo $_GET['p1']; ?></h2></div>
          <div id="text" onClick="this.contentEditable='true';">lorem ipsum dolor lorem ipsum dolorlorem ipsum dolor</div>
           <img id="compile" src="play.png" width=75, height=75, onClick="checkPass()" style="cursor: pointer;"/>
        </div>
        <div style="width:50%; top:0px;float:left;">
          <div id= "theirName"onClick="this.contentEditable='false';" style="width:50%; top:0px;float;"><h2><?PHP echo $_GET['p2']; ?><h2></div>
          <div id="theirText" onClick="this.contentEditable='false';">
            lorem ipsum dolor lorem ipsum dolorlorem ipsum dolor
          </div>
        </div>
    </div>
  </body>
  <script>
      //Browser Detection
      navigator.sayswho= (function(){
          var N= navigator.appName, ua= navigator.userAgent, tem;
          var M= ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
          if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
          M= M? [M[1], M[2]]: [N, navigator.appVersion, '-?'];

          return M;
      })();

      var browser;
      if (navigator.sayswho[0] == "Firefox")
        browser="f";
      else if (navigator.sayswho[0] == "Chrome")
        browser="c";
      else if (navigator.sayswho[0] == "Safari")
        browser="s";
      else  if (navigator.sayswho[0] == "Microsoft")
        browser="m";
      else
        browser="f";

      var mouseX = 0; //default values
      var mouseY = 0; //default values
      var mouseVec = new Vector(mouseX, mouseY);


      var width = $(window).width()-40;
      var height = $(window).height()*8/10;


      var c = document.getElementById("myCanvas");

      //event listener for mouse
      c.addEventListener("click", canvasClick, false);
      c.addEventListener('mousemove', onMouseUpdate, false);

      c.width = width;
      c.height = height;
      var context = c.getContext("2d");

      var pos = 0;
      var mouseClicked = false;
      var screenCovered = false;
      var dogeShowing = false;
      var nyanShowing = false;
      var epShowing = false;
      var coveredCounter = 100;;

      function checkPass()
      {
        $.post("http://188.166.145.0/run.php", {raw : totalString.join("\n"), user : <?PHP echo '"' . $_GET['p1'] . '"'; ?> }, function(data)
        {
            if(data == "true")
            {
                alert("You Win");
            }
            else
            {
                alert("Nope");
            }
        });
      }


      function canvasClick(event)
      {
        if (mouseClicked) {
          mouseClicked = !mouseClicked;
          if (browser == "f" || browser == "m") {
            var newMouseX = event.clientX - c.offsetLeft + document.documentElement.scrollLeft;
            var newMouseY = event.clientY - c.offsetTop + document.documentElement.scrollTop;
          }
          else { //"s" or "c"
            var newMouseX = event.clientX - c.offsetLeft + document.body.scrollLeft;
            var newMouseY = event.clientY - c.offsetTop + document.body.scrollTop;
          }
        }
        else {
          if (browser == "f" || browser == "m") {
            mouseX = event.clientX - c.offsetLeft + document.documentElement.scrollLeft;
            mouseY = event.clientY - c.offsetTop + document.documentElement.scrollTop;
          }
          else { //"s" or "c"
            mouseX = event.clientX - c.offsetLeft + document.body.scrollLeft;
            mouseY = event.clientY - c.offsetTop + document.body.scrollTop;
          }
        }
      }

      function onMouseUpdate(event)
      {
        if (browser == "f" || browser == "m") {
          var newMouseX = event.clientX - c.offsetLeft + document.documentElement.scrollLeft;
          var newMouseY = event.clientY - c.offsetTop + document.documentElement.scrollTop;
        }
        else { //"s" or "c"
          var newMouseX = event.clientX - c.offsetLeft + document.body.scrollLeft;
          var newMouseY = event.clientY - c.offsetTop + document.body.scrollTop;
        }
      }

      var totalString = [];
      totalString.push("public static int[] sort(int[] array) {");
      var highlights = ["boolean", "byte", "char", "double", "float","int","long","short",
        "String", "if", "while", "for", "break", "else", "switch", "case", "true", "false", "(int"];
      var theirString = [];
      theirString.push("public static int[] sort(int[] a) {");

      var gifX = 0;
      var gifY = 0;
      var gifTheta = 0;
      hideAll();

      function game(){

        context.clearRect(0, 0, c.width, c.height);
        context.fillStyle = '#f2f2f2';
        context.fillRect(0, 0, width, height);
        context.fillStyle = getRandomColor();
        context.font = "20px Arial";
        var x = 10;
        var y = 30;
        context.fillText(totalString[0], x, y);
        context.fillText(totalString[0], x+width/2, y);
        context.font = "15px Arial";
        y += 5;
        var tempY = drawText(x, y, totalString);
        drawText(x+width/2, y, theirString);

        if (screenCovered) {
          displaySmoke();
        }
        else if (dogeShowing) {
          displayDoge();
        }
        else if (nyanShowing) {
          displayCat(tempY);
        }
        else if (epShowing) {
          displayEpilepsy();
        }
        else {
          hideAll();
        }
      }

      var thisUser = <?PHP echo '"' . $_GET['p1'] . '"'; ?>;
      var otherUser = <?PHP echo '"' . $_GET['p2'] . '"'; ?>;

      function displayEpilepsy() {
        context.clearRect(0, 0, c.width, c.height);
        context.fillStyle = getRandomColor();
        context.fillRect(0, 0, width, height);

        gifTheta += 0.1;
        context.fillStyle = getRandomColor();
        context.font = "50px Arial";
        context.fillText("EPILEPSY WARNING!", gifX, gifY - 50);


        gifX = 200 + 100 * Math.cos(gifTheta) + Math.random() * 10;
        gifY = 200 + 100 * Math.sin(gifTheta) + Math.random() * 10;

        if (Math.floor(Math.random() * coveredCounter) == 0) {
          epShowing = false;
        }
        else {
          coveredCounter -= 2;
        }
      }

      function displayCat(y) {
        var image = document.getElementById("cat");
        image.style.width = "200px";
        image.style.height = "20px";


        context.drawImage(image,gifX, y-15+Math.floor(Math.random()*10));
        gifX = gifX + 10;

        if (Math.floor(Math.random() * coveredCounter) == 0) {
          nyanShowing = false;
        }
        else {
          coveredCounter--;
        }
      }

      function displayDoge() {
        var image = document.getElementById("doge");
        context.drawImage(image,gifX, gifY);

        gifTheta += 0.1;
        context.fillStyle = getRandomColor();
        context.font = "50px Comic Sans MS";
        context.fillText("EPILEPSY WARNING!", gifX, gifY - 50);

        context.fillText("wow", gifX, 50);
        context.fillText("much code",500, 100);
        context.fillText("very skill", 200, gifY);
        context.fillText("wow", 400, 200);
        context.fillText("such java", 800, 400);


        gifX = 200 + 100 * Math.cos(gifTheta) + Math.random() * 10;
        gifY = 200 + 100 * Math.sin(gifTheta) + Math.random() * 10;

        if (Math.floor(Math.random() * coveredCounter) == 0) {
          dogeShowing = false;
        }
        else {
          coveredCounter--;
        }
      }

      function displaySmoke() {
        $("#snoop").show();
        $("#smoke").show();
        var image = document.getElementById("smoke");
        var newX = 0;

        image.style.position = "absolute";
        image.style.top = height;
        image.style.left = newX;

        gifTheta += 0.1;
        context.fillStyle = getRandomColor();

        context.font = "50px Arial";
        context.fillText("EPILEPSY WARNING!", gifX, gifY - 50);


        gifX = 200 + 100 * Math.cos(gifTheta) + Math.random() * 10;
        gifY = 200 + 100 * Math.sin(gifTheta) + Math.random() * 10;

        var image = document.getElementById("snoop");
        image.style.position = "absolute";
        image.style.top = gifX;
        image.style.left = gifY;

        gifX = 200 + 100 * Math.cos(gifTheta) + Math.random() * 10;
        gifY = 200 + 100 * Math.sin(gifTheta) + Math.random() * 10;
        if (Math.floor(Math.random() * coveredCounter) == 0) {
          screenCovered = false;
        }
        else {
          coveredCounter--;
        }
      }

      function hideAll() {
        $("#snoop").hide();
        $("#smoke").hide();
        $("#doge").hide();
        $("#cat").hide();
        coveredCounter = 300;
        gifX = 0;
        gifY = 0;
        gifTheta = 0;
      }

      function drawText(x, y, stringArray) {
        var lineheight = 18;
        var xVal = x+40;
        for (var i = 1; i<stringArray.length; i++) {
          xVal = x+40;
          words = stringArray[i].split(" ");
          for (var j = 0; j < words.length; j++) {
            if (contains(highlights, words[j])) {
              context.fillStyle = getRandomColor();
            }
            else {
              context.fillStyle = "#444";
            }
            context.fillText(words[j], xVal, y + (i*lineheight) );
            xVal += context.measureText(words[j]+" ").width;
          }
        }
        return y + stringArray.length*lineheight;
      }

        function Vector(x, y) {
          this.x = x;
          this.y = y;
        }

        function normalise(vect) {
          var mag = Math.sqrt(vect.x*vect.x + vect.y*vect.y);
          return new Vector(vect.x/mag, vect.y/mag);
        }

        function multiply(vect, val){
          return new Vector(vect.x*val, vect.y*val);
        }

      function getRandomColor() {
          var letters = '0123456789ABCDEF'.split('');
          var color = '#';
          for (var i = 0; i < 6; i++ ) {
              color += letters[Math.floor(Math.random() * 16)];
          }
          return color;
      }

      // Send an HTTP post request to the server
      function sendRequest(data, callback) {
          $.ajax({
              type: "POST",
              url: "http://188.166.145.0/nextMove.php",
              data: data,
              success: callback
          });
      }

      // Send the source code to the server
      function sendSource(src, user, otherUser, callback) {
          sendRequest({
              "raw": src,
              "user": user,
              "opp": otherUser
          }, callback);
      }

      $(function(){
       $("#text").keypress(function (e) {
          if (e.keyCode == 13) {
             totalString.push($('#text').html().substring(0, $('#text').html().length-4));
             $("#text").empty();
          }
        });
      });

    function contains(a, obj) {
      var i = a.length;
      while (i--) {
         if (a[i] == obj) {
            return true;
         }
      }
      return false;
    }

      myVar = setInterval(game, 50);

      // Send the player's source code to the server every second
      srcSendLoop = setInterval(function() {
          sendSource(totalString.join("\n"), thisUser, otherUser, applyDisruptions);
      }, 1000);

      // Apply the disruptions from the server to the source code
      function applyDisruptions(str) {
          var json = JSON.parse(str);
          var src = json[0];
          var disruption = json[1];
          var opponent = json[2];
          if (opponent[0] != null) {
            var opponentSrc = opponent[0];
            var opponentDisruption = opponent[1];
            switch(opponentDisruption) {
              case 1:
                opponentSrc = replaceVarNames(opponentSrc);
                break;
              case 5:
                opponentSrc = addToLastBlock(opponentSrc, "i = 0;");
            }
            theirString = opponentSrc.split("\n");
            

          }
          switch(disruption) {
              case 1:
              // Replace variable names
                dogeShowing = true;
                src = replaceVarNames(src);
                break;
              case 2:
                //smoke
                screenCovered = true;
                break;
              case 3:
                //line removed
                nyanShowing = true;
                break;
              case 4:
              // Play obnoxious music
                epShowing = true;
                var audio = new Audio('dankstorm.mp3');
                audio.play();
                break;
              case 5:
                var num = Math.floor(Math.random() * 10); 
                src = addToLastBlock(src, "i = "+num+";");
                break;

          }
          console.log("Our work: "+src);

          totalString = src.split("\n");
          console.log("Their string: "+theirString);
      }

      function addToLastBlock(src, stmt) {
          var index = src.lastIndexOf('}');
          if(index < 0) return src;
          var preBracket = src.substring(0, index);
          return preBracket + stmt + src.substring(index, src.length);
      }

      function replaceVarNames(src) {
          var varDecs = src.match("[a-zA-Z]+ [a-zA-Z]+ = .+")
          if(varDecs.length == 0) return src;
          // Get a random variable name
          var varName = varDecs[Math.random() * varDecs.length].split(" ")[1];
          if(varName != "") {
              return src.replace(new RegExp(varName, "g"), "b");
          }
          return src;
      }
          </script>

</html>


