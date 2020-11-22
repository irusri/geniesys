<?php
$ustream = trim($_GET['ustream']);
$dstream = trim($_GET['dstream']);
$picea_basic_start = trim($_GET['picea_basic_start']);
$picea_basic_end = trim($_GET['picea_basic_end']);
$picea_basic_chromosome = trim($_GET['picea_basic_chromosome']);
$plus_minus = trim($_GET['plus_minus']);

$config_path = file_get_contents("../../config.json");
$json_path = json_decode($config_path, true);
$replacements = $json_path['datasets'];

for ($j = 0; $j < count($replacements); $j++) {
    if ($replacements[$j]['group_name'] == "Genomes") {
        $genomic_path_variable = $replacements[$j]['dataset_path'];
    }
    if ($replacements[$j]['group_name'] == "CDS") {
        $cds_path_variable = $replacements[$j]['dataset_path'];
    }
    if ($replacements[$j]['group_name'] == "Transcripts") {
        $transcript_path_variable = $replacements[$j]['dataset_path'];
    }
    if ($replacements[$j]['group_name'] == "Protein") {
        $protein_path_variable = $replacements[$j]['dataset_path'];
    }
}

if ($plus_minus == "-1" || $plus_minus == "-") {
    $plus_minus = "2";
} else {
    $plus_minus = "1";
}

if ($plus_minus == 2) {
    $ustream_start = $picea_basic_end + 1;
    $ustream_end = $picea_basic_end + $ustream;
    exec("../../blast/services/scripts/bin/fastacmd -d  " . dirname(__FILE__) . "/../../../" . $genomic_path_variable . "' -L'" . $ustream_start . ',' . $ustream_end . "' -S '" . $plus_minus . "'  -l 1000000000 -s '" . $picea_basic_chromosome . "' ;", $output_ustream);

    $dstream_start = $picea_basic_start - $dstream;
    $dstream_end = $picea_basic_start - 1;

    exec("../../blast/services/scripts/bin/fastacmd -d  '" . dirname(__FILE__) . "/../../../" . $genomic_path_variable . "' -L'" . $dstream_start . ',' . $dstream_end . "' -S '" . $plus_minus . "'  -l 1000000000 -s '" . $picea_basic_chromosome . "' ;", $output_dstream);

} else {

    if ($picea_basic_start - $ustream > 1) {
        $ustream_start = $picea_basic_start - $ustream;
        $ustream_end = $picea_basic_start - 1;

        exec("../../blast/services/scripts/bin/fastacmd -d  '" . dirname(__FILE__) . "/../../../" . $genomic_path_variable . "' -L'" . $ustream_start . ',' . $ustream_end . "' -S '" . $plus_minus . "'  -l 1000000000 -s '" . $picea_basic_chromosome . "' ;", $output_ustream);
    } else {
        $output_ustream[1] = "";

    }

    $dstream_start = $picea_basic_end + 1;
    $dstream_end = $picea_basic_end + $dstream;

    exec("../../blast/services/scripts/bin/fastacmd -d  '" . dirname(__FILE__) . "/../../../" . $genomic_path_variable . "' -L'" . $dstream_start . ',' . $dstream_end . "' -S '" . $plus_minus . "'  -l 1000000000 -s '" . $picea_basic_chromosome . "' ;", $output_dstream);

    if (strlen($output_ustream[1]) > $ustream + 1) {
        $output_ustream[1] = "";
    }
    if (strlen($output_dstream[1]) > $dstream + 1) {
        $output_dstream[1] = "";
    }

}

if ($output_ustream[1] == null) {
    $output_ustream[1] = "";
}
if ($output_dstream[1] == null) {
    $output_dstream[1] = "";
}

$results = array('ustreamstr' => $output_ustream[1], 'dstreamstr' => $output_dstream[1]);
echo json_encode($results);
