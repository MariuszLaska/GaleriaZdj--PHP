<?php
if($error=='type_error'){
    echo 'Plik może być wyłącznie w formacie jpg lub png';
}
if($error=='size_error'){
    echo 'plik jest za duży';
}
if($error=='no_fill'){
    echo 'wybierz plik do wysłania';
}
if($error=='no_autor'){
    echo 'uzupełnij dane o autorze';
}
if($error=='no_watermark'){
    echo 'dodaj znak wodny';
}
?>
<a href="/">wróć do formularza wysyłania</a>
