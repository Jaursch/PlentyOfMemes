<?php  ?>
	<header>
		<h1 style="color:#5755d9;">MemeMe - <em>Welcome<?php
			if(isset($_SESSION["user"]))
				echo " " . $_SESSION["user"]
		?>!</em></h1>
	</header>
	<nav>
		<ul class="tab tab-block" style='position:sticky'>
			<?php
				foreach ($content as $page => $location){
					echo "<li class='tab-item' style='max-width:8%'><a href='$location?user="./*/$user./*/"' ".($page==$currentpage?" class='active'":"").">".$page."</a></li>";
				}
			?>

			<li class="tab-item tab-action" style='position:absolute;right:1%'>
				<div class="input-group input-inline">
					<input class="form-input input-sm" type="text" placeholder="This doesn't do anything yet">
					<button class="btn btn-primary btn-sm input-group-btn">Search</button>
				</div>
			</li>
			<div>
			<?php
				/*/if(!$_SESSION["user"]){ //not currently getting the correct value
					echo "<p>You are not currently logged in</p>";
				}else{/*/
					//echo "<input type=button onclick='location.href='logout.php';' value='Logout' />";
				/*/}/*/
			?>
			<input type=button onclick="location.href='logout.php';" value='Logout' />

		</div>
		</ul>

	</nav>
