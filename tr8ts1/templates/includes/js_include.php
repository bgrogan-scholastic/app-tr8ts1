<script type="text/javascript"> 
/*
if ($_REQUEST['pdf_display'] {
	$display = $_REQUEST['pdf_display']
}
*/

function launchPDF(slpid, title, pdf_display)
{
   var AUTH_PCODE = "<?php echo $_SERVER['AUTH_PCODE'];?>";
   //alert(AUTH_PCODE);
   //window.location.href = "/pdf?slpid="+slpid+"&product="+AUTH_PCODE+"&prompt&filename="+slpid;
   //alert("/pdf?slpid="+slpid+"&title="+title+"&product="+AUTH_PCODE+"&pdf_display="+pdf_display);
   //window.open("/pdf?slpid="+slpid+"&title="+title+"&product="+AUTH_PCODE+"&pdf_display="+pdf_display);
   
   window.location.href = "/pdf?slpid="+slpid+"&title="+title+"&product="+AUTH_PCODE;
//   alert("/pdf?slpid="+slpid+"&title="+title+"&product="+AUTH_PCODE);
   //window.open("/pdf?slpid="+slpid+"&product="+AUTH_PCODE);
}   
</script>
