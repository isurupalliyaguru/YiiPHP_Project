<?php
	Yii::app()->clientScript->scriptMap=array('jquery.js'=>false,); // to remove default Yii jquery file loading
	
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->getBaseUrl(true)."/js/common_startup.js",CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->getBaseUrl(true)."/js/tinycarousel.js",CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile("https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false",CClientScript::POS_END);

	$gmap_js_array = "";

	$gmap_js_array = "['". $row["html_h1"] ."', " . $detail_row["gmap_longitude"] . ", " . $detail_row["gmap_latitude"] . ", 1, '" . gescapeJS($row["html_content"]) . "' ,'/images/bodycss/1.png'],";
	
	$gmap_index = 2; //js index 
	$gmap_info_count = 1; //to remove the comma adding to js array
	if (!empty($gmap_info)){
		foreach ($gmap_info as $gmap){
			$gmap_js_array .= "['". $gmap["html_h1"] . "' , " . $gmap["gmap_longitude"] . ", " . $gmap["gmap_latitude"] . " , " . $gmap_index . ", '" . gescapeJS($gmap["html_content"]) . "','/images/bodycss/2.png']".
			( $gmap_info_count < (count($gmap_info))? ',' : '') ;
			$gmap_info_count++;
			$gmap_index++;
		}
	}
	
	Yii::app()->clientScript->registerScript("tab_js",
	'$(document).ready(function($) {
		$(".hotel_info .tab_content > li").each(function (d) {
				if (!$(this).hasClass("active")) {
					$(this).css("display", "none")
				}
			});
			
			$(".tabs li").click(function() {					
				var d = $(this).index();
				$(".hotel_info .tabs li").each(function (e) {
					$(this).removeClass("active")
				});
				$(".hotel_info .tab_content > li").each(function (e) {
					if (e == d) {
						$(this).css("display", "block")
					} else {
						$(this).css("display", "none")
					}
				});
				$(this).addClass("active");        
			});
			
			$(".rates_tab_select").click(function() {
				$(".hotel_info .tabs li").each(function (e) {
					$(this).removeClass("active");
				});
				$(".hotel_info .tab_content > li").each(function (e) {
					$(this).css("display", "none");
				});
				$(".hotel_info .tabs > .rates_tab_heading").addClass("active");
				$(".hotel_info .tab_content > .rates_tab_main").css("display", "block");
				$("html,body").animate({scrollTop:$("#review_tab_scroll").offset().top}, 1500);
			});
	});'
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("view_map",
	'
	var infowindow = null;
	function initialize() {
		var mapOptions = {
		  zoom: 14,
		  center: new google.maps.LatLng(' . $detail_row["gmap_longitude"] . ', ' . $detail_row["gmap_latitude"] . '),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map = new google.maps.Map(document.getElementById("map_canvas"),
									  mapOptions);

		setMarkers(map, hotel);
			infowindow = new google.maps.InfoWindow({
				content: "loading..."
		});
	}
	
	var hotel = [ ' . $gmap_js_array . ' ];
	
	function setMarkers(map, markers) {
		
		var blue_icon = new google.maps.MarkerImage("http://www.apartmentslanka.com/images/bodycss/pointer.png", new google.maps.Size(32, 32), new google.maps.Point(32, 0));
		var red_icon = new google.maps.MarkerImage("http://www.apartmentslanka.com/images/bodycss/pointer.png", new google.maps.Size(32, 32), new google.maps.Point(0, 0));
		
		for (var i = 0; i < markers.length; i++) {
			var sites = markers[i];
			var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
			var marker = new google.maps.Marker({
				position: siteLatLng,
				map: map,
				title: sites[0],
				zIndex: sites[3],
				html: sites[4],
				icon : (i == 0 ? red_icon : blue_icon)
			});

			google.maps.event.addListener(marker, "mouseover", function () {
				infowindow.setContent(this.html);
				infowindow.open(map, this);
			});
		}
	}
		
	$(document).ready(function($) {
		$(".view_map").click(function() {
				$(".google_map").css("display", "block");
				$("html,body").animate({scrollTop:$("#google_map_target").offset().top}, 1500);
				
				initialize();
				
				$(".loading").fadeOut(8000, function() { $(this).remove(); });
				return false;
			});
	})'
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("inquiry_flip",
	'$(function() {

			var $Inquries   = $("#Inquries"), 
				$window    = $(window),
				offset     = $Inquries.offset(),
				topPadding = 15;

			$window.scroll(function() {
				if ($window.scrollTop() + 80 > offset.top) {
					$("#Inquries").addClass("inquiryscroll");
				} else {
					$("#Inquries").removeClass("inquiryscroll");
				}
			});
			
		});'
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("execute_gallery",
	"$('#single_image').click(function () {
			$('#thumb_image_first').trigger('click');
		})"
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("photogallery",
	"$(document).ready(function(){					
		$('#slider').tinycarousel();			
	});"
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("photogallery_imagecount",
	" $(document).ready(function() {
		  $('a[rel=img_gallery]').fancybox({
			   helpers : { 
				   title : { type : 'over' }
		   		}, // helpers
			   beforeShow: function() {
				   this.title = '<span>' + (this.title ? ' ' + this.title + '<br />' : '') + 'Image ' + (this.index + 1) + ' of ' + this.group.length + '</span>';
			   } // beforeShow
		  }); // fancybox
	 });"
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("sub_rates_tab",
	'$(".rates_tab > a").each(function () {
			var f = $(this),
				e = false,
				d = f.next("div");
			f.click(function () {
				e = !e;
				d.slideToggle(e);
				f.toggleClass("active");
				if (e) {
					$(this).find(".triangle").html("&#9660;")
				} else {
					$(this).find(".triangle").html("&#9658;")
				}
			})
		});'
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("inquiry",
	"$('#Inquries').fancybox({
		'autoDimensions': true,
		'scrolling'		: 'no',
		'width'			: 500,
		'titleShow'		: false,
		'onClosed'		: function() {
			$('.errorSummary').empty();
			$('.errorSummary').hide();
		}
	});"
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("inquiry2",
	"$('#Inquries2').fancybox({
		'autoDimensions': true,
		'scrolling'		: 'no',		
		'width'			: 500,
		'titleShow'		: false,
		'onClosed'		: function() {
			$('.errorSummary').empty();
			$('.errorSummary').hide();
		}
	});"
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("hide_show_review",
	"$('#review_show').click(function () {
		$('.review_more').toggle();
		$('.review').show();
	});
	$('#review_hide').click(function () {
		$('.review').toggle();
		$('.review_more').toggle();
	});"
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("videos_popup",
	"$('.various').fancybox({
		'transitionIn'	: 'none',
		'transitionOut'	: 'none'
	});"
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("thumb_img",
	"$('.thumb_img').fancybox({
			'transitionIn'	: 'none',
			'transitionOut'	: 'none'
	});"
    ,CClientScript::POS_END);
	
	Yii::app()->clientScript->registerScript("Inquery_form_submit",
	"jQuery(function($) {
		jQuery('body').undelegate('#yt0','click').delegate('#yt0','click',function(){jQuery.ajax({'dataType':'html','success':
				function(html){
					var error = $(html).hasClass('error');
					if(error){
						$('.errorSummary').html(html);
						$('.errorSummary').show();
					}
					else{
						$.fancybox(html);
						setTimeout ('$.fancybox.close ()', 5000);
					}
				}
			,'type':'POST','url':'/hotel/inquiry/','cache':false,'data':jQuery(this).parents('form').serialize()});return false;});
		});"
    ,CClientScript::POS_END);
	
	function hotel_rating($rateid){
		//@param hotel rates eg: 2 star, 3star or 5 star
		//post for css values
		switch($rateid){
			case 1.5:
				return 22;
			case 2: 
				return 30;
			case 2.5:
				return 37;
			case 3:
				return 44;
			case 3.5:
				return 52;
			case 4:
				return 60;
			case 4.5:
				return 67;
			case 5:
				return 75;
			case 5.5:
				return 82;
			case 6:
				return 89;
			case 6.5:
				return 97;
			case 7:
				return 104;
			default:
				return 13; // default is we assue as 1 star hotel
		}
	}
?>
<div class="sub_content">
	<section class="top_content">
		<h1 class="hotel_heading"><?=(!empty($row["html_h1"]) ? $row["html_h1"] : "") ; ?></h1>
		<table class="fl">
			<tbody>
				<tr>
					<td class="review_stars_td"> <ul class="star"><li class="unstyled star curr" style="width:<?=hotel_rating($detail_row["star_rating"]); ?>px;"></li></ul> </td>
				</tr> 
			</tbody>
		</table>
		<div class="fr col-dark-blue inquiry-call">Call: +94 (0) 777 347547</div>
		<div class="spacer_0px"></div>
		<span class="address"><?=(!empty($detail_row["address"]) ? $detail_row["address"] : "") ; ?> <?=(!empty($detail_row["gmap_longitude"]) && !empty($detail_row["gmap_latitude"]) ? '<a class="view_map" href="javascript:;">View Map</a>' : ""); ?> </span><br/>
		<?=(!empty($row["html_content"]) ? $row["html_content"] : "") ; ?>
	</section>
	<section class="middle_content">
		<!-- Loading the gallery -->
		<?php if(!empty($pageContent->pageid) && !empty($row["categoryid"])) $this->widget('application.widgets.photoGallery', array('pageid'=>$pageContent->pageid, 'video_url'=>$detail_row["video_url"], 'categoryid'=>$row["categoryid"])); ?> 
		
		<section class="personal_review">
			<?=(!empty($row["html_content2"]) ? "<h2 class='include_leaf'>
	Our Personal Review</h2>" . $row["html_content2"] : "") ; ?>
		</section>
		
		<aside class="rates">
			<?php if(!empty($detail_row["price_rate_startfrom"])): ?>
			<h2 class="include_leaf">Rates</h2>
			<div class="price_button availability_button">
				<span id="start">Starting from<br/></span>
				<span id="price">USD <?=$detail_row["price_rate_startfrom"]; ?></span><br/>
				<a href="javascript:;" class="rates_tab_select">View Rates</a>
			</div>
			<?php endif; ?>
			<a href="#inquiry_form" id="Inquries" class="inquiryform" title="Inquries">Book Now<br />or Inquire</a>
		</aside>
	</section>
	<div class="spacer_1px"></div>
	<section class="bottom_content">
		<section class="location">
			<ul>
				<?=(!empty($detail_row["gmap_longitude"]) && !empty($detail_row["gmap_latitude"]) ?
				'<li class="map_icon_area">
					<a href="javascript:;" class="view_map map_icon thumb_img">Show Map</a>
				</li>' : ""); ?>
				<?=(!empty($detail_row["location_html"]) ? $detail_row["location_html"] : "") ; ?>
			</ul>
		</section>
		<section class="hotel_info" id="review_tab_scroll">							
			<nav>
				<ul class="tabs">
					<?=(!empty($detail_row["hotel_facilities"]) ? '<li class="active first bgcol-light-blue">Hotel Facilities</li>' : ""); ?>
					<?=(!empty($detail_row["hotel_policies"]) ? '<li class="bgcol-light-blue ">Hotel Policies</li>' : ""); ?>
					<?=(!empty($detail_row["price_rate_startfrom"]) ? '<li class="bgcol-light-blue rates_tab_heading ' . (empty($detail_row["hotel_extra_info_title"]) ? 'last' : '' ). '">Rates</li>': ""); ?>
					<?=(!empty($detail_row["hotel_extra_info_title"]) ? '<li class="bgcol-light-blue last">' . $detail_row["hotel_extra_info_title"] . '</li>': ""); ?>
				</ul>
			</nav>
			<div class="spacer_0px"></div>
			<aside>
				<ul class="tab_content">
					<?=(!empty($detail_row["hotel_facilities"]) ? '<li class="active">' . $detail_row["hotel_facilities"] . '</li>' : ""); ?>
					<?=(!empty($detail_row["hotel_policies"]) ? '<li class="content_txt">' . $detail_row["hotel_policies"] . '</li>' : ""); ?>
					<li class="content_txt rates_tab_main">
						<div class='rates_tab'>
								<?php 
									if (file_exists(dirname(__FILE__)."/rates/" . $pageContent->pageid . ".php")) {
										
										include(dirname(__FILE__)."/rates/" . $pageContent->pageid . ".php"); 
										
										foreach($rates_arr as $rates){
											echo "<a class=''>" . $rates["title"] . "&nbsp;<span class='triangle'>&#9658;</span></a>";
											echo "<div class='rates_description'> 
												". $rates["description"] ." 
												<div class='spacer_1px'></div>
												</div>";
												
											echo '<div class="spacer_1px"></div>';
										}
									} 
								?>
						</div>
					</li>
					<?=((!empty($detail_row["hotel_extra_info_title"]) && !empty($detail_row["hotel_extra_info"])) ? '<li class="content_txt">' . $detail_row["hotel_extra_info"] . '</li>' : ""); ?>
				</ul>
				<div class="spacer_1px"></div>														
			</aside>
		</section>
		<div class="spacer_1px"></div>
		<div class="google_map addpadding" id="google_map_target">
			<img src="/images/bodycss/loadingAnimation.gif" alt="" class="loading" />
			<h2 class="include_leaf">Map</h2>
			<div id="map_canvas" class="google_map_div"></div>
		</div>
	</section>
</div>
<div class="spacer_1px"></div>
<br/>
<div id='make_inquiry' style='display:none'>
	<div id='ajax_content'></div>
	<div class='form'>
		<form id="inquiry_form" action="/nuwaraeliya-mistyhills/hotel/" method="post">
		<fieldset>
			<legend>Book now or Inquire</legend><input type="hidden" value="<?=$_REQUEST['sef_url']; ?>" name="inquiry_sef_url" id="inquiry_sef_url" /><div class='errorSummary' style='display:none;'></div>
			<p>
				<label for='inquiry_name'>Name:* </label>
				<input type='text' id='inquiry_name' name='inquiry_name' size='30' />
			</p>
			<p>
				<label for='inquiry_email'>Email:* </label>
				<input type='email' id='inquiry_email' name='inquiry_email' size='30' />
			</p>
			<p>
				<label for='inquiry_phone'>Phone number: </label>
				<input type='text' id='inquiry_phone' name='inquiry_phone' size='30' />
			</p>
			<p>
				<label for='inquiry_country'>Country: </label>
				<select id='inquiry_country' name='inquiry_country'><option value='Please select'>Please select</option><option value='Afghanistan'>Afghanistan</option><option value='Åland Islands'>Åland Islands</option><option value='Albania'>Albania</option><option value='Algeria'>Algeria</option><option value='American Samoa'>American Samoa</option><option value='Andorra'>Andorra</option><option value='Angola'>Angola</option><option value='Anguilla'>Anguilla</option><option value='Antarctica'>Antarctica</option><option value='Antigua And Barbuda'>Antigua And Barbuda</option><option value='Argentina'>Argentina</option><option value='Armenia'>Armenia</option><option value='Aruba'>Aruba</option><option value='Australia'>Australia</option><option value='Austria'>Austria</option><option value='Azerbaijan'>Azerbaijan</option><option value='Bahamas'>Bahamas</option><option value='Bahrain'>Bahrain</option><option value='Bangladesh'>Bangladesh</option><option value='Barbados'>Barbados</option><option value='Belarus'>Belarus</option><option value='Belgium'>Belgium</option><option value='Belize'>Belize</option><option value='Benin'>Benin</option><option value='Bermuda'>Bermuda</option><option value='Bhutan'>Bhutan</option><option value='Bolivia, Plurinational State Of'>Bolivia, Plurinational State Of</option><option value='Bonaire, Saint Eustatius And Saba'>Bonaire, Saint Eustatius And Saba</option><option value='Bosnia And Herzegovina'>Bosnia And Herzegovina</option><option value='Botswana'>Botswana</option><option value='Bouvet Island'>Bouvet Island</option><option value='Brazil'>Brazil</option><option value='British Indian Ocean Territory'>British Indian Ocean Territory</option><option value='Brunei Darussalam'>Brunei Darussalam</option><option value='Bulgaria'>Bulgaria</option><option value='Burkina Faso'>Burkina Faso</option><option value='Burundi'>Burundi</option><option value='Cambodia'>Cambodia</option><option value='Cameroon'>Cameroon</option><option value='Canada'>Canada</option><option value='Cape Verde'>Cape Verde</option><option value='Cayman Islands'>Cayman Islands</option><option value='Central African Republic'>Central African Republic</option><option value='Chad'>Chad</option><option value='Chile'>Chile</option><option value='China'>China</option><option value='Christmas Island'>Christmas Island</option><option value='Cocos (keeling) Islands'>Cocos (keeling) Islands</option><option value='Colombia'>Colombia</option><option value='Comoros'>Comoros</option><option value='Congo'>Congo</option><option value='Congo, The Democratic Republic Of The'>Congo, The Democratic Republic Of The</option><option value='Cook Islands'>Cook Islands</option><option value='Costa Rica'>Costa Rica</option><option value='CÔte Divoire'>CÔte Divoire</option><option value='Croatia'>Croatia</option><option value='Curaçao'>Curaçao</option><option value='Cuba'>Cuba</option><option value='Cyprus'>Cyprus</option><option value='Czech Republic'>Czech Republic</option><option value='Denmark'>Denmark</option><option value='Djibouti'>Djibouti</option><option value='Dominica'>Dominica</option><option value='Dominican Republic'>Dominican Republic</option><option value='Ecuador'>Ecuador</option><option value='Egypt'>Egypt</option><option value='El Salvador'>El Salvador</option><option value='Equatorial Guinea'>Equatorial Guinea</option><option value='Eritrea'>Eritrea</option><option value='Estonia'>Estonia</option><option value='Ethiopia'>Ethiopia</option><option value='Falkland Islands (malvinas)'>Falkland Islands (malvinas)</option><option value='Faroe Islands'>Faroe Islands</option><option value='Fiji'>Fiji</option><option value='Finland'>Finland</option><option value='France'>France</option><option value='French Guiana'>French Guiana</option><option value='French Polynesia'>French Polynesia</option><option value='French Southern Territories'>French Southern Territories</option><option value='Gabon'>Gabon</option><option value='Gambia'>Gambia</option><option value='Georgia'>Georgia</option><option value='Germany'>Germany</option><option value='Ghana'>Ghana</option><option value='Gibraltar'>Gibraltar</option><option value='Greece'>Greece</option><option value='Greenland'>Greenland</option><option value='Grenada'>Grenada</option><option value='Guadeloupe'>Guadeloupe</option><option value='Guam'>Guam</option><option value='Guatemala'>Guatemala</option><option value='Guernsey'>Guernsey</option><option value='Guinea'>Guinea</option><option value='Guinea-bissau'>Guinea-bissau</option><option value='Guyana'>Guyana</option><option value='Haiti'>Haiti</option><option value='Heard Island And Mcdonald Islands'>Heard Island And Mcdonald Islands</option><option value='Holy See (vatican City State)'>Holy See (vatican City State)</option><option value='Honduras'>Honduras</option><option value='Hong Kong'>Hong Kong</option><option value='Hungary'>Hungary</option><option value='Iceland'>Iceland</option><option value='India'>India</option><option value='Indonesia'>Indonesia</option><option value='Iran, Islamic Republic Of'>Iran, Islamic Republic Of</option><option value='Iraq'>Iraq</option><option value='Ireland'>Ireland</option><option value='Isle Of Man'>Isle Of Man</option><option value='Israel'>Israel</option><option value='Italy'>Italy</option><option value='Jamaica'>Jamaica</option><option value='Japan'>Japan</option><option value='Jersey'>Jersey</option><option value='Jordan'>Jordan</option><option value='Kazakhstan'>Kazakhstan</option><option value='Kenya'>Kenya</option><option value='Kiribati'>Kiribati</option><option value='Korea, Democratic Peoples Republic Of'>Korea, Democratic Peoples Republic Of</option><option value='Korea, Republic Of'>Korea, Republic Of</option><option value='Kuwait'>Kuwait</option><option value='Kyrgyzstan'>Kyrgyzstan</option><option value='Lao Peoples Democratic Republic'>Lao Peoples Democratic Republic</option><option value='Latvia'>Latvia</option><option value='Lebanon'>Lebanon</option><option value='Lesotho'>Lesotho</option><option value='Liberia'>Liberia</option><option value='Libyan Arab Jamahiriya'>Libyan Arab Jamahiriya</option><option value='Liechtenstein'>Liechtenstein</option><option value='Lithuania'>Lithuania</option><option value='Luxembourg'>Luxembourg</option><option value='Macao'>Macao</option><option value='Macedonia, The Former Yugoslav Republic Of'>Macedonia, The Former Yugoslav Republic Of</option><option value='Madagascar'>Madagascar</option><option value='Malawi'>Malawi</option><option value='Malaysia'>Malaysia</option><option value='Maldives'>Maldives</option><option value='Mali'>Mali</option><option value='Malta'>Malta</option><option value='Marshall Islands'>Marshall Islands</option><option value='Martinique'>Martinique</option><option value='Mauritania'>Mauritania</option><option value='Mauritius'>Mauritius</option><option value='Mayotte'>Mayotte</option><option value='Mexico'>Mexico</option><option value='Micronesia, Federated States Of'>Micronesia, Federated States Of</option><option value='Moldova, Republic Of'>Moldova, Republic Of</option><option value='Monaco'>Monaco</option><option value='Mongolia'>Mongolia</option><option value='Montenegro'>Montenegro</option><option value='Montserrat'>Montserrat</option><option value='Morocco'>Morocco</option><option value='Mozambique'>Mozambique</option><option value='Myanmar'>Myanmar</option><option value='Namibia'>Namibia</option><option value='Nauru'>Nauru</option><option value='Nepal'>Nepal</option><option value='Netherlands'>Netherlands</option><option value='New Caledonia'>New Caledonia</option><option value='New Zealand'>New Zealand</option><option value='Nicaragua'>Nicaragua</option><option value='Niger'>Niger</option><option value='Nigeria'>Nigeria</option><option value='Niue'>Niue</option><option value='Norfolk Island'>Norfolk Island</option><option value='Northern Mariana Islands'>Northern Mariana Islands</option><option value='Norway'>Norway</option><option value='Oman'>Oman</option><option value='Pakistan'>Pakistan</option><option value='Palau'>Palau</option><option value='Palestinian Territory, Occupied'>Palestinian Territory, Occupied</option><option value='Panama'>Panama</option><option value='Papua New Guinea'>Papua New Guinea</option><option value='Paraguay'>Paraguay</option><option value='Peru'>Peru</option><option value='Philippines'>Philippines</option><option value='Pitcairn'>Pitcairn</option><option value='Poland'>Poland</option><option value='Portugal'>Portugal</option><option value='Puerto Rico'>Puerto Rico</option><option value='Qatar'>Qatar</option><option value='Reunion'>Reunion</option><option value='Romania'>Romania</option><option value='Russian Federation'>Russian Federation</option><option value='Rwanda'>Rwanda</option><option value='Saint BarthÉlemy'>Saint BarthÉlemy</option><option value='Saint Helena, Ascension And Tristan Da Cunha'>Saint Helena, Ascension And Tristan Da Cunha</option><option value='Saint Kitts And Nevis'>Saint Kitts And Nevis</option><option value='Saint Lucia'>Saint Lucia</option><option value='Saint Martin (french Part)'>Saint Martin (french Part)</option><option value='Saint Pierre And Miquelon'>Saint Pierre And Miquelon</option><option value='Saint Vincent And The Grenadines'>Saint Vincent And The Grenadines</option><option value='Samoa'>Samoa</option><option value='San Marino'>San Marino</option><option value='Sao Tome And Principe'>Sao Tome And Principe</option><option value='Saudi Arabia'>Saudi Arabia</option><option value='Senegal'>Senegal</option><option value='Serbia'>Serbia</option><option value='Seychelles'>Seychelles</option><option value='Sierra Leone'>Sierra Leone</option><option value='Singapore'>Singapore</option><option value='Sint Maarten (dutch Part)'>Sint Maarten (dutch Part)</option><option value='Slovakia'>Slovakia</option><option value='Slovenia'>Slovenia</option><option value='Solomon Islands'>Solomon Islands</option><option value='Somalia'>Somalia</option><option value='South Africa'>South Africa</option><option value='South Georgia And The South Sandwich Islands'>South Georgia And The South Sandwich Islands</option><option value='Spain'>Spain</option><option value='Sri Lanka'>Sri Lanka</option><option value='Sudan'>Sudan</option><option value='Suriname'>Suriname</option><option value='Svalbard And Jan Mayen'>Svalbard And Jan Mayen</option><option value='Swaziland'>Swaziland</option><option value='Sweden'>Sweden</option><option value='Switzerland'>Switzerland</option><option value='Syrian Arab Republic'>Syrian Arab Republic</option><option value='Taiwan, Province Of China'>Taiwan, Province Of China</option><option value='Tajikistan'>Tajikistan</option><option value='Tanzania, United Republic Of'>Tanzania, United Republic Of</option><option value='Thailand'>Thailand</option><option value='Timor-leste'>Timor-leste</option><option value='Togo'>Togo</option><option value='Tokelau'>Tokelau</option><option value='Tonga'>Tonga</option><option value='Trinidad And Tobago'>Trinidad And Tobago</option><option value='Tunisia'>Tunisia</option><option value='Turkey'>Turkey</option><option value='Turkmenistan'>Turkmenistan</option><option value='Turks And Caicos Islands'>Turks And Caicos Islands</option><option value='Tuvalu'>Tuvalu</option><option value='Uganda'>Uganda</option><option value='Ukraine'>Ukraine</option><option value='United Arab Emirates'>United Arab Emirates</option><option value='United Kingdom'>United Kingdom</option><option value='United States'>United States</option><option value='United States Minor Outlying Islands'>United States Minor Outlying Islands</option><option value='Uruguay'>Uruguay</option><option value='Uzbekistan'>Uzbekistan</option><option value='Vanuatu'>Vanuatu</option><option value='Venezuela, Bolivarian Republic Of'>Venezuela, Bolivarian Republic Of</option><option value='Viet Nam'>Viet Nam</option><option value='Virgin Islands, British'>Virgin Islands, British</option><option value='Virgin Islands, U.S.'>Virgin Islands, U.S.</option><option value='Wallis And Futuna'>Wallis And Futuna</option><option value='Western Sahara'>Western Sahara</option><option value='Yemen'>Yemen</option><option value='Zambia'>Zambia</option><option value='Zimbabwe'>Zimbabwe</option></select>
			</p>
			<p>
				<label for='inquiry_chk_in'>Check in date: </label>
				<input type='text' id='inquiry_chk_in' name='inquiry_chk_in' size='30' />
			</p>
			<p>
				<label for='inquiry_chk_out'>Check out date: </label>
				<input type='text' id='inquiry_chk_out' name='inquiry_chk_out' size='30' />
			</p>
			<p>
				<label for='inquiry_message'>Your Message / Special Requirements: </label>
				<textarea rows='2' cols='30' id='inquiry_message' name='inquiry_message' placeholder='If you have any special requests, comments or questions, please type them here.'></textarea>
			</p>
			<div style='visibility: hidden; float: left; margin-top:-46px;'><input type="text" value="" name="filter" id="filter" /></div>
			<br /><input type="submit" name="yt0" value="Submit inquiry" id="yt0" /><span class='inquiry-call col-dark-blue'> or call: +94 (0) 777 347547</span>
		</fieldset>
		</form>
	</div>
</div>
