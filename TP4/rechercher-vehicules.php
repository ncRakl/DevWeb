<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Recherche des voitures d'une personne</title>
</head>
<body>

	<form action="<?php echo $_SERVER['PHP_SELF'];?>" name="form1" method="post" enctype="application/x-www-form-urlencoded">
		<fieldset>
			<legend><b>Coordonnées de la personne</b></legend>
			<table>
				<tr>
					<td>Nom : </td>
					<td><input type="text" name="nom"/></td>
				</tr>
				<tr>
					<td>Prénom : </td>
					<td><input type="text" name="prenom"/></td>
				</tr>
				<tr>
					<td><input type="submit" name="Chercher"/></td>
				</tr>
			</table>
		</fieldset>
	</form>

	<?php

		if (isset($_POST['nom']) && isset($_POST['prenom']))
		{
			include_once 'connexpdo.inc.php';
			$db = connexpdo("voitures");
			$nom = $db->quote($_POST['nom']);
			$prenom = $db->quote($_POST['prenom']);
			$query = "SELECT voiture.immat, modele.modele FROM voiture, modele, proprietaire, cartegrise WHERE proprietaire.nom=$nom AND proprietaire.prenom=$prenom AND proprietaire.id_pers=cartegrise.id_pers AND voiture.id_modele=modele.id_modele AND cartegrise.immat=voiture.immat";
			$result = $db->query($query);
			echo "<h3>Liste des véhicules de ", $_POST['prenom'], " ", $_POST['nom'], "</h3>";
			echo "<table border=\"1\">";
			while ($row = $result->fetch(PDO::FETCH_BOTH)) {
				echo "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
			}
			echo "</table>";
		} else {
			echo "<h3>Formulaire à compléter !</h3>";
		}

	?>

</body>
</html>