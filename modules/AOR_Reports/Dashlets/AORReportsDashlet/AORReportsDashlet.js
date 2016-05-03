function displayEmployeeDuration () {
    // Hack to display duration seconds in more pleasent way
    if(document.getElementById('employment_duration')!== null)
    {
        var unix_timestamp = parseInt(document.getElementById('employment_duration').innerHTML);
        var date = secondsToString(unix_timestamp)
        document.getElementById('employment_duration').innerHTML = date;
    }
}

function secondsToString(seconds)
{
    var numyears = Math.floor(seconds / 31536000);
    var nummonths = Math.floor((seconds % 31536000) / 2628000);
    var numdays = Math.floor(((seconds % 31536000) % 2628000) / 86400);
    //var numdays = Math.floor((seconds % 31536000) / 86400);
    var numhours = Math.floor(((seconds % 31536000) % 86400) / 3600);
    var numminutes = Math.floor((((seconds % 31536000) % 86400) % 3600) / 60);
    var numseconds = (((seconds % 31536000) % 86400) % 3600) % 60;
    return numyears + " years " + nummonths + " months " + numdays + " days " + numhours + " hours " + numminutes + " minutes " + numseconds + " seconds";
}

window.setTimeout(displayEmployeeDuration, 300)
