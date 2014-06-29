var boem = true;

$(document).ready(function(){
	$('#lang').change(function() {
		$('#curLang').val($('#lang').val());

		updateLabels();
		chat.getChats();
	});	
	
	updateLabels();
	
	// Run the init method on document ready:
	chat.init();
});

function scrollChatBottom() {
	//$("#chatLineHolder").animate({ scrollTop: $("#chatLineHolder").attr("scrollHeight") - $('#chatLineHolder').height() }, 3000);	
	
	$("#chatLineHolder").scrollTop($("#chatLineHolder").prop('scrollHeight'));
}

function openCR() {
	$( "#roomname" ).val("");
	loadAllUsers();  
	$( "#dialog-form" ).dialog( "open" );
}

$(function() {
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
	var name = $( "#name" ),
		email = $( "#email" ),
		password = $( "#password" ),
		allFields = $( [] ).add( name ).add( email ).add( password ),
		tips = $( ".validateTips" );

	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}

	function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Length of " + n + " must be between " +
				min + " and " + max + "." );
			return false;
		} else {
			return true;
		}
	}

	function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
	}
	

});

function updateLabels() {
	
	chat.getSystemTranslations();

}

function getCountry(c) {
	if (!c)
		return 'Unknown';
	
    country = '';
	c = c.toUpperCase();

    if( c == 'AF' ) country = 'Afghanistan';
    if( c == 'AX' ) country = 'Aland Islands';
    if( c == 'AL' ) country = 'Albania';
    if( c == 'DZ' ) country = 'Algeria';
    if( c == 'AS' ) country = 'American Samoa';
    if( c == 'AD' ) country = 'Andorra';
    if( c == 'AO' ) country = 'Angola';
    if( c == 'AI' ) country = 'Anguilla';
    if( c == 'AQ' ) country = 'Antarctica';
    if( c == 'AG' ) country = 'Antigua and Barbuda';
    if( c == 'AR' ) country = 'Argentina';
    if( c == 'AM' ) country = 'Armenia';
    if( c == 'AW' ) country = 'Aruba';
    if( c == 'AU' ) country = 'Australia';
    if( c == 'AT' ) country = 'Austria';
    if( c == 'AZ' ) country = 'Azerbaijan';
    if( c == 'BS' ) country = 'Bahamas the';
    if( c == 'BH' ) country = 'Bahrain';
    if( c == 'BD' ) country = 'Bangladesh';
    if( c == 'BB' ) country = 'Barbados';
    if( c == 'BY' ) country = 'Belarus';
    if( c == 'BE' ) country = 'Belgium';
    if( c == 'BZ' ) country = 'Belize';
    if( c == 'BJ' ) country = 'Benin';
    if( c == 'BM' ) country = 'Bermuda';
    if( c == 'BT' ) country = 'Bhutan';
    if( c == 'BO' ) country = 'Bolivia';
    if( c == 'BA' ) country = 'Bosnia and Herzegovina';
    if( c == 'BW' ) country = 'Botswana';
    if( c == 'BV' ) country = 'Bouvet Island (Bouvetoya)';
    if( c == 'BR' ) country = 'Brazil';
    if( c == 'IO' ) country = 'British Indian Ocean Territory (Chagos Archipelago)';
    if( c == 'VG' ) country = 'British Virgin Islands';
    if( c == 'BN' ) country = 'Brunei Darussalam';
    if( c == 'BG' ) country = 'Bulgaria';
    if( c == 'BF' ) country = 'Burkina Faso';
    if( c == 'BI' ) country = 'Burundi';
    if( c == 'KH' ) country = 'Cambodia';
    if( c == 'CM' ) country = 'Cameroon';
    if( c == 'CA' ) country = 'Canada';
    if( c == 'CV' ) country = 'Cape Verde';
    if( c == 'KY' ) country = 'Cayman Islands';
    if( c == 'CF' ) country = 'Central African Republic';
    if( c == 'TD' ) country = 'Chad';
    if( c == 'CL' ) country = 'Chile';
    if( c == 'CN' ) country = 'China';
    if( c == 'CX' ) country = 'Christmas Island';
    if( c == 'CC' ) country = 'Cocos (Keeling) Islands';
    if( c == 'CO' ) country = 'Colombia';
    if( c == 'KM' ) country = 'Comoros the';
    if( c == 'CD' ) country = 'Congo';
    if( c == 'CG' ) country = 'Congo the';
    if( c == 'CK' ) country = 'Cook Islands';
    if( c == 'CR' ) country = 'Costa Rica';
    if( c == 'CI' ) country = 'Cote d\'Ivoire';
    if( c == 'HR' ) country = 'Croatia';
    if( c == 'CU' ) country = 'Cuba';
    if( c == 'CY' ) country = 'Cyprus';
    if( c == 'CZ' ) country = 'Czech Republic';
    if( c == 'DK' ) country = 'Denmark';
    if( c == 'DJ' ) country = 'Djibouti';
    if( c == 'DM' ) country = 'Dominica';
    if( c == 'DO' ) country = 'Dominican Republic';
    if( c == 'EC' ) country = 'Ecuador';
    if( c == 'EG' ) country = 'Egypt';
    if( c == 'SV' ) country = 'El Salvador';
    if( c == 'GQ' ) country = 'Equatorial Guinea';
    if( c == 'ER' ) country = 'Eritrea';
    if( c == 'EE' ) country = 'Estonia';
    if( c == 'ET' ) country = 'Ethiopia';
    if( c == 'FO' ) country = 'Faroe Islands';
    if( c == 'FK' ) country = 'Falkland Islands (Malvinas)';
    if( c == 'FJ' ) country = 'Fiji the Fiji Islands';
    if( c == 'FI' ) country = 'Finland';
    if( c == 'FR' ) country = 'France, French Republic';
    if( c == 'GF' ) country = 'French Guiana';
    if( c == 'PF' ) country = 'French Polynesia';
    if( c == 'TF' ) country = 'French Southern Territories';
    if( c == 'GA' ) country = 'Gabon';
    if( c == 'GM' ) country = 'Gambia the';
    if( c == 'GE' ) country = 'Georgia';
    if( c == 'DE' ) country = 'Germany';
    if( c == 'GH' ) country = 'Ghana';
    if( c == 'GI' ) country = 'Gibraltar';
    if( c == 'GR' ) country = 'Greece';
    if( c == 'GL' ) country = 'Greenland';
    if( c == 'GD' ) country = 'Grenada';
    if( c == 'GP' ) country = 'Guadeloupe';
    if( c == 'GU' ) country = 'Guam';
    if( c == 'GT' ) country = 'Guatemala';
    if( c == 'GG' ) country = 'Guernsey';
    if( c == 'GN' ) country = 'Guinea';
    if( c == 'GW' ) country = 'Guinea-Bissau';
    if( c == 'GY' ) country = 'Guyana';
    if( c == 'HT' ) country = 'Haiti';
    if( c == 'HM' ) country = 'Heard Island and McDonald Islands';
    if( c == 'VA' ) country = 'Holy See (Vatican City State)';
    if( c == 'HN' ) country = 'Honduras';
    if( c == 'HK' ) country = 'Hong Kong';
    if( c == 'HU' ) country = 'Hungary';
    if( c == 'IS' ) country = 'Iceland';
    if( c == 'IN' ) country = 'India';
    if( c == 'ID' ) country = 'Indonesia';
    if( c == 'IR' ) country = 'Iran';
    if( c == 'IQ' ) country = 'Iraq';
    if( c == 'IE' ) country = 'Ireland';
    if( c == 'IM' ) country = 'Isle of Man';
    if( c == 'IL' ) country = 'Israel';
    if( c == 'IT' ) country = 'Italy';
    if( c == 'JM' ) country = 'Jamaica';
    if( c == 'JP' ) country = 'Japan';
    if( c == 'JE' ) country = 'Jersey';
    if( c == 'JO' ) country = 'Jordan';
    if( c == 'KZ' ) country = 'Kazakhstan';
    if( c == 'KE' ) country = 'Kenya';
    if( c == 'KI' ) country = 'Kiribati';
    if( c == 'KP' ) country = 'Korea';
    if( c == 'KR' ) country = 'Korea';
    if( c == 'KW' ) country = 'Kuwait';
    if( c == 'KG' ) country = 'Kyrgyz Republic';
    if( c == 'LA' ) country = 'Lao';
    if( c == 'LV' ) country = 'Latvia';
    if( c == 'LB' ) country = 'Lebanon'; 
    if( c == 'LS' ) country = 'Lesotho';
    if( c == 'LR' ) country = 'Liberia';
    if( c == 'LY' ) country = 'Libyan Arab Jamahiriya';
    if( c == 'LI' ) country = 'Liechtenstein';
    if( c == 'LT' ) country = 'Lithuania';
    if( c == 'LU' ) country = 'Luxembourg';
    if( c == 'MO' ) country = 'Macao';
    if( c == 'MK' ) country = 'Macedonia';
    if( c == 'MG' ) country = 'Madagascar';
    if( c == 'MW' ) country = 'Malawi';
    if( c == 'MY' ) country = 'Malaysia';
    if( c == 'MV' ) country = 'Maldives';
    if( c == 'ML' ) country = 'Mali';
    if( c == 'MT' ) country = 'Malta';
    if( c == 'MH' ) country = 'Marshall Islands';
    if( c == 'MQ' ) country = 'Martinique';
    if( c == 'MR' ) country = 'Mauritania';
    if( c == 'MU' ) country = 'Mauritius';
    if( c == 'YT' ) country = 'Mayotte';
    if( c == 'MX' ) country = 'Mexico';
    if( c == 'FM' ) country = 'Micronesia';
    if( c == 'MD' ) country = 'Moldova';
    if( c == 'MC' ) country = 'Monaco';
    if( c == 'MN' ) country = 'Mongolia';
    if( c == 'ME' ) country = 'Montenegro';
    if( c == 'MS' ) country = 'Montserrat';
    if( c == 'MA' ) country = 'Morocco';
    if( c == 'MZ' ) country = 'Mozambique';
    if( c == 'MM' ) country = 'Myanmar';
    if( c == 'NA' ) country = 'Namibia';
    if( c == 'NR' ) country = 'Nauru';
    if( c == 'NP' ) country = 'Nepal';
    if( c == 'AN' ) country = 'Netherlands Antilles';
    if( c == 'NL' ) country = 'Netherlands the';
    if( c == 'NC' ) country = 'New Caledonia';
    if( c == 'NZ' ) country = 'New Zealand';
    if( c == 'NI' ) country = 'Nicaragua';
    if( c == 'NE' ) country = 'Niger';
    if( c == 'NG' ) country = 'Nigeria';
    if( c == 'NU' ) country = 'Niue';
    if( c == 'NF' ) country = 'Norfolk Island';
    if( c == 'MP' ) country = 'Northern Mariana Islands';
    if( c == 'NO' ) country = 'Norway';
    if( c == 'OM' ) country = 'Oman';
    if( c == 'PK' ) country = 'Pakistan';
    if( c == 'PW' ) country = 'Palau';
    if( c == 'PS' ) country = 'Palestinian Territory';
    if( c == 'PA' ) country = 'Panama';
    if( c == 'PG' ) country = 'Papua New Guinea';
    if( c == 'PY' ) country = 'Paraguay';
    if( c == 'PE' ) country = 'Peru';
    if( c == 'PH' ) country = 'Philippines';
    if( c == 'PN' ) country = 'Pitcairn Islands';
    if( c == 'PL' ) country = 'Poland';
    if( c == 'PT' ) country = 'Portugal, Portuguese Republic';
    if( c == 'PR' ) country = 'Puerto Rico';
    if( c == 'QA' ) country = 'Qatar';
    if( c == 'RE' ) country = 'Reunion';
    if( c == 'RO' ) country = 'Romania';
    if( c == 'RU' ) country = 'Russian Federation';
    if( c == 'RW' ) country = 'Rwanda';
    if( c == 'BL' ) country = 'Saint Barthelemy';
    if( c == 'SH' ) country = 'Saint Helena';
    if( c == 'KN' ) country = 'Saint Kitts and Nevis';
    if( c == 'LC' ) country = 'Saint Lucia';
    if( c == 'MF' ) country = 'Saint Martin';
    if( c == 'PM' ) country = 'Saint Pierre and Miquelon';
    if( c == 'VC' ) country = 'Saint Vincent and the Grenadines';
    if( c == 'WS' ) country = 'Samoa';
    if( c == 'SM' ) country = 'San Marino';
    if( c == 'ST' ) country = 'Sao Tome and Principe';
    if( c == 'SA' ) country = 'Saudi Arabia';
    if( c == 'SN' ) country = 'Senegal';
    if( c == 'RS' ) country = 'Serbia';
    if( c == 'SC' ) country = 'Seychelles';
    if( c == 'SL' ) country = 'Sierra Leone';
    if( c == 'SG' ) country = 'Singapore';
    if( c == 'SK' ) country = 'Slovakia (Slovak Republic)';
    if( c == 'SI' ) country = 'Slovenia';
    if( c == 'SB' ) country = 'Solomon Islands';
    if( c == 'SO' ) country = 'Somalia, Somali Republic';
    if( c == 'ZA' ) country = 'South Africa';
    if( c == 'GS' ) country = 'South Georgia and the South Sandwich Islands';
    if( c == 'ES' ) country = 'Spain';
    if( c == 'LK' ) country = 'Sri Lanka';
    if( c == 'SD' ) country = 'Sudan';
    if( c == 'SR' ) country = 'Suriname';
    if( c == 'SJ' ) country = 'Svalbard & Jan Mayen Islands';
    if( c == 'SZ' ) country = 'Swaziland';
    if( c == 'SE' ) country = 'Sweden';
    if( c == 'CH' ) country = 'Switzerland, Swiss Confederation';
    if( c == 'SY' ) country = 'Syrian Arab Republic';
    if( c == 'TW' ) country = 'Taiwan';
    if( c == 'TJ' ) country = 'Tajikistan';
    if( c == 'TZ' ) country = 'Tanzania';
    if( c == 'TH' ) country = 'Thailand';
    if( c == 'TL' ) country = 'Timor-Leste';
    if( c == 'TG' ) country = 'Togo';
    if( c == 'TK' ) country = 'Tokelau';
    if( c == 'TO' ) country = 'Tonga';
    if( c == 'TT' ) country = 'Trinidad and Tobago';
    if( c == 'TN' ) country = 'Tunisia';
    if( c == 'TR' ) country = 'Turkey';
    if( c == 'TM' ) country = 'Turkmenistan';
    if( c == 'TC' ) country = 'Turks and Caicos Islands';
    if( c == 'TV' ) country = 'Tuvalu';
    if( c == 'UG' ) country = 'Uganda';
    if( c == 'UA' ) country = 'Ukraine';
    if( c == 'AE' ) country = 'United Arab Emirates';
    if( c == 'GB' ) country = 'United Kingdom';
    if( c == 'US' ) country = 'United States of America';
    if( c == 'UM' ) country = 'United States Minor Outlying Islands';
    if( c == 'VI' ) country = 'United States Virgin Islands';
    if( c == 'UY' ) country = 'Uruguay, Eastern Republic of';
    if( c == 'UZ' ) country = 'Uzbekistan';
    if( c == 'VU' ) country = 'Vanuatu';
    if( c == 'VE' ) country = 'Venezuela';
    if( c == 'VN' ) country = 'Vietnam';
    if( c == 'WF' ) country = 'Wallis and Futuna';
    if( c == 'EH' ) country = 'Western Sahara';
    if( c == 'YE' ) country = 'Yemen';
    if( c == 'ZM' ) country = 'Zambia';
    if( c == 'ZW' ) country = 'Zimbabwe';
    if( country == '') country = c;

	return country;
}

function getLanguage(l) {
	var res = "";
	if (!l)
		return 'Unknown';
	
	$("#lang > option").each(function() {
		if (this.value.toLowerCase() == l.toLowerCase()) {
			res = this.text;
		}
	});
	
	return "en";
	
	return res;
}

var chat = {
	
	// data holds variables for use in the class:
	
	data : {
		lastID 		: 0,
		noActivity	: 0
	},
	
	// Init binds event listeners and sets up timers:
	
	init : function(){
		chat.login($('#name').val(),$('#email').val(),$('#country').val(),$('#server').val(),$('#oi').val(),$('#op').val(),$('#userip').val());
		

	},
	
	// The login method hides displays the
	// user's login data and shows the submit form
	
	checklogged : function(name, gravatar, country, oem) {
		chat.data.name = name;
		chat.data.gravatar = gravatar;
		chat.data.country = country;
		chat.data.oem = oem;

		$.tzGET('login',{name: name, email: gravatar, country: country, oem: oem},function(r){
			$('#chatTopBar').html(chat.render('loginTopBar',chat.data));

			$('#chatText').focus();
		});		
	},
	
	login : function(name,gravatar,country,oem,oi,op,userip){
		chat.data.name = name;
		chat.data.gravatar = gravatar;
		chat.data.country = country;
		chat.data.oem = oem;
		chat.data.oi = oi;
		chat.data.op = op;
		chat.data.userip = userip;

		$.tzGET('login',{name: name, email: gravatar, country: country, oem: oem, oi: oi, op: op, userip: userip},function(r){
			$('#chatRoom').val(r.room);
			
			chat.data.oemlabel = r.oemlabel;
			chat.data.oemlang = r.oemlang;
			chat.data.oememail = r.oememail;
			chat.data.oemlogo = r.oemlogo;
			
			if (!r.oemlogo)
				chat.data.oemlogo = 'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm';
			
			(function getUsersTimeoutFunction(){
				chat.getUsers(getUsersTimeoutFunction);
			})();

			(function getChatsTimeoutFunction(){
				chat.getChats(getChatsTimeoutFunction);
			})();
			
			$('#chatTopBar').html(chat.render('loginTopBar',chat.data));

	//		$('#loginForm').fadeOut(function(){
	//			$('#submitForm').fadeIn();
				$('#chatText').focus();
	//		});
	
			// Using the defaultText jQuery plugin, included at the bottom:
			$('#name').defaultText('Nickname');
			$('#email').defaultText('Email (Gravatars are Enabled)');

			// Converting the #chatLineHolder div into a jScrollPane,
			// and saving the plugin's API in chat.data:
/*
			chat.data.jspAPI = $('#chatLineHolder').jScrollPane({
				verticalDragMinHeight: 12,
				verticalDragMaxHeight: 12
			}).data('jsp');
*/
			// We use the working variable to prevent
			// multiple form submissions:

			var working = false;

			// Logging a person in the chat:

			$('#loginForm').submit(function(){
				if(working) return false;
				working = true;

				// Using our tzPOST wrapper function
				// (defined in the bottom):
				$.tzPOST('login',{name: $('#name').val(), email: $('#email').val(), country: $('#country').val()},function(r){
					working = false;

					if(r.error){
						chat.displayError(r.error);
					}
					else chat.login(r.name,r.gravatar);
				});

				return false;
			});

			// Submitting a new chat entry:

			$('#submitForm').submit(function(){

				var text = $('#chatText').val();
				var lang = $('#curLang').val();
				var country = $('#country').val();
				var room = $('#chatRoom').val();

				if(text.length == 0){
					return false;
				}

				if(working) return false;
				working = true;

				// Assigning a temporary ID to the chat:
				var tempID = 't'+Math.round(Math.random()*1000000),
					params = {
						id			: tempID,
						author		: chat.data.name,
						gravatar	: chat.data.gravatar,
						text		: text.replace(/</g,'&lt;').replace(/>/g,'&gt;'),
						room		: room,
						country		: country,
						lang		: lang
					};

				// Using our addChatLine method to add the chat
				// to the screen immediately, without waiting for
				// the AJAX request to complete:

				chat.addChatLine($.extend({},params));

				// Using our tzPOST wrapper method to send the chat
				// via a POST AJAX request:

				$.tzPOST('submitChat',$(this).serialize(),function(r){
					working = false;

					$('#chatText').val('');
					$('div.chat-'+tempID).remove();

					params['id'] = r.insertID;
					chat.addChatLine($.extend({},params));
				});

				return false;
			});

			//new instant translate
			$('#translateForm').submit(function(){
				var text = $('#instant_text').val();
				var fromlang = $('#lang-from').val();
				var tolang = $('#lang-to').val();

				if(text.length == 0){
					return false;
				}

				if(working) return false;
				working = true;

				$.tzGET('translateText',{text: text, lang: tolang},function(res){
					working = false;
					$('#instant_results').html(res);
				});

				return false;
			});


			// Logging the user out:

			$('a.logoutButton').live('click',function(){

				$('#chatTopBar > span').fadeOut(function(){
					$(this).remove();
				});

				$('#submitForm').fadeOut(function(){
					$('#loginForm').fadeIn();
				});

				$.tzPOST('logout');

				return false;
			});

			// Checking whether the user is already logged (browser refresh)
/*
			$.tzGET('checkLogged',function(r){
				if(r.logged){
					chat.checklogged(r.loggedAs.name,r.loggedAs.gravatar);
				}
			});
*/
			// Self executing timeout functions

	//		(function getRoomsTimeoutFunction(){
	//			chat.getRooms(getRoomsTimeoutFunction);
	//		})();	

		});		
	},
	
	// The render method generates the HTML markup 
	// that is needed by the other methods:
	
	render : function(template,params){
		 
		var arr = [];
		switch(template){
			case 'loginTopBar':
				arr = [
				'<span><img src="',params.oemlogo,'" width="23" /> ', 
				'<span class="name">',params.oemlabel,'</span><a href="" class="logoutButton rounded" id="logoutbutton">Logout</a></span>'];
			break; 
			
			case 'chatLine':
/*			
				arr = [
					'<div class="chat chat-',params.id,' rounded"><span class="gravatar"><img src="',params.gravatar,
					'" width="23" height="23" onload="this.style.visibility=\'visible\'" />','</span><span class="author">',params.author,
					':</span><span class="text">',params.text,'</span><span class="time">',params.time,'</span></div>'];
*/	
					
				var type = jQuery.trim(params.msgtype);
					
				if (type == 'P') {
					var t = params.trans.replace("[ROOMLINKPLACEHOLDER]", "<a href='javascript:reloadAndChangeRoom(\"" + params.room + "\")'>");
					t = t.replace("[ENDROOMLINKPLACEHOLDER]", "</a>");
					
					arr = [
					'<div class="chat-',params.id,' chat-text"><div class="main-chat-image"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm" width="26" height="26" onload="this.style.visibility=\'visible\'" /></div><div class="main-chat-message-background"><div class="main-chat-message"><span class="text',params.msgtype,'">',t,
					'</span></div></div><div class="info">From: ',params.author,' @ ',params.time,'</div></div>'
					];
				}
				else {
					arr = [
					'<div class="chat-',params.id,' chat-text"><div class="main-chat-image"><img src="http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm" width="26" height="26" onload="this.style.visibility=\'visible\'" /></div><div class="main-chat-message-background"><div class="main-chat-message"><span class="text',params.msgtype,'">',params.trans,
					'</span></div></div><div class="info">From: ',params.author,' @ ',params.time,' | <font id="country-',params.id,'"></font>, - <font id="language-',params.id,
					'"></font> <!--a href="#" class="button-chat">View profile</a><a href="#" class="button-chat">Send IM</a--></div></div>'
					];
				
					$.tzGET('translateText',{text: getCountry(params.country), lang: $('#lang').val()},function(res){
						working = false;
						$('#country-' + params.id).html(res);
						//chat.data.jspAPI.reinitialise();
						//chat.data.jspAPI.scrollToBottom(true);	
						
						scrollChatBottom();
						
						//$("#chatLineHolder").attr({ scrollTop: $("#chatLineHolder").attr("scrollHeight") });					
					});
				
					$.tzGET('translateText',{text: getLanguage(params.language), lang: $('#lang').val()},function(res){
						working = false;
						$('#language-' + params.id).html(res);
					});
					//chat.data.jspAPI.reinitialise();
					//chat.data.jspAPI.scrollToBottom(true); 					

					scrollChatBottom();
				}
			break;
			

		}
		
		// A single array join is faster than
		// multiple concatenations
		
		return arr.join('');
		
	},
	
	// The addChatLine method ads a chat entry to the page
	
	addChatLine : function(params){
		
		// All times are displayed in the user's timezone
//var_dump($_SESSION);(params);		
		var d = new Date();
		if(params.time) {
			
			// PHP returns the time in UTC (GMT). We use it to feed the date
			// object and later output it in the user's timezone. JavaScript
			// internally converts it for us.
			
			d.setUTCHours(params.time.hours,params.time.minutes);
		}
		
		params.time = (d.getHours() < 10 ? '0' : '' ) + d.getHours()+':'+
					  (d.getMinutes() < 10 ? '0':'') + d.getMinutes();
		
		var markup = chat.render('chatLine',params),
			exists = $('#chatLineHolder .chat-'+params.id);

		if(exists.length){
			exists.remove();
		}
		
		if(!chat.data.lastID){
			// If this is the first chat, remove the
			// paragraph saying there aren't any:
			
			$('#chatLineHolder p').remove();
		}
		
		// If this isn't a temporary chat:
		if(params.id.toString().charAt(0) != 't'){
			var previous = $('#chatLineHolder .chat-'+(+params.id - 1));
			if(previous.length){
				previous.after(markup);
			}
			else
				$('#chatLineHolder').append(markup);
			
			
			//else chat.data.jspAPI.getContentPane().append(markup);
		}
		else
			$('#chatLineHolder').append(markup);
		
//		else chat.data.jspAPI.getContentPane().append(markup);
		
		// As we added new content, we need to
		// reinitialise the jScrollPane plugin:
		
//		chat.data.jspAPI.reinitialise();
//		chat.data.jspAPI.scrollToBottom(true);
//		$("#chatLineHolder").attr({ scrollTop: $("#chatLineHolder").attr("scrollHeight") });
		
		scrollChatBottom();
		
	},
	
	// This method requests the latest chats
	// (since lastID), and adds them to the page.
	
	getChats : function(callback){ 
		$.tzGET('getChats',{lastID: chat.data.lastID, lang: $('#lang').val(), room: $('#chatRoom').val()},function(r){
			for(var i=0;i<r.chats.length;i++){
				chat.addChatLine(r.chats[i]);
			}
			
			if(r.chats.length){
				chat.data.noActivity = 0;
				chat.data.lastID = r.chats[i-1].id;
			}
			else{
				// If no chats were received, increment
				// the noActivity counter.
				
				chat.data.noActivity++;
			}
			
			if(!chat.data.lastID){
				$.tzGET('translateText',{text: 'No chats yet', lang: $('#lang').val()},function(res){
					working = false;

					$('#chatLineHolder').html('<p class="noChats" id="noChats">' + res + '</p>');
					//chat.data.jspAPI.getContentPane().html('<p class="noChats" id="noChats">' + res + '</p>');
				});
			}
			
			// Setting a timeout for the next request,
			// depending on the chat activity:
			
			var nextRequest = 1000;
			
			// 2 seconds
			if(chat.data.noActivity > 3){
				nextRequest = 2000;
			}
			
			if(chat.data.noActivity > 10){
				nextRequest = 5000;
			}
			
			// 15 seconds
			if(chat.data.noActivity > 20){
				nextRequest = 15000;
			}
		
			setTimeout(callback,nextRequest);
		});
	},
	
	// Requesting a list with all the users.
	
	getUsers : function(callback){
		
//console.log('getUsers');		
		
		var cr = 1;
		if ($('#chatRoom').val())
			cr = $('#chatRoom').val();
			
		$.tzGET('getUsers',{chatRoom: cr},function(r){
			
			var users = [];
			for(var i=0; i< r.users.length;i++){
				if(r.users[i]){
 					users.push(chat.render('user',r.users[i]));
				}
			}
			
			var message = '';
			
			if(r.total<1){
				message = 'No one is online';
			}
			else {
				message = (r.total == 1 ? 'person':'people')+' online';
			}

			$.tzGET('translateText',{text: message, lang: $('#lang').val()},function(res){
				working = false;

				message = res;
				
				users.push('<p class="count">'+r.total+' '+message+'</p>');
				$('#chatUsers').html(users.join(''));

				setTimeout(callback,15000);
			});
			
		});
	},

	// Requesting a list with all the users.
	
	getSystemTranslations : function(callback){
		$.tzGET('getSystemTranslations',{language: $('#lang').val()},function(r){
			
			var trans = [];
			
			var bChatAbout = false;
			var bChatWith = false;
			var bSubmit = false;
			var bTranslate = false;
			var bFrom = false;
			var bTo = false;
			var bLogin = false;
			var bNoChatsYet = false;
			var bInstantTranslate = false;
			var bCreateNewChatTopic = false;
			var bcreate_new_topic = false;
			var bcreate_new_invite = false;
			var bbtn_create_chat_topic = false;
			var bbtn_create_chat_cancel = false;
			var bnot_entered_chat_topic = false;
			var bnot_selected_users = false;
			
			var binvite_friends = false;
			var bselect_language = false;
			var binvite_your_friends = false;
			
			for(var i=0; i< r.trans.length;i++){
				if(r.trans[i]){
					
					
					var params = r.trans[i];
					
					var from = params.orig_text;
					var to = params.to_text;
					
					if (from == 'Chat About') {
						$('#ChatRoomLabel').html(to);
						bChatAbout = true;
					}
					else if (from == 'Chat With') {
						$('#ChatWithLabel').html(to);
						bChatWith = true;
					}
					else if (from == 'Submit') {
						//$('#SubmitButton').val(to);
						$('#SubmitButton').attr('value', to);
						bSubmit = true;
					}
					else if (from == 'Translate'){
						$('#InstantTranslateButton').val(to);
						$('#Translate_Label').html(to);  
						bTranslate = true;
					}
					else if (from == 'From') {
						$('#From_Label').html(to);
						bFrom = true;
					}
					else if (from == 'To') {
						$('#To_Label').html(to);
						bTo = true;
					}
					else if (from == 'Login') { 
						$('#logmein').val(to);
						bLogin = true;
					}
					else if (from == 'No chats yet') {
						$('#noChats').html(to);
						bNoChatsYet = true;
					}
					else if (from == 'Instant Translate') {
						$('#InstantTranslateLabel').html(to);
						bInstantTranslate = true;
					}
					else if (from == 'Create new Chat Topic') {
						$('#dialog-form').dialog('option', 'title', to);
						bCreateNewChatTopic = true;
					}
					else if (from == 'Topic') {
						$('#create_new_topic').html(to);
						bcreate_new_topic = true;
					}
					else if (from == 'Invite') {
						$('#create_new_invite').html(to);
						bcreate_new_invite = true;
					}
					else if (from == 'Create a Chat Topic') {
						$('#btn_create_chat_topic').html(to);
						bbtn_create_chat_topic = true;
					}
					else if (from == 'Cancel') {
						$('#btn_create_chat_cancel').html(to);
						bbtn_create_chat_cancel = true;
					}
					else if (from == 'You have not entered a topic.') {
						$('#not_entered_chat_topic').val(to);
						bnot_entered_chat_topic = true;
					}
					else if (from == 'You have not selected any users.') {
						$('#not_selected_users').val(to);
						bnot_selected_users = true;
					}
					else if (from == 'Invite Friends') {
						$('#invite_friends').html(to);
						binvite_friends = true;
					}
					else if (from == 'Select Language') {
						$('#select_language').html(to);
						bselect_language = true;
					}
					else if (from == 'Come and chat with me on Babelizer. Babelizer is an app that allows people from around the world to chat without the boundary of language.') {
						$('#invite_your_friends').val(to);
						binvite_your_friends = true;
					}
				}
			}
			
			//If we don't have any of the translations cached then we do the translate (and cache)
			if (!bChatAbout) {
				$.tzGET('translateText',{text: 'Chat About', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#ChatRoomLabel').html(jQuery.trim(res));
				});
			}
			if (!bChatWith) {
				$.tzGET('translateText',{text: 'Chat With', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#ChatWithLabel').html(jQuery.trim(res));
				});
			}
			if (!bSubmit) {
				$.tzGET('translateText',{text: 'Submit', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#SubmitButton').html(jQuery.trim(res));
				});
			}
			if (!bTranslate) {
				$.tzGET('translateText',{text: 'Translate', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#InstantTranslateButton').val(jQuery.trim(res));
					$('#Translate_Label').html(jQuery.trim(res));
				});
			}
			if (!bFrom) {
				$.tzGET('translateText',{text: 'From', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#From_Label').html(jQuery.trim(res));
				});
			}
			if (!bTo) {
				$.tzGET('translateText',{text: 'To', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#To_Label').html(jQuery.trim(res));
				});
			}
			if (!bLogin) {
				$.tzGET('translateText',{text: 'Login', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#logmein').html(jQuery.trim(res));
				});
			}
			if (!bNoChatsYet) {
				$.tzGET('translateText',{text: 'No chats yet', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#noChats').html(jQuery.trim(res));
				});
			}
			if (!bInstantTranslate) {
				$.tzGET('translateText',{text: 'Instant Translate', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#InstantTranslateLabel').html(jQuery.trim(res));
				});
			}
			if (!bCreateNewChatTopic) {
				$.tzGET('translateText',{text: 'Create New Chat Topic', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#dialog-form').dialog('option', 'title', jQuery.trim(res));
				});
			}
			if (!bcreate_new_topic) {
				$.tzGET('translateText',{text: 'Topic', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#create_new_topic').html(jQuery.trim(res));
				});
			}
			if (!bcreate_new_invite) {
				$.tzGET('translateText',{text: 'Invite', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#create_new_invite').html(jQuery.trim(res));
				});
			}
			if (!bbtn_create_chat_cancel) {
				$.tzGET('translateText',{text: 'Cancel', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#btn_create_chat_cancel').html(jQuery.trim(res));
				});
			}
			if (!bbtn_create_chat_topic) {
				$.tzGET('translateText',{text: 'Create a Chat Topic', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#btn_create_chat_topic').html(jQuery.trim(res));
				});
			}
			if (!bnot_entered_chat_topic) {
				$.tzGET('translateText',{text: 'You have not entered a topic.', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#not_entered_chat_topic').val(jQuery.trim(res));
				});
			}
			if (!bnot_selected_users) {
				$.tzGET('translateText',{text: 'You have not selected any users.', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#not_selected_users').val(jQuery.trim(res));
				});
			}
			if (!binvite_friends) {
				$.tzGET('translateText',{text: 'Invite Friends', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#invite_friends').html(jQuery.trim(res));
				});
			}
			if (!bselect_language) {
				$.tzGET('translateText',{text: 'Select Language', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#select_language').html(jQuery.trim(res));
				});
			}
			if (!binvite_your_friends) {
				$.tzGET('translateText',{text: 'Come and chat with me on Babelizer. Babelizer is an app that allows people from around the world to chat without the boundary of language.', lang: $('#lang').val(), type: 'S'},function(res){
					working = false;
					$('#invite_your_friends').val(jQuery.trim(res));
				});
			}
		});
	},

	// This method displays an error message on the top of the page:
	
	displayError : function(msg){
		var elem = $('<div>',{
			id		: 'chatErrorMessage',
			html	: msg
		});
		
		elem.click(function(){
			$(this).fadeOut(function(){
				$(this).remove();
			});
		});
		
		setTimeout(function(){
			elem.click();
		},5000);
		
		elem.hide().appendTo('body').slideDown();
	}
};

// Custom GET & POST wrappers:

$.tzPOST = function(action,data,callback){
	$.post('php/ajax.php?action='+action,data,callback,'json');
}

$.tzGET = function(action,data,callback){
	$.get('php/ajax.php?action='+action,data,callback,'json');
}

// A custom jQuery method for placeholder text:

$.fn.defaultText = function(value){
	
	var element = this.eq(0);
	element.data('defaultText',value);
	
	element.focus(function(){
		if(element.val() == value){
			element.val('').removeClass('defaultText');
		}
	}).blur(function(){
		if(element.val() == '' || element.val() == value){
			element.addClass('defaultText').val(value);
		}
	});
	
	return element.blur();
}