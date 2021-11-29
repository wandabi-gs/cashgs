function clock()
{
	var time=new Date();
	var realtime=time.toLocaleTimeString();
    var hour=time.getHours();
    var greet;

    document.getElementById("thetime").firstChild.nodeValue = realtime;

    if(hour<12)
    {
        greet="Good morning";
    }
    else if(hour<18)
    {
        greet="Good afternoon";
    }
    else if(hour<24)
    {
        greet="Good evening";
    }
    
    document.getElementById("greet").firstChild.nodeValue=greet;

}

