//Hold an array of all the feedback elements opened.
var openedFeedbacks = [];

//Variables to coordinate the timing of the input fields feedback wrapper.
//It should wait the value in delay(in milliseconds) and then display the feedback wrapper.
var d = new Date();
var currentTime;
var showTime;

//How many milliseconds after the last input the feedback opens.
var delay = 1500;

//Show the feedback after 1.5 seconds after the last input.
function ShowFeedback(id)
{
    OpenFeedback(id);
}

function ShowFeedbackInput(id)
{
    var d = new Date();
    currentTime = d.getTime();
    showTime = currentTime + delay;

    var intvl = setInterval(function(){
        var d2 = new Date();
        currentTime = d2.getTime();
        if( (showTime - currentTime ) < 0 )
        {
            OpenFeedback(id);
            clearInterval(intvl);
        }
    }, 100);
}

//Reset the showTime variable after this function was called.
function UpdateTime()
{
    var d = new Date();
    currentTime = d.getTime();
    showTime = currentTime + 1500;
}

//Close all the other feedbacks, get the element name, display the feedback and then push it to an array.
function OpenFeedback(id)
{
    CloseAllFeedback();
    defaultTag = "feedback-wrapper-";
    combinedTag = defaultTag + (parseInt(id) + 1);

    element = document.getElementById(combinedTag);
    element.style.display = "block";

    openedFeedbacks.push(element);
}

//Loop over the array and close all the feedbacks open.
function CloseAllFeedback()
{
    for(var i = 0; i < openedFeedbacks.length; i++)
    {
        openedFeedbacks[i].style.display = "none";
        CloseFeedback(i);
    }
}

//Set the feedback closed, reconstruct the openFeedbacks array.
//NOTE: Do not use array.indexOf to remove a array entry due lack of compatibility with IE9 or lower.
function CloseFeedback(id)
{
    openedFeedbacks[id].style.display = "none";

    tempArray = [];
    for(var i = 0; i < openedFeedbacks.length; i++)
    {
        if(openedFeedbacks[i] != openedFeedbacks[id])
        {
            tempArray.push(openedFeedbacks[i]);
        }
    }

    openedFeedbacks = tempArray;
}
