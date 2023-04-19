<?php

namespace App\Helpers;

use Stevebauman\Location\Facades\Location;

class UserSystemInfoHelper
{


    public $countries = [
        'en' => [
            "AF" => "Afghanistan",
            "AX" => "Aland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BQ" => "Bonaire, Sint Eustatius and Saba",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, the Democratic Republic of the",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Cote D'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CW" => "Curacao",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and Mcdonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "XK" => "Kosovo",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libyan Arab Jamahiriya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, the Former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Reunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "BL" => "Saint Barthelemy",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SX" => "Sint Maarten",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "SS" => "South Sudan",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.s.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe"
        ],
        'ar' => [
            "AF" => "أفغانستان",
            "AX" => "جزر آلاند",
            "AL" => "ألبانيا",
            "DZ" => "الجزائر",
            "AS" => "ساموا الأمريكية",
            "AD" => "أندورا",
            "AO" => "أنغولا",
            "AI" => "أنغيلا",
            "AQ" => "أنتاركتيكا",
            "AG" => "أنتيغوا وبربودا",
            "AR" => "الأرجنتين",
            "AM" => "أرمينيا",
            "AW" => "أروبا",
            "AU" => "أستراليا",
            "AT" => "النمسا",
            "AZ" => "أذربيجان",
            "BS" => "جزر البهاما",
            "BH" => "البحرين",
            "BD" => "بنغلاديش",
            "BB" => "بربادوس",
            "BY" => "بيلاروسيا",
            "BE" => "بلجيكا",
            "BZ" => "بليز",
            "BJ" => "بنين",
            "BM" => "برمودا",
            "BT" => "بوتان",
            "BO" => "بوليفيا",
            "BQ" => "بونير وسانت يوستاتيوس وسابا",
            "BA" => "البوسنة والهرسك",
            "BW" => "بوتسوانا",
            "BV" => "جزيرة بوفيت",
            "BR" => "البرازيل",
            "IO" => "إقليم المحيط البريطاني الهندي",
            "BN" => "بروناي دار السلام",
            "BG" => "بلغاريا",
            "BF" => "بوركينا فاسو",
            "BI" => "بوروندي",
            "KH" => "كمبوديا",
            "CM" => "الكاميرون",
            "CA" => "كندا",
            "CV" => "الرأس الأخضر",
            "KY" => "جزر كايمان",
            "CF" => "جمهورية افريقيا الوسطى",
            "TD" => "تشاد",
            "CL" => "تشيلي",
            "CN" => "الصين",
            "CX" => "جزيرة الكريسماس",
            "CC" => "جزر كوكوس (كيلينغ)",
            "CO" => "كولومبيا",
            "KM" => "جزر القمر",
            "CG" => "الكونغو",
            "CD" => "الكونغو ، جمهورية الكونغو الديمقراطية",
            "CK" => "جزر كوك",
            "CR" => "كوستا ريكا",
            "CI" => "ساحل العاج",
            "HR" => "كرواتيا",
            "CU" => "كوبا",
            "CW" => "كوراكاو",
            "CY" => "قبرص",
            "CZ" => "الجمهورية التشيكية",
            "DK" => "الدنمارك",
            "DJ" => "جيبوتي",
            "DM" => "دومينيكا",
            "DO" => "جمهورية الدومنيكان",
            "EC" => "الاكوادور",
            "EG" => "مصر",
            "SV" => "السلفادور",
            "GQ" => "غينيا الإستوائية",
            "ER" => "إريتريا",
            "EE" => "إستونيا",
            "ET" => "أثيوبيا",
            "FK" => "جزر فوكلاند (مالفيناس)",
            "FO" => "جزر فاروس",
            "FJ" => "فيجي",
            "FI" => "فنلندا",
            "FR" => "فرنسا",
            "GF" => "غيانا الفرنسية",
            "PF" => "بولينيزيا الفرنسية",
            "TF" => "المناطق الجنوبية لفرنسا",
            "GA" => "الجابون",
            "GM" => "غامبيا",
            "GE" => "جورجيا",
            "DE" => "ألمانيا",
            "GH" => "غانا",
            "GI" => "جبل طارق",
            "GR" => "اليونان",
            "GL" => "الأرض الخضراء",
            "GD" => "غرينادا",
            "GP" => "جوادلوب",
            "GU" => "غوام",
            "GT" => "غواتيمالا",
            "GG" => "غيرنسي",
            "GN" => "غينيا",
            "GW" => "غينيا بيساو",
            "GY" => "غيانا",
            "HT" => "هايتي",
            "HM" => "قلب الجزيرة وجزر ماكدونالز",
            "VA" => "الكرسي الرسولي (دولة الفاتيكان)",
            "HN" => "هندوراس",
            "HK" => "هونج كونج",
            "HU" => "هنغاريا",
            "IS" => "أيسلندا",
            "IN" => "الهند",
            "ID" => "إندونيسيا",
            "IR" => "جمهورية إيران الإسلامية",
            "IQ" => "العراق",
            "IE" => "أيرلندا",
            "IM" => "جزيرة آيل أوف مان",
            "IL" => "إسرائيل",
            "IT" => "إيطاليا",
            "JM" => "جامايكا",
            "JP" => "اليابان",
            "JE" => "جيرسي",
            "JO" => "الأردن",
            "KZ" => "كازاخستان",
            "KE" => "كينيا",
            "KI" => "كيريباتي",
            "KP" => "كوريا، الجمهورية الشعبية الديمقراطية",
            "KR" => "جمهورية كوريا",
            "XK" => "كوسوفو",
            "KW" => "الكويت",
            "KG" => "قيرغيزستان",
            "LA" => "جمهورية لاو الديمقراطية الشعبية",
            "LV" => "لاتفيا",
            "LB" => "لبنان",
            "LS" => "ليسوتو",
            "LR" => "ليبيريا",
            "LY" => "الجماهيرية العربية الليبية",
            "LI" => "ليختنشتاين",
            "LT" => "ليتوانيا",
            "LU" => "لوكسمبورغ",
            "MO" => "ماكاو",
            "MK" => "مقدونيا ، جمهورية يوغوسلافيا السابقة",
            "MG" => "مدغشقر",
            "MW" => "ملاوي",
            "MY" => "ماليزيا",
            "MV" => "جزر المالديف",
            "ML" => "مالي",
            "MT" => "مالطا",
            "MH" => "جزر مارشال",
            "MQ" => "مارتينيك",
            "MR" => "موريتانيا",
            "MU" => "موريشيوس",
            "YT" => "مايوت",
            "MX" => "المكسيك",
            "FM" => "ولايات ميكرونيزيا الموحدة",
            "MD" => "جمهورية مولدوفا",
            "MC" => "موناكو",
            "MN" => "منغوليا",
            "ME" => "الجبل الأسود",
            "MS" => "مونتسيرات",
            "MA" => "المغرب",
            "MZ" => "موزمبيق",
            "MM" => "ميانمار",
            "NA" => "ناميبيا",
            "NR" => "ناورو",
            "NP" => "نيبال",
            "NL" => "هولندا",
            "AN" => "جزر الأنتيل الهولندية",
            "NC" => "كاليدونيا الجديدة",
            "NZ" => "نيوزيلاندا",
            "NI" => "نيكاراغوا",
            "NE" => "النيجر",
            "NG" => "نيجيريا",
            "NU" => "نيوي",
            "NF" => "جزيرة نورفولك",
            "MP" => "جزر مريانا الشمالية",
            "NO" => "النرويج",
            "OM" => "سلطنة عمان",
            "PK" => "باكستان",
            "PW" => "بالاو",
            "PS" => "الأراضي الفلسطينية المحتلة",
            "PA" => "بنما",
            "PG" => "بابوا غينيا الجديدة",
            "PY" => "باراغواي",
            "PE" => "بيرو",
            "PH" => "فيلبيني",
            "PN" => "بيتكيرن",
            "PL" => "بولندا",
            "PT" => "البرتغال",
            "PR" => "بورتوريكو",
            "QA" => "دولة قطر",
            "RE" => "جمع شمل",
            "RO" => "رومانيا",
            "RU" => "الاتحاد الروسي",
            "RW" => "رواندا",
            "BL" => "سانت بارتيليمي",
            "SH" => "سانت هيلانة",
            "KN" => "سانت كيتس ونيفيس",
            "LC" => "القديسة لوسيا",
            "MF" => "القديس مارتن",
            "PM" => "سانت بيير وميكلون",
            "VC" => "سانت فنسنت وجزر غرينادين",
            "WS" => "ساموا",
            "SM" => "سان مارينو",
            "ST" => "ساو تومي وبرينسيبي",
            "SA" => "المملكة العربية السعودية",
            "SN" => "السنغال",
            "RS" => "صربيا",
            "CS" => "صربيا والجبل الأسود",
            "SC" => "سيشيل",
            "SL" => "سيرا ليون",
            "SG" => "سنغافورة",
            "SX" => "سينت مارتن",
            "SK" => "سلوفاكيا",
            "SI" => "سلوفينيا",
            "SB" => "جزر سليمان",
            "SO" => "الصومال",
            "ZA" => "جنوب أفريقيا",
            "GS" => "جورجيا الجنوبية وجزر ساندويتش الجنوبية",
            "SS" => "جنوب السودان",
            "ES" => "إسبانيا",
            "LK" => "سيريلانكا",
            "SD" => "السودان",
            "SR" => "سورينام",
            "SJ" => "سفالبارد وجان ماين",
            "SZ" => "سوازيلاند",
            "SE" => "السويد",
            "CH" => "سويسرا",
            "SY" => "الجمهورية العربية السورية",
            "TW" => "مقاطعة تايوان الصينية",
            "TJ" => "طاجيكستان",
            "TZ" => "جمهورية تنزانيا المتحدة",
            "TH" => "تايلاند",
            "TL" => "تيمور ليشتي",
            "TG" => "توجو",
            "TK" => "توكيلاو",
            "TO" => "تونغا",
            "TT" => "ترينداد وتوباغو",
            "TN" => "تونس",
            "TR" => "ديك رومى",
            "TM" => "تركمانستان",
            "TC" => "جزر تركس وكايكوس",
            "TV" => "توفالو",
            "UG" => "أوغندا",
            "UA" => "أوكرانيا",
            "AE" => "الإمارات العربية المتحدة",
            "GB" => "المملكة المتحدة",
            "US" => "الولايات المتحدة",
            "UM" => "جزر الولايات المتحدة البعيدة الصغرى",
            "UY" => "أوروغواي",
            "UZ" => "أوزبكستان",
            "VU" => "فانواتو",
            "VE" => "فنزويلا",
            "VN" => "فييت نام",
            "VG" => "جزر العذراء البريطانية",
            "VI" => "جزر فيرجن ، الولايات المتحدة",
            "WF" => "واليس وفوتونا",
            "EH" => "الصحراء الغربية",
            "YE" => "اليمن",
            "ZM" => "زامبيا",
            "ZW" => "زيمبابوي"
        ],
    ];

    public function get_country_from_ip($ip)
    {
        try {
            $location = Location::get($ip);
            $country = $this->countries['ar'][$location->countryCode];
            return [
                'country' => $country,
                'country_code' => $location->countryCode
            ];
        } catch (\Exception $e) {
        }

        return [
            'country' => "غير محدد",
            'country_code' => "404"
        ];
    }


    public static function get_user_agent()
    {
        return request()->header('User-Agent');
    }

    public static function get_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $ipaddress = $_SERVER["HTTP_CF_CONNECTING_IP"];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            } else {
                if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                    $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
                } else {
                    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    } else {
                        if (isset($_SERVER['HTTP_X_FORWARDED'])) {
                            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
                        } else {
                            if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
                            } else {
                                if (isset($_SERVER['HTTP_FORWARDED'])) {
                                    $ipaddress = $_SERVER['HTTP_FORWARDED'];
                                } else {
                                    if (isset($_SERVER['REMOTE_ADDR'])) {
                                        $ipaddress = $_SERVER['REMOTE_ADDR'];
                                    } else {
                                        if (request()->ip() != null) {
                                            $ipaddress = request()->ip();
                                        } else {
                                            $ipaddress = 'UNKNOWN';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $ipaddress;
    }


    public static function get_os()
    {
        $user_agent = self::get_user_agent();
        $os_platform = "Unknown OS Platform";
        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile',
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }

    public static function get_browsers()
    {
        $user_agent = self::get_user_agent();

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/Trident/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/knoqueror/i' => 'Konqueror',
            '/ubrowser/i' => 'UC Browser',
            '/mobile/i' => 'Safari Browser',
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }
        return $browser;
    }

    public static function get_device()
    {
        $tablet_browser = 0;
        $mobile_browser = 0;

        if (preg_match(
            '/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i',
            strtolower(request()->header('User-Agent'))
        )) {
            $tablet_browser++;
        }

        if (preg_match(
            '/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i',
            strtolower(request()->header('User-Agent'))
        )) {
            $mobile_browser++;
        }

        if ((isset($_SERVER['HTTP_ACCEPT']) && strpos(
                    strtolower($_SERVER['HTTP_ACCEPT']),
                    'application/vnd.wap.xhtml+xml'
                ) > 0) or
            ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or
                isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr(self::get_user_agent(), 0, 4));
        $mobile_agents = array(
            'w3c',
            'acs-',
            'alav',
            'alca',
            'amoi',
            'audi',
            'avan',
            'benq',
            'bird',
            'blac',
            'blaz',
            'brew',
            'cell',
            'cldc',
            'cmd-',
            'dang',
            'doco',
            'eric',
            'hipt',
            'inno',
            'ipaq',
            'java',
            'jigs',
            'kddi',
            'keji',
            'leno',
            'lg-c',
            'lg-d',
            'lg-g',
            'lge-',
            'maui',
            'maxo',
            'midp',
            'mits',
            'mmef',
            'mobi',
            'mot-',
            'moto',
            'mwbp',
            'nec-',

            'newt',
            'noki',
            'palm',
            'pana',
            'pant',
            'phil',
            'play',
            'port',
            'prox',
            'qwap',
            'sage',
            'sams',
            'sany',
            'sch-',
            'sec-',
            'send',
            'seri',
            'sgh-',
            'shar',

            'sie-',
            'siem',
            'smal',
            'smar',
            'sony',
            'sph-',
            'symb',
            't-mo',
            'teli',
            'tim-',
            'tosh',
            'tsm-',
            'upg1',
            'upsi',
            'vk-v',
            'voda',
            'wap-',
            'wapa',
            'wapi',
            'wapp',
            'wapr',
            'webc',
            'winw',
            'winw',
            'xda',
            'xda-'
        );

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower(self::get_user_agent()), 'opera mini') > 0) {
            $mobile_browser++;

            //Check for tables on opera mini alternative headers

            $stock_ua =
                strtolower(
                    isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ?
                        $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] :
                        (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ?
                            $_SERVER['HTTP_DEVICE_STOCK_UA'] : '')
                );

            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }

        if ($tablet_browser > 0) {
            //do something for tablet devices

            return 'Tablet';
        } else {
            if ($mobile_browser > 0) {
                //do something for mobile devices

                return 'Mobile';
            } else {
                //do something for everything else
                return 'Computer';
            }
        }
    }

    public static function prev_url()
    {
        $prev_url = "";
        if (filter_var(url()->previous(), FILTER_VALIDATE_URL)) // is a valid url
        {
            $parsex = parse_url(url()->previous());
            $prev_domain = $parsex['host'];
            try {
                $prev_url = url()->previous();
            } catch (\Exception $e) {
            }
        }
        return $prev_url;
    }
}
