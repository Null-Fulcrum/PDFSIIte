<?php
session_start();
$FileTempName = 'PDF/'.$_SESSION["path_file"];
$_SESSION = array();
$p = new PDFlib();
    $p->set_option("stringformat=utf8");

    if ($p->begin_document("", "") == 0) {
        die("Error: " . $p->get_errmsg());
    }
try {
      $doc = $p->open_pdi_document("$FileTempName","");
} catch (\Exception $e) {
  echo '';
}


    $pagecount = $p->pcos_get_number($doc, "length:pages");

    for ($pageno = 1; $pageno <= $pagecount; $pageno++){
        $page = $p->open_pdi_page($doc, $pageno, "");


        $p->begin_page_ext(20, 20, "");      


        $p->fit_pdi_page($page, 0, 0, "adjustpage");


        $p->end_page_ext("");
        $p->close_pdi_page($page);
    }
    $p->close_pdi_document($doc);

$p->end_document("");
$buf = $p->get_buffer();
$len = strlen($buf);

header("Content-type: application/pdf");
header("Content-Disposition: inline; filename= $FileTempName");
echo "$buf";

?>
