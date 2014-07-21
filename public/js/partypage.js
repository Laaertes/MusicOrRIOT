function searchMe() {
    var spotifyApi = new SpotifyWebApi();
    spotifyApi.getArtistAlbums('43ZHCT0cAZBISjO8DG9PnE')
        .then(function(data) {
            console.log('Artist albums', data);
        }, function(err) {
            console.error(err);
        });
}