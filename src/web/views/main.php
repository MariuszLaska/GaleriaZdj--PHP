<?php
include 'includes/login_include.php';
?>
<h3>Wyślij zdjęcie</h3>
<br />
<form method="POST" enctype="multipart/form-data">

    autor:<input type="text" name="autor" value="<?php echo @$_SESSION['user'] ?>" >
    tytuł:<input type="text" name="title" > <br />
    znak wodny:<input type="text" name="watermark">
    <br />
    <input type="file" name="photo">  <?php if(isset($_SESSION['user'])){?> prywatne: <input type="checkbox" name="private" value="private"> <?php } ?>
    <input type="submit" name="wyślij!">
</form>
<br />
<h2><a href="/gallery">Zobacz naszą galerię!</a></h2>

