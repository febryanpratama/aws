<?php

namespace App\Http\Controllers;

use App\Models\LoginActivity;
use Illuminate\Http\Request;
use PDO;
use Auth;
use Agent;
use App\Models\File;
use App\Models\Notification as Notification;
use App\Models\FileOrder;
use App\Models\FileOrderDocument;
use App\Models\FileOrderReceiver;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Instagram\Api;
use Instagram\Auth\Checkpoint\ImapClient;
use Instagram\Exception\InstagramException;
use Psr\Cache\CacheException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function settings()
    {
        return view("pages.settings");
    }
    public function settingsPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string", "min:5"],
            "email" => ["required", "email", "min:7"],
            "job_title" => ["required", "string", "min:5"],
            "bio" => ["required", "string", "min:5"],
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();

            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Failed..",
                "modal_message" => $message,
                "modal_type" => "error",
            ];
            return Redirect::back()->with($modal);
        }

        $user = User::findOrFail(Auth::user()->id);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $size = $file->getSize();
            $to_file = 'assets/images/user';
            $name_file = rand(11111, 99999) . " - " . $file->getClientOriginalName();
            $file->move($to_file, $name_file);
            $user->avatar = $name_file;
        }

        if ($request->password !== null) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->job_title = $request->job_title;
        $user->bio = $request->bio;

        $user->save();


        $modal = [
            "modal" => "yes",
            "modal_title" => "Yay! Sucess",
            "modal_message" => "You are successfully change your profile!",
            "modal_type" => "success",
        ];

        return Redirect::back()->with($modal);
    }

    public function esignPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "esign" => ["required", "mimes:jpeg,png"],
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();

            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Failed..",
                "modal_message" => $message,
                "modal_type" => "error",
            ];
            return Redirect::back()->with($modal);
        }

        $user = User::findOrFail(Auth::user()->id);

        if ($request->hasFile('esign')) {
            $file = $request->file('esign');
            $size = $file->getSize();
            $to_file = 'assets/images/user';
            $name_file = rand(11111, 99999) . " - " . $file->getClientOriginalName();
            $file->move($to_file, $name_file);
            $user->esign = $name_file;
            $user->save();
        }


        $modal = [
            "modal" => "yes",
            "modal_title" => "Yay! Sucess",
            "modal_message" => "You are successfully change your E-Sign!",
            "modal_type" => "success",
        ];

        return Redirect::back()->with($modal);
    }
    public function index()
    {
        if (Auth::user()->id == 1) {
            return view('pages.dashboard_admin');
        } else {
            return view('pages.dashboard');
        }
    }
    public function test()
    {
        return "test";
    }
    public function attendanceHistory()
    {
        $data['activities'] = LoginActivity::where("user_id", Auth::user()->id)->orderBy('created_at', 'DESC')->limit(62)->get();
        return view('pages.attendanceHistory', $data);
    }
    public function userAttendance()
    {
        $data['activities'] = LoginActivity::select('*', 'login_activities.created_at as activites_created_at')
            ->join('users', 'login_activities.user_id', 'users.id')
            ->where('login_activities.user_id', '<>', Auth::user()->id)
            ->where('login_activities.user_id', '<>', 1)
            ->orderBy('login_activities.created_at', 'DESC')
            ->get();
        $data['users'] = User::where("id", "<>", "1")->get();
        return view('pages.userAttendance', $data);
    }
    public function attendanceSearch(Request $request)
    {

        $query = [];

        if ($request->from !== null) {
            $query[] = ['login_activities.created_at', '>=', $request->from . " 00:00:00"];
        }

        if ($request->to !== null) {
            $query[] = ['login_activities.created_at', '<=', $request->to . " 23:59:59"];
        }

        if ($request->user_id !== 'all') {
            $query[] = ['login_activities.user_id', '=', $request->user_id];
        }

        if ($request->type !== 'all') {
            $query[] = ['login_activities.type', '=', $request->type];
        }

        $query[] = ['login_activities.user_id', '<>', Auth::user()->id];
        $query[] = ['login_activities.user_id', '<>', 1];

        $data['activities'] = LoginActivity::join('users', 'login_activities.user_id', 'users.id')
            ->select('*', 'login_activities.created_at as activites_created_at')
            ->where($query)
            ->orderBy('login_activities.created_at', 'DESC')
            ->get();

        $data['users'] = User::all();
        $request->flash();
        return view('pages.userAttendance', $data);
    }

    public function attendanceIn(Request $request)
    {
        $data = $request->except('_token');
        $date_now = date("Y-m-d");
        $find = LoginActivity::where("just_date_in", $date_now)->where("user_id", Auth::user()->id)->where("type", "in")->count();

        if ($find == 0 && time() <= strtotime('11am')) {
            $platform = Agent::platform();
            $browser = Agent::browser();
            // dd($browser);
            $browser_version = Agent::version($browser);
            $data['user_agent'] = "$platform, $browser, $browser_version";
            $data['just_date_in'] = $date_now;

            $data['type'] = "in";
            $data['user_id'] = Auth::user()->id;
            $data['ip_address'] = $request->ip();

            LoginActivity::create($data);

            $modal = [
                "modal" => "yes",
                "modal_title" => "Yay! Sucess",
                "modal_message" => "You are successfully to log off the office!",
                "modal_type" => "success",
            ];

            return back()->with($modal);
        } else {
            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Failed..",
                "modal_message" => "You are already log in the office because you are late!",
                "modal_type" => "error",
            ];
            return back()->with($modal);
        }
    }
    public function attendanceOut(Request $request)
    {
        $date_now = date("Y-m-d");
        $find = LoginActivity::where("just_date_in", $date_now)->where("user_id", Auth::user()->id)->where("type", "out")->count();

        // 9am = 9pagi
        if ($find == 0 && time() >= strtotime('3pm')) {
            $platform = Agent::platform();
            $browser = Agent::browser();
            $browser_version = Agent::version($browser);
            $user_agent = "$platform, $browser $browser_version";

            $activity = new LoginActivity;
            $activity->user_id = Auth::user()->id;
            $activity->ip_address = $request->ip();
            $activity->user_agent = $user_agent;
            $activity->latitude = $request->latitude;
            $activity->longitude = $request->longitude;
            $activity->just_date_in = $date_now;
            $activity->type = "out";
            $activity->save();

            $modal = [
                "modal" => "yes",
                "modal_title" => "Yay! Sucess",
                "modal_message" => "You are successfully to log off the office!",
                "modal_type" => "success",
            ];
        } else {
            if ($find == 0) {
                $modal = [
                    "modal" => "yes",
                    "modal_title" => "Ups! Sorry..",
                    "modal_message" => "Your time exit works is not reached yet!",
                    "modal_type" => "error",
                ];
            } else {
                $modal = [
                    "modal" => "yes",
                    "modal_title" => "Ups! Sorry..",
                    "modal_message" => "You are already exit works today!",
                    "modal_type" => "error",
                ];
            }
        }

        return Redirect::route('attendanceHistory')->with($modal);
    }
    public function fileOrder()
    {
        $data['fileOrders'] = FileOrderReceiver::where("receiver_id", Auth::user()->id)->get();

        foreach ($data['fileOrders'] as $key => $value) {
            $data['documents'][$key] = FileOrderDocument::where("file_id", $value->file_id)->first();
        }

        return view("pages.fileOrder", $data);
    }
    public function fileManager()
    {
        $data['files'] = File::orderBy('created_at', 'DESC')->get();
        return view("pages.fileManager", $data);
    }
    public function fileManagerSearch(Request $request)
    {

        $request->flash();

        $data['files'] = File::join('users', 'files.sender_id', 'users.id')
            ->where('files.link', 'LIKE', '%' . $request->keywords . '%')
            ->orWhere('users.name', 'LIKE', '%' . $request->keywords . '%')
            ->orWhere('files.created_at', 'LIKE', '%' . $request->keywords . '%')
            ->orderBy('files.created_at', 'DESC')->get();
        return view("pages.fileManager", $data);
    }
    public function fileOrderPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "receiver_id.*" => ["required", "integer"],
            "title" => ["required", "min:8", "string"],
            "instruction" => ["required", "min:8", "string"],
        ]);

        if (!$request->has('receiver_id')) {
            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Failed..",
                "modal_message" => "You must select user to receive the order!",
                "modal_type" => "error",
            ];
            return Redirect::back()->with($modal);
        }

        if ($validator->fails()) {
            // $errors = $validator->messages()->get('*');
            $message = $validator->errors()->first();

            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Failed..",
                "modal_message" => $message,
                "modal_type" => "error",
            ];
            return Redirect::back()->with($modal);
        }

        // insert to file order
        $fileOrder = new FileOrder;
        $fileOrder->sender_id = Auth::user()->id;
        $fileOrder->title = $request->title;
        $fileOrder->instruction = $request->instruction;
        $fileOrder->save();
        $id = $fileOrder->id;

        // insert to file order receiver
        foreach ($request->receiver_id as $key => $value) {
            $fileOrderReceiver = new FileOrderReceiver;
            $fileOrderReceiver->fileorder_id = $id;
            $fileOrderReceiver->receiver_id = $value;
            $fileOrderReceiver->save();

            // insert notification to receiver
            $notification = new Notification;
            $notification->from_id = Auth::user()->id;
            $notification->to_id = $value;
            $notification->message = "<b>FO-$id</b> There is new file order for you. Check it out now!";
            $notification->save();
        }

        $modal = [
            "modal" => "yes",
            "modal_title" => "Yay! Sucess",
            "modal_message" => "You are successfully post an order!",
            "modal_type" => "success",
        ];

        return Redirect::route('fileOrderHistory')->with($modal);
    }
    public function fileOrderHistory()
    {
        $data['fileOrders'] = FileOrder::where("sender_id", Auth::user()->id)->orderBy('created_at', 'DESC')->get();

        if (Auth::user()->level == 'admin') {
            $data['users'] = User::where('id', '<>', Auth::user()->id)->get();
        } else {
            $data['users'] = User::where('id', '<>', Auth::user()->id)->where('level', 'user')->get();
        }

        foreach ($data['fileOrders'] as $key => $value) {
            $data['documents'][$key] = FileOrderDocument::where("file_id", $value->id)->first();
        }

        // return $data;

        return view("pages.fileOrderHistory", $data);
    }
    public function fileOrderReview()
    {
        $data['fileOrders'] = FileOrder::where("sender_id", 1)->orderBy('created_at', 'DESC')->get();

        if (Auth::user()->level == 'admin') {
            $data['users'] = User::where('id', '<>', Auth::user()->id)->get();
        } else {
            $data['users'] = User::where('id', '<>', Auth::user()->id)->where('level', 'user')->get();
        }

        foreach ($data['fileOrders'] as $key => $value) {
            $data['documents'][$key] = FileOrderDocument::where("file_id", $value->id)->first();
        }

        // return $data;

        return view("pages.fileOrderReview", $data);
    }
    public function fileOrderCancel($id)
    {
        $fileOrder = FileOrder::findOrFail($id);
        $fileOrder->status = "canceled";
        $fileOrder->save();

        $modal = ["modal" => "yes", "modal_type" => "success", "modal_title" => "Success!", "modal_message" => "Successfully make file order to canceled."];
        return redirect('fileOrderHistory')->with($modal);
    }
    public function fileOrderComment(Request $request, $id = '')
    {
        $validator = Validator::make($request->all(), [
            "comments" => ["required", "min:5", "string"],
        ]);

        if ($validator->fails()) {
            // $errors = $validator->messages()->get('*');
            $message = $validator->errors()->first();

            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Failed..",
                "modal_message" => $message,
                "modal_type" => "error",
            ];
            return Redirect::back()->with($modal);
        }

        $fileOrderDocuments = FileOrderDocument::findOrFail($id);
        $fileOrderDocuments->comments = $request->comments;
        $fileOrderDocuments->save();

        $modal = ["modal" => "yes", "modal_type" => "success", "modal_title" => "Success!", "modal_message" => "Successfully give a comment."];
        return redirect('fileOrderHistory')->with($modal);
    }
    public function fileOrderCompleted($id)
    {
        $fileOrder = FileOrder::findOrFail($id);
        $fileOrder->status = "completed";
        $fileOrder->save();

        $modal = ["modal" => "yes", "modal_type" => "success", "modal_title" => "Success!", "modal_message" => "Successfully make file order to completed."];
        return redirect('fileOrderHistory')->with($modal);
    }
    public function fileOrderReviewPost(Request $request, $id = '')
    {
        $validator = Validator::make($request->all(), [
            "reviews" => ["required", "min:5", "string"],
        ]);

        if ($validator->fails()) {
            // $errors = $validator->messages()->get('*');
            $message = $validator->errors()->first();

            $modal = [
                "modal" => "yes",
                "modal_title" => "Ups! Failed..",
                "modal_message" => $message,
                "modal_type" => "error",
            ];
            return Redirect::back()->with($modal);
        }

        $fileOrderDocuments = FileOrderDocument::findOrFail($id);
        $fileOrderDocuments->reviews = $request->reviews;
        $fileOrderDocuments->save();

        $modal = ["modal" => "yes", "modal_type" => "success", "modal_title" => "Success!", "modal_message" => "Successfully give a review."];
        return redirect('fileOrderReview')->with($modal);
    }
    public function fileOrderUpload(Request $request, $id = '')
    {

        $fileOrder = FileOrder::findOrFail($id);
        $fileOrderDocuments = new FileOrderDocument;
        $files = new File;

        $validator = Validator::make($request->all(), [
            "file" => ["required", "max:1000000"],
        ]);


        if ($validator->fails()) {
            $modal = ["modal" => "yes", "modal_type" => "error", "modal_title" => "Failed!", "modal_message" => "File is required."];
            return redirect('fileOrder')->with($modal);
        }

        if ($request->hasFile('file')) {
            if ($fileOrder->status == "placed") {
                $fileOrder->status = "process";
                $fileOrder->save();
            }

            $file = $request->file('file');
            $size = $file->getSize();
            $to_file = 'assets/files';
            $name_file = rand(1111111111, 9999999999) . "." . $file->getClientOriginalExtension();
            $file->move($to_file, $name_file);

            // insert file
            $files->sender_id = Auth::user()->id;
            $files->link = $name_file;
            $files->size = $size;
            $files->description = "File from File Order";
            $files->save();

            $file_id = $files->id;

            // insert document
            $fileOrderDocuments->fileorder_id = $id;
            $fileOrderDocuments->file_id = $file_id;
            $fileOrderDocuments->sender_id = Auth::user()->id;
            $fileOrderDocuments->save();
        } else {
            $modal = ["modal" => "yes", "modal_type" => "error", "modal_title" => "Failed!", "modal_message" => "File is required."];
            return redirect('fileOrder')->with($modal);
        }

        $modal = ["modal" => "yes", "modal_type" => "success", "modal_title" => "Success!", "modal_message" => "Uplaod file success."];
        return redirect('fileOrder')->with($modal);
    }
}
