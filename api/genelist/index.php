<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

//initialize new SLim App 
$app = new \Slim\App; 

//Slim testing
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $name");

    return $response;
});

// Customer Routes
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
			->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

//Get all genelist
$app->get('/get_all', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$table = $request->getParam('table');
	$fingerprint = $request->getParam('fingerprint');
    $sql = "SELECT * FROM $table where fingerprint='$fingerprint'";
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
		echo json_encode($genelist_results);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Get genelist by id
$app->get('/get_list_by_id', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
	$table = $request->getParam('table');
	$basket_id = $request->getParam('basket_id');
    $sql = "SELECT * FROM $table where fingerprint='$fingerprint' and gene_basket_id=$basket_id";
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($genelist_results); 
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Get active genelist
$app->get('/get_active_list', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
	$table = $request->getParam('table');
    $sql = "SELECT * FROM $table where fingerprint='$fingerprint' and genelist_flag=1";
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($genelist_results); 
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Get shared genelist
$app->get('/get_shared_list', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
	$table = $request->getParam('table');
	$gene_basket_id = $request->getParam('gene_basket_id');
    $sql = "SELECT * FROM $table where fingerprint='$fingerprint' and gene_basket_id='$gene_basket_id'";
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($genelist_results); 
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Add new genelist(if there is no active list availble new list will be the active one)
$app->post('/create_list', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
	$list_name= $request->getParam('list_name');
	$list= $request->getParam('list');
	$table = $request->getParam('table');
	if(count(isactiveExist($db_name,$fingerprint,$table))==0){
		$sql = "UPDATE $table SET genelist_flag=0 where fingerprint=:fingerprint;INSERT INTO $table(gene_basket_name,gene_list,fingerprint,genelist_time,genelist_flag) VALUES (:list_name,:list,:fingerprint,NOW(),1);";		
	}else{
		$sql = "INSERT INTO $table(gene_basket_name,gene_list,fingerprint,genelist_time,genelist_flag) VALUES (:list_name,:list,:fingerprint,NOW(),0);";
	}
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',  $fingerprint);
        $stmt->bindParam(':list_name',      $list_name);
        $stmt->bindParam(':list',      $list);
        $stmt->execute();
        echo '{"notice": {"text": "New genelist added"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//Add new active genelist
$app->post('/create_active_list', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
	$list_name= $request->getParam('list_name');
	$list= $request->getParam('list');
	$table = $request->getParam('table');
		$sql = "UPDATE $table SET genelist_flag=0 where fingerprint=:fingerprint;INSERT INTO $table(gene_basket_name,gene_list,fingerprint,genelist_time,genelist_flag) VALUES (:list_name,:list,:fingerprint,NOW(),1);";		
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',  $fingerprint);
        $stmt->bindParam(':list_name',      $list_name);
        $stmt->bindParam(':list',      $list);
        $stmt->execute();
        echo '{"notice": {"text": "New active genelist added"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//change active genelist by list id
$app->post('/make_me_active_by_id', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $basket_id = $request->getParam('basket_id');
	$table = $request->getParam('table');
    $sql = "UPDATE $table SET genelist_flag=0 where fingerprint=:fingerprint;UPDATE $table SET genelist_flag=1 WHERE fingerprint =:fingerprint and gene_basket_id=:basket_id";
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':basket_id',$basket_id);
        $stmt->execute();
        echo '{"notice": {"text": "GeneList Updated"}}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//update genes in active
$app->post('/update_active_list', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $list = $request->getParam('list');
	$table = $request->getParam('table');
	
	$list_array=explode(",",$list);
	$active_list = explode(",",isactiveExist($db_name,$fingerprint,$table)[0]->gene_list);
	
	$arr = array_merge($list_array,array_filter($active_list)); 
	$list=implode(",",array_unique($arr));

	if(count(isactiveExist($db_name,$fingerprint,$table)[0]->gene_list)==0){
	$sql = "UPDATE $table SET genelist_flag=0 where fingerprint=:fingerprint;INSERT INTO $table(gene_basket_name,gene_list,fingerprint,genelist_time,genelist_flag) VALUES ('ative',:list,:fingerprint,NOW(),1);";	
	}else{
	$sql = "UPDATE $table SET gene_list=:list WHERE fingerprint=:fingerprint and genelist_flag=1";	
	}
	try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':list',$list);
        $stmt->execute();
        echo '{"notice": {"text": "GeneList Updated"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Replace genes in active
$app->post('/replace_active_list', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $list = $request->getParam('list');
	$table = $request->getParam('table');
	
	$list_array=explode(",",$list);
//	$active_list = explode(",",isactiveExist($db_name,$fingerprint,$table)[0]->gene_list);
//	$arr = array_merge($active_list,$list_array); 
	$list=implode(",",array_unique($list_array));

	if(count(isactiveExist($db_name,$fingerprint,$table)[0]->gene_list)==0){
	$sql = "UPDATE $table SET genelist_flag=0 where fingerprint=:fingerprint;INSERT INTO $table(gene_basket_name,gene_list,fingerprint,genelist_time,genelist_flag) VALUES ('ative',:list,:fingerprint,NOW(),1);";	
	}else{
	$sql = "UPDATE $table SET gene_list=:list WHERE fingerprint=:fingerprint and genelist_flag=1";	
	}
	try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':list',$list);
        $stmt->execute();
        echo '{"notice": {"text": "GeneList Replaced"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//update list by basket id
$app->post('/update_list_by_id', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $basket_id = $request->getParam('basket_id');
	$list = $request->getParam('list');
	$table = $request->getParam('table');
	
	$list_array=explode(",",$list);
	$active_list = explode(",",islistExist($db_name,$fingerprint,$basket_id,$table)[0]->gene_list);
	$arr =array_merge($list_array,array_filter($active_list));  
	$list=implode(",",array_unique($arr));
	
	if(count(isactiveExist($db_name,$fingerprint,$table))==0){
		$sql = "UPDATE $table SET genelist_flag=1 where fingerprint=:fingerprint and gene_basket_id=:basket_id;UPDATE $table SET gene_list=:list WHERE fingerprint=:fingerprint and gene_basket_id=:basket_id";		
	}else{
		$sql = "UPDATE $table SET gene_list=:list WHERE fingerprint=:fingerprint and gene_basket_id=:basket_id";	
	}
	  try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':basket_id',$basket_id);
		$stmt->bindParam(':list',$list);
        $stmt->execute();
        echo '{"notice": {"text": "GeneList UPDATED"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }	
});


//Clear active GeneList by basket id
$app->post('/clear_list_by_id', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $basket_id = $request->getParam('basket_id');
	$table = $request->getParam('table');
	
		$sql = "UPDATE $table SET gene_list='' WHERE fingerprint=:fingerprint and gene_basket_id=:basket_id";	
	  try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':basket_id',$basket_id);
        $stmt->execute();
        echo '{"notice": {"text": "GeneList CLEARED"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }	
});

//Delete GeneList by basket id
$app->post('/delete_list_by_id', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $basket_id = $request->getParam('basket_id');
	$table = $request->getParam('table');
	
		$sql = "DELETE from $table WHERE fingerprint=:fingerprint and gene_basket_id=:basket_id";	
	  try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':basket_id',$basket_id);
        $stmt->execute();
        echo '{"notice": {"text": "GeneList DELETED"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }	
});


//Remove genes from the list by basket id
$app->post('/remove_genes_by_id', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $basket_id = $request->getParam('basket_id');
	$table = $request->getParam('table');
	$listx = $request->getParam('list');
	$list_array=explode(",",$listx);
	$active_list = explode(",",islistExist($db_name,$fingerprint,$basket_id,$table)[0]->gene_list);
	$arr = array_diff($active_list,$list_array); 
	$list=implode(",",array_unique($arr));
	$sql = "UPDATE $table SET gene_list='$list' WHERE fingerprint=:fingerprint and gene_basket_id=:basket_id";
	  try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':basket_id',$basket_id);
		//$stmt->bindParam(':list',$list);
        $stmt->execute();
        echo '{"notice": {"text": "'.$listx.' genes have been removed from the GeneList"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }	
});

//Remove few genes from the active list
$app->post('/remove_active_genes', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
	$table = $request->getParam('table');
	$listx = $request->getParam('list');
	$list_array=explode(",",$listx);
	$active_list = explode(",",isactiveExist($db_name,$fingerprint,$table)[0]->gene_list);
	$arr = array_diff($active_list,$list_array); 
	$list=implode(",",array_unique($arr));
	$sql = "UPDATE $table SET gene_list='$list' WHERE fingerprint=:fingerprint and genelist_flag=1";
	  try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		//$stmt->bindParam(':list',$list);
        $stmt->execute();
        echo '{"notice": {"text": "'.$listx.' genes have been removed from the GeneList"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }	
});

//Rename  list by basket id
$app->post('/rename_list_by_id', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $basket_id = $request->getParam('basket_id');
	$table = $request->getParam('table');
	$list_name= $request->getParam('list_name'); 
	$sql = "UPDATE $table SET gene_basket_name=:list_name WHERE fingerprint=:fingerprint and gene_basket_id=:basket_id";
	  try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':basket_id',$basket_id);
		$stmt->bindParam(':list_name',      $list_name);
        $stmt->execute();
        echo '{"notice": {"text": "'.$list_name.' renamed"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }	
});


//Add or Update cross  list by name this function is for cross species list
$app->post('/create_list_by_name', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
	$list_name= $request->getParam('list_name');
	$list= $request->getParam('list');
	$table = $request->getParam('table');
	$list = str_replace(';', ',', $list);
	$list_array=explode(",",$list);  
	$list=implode(",",array_unique($list_array));
	
	if(count(islistExistByName($db_name,$fingerprint,$list_name,$table))==0){
		$sql = "UPDATE $table SET genelist_flag=0 where fingerprint=:fingerprint;INSERT INTO $table(gene_basket_name,gene_list,fingerprint,genelist_time,genelist_flag) VALUES (:list_name,:list,:fingerprint,NOW(),1);";		
	}else{
		$sql = "UPDATE $table SET genelist_flag=0 where fingerprint=:fingerprint;UPDATE $table SET gene_list=:list,genelist_flag=1 WHERE fingerprint=:fingerprint and gene_basket_name=:list_name;";
	}
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',  $fingerprint);
        $stmt->bindParam(':list_name',      $list_name);
        $stmt->bindParam(':list',      $list);
        $stmt->execute();
        echo json_encode('{"notice": {"text": "Updated cross species list"}');
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

//Remove genes from the list by basket name
$app->post('/remove_genes_by_name', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$fingerprint = $request->getParam('fingerprint');
    $list_name= $request->getParam('list_name');
	$table = $request->getParam('table');
	$listx = $request->getParam('list');
	$list_array=explode(",",$listx);
	$active_list = explode(",",islistExistByName($db_name,$fingerprint,$list_name,$table)[0]->gene_list);
	$arr = array_diff($active_list,$list_array); 
	$list=implode(",",array_unique($arr));
	$sql = "UPDATE $table SET gene_list='$list' WHERE fingerprint=:fingerprint and gene_basket_name=:list_name";
	  try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':fingerprint',$fingerprint);
		$stmt->bindParam(':list_name',      $list_name);
		//$stmt->bindParam(':list',$list);
        $stmt->execute();
        echo '{"notice": {"text": "'.$listx.' genes have been removed from the GeneList"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }	
});

//Create table if not exists
$app->post('/create_table', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$table_name= $request->getParam('table_name');
		$sql = "DROP TABLE IF EXISTS `$table_name`;CREATE TABLE $table_name (`gene_basket_id` int(10) NOT NULL AUTO_INCREMENT,  `gene_basket_name` varchar(100) COLLATE latin1_general_ci NOT NULL,   `gene_list` mediumtext COLLATE latin1_general_ci,   `fingerprint` varchar(255) CHARACTER SET utf8 DEFAULT NULL,   `genelist_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,   `genelist_flag` bit(1) DEFAULT b'0',   PRIMARY KEY (`gene_basket_id`) ) ENGINE=MyISAM AUTO_INCREMENT=232 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;";		
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':table_name',  $table_name);
        $stmt->execute();
        echo '{"notice": {"text": "New table created"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//Get genes for description
$app->get('/get_genes', function(Request $request, Response $response){
	$db_name = $request->getParam('name');
	$table = $request->getParam('table');
	$fingerprint = $request->getParam('fingerprint');
	 $description= $request->getParam('desc');
    $sql = "SELECT gene_id FROM $table where description like '%$description%' limit 20";
    try{
        $db = new db();
        $db = $db->connect($db_name);
        $stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
		echo json_encode($genelist_results);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


//Return an array with elements or emepty array depending on the exsistence of active genelist by given database name and fingerprint id.
function isactiveExist($db_name,$fingerprint,$table) {
    $sql = "SELECT * FROM $table where fingerprint='$fingerprint'and genelist_flag=1";
    try {
        $db = new db();
        $db = $db->connect($db_name);
		$stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
		return $genelist_results;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


//Return existsing genelist by gene basket id
function islistExist($db_name,$fingerprint,$basket_id,$table) {
    $sql = "SELECT * FROM $table where fingerprint='$fingerprint' and gene_basket_id='$basket_id'";
    try {
        $db = new db();
        $db = $db->connect($db_name);
		$stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
		return $genelist_results;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Return existsing genelist by gene list name
function islistExistByName($db_name,$fingerprint,$list_name,$table) {
    $sql = "SELECT * FROM $table where fingerprint='$fingerprint' and gene_basket_name='$list_name'";
    try {
        $db = new db();
        $db = $db->connect($db_name);
		$stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
		return $genelist_results;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Return genelist by fingerprintid
function getgenelistByFingerprint($db_name,$fingerprint,$table) {
    $sql = "SELECT * FROM $table where fingerprint='$fingerprint'";
    try {
        $db = new db();
        $db = $db->connect($db_name);
		$stmt = $db->query($sql);
        $genelist_results = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
		return $genelist_results;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}





$app->run();