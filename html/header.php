

	<header>
		<h1 style="color:#5755d9;">MemeMe - <em>Welcome<span id="username"><?php echo " $user";?></span>!</em></h1>
	</header>
	<nav>
		<ul class="tab tab-block" style='position:sticky'>
			<?php
				foreach ($content as $page => $location){
					echo "<li class='tab-item' style='max-width:5%'><a href='$location?user=".$user."' ".($page==$currentpage?" class='active'":"").">".$page."</a></li>";
				}
			?>
		
		
		</ul>

	</nav>
