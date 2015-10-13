<?php
class geotag
{
    function __construct() { }
    
    private function exifToNumber($value, $format) 
    { 
        $spos = strpos($value, '/'); 
        if ($spos === false) 
        { 
            return sprintf($format, $value); 
        } 
        else 
        { 
            list($base,$divider) = explode("/", $value, 2); 
            if ($divider == 0){ return sprintf($format, 0); }
            else { return sprintf($format, ($base / $divider)); }
        } 
    } 

    private function exifToCoordinate($reference, $coordinate) 
    { 
        if ($reference == 'S' || $reference == 'W') {  $prefix = '-';  }
        else { $prefix = ''; }

        return $prefix . sprintf('%.6F', $this->exifToNumber($coordinate[0], '%.6F') + 
            ((($this->exifToNumber($coordinate[1], '%.6F') * 60) +     
            ($this->exifToNumber($coordinate[2], '%.6F'))) / 3600)); 
    } 

    function getCoordinates($filename) 
    { 
        if (extension_loaded('exif') && file_exists($filename) ) 
        { 
            $exif = exif_read_data($filename, 'EXIF'); 

            if (isset($exif['GPSLatitudeRef']) && isset($exif['GPSLatitude']) &&  
                isset($exif['GPSLongitudeRef']) && isset($exif['GPSLongitude'])) 
            { 
                return array ( 
                    $this->exifToCoordinate($exif['GPSLatitudeRef'], $exif['GPSLatitude']),  
                    $this->exifToCoordinate($exif['GPSLongitudeRef'], $exif['GPSLongitude']) 
                ); 
            } 
        } 
        
        return FALSE;
    } 

}

// Untuk memanggil fungsi info_camera(namafile.jpg) berisi informasi foto dengan metode EXIF
function info_camera($imagePath) {

    // Mengecek keberadaan file, jika tidak ditemukan maka tidak akan diproses
    if ((isset($imagePath)) and (file_exists($imagePath))) {
   
      // Ada 2 informasi dengan berbentuk array, yaitu IFD0 dan EXIF.
      $exif_ifd0 = read_exif_data($imagePath ,'IFD0' ,0);      
      $exif_exif = read_exif_data($imagePath ,'EXIF' ,0);
     
      // Informasi tidak ditemukan
      $notFound = "Tidak terdeteksi";
     
      // Make
      if (@array_key_exists('Make', $exif_ifd0)) {
        $camMake = $exif_ifd0['Make'];
      } else { $camMake = $notFound; }
     
      // Model
      if (@array_key_exists('Model', $exif_ifd0)) {
        $camModel = $exif_ifd0['Model'];
      } else { $camModel = $notFound; }
     
      // Exposure
      if (@array_key_exists('ExposureTime', $exif_ifd0)) {
        $camExposure = $exif_ifd0['ExposureTime'];
      } else { $camExposure = $notFound; }

      // Aperture
      if (@array_key_exists('ApertureFNumber', $exif_ifd0['COMPUTED'])) {
        $camAperture = $exif_ifd0['COMPUTED']['ApertureFNumber'];
      } else { $camAperture = $notFound; }

      // Width
      if (@array_key_exists('Width', $exif_ifd0['COMPUTED'])) {
        $camWidth = $exif_ifd0['COMPUTED']['Width'];
      } else { $camWidth = $notFound; }
     
      // Height
      if (@array_key_exists('Height', $exif_ifd0['COMPUTED'])) {
        $camHeight = $exif_ifd0['COMPUTED']['Height'];
      } else { $camHeight = $notFound; }

      // Date
      if (@array_key_exists('DateTime', $exif_ifd0)) {
        $camDate = $exif_ifd0['DateTime'];
      } else { $camDate = $notFound; }
     
      // GPSLatitudeRef
      if (@array_key_exists('GPSLatitudeRef',$exif_exif)) {
        $camGPSLatitudeRef = $exif_exif['GPSLatitudeRef'];
      } else { $camGPSLatitudeRef = $notFound; }

            // GPSLatitude
      if (@array_key_exists('GPSLatitude',$exif_exif)) {
        $camGPSLatitude = $exif_exif['GPSLatitude'];
      } else { $camGPSLatitude = $notFound; }

            // GPSLongitudeRef
      if (@array_key_exists('GPSLongitudeRef',$exif_exif)) {
        $camGPSLongitudeRef = $exif_exif['GPSLongitudeRef'];
      } else { $camGPSLongitudeRef = $notFound; }

            // GPSLongitude
      if (@array_key_exists('GPSLongitude',$exif_exif)) {
        $camGPSLongitude = $exif_exif['GPSLongitude'];
      } else { $camGPSLongitude = $notFound; }

            // ISO
      if (@array_key_exists('ISOSpeedRatings',$exif_exif)) {
        $camIso = $exif_exif['ISOSpeedRatings'];
      } else { $camIso = $notFound; }
     
      $return = array();
      $return['make'] = $camMake;
      $return['model'] = $camModel;
      $return['exposure'] = $camExposure;
      $return['aperture'] = $camAperture;
      $return['width'] = $camWidth;
      $return['height'] = $camHeight;
      $return['date'] = $camDate;
      $return['iso'] = $camIso;
      $return['total_pixels'] =  $camHeight * $camWidth;
      $return['ratio_pixels'] = $camWidth/$camHeight;
      $return['GPSLatitudeRef'] = $camGPSLatitudeRef;
      $return['GPSLatitude'] = $camGPSLatitude;
      $return['GPSLongitudeRef'] = $camGPSLongitudeRef;
      $return['GPSLongitude'] = $camGPSLongitude;
      return $return;
   
    } else {
      // Berkas tidak ditemukan
      return false;
    }
}

$camera = info_camera($image);
$megapixels = round($camera['total_pixels']/1000000);
$geo = new geotag();
$result = $geo->getCoordinates($image);
?>
