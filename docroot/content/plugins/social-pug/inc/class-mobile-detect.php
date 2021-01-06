<?php

namespace Mediavine\Grow;
/**
 * Mobile Detect Library
 * =====================
 *
 * Motto: "Every business should have a mobile detection script to detect mobile readers"
 *
 * Mobile_Detect is a lightweight PHP class for detecting mobile devices (including tablets).
 * It uses the User-Agent string combined with specific HTTP headers to detect the mobile environment.
 *
 * @author      Current authors: Serban Ghita <serbanghita@gmail.com>
 *                               Nick Ilyin <nick.ilyin@gmail.com>
 *
 *              Original author: Victor Stanciu <vic.stanciu@gmail.com>
 *
 * @license     Code and contributions have 'MIT License'
 *              More details: https://github.com/serbanghita/Mobile-Detect/blob/master/LICENSE.txt
 *
 * @link        Homepage:     http://mobiledetect.net
 *              GitHub Repo:  https://github.com/serbanghita/Mobile-Detect
 *              Google Code:  http://code.google.com/p/php-mobile-detect/
 *              README:       https://github.com/serbanghita/Mobile-Detect/blob/master/README.md
 *              HOWTO:        https://github.com/serbanghita/Mobile-Detect/wiki/Code-examples
 *
 * @version     2.8.24
 */
class Mobile_Detect {
	/**
	 * Mobile detection type.
	 *
	 * @deprecated since version 2.6.9
	 */
	const DETECTION_TYPE_MOBILE = 'mobile';

	/**
	 * Extended detection type.
	 *
	 * @deprecated since version 2.6.9
	 */
	const DETECTION_TYPE_EXTENDED = 'extended';

	/**
	 * A frequently used regular expression to extract version #s.
	 *
	 * @deprecated since version 2.6.9
	 */
	const VER = '([\w._\+]+)';

	/**
	 * Top-level device.
	 */
	const MOBILE_GRADE_A = 'A';

	/**
	 * Mid-level device.
	 */
	const MOBILE_GRADE_B = 'B';

	/**
	 * Low-level device.
	 */
	const MOBILE_GRADE_C = 'C';

	/**
	 * Stores the version number of the current release.
	 */
	const VERSION = '2.8.24';

	/**
	 * A type for the version() method indicating a string return value.
	 */
	const VERSION_TYPE_STRING = 'text';

	/**
	 * A type for the version() method indicating a float return value.
	 */
	const VERSION_TYPE_FLOAT = 'float';
	/**
	 * HTTP headers that trigger the 'isMobile' detection
	 * to be true.
	 *
	 * @var array
	 */
	protected static $mobileHeaders = [

		'HTTP_ACCEPT'                  => [
			'matches' => [
				// Opera Mini; @reference: http://dev.opera.com/articles/view/opera-binary-markup-language/
				'application/x-obml2d',
				// BlackBerry devices.
				'application/vnd.rim.html',
				'text/vnd.wap.wml',
				'application/vnd.wap.xhtml+xml',
			],
		],
		'HTTP_X_WAP_PROFILE'           => null,
		'HTTP_X_WAP_CLIENTID'          => null,
		'HTTP_WAP_CONNECTION'          => null,
		'HTTP_PROFILE'                 => null,
		// Reported by Opera on Nokia devices (eg. C3).
		'HTTP_X_OPERAMINI_PHONE_UA'    => null,
		'HTTP_X_NOKIA_GATEWAY_ID'      => null,
		'HTTP_X_ORANGE_ID'             => null,
		'HTTP_X_VODAFONE_3GPDPCONTEXT' => null,
		'HTTP_X_HUAWEI_USERID'         => null,
		// Reported by Windows Smartphones.
		'HTTP_UA_OS'                   => null,
		// Reported by Verizon, Vodafone proxy system.
		'HTTP_X_MOBILE_GATEWAY'        => null,
		// Seen this on HTC Sensation. SensationXE_Beats_Z715e.
		'HTTP_X_ATT_DEVICEID'          => null,
		// Seen this on a HTC.
		'HTTP_UA_CPU'                  => [ 'matches' => [ 'ARM' ] ],
	];
	/**
	 * List of mobile devices (phones).
	 *
	 * @var array
	 */
	protected static $phoneDevices = [
		'iPhone'       => '\biPhone\b|\biPod\b',
		// |\biTunes
		'BlackBerry'   => 'BlackBerry|\bBB10\b|rim[0-9]+',
		'HTC'          => 'HTC|HTC.*(Sensation|Evo|Vision|Explorer|6800|8100|8900|A7272|S510e|C110e|Legend|Desire|T8282)|APX515CKT|Qtek9090|APA9292KT|HD_mini|Sensation.*Z710e|PG86100|Z715e|Desire.*(A8181|HD)|ADR6200|ADR6400L|ADR6425|001HT|Inspire 4G|Android.*\bEVO\b|T-Mobile G1|Z520m',
		'Nexus'        => 'Nexus One|Nexus S|Galaxy.*Nexus|Android.*Nexus.*Mobile|Nexus 4|Nexus 5|Nexus 6',
		// @todo: Is 'Dell Streak' a tablet or a phone? ;)
		'Dell'         => 'Dell.*Streak|Dell.*Aero|Dell.*Venue|DELL.*Venue Pro|Dell Flash|Dell Smoke|Dell Mini 3iX|XCD28|XCD35|\b001DL\b|\b101DL\b|\bGS01\b',
		'Motorola'     => 'Motorola|DROIDX|DROID BIONIC|\bDroid\b.*Build|Android.*Xoom|HRI39|MOT-|A1260|A1680|A555|A853|A855|A953|A955|A956|Motorola.*ELECTRIFY|Motorola.*i1|i867|i940|MB200|MB300|MB501|MB502|MB508|MB511|MB520|MB525|MB526|MB611|MB612|MB632|MB810|MB855|MB860|MB861|MB865|MB870|ME501|ME502|ME511|ME525|ME600|ME632|ME722|ME811|ME860|ME863|ME865|MT620|MT710|MT716|MT720|MT810|MT870|MT917|Motorola.*TITANIUM|WX435|WX445|XT300|XT301|XT311|XT316|XT317|XT319|XT320|XT390|XT502|XT530|XT531|XT532|XT535|XT603|XT610|XT611|XT615|XT681|XT701|XT702|XT711|XT720|XT800|XT806|XT860|XT862|XT875|XT882|XT883|XT894|XT901|XT907|XT909|XT910|XT912|XT928|XT926|XT915|XT919|XT925|XT1021|\bMoto E\b',
		'Samsung'      => '\bSamsung\b|SM-G9250|GT-19300|SGH-I337|BGT-S5230|GT-B2100|GT-B2700|GT-B2710|GT-B3210|GT-B3310|GT-B3410|GT-B3730|GT-B3740|GT-B5510|GT-B5512|GT-B5722|GT-B6520|GT-B7300|GT-B7320|GT-B7330|GT-B7350|GT-B7510|GT-B7722|GT-B7800|GT-C3010|GT-C3011|GT-C3060|GT-C3200|GT-C3212|GT-C3212I|GT-C3262|GT-C3222|GT-C3300|GT-C3300K|GT-C3303|GT-C3303K|GT-C3310|GT-C3322|GT-C3330|GT-C3350|GT-C3500|GT-C3510|GT-C3530|GT-C3630|GT-C3780|GT-C5010|GT-C5212|GT-C6620|GT-C6625|GT-C6712|GT-E1050|GT-E1070|GT-E1075|GT-E1080|GT-E1081|GT-E1085|GT-E1087|GT-E1100|GT-E1107|GT-E1110|GT-E1120|GT-E1125|GT-E1130|GT-E1160|GT-E1170|GT-E1175|GT-E1180|GT-E1182|GT-E1200|GT-E1210|GT-E1225|GT-E1230|GT-E1390|GT-E2100|GT-E2120|GT-E2121|GT-E2152|GT-E2220|GT-E2222|GT-E2230|GT-E2232|GT-E2250|GT-E2370|GT-E2550|GT-E2652|GT-E3210|GT-E3213|GT-I5500|GT-I5503|GT-I5700|GT-I5800|GT-I5801|GT-I6410|GT-I6420|GT-I7110|GT-I7410|GT-I7500|GT-I8000|GT-I8150|GT-I8160|GT-I8190|GT-I8320|GT-I8330|GT-I8350|GT-I8530|GT-I8700|GT-I8703|GT-I8910|GT-I9000|GT-I9001|GT-I9003|GT-I9010|GT-I9020|GT-I9023|GT-I9070|GT-I9082|GT-I9100|GT-I9103|GT-I9220|GT-I9250|GT-I9300|GT-I9305|GT-I9500|GT-I9505|GT-M3510|GT-M5650|GT-M7500|GT-M7600|GT-M7603|GT-M8800|GT-M8910|GT-N7000|GT-S3110|GT-S3310|GT-S3350|GT-S3353|GT-S3370|GT-S3650|GT-S3653|GT-S3770|GT-S3850|GT-S5210|GT-S5220|GT-S5229|GT-S5230|GT-S5233|GT-S5250|GT-S5253|GT-S5260|GT-S5263|GT-S5270|GT-S5300|GT-S5330|GT-S5350|GT-S5360|GT-S5363|GT-S5369|GT-S5380|GT-S5380D|GT-S5560|GT-S5570|GT-S5600|GT-S5603|GT-S5610|GT-S5620|GT-S5660|GT-S5670|GT-S5690|GT-S5750|GT-S5780|GT-S5830|GT-S5839|GT-S6102|GT-S6500|GT-S7070|GT-S7200|GT-S7220|GT-S7230|GT-S7233|GT-S7250|GT-S7500|GT-S7530|GT-S7550|GT-S7562|GT-S7710|GT-S8000|GT-S8003|GT-S8500|GT-S8530|GT-S8600|SCH-A310|SCH-A530|SCH-A570|SCH-A610|SCH-A630|SCH-A650|SCH-A790|SCH-A795|SCH-A850|SCH-A870|SCH-A890|SCH-A930|SCH-A950|SCH-A970|SCH-A990|SCH-I100|SCH-I110|SCH-I400|SCH-I405|SCH-I500|SCH-I510|SCH-I515|SCH-I600|SCH-I730|SCH-I760|SCH-I770|SCH-I830|SCH-I910|SCH-I920|SCH-I959|SCH-LC11|SCH-N150|SCH-N300|SCH-R100|SCH-R300|SCH-R351|SCH-R400|SCH-R410|SCH-T300|SCH-U310|SCH-U320|SCH-U350|SCH-U360|SCH-U365|SCH-U370|SCH-U380|SCH-U410|SCH-U430|SCH-U450|SCH-U460|SCH-U470|SCH-U490|SCH-U540|SCH-U550|SCH-U620|SCH-U640|SCH-U650|SCH-U660|SCH-U700|SCH-U740|SCH-U750|SCH-U810|SCH-U820|SCH-U900|SCH-U940|SCH-U960|SCS-26UC|SGH-A107|SGH-A117|SGH-A127|SGH-A137|SGH-A157|SGH-A167|SGH-A177|SGH-A187|SGH-A197|SGH-A227|SGH-A237|SGH-A257|SGH-A437|SGH-A517|SGH-A597|SGH-A637|SGH-A657|SGH-A667|SGH-A687|SGH-A697|SGH-A707|SGH-A717|SGH-A727|SGH-A737|SGH-A747|SGH-A767|SGH-A777|SGH-A797|SGH-A817|SGH-A827|SGH-A837|SGH-A847|SGH-A867|SGH-A877|SGH-A887|SGH-A897|SGH-A927|SGH-B100|SGH-B130|SGH-B200|SGH-B220|SGH-C100|SGH-C110|SGH-C120|SGH-C130|SGH-C140|SGH-C160|SGH-C170|SGH-C180|SGH-C200|SGH-C207|SGH-C210|SGH-C225|SGH-C230|SGH-C417|SGH-C450|SGH-D307|SGH-D347|SGH-D357|SGH-D407|SGH-D415|SGH-D780|SGH-D807|SGH-D980|SGH-E105|SGH-E200|SGH-E315|SGH-E316|SGH-E317|SGH-E335|SGH-E590|SGH-E635|SGH-E715|SGH-E890|SGH-F300|SGH-F480|SGH-I200|SGH-I300|SGH-I320|SGH-I550|SGH-I577|SGH-I600|SGH-I607|SGH-I617|SGH-I627|SGH-I637|SGH-I677|SGH-I700|SGH-I717|SGH-I727|SGH-i747M|SGH-I777|SGH-I780|SGH-I827|SGH-I847|SGH-I857|SGH-I896|SGH-I897|SGH-I900|SGH-I907|SGH-I917|SGH-I927|SGH-I937|SGH-I997|SGH-J150|SGH-J200|SGH-L170|SGH-L700|SGH-M110|SGH-M150|SGH-M200|SGH-N105|SGH-N500|SGH-N600|SGH-N620|SGH-N625|SGH-N700|SGH-N710|SGH-P107|SGH-P207|SGH-P300|SGH-P310|SGH-P520|SGH-P735|SGH-P777|SGH-Q105|SGH-R210|SGH-R220|SGH-R225|SGH-S105|SGH-S307|SGH-T109|SGH-T119|SGH-T139|SGH-T209|SGH-T219|SGH-T229|SGH-T239|SGH-T249|SGH-T259|SGH-T309|SGH-T319|SGH-T329|SGH-T339|SGH-T349|SGH-T359|SGH-T369|SGH-T379|SGH-T409|SGH-T429|SGH-T439|SGH-T459|SGH-T469|SGH-T479|SGH-T499|SGH-T509|SGH-T519|SGH-T539|SGH-T559|SGH-T589|SGH-T609|SGH-T619|SGH-T629|SGH-T639|SGH-T659|SGH-T669|SGH-T679|SGH-T709|SGH-T719|SGH-T729|SGH-T739|SGH-T746|SGH-T749|SGH-T759|SGH-T769|SGH-T809|SGH-T819|SGH-T839|SGH-T919|SGH-T929|SGH-T939|SGH-T959|SGH-T989|SGH-U100|SGH-U200|SGH-U800|SGH-V205|SGH-V206|SGH-X100|SGH-X105|SGH-X120|SGH-X140|SGH-X426|SGH-X427|SGH-X475|SGH-X495|SGH-X497|SGH-X507|SGH-X600|SGH-X610|SGH-X620|SGH-X630|SGH-X700|SGH-X820|SGH-X890|SGH-Z130|SGH-Z150|SGH-Z170|SGH-ZX10|SGH-ZX20|SHW-M110|SPH-A120|SPH-A400|SPH-A420|SPH-A460|SPH-A500|SPH-A560|SPH-A600|SPH-A620|SPH-A660|SPH-A700|SPH-A740|SPH-A760|SPH-A790|SPH-A800|SPH-A820|SPH-A840|SPH-A880|SPH-A900|SPH-A940|SPH-A960|SPH-D600|SPH-D700|SPH-D710|SPH-D720|SPH-I300|SPH-I325|SPH-I330|SPH-I350|SPH-I500|SPH-I600|SPH-I700|SPH-L700|SPH-M100|SPH-M220|SPH-M240|SPH-M300|SPH-M305|SPH-M320|SPH-M330|SPH-M350|SPH-M360|SPH-M370|SPH-M380|SPH-M510|SPH-M540|SPH-M550|SPH-M560|SPH-M570|SPH-M580|SPH-M610|SPH-M620|SPH-M630|SPH-M800|SPH-M810|SPH-M850|SPH-M900|SPH-M910|SPH-M920|SPH-M930|SPH-N100|SPH-N200|SPH-N240|SPH-N300|SPH-N400|SPH-Z400|SWC-E100|SCH-i909|GT-N7100|GT-N7105|SCH-I535|SM-N900A|SGH-I317|SGH-T999L|GT-S5360B|GT-I8262|GT-S6802|GT-S6312|GT-S6310|GT-S5312|GT-S5310|GT-I9105|GT-I8510|GT-S6790N|SM-G7105|SM-N9005|GT-S5301|GT-I9295|GT-I9195|SM-C101|GT-S7392|GT-S7560|GT-B7610|GT-I5510|GT-S7582|GT-S7530E|GT-I8750|SM-G9006V|SM-G9008V|SM-G9009D|SM-G900A|SM-G900D|SM-G900F|SM-G900H|SM-G900I|SM-G900J|SM-G900K|SM-G900L|SM-G900M|SM-G900P|SM-G900R4|SM-G900S|SM-G900T|SM-G900V|SM-G900W8|SHV-E160K|SCH-P709|SCH-P729|SM-T2558|GT-I9205|SM-G9350|SM-J120F',
		'LG'           => '\bLG\b;|LG[- ]?(C800|C900|E400|E610|E900|E-900|F160|F180K|F180L|F180S|730|855|L160|LS740|LS840|LS970|LU6200|MS690|MS695|MS770|MS840|MS870|MS910|P500|P700|P705|VM696|AS680|AS695|AX840|C729|E970|GS505|272|C395|E739BK|E960|L55C|L75C|LS696|LS860|P769BK|P350|P500|P509|P870|UN272|US730|VS840|VS950|LN272|LN510|LS670|LS855|LW690|MN270|MN510|P509|P769|P930|UN200|UN270|UN510|UN610|US670|US740|US760|UX265|UX840|VN271|VN530|VS660|VS700|VS740|VS750|VS910|VS920|VS930|VX9200|VX11000|AX840A|LW770|P506|P925|P999|E612|D955|D802|MS323)',
		'Sony'         => 'SonyST|SonyLT|SonyEricsson|SonyEricssonLT15iv|LT18i|E10i|LT28h|LT26w|SonyEricssonMT27i|C5303|C6902|C6903|C6906|C6943|D2533',
		'Asus'         => 'Asus.*Galaxy|PadFone.*Mobile',
		'NokiaLumia'   => 'Lumia [0-9]{3,4}',
		// http://www.micromaxinfo.com/mobiles/smartphones
		// Added because the codes might conflict with Acer Tablets.
		'Micromax'     => 'Micromax.*\b(A210|A92|A88|A72|A111|A110Q|A115|A116|A110|A90S|A26|A51|A35|A54|A25|A27|A89|A68|A65|A57|A90)\b',
		// @todo Complete the regex.
		'Palm'         => 'PalmSource|Palm',
		// avantgo|blazer|elaine|hiptop|plucker|xiino ;
		'Vertu'        => 'Vertu|Vertu.*Ltd|Vertu.*Ascent|Vertu.*Ayxta|Vertu.*Constellation(F|Quest)?|Vertu.*Monika|Vertu.*Signature',
		// Just for fun ;)
		// http://www.pantech.co.kr/en/prod/prodList.do?gbrand=VEGA (PANTECH)
		// Most of the VEGA devices are legacy. PANTECH seem to be newer devices based on Android.
		'Pantech'      => 'PANTECH|IM-A850S|IM-A840S|IM-A830L|IM-A830K|IM-A830S|IM-A820L|IM-A810K|IM-A810S|IM-A800S|IM-T100K|IM-A725L|IM-A780L|IM-A775C|IM-A770K|IM-A760S|IM-A750K|IM-A740S|IM-A730S|IM-A720L|IM-A710K|IM-A690L|IM-A690S|IM-A650S|IM-A630K|IM-A600S|VEGA PTL21|PT003|P8010|ADR910L|P6030|P6020|P9070|P4100|P9060|P5000|CDM8992|TXT8045|ADR8995|IS11PT|P2030|P6010|P8000|PT002|IS06|CDM8999|P9050|PT001|TXT8040|P2020|P9020|P2000|P7040|P7000|C790',
		// http://www.fly-phone.com/devices/smartphones/ ; Included only smartphones.
		'Fly'          => 'IQ230|IQ444|IQ450|IQ440|IQ442|IQ441|IQ245|IQ256|IQ236|IQ255|IQ235|IQ245|IQ275|IQ240|IQ285|IQ280|IQ270|IQ260|IQ250',
		// http://fr.wikomobile.com
		'Wiko'         => 'KITE 4G|HIGHWAY|GETAWAY|STAIRWAY|DARKSIDE|DARKFULL|DARKNIGHT|DARKMOON|SLIDE|WAX 4G|RAINBOW|BLOOM|SUNSET|GOA(?!nna)|LENNY|BARRY|IGGY|OZZY|CINK FIVE|CINK PEAX|CINK PEAX 2|CINK SLIM|CINK SLIM 2|CINK +|CINK KING|CINK PEAX|CINK SLIM|SUBLIM',
		'iMobile'      => 'i-mobile (IQ|i-STYLE|idea|ZAA|Hitz)',
		// Added simvalley mobile just for fun. They have some interesting devices.
		// http://www.simvalley.fr/telephonie---gps-_22_telephonie-mobile_telephones_.html
		'SimValley'    => '\b(SP-80|XT-930|SX-340|XT-930|SX-310|SP-360|SP60|SPT-800|SP-120|SPT-800|SP-140|SPX-5|SPX-8|SP-100|SPX-8|SPX-12)\b',
		// Wolfgang - a brand that is sold by Aldi supermarkets.
		// http://www.wolfgangmobile.com/
		'Wolfgang'     => 'AT-B24D|AT-AS50HD|AT-AS40W|AT-AS55HD|AT-AS45q2|AT-B26D|AT-AS50Q',
		'Alcatel'      => 'Alcatel',
		'Nintendo'     => 'Nintendo 3DS',
		// http://en.wikipedia.org/wiki/Amoi
		'Amoi'         => 'Amoi',
		// http://en.wikipedia.org/wiki/INQ
		'INQ'          => 'INQ',
		// @Tapatalk is a mobile app; http://support.tapatalk.com/threads/smf-2-0-2-os-and-browser-detection-plugin-and-tapatalk.15565/#post-79039
		'GenericPhone' => 'Tapatalk|PDA;|SAGEM|\bmmp\b|pocket|\bpsp\b|symbian|Smartphone|smartfon|treo|up.browser|up.link|vodafone|\bwap\b|nokia|Series40|Series60|S60|SonyEricsson|N900|MAUI.*WAP.*Browser',
	];
	/**
	 * List of mobile Operating Systems.
	 *
	 * @var array
	 */
	protected static $operatingSystems = [
		'AndroidOS'       => 'Android',
		'BlackBerryOS'    => 'blackberry|\bBB10\b|rim tablet os',
		'PalmOS'          => 'PalmOS|avantgo|blazer|elaine|hiptop|palm|plucker|xiino',
		'SymbianOS'       => 'Symbian|SymbOS|Series60|Series40|SYB-[0-9]+|\bS60\b',
		// @reference: http://en.wikipedia.org/wiki/Windows_Mobile
		'WindowsMobileOS' => 'Windows CE.*(PPC|Smartphone|Mobile|[0-9]{3}x[0-9]{3})|Window Mobile|Windows Phone [0-9.]+|WCE;',
		// @reference: http://en.wikipedia.org/wiki/Windows_Phone
		// http://wifeng.cn/?r=blog&a=view&id=106
		// http://nicksnettravels.builttoroam.com/post/2011/01/10/Bogus-Windows-Phone-7-User-Agent-String.aspx
		// http://msdn.microsoft.com/library/ms537503.aspx
		// https://msdn.microsoft.com/en-us/library/hh869301(v=vs.85).aspx
		'WindowsPhoneOS'  => 'Windows Phone 10.0|Windows Phone 8.1|Windows Phone 8.0|Windows Phone OS|XBLWP7|ZuneWP7|Windows NT 6.[23]; ARM;',
		'iOS'             => '\biPhone.*Mobile|\biPod|\biPad',
		// http://en.wikipedia.org/wiki/MeeGo
		// @todo: research MeeGo in UAs
		'MeeGoOS'         => 'MeeGo',
		// http://en.wikipedia.org/wiki/Maemo
		// @todo: research Maemo in UAs
		'MaemoOS'         => 'Maemo',
		'JavaOS'          => 'J2ME/|\bMIDP\b|\bCLDC\b', // '|Java/' produces bug #135
		'webOS'           => 'webOS|hpwOS',
		'badaOS'          => '\bBada\b',
		'BREWOS'          => 'BREW',
	];
	/**
	 * List of mobile User Agents.
	 *
	 * IMPORTANT: This is a list of only mobile browsers.
	 * Mobile Detect 2.x supports only mobile browsers,
	 * it was never designed to detect all browsers.
	 * The change will come in 2017 in the 3.x release for PHP7.
	 *
	 * @var array
	 */
	protected static $browsers = [
		//'Vivaldi'         => 'Vivaldi',
		// @reference: https://developers.google.com/chrome/mobile/docs/user-agent
		'Chrome'         => '\bCrMo\b|CriOS|Android.*Chrome/[.0-9]* (Mobile)?',
		'Dolfin'         => '\bDolfin\b',
		'Opera'          => 'Opera.*Mini|Opera.*Mobi|Android.*Opera|Mobile.*OPR/[0-9.]+|Coast/[0-9.]+',
		'Skyfire'        => 'Skyfire',
		'Edge'           => 'Mobile Safari/[.0-9]* Edge',
		'IE'             => 'IEMobile|MSIEMobile',
		// |Trident/[.0-9]+
		'Firefox'        => 'fennec|firefox.*maemo|(Mobile|Tablet).*Firefox|Firefox.*Mobile|FxiOS',
		'Bolt'           => 'bolt',
		'TeaShark'       => 'teashark',
		'Blazer'         => 'Blazer',
		// @reference: http://developer.apple.com/library/safari/#documentation/AppleApplications/Reference/SafariWebContent/OptimizingforSafarioniPhone/OptimizingforSafarioniPhone.html#//apple_ref/doc/uid/TP40006517-SW3
		'Safari'         => 'Version.*Mobile.*Safari|Safari.*Mobile|MobileSafari',
		// http://en.wikipedia.org/wiki/Midori_(web_browser)
		//'Midori'          => 'midori',
		//'Tizen'           => 'Tizen',
		'UCBrowser'      => 'UC.*Browser|UCWEB',
		'baiduboxapp'    => 'baiduboxapp',
		'baidubrowser'   => 'baidubrowser',
		// https://github.com/serbanghita/Mobile-Detect/issues/7
		'DiigoBrowser'   => 'DiigoBrowser',
		// http://www.puffinbrowser.com/index.php
		'Puffin'         => 'Puffin',
		// http://mercury-browser.com/index.html
		'Mercury'        => '\bMercury\b',
		// http://en.wikipedia.org/wiki/Obigo_Browser
		'ObigoBrowser'   => 'Obigo',
		// http://en.wikipedia.org/wiki/NetFront
		'NetFront'       => 'NF-Browser',
		// @reference: http://en.wikipedia.org/wiki/Minimo
		// http://en.wikipedia.org/wiki/Vision_Mobile_Browser
		'GenericBrowser' => 'NokiaBrowser|OviBrowser|OneBrowser|TwonkyBeamBrowser|SEMC.*Browser|FlyFlow|Minimo|NetFront|Novarra-Vision|MQQBrowser|MicroMessenger',
		// @reference: https://en.wikipedia.org/wiki/Pale_Moon_(web_browser)
		'PaleMoon'       => 'Android.*PaleMoon|Mobile.*PaleMoon',
	];
	/**
	 * Utilities.
	 *
	 * @var array
	 */
	protected static $utilities = [
		// Experimental. When a mobile device wants to switch to 'Desktop Mode'.
		// http://scottcate.com/technology/windows-phone-8-ie10-desktop-or-mobile/
		// https://github.com/serbanghita/Mobile-Detect/issues/57#issuecomment-15024011
		// https://developers.facebook.com/docs/sharing/best-practices
		'Bot'         => 'Googlebot|facebookexternalhit|AdsBot-Google|Google Keyword Suggestion|Facebot|YandexBot|YandexMobileBot|bingbot|ia_archiver|AhrefsBot|Ezooms|GSLFbot|WBSearchBot|Twitterbot|TweetmemeBot|Twikle|PaperLiBot|Wotbox|UnwindFetchor|Exabot|MJ12bot|YandexImages|TurnitinBot|Pingdom',
		'MobileBot'   => 'Googlebot-Mobile|AdsBot-Google-Mobile|YahooSeeker/M1A1-R2D2',
		'DesktopMode' => 'WPDesktop',
		'TV'          => 'SonyDTV|HbbTV', // experimental
		'WebKit'      => '(webkit)[ /]([\w.]+)',
		// @todo: Include JXD consoles.
		'Console'     => '\b(Nintendo|Nintendo WiiU|Nintendo 3DS|PLAYSTATION|Xbox)\b',
		'Watch'       => 'SM-V700',
	];
	/**
	 * All possible HTTP headers that represent the
	 * User-Agent string.
	 *
	 * @var array
	 */
	protected static $uaHttpHeaders = [
		// The default User-Agent string.
		'HTTP_USER_AGENT',
		// Header can occur on devices using Opera Mini.
		'HTTP_X_OPERAMINI_PHONE_UA',
		// Vodafone specific header: http://www.seoprinciple.com/mobile-web-community-still-angry-at-vodafone/24/
		'HTTP_X_DEVICE_USER_AGENT',
		'HTTP_X_ORIGINAL_USER_AGENT',
		'HTTP_X_SKYFIRE_PHONE',
		'HTTP_X_BOLT_PHONE_UA',
		'HTTP_DEVICE_STOCK_UA',
		'HTTP_X_UCBROWSER_DEVICE_UA',
	];
	/**
	 * The individual segments that could exist in a User-Agent string. VER refers to the regular
	 * expression defined in the constant self::VER.
	 *
	 * @var array
	 */
	protected static $properties = [

		// Build
		'Mobile'           => 'Mobile/[VER]',
		'Build'            => 'Build/[VER]',
		'Version'          => 'Version/[VER]',
		'VendorID'         => 'VendorID/[VER]',

		// Devices
		'iPad'             => 'iPad.*CPU[a-z ]+[VER]',
		'iPhone'           => 'iPhone.*CPU[a-z ]+[VER]',
		'iPod'             => 'iPod.*CPU[a-z ]+[VER]',
		//'BlackBerry'    => array('BlackBerry[VER]', 'BlackBerry [VER];'),
		'Kindle'           => 'Kindle/[VER]',

		// Browser
		'Chrome'           => [ 'Chrome/[VER]', 'CriOS/[VER]', 'CrMo/[VER]' ],
		'Coast'            => [ 'Coast/[VER]' ],
		'Dolfin'           => 'Dolfin/[VER]',
		// @reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/User-Agent/Firefox
		'Firefox'          => [ 'Firefox/[VER]', 'FxiOS/[VER]' ],
		'Fennec'           => 'Fennec/[VER]',
		// http://msdn.microsoft.com/en-us/library/ms537503(v=vs.85).aspx
		// https://msdn.microsoft.com/en-us/library/ie/hh869301(v=vs.85).aspx
		'Edge'             => 'Edge/[VER]',
		'IE'               => [ 'IEMobile/[VER];', 'IEMobile [VER]', 'MSIE [VER];', 'Trident/[0-9.]+;.*rv:[VER]' ],
		// http://en.wikipedia.org/wiki/NetFront
		'NetFront'         => 'NetFront/[VER]',
		'NokiaBrowser'     => 'NokiaBrowser/[VER]',
		'Opera'            => [ ' OPR/[VER]', 'Opera Mini/[VER]', 'Version/[VER]' ],
		'Opera Mini'       => 'Opera Mini/[VER]',
		'Opera Mobi'       => 'Version/[VER]',
		'UC Browser'       => 'UC Browser[VER]',
		'MQQBrowser'       => 'MQQBrowser/[VER]',
		'MicroMessenger'   => 'MicroMessenger/[VER]',
		'baiduboxapp'      => 'baiduboxapp/[VER]',
		'baidubrowser'     => 'baidubrowser/[VER]',
		'SamsungBrowser'   => 'SamsungBrowser/[VER]',
		'Iron'             => 'Iron/[VER]',
		// @note: Safari 7534.48.3 is actually Version 5.1.
		// @note: On BlackBerry the Version is overwriten by the OS.
		'Safari'           => [ 'Version/[VER]', 'Safari/[VER]' ],
		'Skyfire'          => 'Skyfire/[VER]',
		'Tizen'            => 'Tizen/[VER]',
		'Webkit'           => 'webkit[ /][VER]',
		'PaleMoon'         => 'PaleMoon/[VER]',

		// Engine
		'Gecko'            => 'Gecko/[VER]',
		'Trident'          => 'Trident/[VER]',
		'Presto'           => 'Presto/[VER]',
		'Goanna'           => 'Goanna/[VER]',

		// OS
		'iOS'              => ' \bi?OS\b [VER][ ;]{1}',
		'Android'          => 'Android [VER]',
		'BlackBerry'       => [ 'BlackBerry[\w]+/[VER]', 'BlackBerry.*Version/[VER]', 'Version/[VER]' ],
		'BREW'             => 'BREW [VER]',
		'Java'             => 'Java/[VER]',
		// @reference: http://windowsteamblog.com/windows_phone/b/wpdev/archive/2011/08/29/introducing-the-ie9-on-windows-phone-mango-user-agent-string.aspx
		// @reference: http://en.wikipedia.org/wiki/Windows_NT#Releases
		'Windows Phone OS' => [ 'Windows Phone OS [VER]', 'Windows Phone [VER]' ],
		'Windows Phone'    => 'Windows Phone [VER]',
		'Windows CE'       => 'Windows CE/[VER]',
		// http://social.msdn.microsoft.com/Forums/en-US/windowsdeveloperpreviewgeneral/thread/6be392da-4d2f-41b4-8354-8dcee20c85cd
		'Windows NT'       => 'Windows NT [VER]',
		'Symbian'          => [ 'SymbianOS/[VER]', 'Symbian/[VER]' ],
		'webOS'            => [ 'webOS/[VER]', 'hpwOS/[VER];' ],
	];
	/**
	 * A cache for resolved matches
	 * @var array
	 */
	protected $cache = [];
	/**
	 * The User-Agent HTTP header is stored in here.
	 * @var string
	 */
	protected $userAgent = null;
	/**
	 * HTTP headers in the PHP-flavor. So HTTP_USER_AGENT and SERVER_SOFTWARE.
	 * @var array
	 */
	protected $httpHeaders = [];
	/**
	 * CloudFront headers. E.g. CloudFront-Is-Desktop-Viewer, CloudFront-Is-Mobile-Viewer & CloudFront-Is-Tablet-Viewer.
	 * @var array
	 */
	protected $cloudfrontHeaders = [];
	/**
	 * The matching Regex.
	 * This is good for debug.
	 * @var string
	 */
	protected $matchingRegex = null;
	/**
	 * The matches extracted from the regex expression.
	 * This is good for debug.
	 * @var string
	 */
	protected $matchesArray = null;
	/**
	 * The detection type, using self::DETECTION_TYPE_MOBILE or self::DETECTION_TYPE_EXTENDED.
	 *
	 * @deprecated since version 2.6.9
	 *
	 * @var string
	 */
	protected $detectionType = self::DETECTION_TYPE_MOBILE;

	/**
	 * Construct an instance of this class.
	 *
	 * @param array $headers Specify the headers as injection. Should be PHP _SERVER flavored.
	 *                          If left empty, will use the global _SERVER['HTTP_*'] vars instead.
	 * @param string $userAgent Inject the User-Agent header. If null, will use HTTP_USER_AGENT
	 *                          from the $headers array instead.
	 */
	public function __construct(
		array $headers = null,
		$userAgent = null
	) {
		$this->setHttpHeaders( $headers );
		$this->setUserAgent( $userAgent );
	}

	/**
	 * Get the current script version.
	 * This is useful for the demo.php file,
	 * so people can check on what version they are testing
	 * for mobile devices.
	 *
	 * @return string The version number in semantic version format.
	 */
	public static function getScriptVersion() {
		return self::$VERSION;
	}

	/**
	 * Retrieve the list of known phone devices.
	 *
	 * @return array List of phone devices.
	 */
	public static function getPhoneDevices() {
		return self::$phoneDevices;
	}

	/**
	 * Alias for getBrowsers() method.
	 *
	 * @return array List of user agents.
	 */
	public static function getUserAgents() {
		return self::getBrowsers();
	}

	/**
	 * Retrieve the list of known browsers. Specifically, the user agents.
	 *
	 * @return array List of browsers / user agents.
	 */
	public static function getBrowsers() {
		return self::$browsers;
	}

	/**
	 * Retrieve the list of known utilities.
	 *
	 * @return array List of utilities.
	 */
	public static function getUtilities() {
		return self::$utilities;
	}

	/**
	 * Retrieve the list of mobile operating systems.
	 *
	 * @return array The list of mobile operating systems.
	 */
	public static function getOperatingSystems() {
		return self::$operatingSystems;
	}

	/**
	 * Retrieves the HTTP headers.
	 *
	 * @return array
	 */
	public function getHttpHeaders() {
		return $this->httpHeaders;
	}

	/**
	 * Set the HTTP Headers. Must be PHP-flavored. This method will reset existing headers.
	 *
	 * @param array $httpHeaders The headers to set. If null, then using PHP's _SERVER to extract
	 *                           the headers. The default null is left for backwards compatibility.
	 */
	public function setHttpHeaders( $httpHeaders = null ) {
		// use global _SERVER if $httpHeaders aren't defined
		if ( ! is_array( $httpHeaders ) || ! count( $httpHeaders ) ) {
			$httpHeaders = $_SERVER;
		}

		// clear existing headers
		$this->httpHeaders = [];

		// Only save HTTP headers. In PHP land, that means only _SERVER vars that
		// start with HTTP_.
		foreach ( $httpHeaders as $key => $value ) {
			if ( substr( $key, 0, 5 ) === 'HTTP_' ) {
				$this->httpHeaders[ $key ] = $value;
			}
		}

		// In case we're dealing with CloudFront, we need to know.
		$this->setCfHeaders( $httpHeaders );
	}

	/**
	 * Retrieves a particular header. If it doesn't exist, no exception/error is caused.
	 * Simply null is returned.
	 *
	 * @param string $header The name of the header to retrieve. Can be HTTP compliant such as
	 *                       "User-Agent" or "X-Device-User-Agent" or can be php-esque with the
	 *                       all-caps, HTTP_ prefixed, underscore seperated awesomeness.
	 *
	 * @return string|null The value of the header.
	 */
	public function getHttpHeader( $header ) {
		// are we using PHP-flavored headers?
		if ( strpos( $header, '_' ) === false ) {
			$header = str_replace( '-', '_', $header );
			$header = strtoupper( $header );
		}

		// test the alternate, too
		$altHeader = 'HTTP_' . $header;

		//Test both the regular and the HTTP_ prefix
		if ( isset( $this->httpHeaders[ $header ] ) ) {
			return $this->httpHeaders[ $header ];
		} elseif ( isset( $this->httpHeaders[ $altHeader ] ) ) {
			return $this->httpHeaders[ $altHeader ];
		}

		return null;
	}

	/**
	 * Get all possible HTTP headers that
	 * can contain the User-Agent string.
	 *
	 * @return array List of HTTP headers.
	 */
	public function getUaHttpHeaders() {
		return self::$uaHttpHeaders;
	}

	/**
	 * Set CloudFront headers
	 * http://docs.aws.amazon.com/AmazonCloudFront/latest/DeveloperGuide/header-caching.html#header-caching-web-device
	 *
	 * @param array $cfHeaders List of HTTP headers
	 *
	 * @return  boolean If there were CloudFront headers to be set
	 */
	public function setCfHeaders( $cfHeaders = null ) {
		// use global _SERVER if $cfHeaders aren't defined
		if ( ! is_array( $cfHeaders ) || ! count( $cfHeaders ) ) {
			$cfHeaders = $_SERVER;
		}

		// clear existing headers
		$this->cloudfrontHeaders = [];

		// Only save CLOUDFRONT headers. In PHP land, that means only _SERVER vars that
		// start with cloudfront-.
		$response = false;
		foreach ( $cfHeaders as $key => $value ) {
			if ( substr( strtolower( $key ), 0, 16 ) === 'http_cloudfront_' ) {
				$this->cloudfrontHeaders[ strtoupper( $key ) ] = $value;
				$response                                      = true;
			}
		}

		return $response;
	}

	public function getMatchingRegex() {
		return $this->matchingRegex;
	}

	public function getMatchesArray() {
		return $this->matchesArray;
	}

	/**
	 * Magic overloading method.
	 *
	 * @method boolean is[...]()
	 * @param string $name
	 * @param array $arguments
	 *
	 * @return mixed
	 * @throws BadMethodCallException when the method doesn't exist and doesn't start with 'is'
	 */
	public function __call( $name, $arguments ) {
		// make sure the name starts with 'is', otherwise
		if ( substr( $name, 0, 2 ) !== 'is' ) {
			throw new BadMethodCallException( "No such method exists: $name" );
		}

		$this->setDetectionType( self::DETECTION_TYPE_MOBILE );

		$key = substr( $name, 2 );

		return $this->matchUAAgainstKey( $key );
	}

	/**
	 * Set the detection type. Must be one of self::DETECTION_TYPE_MOBILE or
	 * self::DETECTION_TYPE_EXTENDED. Otherwise, nothing is set.
	 *
	 * @param string $type The type. Must be a self::DETECTION_TYPE_* constant. The default
	 *                     parameter is null which will default to self::DETECTION_TYPE_MOBILE.
	 *
	 * @deprecated since version 2.6.9
	 *
	 */
	public function setDetectionType( $type = null ) {
		if ( $type === null ) {
			$type = self::DETECTION_TYPE_MOBILE;
		}

		if ( $type !== self::DETECTION_TYPE_MOBILE && $type !== self::DETECTION_TYPE_EXTENDED ) {
			return;
		}

		$this->detectionType = $type;
	}

	/**
	 * Search for a certain key in the rules array.
	 * If the key is found then try to match the corresponding
	 * regex against the User-Agent.
	 *
	 * @param string $key
	 *
	 * @return boolean
	 */
	protected function matchUAAgainstKey( $key ) {
		// Make the keys lowercase so we can match: isIphone(), isiPhone(), isiphone(), etc.
		$key = strtolower( $key );
		if ( false === isset( $this->cache[ $key ] ) ) {

			// change the keys to lower case
			$_rules = array_change_key_case( $this->getRules() );

			if ( false === empty( $_rules[ $key ] ) ) {
				$this->cache[ $key ] = $this->match( $_rules[ $key ] );
			}

			if ( false === isset( $this->cache[ $key ] ) ) {
				$this->cache[ $key ] = false;
			}
		}

		return $this->cache[ $key ];
	}

	/**
	 * Retrieve the current set of rules.
	 *
	 * @return array
	 * @deprecated since version 2.6.9
	 *
	 */
	public function getRules() {
		if ( $this->detectionType == self::DETECTION_TYPE_EXTENDED ) {
			return self::getMobileDetectionRulesExtended();
		} else {
			return self::getMobileDetectionRules();
		}
	}

	/**
	 * Method gets the mobile detection rules + utilities.
	 * The reason this is separate is because utilities rules
	 * don't necessary imply mobile. This method is used inside
	 * the new $detect->is('stuff') method.
	 *
	 * @return array All the rules + extended.
	 * @deprecated since version 2.6.9
	 *
	 */
	public function getMobileDetectionRulesExtended() {
		static $rules;

		if ( ! $rules ) {
			// Merge all rules together.
			$rules = array_merge(
				self::$phoneDevices,
				self::$tabletDevices,
				self::$operatingSystems,
				self::$browsers,
				self::$utilities
			);
		}

		return $rules;
	}

	/**
	 * Method gets the mobile detection rules. This method is used for the magic methods $detect->is*().
	 *
	 * @return array All the rules (but not extended).
	 * @deprecated since version 2.6.9
	 *
	 */
	public static function getMobileDetectionRules() {
		static $rules;

		if ( ! $rules ) {
			$rules = array_merge(
				self::$phoneDevices,
				//self::$tabletDevices,
				self::$operatingSystems,
				self::$browsers
			);
		}

		return $rules;

	}

	/**
	 * Some detection rules are relative (not standard),
	 * because of the diversity of devices, vendors and
	 * their conventions in representing the User-Agent or
	 * the HTTP headers.
	 *
	 * This method will be used to check custom regexes against
	 * the User-Agent string.
	 *
	 * @param $regex
	 * @param string $userAgent
	 *
	 * @return bool
	 *
	 * @todo: search in the HTTP headers too.
	 */
	public function match( $regex, $userAgent = null ) {
		$match = (bool) preg_match( sprintf( '#%s#is', $regex ), ( false === empty( $userAgent ) ? $userAgent : $this->userAgent ), $matches );
		// If positive match is found, store the results for debug.
		if ( $match ) {
			$this->matchingRegex = $regex;
			$this->matchesArray  = $matches;
		}

		return $match;
	}

	/**
	 * Check if the device is mobile.
	 * Returns true if any type of mobile device detected, including special ones
	 *
	 * @param null $userAgent deprecated
	 * @param null $httpHeaders deprecated
	 *
	 * @return bool
	 */
	public function isMobile( $userAgent = null, $httpHeaders = null ) {

		if ( $httpHeaders ) {
			$this->setHttpHeaders( $httpHeaders );
		}

		if ( $userAgent ) {
			$this->setUserAgent( $userAgent );
		}

		// Check specifically for cloudfront headers if the useragent === 'Amazon CloudFront'
		if ( $this->getUserAgent() === 'Amazon CloudFront' ) {
			$cfHeaders = $this->getCfHeaders();
			if ( array_key_exists( 'HTTP_CLOUDFRONT_IS_MOBILE_VIEWER', $cfHeaders ) && $cfHeaders['HTTP_CLOUDFRONT_IS_MOBILE_VIEWER'] === 'true' ) {
				return true;
			}
		}

		$this->setDetectionType( self::DETECTION_TYPE_MOBILE );

		if ( $this->checkHttpHeadersForMobile() ) {
			return true;
		} else {
			return $this->matchDetectionRulesAgainstUA();
		}

	}

	/**
	 * Retrieve the User-Agent.
	 *
	 * @return string|null The user agent if it's set.
	 */
	public function getUserAgent() {
		return $this->userAgent;
	}

	/**
	 * Set the User-Agent to be used.
	 *
	 * @param string $userAgent The user agent string to set.
	 *
	 * @return string|null
	 */
	public function setUserAgent( $userAgent = null ) {
		// Invalidate cache due to #375
		$this->cache = [];

		if ( false === empty( $userAgent ) ) {
			return $this->userAgent = $userAgent;
		} else {
			$this->userAgent = null;
			foreach ( $this->getUaHttpHeaders() as $altHeader ) {
				if ( false === empty( $this->httpHeaders[ $altHeader ] ) ) { // @todo: should use getHttpHeader(), but it would be slow. (Serban)
					$this->userAgent .= $this->httpHeaders[ $altHeader ] . ' ';
				}
			}

			if ( ! empty( $this->userAgent ) ) {
				return $this->userAgent = trim( $this->userAgent );
			}
		}

		if ( count( $this->getCfHeaders() ) > 0 ) {
			return $this->userAgent = 'Amazon CloudFront';
		}

		return $this->userAgent = null;
	}

	/**
	 * Retrieves the cloudfront headers.
	 *
	 * @return array
	 */
	public function getCfHeaders() {
		return $this->cloudfrontHeaders;
	}

	/**
	 * Check the HTTP headers for signs of mobile.
	 * This is the fastest mobile check possible; it's used
	 * inside isMobile() method.
	 *
	 * @return bool
	 */
	public function checkHttpHeadersForMobile() {

		foreach ( $this->getMobileHeaders() as $mobileHeader => $matchType ) {
			if ( isset( $this->httpHeaders[ $mobileHeader ] ) ) {
				if ( is_array( $matchType['matches'] ) ) {
					foreach ( $matchType['matches'] as $_match ) {
						if ( strpos( $this->httpHeaders[ $mobileHeader ], $_match ) !== false ) {
							return true;
						}
					}

					return false;
				} else {
					return true;
				}
			}
		}

		return false;

	}

	public function getMobileHeaders() {
		return self::$mobileHeaders;
	}

	/**
	 * Find a detection rule that matches the current User-agent.
	 *
	 * @param null $userAgent deprecated
	 *
	 * @return boolean
	 */
	protected function matchDetectionRulesAgainstUA( $userAgent = null ) {
		// Begin general search.
		foreach ( $this->getRules() as $_regex ) {
			if ( empty( $_regex ) ) {
				continue;
			}

			if ( $this->match( $_regex, $userAgent ) ) {
				return true;
			}
		}

		return false;
	}

}
