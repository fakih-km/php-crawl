<!-- BUKALAPAK -->

<?php
include('simple_html_dom.php');
include('config.php');

error_reporting(0);
// get DOM from URL or file
$html = file_get_html('https://www.bukalapak.com/c/hobi-koleksi/buku/komputer-487?from=navbar_categories&page=3&source=navbar');

$sql_id = "SELECT *
    FROM komputer
    ORDER BY id DESC
    LIMIT 1";
$stmt_id = $DB_con->prepare($sql_id);
$stmt_id->execute();
$result_id = $stmt_id->fetchAll(PDO::FETCH_ASSOC);

foreach($result_id  as $row_id ){
    $no_id = (int)$row_id ['id'];
}
if($no_id >0){
	$no_urut = $no_id + 1;
	$no_urut_2 = $no_id + 1;
	$no_urut_3 = $no_id + 1;
}
else
{
	$no_urut = 1;
	$no_urut_2 = 1;
	$no_urut_3 = 1;
}

// find all link	
foreach($html->find('img.product-media__img') as $e){
	 $image= $e->src;
	$stmt = $DB_con->prepare("INSERT INTO komputer(gambar) VALUES(:pvalue1)");
	$stmt->bindParam(':pvalue1',$image);
	$stmt->execute();

}

foreach($html->find('a.product__name') as $e){
	$product_name= $e->innertext; 
	$stmt = $DB_con->prepare("UPDATE komputer SET nama=:pvalue2 WHERE id = :pid");
	$stmt->bindParam(':pvalue2',$product_name);
	$stmt->bindParam(':pid',$no_urut);
	$stmt->execute();
	$no_urut++;
}


foreach($html->find('a.product__name') as $e){
	$product_link= $e->href; 
	$stmt = $DB_con->prepare("UPDATE komputer SET link=:pvalue3 WHERE id = :pid");
	$stmt->bindParam(':pvalue3',$product_link);
	$stmt->bindParam(':pid',$no_urut_2);
	$stmt->execute();
	$no_urut_2++;
}

foreach($html->find('span.amount') as $e){
	$amount = $e->innertext; 
	
	$stmt = $DB_con->prepare("UPDATE komputer SET harga=:pvalue4 WHERE id = :pid");
	$stmt->bindParam(':pvalue4',$amount);
	$stmt->bindParam(':pid',$no_urut_3);
	$stmt->execute();
	$no_urut_3++;
}


echo 'sukses';

?>