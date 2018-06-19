<?php 
//session_set_cookie_params(0);
session_start(); 
//on the $pages0 array insert all the pages that a user can not access unless they are logged in to the site.
$pages0 = array ('forgot','league_manager','user_manager','results_manager','scores_manager','group_results','advert_manager','league_settings','eventsLog','reports','unpaid_bets','customer_records','logout','accountsPayable','accountsReceivable',
		'recon_sheet','eventReport','winnerPayoutProcessing','userTransactionListingReport','cumulativePayout','tax_returns','age_analysis','threshold','weekly_payouts','cumulative_payouts','fieldSheetReport','users_to_be_paid');
$page0 = $_GET['page'];
if (in_array($page0,$pages0)){

if((empty($_SESSION['SPORTS_CALL_ADMIN_ID'])) AND ($page0!=="")){

 header("Location: index.php?page=home&img=wrong&msg=You must be logged in to view this page."); 
 exit;

}
else{
	if($page0 == "logout"){
		
    session_destroy();
    header('Location: index.php?page=home&img=wrong&msg=You logged out.');
    exit();
}

}									
  	 				        
}

# Check if a user is logged in 
function isLogged(){ 
    if($_SESSION['SPORTS_CALL_ADMIN_ID']){ # When logged in this variable is set to TRUE 
        return TRUE; 
    }
	/*elseif($_SESSION['SPORTS_CALL_ADMIN_ID']){ # When logged in this variable is set to TRUE 
        return TRUE; 
    } */
	else{ 
        return FALSE; 
    } 
} 
# Log a user Out 
function logOut(){ 
    $_SESSION = array(); 
    if (isset($_COOKIE[session_name()])) { 
        setcookie(session_name(), '', time()-42000, '/'); 
    } 
    session_destroy(); 
} 

# Session Logout after in activity 
function sessionX(){ 
    $logLength = 1800; # time in seconds :: 1800 = 30 minutes 
    $ctime = strtotime("now"); # Create a time from a string 
    # If no session time is created, create one 
    if(!isset($_SESSION['sessionX'])){  
        # create session time 
        $_SESSION['sessionX'] = $ctime;  
    }else{ 
        # Check if they have exceded the time limit of inactivity 
        if(((strtotime("now") - $_SESSION['sessionX']) > $logLength) && isLogged()){ 
            # If exceded the time, log the user out 
            logOut(); 
            # Redirect to login page to log back in 
		    //refresh_url();
            header("Location: index.php?page=home&img=wrong&msg=You were logged out due to inactivity on the site, please login again."); 
            exit; 
        }else{ 
            # If they have not exceded the time limit of inactivity, keep them logged in 
            $_SESSION['sessionX'] = $ctime; 
        } 
    } 
} 
# Run Session logout check 
sessionX();
?>