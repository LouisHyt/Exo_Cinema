<?php ob_start(); ?>

<h1>List Movies</h1>

<?php

$title = "Liste des films";
$content = ob_get_clean();
$metadesc = "Display all the movies available";

require 'view/template.php';