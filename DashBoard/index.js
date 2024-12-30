window.addEventListener('load', function() {
    console.log('All assets are loaded')

    
})

function samFunct(el, name) {
    var x = el.clientX;
    var y = el.clientY;
    
    // alert(x + " + " + y + " : " + name);
}

let scrolledData=0


window.addEventListener("scroll", function () {
    // Calculate how far the user has scrolled as a percentage
    const content = document.querySelector(".content");
    const scrollPosition = (window.scrollY / (content.offsetHeight - window.innerHeight)) * 100;
    const percentage = Math.min(scrollPosition, 100); // Cap it at 100%

    if (percentage>scrolledData) {
        scrolledData=percentage
        document.getElementById('percentagevalue').innerText = scrolledData;
    }
  
    // Display the percentage in an element with the id 'percentagevalue'
  });
  
  window.addEventListener("beforeunload", function (e) {
    // Display a confirmation message
    e.returnValue = scrolledData;
  });
  