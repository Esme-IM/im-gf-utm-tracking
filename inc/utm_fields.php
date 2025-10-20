<?php
function marketing_scripts(){
	wp_enqueue_script( 'marketing_scripts', IM_TRACKING_PLUGIN_URL . '/js/set-marketing-cookies.js', array('jquery'), '1.0', true );	
	wp_enqueue_script( 'cookie', IM_TRACKING_PLUGIN_URL . '/js/jquery.cookie.js', array('jquery'), '1.0', true );	
}
add_action( 'wp_footer', 'marketing_scripts' ); 
if ( class_exists( 'GFCommon' ) ) {
add_filter( 'gform_field_value', 'populate_utm_fields', 10, 3 );
function populate_utm_fields( $value, $field, $name ) {
	//Hidden Fields
	//msource - Marketing source (utm_source)
	//mmedium - Marketing Medium (utm_medium)
	//mreferrer - Marketing Referrer (no utm code but http referrer)
	//mcampaign - Marketing campaign (utm_campaign)
	//mterm - Marketing term (utm_term)
	//gaclientid - Marketing client id (utm_clientid)
	//mgclid - Google Click ID gclid
	//fbclid - Facebook Click ID fbclid
	//gaclid-sf - GA Client ID gaclid	
	//reg_impact - Impact Click	
	//mlandingpage - page they landed on (Debug Purposes)
	//mcontent - Marketing content (utm_content)
	/*Get values*/
	if ((isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))) {
		$referrer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
	}		
	
	$source = '';
    $medium = '';
    $campaign = '';
    $mreferrer = '';
    $clientid = '';
    $gclid = '';
    $fbclid = '';
	$gaclid = '';
	$im_ref = '';
	$mContent = '';
	$mTerm = '';
	$entry_page = '';
	$conversion_page = '';
	
	/*check cookies first*/
	if(isset($_COOKIE['marketingSource'])){ $source =  $_COOKIE['marketingSource'];}
	if(isset($_COOKIE['marketingMedium'])){ $medium =  $_COOKIE['marketingMedium'];}
	if(isset($_COOKIE['marketingCampaign'])){ $campaign =  $_COOKIE['marketingCampaign'];}
	if(isset($_COOKIE['marketingReferrer'])){ $mreferrer =  $_COOKIE['marketingReferrer'];}
	if(isset($_COOKIE['marketingClientID'])){ $clientid =  $_COOKIE['marketingClientID'];}
	if(isset($_COOKIE['marketingGClid'])){ $gclid =  $_COOKIE['marketingGClid'];}
	if(isset($_COOKIE['marketingFbClid'])){ $fbclid =  $_COOKIE['marketingFbClid'];}
	if(isset($_COOKIE['marketingGaClid'])){ $gaclid =  $_COOKIE['marketingGaClid'];}
	if(isset($_COOKIE['marketingImRef'])){ $im_ref =  $_COOKIE['marketingImRef'];}
	if(isset($_COOKIE['marketingContent'])){ $mContent =  $_COOKIE['marketingContent'];}
	if(isset($_COOKIE['marketingTerm'])){ $mTerm =  $_COOKIE['marketingTerm'];}	
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
         $url = "https://";   
    } else {
         $url = "http://";   
	}
    $url.= $_SERVER['HTTP_HOST'];   
    
    $url.= $_SERVER['REQUEST_URI'];    
	$conversion_page = $url;
	
	if(isset($_COOKIE['marketingLandingpage'])){ $entry_page =  $_COOKIE['marketingLandingpage'];} else {
		 $entry_page =  $url;
	}
	if ((isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))) {
		if (strtolower(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST)) != strtolower($_SERVER['HTTP_HOST'])) {
			// referer not from the same domain
			$mreferrer = $referrer;

			if (strpos($referrer,"google")) {
				$source = 'google';
				if(isset($_GET['gclid'])){
					$medium = 'ppc';
					$gclid = $_GET['gclid'];
				} else {
					$medium = 'organic';
				}
			} elseif (strpos($referrer,"bing")) {
				$source = 'bing';
				$medium = 'organic';
			} elseif (strpos($referrer,"facebook.com") || strpos($referrer,"fb.com")) {
				$source = 'facebook';				
				if(isset($_GET['fbclid'])){
					$fbclid = $_GET['fbclid'];
				} 
				if(isset($_GET['fbclid']) && isset( $_GET['utm_campaign'])){
					$medium = 'paid social';
				}else {
					$medium = 'social';
				}
			} elseif (strpos($referrer,"twitter.com")) {
				$source = 'twitter';
				$medium = 'social';
			} elseif (strpos($referrer,"linkedin.com")) {
				$source = 'linkedin';
				$medium = 'social';
			} elseif (strpos($referrer,"youtube.com")) {
				$source = 'youtube';
				$medium = 'social';
			} elseif (strpos($referrer,"instagram.com")) {
				$source = 'instagram';
				$medium = 'social';
			} elseif (strpos($referrer,"pinterest.com")) {
				$source = 'pinterest';
				$medium = 'social';
			} elseif (strpos($referrer,"reddit.com")) {
				$source = 'reddit';
				$medium = 'social';
			} elseif (strpos($referrer,"tumblr.com")) {
				$source = 'tumblr';
				$medium = 'social';
			} elseif (strpos($referrer,"quora.com")) {
				$source = 'quora';
				$medium = 'social';
			} elseif (strpos($referrer,"yahoo.com")) {
				$source = 'yahoo';
				$medium = 'organic';
			} elseif (strpos($referrer,"duckduckgo.com")) {
				$source = 'duckduckgo';
				$medium = 'organic';
			} elseif (strpos($referrer,"baidu.com")) {
				$source = 'baidu';
				$medium = 'organic';
			} elseif (strpos($referrer,"yandex.com")) {
				$source = 'yandex';
				$medium = 'organic';
			} elseif (!$referrer) {
				$source = 'direct';
				$medium = 'none';
			} else {
				$source = $referrer; 
				$medium = 'referral';
				$mreferrer = $referrer;
			}
		}
	} else {
		$source = 'direct';
		$medium = 'none';
	}
	
	if(isset($_GET['utm_source'])){ $source =  $_GET['utm_source'];}
	if(isset($_GET['utm_medium'])){ $medium =  $_GET['utm_medium'];}
	if(isset($_GET['utm_campaign'])){ $campaign =  $_GET['utm_campaign'];}
	if(isset($_GET['utm_clientid'])){ $clientid =  $_GET['utm_clientid'];}
	if(isset($_GET['gclid'])){ $gclid =  $_GET['gclid'];}
	if(isset($_GET['fbclid'])){ $fbclid =  $_GET['fbclid'];}
	if(isset($_GET['gaclid'])){ $gaclid =  $_GET['gaclid'];}
	if(isset($_GET['im_ref'])){ $im_ref =  $_GET['im_ref'];}		
	if(isset($_GET['utm_content'])){ $mContent =  $_GET['utm_content'];}
	if(isset($_GET['utm_term'])){ $mTerm =  $_GET['utm_term'];}

	//$gaclid = preg_replace("/^.+\.(.+?\..+?)$/", "\\1", @$_COOKIE['_ga']);
	//$gaclid = 123;

	if(isset($_COOKIE['_ga'])){
		$gaclid = preg_replace("/^.+\.(.+?\..+?)$/", "\\1", $_COOKIE['_ga']);
	}		
	
    $values = array(
        'mcampaign'   => $campaign,
		'msource'   => $source,
		'mmedium'   => $medium,
		'mreferrer'   => $mreferrer,
		'gaclientid'   => $clientid,
		'mcontent'   => $mContent,
		'mterm'   => $mTerm,
		'mgclid'   => $gclid,
		'mfbclid'   => $fbclid,
		'gaclid-sf'   => $gaclid,
		'reg_impact'   => $im_ref,
		'mlandingpage'   => $entry_page,
		'mconversionpage'   => $conversion_page,
    );
    return isset( $values[ $name ] ) ? $values[ $name ] : $value;
}
}
?>