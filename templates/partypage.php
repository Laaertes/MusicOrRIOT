<html>
    <head>
    <title>LoudSource Party</title>
    <link href="css/partypage.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript">
    function searchBox()
    {
        var textBox1 = document.getElementById("searchbox1").value;
        alert("Got ID");
        alert(textBox1);
    };

    function searchMe() {
        alert("running function");
        var textBox1 = document.getElementById("searchbox1").value;
        alert("Searching for " + textBox1)
        var spotifyApi = new SpotifyWebApi();
        spotifyApi.searchArtists('pink')
        .then(function(data) {
            alert(data);
        }, function(err) {
            alert(err);
        });
    }

    </script>

    </head>
        <body>
        <h1 align="center">
        <strong>Party: Cats</strong>
        </h1>
        <br>
        <div class="search" align="center">

        <p>
          <input type="text" value="" id="searchbox1">
        </p>

        <button class="searchBOX" value="Search" onclick="searchMe()">Search</button>	

        </div>

        <br>
        <p class="queue" align="center">
        <strong>Queue</strong>
        </p>
        <br>

        <div>
        <ol class="list">
        <strong>
        <li>
        Rick Astley - Never Gonna Give You Up
        </li>

        <li>
        Rick Astley - Never Gonna Give You Up
        </li>

        <li>
        Rick Astley - Never Gonna Give You Up
        </li>

        <li>
        Rick Astley - Never Gonna Give You Up
        </li>
        </strong>
        </ol>
        </div>
        <nav>
        <a href="index.php"><strong>Home</strong></a>
        </nav>

    </body>
</html>
