<?php
$selected_genelist = trim($_POST['selected_genelist']);
$primaryGenes = trim($_POST['primaryGenes']);
$datatype = trim($_POST['datatype']);
$d_source = trim($_POST['source']);
$expression_table = "expression_exatlas_" . $d_source . "_" . $datatype;
$primaryGenes = trim($primaryGenes, ', ');
include "../../genelist/crud/getgenelist.php";
$primaryGenes2 = getdefaultgenelist();
$experimentarr = get_expression_experiments();

/*
 * Database connection from plugins/settings.php
 */
$path = $_SERVER['DOCUMENT_ROOT'] . "/plugins/settings.php";
include_once $path;
$private_url = parse_url($db_url['genelist']);
$GLOBALS["genelist_connection"] = mysqli_connect($private_url['host'], $private_url['user'], $private_url['pass'], str_replace('/', '', $private_url['path'])) or die(mysqli_error());

$tdb = str_replace('/', '', $private_url['path']);

if (str_replace('/', '', $private_url['path']) == "explorer_aspleaf_potra_v11") {
    $datatype = "vst";
    $d_source = trim($_POST['source']);
    $expression_table = $d_source;
    $expression_table = str_replace("tpm", "vst", $expression_table);
    $d_source = str_replace("tpm", "vst", $d_source);
}

if (isset($_POST['selected_genelist'])) {
    $geneids_array = explode(",", trim($_POST['selected_genelist']));
    exit;
}

$logvalue = "log2";
if ($datatype == "vst") {$logvalue = "LOG2(log2+2)";} else { $logvalue = "LOG2(log2+2)";}

if (count($primaryGenes2) < 1001) {
    $new_array = getdata($primaryGenes2, $d_source);
    print json_encode($new_array);
} else {
    print json_encode("exceeded");
}

function getdata($primaryGenes, $d_source)
{
    $result = array();
    $result2 = array();

    $geneids_array = $primaryGenes;

    for ($t = 0; $t < count($geneids_array); $t++) {

        $resultprobeset = mysqli_query($GLOBALS["genelist_connection"], "SELECT  sample,gene_id,expression  FROM expression WHERE gene_id='$geneids_array[$t]' and sample_i=2;") or die(mysqli_error());
        $rows = array();
        $rows2 = array();
        $rows['name'] = $geneids_array[$t];
        $i = 0;
        while ($rowPROBE_ID = mysqli_fetch_assoc($resultprobeset)) {

            $rows['data'][$i] = (float) $rowPROBE_ID['expression'];
            $rows2['sample_name'][$i] = $rowPROBE_ID['sample'];
            $i++;
        }
        array_push($result, $rows);
        if ($rows2 != null) {
            array_push($result2, $rows2);
        }

    }

    $result2 = $result2[0]['sample_name'];
    $arrsg = array('popdata' => $result, 'samples' => $result2);
    return $arrsg;
}

#####################################
//Check prefix
#####################################
function checkprefix($source, $prefix)
{
    if (str_startswith($source, $prefix)) {
        return true;
    } else {
        return false;
    }
}
function str_startswith($source, $prefix)
{
    return strncmp($source, $prefix, strlen($prefix)) == 0;
}

/////////////////////////////////////
