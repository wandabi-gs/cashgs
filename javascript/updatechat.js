
function updatechat()
{

  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() 
  {

      document.getElementById("messcont").innerHTML=this.responseText;

  }
  xmlhttp.open("GET","../templates/viewchat.php",true);
  xmlhttp.send();
}
