function gettheDate() {
    var Todays = new Date();
    var TheDate = "" + Todays.getDate() + "/" + (Todays.getMonth() + 1) + "/" + Todays.getFullYear();
    document.getElementById("data").innerHTML = TheDate;
}

var timerID = null;
var timerRunning = false;

function stopclock() {
    clearTimeout(timerID); 
    timerRunning = false;
}

function startclock() {
    stopclock();
    gettheDate();
    showtime();
}

function showtime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();

    var timeValue = "" + ((hours > 12) ? hours - 12 : hours);
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
    timeValue += (hours >= 12) ? " P.M." : " A.M.";

    document.getElementById("zegarek").innerHTML = timeValue;
    timerID = setTimeout(showtime, 1000);
    timerRunning = true;
}

window.onload = () => {
    startclock();

    let darkmode = localStorage.getItem('darkmode');
    const themeSwitch = document.getElementById('theme-switch');

    if (themeSwitch) {
        const enableDarkmode = () => {
            document.body.classList.add('darkmode');
            localStorage.setItem('darkmode', 'active');
        }

        const disableDarkmode = () => {
            document.body.classList.remove('darkmode');
            localStorage.setItem('darkmode', 'inactive');
        }

        if (darkmode === 'active') enableDarkmode();

        themeSwitch.addEventListener('click', () => {
            darkmode = localStorage.getItem('darkmode');
            darkmode !== 'active' ? enableDarkmode() : disableDarkmode();
        });
    } else {
        console.error("Nie znaleziono przycisku o ID 'theme-switch'");
    }
};
