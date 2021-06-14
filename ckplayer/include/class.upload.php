<?php
class uploads{
	public $uploadPath;
    protected $fileName;
    protected $maxSize;
    protected $allowMime;
    protected $allowExt;
    protected $imgFlag;
    protected $fileInfo;
    protected $error;
    protected $ext;
    protected $uniName;
    protected $destination;
    protected $file;
    protected $files;
    protected $i;
    protected $key;
    protected $value;
    protected $res;
    protected $uploadFiles;
    public function __construct($uploadPath='./uploads',$imgFlag=true,$maxSize=5242880,$allowExt=array('jpeg','jpg','png','gif'),$allowMime=array('image/jpeg','image/png','image/gif')){
        //$this->fileName=$fileName;
        $this->maxSize=$maxSize;
        $this->allowMime=$allowMime;
        $this->allowExt=$allowExt;
        $this->uploadPath=$uploadPath;
        $this->imgFlag=$imgFlag;
        //$this->fileInfo=$_FILES[$this->fileName];
        //构建上传文件的信息
        foreach($_FILES as $this->file){
          if(is_string($this->file['name'])){
            $this->files[$this->i]=$this->file;
            $this->i++;
          }elseif(is_array($this->file['name'])){
            foreach($this->file['name'] as $this->key=>$this->value){
                $this->files[$this->i]['name']=$this->file['name'][$this->key];
                $this->files[$this->i]['type']=$this->file['type'][$this->key];
                $this->files[$this->i]['tmp_name']=$this->file['tmp_name'][$this->key];
                $this->files[$this->i]['error']=$this->file['error'][$this->key];
                $this->files[$this->i]['size']=$this->file['size'][$this->key];
                $this->i++;
                }
           }
         }
    }
 
    protected function checkError(){
        if($this->fileInfo['error']!=0){
            switch($this->fileInfo['error']){
                case 1:
                    $this->error='上传文件超出了php配置中upload_max_filesize选项的值';
                    break;
                case 2:
                    $this->error="超出了表单MAX_FILE_SIZE限制的大小";
                    break;
                case 3:
                    $this->error="文件部分被上传";
                    break;
                case 4:
                    $this->error="没有选择上传文件";
                    break;
                case 6:
                    $this->error="没找到临时目录";
                    break;
                case 7:
                    $this->error="文件不可写";
                    break;
                case 8:
                    $this->error="系统错误";
                    break;
            }
            return false;
        }
        return true;
    }
    protected function checkExt(){
        $this->ext=strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
        if(!in_array($this->ext,$this->allowExt)){
            $this->error='不允许的扩展名';
            return false;
        }
        return true;
    }
    protected function checkSize(){
        if($this->fileInfo['size']>$this->maxSize){
            $this->error='上传文件过大';
            return false;
        }
        return true;
    }
    /*检测文件类型的*/
    protected function checkMime(){
        if(!in_array($this->fileInfo['type'],$this->allowMime)){
            $this->error='不允许的文件类型';
            return false;
        }
        return true; 
    }
    protected function checkTrueImg(){
        if($this->imgFlag){
            if(!@getimagesize($this->fileInfo['tmp_name'])){
               $this->error='不是真实图片';
               return false;
            }
        }
        return true;
    }
    /*是否通过HTTPPOST方式上传上来的*/
    protected function checkHTTPPOST(){
        if(!is_uploaded_file($this->fileInfo['tmp_name'])){
            $this->error='文件不是通过HTTPPOST方式上传上来的';
            return false;
        }
        return true;
    }
    /*显示错误信息*/
    protected function showError(){
        echo('<sapn style="color:red;">'.$this->error.'</sapn>');
        echo "<br/>";
    }
    protected function checkUploadPath(){
        if(!file_exists($this->uploadPath))
            mkdir($this->uploadPath,0777,true);
    }
    /*产生唯一字符串*/
    protected function getUniName(){
        return md5(uniqid(microtime(true),true));
    }
    protected function uploadFile(){
        if($this->checkError()&&$this->checkExt()&&$this->checkSize()&&$this->checkMime()&&$this->checkTrueImg()&&$this->checkHTTPPOST()){
            $this->checkUploadPath();
            $this->uniName=$this->getUniName();
            $this->destination=$this->uploadPath.'/'.$this->uniName.'.'.$this->ext;        if(@move_uploaded_file($this->fileInfo['tmp_name'],$this->destination)){
                $this->uploadFiles[]=$this->destination;
            }else{
                $this->error='文件移动失败';
                $this->showError();
            }

    }else{
         $this->showError();
    }
   }
   public function uploadsFile(){
      foreach($this->files as $this->fileInfo){
        $this->uploadFile($this->fileInfo); 
        
      }
      return $this->uploadFiles;
   }
}