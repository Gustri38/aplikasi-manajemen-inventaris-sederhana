document.addEventListener('DOMContentLoaded', function() {
    const initialTitle = document.title; 
    const speed = 200;
    const padding = "   ";
    const fullScrollText = initialTitle + padding;
    let currentIndex = 0;

    function scrollTitle() {
        let displayedText = "";
        displayedText = fullScrollText.substring(currentIndex) + fullScrollText.substring(0, currentIndex);
        document.title = displayedText.substring(0, initialTitle.length);
        currentIndex++;
        if (currentIndex >= fullScrollText.length) {
            currentIndex = 0;
        }
        setTimeout(scrollTitle, speed);
    }
    scrollTitle();
});