<?php
// Получаем имя файла из общей переменной
session_start();
//Путь к файлу
$FileTempName = 'PDF/'.$_SESSION["path_file"];
// Создаем PDF
$p = new PDFlib();
    // Выставляем кодироку символов
    $p->set_option("stringformat=utf8");
    // создаем тело PDF
    if ($p->begin_document("", "") == 0) {
        die("Error: " . $p->get_errmsg());
    }
  // Копируем содержимое вывбранного PDF файла в созданное тело
  try {
        $doc = $p->open_pdi_document("$FileTempName","");
    } catch (\Exception $e) {
      echo '';
    }

    // Подсчет страниц в файле

      $pagecount = $p->pcos_get_number($doc, "length:pages");



    // Вывод всех страниц
    for ($pageno = 1; $pageno <= $pagecount; $pageno++){
        $page = $p->open_pdi_page($doc, $pageno, "");


        $p->begin_page_ext(10, 10, "");


        $p->fit_pdi_page($page, 0, 0, "adjustpage");


        $p->end_page_ext("");
        $p->close_pdi_page($page);
    }

    $p->close_pdi_document($doc);

$p->end_document("");
// Перенос созданного файла в буфер
$buf = $p->get_buffer();
$len = strlen($buf);
// Конфигурация созданного файла
header("Content-type: application/pdf");
header("Content-Disposition: inline; filename= $FileTempName");
// Отображение файла
echo "$buf";
// Удаление файла из папки PDF,чтобы ее не засорять
$file_to_delete = $FileTempName;
unlink($file_to_delete);
?>
