var timerID = null;
var timerRunning = false;

function startClock() {
  console.log("clock is running");
  abort();
  getCurrentDate();
  getCurrentTime();
};

function getCurrentDate() {
  Todays = new Date();
  TheDate = "" + Todays.getDate() + "/" + (Todays.getMonth() + 1) + "/" + (Todays.getFullYear());
  document.getElementById("date").innerHTML = TheDate;
};

function abort() {
  if (timerRunning) {
    window.clearTimeout(timerID);
  }
  timerRunning = false;
};

function getCurrentTime() {
  var today = new Date();
  var hours = today.getHours();
  var minutes = today.getMinutes();
  var seconds = today.getSeconds();
  var formattedTime = "" + ((hours > 12) ? hours - 12 : hours);

  formattedTime += ((minutes < 10) ? ":0" : ":") + minutes;
  formattedTime += ((seconds < 10) ? ":0" : ":") + seconds;
  formattedTime += (hours >= 12) ? " P.M." : " A.M.";
  document.getElementById("clock").innerHTML = formattedTime;
  timerId = setTimeout("getCurrentTime()", 1000);
  timerRunning = true;
};

window.onload = startClock();
