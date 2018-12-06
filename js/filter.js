//ERROR VARIABLES
error = {};
$user_item = "";
errormsg = {};
error['user'] = 0;
error['pass'] = 0;
error['nama'] = 0;
error['email'] = 0;
error['no_telp'] = 0;
error['deskripsi'] = 0;
error['web'] = 0;
error['fak'] = 0;
error['kap'] = 0;
error['tiket'] = 0;
error['lokasi'] = 0;
error['poster'] = 0;
errormsg['nama']="<span class='asterisk'><b>Kesalahan</b></span> : Nama Belum Diisi/Terlalu panjang<br />";
errormsg['user']="<span class='asterisk'><b>Kesalahan</b></span> : Username Belum Diisi<br />";
errormsg['pass']="<span class='asterisk'><b>Kesalahan</b></span> : Password terdiri dari angka dan huruf, 8-20 karakter<br />";
errormsg['email']="<span class='asterisk'><b>Kesalahan</b></span> : Email Belum Diisi/Format Email Salah<br />";
errormsg['no_telp']="<span class='asterisk'><b>Kesalahan</b></span> : Format Nomor Telepon Salah<br />";
errormsg['deskripsi'] = "<span class='asterisk'><b>Kesalahan</b></span> : Deskripsi belum diisi<br />";
errormsg['web'] = "<span class='asterisk'><b>Kesalahan</b></span> : Maksimal 50 karakter<br />";
errormsg['fak'] = "<span class='asterisk'><b>Kesalahan</b></span> : Fakultas belum diisi";
errormsg['kap'] = "<span class='asterisk'><b>Kesalahan</b></span> : Format salah";
errormsg['tiket'] = "<span class='asterisk'><b>Kesalahan</b></span> : Format salah";
errormsg['lokasi'] = "<span class='asterisk'><b>Kesalahan</b></span> : Lokasi belum diisi";
errormsg['poster'] = "<span class='asterisk'><b>Kesalahan</b></span> : Poster harus diisi";

//FUNCTIONS

function filter(){  //FILTER FOR FORM INPUTS
		$("input[type='button']").prop("disabled", true);
		$("input[type='submit']").prop("disabled", true);
		
		//check if username column if empty
		if(typeof $("input[name='pass']").val() !== 'undefined'){
	if($("input[name='user']").val() == ""){
		error['user'] = 1;
		errormsg['user']="<span class='asterisk'><b>Kesalahan</b></span> : Username Belum Diisi<br />";
		} else {
			if($("input[name='user']").val().length > 20){
		error['user'] = 1;
		errormsg['user'] = "<span class='asterisk'><b>Kesalahan</b></span> : Username maksimal 20 karakter<br />"
		} else {
			if($("input[name='user']").val().indexOf(" ") > 0){
		error['user'] = 1;
		errormsg['user'] = "<span class='asterisk'><b>Kesalahan</b></span> : Format Username Salah<br />"
		} else {
			error['user'] = 0;
		}
		}
		}
		}
		
	//check password format
	if(typeof $("input[name='pass']").val() !== 'undefined'){
	var pass = $("input[name='pass']").val();
	if(pass.length < 8 || pass.length >20){   //check password length
		error['pass'] = 1;
	} else {
	if(((pass.replace(/[^0-9]/g,"").length) < 1) || ((pass.replace(/[^A-Za-z]/g,"").length) < 1)){ //check if password contains numbers and string 
		error['pass'] = 1;
	} else {
		error['pass'] = 0;
	}
	}
	}

	//check if nama organisasi/kepanitiaan/event column is empty
	if(typeof $("input[name='nama']").val() !== 'undefined'){
	if($("input[name='nama']").val() == "" || $("input[name='nama']").val().length > 49){
		error['nama'] = 1;
		} else {
			error['nama'] = 0;
		}
	}	
		
	//check if tingkatan fakultas need to be selected
	if(typeof $("select[name='tk']").val() !== 'undefined'){
	if($("select[name='tk']").val() == "Universitas"){
		$("select[name='fak']").prop("disabled", true);
		} else {
		$("select[name='fak']").prop("disabled", false);
		}
		
	}	

		
	//check if fakultas is empty
		if(typeof $("select[name='tk']").val() !== "undefined"){
	if($("select[name='fak']").val() == "" && $("select[name='tk']").val() == "Fakultas"){
		error['fak'] = 1;
		} else {
			error['fak'] = 0;
		}
		}	

		//check if email column is empty
	if(typeof $("input[name='email']").val() !== 'undefined'){
	if($("input[name='email']").val() == "" || $("input[name='email']").val().length > 50 ){
		error['email'] = 1;
		} else {
			if($("input[name='email']").val().indexOf("@") <= 0 || $("input[name='email']").val().indexOf("\.") <= 0 ){
				error['email'] = 1;
			} else {
			error['email'] = 0;
			}
		}
		}
		
			//check if phone number column format is correct
		if(typeof $("input[name='no_telp']").val() !== 'undefined'){
	if(($.isNumeric($("input[name='no_telp']").val()) == false && $("input[name='no_telp']").val().length!=0) || $("input[name='no_telp']").val().length > 20 || $("input[name='no_telp']").val().length==0 ){
		error['no_telp'] = 1;
		} else {
			error['no_telp'] = 0;
		}
		}
		
			//check if deskripsi is empty
		if(typeof $("textarea[name='deskripsi']").val() !== 'undefined'){
	if($("textarea[name='deskripsi']").val() == ""){
		error['deskripsi'] = 1;
		} else {
			error['deskripsi'] = 0;
		}
		}
		// check if web > 50 chars
	if(typeof $("input[name='web']").val() !== 'undefined'){
	if($("input[name='web']").val().length > 49){
		error['web'] = 1;
		} else {
			error['web'] = 0;
		}
		}

	//check if kapasitas format is integer
		if(typeof $("input[name='kap']").val() !== 'undefined'){
	if(($.isNumeric($("input[name='kap']").val()) == false && $("input[name='kap']").val().length!=0) || $("input[name='kap']").val().length > 5 || $("input[name='kap']").val().length==0 ){
		error['kap'] = 1;
		} else {
			error['kap'] = 0;
		}
		}
		
			//check if harga tiket format is integer
		if(typeof $("input[name='tiket']").val() !== 'undefined'){
	if(($.isNumeric($("input[name='tiket']").val()) == false && $("input[name='tiket']").val().length!=0) || $("input[name='kap']").val().length > 20){
		error['tiket'] = 1;
		} else {
			error['tiket'] = 0;
		}
		}
		
				//check if lokasi is empty
		if(typeof $("input[name='lokasi']").val() !== 'undefined'){
	if($("input[name='lokasi']").val() == ""){
		error['lokasi'] = 1;
		} else {
			error['lokasi'] = 0;
		}
		}
		
				
				//check if poster is empty
		if(typeof $("input[name='poster']").val() !== 'undefined'){
	if($("input[name='poster']").val() == ""){
		error['poster'] = 1;
		} else {
			error['poster'] = 0;
		}
		}
	check_error();
}


function check_error(){  //CHECKING FORMS USING FILTERS
	error_count = 0;
	jQuery.each(errormsg, function(index, item) {
		$('#'+index+'-notif').html("");
		error_count += error[index];
		if(error[index]==1){
		$('#'+index+'-notif').html(item);
		} else{
			$('#'+index+'-notif').html("");
		}
	});
	if(error_count == 0){
			$(":input[type='button']").prop("disabled", false);
			$(":input[type='submit']").prop("disabled", false);
		} else {
			$(":input[type='button']").prop("disabled", true);
			$(":input[type='submit']").prop("disabled", true);
		}
}


// load organisasi by tingkatan on add/edit kepanitiaan
function loadOrg(){
	org = "";
	if(typeof $("input[name='org']").val() !== 'undefined'){
		org=$("input[name='org']").val();
	}
	tk = $("select[name='tk']").val();
	$.ajax({
		async: false,
		type: 'GET',
		url:"content/filter.php?filter=select_org&item="+tk+"&org="+org,
		success:function(data){
			$("#select_org").html(data);
			state = 0;
		}
	});
}

function loadKep(){
	org = "";
	kep="";
	if(typeof $("#org").val() !== 'undefined'){
		org=$("#org").val();
	}
	if(typeof $("#id_pembuat").val() !== 'undefined'){
		kep=$("#id_pembuat").val();
	}
	$.ajax({
		async: false,
		type: 'GET',
		url:"content/filter.php?filter=select_kep&item="+org+"&kep="+kep,
		success:function(data){
			$("#kep").html(data);
			state = 0;
		}
	});
}

//MAIN FUNCTION
$('document').ready(function(){
filter();
loadOrg();

$( function() {
    $("#datepicker").datepicker({ dateFormat: 'dd-mm-yy' });
  } );

$('.custom-form').bind('input', function(){
  filter();
});

$('.custom-form').change('select', function(){
  filter();
});
$('#select_tk').change('select', function(){
  loadOrg();
});
$('#org').change('select', function(){
  loadKep();
});
$('#org').ready(function(){
  loadKep();
});


//SUBMIT CREATE/UPDATE EVENT
$("#add_eve_btn").click(function(event){
	
			if(!($("input[name='tgl']").val().match(/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[012])[- /.](19|20)\d\d$/))){
				alert("Format Tanggal Salah");
				state=0
		} else {
				state=1;
		}
		
	if(state==1){
		$("#add_eve_form").submit();
	}
});

});