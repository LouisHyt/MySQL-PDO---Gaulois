<?php
    require("./db_config.php");

    $stmt = $db->prepare("
    SELECT pe.nom_personnage, pe.id_personnage ,li.nom_lieu, sp.nom_specialite 
    FROM personnage pe
    INNER JOIN lieu li ON li.id_lieu = pe.id_lieu
    INNER JOIN specialite sp ON pe.id_specialite = sp.id_specialite"
);
    $stmt->execute();
    $gaulois = $stmt->FetchAll(PDO::FETCH_ASSOC);

?>

<table>
  <thead>
    <tr>
      <th>Nom</th>
      <th>Spécialité</th>
      <th>Habitation</th>
    </tr>
  </thead>
  <tbody>
    <?php

        foreach($gaulois as $personne){

            $name = $personne["nom_personnage"];
            $specialite = $personne["nom_specialite"];
            $lieu = $personne["nom_lieu"];
            $id = $personne["id_personnage"];

            echo("
                <tr>
                    <th><a href='./gaulois.php?id=$id'> $name </a></th>
                    <td> $specialite </td>
                    <td> $lieu </td>
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