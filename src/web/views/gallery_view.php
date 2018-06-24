<?php include 'includes/login_include.php'; ?>
<table>
    <?php
        foreach ($photos as $photo){
    ?>
        <tr>
            <td><a href="../view?id=<?= $photo['_id'] ?>"><img src="../gallery/<?php echo $photo['name'] ?>_MINI.png" ?>  </a>
            </td>
            <td>autor: <?php echo $photo['autor']; ?> <br />  tytuł: <?php echo $photo['title']; ?> </td>
        </tr>
     <?php   } ?>
</table>
<table>
    <?php
    foreach ($private as $photo){
        if(@$photo['user']===@$_SESSION['user']){
        ?>
        <tr>
            <td><a href="../pview?id=<?= $photo['_id'] ?>"><img src="../gallery/<?php echo $photo['name'] ?>_MINI.png" ?>  </a>
            </td>
            <td>autor: <?php echo $photo['autor']; ?> <br />  tytuł: <?php echo $photo['title']; ?>  <br /> prywatne</td>
        </tr>
    <?php   } }?>
</table>
