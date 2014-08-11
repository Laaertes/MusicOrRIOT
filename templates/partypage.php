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

                            <?php if ($admin): ?>
                                <div  >
                                    <button id="player" class="play btn btn-primary btn-md" onclick="play()">Play!</button>
                                </div>
                            <?php endif ?>

                            <?php if ($current_song): ?>
                                <div>
                                    <?= $current_song["name"] ?>: <?= $current_song["score"] ?>
                                </div>
                            <?php endif ?>
							
							<fieldset>
	                            <div class="form-group search-bar" align="center">
	                                <div>
	                                    <input class="form-control" type="text" placeholder="Search for Track" id="searchbox1" name="searchbox1" onkeydown="checkKey()" autocomplete="off">
	                                </div>
	                                <br>
	                                <div>
	                                    <button onclick="searchMe()" class="btn btn-primary btn-md">Search</button>
	                                </div>
	                            </div>
	                        </fieldset>
                            
		                    
		                    <!-- Search Results Here -->
							<div>
								<ol id="searchList">
								</ol>									
							</div>
		                    
		                    <p id="displayResult"></p>
		                    
		                    <br>
		                    <p class="queue" align="center">
		                        <strong>Queue</strong>
		                    </p>
		                    <br>
		
		                    <div>
		                        <strong>
		                            <ol id="queueList" class="list">
		                            </ol>
		                        </strong>
		                    </div>
                            <br>
                            <br>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</body>
</html>
