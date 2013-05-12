$(document).ready(function(){

    //Initialize the carousel
    $('#slider-code').tinycarousel(
        {interval: true, //Slide automatically to the next image
        intervaltime: 3000, //Every 3 seconds
        display: 1, //Display one image at a time
        animation: true, //Enable the animation between each images
        duration: 1000, //The animation takes 1 second
        axis:'x', //Hotizontally
        controls: true } //Display previous and next arrows
    );
        
});