
<html>
    <head>
    	<link rel = "stylesheet" href = "css/skeleton.css" />
    	<link rel = "stylesheet" href = "css/style.css" />
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-3.4.1.min.js"></script>
    </head>

    <body onload="ini()"></body>

    <script type = "text/javascript" >
        function init(){
            $('#result').change(function(){
                alert('test');
            });
        }
    </script>

    latitude <input type = "text" id = "lat" /><br>
    longitude <input type = "text" id = "lon" /><br>
    <div id = "result">

    </div>

</html>
