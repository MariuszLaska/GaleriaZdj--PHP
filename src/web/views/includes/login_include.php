<?php
if(isset($_SESSION['user'])){
    ?>
    Witaj, <?php echo $_SESSION['user']; ?>
    <form method="post">
        <input type="hidden" value="out" name="out">
        <input type="submit" value="wyloguj się!">
    </form>
<?php
}
else{
?>
<form method="POST">
    <input type="text" name="username">
    <input type="password" name="password">
    <input type="submit" value="zaloguj się">
</form>
<a href="/newuser">zarejestruj się</a>
<?php
}

if(isset($_POST['username'])){
    $user=$_POST['username'];
    $password=$_POST['password'];
    $check =login($user, $password);
    if($check==1){echo 'Niepoprawny login lub hasło';}
    if($check==0){ ?> <meta http-equiv="refresh" content="0"> <?php }
}

if(isset($_POST['out'])){
    logout();
    ?> <meta http-equiv="refresh" content="0"><?php
}
?>