
<header>
	<div class="navigation">
		<div class="logo" id="haut">
			<a href="index.php"><img src="style/logoSPA.png" width="90" ></a>
		</div>
		<div class="navbar">
			<ul class="links">
				<li><a href="index.php?page=adopter"><i class="fa-solid fa-paw "></i> Adopter</a></li>
				<li><a href="index.php?page=dons"><i class="fa-sharp fa-solid fa-hand-holding-dollar "></i> Dons et Legs</a></li>
				<?php  
				if (isset($_SESSION['nom'])) 
					{
					echo " <li><a href=\"index.php?page=cotisationgue\"><i class=\"fa-solid fa-file \"></i> Cotisations</a></li>";
					
					$sql = $db_b->prepare("SELECT nom FROM auth WHERE nom=:nom");
					$sql->execute(["nom"=>$_SESSION["nom"]]);
					$select_data = $sql->fetch(PDO::FETCH_ASSOC);

					if (!empty($select_data)) 
						{
						echo "<li><a href=\"index.php?page=tech\"><i class=\"fa-solid fa-gear\"></i>Accès au tech</a></li>";
						}
					echo "<li><a href=\"index.php?page=logout\"><i class=\"fa-solid fa-right-to-bracket\"></i></a></li>"; 
					}
				else echo " <div class=\"format\"><li><a href=\"index.php?page=login\"><i class=\"fa-solid fa-circle-user\"></i></a></li>  </div> ";
				?>
			</ul>
			<div class="toggle_btn"> 
				<i class="fa-solid fa-bars"></i>
			</div> 
		</div>
	</div> 
	<div class="dropdown_menu">
		<li><a href="index.php?page=adopter"><i class="fa-solid fa-paw"></i> Adopter</a></li>
		<li><a href="index.php?page=dons"><i class="fa-sharp fa-solid fa-hand-holding-dollar "></i> Dons et Legs</a></li>
		<?php  
		if (isset($_SESSION['nom'])) 
			{
			echo " <li><a href=\"index.php?page=cotisationgue\"><i class=\"fa-solid fa-file \"></i> Cotisations</a></li>";
			
			$sql = $db_b->prepare("SELECT nom FROM auth WHERE nom=:nom");
			$sql->execute(["nom"=>$_SESSION["nom"]]);
			$select_data = $sql->fetch(PDO::FETCH_ASSOC);

			if (!empty($select_data)) 
				{
				echo "<li><a href=\"index.php?page=tech\"><i class=\"fa-solid fa-gear\"></i>Accès au tech</a></li>";
				}
			echo "<li><a href=\"index.php?page=logout\"><i class=\"fa-solid fa-right-to-bracket\"></i></a></li>"; 
			}
		else echo " <div class=\"format\"><li><a href=\"index.php?page=login\"><i class=\"fa-solid fa-circle-user\"></i></a></li>  </div> ";
		?>
	</div>  
</header>


<script>

const toggleBtn = document.querySelector('.toggle_btn')
const toggleBtnIcon = document.querySelector('.toggle_btn i')
const dropDownMenu = document.querySelector('.dropdown_menu')

toggleBtn.onclick = function () {
	dropDownMenu.classList.toggle('open')
	const isOpen = dropDownMenu.classList.contains('open')
	
	toggleBtnIcon.classList = isOpen 
	? 'fa-solid fa-xmark'
	: 'fa-solid fa-bars'
}
</script>





