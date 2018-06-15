			</div>
		</div>
	</div>

	<script type="text/javascript" src="assets/js/jquery-3.2.1.js"></script>
	<script src="assets/js/choosen.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/ajax.js"></script>
	<script type="text/javascript" src="assets/js/Chart.min.js"></script>
	<script type="text/javascript" src="assets/js/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/html2canvas.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js" integrity="sha384-CchuzHs077vGtfhGYl9Qtc7Vx64rXBXdIAZIPbItbNyWIRTdG0oYAqki3Ry13Yzu" crossorigin="anonymous"></script>

	<script type="text/javascript">
		function printing(){
	html2canvas(document.getElementsByClassName('container'),{
		onrendered: function(canvas){
			var img= canvas.toDataURL('image/png');
			var doc= new jsPDF();
			doc.addImage(img, 'JPEG', 10, 10, 180, 100);
			doc.save('report.pdf');
		}
	});
}
	</script>
</body>
</html>