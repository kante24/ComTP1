<?php
require("hautMembre.php");
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Publication Annonce Publique</title>
    </head>

    <body>

        <Center>
            <h1>
                <U>
            Publication d'une annonce publique
        </U>
            </h1>



            <form action="Publication.php" method="POST" style="margin-top: 100px;">
                <table>
                    <tr>
                        <td style="text-align: right;"><strong>Description:</strong></td>
                        <td style="text-align: left;">
                            <textarea type="text" style="height: 100px;" name="description"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: right;"><strong>Date:</strong></td>
                        <td style="text-align: left;">
                            <input type="date" name="date" value="today" />
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: right;"><strong>Auteur:</strong></td>
                        <td style="text-align: left;">
                            <strong><?=$_SESSION[ 'nom']?></strong>
                        </td>
                    </tr>


                    <tr>
                        <td colspan="2" style="text-align: center;"><input type="submit" name="publier" value="Publier"></td>
                    </tr>
                </table>
            </form>

        </Center>



    </body>

    </html>

    <?php
    publierAnnoncePublique();
    ?>