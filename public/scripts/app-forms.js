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
function bruh(){
     
    console.log('test..');
}