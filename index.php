<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'insertion</title>
    <link href="css/bootstrap.css" rel="stylesheet"></head>
<body>
    <?php
    // Connexion à la base de données
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=bddtdwebavancee;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    // Traitement du formulaire
    if (isset($_POST['nom']) && isset($_POST['age']) && isset($_POST['id'])) {
        $nom = $_POST['nom'];
        $age = $_POST['age'];
        $id = $_POST['id'];

        // Requête d'insertion
        $insertQuery = $bdd->prepare("INSERT INTO etudiant (nomPrenom, age, id) VALUES (:nom, :age, :id)");
        $insertQuery->execute(array(
            'nom' => $nom,
            'age' => $age,
            'id' => $id
        ));
        // Afficher un message de confirmation
    }

    // pour suprimer de la base de donées 
    if(isset($_POST['id_a_supprimer'])){ 
        $id_a_suprimer = $_POST['id_a_supprimer']; 
        $deleteQuery = $bdd->prepare("DELETE FROM etudiant WHERE id = :id");
        $deleteQuery->execute(array('id' => $id_a_suprimer));
        echo " supression sucées "; 
    }

    $etudiants = $bdd->query('SELECT * FROM etudiant');
    ?>
     <div class="container mt-5">
        <div class="row">
            <div class="col-12 bg-gradient text-center py-2">
                <h4>Ajouter à la base de données</h4>
            </div>
            <div class="col-12 mt-3">
                <form method="post">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom :</label>
                        <input type="text" class="form-control" id="nom" name="nom">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Votre âge :</label>
                        <input type="number" class="form-control" id="age" name="age">
                    </div>
                    <div class="mb-3">
                        <label for="id" class="form-label">Votre matricule :</label>
                        <input type="text" class="form-control" id="id" name="id">
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Âge</th>
                            <th scope="col">Matricule</th>
                            <th scope="col">Suprimé</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($etudiants as $etudiant) : ?>
                            <tr>
                                <td><?php echo $etudiant['id']; ?></td>
                                <td><?php echo $etudiant['nomPrenom']; ?></td>
                                <td><?php echo $etudiant['age']; ?></td>
                                <td><?php echo $etudiant['id']; ?></td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="id_a_supprimer" value="<?php echo $etudiant['id']; ?>">
                                        <button type="submit" name="supprimer" class="btn btn-danger">Supprimer</button>
                                    </form> 
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</body>
</html>
