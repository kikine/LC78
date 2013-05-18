<?php
$pdf = pdf_new();
pdf_open_file($pdf, "test.pdf");
pdf_set_info($pdf, "Author", "Le Chesnay 78 Escrime");
pdf_set_info($pdf, "Title", "Inscription compétition");
pdf_set_info($pdf, "Creator", "See Author");
pdf_set_info($pdf, "Subject", "Test");
pdf_begin_page($pdf, 595, 842);
pdf_add_bookmark($pdf, "Page 1");
pdf_set_font($pdf, "Times-Roman", 30, "host");
pdf_set_value($pdf, "textrendering", 1);
pdf_show_xy($pdf, "Inscription CNEDS", 50, 750);
pdf_moveto($pdf, 50, 740);
pdf_lineto($pdf, 330, 740);
pdf_stroke($pdf);
pdf_end_page($pdf);
pdf_close($pdf);
pdf_delete($pdf);
$fp = fopen("test.pdf", "r");
header("Content-type: application/pdf");
fpassthru($fp);
fclose($fp);
?>