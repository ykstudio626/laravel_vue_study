<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{

	//保存先ディレクトリ
	private $storage_path = '/user_images/';

	//アップロード
    public function upload(Request $request){
    	$data = [
    		'filename' => '',
    		'error' => ''
    	];

    	if(!empty($request->file('file'))){

	    	$result = $request->file('file')->isValid();

	    	if($result){
	    		$filename = $request->file('file')->getClientOriginalName();
                $ext = $request->file('file')->getClientOriginalExtension();
                $filename_front = str_replace('.'.$ext, '', $filename);
	    		$unique_filename = time().'_'.$filename;//同名ファイルの上書きを防ぐためタイムスタンプを付加
                $unique_filename_t = time().'_'.$filename_front.'_t.'.$ext;//サムネールファイル名
                $unique_filename_l = time().'_'.$filename_front.'_l.'.$ext;//縮小版ファイル名
                //サムネール作成
                Image::make($request->file('file'))->fit(200,200)->save(public_path().$this->storage_path . $unique_filename_t);
                //縮小版作成
                Image::make($request->file('file'))
                    ->resize(900, 600, function ($constraint) {
                        $constraint->aspectRatio(); //タテヨコ比一定   
                        $constraint->upsize(); //拡大防止
                    })->save(public_path().$this->storage_path . $unique_filename_l);
                //元ファイル移動
	    		$file = $request->file('file')->move(public_path().$this->storage_path , $unique_filename);
	    		$data['filename'] = $unique_filename;
                
                //Image::make(public_path().$this->storage_path.'/'.$unique_filename)->resize(200,200)->save(public_path().$this->storage_path , $unique_filename_t);//サムネール作成
	    	}else{
	    		$error = $request->file('file')->getErrorMessage();
	    		$data['error'] = $error;
	    	}

    	}else{//その他の要因でアップロード出来なかった場合（UploadFileオブジェクトが生成されていない）
    		$data['error'] = 'アップロード失敗';
    	}

    	return $data;
    	
    }

    public function destroy(Request $request){
        $data = [];
        if(!empty($request->input('filename'))){
            $path = public_path().$this->storage_path;
            $filename = $request->input('filename');
            $filepath = pathinfo($filename);
            $filename_t = $filepath['filename'].'_t'.'.'.$filepath['extension'];
            $filename_l = $filepath['filename'].'_l'.'.'.$filepath['extension'];
            File::delete($path.$filename , $path.$filename_t , $path.$filename_l);
        }else{
            $data['error'] = '削除失敗';
        }
        return $data;
    }

    public function store(Request $request){
    	$request->file('file')->store('images');
    	return;
    }
}
