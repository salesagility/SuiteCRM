<?php


function GetLangOpts($llcc, $adobeCJK)
{
    if (strlen($llcc) == 5) {
        $lang = substr(strtolower($llcc), 0, 2);
        $country = substr(strtoupper($llcc), 3, 2);
    } else {
        $lang = strtolower($llcc);
        $country = '';
    }
    $unifonts = "";
    $coreSuitable = false;

    switch ($lang) {
      case "en":
      case "ca":
      case "cy":
      case "da":
      case "de":
      case "es":
      case "eu":
      case "fr":
      case "ga":
      case "fi":
      case "is":
      case "it":
      case "nl":
      case "no":
      case "pt":
      case "sv":
        // Edit this value to define how mPDF behaves when using new mPDF('-x')
        // If set to TRUE, mPDF will use Adobe core fonts only when it recognises the languages above
        $coreSuitable = true;  break;



      // RTL Languages
      case "he":
      case "yi":
        $unifonts = "dejavusans,dejavusansB,dejavusansI,dejavusansBI";  break;

      // Arabic
      case "ar":
        $unifonts = "xbriyaz,xbriyazB,xbriyazI,xbriyazBI,xbzar,xbzarB,xbzarI,xbzarBI";  break;
      case "fa":
        $unifonts = "xbriyaz,xbriyazB,xbriyazI,xbriyazBI,xbzar,xbzarB,xbzarI,xbzarBI";  break;
      case "ps":
        $unifonts = "xbriyaz,xbriyazB,xbriyazI,xbriyazBI,xbzar,xbzarB,xbzarI,xbzarBI"; break;
      case "ur":
        $unifonts = "xbriyaz,xbriyazB,xbriyazI,xbriyazBI,xbzar,xbzarB,xbzarI,xbzarBI"; break;

      // Sindhi (can be Arabic or Devanagari)
      case "sd":
        if ($country == "IN") {
            $unifonts = "ind_hi_1_001";
        }
    //	else if ($country == "PK") { $unifonts = ""; }
    //	else { $unifonts = ""; }
        break;


      // INDIC
      // Assamese
      case "as":  $unifonts = "ind_bn_1_001"; break;
      // Bengali
      case "bn":  $unifonts = "ind_bn_1_001"; break;
      // Gujarati
      case "gu":  $unifonts = "ind_gu_1_001"; break;
      // Hindi (Devanagari)
      case "hi":  $unifonts = "ind_hi_1_001"; break;
      // Kannada
      case "kn":  $unifonts = "ind_kn_1_001"; break;
      // Kashmiri
      case "ks":  $unifonts = "ind_hi_1_001"; break;
      // Malayalam
      case "ml":  $unifonts = "ind_ml_1_001"; break;
      // Nepali (Devanagari)
      case "ne":  $unifonts = "ind_hi_1_001"; break;
      // Oriya
      case "or":  $unifonts = "ind_or_1_001"; break;
      // Punjabi (Gurmukhi)
      case "pa":  $unifonts = "ind_pa_1_001"; break;
      // Tamil
      case "ta":  $unifonts = "ind_ta_1_001"; break;
      // Telegu
      case "te":  $unifonts = "ind_te_1_001"; break;

      // THAI
      case "th":  $unifonts = "garuda,garudaB,garudaI,garudaBI,norasi,norasiB,norasiI,norasiBI";  break;

      // VIETNAMESE
      case "vi":
        $unifonts = "dejavusanscondensed,dejavusanscondensedB,dejavusanscondensedI,dejavusanscondensedBI,dejavusans,dejavusansB,dejavusansI,dejavusansBI"; break;

      // CJK Langauges
      case "ja":
        if ($adobeCJK) {
            $unifonts = "sjis,sjisB,sjisI,sjisBI";
        }
/* Uncomment these lines if CJK fonts available */
//		else {
//			$unifonts = "sun-exta,sun-extb,hannoma,hannomb";
//		}
        break;

      case "ko":
        if ($adobeCJK) {
            $unifonts = "uhc,uhcB,uhcI,uhcBI";
        }
/* Uncomment these lines if CJK fonts available */
//		else {
//			$unifonts = "unbatang_0613";
//		}
        break;

      case "zh":
        if ($country == "HK" || $country == "TW") {
            if ($adobeCJK) {
                $unifonts = "big5,big5B,big5I,big5BI";
            }
            /* Uncomment these lines if CJK fonts available */
//			else {
//				$unifonts = "sun-exta,sun-extb,hannoma,hannomb";
//			}
        } elseif ($country == "CN") {
            if ($adobeCJK) {
                $unifonts = "gb,gbB,gbI,gbBI";
            }
            /* Uncomment these lines if CJK fonts available */
//			else {
//				$unifonts = "sun-exta,sun-extb,hannoma,hannomb";
//			}
        } else {
            if ($adobeCJK) {
                $unifonts = "gb,gbB,gbI,gbBI";
            }
            /* Uncomment these lines if CJK fonts available */
//			else {
//				$unifonts = "sun-exta,sun-extb,hannoma,hannomb";
//			}
        }
        break;

    }


    $unifonts_arr = array();
    if ($unifonts) {
        $unifonts_arr = preg_split('/\s*,\s*/', $unifonts);
    }
    return array($coreSuitable ,$unifonts_arr);
}
