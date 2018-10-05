[<?php
$values=array(0, 128, 128+64, 128+64+32, 128+64+32+16, 128+64+32+16+8, 128+64+32+16+8+4, 128+64+32+16+8+4+2, 128+64+32+16+8+4+2+1);
if ($_GET["object"]=="teams") {
    $handle = fopen("res/data/teams.txt", "r");
    $idx=0;
    while (($line = fgets($handle)) !== false) {
        if ($idx != 0) echo ",\n";
        $idx++;
        echo "{\n";
        echo "\t\"name\":\"".trim($line)."\",\n";
        echo "\t\"id\":\"".($idx+1)."\",\n";
        echo "\t\"time\":\"10:00\"\n";
        echo "}";
    }
    for ($i=0;$i<128;$i++) {
        $timeOffset=0;
        for ($j=1;$j<9; $j++) {
            if ($i+128<$values[$j]) {
                $timeOffset=$j;
                break;
            }
        }
        echo ",\n";
        echo "{\n";
        echo "\t\"name\":\"&nbsp;\",\n";
        echo "\t\"id\":\"".($i+130)."\",\n";
        // TODO: make this date calculation based on real time
        // TODO: it doesn't matter, it comes from database anyway
        echo "\t\"time\":\"".(10+$timeOffset*1).":00\"\n";
        echo "}";
    }
}
?>
]
