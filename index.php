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
          <iframe id="ifr" src="http://pdflib.test/generatepdf.php" style="width: 760px; height: 860px;"></iframe>
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
        <div class="choosefile">
          <form action="index.php"  class="submitform" method="post" enctype="multipart/form-data">
          <input  type="file" name="path"></input>
          <button type="submit" name="submit">download</button>
        </form>
        <?php
          // Перенос файла в папку PDF,чтобы generatedpdf.php смог найти файл
          if (!empty($_FILES['path'])) {
            $filename = $_FILES['path']['name'];
            $tmpfile = $_FILES['path']['tmp_name'];
            $targetfilename = "PDF/".$filename;
            move_uploaded_file($tmpfile,$targetfilename);
          }
          // Создание общей переменной,чтобы generatedpdf.php,смог получить имя файла
          if (isset($_POST['submit'])) {
            session_start();
            $_SESSION['path_file'] = $_FILES['path']['name'];
          }
        ?>
        </div>
      </div>

  </body>
</html>
