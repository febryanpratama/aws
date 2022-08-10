<?php

namespace App\Http\Controllers;

use App\Models\LoginActivity;
use Illuminate\Http\Request;
use Auth;
use Instagram\Api;
use Instagram\Auth\Checkpoint\ImapClient;
use Instagram\Exception\InstagramException;
use Psr\Cache\CacheException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use App\Models\Notification;
use App\Models\Permission;

class ApiController extends Controller
{
    //
	public function chart_attendance($user_id, $month, $year){
		// $month = 03;
		$xmonth = (strlen($month) == 1) ? "0".$month : $month;

		$total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

		$date_start = "$year-$xmonth-01";
		$date_end = "$year-$xmonth-$total_days";

		$data[] = LoginActivity::where("user_id", $user_id)
								->where("type", "in")
								->whereBetween("just_date_in", [$date_start, $date_end])
								->count();

		$data[] = Permission::where("user_id", $user_id)
							->where("status", "accepted")
							->whereBetween("date_permission", [$date_start, $date_end])
							->count();

		$fetch = file_get_contents("https://api-harilibur.vercel.app/api?month=$month&year=$year");
		$array = json_decode($fetch);
		$hari_libur = count($array);

		$data[] = (number_of_working_days($date_start, $date_end) - $hari_libur) - array_sum($data);

		return $data;	
	}
	public function chart_discipline($user_id, $month, $year){
		// $month = 03;
		$xmonth = (strlen($month) == 1) ? "0".$month : $month;
		$total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);


		$date_start = "$year-$xmonth-01";
		$date_end = "$year-$xmonth-$total_days";

		$attendance = LoginActivity::where("user_id", $user_id)
								->where("type", "in")
								->whereBetween("just_date_in", [$date_start, $date_end])
								->get();
		$total_late = 0;
		$total_hours = 0;

		foreach ($attendance as $key => $value) {
			$total_hours += 8;

			$patokan = $value->just_date_in." 08:30:00";
			$calculated = (strtotime($patokan) - strtotime($value->created_at));
			if($calculated < 0){
				$total_late++;
			}
		}

		$data[] = $total_late;
		$data[] = $total_hours;

		// return $attendance;

		// $data[] = Permission::where("user_id", $user_id)
		// 					->where("status", "accepted")
		// 					->whereBetween("date_permission", [$date_start, $date_end])
		// 					->count();

		// $data[] = number_of_working_days($date_start, $date_end) - array_sum($data);

		return $data;	
	}
	public function notificationsRead($id){
		if(!is_numeric($id)){
			return ["data" => []];	
		}
		$notifications = Notification::where("to_id", $id)->get();
		foreach($notifications as $key => $notification){
			$notification->is_read = "yes";
			$notification->save();
		}
		return ["data" => ["status" => "200"]];
	}
	public function notifications($id){
		if(!is_numeric($id)){
			return ["data" => []];	
		}
		$notifications = Notification::where("to_id", $id)
						->join('users', 'notifications.from_id', 'users.id')
						->orderBy('notifications.id', 'DESC')
						->get();
		foreach($notifications as $key => $notification){
			$name = $notification->name;
			$explode = explode(' ', $name);
			$notification->name = $explode[0];
			$notification->makeHidden(['password']);
			$notification->datetime = indonesianDate($notification->created_at);
		}
		return ["data"=>$notifications];
	}
    public function instagramFeeds($username){
        $cachePool = new FilesystemAdapter('Instagram', 0, __DIR__ . '/../cache');

        // return __DIR__ . '/../cache';
        
        $api = new Api($cachePool);
        $api->login('psyda.id', 'alfan007');
        $profile = $api->getProfile($username);
        $medias = $profile->getMedias();
        foreach ($medias as $key => $media) {
            $data["data"]["medias"][$key]['thumbnail'] = encodeImg($media->getthumbnailSrc());
            $data["data"]["medias"][$key]['url'] = $media->getLink();
        }
        // dd($medias);
        return $data;
        // return $profile->getId();
    }
    public function weather(){
        $data["data"]["weather"] = cuaca("dki jakarta");
        return $data;
    }
}
