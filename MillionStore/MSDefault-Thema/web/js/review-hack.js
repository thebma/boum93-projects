// As there seems to be no sane way of overriding "review-process.js"
//  We just wait for the element to popup and manually fire click on it.\
//  This should work even if the element is not visible or display:none'd.
let tryCount = 8;

function TryAndActivate() 
{
    //Don't try when the DOM elements hasn't loaded yet.
    let element = document.getElementById("tab-label-reviews-title");
    let container = document.getElementById("tab-label-reviews");

    if(element == null || container == null) 
    {
        return false;
    }

    //Don't try to click the element when the reviews haven't loaded.
    let isActive = container.className.split(" ").includes("active");

    if(!isActive)
    {
        return false;
    }
    
    element.click();
    return --tryCount == 0;
}

var checkReviewTabExist = setInterval(function() 
{
    if(TryAndActivate()) 
    {
        clearInterval(checkReviewTabExist);
    }
}, 500);