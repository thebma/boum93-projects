//If set true, the timer color will turn red. Default false;
var timeCritical = false;

//The end timestamp for this exam/test
var tEnd = 0;

//The amount of minutes remaining until turing red. Default 5.
var timerMaxMinstoRed = 5;

//Function that updates every second.
var TimerUpdate = function()
{
    if(tEnd != 0 && tEnd != undefined)
    {
        //Get the timestamp from javascript. ( and make it PHP compatible ).
        var tCurrent = function () {
            var ts = new Date().getTime().toString();
            return ts.substring(0, ts.length - 3);
        };

        ////Calculate the time and format it into human-readable.
        var tDiff = tEnd - tCurrent();
        var timeString = FormatTime(tDiff);
        var timeElement = document.getElementById("time");
        timeElement.innerHTML = timeString;

        //Turn timer color red if true.
        if (timeCritical) {
            timeElement.style.color = "red";
        } else {
            timeElement.style.color = "white";
        }

        //Check if the serverside tells that the timer is finished, redirect to end of exam if so.
        if( tCurrent() >= tEnd || timeString == "00:00:00" )
        {
            window.location.href = "/vraagtoets/end?reason=time";
        }
    }

    setTimeout(TimerUpdate, 1000);
};

//Check if the end time has changed, do this every 3 minutes.
var UpdateEndTime = function()
{
    $.when(tEndTemp = GetAPIData("timeend")).then( function() {
        tEnd = tEndTemp.responseText;
    });

    setTimeout(UpdateEndTime, ( 3 * 60 * 1000 ));
};

UpdateEndTime();
TimerUpdate();

//Grab data from the serverside API. API purely returns a string result (or json)
function GetAPIData(attr)
{
    return $.ajax({
        url: '/vraagtoets/api?data='+attr
    });
}

//Format the time from a unix timestamp to a human-readable one.
function FormatTime(timestamp)
{
    date = new Date(timestamp * 1000);

    //Fetch hours, prefix with a zero if needed.
    hours = (parseInt(date.getHours()) - 1);
    if(hours < 10)
    {
        hours = "0" + hours;
    }

    //Fetch mins, prefix with a zero if needed.
    mins = date.getMinutes();
    if(mins < 10)
    {
        mins = "0" + mins;
    }

    //Fetch secs, prefix with a zero if needed.
    secs = date.getSeconds();
    if(secs < 10)
    {
        secs = "0" + secs;
    }

    //See if the timer is critical or not.
    if((parseInt(date.getHours()) - 1) == 0 && date.getMinutes() < timerMaxMinstoRed )
    {
        timeCritical = true;
    }

    return hours.toString() + ":" + mins.toString() + ":" + secs.toString();
}
