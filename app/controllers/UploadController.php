<?php
/*
|--------------------------------------------------------------------------
| Cabinet Controller Template
|--------------------------------------------------------------------------
|
| This is the default Cabinet controller template for controlling uploads.
| Feel free to change to your needs.
|
*/

class UploadController extends BaseController {

    /**
     * Displays the form for account creation
     *
     */
     public function image(){
     	return View::make('build/upload');
     }
	 public function progress(){
	 	$key = ini_get("session.upload_progress.prefix") .'uploadImage';
		if (!empty($_SESSION[$key])) {
		    $current = $_SESSION[$key]["bytes_processed"];
		    $total = $_SESSION[$key]["content_length"];
		    return $current < $total ? ceil($current / $total * 100) : 100;
		}
		else {
		    return 100;
			}
	 }
	 public function save(){
	 	$file = Input::file('image');
        $input = array('image' => $file);
        $rules = array(
            'image' => 'image|size:100'
        );
        $validator = Validator::make($input, $rules);
        if ( $validator->fails() )
        {
            return Response::json(array('success' => false, 'errors' => $validator->getMessageBag()->toArray()));
 
        }
        else {
        	$destinationPath = public_path('assets/images/upload/');
            $filename = $file->getClientOriginalName();
            Input::file('image')->move($destinationPath, $filename);
			$htmlPath=URL::asset('assets/images/upload/'.$filename);
            return Response::json(array('success' => true, 'url' => $htmlPath));
        }
	 }
     
    public function create()
    {
    	
        return View::make(Config::get('cabinet::upload_form'));
    }
    
    public function handler(){
    	$handler=new UploadHandler;
	}

    /**
     * Stores new upload
     *
     */
    public function store()
    {
       	$file = Input::file('file');
		$upload = new Upload;

        try {
            $upload->process($file);
        } catch(Exception $exception){
            // Something went wrong. Log it.
            Log::error($exception);
            // Return error
            return Response::json($exception->getMessage(), 400);
        }

        // If it now has an id, it should have been successful.
        if ( $upload->id ) {
        	return Response::json(array('status' => 'success', 'file' => $upload->toArray()), 200);
        } else {
            return Response::json('Error', 400);
        }
	}

    public function index()
    {
        return View::make(Config::get('cabinet::upload_list'));
    }

    public function data()
    {
        $uploads =  Upload::leftjoin('users', 'uploads.user_id', '=', 'users.id')
            ->select(
                array('uploads.id', 'uploads.filename', 'uploads.path', 'uploads.extension',
                    'uploads.size', 'uploads.mimetype', 'users.id as user_id', 'users.username as username')
            );

        return Datatables::of($uploads)
            ->remove_column('id')
            ->remove_column('user_id')
            ->edit_column('username', '<a href="{{ URL::to(\'admin/users/\'.$id.\'/edit\')}}">{{$username}}</a>')
            ->make();
    }

}
