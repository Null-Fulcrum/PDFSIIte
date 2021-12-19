<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>PDFSite</title>
  </head>
  <body>


      <div id="PDF_display">
        <div class="iframeposition">
          <!-- создание окна для отображения странцы generatedpdf.php -->
          <iframe id="ifr" src="generatepdf.php" style="width: 760px; height: 860px;"></iframe>
          <!-- -->
          <!-- Обновлениее фрейма -->
          <script>
            var iframe = document.getElementById('ifr');
            iframe.src = iframe.src;
          </script>
          <!-- -->
        </div>
      </div>


          <div class="formcontainer">
            <ul class="list">
            <li style="margin-bottom: 5px;">
              <div class="choosefile">
                <form action="index.php"  class="submitform" method="post" enctype="multipart/form-data">
                <input  type="file" name="path"></input>
                <button type="submit" name="submit">download</button>
              </form>
              <?php
                include('color-extractor.php');
                // Перенос файла в папку PDF,чтобы generatedpdf.php смог найти файл
                if (!empty($_FILES['path'])) {
                  $filename = $_FILES['path']['name'];
                  $tmpfile = $_FILES['path']['tmp_name'];
                  $targetfilename = "PDF/".$filename;
                  move_uploaded_file($tmpfile,$targetfilename);
                  // Конвертация PDF в JPEG для экспорта цветов
                  $imagick = new Imagick();
                  $imagick->readImage($targetfilename);
                  $imagick->writeImages('converted/conv.jpg', false);
                }




                // Создание общей переменной,чтобы generatedpdf.php,смог получить имя файла
                if (isset($_POST['submit'])) {
                  session_start();
                  $_SESSION['path_file'] = $_FILES['path']['name'];
                }
              ?>
            </div>
            </li style="width:100%;height: 40%;">
            <li>
              <div class="colorList">
                <?php
              //Заполнение блока ColorList цветами из PDF
                  function web_safe($val)
                  {
                    $retval = dechex(3 * round($val/51));
                    return "{$retval}{$retval}";
                  }
                  if (!empty($_FILES['path'])) {
                    $c = 1;
                   echo "<ol style=\"list-style-type: none; font-size: 0.9em; color: #666;\">\n";
                   $files = array_diff(scandir('converted'),['..','.']);
                  foreach ($files as $file){
                    echo "<h1>Page {$c}</h1>";
                    $path = 'converted/'.$file;
                    $sampler = new \Chirp\ImageSampler($path);
                    $sampler->set_steps(20);
                    $matrix = $sampler->sample();
                    $tally = [];
                    foreach($matrix as $row => $arr) {
                      foreach($arr as $color) {
                        list($r, $g, $b) = $color;
                        $rgb = "#" . web_safe($r) . web_safe($g) . web_safe($b);
                        if(!isset($tally[$rgb])) $tally[$rgb] = 0;
                        $tally[$rgb]++;
                      }
                    }


                    asort($tally);
                    foreach($tally as $rgb => $count) {
                      echo "  <li value=\"{$count}\"><div style=\"display: inline-block; width: 10px;border:1px solid black ; height: 1em; background: {$rgb};\"></div> {$rgb}</li>\n";
                    }


                  $c= $c + 1;
                  }
                  echo "</ol>\n\n";
                  foreach ($files as $delete ) {
                    unlink('converted/'.$delete);
                  }
                }

                ?>
              </div>
            </li>
            <li>
              <div class="comment">

              </div>
            </li>
      </ul>
      </div>

  </body>
</html>
