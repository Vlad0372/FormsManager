function showHideTextarea(){
    var selectedItem = document.getElementById("type").value;
    if(selectedItem == "1"){
        var txtarea = document.getElementById("placeTxtAreaDiv");
        txtarea.style.display = "block";
    }else{
        var txtarea = document.getElementById("placeTxtAreaDiv");
        txtarea.style.display = "none";
    }
}
function bruh(par){
    //session()->all();
    //var govno = {{ Session::get(par) }};
    console.log(par);
    console.log('test..');
    //console.log("{{ Session::get('parameter1')}}");
}
function cringe(uh){
    //var uh = "{{ session('minutes') }}";
    console.log('bru_c222ringe_h')
    console.log(uh);
}

function startTimer(elemId, minutes){
    var seconds = 0;
    var minutes = 1;
    var timeRemaining;

    var x = setInterval(function(){   
        
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
    }, 1000);
}