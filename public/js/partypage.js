function searchMe1()
{
	var textBox1 = document.getElementById("searchbox1").value;
	confirm(textBox1);
};


function searchMe() {
    var spotifyApi = new SpotifyWebApi();
    spotifyApi.getArtistAlbums('43ZHCT0cAZBISjO8DG9PnE')
        .then(function(data) {
            console.log('Artist albums', data);
        }, function(err) {
            console.error(err);
        });
}

