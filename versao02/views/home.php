<?php 
$texto = "";
foreach ($teste as $registro) {
    $texto = $texto . $registro['texto_pergunta']; 
    };
?>
<h1><?php echo $title;?></h1>
<h1><?php echo $texto;?></h1>