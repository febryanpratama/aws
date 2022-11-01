<?php

use App\Models\File;
use App\Models\FileOrder;
use App\Models\FileOrderDocument;
use App\Models\FileOrderReceiver;
use App\Models\LoginActivity;
use App\Models\User;

function getFirstName($name)
{
    $explode_space = explode(" ", $name);
    return $explode_space[0];
}
function dateTimesheet($date)
{
    $explode_minus = explode('-', $date);
    $year = substr($explode_minus[0], 2, 2);
    $month = getMonthCode($explode_minus[1]);
    return $explode_minus[2] . '-' . $month . '-' . $year;
}
function getName($id)
{
    $user = User::findOrFail($id);
    return $user->name;
}
function getEsign($id)
{
    $user = User::findOrFail($id);
    return $user->esign;
}
function getJobTitle($id)
{
    $user = User::findOrFail($id);
    return $user->job_title;
}
function getSize($size)
{
    $size_in_kb = ceil($size / 1000);
    $size_in_mb = $size / 1048576;

    $real_size = $size_in_kb;
    $real_size_type = "KB";

    if ($size_in_mb >= 0.1) {
        $real_size = $size_in_mb;
        $real_size_type = "MB";
    }

    // $real_size = strlen(substr(strrchr($real_size, "."), 1));

    return "$real_size $real_size_type";
}
function getFileOrderDocuments($id)
{
    $fileOrderDocuments = FileOrderDocument::select('*', 'file_order_documents.id as fileorderdocument_id')
        ->join("files", "file_order_documents.file_id", "files.id")
        ->join("users", "files.sender_id", "users.id")
        ->where("fileorder_id", $id)->get();
    return $fileOrderDocuments;
}
function getFileOrderReceivers($id)
{
    $fileOrderReceivers = FileOrderReceiver::where("fileorder_id", $id)->get();
    return $fileOrderReceivers;
}
function getStatusIcon($status)
{
    switch ($status) {
        case "placed":
            return "file";
            break;
        case "process":
            return "clock";
            break;
        case "canceled":
            return "times";
            break;
        case "completed":
            return "check";
            break;
    }
}
function getStatusBackground($status)
{
    switch ($status) {
        case "placed":
            return "bg-c-red";
            break;
        case "process":
            return "bg-c-blue";
            break;
        case "canceled":
            return "bg-dark";
            break;
        case "completed":
            return "bg-c-green";
            break;
    }
}
function getStatusColor($status)
{
    switch ($status) {
        case "placed":
            return "danger";
            break;
        case "process":
            return "primary";
            break;
        case "canceled":
            return "dark";
            break;
        case "completed":
            return "success";
            break;
    }
}
function workingDays($id)
{
    $activites = LoginActivity::where("user_id", $id)->where("type", "in")->count();
    return $activites;
}

function myFiles($id)
{
    $files = File::where("sender_id", $id)->count();
    return $files;
}

function cuaca($wil)
{
    switch ($wil) {
        case "aceh":
        case "banda aceh":
        case "bandaaceh":
            $url = "?Prov=01&NamaProv=Aceh";
            break;
        case "bali":
            $url = "?Prov=02&NamaProv=Bali";
            break;
        case "bangka belitung":
        case "babel":
            $url = "?Prov=03&NamaProv=Bangka%20Belitung";
            break;
        case "banten":
            $url = "?Prov=04&NamaProv=Banten";
            break;
        case "bengkulu":
            $url = "?Prov=05&NamaProv=Bengkulu";
            break;
        case "di yogyakarta":
        case "diy yogyakarta":
        case "diy jogyakarta":
        case "jogyakarta":
        case "diy":
            $url = "?Prov=06&NamaProv=DI%20Yogyakarta";
            break;
        case "dki jakarta":
        case "jakarta":
            $url = "?Prov=07&NamaProv=DKI%20Jakarta";
            break;
        case "gorontalo":
            $url = "?Prov=08&NamaProv=Gorontalo";
            break;
        case "jambi":
            $url = "?Prov=09&NamaProv=Jambi";
            break;
        case "jawa barat":
        case "jabar":
            $url = "?Prov=10&NamaProv=Jawa%20Barat";
            break;
        case "jawa tengah":
        case "jateng":
            $url = "?Prov=11&NamaProv=Jawa%20Tengah";
            break;
        case "jawa timur":
        case "jatim":
            $url = "?Prov=12&NamaProv=Jawa%20Timur";
            break;
        case "kalimantan barat":
        case "kalbar":
            $url = "?Prov=13&NamaProv=Kalimantan%20Barat";
            break;
        case "kalimantan selatan":
        case "kalsel":
            $url = "?Prov=14&NamaProv=Kalimantan%20Selatan";
            break;
        case "kalimantan tengah":
        case "kalteng":
            $url = "?Prov=15&NamaProv=Kalimantan%20Tengah";
            break;
        case "kalimantan timur":
        case "kaltim":
            $url = "?Prov=16&NamaProv=Kalimantan%20Timur";
            break;
        case "kalimantan utara":
        case "kalut":
            $url = "?Prov=17&NamaProv=Kalimantan%20Utara";
            break;
        case "kepulauan riau":
        case "kepri":
            $url = "?Prov=18&NamaProv=Kepulauan%20Riau";
            break;
        case "lampung":
        case "bandar lampung":
        case "bandarlampung":
            $url = "?Prov=19&NamaProv=Lampung";
            break;
        case "maluku":
        case "ambon":
            $url = "?Prov=20&NamaProv=Maluku";
            break;
        case "maluku utara":
        case "malut":
        case "ternate":
            $url = "?Prov=21&NamaProv=Maluku%20Utara";
            break;
        case "nusa tenggara barat":
        case "ntb":
            $url = "?Prov=22&NamaProv=Nusa%20Tenggara%20Barat";
            break;
        case "nusa tenggara timur":
        case "ntt":
            $url = "?Prov=23&NamaProv=Nusa%20Tenggara%20Timur";
            break;
        case "papua":
        case "jayapura":
            $url = "?Prov=24&NamaProv=Papua";
            break;
        case "papua barat":
            $url = "?Prov=25&NamaProv=Papua%20Barat";
            break;
        case "riau":
            $url = "?Prov=26&NamaProv=Riau";
            break;
        case "sulawesi barat":
        case "sulbar":
            $url = "?Prov=27&NamaProv=Sulawesi%20Barat";
            break;
        case "sulawesi selatan":
        case "sulsel":
            $url = "?Prov=28&NamaProv=Sulawesi%20Selatan";
            break;
        case "sulawesi tengah":
        case "sulteng":
            $url = "?Prov=29&NamaProv=Sulawesi%20Tengah";
            break;
        case "sulawesi tenggara":
        case "sultra":
            $url = "?Prov=30&NamaProv=Sulawesi%20Tenggara";
            break;
        case "sulawesi utara":
        case "sulut":
            $url = "?Prov=31&NamaProv=Sulawesi%20Utara";
            break;
        case "sumatra barat":
        case "sumatera barat":
        case "sumbar":
            $url = "?Prov=32&NamaProv=Sumatera%20Barat";
            break;
        case "sumatra selatan":
        case "sumatera selatan":
        case "sumsel":
            $url = "?Prov=33&NamaProv=Sumatera%20Selatan";
            break;
        case "sumatra utara":
        case "sumatera utara":
        case "sumut":
            $url = "?Prov=34&NamaProv=Sumatera%20Utara";
            break;
        case "indonesia":
            $url = "?Prov=35&NamaProv=Indonesia";
            break;
        case "list":
            $lst = json_encode(array(
                "Aceh,Bali,Bangka Belitung,Banten,Bengkulu,DI Yogyakarta,DKI Jakarta,Gorontalo,Jambi,Jawa Barat,Jawa Tengah,Jawa Timur,Kalimantan Barat,Kalimantan Selatan,Kalimantan Tengah,Kalimantan Timur,Kalimantan Utara,Kepulauan Riau,Lampung,Maluku,Maluku Utara,Nusa Tenggara Barat,Nusa Tenggara Timur,Papua,Papua Barat,Riau,Sulawesi Barat,Sulawesi Selatan,Sulawesi Tengah,Sulawesi Tenggara,Sulawesi Utara,Sumatera Barat,Sumatera Selatan,Sumatera Utara,Indonesia"
            ));
            return $lst;
            die();
        default:
            $err = json_encode(array("error provinsi not found!"));
            return $err;
            die();
    }

    $html = "http://www.bmkg.go.id/cuaca/prakiraan-cuaca-indonesia.bmkg" . $url;
    $tempat = "";
    $prdom = new DOMDocument;
    libxml_use_internal_errors(true);
    $prdom->loadHTMLFile($html);
    libxml_use_internal_errors(false);
    $xpath = new DOMXPath($prdom);
    $tbp = 1;
    $idTab = '//div[@id="TabPaneCuaca' . $tbp . '"]';
    $divTag = $xpath->query($idTab);
    if ($divTag->length == 0) {
        for ($z = 2; $z <= 3; $z++) {
            $idTab = '//div[@id="TabPaneCuaca' . $z . '"]';
            $divTag = $xpath->query($idTab);
            if ($divTag->length == 0) {
                break;
            }
        }
    }

    foreach ($divTag as $val) {
        $tempat .= $prdom->saveXML($val);
    }

    $internalErrors = libxml_use_internal_errors(true);
    $DOM = new DOMDocument();
    $DOM->loadHTML($tempat);
    $xpath = new DOMXPath($DOM);

    $Header = $DOM->getElementsByTagName('th');
    $Detail = $DOM->getElementsByTagName('td');
    //struktur table
    $head1 =  array("Kota", "Pagi", "Siang", "Malam", "Dini Hari", "Suhu", "Kelembaban");
    $head2 =  array("Kota", "Siang", "Malam", "Dini Hari", "Suhu", "Kelembaban");
    $head3 =  array("Kota", "Malam", "Dini Hari", "Suhu", "Kelembaban");
    $head4 =  array("Kota", "Dini Hari", "Suhu", "Kelembaban");
    libxml_use_internal_errors($internalErrors);

    foreach ($Header as $NodeHeader) {
        $aDataTableHeaderHTML[] = trim($NodeHeader->textContent);
    }
    @$jmlHeader = count($aDataTableHeaderHTML);
    switch ($jmlHeader) {
        case 8:                    //klo full pagi sampe larut dan 3 hari
            $head = $head1;
            break;
        case 7:                    //klo - pagi dan 1 hari
            $head = $head2;
            break;
        case 6:                    //klo - pagi siang dan 1 hari
            //echo "Your favorite color is " . $jmlHeader;
            $head = $head3;
            break;
        case 5:                    //klo dini hari doang dan 1 hari
            $head = $head4;
            break;
        default:
            $err = json_encode(array("error data not found!"));
            print($err);
            die();
    }
    $i = 0;
    $j = 0;
    foreach ($Detail as $sNodeDetail) {
        $aDataTableDetailHTML[$j][] = trim($sNodeDetail->textContent);
        $i = $i + 1;
        $j = $i % count($head) == 0 ? $j + 1 : $j;
    }
    for ($i = 0; $i < count($aDataTableDetailHTML); $i++) {
        for ($j = 0; $j < count($head); $j++) {
            $aTempData[$i][$head[$j]] = $aDataTableDetailHTML[$i][$j];
        }
    }
    $aDataTableDetailHTML = $aTempData;
    unset($aTempData);
    // $js = json_encode($aDataTableDetailHTML);
    // return $js;
    return $aDataTableDetailHTML;
    // die();
}



function encodeImg($url)
{
    $imageData = base64_encode(file_get_contents($url));
    $src = 'data:image/jpeg;base64,' . $imageData;
    return $src;
}

function calculateDays($date_start, $date_end)
{
    $now = strtotime($date_end);
    $your_date = strtotime($date_start);
    $datediff = $now - $your_date;

    return round($datediff / (60 * 60 * 24));
}

function number_of_working_days($from, $to)
{
    $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
    $holidayDays = ['*-12-25', '*-01-01', '2013-12-23']; # variable and fixed holidays

    $from = new DateTime($from);
    $to = new DateTime($to);
    $to->modify('+1 day');
    $interval = new DateInterval('P1D');
    $periods = new DatePeriod($from, $interval, $to);

    $days = 0;
    foreach ($periods as $period) {
        if (!in_array($period->format('N'), $workingDays)) continue;
        if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
        $days++;
    }
    return $days;
}

function getMonthCode($month)
{
    switch ($month) {
        case '1':
            return "Jan";
            break;
        case '2':
            return "Feb";
            break;
        case '3':
            return "Mar";
            break;
        case '4':
            return "Apr";
            break;
        case '5':
            return "May";
            break;
        case '6':
            return "Jun";
            break;
        case '7':
            return "Jul";
            break;
        case '8':
            return "Aug";
            break;
        case '9':
            return "Sep";
            break;
        case '10':
            return "Oct";
            break;
        case '11':
            return "Nov";
            break;
        case '12':
            return "Des";
            break;
        default:
            return "Err";
            break;
    }
}
function getFullMonthCode($month)
{
    switch ($month) {
        case '1':
            return "January";
            break;
        case '2':
            return "February";
            break;
        case '3':
            return "March";
            break;
        case '4':
            return "April";
            break;
        case '5':
            return "May";
            break;
        case '6':
            return "June";
            break;
        case '7':
            return "July";
            break;
        case '8':
            return "August";
            break;
        case '9':
            return "September";
            break;
        case '10':
            return "October";
            break;
        case '11':
            return "November";
            break;
        case '12':
            return "Decemeber";
            break;
        default:
            return "Error";
            break;
    }
}

function indonesianDate($date)
{
    if ($date !== '') {
        $str = "";
        $delim_space = explode(" ", $date);
        $delim_minus = explode("-", $delim_space[0]);
        switch ($delim_minus[1]) {
            case '1':
                $bulan = "Januari";
                break;
            case '2':
                $bulan = "Februari";
                break;
            case '3':
                $bulan = "Maret";
                break;
            case '4':
                $bulan = "April";
                break;
            case '5':
                $bulan = "Mei";
                break;
            case '6':
                $bulan = "Juni";
                break;
            case '7':
                $bulan = "Juli";
                break;
            case '8':
                $bulan = "Agustus";
                break;
            case '9':
                $bulan = "September";
                break;
            case '10':
                $bulan = "Oktober";
                break;
            case '11':
                $bulan = "November";
                break;
            case '12':
                $bulan = "Desember";
                break;
            default:
                $bulan = "Januari";
                break;
        }
        $str .= $delim_minus[2] . " " . $bulan . " " . $delim_minus[0];
        if (isset($delim_space[1])) {
            $delim_double_dot = explode(":", $delim_space[1]);
            $str .= ", " . $delim_double_dot[0] . "." . $delim_double_dot[1];
        }
        return $str;
    } else {
        return "";
    }
}
function translateLineBreaks($string)
{
    $result = nl2br($string);

    // dd($result);
    return $result;
}
