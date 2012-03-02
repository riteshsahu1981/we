<?php
class Base_Uploadease
{
	private $basePath='';
	
	public function __construct()
		{
		  $this->basePath=dirname(__FILE__);
		}
	
	
	public function getPlugin()
		{
		$data = "
		 <script type='text/javascript' src='/js/UploadEaseHelper.js'></script>	
		  <div id='uploader'>
         
          <script type='text/javascript'>
	        function uploadDone( bundleGroupID ) {
	          alert('Upload done!');
	        }
		        var ue = new ueAppletHelper( {
		          codebase: '/java/',
		          width     : 800,
		          height    : 600,
		          maxFileCount: 10,
		          maxFileSize: 1000000,
		          uploadURL : '/index/upload-photo/'
		        } );
		
		        ue.setLastFolderVisitedCookie(30*86400, '/'); // Expire in 30 days
		        
		        ue.setCallbacks({onUploadDone:'uploadDone'});
		
		        ue.write();
		      </script>
		     </div>"; 
		
		return $data;
		}
		
		function downloadFiles($filename)
	{
		if(ini_get('zlib.output_compression'))
			  ini_set('zlib.output_compression', 'Off');
			
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
			
			if( $filename == "" ) 
			{
			  echo "<html><title></title><body>ERROR: download file NOT SPECIFIED.</body></html>";
			  exit;
			} elseif ( ! file_exists( $filename ) ) {
			  echo "<html><title></title><body>ERROR: File not found.</body></html>";
			  exit;
			};
			
			switch($file_extension)
			{
			  case "pdf": $ctype="application/pdf"; break;
			  case "exe": $ctype="application/octet-stream"; break;
			  case "zip": $ctype="application/zip"; break;
			  case "doc": $ctype="application/msword"; break;
			  case "xls": $ctype="application/vnd.ms-excel"; break;
			  case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			  case "gif": $ctype="image/gif"; break;
			  case "png": $ctype="image/png"; break;
			  case "jpeg":
			  case "jpg": $ctype="image/jpg"; break;
			  default: $ctype="application/force-download";
			}
			
			header("Pragma: public"); 
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Content-Type: $ctype");
			
			header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($filename));
			readfile("$filename");
			exit();
		}
	
	}

