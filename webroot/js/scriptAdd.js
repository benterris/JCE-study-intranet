function myFunction(){
    
    switch(document.getElementById('selection').value) {
        case "teacher":
            document.getElementById('volunteer').style.display = "none";
            document.getElementById('highschool0').style.display = "none";
            document.getElementById('highschool').style.display = "none";
            document.getElementById('teacher').style.display = "block";
            document.getElementById('poleManager').style.display = "none";
            break;
        case "volunteer":
            document.getElementById('teacher').style.display = "none";
            document.getElementById('highschool0').style.display = "none";
            document.getElementById('highschool').style.display = "none";
            document.getElementById('volunteer').style.display = "block";
            document.getElementById('poleManager').style.display = "none";
            break;
        case "highschool":
            document.getElementById('volunteer').style.display = "none";
            document.getElementById('teacher').style.display = "none";
            document.getElementById('highschool0').style.display = "block";
            document.getElementById('highschool').style.display = "block";
            document.getElementById('poleManager').style.display = "none";
            break;
        case "poleManager":
            document.getElementById('volunteer').style.display = "none";
            document.getElementById('teacher').style.display = "none";
            document.getElementById('highschool0').style.display = "none";
            document.getElementById('highschool').style.display = "none";
            document.getElementById('poleManager').style.display = "block";
            break;
        default :
            document.getElementById('volunteer').style.display = "none";
            document.getElementById('teacher').style.display = "none";
            document.getElementById('highschool0').style.display = "none";
            document.getElementById('highschool').style.display = "none";
            document.getElementById('poleManager').style.display = "none";
            break;
    }
    
    
}



window.onload = function() {
    myFunction();
}

