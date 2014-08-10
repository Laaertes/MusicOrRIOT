<!DOCTYPE html>
<html>
	<body onload="loaded()">
		<div id ="content">
		    <div class="buttons">
		        <div class="container">
		            <div class="row">
		                <div class="col-md-6 col-md-offset-3">
		                    <h1 align="center">
		                        <strong><?= $party["name"] ?></strong>
		                    </h1>
		                    <br>

                            <div>
                                <button id="player" class="play btn btn-primary btn-md" onclick="play()">Play!</button>
                            </div>

                            <br>

                            <button onclick="sendToDatabase()">SendToDB</button>

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
		                    
		                    <!-- Search Results Here -->
							<div>
								<ol>
									<li id="searchResults">
										<div id="name"></div>
										<div id="artist"></div>
										<div id="album"></div>
										<!-- div id="songLength">placeholdersongLength</div>  -->
									</li>
									<br>
									<li id="searchResults2">
										<div id="name2"></div>
										<div id="artist2"></div>
										<div id="album2"></div>
										<!-- div id="songLength">placeholdersongLength</div>  -->
									</li>
									<br>
									<li id="searchResults3">
										<div id="name3"></div>
										<div id="artist3"></div>
										<div id="album3"></div>
										<!-- div id="songLength">placeholdersongLength</div>  -->
									</li>
									<br>
									<li id="searchResults4">
										<div id="name4"></div>
										<div id="artist4"></div>
										<div id="album4"></div>
										<!-- div id="songLength">placeholdersongLength</div>  -->
									</li>
									<br>
									<li id="searchResults5">
										<div id="name5"></div>
										<div id="artist5"></div>
										<div id="album5"></div>
										<!-- div id="songLength">placeholdersongLength</div>  -->
									</li>
									<br>
								</ol>									
							</div>
		                    
		                    <p id="displayResult"></p>
		                    
		                    <br>
		                    <p class="queue" align="center">
		                        <strong>Queue</strong>
		                    </p>
		                    <br>
		
		                    <div>
		                        <ol id="queueList" class="list">
		                            <strong>
		                            <?php foreach ($songs_by_score_desc as $song): ?>
		                                <li>
		                                    <?= $song["name"] ?>: <?= $song["score"] ?>
		                                    <button onclick="updateVoteCount(<?= $song['id'] ?>, 1);">Up Vote</button>
		                                    <button onclick="updateVoteCount(<?= $song['id'] ?>, -1);">Down Vote</button>
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
