<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="spm-id" content="5176">
    <meta name="description" content="">
    <meta name="keyword" content="">
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data" name="upload_file">
        <label>选择图片文件</label>
        <input name="imgfile" type="file" accept="image/gif, image/jpeg"/>
        <input name="upload" type="submit" value="上传" />
    </form>

<?php
/**
 * Created by PhpStorm.
 * User: luleilei
 * Date: 2017/6/30
 * Time: 上午11:32
 */
//PHP利用GD库将图像裁剪成圆形图

if(!empty($_POST['upload'])){
    $imagePath = test($_FILES['imgfile']['tmp_name'],'./');
    echo '<img src="'.$imagePath.'"/>';

}



/**
 * 说明：PHP利用GD库将图像裁剪成圆形图
 * @param  要处理的图片地址 $url
 * @param  处理后的图片存放位置 $path
 * @return bool true on success or false on failure.
 */
function test($url,$path='./'){
    $imageSize = getimagesize($url);
    $w = $imageSize[0];  $h=$imageSize[1]; // original size
    $original_path= $url;
    $dest_path = $path.uniqid().'.png';
    $src = imagecreatefromstring(file_get_contents($original_path));
    $newpic = imagecreatetruecolor($w,$h);
    imagealphablending($newpic,false);
    $transparent = imagecolorallocatealpha($newpic, 0, 0, 0, 127);
    $r=$w/2;
    for($x=0;$x<$w;$x++)
        for($y=0;$y<$h;$y++){
            $c = imagecolorat($src,$x,$y);
            $_x = $x - $w/2;
            $_y = $y - $h/2;
            if((($_x*$_x) + ($_y*$_y)) < ($r*$r)){
                imagesetpixel($newpic,$x,$y,$c);
            }else{
                imagesetpixel($newpic,$x,$y,$transparent);
            }
        }
    imagesavealpha($newpic, true);
    imagepng($newpic, $dest_path);
    imagedestroy($newpic);
    imagedestroy($src);
    // unlink($url);
    return $dest_path;
}
?>
</body>
</html>
