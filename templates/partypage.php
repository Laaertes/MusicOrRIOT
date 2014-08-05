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
		                    <div class="search" align="center">
		                        <p>
		                            <input type="text" value="" id="searchbox1">
		                            <button class="searchBOX" value="Search" name="Search" onclick="searchMe()">Search</button>
		                        </p>	
		                    </div>
		
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
