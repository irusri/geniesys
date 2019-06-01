<?php
if(isset($_POST['sequence_string'])){$blast_string=trim($_POST['sequence_id'])."\n".trim($_POST['sequence_string']);}else{$blast_string=">Chr09:3779182..3782534
ATGAACTTCTCTCTACTTCCGGGACTCACCTCTCTTGATCTCTCTTCTAACGGACTAGCCGGAAAAATCCCCCTTCAAATATGTACTCTGTCGAGGCTAACTTACCTTGACTTGTCCTTCAATTCCCTCACTGGCGAGTTGCCTCCCTGTGTCCAAAACCTCACTAGGCTTCAAGTTCTTTGGATCAGTTATAATCACATCAGTGGCTCTATCCCTCCTGAGGTGGGAAATTTGGAGAGATTGACCGACTTGAATCTCGAGTTCAATTTGCTTAATGGTGCAGTCCCACTGACTATTGGTTGCTTGCACAATTTACAATCCCTTAGATTTAGCTCAAACAATTTAAGTGGCTCTATCCCTCTTGAGCTTGGGAACCTTGCAAAAACAAATGTTGTTGATTTAAGTTTCAACAACTTCACTGGTCCCATTCCATCCTCTATAGGGAATTTGACAAGCTTGACTTATCTCTATTTGCATCGAAACAAACTTGGTGGATCTATTCCTCTCGTAATAGGGAATTTGACGAGCTTGACCGATCTCTATTTGCAAAAAAACCAACTCGGTGGATCTATTCCCCTTCAAATGTGTACTCTGTCGAGGCTAACTCACCTTGACTTGTCCTTCAATTCTCTCATTGGCGAGTTACCTCCCTATGTCCAAAACCTCACTAGGCTTCAAGTTCTTCGGATCAGTTATAATCACATCAGTGGCTCTATCCCTCCTGAGTTGGGAAATTTAGAGAGATTGACCAACTTGAATCTCAAGGTCAATTTGCTTAATGGTGCAATCCCATTGACTATTGGTTGCTTGCACAATTTACAATCCCTTCGATTTAGCTCAAACAATTTAAGTGGCTCTATCCCTCTTGAACTAGGGAACCTCGCAAAAATAAATGTTGTTGATTTAAGTTTGAACACCTTCACTGGTCCCATTCCGTCCTCTATAGGGAATTTGACAAGCTTGACTTCTCTCTATTTGCAACGAAACAAACTTGGTGGATCTATTCCTTCGGAAATAGGGAATTTGACGAGCTTGAATTATCTCGATTTGCAAGGAAACCAACTCGGTGGATCTATTCCTCCGGAAATAGGGAATTTGATGAGCTTGATTAGTCTCAATTTGCGAGGAAACCAACTCGATGGATCTCTTCCTCCGAAAATAGGGAATTTGAAGAACTTGGCTTATCTCGATTTGCGAAGAAACCAACTCAGTGGATCTATTCCTCCAGAAATAGGGAATTTGACAAGCATGACTTATCTCTATTTGCAAGAAAACAAACTCAGTGGATGTATTCCGTCACAAATAGGCAATTTGAAGAGCTTGGTCGCACTGAAATTACATGAAAATAGAATTGATTGTGCCATCCCATCGAACATAGGAGATTTAAGGGATCTCCGACAGCTAGATTTGAGCTCGAACAACTTGGTCGGGGAAATCCCCGTTCAACTTGGGAAACTAGGCTGGTTAAACTATCTCGATCTTCACAACAATTCTCTTTCTGGCTCCATTCCAGATAATCTCAAGGCTATCTTTCCTAATACTTCTTTTCTCGGCAACAAAGATTTGAACCAGTTTCATGAAACCCAAGCCCCCAGAAGAAGGTCTAGCGTAATTCATTATATGACGATATTCATTCCACTAGCTGCGATTTCCTGTATAGTGGTCGGATCTTGCTTTCTATTTCGCTGTGCAACAAAAACAGAGCAACTAGAGACTACAAAAAAAAATGGAAATTTCTTGTCAATATGGAGTTATGATGGGAGGCTTGCATATGAAGACATAATCGATGCAACAGAGGACTTCGATCTCAAATATTGCATCGGGACTGGTGGTTATGGTAGCGTTTATAGAGCACGATTGCCCAATGGGAAAGTTGTGGCATTGAAGAAACTTCACCGTCTTGAAGCAGAGGACCCATCCTTCGACAAGAGCTTTCGAAATGAAGTGAAACACTTGACAGAAATAAGGCATAGAAGCATAATCAAGCTCCATGGTTTCTGCTTACACAGGCGATGCATGTTCTTAGTTTACGAATACATGGGAAAATGGGAGTCTATTCTGTGCTTTGAGAGATGATATTGAAGCCGTGGAATTGGATTGGTCCAAAAGAGTCAATCTCGTCCAGGATACAGCACATGCTTTGTCTTACATGCACCATGATTGTGTTCGGCCAATTGTTCATCGAGACATGTCTAGCAATAACATCTTACTCAACAGTAAAATGCAAGCTTTTGTATCAGATTTTGGCACCGCAAGACTTCTGGGTCATGATTCCTCATCTAACTTCACTGCAAATATCGCTGGCACCTATGGATACATTGCACCAGGTGAGCAATACTTTATGCTTCATATATATATATTACCCTGAAAGTTACTACAGGAGGTAGAAGTCAAATAAACGACATTGTAGAAGTTTCACTATCCATGCACATCGGTGACTTGTAGACTGTTATTGTACTTGCCAACAGTAGCTAAGGATTGGTTGTGCCACGATTGGTCAAATGTCCCCTCGGAACCACCTTGTACGCCGTGGCTCTGACTTCTGTATTCATTTTTTTTTTTTTTTGGTAAAGCTGTATTCATTTTATTCATTTCTATATATTTGAATATTTTTGGAAAATGAATATTTATTTTGTATGCCACTATTGTTAGTATTACTGGGTTACTTATTTTAGAATAAAAATGTCTCAAACTATATTTTTATGTTGCATCTAAGTAAAAGCATGTCGGAATAGTAAGATTTTTGGATTTCGTATTACATCCATATTGGTATTACTAAGTCATTCATTTCTATTAAACGTTTTGTTGTGGAAATAAAATTAACTGTTTTGAAAGGAAAATTGGAGGGGCAAATGGGGCGGTGTGGGGTGCCGCACATGGTTATGCGGGGCACGATGGAGAGGGAAAAGTTGCCTCTCAAGGGGCAGCGACGGGGCGGGCAGTAAGGGTGTAGTCATCCCGTCACGGGGCGGGCAGTTAAGGGTGTAGTCATCCCGTCCAAAGCCTCAACTGCTAAAATTTTGTATGCCTTTTTGTATTTTTTTGCAGAGCTTGCATATACTTTGGTCGTTACTGAGAAATGCGACGTATATAGCTTTGGAGTGGTAGCAATGGAAACAATGATGGGTGAGCATCCAGGAGATATTATATCTATCTTGTTGACATCCTCCGGAGAAGATATCATGCTACATGAAATTCTAGACCGGCGGTTGCCTTTTCCAAGAGAGAACTCTATTGCAAGAAGTATTGTTTTGATAGTTTCTCTAGCGCTTGCTTGCTTGAGTGCTAATCCAAAGTCTCGACCAACTATGAAGCAAGTCTCAGAAGCTTTTCTAGCTCGAAAGTCACCATTG
>Potri.001G000900.2
GAGTGGGCTTGTCTCTTTGTATACACGCCCCTTCCTTCGTCAAATCAATCCGTTTTATTGATTTTATTTTATTTGAGAAAATACAAACTAAAAAAGTTCTGGATCTCGATTGTGTGCGTGTGTAAGAGAGAGAGGATCAACTATTAATCTCGACGAATCAGAGGAGCTGTTTTTTAGTAATAAAAGGAAGAAAGAAGGGATTTTGATTTGCTCTACATCCATCCATCACTTTGATTCTCCTCTCCTCCCGTCTCTGAAGAAAGGATTTGTCGACAATGAGAATGGGAGCTGTTGCTGCGATATGGTGGTTAACGGTGGTTGCTGCTGCATCTCGCCTTTCATTCCTGCACGCCTCTTCTCCATCATCAACTACTGTCCCAGCTTTCCTCTGGTCTCCTCACCATCCTCATCATCAAATGAGTGAAGTAGTGAATTATCAGACCATTTCTTCAAAAGATCTTGCCAGGTCAGTTCTGTCTGAAGGAGGCTGGTCAAACTTACTGTGCTCAGAAAAGAAAGTTCAGCAGTCTGTGGATCTGGCGCTTGTATTTATTGGCAGGGGGCTGCTTTCCACTGATGTTTCTGCAAACAAAAACACAGATCCAGCTCTTGTGAACTTGCTCAAGGTTTCTTATACCGAGTCCAATTTTTCCATGGCATTTCCTTATGTTGCTGCTTCAGAGGAGGCAATGGAGAATTCATTGGTTTCTGGGTTTGCAGAAGCTTGTGGGCAGGATTTAGGAATCAGTAATGTTGCTTTTTCAGAGTCATGTTCTGTAGAGGGTGAAAACTTTCAAAAGCTTGCAAACTTGCACGCCATCAATGACTATCTGGCTTCAAGGATGGAGAAGAGGCCTAGTGGCCATACTGACCTGGTTGTATTCTGTTATGGAGGCTCCAATTCAATGAAAGGACTTGACCAACCACAAAGTGAAAGTGAAATTTTCTCTGAGCTCATCAGCTCTGTGGAGATGTTGGGGGGGAAATATTCCGTTCTCTATGTTTCAGATCCCTTCCGATCAATCCACCTTCCTTATCATCGAGAACTAGAAAGGTTTCTTGCTGAAAGTGCTGCAGGAAATGCATCACTGAATTCCACACACTGCGATGAAGTTTGCCAGATCAAATCATCACTTTTGGAAGGAGTTTTAGTTGGGATTGTTTTGCTTATCATTTTGATATCAGGCCTTTGCTGTATGATGGGCATTGACACTCCAACAAGATTTGAGGCTCCCCAAGACTCTTAATTGGTTGCATGTGTACCACCAAGTACTTTTGTCTTGGGCATTTGTGAAAGAGATTAGTTTGGTTGTTATATAGTTGTCAATGAACGGAGATGCTGTCTTGTATTATTTAAACAAGTGTTATCTTATGATGGTAATAATGGAGCATTTTAGTGTTTTTGTTAACACACTGTATTATGTACCCTTTTGCTGTCTATGTGCCGTGTAGGGTCTATTCTTGATTTGAGGAGGTTTCATTAAGTGGTCTGTATATCCATTGAAAATCTAGCCGCTGCAATGATATGAACTTGTAGTGGAAATGACTTGAAAATGTTTGCTTATCAATATAAAGCTCTGTTATGATCACTATTGACCTCAGATTGGTGTCTCGTCTTAATGAATGATTCTGTCTTGTCTTC";
$blast_string="";
}
?>
<script type="text/javascript">
            var blast_program=<?php print json_encode($_POST['program'])?>;
</script>
<span style="float: right;color: red">&copy;</span>
<link rel='stylesheet' href="plugins/blast/css/blast.css" /> 
<div id="blast_content">
    <form method="post" id="genie_blast_form"  >
        <fieldset>
            <ol>
            <li id="examplesearch">
            <label for="data_type">Load example:</label>
            <input type="text" name="seqid" style="width:200px;font-size:14px;font-weight:bold;" placeholder="Type in gene id" id="seqid" class="ui-autocomplete-input" autocomplete="off"><span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
            <input onclick="extract_sequence('genomic_data');" height="60px" type="button" id="genomic_btn" class="form-submit" value="Genomic Sequence" style=" outline:none;">
             <input onclick="extract_sequence('transcript_sequence');" height="60px" type="button" id="transcript_btn"  class="form-submit" value="Transcript Sequence" style=" outline:none;">
              <input onclick="extract_sequence('cds_sequence');" height="60px" type="button" id="cds_btn"  class="form-submit" value="CDS Sequence" style=" outline:none;">
               <input onclick="extract_sequence('protein_sequence');" height="60px" type="button" id="protein_btn"  class="form-submit" style="display: none;outline:none;" value="Protein Sequence">
            </li>
            
             <li>
                    <label for="data_type">BLAST program:</label>
                    <select name="database_type" id="database_type">
                        <option value="blastn">BLASTN - nucleotide query to nucleotide db</option>
                        <option value="blastx">BLASTX - translated (6 frames) nucl. query to protein db</option>
                        <option value="blastp">BLASTP - protein query to protein db</option>
                        <option value="tblastn">TBLASTN - protein query to translated (6 frames) nt db</option>
                        <option value="tblastx">TBLASTX - transl. (6 frames) nucl. query to transl (6) nt db</option>
                    </select>
                    
                </li>
                <li>
                    <label for="column_name">Query sequence:</label>
                    <textarea name="query_sequence_text" id="query_sequence_text" cols="100" rows="15"><?php echo $blast_string; ?></textarea>
                    
                    <li>
                        <label for="column_name">Upload File:</label>
                        <input type="file" name="query_file" class="form-file" id="equery_file" size="60">
                        
                    </li>
                    <li>
                        <label for="column_name">Select Blast DB:</label>
                        <select multiple name="datasets" style="height:60px" id="Datasets"> </select>
                     
                        <br /> </li>
                    <li>
                        <div class="mH" onclick="toggleMenu('menu1')">+ Settings
                            
                        </div>
                        <div id="menu1" class="mL">
                            <label for="scroing_matrix">Scoring matrix:</label>
                            <select name="advanced_parameters_scoring_matrix" class="form-select" id="advanced_parameters_scoring_matrix">
                                <option value="BLOSUM62" selected="selected">BLOSUM62</option>
                                <option value="PAM30">PAM30</option>
                                <option value="PAM70">PAM70</option>
                                <option value="BLOSUM80">BLOSUM80</option>
                                <option value="BLOSUM45">BLOSUM45</option>
                            </select>
                            <br>
                            <label for="filtering">Filtering:</label>
                            <label class="option" for="advanced_parameters_low_complexity_regions">
                                <input type="checkbox" name="advanced_parameters_low_complexity_regions" id="advanced_parameters_low_complexity_regions"  class="form-checkbox"> Low complexity </label>
                            <label class="option" for="advanced_parameters_filtering_lower_case_letters">
                                <input type="checkbox" name="advanced_parameters_filtering_lower_case_letters" id="advanced_parameters_filtering_lower_case_letters"  class="form-checkbox"> Lower-case letters</label>
                            <br>
                            <label for="filtering">E-value cutoff:</label>
                            <select name="advanced_parameters_e_value_cutoff" class="form-select" id="advanced_parameters_e_value_cutoff">
                                <option value="1e-3" selected="selected">1e-3</option>
                                <option value="1e-30">1e-30</option>
                                <option value="1e-10">1e-10</option>
                                <option value="1e-5">1e-5</option>
                                <option value="0.1">0.1</option>
                                <option value="0">0</option>
                                <option value="10">10</option>
                                <option value="100">100</option>
                                <option value="1000">1000</option>
                            </select>
                            <br>
                            <label for="advanced_options">Advanced Options:</label>
                            <label class="option" for="advanced_parameters_e_value_cutoff_BLAST_options_ungapped">
                                <input type="checkbox" name="advanced_parameters_e_value_cutoff_BLAST_options_ungapped" id="advanced_parameters_e_value_cutoff_BLAST_options_ungapped"  class="checkbox"> ungapped</label>
                            <label class="option" for="advanced_parameters_options_megablast">
                                <input type="checkbox" name="advanced_parameters_options_megablast" id="advanced_parameters_options_megablast"  class="form-checkbox"> megablast</label>
                            <br />
                            <label for="advanced_parameters_genetic_code">Query genetic code:</label>
                            <select name="advanced_parameters_genetic_code" class="form-select" id="advanced_parameters_genetic_code">
                                <option value="0" selected="selected">Standard</option>
                                <option value="1">Vertebrate Mitochondrial</option>
                                <option value="2">Yeast Mitochondrial</option>
                                <option value="3">Mold, Protozoan, and Coelocoel Mitochondrial</option>
                                <option value="4">Invertebrate Mitochondrial</option>
                                <option value="5">Ciliate Nuclear</option>
                                <option value="6">Echinoderm Mitochondrial</option>
                                <option value="7">Euplotid Nuclear</option>
                                <option value="8">Bacterial</option>
                                <option value="9">Alternative Yeast Nuclear</option>
                                <option value="10">Ascidian Mitochondrial</option>
                                <option value="11">Flatworm Mitochondrial</option>
                                <option value="12">Blepharisma Macronuclear</option>
                            </select>
                            <br>
                            <label for="DB_genetic_code">DB genetic code:</label>
                            <select name="advanced_parameters_DB_genetic_code" class="form-select" id="advanced_parameters_DB_genetic_code">
                                <option value="0" selected="selected">Standard</option>
                                <option value="1">Vertebrate Mitochondrial</option>
                                <option value="2">Yeast Mitochondrial</option>
                                <option value="3">Mold, Protozoan, and Coelocoel Mitochondrial</option>
                                <option value="4">Invertebrate Mitochondrial</option>
                                <option value="5">Ciliate Nuclear</option>
                                <option value="6">Echinoderm Mitochondrial</option>
                                <option value="7">Euplotid Nuclear</option>
                                <option value="8">Bacterial</option>
                                <option value="9">Alternative Yeast Nuclear</option>
                                <option value="10">Ascidian Mitochondrial</option>
                                <option value="11">Flatworm Mitochondrial</option>
                                <option value="12">Blepharisma Macronuclear</option>
                            </select>
                            <br> 
                            <label for="advanced_parameters_Frame_shift_penalty">Frame shift penalty:</label>
                            <input type="text" maxlength="128" name="advanced_parameters_Frame_shift_penalty" id="advanced_parameters_Frame_shift_penalty" size="60" value="" class="form-text">
                            <br>
                            <label for="advanced_parameters_word_size">Word size:</label>
                            <input type="text" maxlength="128" name="advanced_parameters_word_size" id="advanced_parameters_word_size" size="60" value="" class="form-text">
                            <br>
                            <label for="advanced_parameters_number_of_results">Number of results per sequence:</label>
                            <select name="advanced_parameters_number_of_results" class="form-select" id="advanced_parameters_number_of_results">
                               <option selected="selected" value="50">50</option>
                                 <option value="10" >10</option>
                                <option value="100">100</option>
                                <option value="1">1</option>
                                	
                            </select>
                    </li>
            </ol>
            <button  id="submitbtn" onclick="submitformelements()" type="button"  value="Run search" class="submitbtn">BLAST</button>
        </fieldset></form>
    <p /> 
 <div style="position:absolute;display:none;width:70px;top:34%;left:46%;z-index:200000" align="center" id="waiting_div"><div class="spinner">
<div class="bounce1"></div>
<div class="bounce2"></div>
<div class="bounce3"></div>
</div></div>
<div style="position:relative;display:none" id="results_div"> Results..</div>

</div>
<div style="display: none" id="result_buttons">
<input class="form-submit" type="button" id="frm-fasta" value="FASTA"></input> 
<input class="form-submit" type="button" id="frm-genelist" value="Create a GeneList"></input> 
<!--<input class="form-submit" type="button" id="frm-kablammo" value="Send to kablammo"></input> 
<input class="form-submit" type="button" id="frm-pfam" value="Send to Pfam"></input>
<input class="form-submit" type="button" id="frm-Galaxy" value="Send to Galaxy"></input>
<input class="form-submit" type="button" id="frm-best" value="Get Best BLAST"></input>
<input class="form-submit" type="button" id="frm-tree" value="Create Phylogenetic tree"></input>
<input class="form-submit" type="button" id="frm-tree" value="Create DOwnload the table results"></input>-->
</div>

<script src="plugins/blast/js/jquery.dataTables.min.js" type="application/javascript" ></script>
<script type="application/javascript" src="plugins/blast/js/lib/dataTables.buttons.min.js"></script>
<script type="application/javascript" src="plugins/blast/js/lib/jszip.min.js"></script>
<script type="application/javascript" src="plugins/blast/js/lib/pdfmake.min.js"></script>
<script type="application/javascript" src="plugins/blast/js/lib/vfs_fonts.js"></script>
<script type="application/javascript" src="plugins/blast/js/lib/buttons.html5.min.js"></script>




<script src="plugins/blast/js/main.js" type="application/javascript"></script>
<script type="application/javascript"></script>
