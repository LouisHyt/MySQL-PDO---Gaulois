<?php
    require("./db_config.php");

    if(!isset($_GET["id"])){
        echo("<h1>Aucun ID n'a été spécifié</h1>");
        return;
    }
    
    $gauloisID = $_GET["id"];
    

    //Infos Gaulois
    $stmt = $db->prepare("
        SELECT pe.nom_personnage, li.nom_lieu, sp.nom_specialite
        FROM personnage pe
        INNER JOIN lieu li ON li.id_lieu = pe.id_lieu
        INNER JOIN specialite sp ON pe.id_specialite = sp.id_specialite
        WHERE pe.id_personnage = :id
    ");
    $stmt->bindValue(':id', $gauloisID, PDO::PARAM_INT);
    $stmt->execute();
    $gauloisInfos = $stmt->Fetch();


    if(!$gauloisInfos){
        echo("<h1>L'utilisateur avec l'Id $gauloisID n'existe pas</h1>");
        return;
    }

    //Infos Batailles du gaulois
    $stmt = $db->prepare('
        SELECT pc.qte AS casque_pris, ba.nom_bataille, DATE_FORMAT(ba.date_bataille, "%d/%m/%y") AS date
        FROM personnage pe
        INNER JOIN prendre_casque pc ON pe.id_personnage = pc.id_personnage
        INNER JOIN bataille ba ON pc.id_bataille = ba.id_bataille
        WHERE pe.id_personnage = :id
    ');
    $stmt->bindValue(':id', $gauloisID, PDO::PARAM_INT);
    $stmt->execute();
    $gauloisBatailles = $stmt->FetchAll(PDO::FETCH_ASSOC)

?>

<div class="infos">
    <h1>Nom du gaulois : <?= $gauloisInfos["nom_personnage"] ?><h1>
    <p>Spécialité : <?= $gauloisInfos["nom_specialite"] ?></p>
    <p>Lieu d'habitation : <?= $gauloisInfos["nom_lieu"] ?></p>
</div>


<?php

    if(!$gauloisBatailles){
        echo("<h3>Le gaulois " . $gauloisInfos["nom_personnage"]. " n'a gagné aucun casque durant une bataille</h3>");
        return;
    }

?>

<table>

  <thead>
    <tr>
      <th scope="col">Bataille</th>
      <th scope="col">Date</th>
      <th scope="col">Casque pris</th>
    </tr>
  </thead>
  <tbody>

  <?php
    
    foreach($gauloisBatailles as $bataille){

        $casque_pris = $bataille["casque_pris"];
        $nom_bataille = $bataille["nom_bataille"];
        $date = $bataille["date"];

        echo("
            <tr>
                <th> $nom_bataille </th>
                <td> $date </td>
                <td> $casque_pris </td>
            </tr>
        ");
    }
  ?>

  </tbody>
</table>


<style>
    table {
        border-collapse: collapse;
        border: 2px solid rgb(140 140 140);
        font-family: sans-serif;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    caption {
        caption-side: bottom;
        padding: 10px;
        font-weight: bold;
    }

    thead,
    tfoot {
        background-color: rgb(228 240 245);
    }

    th,
    td {
        border: 1px solid rgb(160 160 160);
        padding: 8px 10px;
    }

    td:last-of-type {
        text-align: center;
    }
</style>