let addToCartButton = document.getElementById("product-addtocart-button");

if(addToCartButton) 
{
    console.log("added listener");
    addToCartButton.onclick(scrollToTop);
}
else
{
    console.log("yeah we didn't find the button.");
}

function scrollToTop() 
{
    if(window.scrollY > 10)
    {
        window.scrollTo(window.scrollX, 0)
    }
}