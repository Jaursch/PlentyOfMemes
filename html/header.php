

	<header>
		<h1>MemeMe - <em>Welcome<span id="username"><?php echo " $user";?></span>!</em></h1>
	</header>
	<nav>
		<ul class="tab tab-block" style='position:sticky'>
			<?php
				foreach ($content as $page => $location){
					echo "<li class='tab-item' style='max-width:5%'><a href='$location?user=".$user."' ".($page==$currentpage?" class='active'":"").">".$page."</a></li>";
				}
			?>

			<li class="tab-item tab-action" style='position:absolute;right:1%'>
				<div class="input-group input-inline">
					<input class="form-input input-sm" type="text" placeholder="This doesn't do anything yet">
					<button class="btn btn-primary btn-sm input-group-btn">Search</button>
				</div>
			</li>
			<input type=button onclick="location.href='logout.php'; " value="Logout" />

		</ul>

	</nav>
