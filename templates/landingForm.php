<!DOCTYPE html>
    <div id ="content">
        <div class="buttons">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="create-party">
                            <div class="centered">
                                <a class="btn btn-primary btn-lg" role="button" href="createparty.php">Create Party</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="find-party">
                            <div class="centered">
                                <form action="findparty.php" method="post">
                                    <fieldset>
                                        <div class="form-group search-bar">
                                            <input autofocus class="form-control" name="party" placeholder="Party Name" type="text">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg">Find Party</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/landing.js"></script>
    <script src="js/partypage.js"></script>
    <script src="js/spotifyAPI.js"></script>
</body>
</html>