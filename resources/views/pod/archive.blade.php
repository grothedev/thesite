
<html>
	<head>
                <link rel = "stylesheet" href = "../../css/skeleton.css" />
                <link rel = "stylesheet" href = "../../css/style.css" />
    </head>
	<div class = "container">
		<div class = "row">
			<h2>Previous Episodes</h2>
			<center>
				<?php

					
					/* NEW DESIGN
					 * scan through directory, filenames are [id]-[short-desc]
					 * for each, if it's in db, print
					 * 	else add to db and print
					 * */

					$dir = scandir(".");
					$db = SQLite3::open('db.sqlite');
					$result = $db->query('SELECT * FROM podcasts')->fetchArray();
					var_dump($result);
					for ($i = 2; $i < sizeof($dir); $i++){
						if ( !strstr($dir[$i], 'mp3') && !strstr($dir[$i], 'ogg')) continue;
						if (){
						}
						//echo '<a href = "' . $dir[$i] . '">' . $dir[$i] . '</a>';
						//echo '<br>';
					}

				?>
			</center>

		</div>
	</div>

<!DOCTYPE html>
<html>

</html>
