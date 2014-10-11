<?php

class Images extends \Eloquent {
	protected $guarded = array('id');
	public function card(){
		$this->belongsTo('cards','cards_id');
	}
	public function parent()
    {
        return $this->belongsTo('Images', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Images', 'parent_id');
    } 
	/*
   * File Managemenet, returns directory of saved image.
   */
	public function getImageFile($url){
		if(Auth::check()){
		 		$user_id=Auth::user()->id;
		 	}else{
		 		$user_id=Session::get('user');
		 	}
		$parsed=parse_url($url);
		if($parsed['host']==Request::server('HTTP_HOST')){
			$filename=basename($url);
			$put_dir=public_path('assets/images/upload/'.$filename);
			$parts=pathinfo($url);
			//If it's file uploaded, then we need to make valid url query
			$path=URL::asset('assets/images/upload/'.rawurlencode($filename));
			}else{
			/*
			 * Save the images if they are from an external URL source. 
			 */
			$parts=pathinfo($url);
			$ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_REFERER, 'http://paulgruenbacher.com');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    $data = curl_exec($ch);
			if($data === false){
				trigger_error(curl_error($ch));	
			} 
		    curl_close($ch);
			$path=explode("?",$url);
			$filename=basename($path[0]);
			$put_dir=public_path('assets/images/instagram/'.$filename);
			file_put_contents($put_dir, $data);
			$path=URL::asset('assets/images/instagram/'.rawurlencode($filename));
		}
		//Check file values by the $put_dir
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimetype=finfo_file($finfo,$put_dir);
		$size=filesize($put_dir);
		finfo_close($finfo);
		$dimensions=getimagesize($put_dir);
		$this->file_path=$put_dir;
		$this->filename=$filename;
		$this->extension=$parts['extension'];
		$this->mimetype=$mimetype;
		$this->width=$dimensions[0];
		$this->height=$dimensions[1];
		$this->path=$path;
		$this->user_id=$user_id;
		$this->size=$size;
		$this->save();
		return $this->id;
	}
	public function saveCroppedRotate($id,$rotate,$w,$h,$x,$y){
		if(Auth::check()){
		 		$user_id=Auth::user()->id;
		 	}else{
		 		$user_id=Session::get('user');
		 	}
		//Find original image
		$image=Images::find($id);
		$filename=$image->filename;
		$filepath=$image->file_path;
		$quality=90;
		$new_path=public_path('assets/images/cropped/'.$filename);
		$img = Image::make($filepath);
		$img->rotate($rotate);
		$img->save($new_path,$quality);
		$img=Image::make($new_path);
		$img->crop($w,$h,$x,$y);
		$img->save($new_path,$quality);
		//Get information about the saved image
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimetype=finfo_file($finfo,$new_path);
		$size=filesize($new_path);
		finfo_close($finfo);
		$dimensions=getimagesize($new_path);
		//Save the cropped image mysql
		$this->filename=basename($new_path);
		$this->parent_id=$id;
		$this->user_id=$user_id;
		$this->file_path=$new_path;
		$this->path=URL::asset('assets/images/cropped/'.rawurlencode($filename));
		$this->size=$size;
		$this->width=$dimensions[0];
		$this->height=$dimensions[1];
		$this->mimetype=$mimetype;
		return $this;
	}
	public function saveThumbnail($id){
		if(Auth::check()){
		 		$user_id=Auth::user()->id;
		 	}else{
		 		$user_id=Session::get('user');
		 	}
		//Create Thumbnail Version
		$old_path=Images::find($id)->file_path;
		$thumbnail=Image::make($old_path);
		$quality=60;
		// resize the image to a width of 150 and constrain aspect ratio (auto height)
		$filename=basename($old_path);
		$thumb_path = public_path('assets/images/thumbnails/'.$filename);
		$thumbnail->resize(150, null, function ($constraint) {
		    $constraint->aspectRatio();
		});
		$thumbnail->save($thumb_path,$quality);
		//Get information about the saved image
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimetype=finfo_file($finfo,$thumb_path);
		$size=filesize($thumb_path);
		finfo_close($finfo);
		$dimensions=getimagesize($thumb_path);
		//Save the thumbnail image mysql
		$this->filename=basename($thumb_path);
		$this->parent_id=$id;
		$this->user_id=$user_id;
		$this->file_path=$thumb_path;
		$this->path=URL::asset('assets/images/thumbnails/'.rawurlencode($filename));
		$this->size=$size;
		$this->width=$dimensions[0];
		$this->height=$dimensions[1];
		$this->mimetype=$mimetype;
		$this->save();
		return DB::connection('mysql')->getPdo()->lastInsertId();
	}
	public static function boot(){
	 	parent::boot();
		static::deleting(function($image) { // before delete() method call this
             if(File::exists($image->file_path)){
             	File::delete($image->file_path);
             }
        });
	 }
}