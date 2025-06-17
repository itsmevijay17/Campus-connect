function openTab(tabName) {
    var i, tabContent, tabButtons;
    
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    tabButtons = document.getElementsByClassName("tab");
    for (i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove("active");
    }

    document.getElementById(tabName).style.display = "block";
    event.currentTarget.classList.add("active");
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("my-od").style.display = "block";
});

