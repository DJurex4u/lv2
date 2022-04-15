<?php
$xml = simplexml_load_file("LV2.xml");
$html = "<div>";
foreach ($xml->record as $person) {
    $html .=
        "<div>                   
                
                <img src=$person->slika>
            <div>
                <h4>$person->ime $person->prezime</h4>
                <p class='text-secondary mb-1'>$person->spol</p>
                <p class='text-muted font-size-sm'>$person->email</p>
                <p class='text-muted font-size-sm'>$person->zivotopis</p>      
            </div>
            <hr>
        </div>";
}
$html .="</div>";
echo $html;
?>