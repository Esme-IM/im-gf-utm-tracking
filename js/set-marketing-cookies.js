function getReferrerDomain(url) {
    var a=document.createElement('a');
    a.href=url;
    return a.hostname;
}

function setMarketingCookies() {
    var referrer = document.referrer;
    var currentHostname = window.location.hostname;
    var params = new URLSearchParams(window.location.search);
    var utmSource = params.get('utm_source');
    var utmMedium = params.get('utm_medium');
    var utmCampaign = params.get('utm_campaign');
    var utmClientid = params.get('utm_clientid');
    var utmContent = params.get('utm_content');
    var utmTerm = params.get('utm_term');
    var source = '';
    var medium = '';
    var campaign = '';
    var mreferrer = '';
    var clientid = '';
	var mContent = '';
	var mTerm = '';
	var gclid = params.get('gclid');
	var fbclid = params.get('fbclid');
    var gaclid = params.get('gaclid');
    var im_ref = params.get('im_ref');
	var entry_page = '';
	entry_page = window.location.href;
    // Default values based on referrer
    if (referrer && !referrer.includes(currentHostname)) {	
		mreferrer = referrer;
        // Check for specific referrers
        if (referrer.includes("google")) {
            source = 'google';
            medium = params.get('gclid') ? 'ppc' : 'organic';
        } else if (referrer.includes("bing")) {
            source = 'bing';
            medium = 'organic';
        } else if (referrer.includes("facebook.com") || referrer.includes("fb.com")) {
            source = 'facebook';			
			if(fbclid && utmCampaign){
				medium = 'paid social';
			} else {
				medium = 'social';
			}
        } else if (referrer.includes("twitter.com")) {
            source = 'twitter';
            medium = 'social';
        } else if (referrer.includes("linkedin.com")) {
            source = 'linkedin';
            medium = 'social';
        } else if (referrer.includes("youtube.com")) {
            source = 'youtube';
            medium = 'social';
        } else if (referrer.includes("instagram.com")) {
            source = 'instagram';
            medium = 'social';
        } else if (referrer.includes("pinterest.com")) {
            source = 'pinterest';
            medium = 'social';
        } else if (referrer.includes("reddit.com")) {
            source = 'reddit';
            medium = 'social';
        } else if (referrer.includes("tumblr.com")) {
            source = 'tumblr';
            medium = 'social';
        } else if (referrer.includes("quora.com")) {
            source = 'quora';
            medium = 'social';
        } else if (referrer.includes("yahoo.com")) {
            source = 'yahoo';
            medium = 'organic';
        } else if (referrer.includes("duckduckgo.com")) {
            source = 'duckduckgo';
            medium = 'organic';
        } else if (referrer.includes("baidu.com")) {
            source = 'baidu';
            medium = 'organic';
        } else if (referrer.includes("yandex.com")) {
            source = 'yandex';
            medium = 'organic';
        } else if (!referrer) {
            source = 'direct';
            medium = 'none';
        } else {
            source = new URL(referrer).hostname;
            medium = 'referral';		
            mreferrer = referrer;
        }
        // Add more referrers as needed
    } else {
		source = 'direct';
        medium = 'none';
	}
	// Override with UTM parameters if they exist
	if (utmSource) source = utmSource;
	if (utmMedium) medium = utmMedium;
	if (utmCampaign) campaign = utmCampaign;
	if (utmClientid) clientid = utmClientid;
	if (utmContent) mContent = utmContent;
	if (utmTerm) mTerm = utmTerm;
	
	// Set cookies
	if(source != ''){
		jQuery.cookie('marketingSource', source, { path: '/' });
	} else {
		jQuery.removeCookie('marketingSource', { path: '/' });
	}
	if(medium != ''){
		jQuery.cookie('marketingMedium', medium, { path: '/' });
	} else {
		jQuery.removeCookie('marketingMedium', { path: '/' });
	}
	if(mreferrer != ''){
		jQuery.cookie('marketingReferrer', mreferrer, { path: '/' });
	}else {
		jQuery.removeCookie('marketingReferrer', { path: '/' });
	}
	if(campaign != ''){
		jQuery.cookie('marketingCampaign', campaign, { path: '/' });
	}else {
		jQuery.removeCookie('marketingCampaign', { path: '/' });
	}
	if(clientid != ''){
		jQuery.cookie('marketingClientID', clientid, { path: '/' });
	}else {
		jQuery.removeCookie('marketingClientID', { path: '/' });
	}
	if(mContent != ''){
		jQuery.cookie('marketingContent', mContent, { path: '/' });
	}else {
		jQuery.removeCookie('marketingContent', { path: '/' });
	}
	if(mTerm != ''){
		jQuery.cookie('marketingTerm', mTerm, { path: '/' });
	}else {
		jQuery.removeCookie('marketingTerm', { path: '/' });
	}
	if(gclid != ''){
		jQuery.cookie('marketingGClid', gclid, { expires: 1, path: '/' });
	}else {
		jQuery.removeCookie('marketingGClid', { path: '/' });
	}
	if(fbclid != ''){
		jQuery.cookie('marketingFbClid', fbclid, { expires: 1, path: '/' });
	}else {
		jQuery.removeCookie('marketingFbClid', { path: '/' });
	}
	if(gaclid != ''){
		jQuery.cookie('marketingGaClid', gaclid, { expires: 1, path: '/' });
	}else {
		jQuery.removeCookie('marketingGaClid', { path: '/' });
	}
	if(im_ref != ''){
		jQuery.cookie('marketingImRef', im_ref, { expires: 1, path: '/' });
	}else {
		jQuery.removeCookie('marketingImRef', { path: '/' });
	}              
	jQuery.cookie('marketingLandingpage', entry_page, {path: '/' });	
	console.log('marketingFired');
}

var referrer = document.referrer;
var currentHostname = window.location.hostname;
if (!referrer.includes(currentHostname)) {
	jQuery(document).ready(setMarketingCookies);
}