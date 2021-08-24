function ZoomImage(element)
{
    window.open(element.src,  "img", "width=450px, height=450px");
}

var LatestCache;
$( ".cacheable" ).focusin(function() {
    LatestCache = this.id;
});

function AddInput()
{
    var e = document.getElementById(LatestCache);
    e.value += " [input] ";
}

function AddSeperation()
{
    var e = document.getElementById(LatestCache);
    e.value += " & ";
}

$(document).ready(function(){
   HandleSelect( document.getElementById("select_type") );
});

function HandleSelect(element)
{
    $(".type1").hide();
    $(".type2").hide();
    $(".type3").hide();
    $("#seperate").hide();
    $("#input").hide();

    switch(parseInt(element.value))
    {
        case 1:
            $(".type1").show();
            break;
        case 2:
            $(".type2").show();
            break;
        case 3:
            $(".type3").show();
            $("#seperate").show();
            $("#input").show();
            break;
        default:
            $(".type1").show();
            break;
    }
}

function AdjustForm(url)
{
    var element = document.getElementById("aantalvragen");

    var urlTo =  url+"&aantalvragen=" + element.value;
    window.location = urlTo;
}




