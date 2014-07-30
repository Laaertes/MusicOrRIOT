<!DOCTYPE html>
    <div id ="content">
        <div>
            <?php
                print"<b> $Id </b> $IPAddress <br/> $PartyName <br/>"
            ?>
        </div>
        <div class="buttons">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="create-party">
                            <div class="centered">
                                <a href="#" class="btn btn-primary btn-lg" role="button">Create Party</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="find-party">
                            <div class="centered">
                                <a class="btn btn-primary btn-lg" role="button" onclick="myFunction()">Find Party</a>
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
