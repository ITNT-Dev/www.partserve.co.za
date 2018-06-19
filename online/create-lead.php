<!DOCTYPE html>


<?php
require_once('../include/db_access.php'); 
session_start();
//var_dump($_GET); die();
unset($_SESSION['lead_num']);
if(isset($_GET['id'])){
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql = $sql = "SELECT *
			FROM customers c
			LEFT JOIN titles tl ON ( tl.titleId = c.custTitleId )
			LEFT JOIN customer_assets ca ON ( ca.assetCustomerId = c.custId )
			LEFT JOIN testtags tg ON ( ca.assetTagNo = tg.tagNo )
			LEFT JOIN dropdown_models md ON ( ca.assetModelId = md.modelId )
			LEFT JOIN dropdown_makes mk ON ( mk.makeId = md.modelMakeId )
			LEFT JOIN billable bl ON ( ca.assetBillId = bl.billId )
			LEFT JOIN products pr ON ( pr.productId = ca.assetProductId )
			 WHERE custId = '".$_GET['id']."'";
		
		$result = $dbObject->dbQuery($sql);


		while($row = $dbObject->dbNextRecord($result))
		{
			
			$client_validates[] = $row['custFirstName']." ".$row['custSurname'];
			$client_validates[] = $row['custIDNumber'];
			$client_validates[] = $row['custEmail'];
			$client_validates[] = $row['custCellNo'];
			$client_validates[] = $row['streetAddress'];
			$client_validates[] = $row['streetArea'];
			$client_validates[] = $row['streetCity'];
			$client_validates[] = $row['streetCode'];
			$client_validates[] = $row['assetBillId'];
			$client_tested = '';
		}
		$publish = "<a href='create-lead.php?publish=".$_GET['id']."'>Publish client Info</a>";
	}

if(isset($_GET['publish'])){
	

		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql = $sql = "SELECT *
			FROM customers c
			LEFT JOIN titles tl ON ( tl.titleId = c.custTitleId )
			LEFT JOIN customer_assets ca ON ( ca.assetCustomerId = c.custId )
			LEFT JOIN testtags tg ON ( ca.assetTagNo = tg.tagNo )
			LEFT JOIN dropdown_models md ON ( ca.assetModelId = md.modelId )
			LEFT JOIN dropdown_makes mk ON ( mk.makeId = md.modelMakeId )
			LEFT JOIN billable bl ON ( ca.assetBillId = bl.billId )
			LEFT JOIN products pr ON ( pr.productId = ca.assetProductId )
			 WHERE custId = '".$_GET['publish']."'";
		
		$result = $dbObject->dbQuery($sql);


		while($row = $dbObject->dbNextRecord($result))
		{
			$publish_item[] = $row['custFirstName']." ".$row['custSurname'];
			$publish_item[] = $row['custIDNumber'];
			$publish_item[] = $row['custEmail'];
			$publish_item[] = $row['custCellNo'];
			$publish_item[] = $row['streetAddress'];
			$publish_item[] = $row['streetArea'];
			$publish_item[] = $row['streetCity'];
			$publish_item[] = $row['streetCode'];
			$publish_item[] = $row['assetBillId'];
			$client_tested = '';
		}
		//$reverse_info = "<a href='create-lead.php?view=".$_SESSION['revert']."'>Revert to intial info</a>";
	}




if(isset($_POST['validate_search'])){
	
	
	if (isset($_POST['id_search']) && $_POST['id_search'] != '')
    {
		
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql = "SELECT *
			FROM customers
			 WHERE custIDNumber = '".$_POST['id_search']."'";
		
		$result = $dbObject->dbQuery($sql);

         $clients_in_db = '';
		while($row = $dbObject->dbNextRecord($result))
		{
			$clients_in_db .= "
				<a href='?id=".$row['custId']."'>".$row['custFirstName']." ".$row['custSurname']." ".$row['custIDNumber']."</a><br/>";
			$client_validated = '';
			$client_tested = '';
		}
    
	}
	
	if (isset($_POST['cell_search']) && $_POST['cell_search'] != '')
		{
			$dbObject = new dbObject();
			$dbObject->dbConnect();
			$sql = "SELECT *
			FROM customers 
			WHERE custCellNo = '".$_POST['cell_search']."'";
    
			$result = $dbObject->dbQuery($sql);
			$clients_in_db = '';
			while($row = $dbObject->dbNextRecord($result))
			{
				$clients_in_db .= "
				<a href='?id=".$row['custId']."'>".$row['custFirstName']." ".$row['custSurname']." ".$row['custIDNumber']."</a><br/>";
			$client_validated = '';
				$client_tested = '';
				
			}
	}

	
	
	
	
	if (isset($_POST['tag_search']) && $_POST['tag_search'] != '')
		{
			 require_once('../include/db_access.php');
			$dbObject = new dbObject();
			$dbObject->dbConnect();
			$sql = "SELECT *
			FROM customers c
			LEFT JOIN titles tl ON ( tl.titleId = c.custTitleId )
			LEFT JOIN customer_assets ca ON ( ca.assetCustomerId = c.custId )
			LEFT JOIN testtags tg ON ( ca.assetTagNo = tg.tagNo )
			LEFT JOIN dropdown_models md ON ( ca.assetModelId = md.modelId )
			LEFT JOIN dropdown_makes mk ON ( mk.makeId = md.modelMakeId )
			LEFT JOIN billable bl ON ( ca.assetBillId = bl.billId )
			LEFT JOIN products pr ON ( pr.productId = ca.assetProductId )
			WHERE assetTagNo = '".$_POST['tag_search']."'
			GROUP BY c.custFirstName";
    
			$result = $dbObject->dbQuery($sql);
			$clients_in_db = '';
			while($row = $dbObject->dbNextRecord($result))
			{
				$clients_in_db .= "
				<a href='?id=".$row['custId']."'>".$row['custFirstName']." ".$row['custSurname']." ".$row['custIDNumber']."</a><br/>";
			$client_validated = '';
				$client_tested = '';
				
			}
	}

	
	
	
	
	if (isset($_POST['reg_search']) && $_POST['reg_search'] != '')
		{
			$dbObject = new dbObject();
        $dbObject->dbConnect();
        $sql = "SELECT *
		FROM customers c
		LEFT JOIN titles tl ON ( tl.titleId = c.custTitleId )
		LEFT JOIN customer_assets ca ON ( ca.assetCustomerId = c.custId )
		LEFT JOIN testtags tg ON ( ca.assetTagNo = tg.tagNo )
		LEFT JOIN dropdown_models md ON ( ca.assetModelId = md.modelId )
		LEFT JOIN dropdown_makes mk ON ( mk.makeId = md.modelMakeId )
		LEFT JOIN billable bl ON ( ca.assetBillId = bl.billId )
		LEFT JOIN products pr ON ( pr.productId = ca.assetProductId )
		WHERE assetRegNo = '".$_POST['reg_search']."'
		GROUP BY c.custFirstName";
    
	$result = $dbObject->dbQuery($sql);
    
			$clients_in_db = '';
			while($row = $dbObject->dbNextRecord($result))
			{
				$clients_in_db .= "
				<a href='?id=".$row['custId']."'>".$row['custFirstName']." ".$row['custSurname']." ".$row['custIDNumber']."</a><br/>";
			$client_validated = '';
				$client_tested = '';
			}
	}

	
	if (!isset($client_validated))
    {
		$error = "Client is not in our Database";
		$client_tested = '';
	}
	
}
    ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create A Lead</title>

    <!-- Font Awesome and Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Bootstrap -->

    <link href="css/hover-min.css" rel="stylesheet">
    <link href="css/ionicons.min.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link href="css/animate.min.css" rel="stylesheet"> 
	<link href="css/animate.css" rel="stylesheet" />	
	<link href="css/style.css" rel="stylesheet">

	<!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->

  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	 <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->   
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script> 
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 

	  
    <script type="text/javascript">
  $(document).ready(function(){

	$(".update_my_btn").hide(); 
	$(".leadnotes").hide(); 
	$(".save_my_btn").show();
	$("#qualified-leads").hide();
	$("#contact-made").hide();
	$("#schedulled-lead").hide();
	$(".notes_history_btn").hide(); 
	$("#qualified-leads").click(function(){
		$.post("ajax_update_qualified.php",
				{

				},
				function(data,status){
					$("#lead_show_notes").html(data);
					
				});
		
	});
	$("#contact-made").click(function(){
		
		$.post("ajax_update_contact.php",
				{

				},
				function(data,status){
					$("#lead_show_notes").html(data);
					
				});
	});
	$("#schedulled-lead").click(function(){
		
		$.post("ajax_update_schedule.php",
				{

				},
				function(data,status){
					$("#lead_show_notes").html(data);
					
				});
	});
	
	
	
	
	$('#t_test').click(function(){
	$res = $('#notes_id_id_1').text();
	alert($res);
	});
	
	
	 $('#check_notes1').click(function(){
		 var txt_notes = $('#notes_content_1').text();
		 var id = $('#notes_id_id_1').text();
		 var txt_notes_id = $('#notes_id_1').text();
		
		 $("#update_notes").val("ys");
		 $("update_notes_lead_num").val(txt_notes);
		 $("#update_notes_id").val(id);
				
		 
	 });
	 $('#check_notes2').click(function(){
		 var txt_notes = $('#notes_content_2').text();
		 var id = $('#notes_id_id_2').text();
		 var txt_notes_id = $('#notes_id_2').text();
		 
		  $("#update_notes").val(txt_notes_id);
		 $("update_notes_lead_num").val(txt_notes);
		 $("#update_notes_id").val(id);
		 
	 });
	 $('#check_notes3').click(function(){
		 var txt_notes = $('#notes_content_3').text();
		 var id = $('#notes_id_id_3').text();
		 var txt_notes_id = $('#notes_id_3').text();
		  $("#update_notes").val(txt_notes_id);
		 $("update_notes_lead_num").val(txt_notes);
		 $("#update_notes_id").val(id);
		 
	 });
	 $('#check_notes4').click(function(){
		 var txt_notes = $('#notes_content_4').text();
		 var id = $('#notes_id_id_4').text();
		 var txt_notes_id = $('#notes_id_4').text();
		  $("#update_notes").val(txt_notes_id);
		 $("update_notes_lead_num").val(txt_notes);
		 $("#update_notes_id").val(id);
		 
	 });
	 $('#check_notes5').click(function(){
		 var txt_notes = $('#notes_content_5').text();
		 var id = $('#notes_id_id_5').text();
		 var txt_notes_id = $('#notes_id_5').text();
		 $("#update_notes").val(txt_notes_id);
		 $("update_notes_lead_num").val(txt_notes);
		 $("#update_notes_id").val(id);
		 
	 });
	 $('#check_notes6').click(function(){
		 var txt_notes = $('#notes_content_6').text();
		 var id = $('#notes_id_id_6').text();
		 var txt_notes_id = $('#notes_id_6').text();
		  $("#update_notes").val(txt_notes_id);
		 $("update_notes_lead_num").val(txt_notes);
		 $("#update_notes_id").val(id);
	 });
	 $('#check_notes7').click(function(){
		 var txt_notes = $('#notes_content_7').text();
		 var id = $('#notes_id_id_7').text();
		 var txt_notes_id = $('#notes_id_7').text();
		  $("#update_notes").val(txt_notes_id);
		 $("update_notes_lead_num").val(txt_notes);
		 $("#update_notes_id").val(id);
		 
	 });
	
		

		
		$(".update_my_btn").click(function(){
              var user = $("#user").val();
		         var lead_by = $("#lead_by").val();
			     var f_name = $("#f_name").val();
				  var id_num = $("#id_num").val();
				  var email_main = $("#email_main").val();
				  var phone = $("#phone").val();
				  var product_type = $("#product_type").val();
				  var source = $("#source").val();
				  var h_us = $("#h_us").val();
				  var main_address = $("#main_address").val();
				  var street_adress = $("#street_number").val();
				  var city = $("#locality").val();				  
				  var province = $("#administrative_area_level_1").val();
				  var zip_code = $("#postal_code").val();
				  var country = $("#country").val();
				  var b_number = $("#b_number").val();
				  var notes = $("#notes").val();
				  var quantity = $("#quantity").val();
				  var pay_method = $("#pay_method").val();
				  var fee = $("#fee").val();
				  var t_install1 = $("#t_install1").val();
				  var p_type1 = $("#p_type1").val();
				  var v_make1 = $("#v_make1").val();
				  var model1 = $("#model1").val();
				  var reg_num = $("#reg_num").val();
				  var v_num = $("#v_num").val();
				  var reg_num2 = $("#reg_num2").val();
				  var v_num2 = $("#v_num2").val();
				  var reg_num3 = $("#reg_num3").val();
				  var v_num3 = $("#v_num3").val(); 
				  var fee = $("#fee").val();
				  var pay_method = $("#pay_method").val();
				    var ck = $("#ck").val();
				  var vat = $("#vat").val();
				  var alt_phone = $("#alt_phone").val();
				  var date_reminder = $("#date_reminder").val();
				  var alt_email = $("#alt_email").val();
				  var color1 = $("#color1").val();
				  var color2 = $("#color2").val();
				  var color3 = $("#color3").val();
				 
			$.post("ajax_update.php",
				{
				  user_keep_id: user,
				  f_name: f_name,
				  email_main: email_main,
				   
				  product_type:"test",
				  source:source,
				  lead_by:lead_by,
				  address:main_address,
				  h_us:h_us,
				  notes:notes,
				  quantity:quantity,
				  phone:phone,
				   
				  street_adress:street_adress,
				  address2:"nothing",
				  city:city,
				  province:province,
				  zip_code:zip_code,
				  country:country,
				  b_number:b_number,
				  p_type1:p_type1,
				  t_install1:t_install1,
				  v_make1:v_make1,
				  model1:model1,
				  
				  color1:color1,
				  notes: notes,
				  
				  quantity:quantity,
				  color2:"color2",
				  color3:"color3",
				  model3:"model3",
				  v_make3:"v_make3",
				  ck:ck,
				  vat:vat, 
				  alt_phone:alt_phone,
				  date_reminder:date_reminder,
				  alt_email:alt_email,
				  pay_method:pay_method,
				  fee:fee,
				  id_num:id_num
				  
				}, 
				function(data,status){
					alert("Data: " + data + "\nStatus: " + status);
					$(".update_my_btn").show();
					$(".save_my_btn").hide();
					$("#qualified-leads").show();
					$("#contact-made").show();
					$("#schedulled-lead").show();
					
					
				});
				
		});

		
		
		
		
		
		
		$(".save_my_btn").click(function(){
		
   
		var myFormErors = '0';
		         var user = $("#user").val();
		         var lead_by = $("#lead_by").val();
			     var f_name = $("#f_name").val();
				  var id_num = $("#id_num").val();
				  var email_main = $("#email_main").val();
				  var phone = $("#phone").val();
				  var product_type = $("#product_type").val();
				  var source = $("#source").val();
				  var h_us = $("#h_us").val();
				  var main_address = $("#main_address").val();
				  var street_adress = $("#street_number").val();
				  var city = $("#locality").val();				  
				  var province = $("#administrative_area_level_1").val();
				  var zip_code = $("#postal_code").val();
				  var country = $("#country").val();
				  var b_number = $("#b_number").val();
				  var notes = $("#notes").val();
				  var quantity = $("#quantity").val();
				  var pay_method = $("#pay_method").val();
				  var fee = $("#fee").val();
				  var t_install1 = $("#t_install1").val();
				  var p_type1 = $("#p_type1").val();
				  var v_make1 = $("#v_make1").val();
				  var model1 = $("#model1").val();
				  var reg_num = $("#reg_num").val();
				  var v_num = $("#v_num").val();
				  var reg_num2 = $("#reg_num2").val();
				  var v_num2 = $("#v_num2").val();
				  var reg_num3 = $("#reg_num3").val();
				  var v_num3 = $("#v_num3").val(); 
				  var fee = $("#fee").val();
				  var pay_method = $("#pay_method").val();
				    var ck = $("#ck").val();
				  var vat = $("#vat").val();
				  var alt_phone = $("#alt_phone").val();
				  var date_reminder = $("#date_reminder").val();
				  var alt_email = $("#alt_email").val();
				  var color1 = $("#color1").val();
				  var color2 = $("#color2").val();
				  var color3 = $("#color3").val();
				 
				 
		
		if(f_name== ''){
			$("#f_name").addClass("vali");
			myFormErors = '1';
		}
		if(id_num == ''){
			$("#id_num").addClass("vali");
			myFormErors = '1';
		}
	    if(email_main == ''){
			$("#email_main").addClass("vali");
			myFormErors = '1';
		}
		if(phone == ''){
			$("#phone").addClass("vali");
			myFormErors = '1';
		}
		if(source == '0'){
			$("#source").addClass("vali");
			myFormErors = '1';
		}
		if(h_us == '0'){
			$("#h_us").addClass("vali");
			myFormErors = '1';			
		}
		if(notes == ''){
			$("#notes").addClass("vali"); 
			myFormErors = '1';			
		}
		if(main_address == ''){
			$(".main_address").addClass("vali"); 
			myFormErors = '1';			
		}
		if(street_adress == ''){
			$("#street_number").addClass("vali");
			myFormErors = '1';			
		}
		if(city == ''){
			$("#locality").addClass("vali");
			myFormErors = '1';			
		}
		if(province == ''){
			$("#administrative_area_level_1").addClass("vali"); 
			myFormErors = '1';			
		}
		if(zip_code == ''){
			$("#postal_code").addClass("vali"); 
			myFormErors = '1';			
		}
		
		
		if(country == ''){
			$("#country").addClass("vali"); 
			myFormErors = '1';			
		}
		if(b_number == ''){
			$("#b_number").addClass("vali"); 
			myFormErors = '1';			
		}
		if(quantity == ''){
			$("#quantity").addClass("vali"); 
			myFormErors = '1';			
		}
		if(pay_method == '0'){
			$("#pay_method").addClass("vali"); 
			myFormErors = '1';			
		}
		if(fee == ''){
			$("#fee").addClass("vali"); 
			myFormErors = '1';			
		}
		if(t_install1 == '0'){
			$("#t_install1").addClass("vali"); 
			myFormErors = '1';			
		}
		if(v_make1 == '0'){
			$("#v_make1").addClass("vali"); 
			myFormErors = '1';			
		}
		if(color1 == '0'){
			$("#color1").addClass("vali"); 
			myFormErors = '1';			
		}
		if(model1 == '0'){
			$("#model1").addClass("vali"); 
			myFormErors = '1';			
		}
		if(reg_num == ''){
			$("#reg_num").addClass("vali"); 
			myFormErors = '1';			
		}
		if(v_num == ''){
			$("#v_num").addClass("vali"); 
			myFormErors = '1';			
		}
		
		
		
		
		
		
		// end here
		
			if(myFormErors == '0') 
			{
				
				var user = $("#user").val();
		         var lead_by = $("#lead_by").val();
			     var f_name = $("#f_name").val();
				  var id_num = $("#id_num").val();
				  var email_main = $("#email_main").val();
				  var phone = $("#phone").val();
				  var product_type = $("#product_type").val();
				  var source = $("#source").val();
				  var h_us = $("#h_us").val();
				  var main_address = $("#main_address").val();
				  var street_adress = $("#street_number").val();
				  var city = $("#locality").val();				  
				  var province = $("#administrative_area_level_1").val();
				  var zip_code = $("#postal_code").val();
				  var country = $("#country").val();
				  var b_number = $("#b_number").val();
				  var notes = $("#notes").val();
				  var quantity = $("#quantity").val();
				  var pay_method = $("#pay_method").val();
				  var fee = $("#fee").val();
				  var t_install1 = $("#t_install1").val();
				  var p_type1 = $("#p_type1").val();
				  var p_type2 = $("#p_type2").val();
				  var p_type3 = $("#p_type3").val();
				  var v_make1 = $("#v_make1").val();
				  var model1 = $("#model1").val();
				  var reg_num = $("#reg_num").val();
				  var v_num = $("#v_num").val();
				  var reg_num2 = $("#reg_num2").val();
				  var v_num2 = $("#v_num2").val();
				  var reg_num3 = $("#reg_num3").val();
				  var v_num3 = $("#v_num3").val(); 
				  var fee = $("#fee").val();
				  var pay_method = $("#pay_method").val();
				    var ck = $("#ck").val();
				  var vat = $("#vat").val();
				  var alt_phone = $("#alt_phone").val();
				  var date_reminder = $("#date_reminder").val();
				  var alt_email = $("#alt_email").val();
				  var color1 = $("#color1").val();
				  var color2 = $("#color2").val();
				  var color3 = $("#color3").val();
				$("#f_name").removeClass("vali");
				$("#id_num").removeClass("vali");
				$("#email_main").removeClass("vali");
				$("#phone").removeClass("vali");
				$("#source").removeClass("vali");
				$("#h_us").removeClass("vali");
				$("#notes").removeClass("vali");
				$(".main_address").removeClass("vali");
				$("#street_number").removeClass("vali");
				$("#locality").removeClass("vali");
				$("#administrative_area_level_1").removeClass("vali");
				$("#postal_code").removeClass("vali");
				$("#country").removeClass("vali");
				$("#b_number").removeClass("vali"); 
				$("#quantity").removeClass("vali");
				$("#pay_method").removeClass("vali");
				$("#fee").removeClass("vali"); 
				$("#t_install1").removeClass("vali");
				$("#v_make1").removeClass("vali"); 
				$("#color1").removeClass("vali"); 
				$("#model1").removeClass("vali");
				$("#reg_num").removeClass("vali");
				$("#v_num").removeClass("vali"); 
			
		
				
				
				$.post("ajax_callback.php",
				{
					
				 user_keep_id: user,
				  f_name: f_name,
				  email_main: email_main,
				   
				  product_type:"test",
				  source:source,
				  lead_by:lead_by,
				  address:main_address,
				  h_us:h_us,
				  notes:notes,
				  quantity:quantity,
				  phone:phone,
				   
				  street_adress:street_adress,
				  address2:"nothing",
				  city:city,
				  province:province,
				  zip_code:zip_code,
				  country:country,
				  b_number:b_number,
				
				  p_type1:p_type1,
				  
				  t_install1:t_install1,
				  
				  v_make1:v_make1,
				  model1:model1,
				  
				  color1:color1,
				  notes: notes,
				  
				  quantity:quantity,
				  color2:"color2",
				  color3:"color3",
				  model3:"model3",
				  v_make3:"v_make3",
				  ck:ck,
				  vat:vat, 
				  alt_phone:alt_phone,
				  date_reminder:date_reminder,
				  alt_email:alt_email,
				  pay_method:pay_method,
				  fee:fee,
				  id_num:id_num
				  
				 
				  
				},
				function(data,status){
					alert("Data: demu " + data + "\nStatus: " + status);
					var gen_num = data; 
					$("#my_id").text(gen_num);
					$("#lead_nums").text(gen_num);
					$(".leadnotes").show();
					$(".notes_lead_num").val(gen_num);
					$(".update_my_btn").show();
					$(".save_my_btn").hide();
					$("#qualified-leads").show();
					$("#contact-made").show();
					$("#schedulled-lead").show();
					$(".notes_history_btn").show(); 
					
				});
				
				
			}
		
    
  });
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		$("#save_notes").click(function(){
			var notes = $("#notes").val();
			var lead_num = "<?php echo $_SESSION['lead_num']; ?>";
			$.post("ajax_insert_notes.php",
				{
				  notes: notes,
				  lead_num:lead_num
				},
				function(data,status){
					$("#hist_notes").html(data);
					
				});
			$("#notes").val("");

			});
			
		$("#update_notes").click(function(){
			var notes = $("#notes").val();
			var lead_num = "<?php echo $_SESSION['lead_num']; ?>";
			$.post("ajax_insert_notes.php",
				{
				  notes: notes,
				  lead_num:lead_num
				},
				function(data,status){
					$("#lead_show_notes").html(data);
					
				});
			$("#notes").val("");

			});
		$("#email_main").prop("required", true);
		
});			
</script>
<style> 

.vali {
  border-color: #e63339;
  outline: 0;
  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(230, 51, 57, .6);
          box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(230, 51, 57, .6);
}
</style>





  </head>
  <body>

  <?php
  
  if(!isset($client_tested)){
	  $str = <<<MY_MARKER
<script type="text/javascript">
  $(document).ready(function(){
    $("#f_main :input, select, #main_submit").prop("disabled", true);

}); 
</script>

MY_MARKER;

echo $str;
  }
if(isset($_GET['view'])){
		  $str = <<<MY_MARKER
<script type="text/javascript">
  $(document).ready(function(){
    $("#f_main :input, select, #main_submit").prop("disabled", false);

}); 
</script>

MY_MARKER;

echo $str;
$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql = $sql = "SELECT * from leads_captures where id = ".$_GET['view']." order by id desc";
		$result = $dbObject->dbQuery($sql);
		$row = $dbObject->dbNextRecord($result);
				$view_mine[] = $row['lead_by'];
				$view_mine[] = $row['user'];
				$view_mine[] = $row['full_name'];
				$view_mine[] = $row['id_num'];
				$view_mine[] = $row['email'];
				$view_mine[] = $row['phone'];
				$view_mine[] = $row['source'];
				$view_mine[] = $row['hear_from'];
				$view_mine[] = $row['address'];
				$view_mine[] = $row['street_adress'];
				$view_mine[] = $row['city'];
				$view_mine[] = $row['province'];
				$view_mine[] = $row['zip_code'];
				$view_mine[] = $row['country'];
				$view_mine[] = $row['p_type1'];
				$view_mine[] = $row['t_install1'];
				$view_mine[] = $row['b_number'];
				
				
				
				
				
				$_SESSION['lead_num'] = $row['lead_num'];

			
		$revert = $_GET['view'];
	}
	?>
	

	<!-- Navigation -->
    <div id="navigation">
        
			<div class="container">
				<div class="row">
				    <div class="col-md-3">
						<div class="site-logo">
							<a href="index.php" class="brand"><img src="img/logo.png"></a>
						</div>
				    </div>
					<div class="col-md-9">	 
							<P class="pull-right">
								<a href=""><i class="fa fa-info"></i> Notifications (3) </a> &nbsp;&nbsp;
								<a href=""> Howdy (3) </a>
							</P>  
					</div>
				</div>
			</div>
			<!-- /.container -->
		
    </div> 
     <!-- /.Navigation -->
    <?php include_once 'includes/nav.php'; ?>

<section id="about">
<table style="display:none;"><tr><td id="my_id"></td></tr></table>  
		<div class="container">		
			<div class="row"> 
				<div class="col-md-12">
					<p><h1>Edit Client & Follow up <span id="lead_nums"><?php if(isset($_SESSION['lead_num'])){ echo $_SESSION['lead_num']; } ?></span></h1></p>
					<div class="panel panel-info">
					  <div class="panel-heading" style="background-color:black;">
					  	<i class="fa fa-pencil-square-o"></i> Edit Client & Follow up
						
						
						
						 
						
		
			
						
						
						
					  	<span class="pull-right"><b><?php echo " " . date("Y/m/d       h:i:sa")?></b></span>
					  </div>
					  <div class="panel-body">
					  <?php
					  if(isset($error))
					  {
						  ?>
						  <div class="row">
						<div class="col-md-3">
							<b style='color:red;'><?php echo $error; ?></b>
							
							
							
							
						</div>
						</div>
					  
					  <?php 
					  }
					  
					  
					 
					  
											if(isset($client_validated['is_com'])){
												if($client_validated['is_com'] == '1'){
													echo "<span style='color:red;'><b>(Warning: Registered company - Please expand company info below to see details!)</b></span>";
												}
											}
											
					  ?>
					  <form action="" method="post">
					  <div class="row">
						<div class="col-md-3">
							<input name="id_search" class="form-control" id="id_search" placeholder="I.D NUMBER" value="" type="text">
						</div>
						<div class="col-md-3">
							<input name="cell_search" class="form-control" id="id_search" placeholder="CELL PHONE NUMBER" value="" type="text">
						</div>
						<div class="col-md-3">
							<input name="reg_search" class="form-control" id="reg_search" placeholder="REGISTRATION" value="" type="text">
						</div>
						<div class="col-md-3">
							<input name="tag_search" class="form-control" id="tag_search" placeholder="TAG" value="" type="text">
						</div>
					</div>
					<div class="row">
						<div class="col-md-2">
							<input name="validate_search" type="submit" class="btn btn-success" value="Validate Client" style="background-color:#e63339;">
							
						</div>
					</div>
					</form>
					
					 <?php
					 if(isset($publish))
					{
						echo $publish;
					}
					 if(isset($client_validated)){
							echo "<br/><P><b> CLICK TO CHOOSE SPECIFIC CLIENT FROM LIST BELOW;</b></P>";
							echo $clients_in_db;
													
											
						}
						
					 					?>
											
					<hr/>
					<?php
					if(isset($_POST['main_form']))
					{
						$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql = "insert into leads_captures values(null,'".$_POST['f_name']."','".$_POST['email_main']."','".$_POST['product_type']."','".$_POST['source']."','".$_POST['lead_by']."','".$_POST['address']."','".$_POST['h_us']."','".$_POST['notes']."','".$_POST['quantity']."','".$_POST['phone']."','".$_POST['street_adress']."','".$_POST['address2']."','".$_POST['city']."','".$_POST['province']."','".$_POST['zip_code']."','".$_POST['country']."','".$_POST['b_number']."','".$_POST['p_type1']."','".$_POST['t_install1']."','".$_POST['v_make1']."','".$_POST['model1']."','".$_POST['color1']."','".$_POST['p_type2']."','".$_POST['t_install2']."','".$_POST['v_make2']."','".$_POST['model2']."','".$_POST['color2']."','".$_POST['p_type3']."','".$_POST['t_install3']."','".$_POST['v_make3']."','".$_POST['model3']."','".$_POST['color3']."','".$_POST['alt_name']."','".$_POST['alt_phone']."','".$_POST['alt_email']."','".$_POST['ck']."','".$_POST['vat']."', NOW(), '".$user_keep_id."')";
		$result = $dbObject->dbQuery($sql);
		echo "
		<script>
		window.location.assign('http://registertest.tracetec.co.za/leads/all-leads.php');
		</script>
		"; 
					}
					
					?>
					

  	<div class="col-md-6">
						  	<form class="form-horizontal" id="f_main" name="f_main" method="post" action="">
				                    <input name="lead_id" id ="lead_id" type="hidden">
				                    <h4>Personal Details </h4>
									<div class="form-group">
				                        <label for="firstname" class="col-sm-4 control-label">Lead Created by</label>
				                        <div class="col-sm-10">
				                            <input name="lead_by" class="form-control" id="lead_by" placeholder="Address" type="text" 
											<?php
											if(isset($view_mine)){
												?>
												
												value='<?php echo $view_mine[0]; ?>'> 
											
											<?php
											}
											else{
												?>
												
												value='<?php echo $name_str; ?>'>
												
												<?php
											}
											?>
					
											<input name="user" class="form-control" id="user" placeholder="Address" type="hidden" <?php
											if(isset($view_mine)){
												?>
												value='<?php echo $view_mine[1]; ?>'> 
											
											<?php
											}
											else{
												?>
												
												value='<?php echo $user_keep_id; ?>'>
												
												<?php
											}
											?> 
											
				                        </div>
				                      </div>
									  <div class='loader'></div> 
				                      <div class="form-group">
				                        <label for="firstname" class="col-sm-4 control-label">Full Name
										<span style="color:red;">
										<?php
										if(isset($client_validates)){
											echo $client_validates[2];
											}
											?>
										</span></label>
				                        <div class="col-sm-10">
				                            <input name="f_name" class="form-control" id="f_name" placeholder="Full Name" type="text" required='required' <?php
											
							if(isset($publish_item))
							{
								echo "value='".$publish_item[0]."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[2]."'"; 
							}
							
							?>>
				                        </div>
				                      </div>
                              
							  
							  
							     <div class="form-group">
				                        <label for="firstname" class="col-sm-8 control-label">I.D Number
										
										<span style="color:red;">
										<?php
										if(isset($client_validates)){
											echo $client_validates[1];
											}
											?>
										</span>
										</label>
				                        <div class="col-sm-10">
				                            <input name="id_num" class="form-control" id="id_num" placeholder="I.d Number" type="text" <?php
											
										if(isset($publish_item))
										{
											echo "value='".$publish_item[1]."'"; 
										}
										if(isset($view_mine))
										{
											echo "value='".$view_mine[3]."'"; 
										}
										
										?>>
				                        </div>
							  </div>
							  
				                     <div class="form-group">
				                        <label for="surname" class="col-sm-4 control-label">Email
										<span style="color:red;">
										<?php
										if(isset($client_validates)){
											echo $client_validates[2];
											}
											?>
										</span>
										
										</label>
				                        <div class="col-sm-10">
				                          <input name="email_main" class="form-control" id="email_main" placeholder="Email" type="text"  <?php
									if(isset($publish_item))
							{
								echo "value='".$publish_item[2]."'"; 
							}		
						
							if(isset($view_mine))
							{
								echo "value='".$view_mine[4]."'"; 
							}
							
							?>>
				                        </div>
				                     </div>

				                    <div class="form-group">
				                        <label for="cellnumber" class="col-sm-8 control-label">Cell Phone Number
										
										<span style="color:red;">
										<?php
										if(isset($client_validates)){
											echo $client_validates[2];
											}
											?>
										</span>
										</label>
				                        <div class="col-sm-10">
				                            <div class="input-group">
				                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
				                                <input name="phone" class="form-control" id="phone" placeholder="Cell Phone Number" type="text"  <?php
											
							if(isset($publish_item))
							{
								echo "value='".$publish_item[3]."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[5]."'"; 
							}
							 
						    ?>>
							
				                            </div>
				                        </div>
				                    </div>
									
									<div class="form-group">
				                        <label for="cellnumber" class="col-sm-4 control-label">Contact date reminder</label>
				                        <div class="col-sm-10">
				                            <div class="input-group">
				                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				                                <input name="date_reminder" class="form-control" id="date_reminder" placeholder="2017-04-22"  type="text">
											</div>
				                        </div>
				                   </div>
								   <input name="source" class="form-control" id="source" placeholder="2" value="system" type="hidden">
				                    <!--<div class="form-group">
				                        <label for="usertype_id" class="col-sm-4 control-label">Source</label>
				                        <div class="col-sm-10">
				                            <select name="source" id='source' class="form-control">
				                                <option value="0">Select</option>
												<option value="Recovery">Recovery</option>
												<option value="TraceFleet">TraceFleet</option>
												<option value="TraceSure">TraceSure</option>
												<option value="TraceHelp">TraceHelp</option>
												<option value="Contact Me">Contact Me</option>
		                                    </select>
				                        </div>
				                    </div>
									-->
				                    <div class="form-group">
				                        <label for="usertype_id" class="col-sm-5 control-label">How did you hear about us?</label>
				                        <div class="col-sm-10">
				                            <select name="h_us" id='h_us' class="form-control">
				                                <option value="0">How did you hear about us</option>
												<option value="Advert">Advert</option>
												<option value="Billboards">Billboards</option>
												<option value="Existing client">Existing client</option>
												<option value="Leaflets/Brochure">Leaflets/Brochure</option>
												<option value="Radio">Radio</option>
												<option value="Referred by dealership">Referred by dealership</option>
												<option value="Word of mouth">Word of mouth</option> 
												<option value="Internet Search">Internet Search</option>
												<option value="Magazine Advert">Magazine Advert</option>
												<option value="Racing Bikes">Racing Bikes</option>
												<option value="Tracetec Voucher">Tracetec Voucher</option>
												<option value="Tracetec Trailers">Tracetec Trailers</option> 
												<option value="Other">Other</option>
		                               		 </select>
				                        </div>
				                    </div>
			                      	     <div class="form-group">
    <label for="address1" class="col-sm-10 control-label">Enter the address here *
	<span style="color:red;">
										<?php
										if(isset($client_validates)){
											echo $client_validates[4];
											}
											?>
										</span>
	
	</label>
    <div class="col-sm-10">
        <input type="text" class="form-control main_address" name='address' onfocus="geolocate()" id="autocomplete" autocomplete="off" placeholder="Enter the address here"  <?php
											
							if(isset($publish_item))
							{
								echo "value='".$publish_item[4]."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[7]."'"; 
							}
							 
						    ?>>
							
    </div>
</div>
        <div class="form-group">
            <label for="address1" class="col-sm-5 control-label">Street Address <b>*</b>
			
			<span style="color:red;">
										<?php
										if(isset($client_validates)){
											echo $client_validates[5];
											}
											?>
										</span>
			</label>
			<div class="col-sm-10">
            <!-- <input type="text" class="form-control" id="locality" name="street_adress" autocomplete="off" value="" placeholder="Address 1"> -->
			<input type="text" class="form-control" id="street_number" name="street_adress" autocomplete="off" placeholder="Address 1" <?php
											
							if(isset($publish_item))
							{
								echo "value='".$publish_item[5]."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[8]."'"; 
							}
							 
						    ?>>
							
        </div>
		</div>
        <div class="form-group">
            <label for="city" class="col-sm-5 control-label">City <b>*</b>
			
			<span style="color:red;">
										<?php
										if(isset($client_validates)){
											echo $client_validates[6];
											}
											?>
										</span>
			</label>
			<div class="col-sm-10">
            <!-- <input type="text" class="form-control" id="city" name="city" autocomplete="off" value="" placeholder="City" /> -->
			<input type="text" class="form-control" id="locality" name="city" autocomplete="off" placeholder="City" <?php
											
							if(isset($publish_item))
							{
								echo "value='".$publish_item[6]."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[9]."'"; 
							}
							 
						    ?>>
							
        </div></div>
        <div class="form-group">
            <label for="state" class="col-sm-5 control-label">Province or State / Region <b>*</b></label>
			<div class="col-sm-10">
            <!-- <input type="text" class="form-control" id="province" name="province" autocomplete="off" value="" placeholder="State / Region" /> -->
			<input type="text" class="form-control" id="administrative_area_level_1" name="province" autocomplete="off" placeholder="State / Region" <?php
											
							if(isset($validate_view))
							{
								echo "value='".$validate_view['phone']."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[10]."'"; 
							}
							 
						    ?>>
        </div></div>
        <div class="form-group">
            <label for="postcode" class="col-sm-5 control-label">Zip Code 
			<span style="color:red;">
										<?php
										if(isset($client_validates)){
											echo $client_validates[7];
											}
											?>
										</span>
			</label>
			<div class="col-sm-10">
            <!-- <input type="text" class="form-control" name="zip_code" autocomplete="off" value="" id="zip_code" placeholder="Zip Code" /> -->
			<input type="text" class="form-control" name="postal_code" autocomplete="off" id="postal_code" placeholder="Zip Code" <?php
											
							if(isset($publish_item))
							{
								echo "value='".$publish_item[7]."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[11]."'"; 
							}
							 
						    ?>>
							
        </div></div>
        <div class="form-group">
            <label for="country" class="col-sm-5 control-label">Country <b>*</b></label>
			<div class="col-sm-10">
            <!-- <input type="text" class="form-control" name="country" id="country" required autocomplete="off" /> -->
			<input type="text" class="form-control" name="country" id="country" required autocomplete="off"  <?php
											
							if(isset($validate_view))
							{
								echo "value='".$validate_view['phone']."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[12]."'"; 
							}
							 
						    ?>>
							
        </div></div>
				                  
				                   <div class="form-group">
				                        <label for="firstname" class="col-sm-6 control-label">Billing number if existing
										<span style="color:red;">
										<?php 
										if(isset($client_validates)){
											echo $client_validates[7];
											}
											?>
										</span>
										</label>
				                        <div class="col-sm-10">
				                           <input name="b_number" class="form-control" id="b_number" placeholder="Address" required="" type="text"  <?php
											
							if(isset($publish_item))
							{
								echo "value='".$publish_item[7]."'"; 
							}
							if(isset($view_mine))
							{
								echo "value='".$view_mine[15]."'"; 
							}
							 
						    ?>>
							
				                        </div> 
			                      </div>
			                     
				               <div class="form-group">
				                        <label for="firstname" class="col-sm-4 control-label">Notes </label>
				                        	<div class="col-sm-10">
				                        		<textarea class="form-control" rows="3" id="notes"></textarea>
				                        	</div>
				                  </div>   

								  
								 <div class="form-group notes_history_btn">
									
										<div class="col-sm-10">
										<br/>
										<br/>
											<label class="control-label">Click To view Notes History | <a class="btn btn-info" data-toggle="modal" data-target="#myModal">click to view History -></a> </label>
											 <div id='lead_show_notes'>
											</div> 
										</div>
								    </div> 
								  
								  
								  
								  
								  
								  
								  
								  
			            </div>  





						

						
			            <div class="col-md-6">
				                 <div class="form-group">
										<div class="col-sm-8">
											<a data-toggle="collapse" href="#collapseExample4" aria-expanded="false" aria-controls="collapseExample4">
													<span class="glyphicon glyphicon-plus-sign" style="font-size:25px;"></span> &nbsp;&nbsp; <label>Add Company Information
													<?php
													if(isset($client_validated['is_com'])){
														if($client_validated['is_com'] == '1'){
															echo "<span style='color:red;'><b>(Warning: Is a company view Please!)</b></span>";
														}
													}
													?>
													
													
													</label> 
												</a>
										</div>
				                    <div class="form-group">
				                    	<div class="collapse" id="collapseExample4">
										  <div class="well">
										 	  <div class="form-group">
												<label for="surname" class="col-sm-4 control-label">CK No:</label>
													<div class="col-sm-10">
														<input name="ck" class="form-control" id="ck" placeholder="CK Number" type="text" value='<?php
															if(isset($client_validated))
															{
																echo $client_validated['ck'];
															}
															
															?>'>
													</div>
											  </div>
											<div class="form-group">
													<label for="surname" class="col-sm-4 control-label">VAT No:</label>
														<div class="col-sm-10">
															<input name="vat" class="form-control" id="vat" placeholder="VAT Number" type="text" value='<?php
																if(isset($client_validated))
																{
																	echo $client_validated['vat'];
																}
																
																?>'>
														</div>
											 </div>
										   </div>
										</div>
									 </div>

								 
								 
								 
								 
								 
								 
										 <div class="form-group">
				                        <label for="firstname" class="col-sm-8 control-label">
										<br/>Quantity
										</label>
				                        <div class="col-sm-10">
				                            <input name="quantity" class="form-control" id="quantity" placeholder="Quantity" type="text" >
				                        </div>
										
										<div class="form-group">
				                        <label for="cellnumber" class="col-sm-4 control-label">Payment Method</label>
				                        <div class="col-sm-10">
				                             <select class="form-control" name="p_type1" id="pay_method">
												<option value="0">--Select--</option>
												<option value="cash">Cash</option>
												<option value="Credit card">Credit card</option>
												<option  value="edcon">EDCON</option>
												<option value="eft">EFT</option>
												<option value="mra">MRA</option>
											 </select>
										</div>
										
										</div>
										
										<div class="form-group">
				                        <label for="firstname" class="col-sm-10 control-label">Installation Fee
										</label>
				                        <div class="col-sm-10">
				                            <input name="fee" class="form-control" id="fee" placeholder="Installation Fee" type="text" <?php
											
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name']."'"; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[13]."'"; 
										}
										
										?>>
				                        </div>
										
										
										
										
										
										<!--
										 <div class="form-group">
				                        <label for="firstname" class="col-sm-4 control-label">Tag Number</label>
				                        <div class="col-sm-10">
				                           <input name="tag_num" class="form-control" id="tag_num" placeholder="Tag Number" type="text" <?php
											/*
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name'].""; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[0].""; 
										}
										*/
										?>'>
				                        </div>
										<div class="form-group">
				                        <label for="firstname" class="col-sm-10 control-label">Old Tag Number /  If neccessary </label>
				                        <div class="col-sm-10">
				                            <input type="checkbox" name="old_tag_select"><input name="old_tag_num" class="form-control" id="old_tag_num" placeholder="Old Tag Number" type="text" <?php
											/*
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name'].""; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[0].""; 
										}
										
										*/ ?>'>
				                        </div>
				              -->

				                    <div class="form-group">
				                        <label for="cellnumber" class="col-sm-4 control-label">Product Type 1</label>
				                        <div class="col-sm-10">
				                             <select class="form-control" name="p_type1" id="p_type1">
		<option value="0">--Select--</option>
		<?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM products ORDER BY productName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['productName'] . "'>" . $row['productName'] . "</option>";
		}
		?>
			</select>
				                        </div>
				                  </div>

				                     <div class="form-group">
				                        <label for="surname" class="col-sm-4 control-label">Type Of Installation</label>
				                        <div class="col-sm-10">
				                         <select name="t_install1" id="t_install1" class="form-control">
										 <option value="0">--Select--</option>
		<?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM dropdown_installationtypes ORDER BY installationTypeName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['installationTypeName'] . "'>" . $row['installationTypeName'] . "</option>";
		}
		?>
			</select>	                        </div>
				                     </div>
				                    <div class="form-group">
				                        <label for="usertype_id" class="col-sm-4 control-label">Vehicle Make</label>
				                        <div class="col-sm-10">
				                            <select name="v_make1" id="v_make1" class="form-control">
											<option value="0">--Select--</option>
				                                <?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT dropdown_makes.makeId, dropdown_makes.makeName, dropdown_models.modelId FROM dropdown_makes INNER JOIN dropdown_models ON ( dropdown_models.modelMakeId = dropdown_makes.makeId ) GROUP BY modelMakeId ORDER BY makeName ASC";
		$result = $dbObject->dbQuery($sql);
		
		while ($row = mysql_fetch_array($result))
		{
			/*if (isset($row1) && (int)$row1['assetModelId'] == $row['modelId'])
			echo '<option value="' . $row['makeId'] . '" selected>' . $row['makeName'] . '</option>';
			else*/
			echo '<option value="' . $row['makeId'] . '">' . $row['makeName'] . '</option>';
		}
		?>
		                                    </select>
				                        </div>
				                    </div>

				                    <div class="form-group">
				                        <label for="usertype_id" class="col-sm-4 control-label">Model</label>
				                        <div class="col-sm-10">
				                            <select name="model1" id="model1"class="form-control">
											<option value="0">--Select--</option>
				                               <?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM dropdown_installationtypes ORDER BY installationTypeName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['installationTypeName'] . "'>" . $row['installationTypeName'] . "</option>";
		}
		?>
			</select>
		                                    </select>
				                        </div>
				                    </div>
				                    <div class="form-group">
				                        <label for="usertype_id" class="col-sm-4 control-label">Color</label>
				                        <div class="col-sm-10">
				                            <select name="color1" id="color1" class="form-control">
				                               <?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM dropdown_colours ORDER BY colourName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['colourName'] . "'>" . $row['colourName'] . "</option>";
		}
		?>
			</select>
				                        </div>
				                    </div>
				                   <div class="form-group">
				                        <label for="firstname" class="col-sm-4 control-label">Registration Number</label>
				                        <div class="col-sm-10">
				                             <input type="checkbox" name="reg_select"><input name="reg_num" class="form-control" id="reg_num" placeholder="Registration Number" type="text" <?php
											
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name']."'"; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[0]."'"; 
										}
										
										?>>
				                        </div></div>
								    <div class="form-group">
				                        <label for="firstname" class="col-sm-4 control-label">VIN Number</label>
				                        <div class="col-sm-10">
				                            <input type="checkbox" name="tag_select"><input name="v_num" class="form-control" id="v_num" placeholder="Vin Number" type="text" <?php
											
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name']."'"; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[0]."'"; 
										}
										
										?>>
				                        </div></div>
										
										
								    <div class="form-group">
				                        <div class="col-sm-10">
				                            <a data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
											<span class="glyphicon glyphicon-plus-sign" style="font-size:25px;"></span> Product Type 2
										</a>
				                        </div>
				                    </div>
									
									
									
									<div class="form-group">
				                        <div class='collapse' id="collapseExample2">
									
										    	<div class="form-group">
							                        <label for="cellnumber" class="col-sm-4 control-label">Product Type 2</label>
							                        <div class="col-sm-8">
							                            <div class="input-group">
														<select name="p_type2" id="p_type2" class="form-control">
															   <?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM products ORDER BY productName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['productName'] . "'>" . $row['productName'] . "</option>";
		}
		?>
			</select>
															</div>
														</div>
							                   
                                                
							                        <label for="cellnumber" class="col-sm-4 control-label">Type Of Installation</label>
							                        <div class="col-sm-8">
							                           <div class="input-group">
							                                 <select name="t_install2" id="t_install2" class="form-control">
		<?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM dropdown_installationtypes ORDER BY installationTypeName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['installationTypeName'] . "'>" . $row['installationTypeName'] . "</option>";
		}
		?>
			</select>	                            </div>
				             
							                    </div>
												
							                        </div>
													
							                         <label for="cellnumber" class="col-sm-4 control-label">Vehicle Make</label>
							                        <div class="col-sm-6">
							                            <div class="input-group">
							                                <select name="v_make1" id="v_make1" class="form-control">
											<option value="0">--Select--</option>
				                                <?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT dropdown_makes.makeId, dropdown_makes.makeName, dropdown_models.modelId FROM dropdown_makes INNER JOIN dropdown_models ON ( dropdown_models.modelMakeId = dropdown_makes.makeId ) GROUP BY modelMakeId ORDER BY makeName ASC";
		$result = $dbObject->dbQuery($sql);
		
		while ($row = mysql_fetch_array($result))
		{
			/*if (isset($row1) && (int)$row1['assetModelId'] == $row['modelId'])
			echo '<option value="' . $row['makeId'] . '" selected>' . $row['makeName'] . '</option>';
			else*/
			echo '<option value="' . $row['makeId'] . '">' . $row['makeName'] . '</option>';
		}
		?>
		                                    </select>
															<input type='hidden' value="test" name="notes" />
							                            </div>
							                        </div>
													
							                         <label for="cellnumber" class="col-sm-4 control-label">Model</label>
							                        <div class="col-sm-8">
							                            <div class="input-group">
							                                <select name="model1" id="model1"class="form-control">
											<option value="0">--Select--</option>
				                               <?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM dropdown_installationtypes ORDER BY installationTypeName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['installationTypeName'] . "'>" . $row['installationTypeName'] . "</option>";
		}
		?>
			</select>
							                            </div>
							                        </div>
													
														 <label for="cellnumber" class="col-sm-4 control-label">Color</label>
														<div class="col-sm-8">
															<div class="input-group">
																<select name="color1" id="color1"class="form-control">
											<option value="0">--Select--</option>
				                               <?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM dropdown_colours ORDER BY colourName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['colourName'] . "'>" . $row['colourName'] . "</option>";
		}
		?>
			</select>
															</div>
														</div>
													
													
													
													
													
				                         
				                        <label for="firstname" class="col-sm-4 control-label">Registration Number 2</label>
				                        <div class="col-sm-10">
				                             <input type="checkbox" name="reg_select"><input name="reg_num2" class="form-control" id="reg_num2" placeholder="Registration Number 2" type="text" <?php
											
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name']."'"; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[0]."'"; 
										}
										
										?>>
				                        </div>
								    
				                        <label for="firstname" class="col-sm-4 control-label">VIN Number 2</label>
				                        <div class="col-sm-10">
				                            <input type="checkbox" name="vin_select2"><input name="vin_num2" class="form-control" id="vin_num2" placeholder="Vin Number 2" type="text" <?php
											
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name']."'"; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[0]."'"; 
										}
										
										?>>
				                        </div></div>
													
													
													
													
													
													
													
													
													
													
				                        <div class="col-sm-10">
				                            <a data-toggle="collapse" href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
											<span class="glyphicon glyphicon-plus-sign" style="font-size:25px;"></span> Product Type 3
										</a>
				                        </div>
				                    </div>
									
									<div class="form-group collapse" id="collapseExample1">
									<div class="form-group">
							                        <label for="cellnumber" class="col-sm-4 control-label">Product Type3</label>
							                        <div class="col-sm-8">
							                            <div class="input-group">
							                               <select name="p_type3" id="p_type3" class="form-control">
															   <?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM products ORDER BY productName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['productName'] . "'>" . $row['productName'] . "</option>";
		}
		?>
			</select>
							                            </div>
							                        </div>

							                        <label for="cellnumber" class="col-sm-4 control-label">Type Of Installation</label>
							                        <div class="col-sm-8">
							                            <div class="input-group">
							                                 <select name="t_install3" id="t_install3" class="form-control">
		<?php
		$dbObject = new dbObject();
		$dbObject->dbConnect();
		$sql="SELECT * FROM dropdown_installationtypes ORDER BY installationTypeName ASC";
		$result = $dbObject->dbQuery($sql);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option value='" . $row['installationTypeName'] . "'>" . $row['installationTypeName'] . "</option>";
		}
		?>
			</select>	                        </div>
				             
							                            </div>
							                        </div>
							                         <label for="cellnumber" class="col-sm-4 control-label">Vehicle Make</label>
							                        <div class="col-sm-6">
							                            <div class="input-group">
							                                <select name="v_make3" id="v_make3" class="form-control">
								                                <option value="0">........... SELECT ...........</option>
																<option value="Recovery">VW</option>
																<option value="TraceFleet">Volvo</option>
																<option value="TraceSure">BMW</option>
																<option value="TraceHelp">Avanza</option>
						                                    </select>
							                            </div>
							                        </div>
							                         <label for="cellnumber" class="col-sm-4 control-label">Model</label>
							                        <div class="col-sm-8">
							                            <div class="input-group">
							                                <select name="model3" id="model3" class="form-control">
								                                <option value="0">........... SELECT ........... </option>
																<option value="Recovery">Model 1</option>
																<option value="TraceFleet">Model 2</option>
																<option value="TraceSure">Model 3</option>
																<option value="TraceHelp">Model 4</option>
						                                    </select>
							                            </div>
							                        </div>
							                         <label for="cellnumber" class="col-sm-4 control-label">Color</label>
							                        <div class="col-sm-8">
							                            <div class="input-group">
							                                <select class="form-control" name='color3'id="color3">
								                                <option value="0">........... SELECT ...........</option>
																<option value="Recovery">Blue</option>
																<option value="TraceFleet">Red</option>
																<option value="TraceSure">grey</option>
																<option value="TraceHelp">black</option>
						                                    </select>
							                            </div>
							                        </div>
													
													
													
													 
				                        <label for="firstname" class="col-sm-4 control-label">Registration Number 3</label>
				                        <div class="col-sm-10">
				                             <input type="checkbox" name="reg_select3"><input name="reg_num3" class="form-control" id="reg_num3" placeholder="Registration Number 3" type="text" <?php
											
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name'].""; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[0].""; 
										}
										
										?>'>
				                        </div>
								    
				                        <label for="firstname" class="col-sm-4 control-label">VIN Number 3</label>
				                        <div class="col-sm-10">
				                            <input type="checkbox" name="vin_select3"><input name="vin_num3" class="form-control" id="vin_num3" placeholder="Vin Number 3" type="text" <?php
											
										if(isset($validate_view))
										{
											echo "value='".$validate_view['full_name'].""; 
										}
										if(isset($view))
										{
											echo "value='".$view_mine[0].""; 
										}
										
										?>'>
				                        </div></div>
													
													
													
													
													
													
							                    </div>
									        </div>
									
									
							
									
									
									
									
									
									
									
									
									
									
									
									
									
									
				                    <div class="form-group">
				                        <label for="surname" class="col-sm-5 control-label">Alternate Contact Details</label>
				                        <div class="col-sm-10">
				                            <input name="alt_name" class="form-control" id="alt_name" placeholder="Name" type="text">
				                            <div class="input-group">
				                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
				                                <input name="alt_phone" class="form-control" id="alt_phone" placeholder="Telephone" value="" type="text">
				                            </div>
				                            <input name="alt_email" class="form-control" id="alt_email" placeholder="Email" value="" type="text">
				                        </div>
				                    </div>
									<!--
				                   <div class="form-group">
				                        <label for="surname" class="col-sm-5 control-label">In Company Name (Yes/No)</label>
				                        <div class="col-sm-10">
				                         	<div class="checkbox">
											    <label>
											      <input type="checkbox"> Yes &nbsp;&nbsp;&nbsp;
											    </label>
											    <label>
											     	<input type="checkbox"> No
											    </label>
										    </div>
				                        </div>
				                    </div>
									-->
				                     
									 <div class="form-group">
			                      <br>
					                    <div class="col-sm-10">
					                            <input type="button" name="main_update" id="qualified-leads" class="btn btn-default qualified-leads" value='Prebooked Lead'>
						                        <a class="btn btn-default" href="all-leads.php"> <i class="fa fa-hand-o-left"></i> All Leads </a> 
						                        <input type="button" name="main_form" id="main_form" class="btn btn-success save_my_btn" value='Save' style="background-color:#e63339;">
												<input type="button" name="main_update" id="main_update" class="btn btn-primary update_my_btn" value='Update Lead'>
						                       
					                    </div>
				                  </div>
				                   </div>
			                     
			                
			            </div>
						
						
						</div>
						

					
						
						
						
						
					  </div>  
					</div>
				</div>
			</div>		
		</div>
		</form>
</section>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">NOTES History &nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></h4>
      </div>
      <div class="modal-body">
	 
	  <div id='hist_notes'>
	  
	  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
	
	
	

<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit LEAD NOTES&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></h4>
      </div>
      <div class="modal-body">
	  <input type='hidden' name='update_notes_lead_num' id='update_notes_lead_num' class='update_notes_lead_num' />
	  <input type='hidden' name='update_notes_id' id='update_notes_id' class='update_notes_id' /> 
        <textarea class="form-control" name='update_notes' rows='8' id='update_notes'>
		
		</textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button id='update_notes' type="button" class="btn btn-primary" data-dismiss="modal">Update Notes</button>
      </div>
    </div>
  </div>
</div>
		
	
	<footer style="background-color:black;">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-6">
                     <p align="left">Copyright © 2016 Tracetec. All rights reserved | Designed by <a href="https://www.itnt.co.za/" rel="no-follow"> ITNT</a></p>       
					</div>
					<div class="col-md-6">
						<span class="pull-right"><a href="#home" class="scrollup"><i class="fa fa-angle-up fa-3x"></i></a></span>
					</div>
				</div>
			</div>	
		</div>
	</footer>
	
	<!-- Core JavaScript Files -->

    <script src="js/jquery-2.1.1.min.js"></script>	 
    <script src="js/bootstrap.min.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/jquery.easing.min.js"></script>		
	<script src="js/functions.js"></script>

<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    // [START region_fillform]
    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
            document.getElementById(component).value = '';
			if(component != 'route')
			{
				document.getElementById(component).disabled = false;
			}
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
				if(i != '1')
				{
					if(i == '0')
					{
						var val1 = place.address_components[0][componentForm[addressType]];
						var val2 = place.address_components[1][componentForm[addressType]];
						document.getElementById(addressType).value = val1 + " " + val2;
					}
					else
					{
						var val = place.address_components[i][componentForm[addressType]];
						document.getElementById(addressType).value = val;
					}
				}
            }
        }
    }
    // [END region_fillform]

    // [START region_geolocation]
    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
    // [END region_geolocation]

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsPlbPQn2D3xW97hjrtU3JUvoHNghq8Bw&signed_in=true&libraries=places&callback=initAutocomplete"
        async defer></script>

  </body>
</html>