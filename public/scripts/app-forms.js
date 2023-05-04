function showHideTextarea(){
    //var selectedItem = document.getElementById("type").value;
    //console.log(selectedItem);

    var e = document.getElementById("type");
    var value = e.value;
    var hasDesc = e.options[e.selectedIndex].getAttribute("data-hasdescription");

    if(hasDesc == 1){
        var txtarea = document.getElementById("placeTxtAreaDiv");
        txtarea.style.display = "block";
    }else{
        var txtarea = document.getElementById("placeTxtAreaDiv");
        txtarea.style.display = "none";
    }
}

function restoreSelectedOption(oldValue){
    if(oldValue){
        var selectedItem = document.getElementById("type");
        selectedItem.value = oldValue;
        showHideTextarea();
    }else{
        var selectedItem = document.getElementById("type");
        selectedItem.value = -1;  
    } 
}

function saveScrollPos(){
    scrollPos = document.documentElement.scrollTop || document.body.scrollTop;
    localStorage.setItem("formScrollPos", scrollPos);
}

function getSavedScrollPos(){
    return localStorage.getItem("formScrollPos");
}

function getCurrentScrollPos(){
    console.log(document.documentElement.scrollTop || document.body.scrollTop);
}

function setCurrentScrollPos(pos){
    document.documentElement.scrollTop = document.body.scrollTop = pos;
}

function startTimer(elemId, passedSecs){
    var seconds = passedSecs % 60;
    var minutes = Math.floor(passedSecs / 60);
    var timeRemaining;

    tick();

    var x = setInterval(tick, 1000);

    function tick(){
        if(seconds < 10){
            timeRemaining = minutes + ":0" + seconds; 
        }else{
            timeRemaining = minutes + ":" + seconds; 
        }
        document.getElementById(elemId).innerHTML = timeRemaining;
    
        seconds -= 1;
    
        if(seconds < 0){
            if(minutes > 0){
                minutes -= 1;
                seconds = 59;
            }else{
                clearInterval(x);
                document.forms['terminateSessionForm'].submit();
            }          
        }     
    }
}

function setModalHiddenInputId(id, modalId){
    document.getElementById(modalId).value = id;
}