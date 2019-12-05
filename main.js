let e = null;
let xhttp = new XMLHttpRequest();
let button1 = document.getElementById("button1");
let button2 = document.getElementById("button2");
let button3 = document.getElementById("button3");
let disable = false;
let game = Math.random()
  .toString(36)
  .substring(7)
  .toUpperCase();

init();

// setInterval(draw, 1000);

// button2.style.display = "none";
// button3.style.display = "none";
// document.getElementsByClassName("dealer").display = "none";

// _______________________________________________________________________________________________________

if (disable === false) {
  button1.onclick = function() {
    xhttp.open("POST", "blackjack.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=restart");
    disable = true;
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        draw();
      }
    };
    button2.style.display = "block";
    button3.style.display = "block";
    button1.style.display = "none";
  };

  // _______________________________

  button2.onclick = function() {
    xhttp.open("POST", "blackjack.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        draw();
      }
    };
    xhttp.send("action=hit");
  };

  // _______________________________

  button3.onclick = function() {
    xhttp.open("POST", "blackjack.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        draw();
      }
    };
    xhttp.send("action=stand");
    // let c_hand = document.getElementsByClassName("computer_hand");
    // c_hand.innerHTML = "";
  };
}

// _________________________________________________________________________________________________________

window.addEventListener("beforeunload", function() {
  xhttp.open("POST", "blackjack.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=terminate&game=" + game);
  //following two lines will cause the browser to ask the user if they
  //want to leave. The text of this dialog is controlled by the browser.
  e.preventDefault(); //per the standard
  e.returnValue = ""; //required for Chrome
  //else: user is allowed to leave without a warning dialog
});

// _________________________________________________________________________________________________________

// Fuctions

function init() {
  while (e === null || e === "" || e == " ") {
    e = prompt("Give me a family-friendly username: ");
  }
  button1.style.display = "block";
  button2.style.display = "none";
  button3.style.display = "none";
  let xhttp = new XMLHttpRequest();

  xhttp.open("POST", "blackjack.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=newgame&game=" + game + "&player=" + e);
  xhttp.onreadystatechange = function() {
    draw();
  };
}

// ___________________

function draw() {
  let xhttp = new XMLHttpRequest();

  xhttp.open("POST", "draw.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("action=draw");

  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      let responses = this.response.split("&&&");
      if (responses[0] !== "") {
        restart();
      }
      document.getElementById("canvas").innerHTML = responses[1];
    }
  };
}

// ___________________

function restart() {
  button1.style.display = "block";
  button2.style.display = "none";
  button3.style.display = "none";
}
