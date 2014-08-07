<!DOCTYPE html>
<html>
	<body>
		<div id ="content">
		    <div class="buttons">
		        <div class="container">
		            <div class="row">
		                <div class="col-md-6 col-md-offset-3">
		                    <h1 align="center">
		                        <strong><?= $party["name"] ?></strong>
		                    </h1>
		                    <br>
                            <div class="form-group search-bar" align="center">
                                <div>
                                    <input class="form-control" type="text" placeholder="Search for Track" id="searchbox1" name="searchbox1">
                                </div>
                                <br>
                                <div>
                                    <button onclick="searchMe()" class="btn btn-primary btn-md">Search</button>
                                </div>
                            </div>
		                    
		                    <p id="displayResult"></p>
		                    
		                    <br>
		                    <p class="queue" align="center">
		                        <strong>Queue</strong>
		                    </p>
		                    <br>
		
		                    <div>
		                        <ol class="list">
		                            <strong>
		                            <?php foreach ($songs_by_score_desc as $song): ?>
		                                <li>
		                                    <?= $song["name"] ?>: <?= $song["score"] ?>
		                                </li>
		                            <?php endforeach ?>
		                            </strong>
		                        </ol>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</body>
</html>
