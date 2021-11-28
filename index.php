<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>PDFSite</title>
  </head>
  <body>
    <div id="Header">
      <div id="logo">PDFlib.ru</div>
    </div>
    <div id="body">
      <div id="PDF_display">

        <script>
        var iframe = document.getElementById('ifr');
        iframe.src = iframe.src;
        </script>

        <iframe id="ifr" src="http://pdflib.test/generatepdf.php" style="width: 100%; height: 100%;"></iframe>

      </div>
      <div id="Button_div">
          <form action="index.php" method="post" enctype="multipart/form-data">
          <input  type="file" name="path"></input>
          </br>
          <button type="submit" name="submit">download</button>
        </form>
        <?php

        if (isset($_POST['submit'])) {
          session_start();
          $_SESSION['path_file'] = $_FILES['path']['name'];


        }

        ?>
      </div>
    </div>
  </body>
</html>
