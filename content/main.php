<?php
//VARIABLES
$bs_input='';
$bs_no_urut='';
if(!empty($_GET['action'])){
	$action=$_GET['action'];
} else {
	$action = 'home';	
}
// File structure:
// - DEFINE QUERY
// - RUN QUERY & BUILD TABLES
// - INTERFACE ELEMENTS
// - BUILD INTERFACE


 
//-------------------- DEFINE QUERY -----------------------//
switch ($action){
case 'home':
			$result_org = pg_query($conn, 'select nama as ORGANISASI from organisasi,pembuat_event where id=id_organisasi order by nama asc limit 5 ');
			$result_kep = pg_query($conn, 'select nama as KEPANITIAAN from kepanitiaan,pembuat_event where id=id_kepanitiaan order by nama asc limit 5');
			$result_eve = pg_query($conn, 'select nama as EVENT from event order by id_event asc limit 5');
			break;
case 'login':
			$username = $_POST['user'];
			$password = $_POST['pass'];
			$result = pg_query($conn, "select * from pengguna where username='$username' and password='$password'");
			break;
case 'show-organisasi':
			$result = pg_query($conn, 'select nama as "Nama Organisasi",email as "Email",alamat_website as "Website",tingkatan as "Tingkatan",kategori as "Kategori", id_organisasi from organisasi,pembuat_event where id=id_organisasi');
			break;
case 'show-kepanitiaan':
			$result = pg_query($conn, 'select nama as "Nama Kepanitiaan",email as "Email", alamat_website as "Website",tingkatan as "Tingkatan", kategori as "Kategori", id_kepanitiaan,id_organisasi from kepanitiaan,pembuat_event where id=id_kepanitiaan');
			break;
case 'show-event':
			$result = pg_query($conn, 'select nama as "Nama Event", waktu as "Waktu",kapasitas as "Kapasitas",harga_tiket as "Harga Tiket", sifat_event as "Sifat",id_event,id_pembuat_event from event');
			break;
case 'edit-organisasi':
			$id = $_GET['id'];
			$result = pg_query($conn, "select distinct * from organisasi,pembuat_event where id=id_organisasi and id='$id'");
			break;
case 'edit-kepanitiaan':
			$id_kep = $_GET['id_kepanitiaan'];
			$id_org = $_GET['id_organisasi'];
			$result = pg_query($conn, "select distinct * from kepanitiaan,pembuat_event where id=id_kepanitiaan and id='$id_kep'");
			break;
case 'edit-event':
			$id_eve = $_GET['id'];
			$query = "select * from event where id_event=".intval($id_eve);
			$result = pg_query($conn, $query);
			break;
case 'save-organisasi':
			$do=$_GET['do'];
			$nama = $_POST['nama'];
			$tingkatan = $_POST['tk'];
				if($tingkatan=='Fakultas'){
					$tingkatan=$_POST['fak'];
				}
			$email = $_POST['email'];
			$web = $_POST['web'];
			$telp = $_POST['no_telp'];
			$cat = $_POST['cat'];
			$logo = $_POST['logo'];
			if($logo !==""){
			$logo = "http://dummy.ui.ac.id/".$logo;
			}
			$deskripsi = $_POST['deskripsi'];
			switch ($do){
				case 'add':
						$get_last_id=pg_query($conn, "select id from pembuat_event order by id desc limit 1");
						$last_id_row=pg_fetch_row($get_last_id);
						$last_id=$last_id_row[0]+1;
						pg_query($conn, "insert into pembuat_event values('$last_id','$nama','$email','$web','$tingkatan','$cat','$logo','$deskripsi','$telp')");
						pg_query($conn, "insert into organisasi values ($last_id)");
					break;
				case 'update':
						$last_id=$_GET['id'];
						pg_query($conn, "update pembuat_event set nama='$nama',email='$email',alamat_website='$web',tingkatan='$tingkatan',kategori='$cat',logo='$logo',deskripsi='$deskripsi',contact_person='$telp' where id='$last_id'");
					break;
			}
			break;
case 'save-kepanitiaan':
			$do=$_GET['do'];
			$nama = $_POST['nama'];
			$tingkatan = $_POST['tk'];
			$organisasi=$_POST['org'];
			$email = $_POST['email'];
			$web = $_POST['web'];
			$telp = $_POST['no_telp'];
			$cat = $_POST['cat'];
			$logo = $_POST['logo'];
			if($logo !==""){
			$logo = "http://dummy.ui.ac.id/".$logo;
			}
			$deskripsi = $_POST['deskripsi'];
			switch ($do){
				case 'add':					
						$get_last_id=pg_query($conn, "select id from pembuat_event order by id desc limit 1");
						$last_id_row=pg_fetch_row($get_last_id);
						$last_id=$last_id_row[0]+1;
						pg_query($conn, "insert into pembuat_event values('$last_id','$nama','$email','$web','$tingkatan','$cat','$logo','$deskripsi','$telp')");
						$query = "insert into kepanitiaan values ('$last_id',".intval($organisasi).")";
						pg_query($conn, $query);
					break;
				case 'update':
						$org=$_POST['select_org'];
						$last_id=$_GET['id_kep'];
						pg_query($conn, "update pembuat_event set nama='$nama',email='$email',alamat_website='$web',tingkatan='$tingkatan',kategori='$cat',logo='$logo',deskripsi='$deskripsi',contact_person='$telp' where id='$last_id'");
						$query = "update kepanitiaan set id_organisasi='$org' where id_kepanitiaan='$last_id'";
						pg_query($conn, $query);
					break;
			}
			break;
case 'save-event':
			$do=$_GET['do'];
			$nama=$_POST['nama'];
			$tgl = $_POST['tgl'];
			$jam = $_POST['jam'];
			$menit = $_POST['menit'];
			$kapasitas = $_POST['kap'];
			$tiket = $_POST['tiket'];
			$lokasi = $_POST['lokasi'];
			$sifat = $_POST['sifat'];
			$kategori = $_POST['cat'];
			$deskripsi = $_POST['deskripsi'];
			$timestamp = $tgl." ".$jam.":".$menit.":00";
			//$name  = $_POST['poster'];
			//$temp_name  = $_FILES['poster']['tmp_name'];  
			//$location = 'poster/';      
			//move_uploaded_file($temp_name, $location.$name);
			//$image=$location.$name;
			switch ($do){
				case 'add':
					$pembuat_event = $_POST['org'];
					if($_POST['kep']){
					$kep = $_POST['kep'];
					}
					if($_POST['kep'] !==""){
					$pembuat_event=$_POST['kep'];
						}
					$get_last_id=pg_query($conn, "select id_event from event order by id_event desc limit 1");
					$last_id_row=pg_fetch_row($get_last_id);
					$last_id=$last_id_row[0]+1;
					pg_query($conn, "insert into event values('$last_id','$pembuat_event','$nama','$tgl','$timestamp','$kapasitas','$tiket','$lokasi','$sifat','$deskripsi','$kategori')");
					break;
				case 'update':
					$id=$_GET['id'];
					pg_query($conn, "update event set nama='$nama',tanggal='$tgl',waktu='$timestamp',kapasitas='$kapasitas',harga_tiket='$tiket',lokasi='$lokasi',sifat_event='$sifat',deskripsi_singkat='$deskripsi',nomor_kategori='$kategori' where id_event='$id'");
					break;
			}
			break;
case 'confirm-delete':
			$item=$_GET['item'];
			$id=$_GET['id'];
			$id_pembuat=$_GET['id_pembuat'];
			break;
case 'delete':
			$item=$_GET['item'];
			$id=$_GET['id'];
			switch($item){
				case 'org':
				pg_query($conn, "delete from pembuat_event where id='$id'");
				break;
				case 'kep':
				pg_query($conn, "delete from pembuat_event where id='$id'");
				break;
				case 'eve':
				$id_pembuat=$_GET['id_pembuat'];
				pg_query($conn, "delete from event where id_event='$id' and id_pembuat_event='$id_pembuat'");
				break;
			}
			//$result=($conn, 'select');

			break;
case 'show':
			$item=$_GET['item'];
			$id=$_GET['id'];
			switch($item){
				case 'org':
				$result = pg_query($conn, "select distinct * from pembuat_event,organisasi where id=id_organisasi and id='$id'");
				$back = "organisasi";
				break;
				case 'kep':
				$result = pg_query($conn, "select distinct * from pembuat_event,kepanitiaan where id=id_kepanitiaan and id='$id'");
				$back="kepanitiaan";
				break;
				case 'eve':
				$id_pembuat=$_GET['id_pembuat'];
				$back="event";
				$result=pg_query($conn, "select * from event where id_event='$id' and id_pembuat_event='$id_pembuat'");
				break;
			}
			break;	
}




//-------------- RUN QUERY & BUILD TABLES---------------//
switch($action){
case 'home':
			$content="<div class='seleksi'>
					<table  align='center'><tr><td valign='top'>
					<div class='home-panel'>
					<table cellspacing='0' cellpadding='0' align='center'>
					<thead><tr>";
			$col= pg_num_fields($result_org);
			for($i=0;$i<$col;$i++){
				$colname = pg_field_name($result_org,$i);
				$content .= "<th>".strtoupper($colname)."</th>";
			}
			$content .="</tr></thead><tbody>";

			while ($hasil_result_org = pg_fetch_row($result_org)) {
				$content.="<tr><td>".$hasil_result_org[0]."</td></tr>";
			}
			$content.="<tr><td colspan='2'><a href='index.php?action=show-organisasi'>Lihat Semua Organisasi</a></td></tr></tbody></table>
					</div></td><td valign='top'>
					<div class='home-panel'>
					<table cellspacing='0' cellpadding='0' align='center'>
					<thead><tr>";
			$col= pg_num_fields($result_kep);
			for($i=0;$i<$col;$i++){
				$colname = pg_field_name($result_kep,$i);
				$content .= "<th>".strtoupper($colname)."</th>";
			}
			$content .="</tr></thead><tbody>";

			while ($hasil_result_kep = pg_fetch_row($result_kep)) {
				$content.="<tr><td>".$hasil_result_kep[0]."</td></tr>";
			}
			$content.="<tr><td colspan='2'><a href='index.php?action=show-kepanitiaan'>Lihat Semua Kepanitiaan</a></td></tr></tbody></table></div></td><td valign='top'>
					<div class='home-panel'>
					<table cellspacing='0' cellpadding='0' align='center'>
					<thead><tr>";
			$col= pg_num_fields($result_eve);
			for($i=0;$i<$col;$i++){
				$colname = pg_field_name($result_eve,$i);
				$content .= "<th>".strtoupper($colname)."</th>";
			}
			$content .="</tr></thead><tbody>";

			while ($hasil_result_eve = pg_fetch_row($result_eve)) {
				$content.="<tr><td>".$hasil_result_eve[0]."</td></tr>";
}
			$content.="<tr><td colspan='2'><a href='index.php?action=show-event'>Lihat Semua Event</a></td></tr></tbody></table>
					</div></td></tr></table>
					</div>";	
			break;
case 'login':
			$check=pg_num_rows($result);
			if($check==0){
					$content = "Username/password salah!<br /><br /><div class='button1'><a href='index.php?action=loginform'>Kembali</a></div>";
			} else {
							$queryadmin = pg_query($conn,"select username from admin where username='$username'");
							$checkadmin= pg_num_rows($queryadmin);
							if($checkadmin > 0){
									$_SESSION['login'] = 1;
									$_SESSION['role'] = "admin";
									$_SESSION['id'] = "Admin";
									$_SESSION['uid'] = $username;
									$_SESSION['email'] = ""; 
							} else {
									$queryguest = pg_query($conn,"select n.username, email, nama from non_admin n,guest g where n.username=g.username and n.username='$username'");
									$checkguest= pg_num_rows($queryguest);
									if($checkguest > 0){
											while($infouser = pg_fetch_row($queryguest)){
												$_SESSION['login'] = 1;
												$_SESSION['role'] = "guest";
												$_SESSION['id'] = $infouser[2];
												$_SESSION['uid'] = $username;
												$_SESSION['email'] = $infouser[1];	
												} 
									} else {
											$querynonadmin = pg_query($conn,"select username,email,nama from non_admin where username='$username'");
											while($infouser = pg_fetch_row($querynonadmin)){
												$_SESSION['login'] = 1;
												$_SESSION['role'] = "civitas";
												$_SESSION['id'] = $infouser[2];
												$_SESSION['uid'] = $username;
												$_SESSION['email'] = $infouser[1];	
												}
									}
							}
			header('Location:index.php');	
			}
			break;
			
case 'show-organisasi':
			if($_SESSION){
			$role = $_SESSION['role'];
			} else{$role='non_admin';}
			if($role == "admin"){
					$content = "<div class='button-prime'><a href='index.php?action=add-organisasi'>Tambahkan Organisasi</div>";
			}
			$content.= "<table class='table table-bordered' id='dataTable' width='100%' align='left' cellspacing='0'><thead><tr><th>No</th>";
			$col= pg_num_fields($result);
			for($i=0;$i<$col-1;$i++){
					$colname = pg_field_name($result,$i);
					$content .= "<th>".$colname."</th>";
			}		
			if($role == "admin"){
						$content .= "<th>Edit</th>";
					}
			
			$content .="</tr></thead><tbody>";
			$no = 1;
			while($infouser = pg_fetch_row($result)){
					$content.="<tr><td>".$no."</td><td><a href='index.php?action=show&item=org&id=".$infouser[5]."'><u>".$infouser[0]."</u></a></td><td>".$infouser[1]."</td><td>".$infouser[2]."</td><td>".$infouser[3]."</td><td>".$infouser[4]."</td>";
			if($role == "admin"){
						$content .= "<td><a href='index.php?action=edit-organisasi&id=".$infouser[5]."'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?action=confirm-delete&item=org&id=".$infouser[5]."'>Delete</a></td></tr>";
					}
			$no+=1;
			}
			$content .="</tbody></table>";
			break;

case 'show-kepanitiaan':
			if($_SESSION){
			$role = $_SESSION['role'];
			} else{$role='non_admin';}
			if($role == "admin"){
					$content = "<div class='button-prime'><a href='index.php?action=add-kepanitiaan'>Tambahkan Kepanitiaan</div>";
			}
			$content.= "<table class='table table-bordered' id='dataTable' width='100%' align='left' cellspacing='0'><thead><tr><th>No</th>";
			$col= pg_num_fields($result);
			for($i=0;$i<$col-2;$i++){
					$colname = pg_field_name($result,$i);
					$content .= "<th>".$colname."</th>";
			}		
			if($role == "admin"){
						$content .= "<th>Edit</th>";
					}
			
			$content .="</tr></thead><tbody>";
			$no = 1;
			while($infouser = pg_fetch_row($result)){
					$content.="<tr><td>".$no."</td><td><a href='index.php?action=show&item=kep&id=".$infouser[5]."'><u>".$infouser[0]."</u></a></td><td>".$infouser[1]."</td><td>".$infouser[2]."</td><td>".$infouser[3]."</td><td>".$infouser[4]."</td>";
			if($role == "admin"){
						$content .= "<td><a href='index.php?action=edit-kepanitiaan&id_kepanitiaan=".$infouser[5]."&id_organisasi=".$infouser[6]."'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?action=confirm-delete&item=kep&id=".$infouser[5]."'>Delete</a></td></tr>";
					}
			$no+=1;
			}
			$content .="</tbody></table>";
			break;

case 'show-event':
			if($_SESSION){
			$role = $_SESSION['role'];
			} else{$role='non_admin';}
			if($role == "admin"){
					$content = "<div class='button-prime'><a href='index.php?action=add-event'>Tambahkan Event</div>";
			}
			$content.= "<table class='table table-bordered' id='dataTable' width='100%' align='left' cellspacing='0'><thead><tr><th>No</th>";
			$col= pg_num_fields($result);
			for($i=0;$i<$col-2;$i++){
					$colname = pg_field_name($result,$i);
					$content .= "<th>".$colname."</th>";
			}		
			if($role == "admin"){
						$content .= "<th>Edit</th>";
					}
			
			$content .="</tr></thead><tbody>";
			$no = 1;
			while($infouser = pg_fetch_row($result)){
					$content.="<tr><td>".$no."</td><td><a href='index.php?action=show&item=eve&id=".$infouser[5]."&id_pembuat=".$infouser[6]."'><u>".$infouser[0]."</u></a></td><td>".$infouser[1]."</td><td>".$infouser[2]."</td><td>".$infouser[3]."</td><td>".$infouser[4]."</td>";
			if($role == "admin"){
						$content .= "<td><a href='index.php?action=edit-event&id=".$infouser[5]."'>Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?action=confirm-delete&item=eve&id=".$infouser[5]."&id_pembuat=".$infouser[6]."'>Delete</a></td></tr>";
					}
			$no+=1;
			}
			$content .="</tbody></table>";
			break;
case 'edit-organisasi':
			$infouser=pg_fetch_row($result);
			$content ="<form enctype='multipart/form-data' id='edit_org_form' action='index.php?action=save-organisasi&id=".$infouser[0]."&do=update' method='POST'>
				<table class='custom-form'>
				<tr><td>Nama Organisasi<span class='asterisk'>*</span></td><td>		: </td><td><input type='text' name='nama' value='".$infouser[2]."' /><div id='nama-notif' class='notif'></div></td></tr>
				<tr><td>Tingkatan <span class='asterisk'>*</span></td><td> 	: </td><td><select name='tk'>";
				if($infouser[5]=="Universitas"){
					$content.="<option selected='selected'>Universitas</option><option>Fakultas</option>";
				} else{
					$content.="<option>Universitas</option><option selected='selected'>Fakultas</option>";
				}
			
			$content.="</select><div id='tk-notif' class='notif'></div></td></tr>
				<tr><td>Fakultas</td><td> 	: </td><td><select name='fak'><option></option><option>Fakultas Ilmu Komputer</option><option>Fakultas Hukum</option><option>Fakultas Ilmu Budaya</option><option>Fakultas Ilmu Sosial Politik</option>
				<option>Fakultas Ekonomi</option><option>Fakultas Teknik</option><option>Fakultas MIPA</option><option>Fakultas Ilmu Farmasi</option><option>Fakultas Ilmu Keperawatan</option><option>Fakultas Kesehatan Masyarakat</select>
				<div id='fak-notif' class='notif'></div></td></tr>
				<tr><td>Email <span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='email' value='".$infouser[3]."' /><div id='email-notif' class='notif'></div></td></tr>
				<tr><td>Website</td><td> 	: </td><td><input type='text' name='web' value='".$infouser[4]."' /><div id='web-notif' class='notif'></div></td></tr>
				<tr><td>Nomor Telepon CP <span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='no_telp' value='".$infouser[9]."'/><div id='no_telp-notif' class='notif'></div></td></tr>
				<tr><td>Kategori <span class='asterisk'>*</span></td><td> : </td><td><select name='cat'>";
				$querycat = pg_query('select kategori from pembuat_event group by kategori');
				while($cat_result = pg_fetch_row($querycat)){
					if($infouser[6]==$cat_result[0]){
					$content.="<option selected='selected' value='".$cat_result[0]."'>".$cat_result[0]."</option>";
					} else{
						$content.="<option value='".$cat_result[0]."'>".$cat_result[0]."</option>";
					}
				}
			$content.="</select><div id='cat-notif' class='notif'></div></td></tr>
				<tr><td>Logo</td><td>: </td><td><input type='file' name='logo' value='".$infouser[7]."' /><div id='logo-notif' class='notif'></div></td></tr>
				<tr><td>Deskripsi <span class='asterisk'>*</span></td><td> : </td><td><textarea name='deskripsi'>".$infouser[8]."</textarea><div id='desc-notif' class='notif'></div></td></tr>
				<tr><td align='left'><span class='asterisk'>* wajib diisi</span></td><td></td><td align='right'><input type='submit' id='edit-org' value='Tambahkan' /></td></tr>
				</table>
				</form><div class='button1'><a href='index.php?action=show-organisasi'>Kembali</a></div>"; 
			break;
case 'edit-kepanitiaan':
			$infouser=pg_fetch_row($result);
			$content ="<form enctype='multipart/form-data' id='edit_kep_form' action='index.php?action=save-kepanitiaan&id_kep=".$infouser[0]."&do=update' method='POST'>
				<table class='custom-form'>
				<tr><td>Nama Kepanitiaan<span class='asterisk'>*</span></td><td>		: </td><td><input type='text' name='nama' value='".$infouser[3]."' /><div id='nama-notif' class='notif'></div></td></tr>
<tr><td>Tingkatan<span class='asterisk'>*</span></td><td>: </td><td id='select_tk'><select name='tk'>";
				$querycat = pg_query('select tingkatan from organisasi,pembuat_event where id=id_organisasi group by tingkatan');
				while($cat_result = pg_fetch_row($querycat)){
					if($cat_result[0]== $infouser[6]){
						$content .="<option selected='selected' value='".$cat_result[0]."'>".$cat_result[0]."</option>";	
					} else {
						
					$content .="<option value='".$cat_result[0]."'>".$cat_result[0]."</option>";
				}
				}
$content .= "</select><div id='tk-notif' class='notif'></div></td></tr>
				<tr><td>Organisasi Asal</td><td>		: </td><td><input type='hidden' name='org' value='".$id_org."' /><select id='select_org' name='select_org'>";
$content .= "</select><div id='nama-notif' class='notif'></div></td></tr>
				<tr><td>Email <span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='email' value='".$infouser[4]."' /><div id='email-notif' class='notif'></div></td></tr>
				<tr><td>Website</td><td> 	: </td><td><input type='text' name='web' value='".$infouser[5]."' /><div id='web-notif' class='notif'></div></td></tr>
				<tr><td>Nomor Telepon CP <span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='no_telp' value='".$infouser[10]."'/><div id='no_telp-notif' class='notif'></div></td></tr>
				<tr><td>Kategori <span class='asterisk'>*</span></td><td> : </td><td><select name='cat'>";
				$querycat = pg_query('select kategori from pembuat_event group by kategori');
				while($cat_result = pg_fetch_row($querycat)){
					if($infouser[7]==$cat_result[0]){
					$content.="<option selected='selected' value='".$cat_result[0]."'>".$cat_result[0]."</option>";
					} else{
						$content.="<option value='".$cat_result[0]."'>".$cat_result[0]."</option>";
					}
				}
			$content.="</select><div id='cat-notif' class='notif'></div></td></tr>
				<tr><td>Logo</td><td>: </td><td><input type='file' name='logo' value='".$infouser[8]."' /><div id='logo-notif' class='notif'></div></td></tr>
				<tr><td>Deskripsi <span class='asterisk'>*</span></td><td> : </td><td><textarea name='deskripsi'>".$infouser[9]."</textarea><div id='deskripsi-notif' class='notif'></div></td></tr>
				<tr><td align='left'><span class='asterisk'>* wajib diisi</span></td><td></td><td align='right'><input type='submit' id='edit-kep' value='Tambahkan' /></td></tr>
				</table>
				</form><div class='button1'><a href='index.php?action=show-kepanitiaan'>Kembali</a></div>"; 
			break;
case 'edit-event':
			$infouser=pg_fetch_row($result);
			$edit_event_form = "<form id='add_eve_form' action='index.php?action=save-event&do=update&id=".$infouser[0]."' method='POST'>
				<table class='custom-form'>
				<tr><td>Nama Event<span class='asterisk'>*</span></td><td>		: </td><td><input type='text' name='nama' value='".$infouser[2]."' /><div id='event-notif' class='notif'></div></td></tr>
				<tr><td>Organisasi <span class='asterisk'>*</span></td><td> 	: </td><td>";
				//<tr><td>Organisasi <span class='asterisk'>*</span></td><td> 	: </td><td><select id='org' name='org'>;
				$is_kep = pg_num_rows(pg_query("select * from kepanitiaan where id_kepanitiaan='$infouser[1]'"));
				$id_pembuat = pg_fetch_row(pg_query("select distinct * from pembuat_event where id='$infouser[1]'"));
				//if($is_kep==0){
				//$querycat = pg_query('select id,nama from organisasi,pembuat_event where id=id_organisasi group by id');
				//while($cat_result = pg_fetch_row($querycat)){
				//	if($cat_result[0]==$infouser[1]){
						//$edit_event_form .="<option selected='selected' value='".$cat_result[0]."'>".$cat_result[1]."</option>";
					
				//	} 
					//else{
					//$edit_event_form .="<option value='".$cat_result[0]."'>".$cat_result[1]."</option>";
					//}
				//}
				//} else{
				//	$kep_id = pg_fetch_row(pg_query("select * from kepanitiaan where id_kepanitiaan='$infouser[1]'"));
				//	$querycat = pg_query('select id,nama from organisasi,pembuat_event where id=id_organisasi group by id');
				//while($cat_result = pg_fetch_row($querycat)){
				//	if($kep_id[1]==$cat_result[0]){
					//	$edit_event_form .="<option selected='selected' value='".$cat_result[0]."'>".$cat_result[1]."</option>";
					//} else{
					//$edit_event_form .="<option value='".$cat_result[0]."'>".$cat_result[1]."</option>";
					//}
			//	}
				//}
				if($is_kep==0){
					$kep_is="-";
					$org_is=$id_pembuat[1];
				} else{
					$is_org = pg_fetch_row(pg_query("select * from kepanitiaan where id_kepanitiaan='$infouser[1]'"));
					$id_org = pg_fetch_row(pg_query("select distinct * from pembuat_event where id='$is_org[1]'"));
					$kep_is=$id_pembuat[1];
					$org_is=$id_org[1];
					
				}
				//</select>
$edit_event_form .= $org_is."<div id='org-notif' class='notif'></div><input type='hidden' id='id_pembuat' name='id_pembuat' value='".$infouser[1]."' /></td></tr>
				<tr><td>Kepanitiaan</td><td> 	: </td><td>";
				//<tr><td>Kepanitiaan</td><td> 	: </td><td><select id='kep' name='kep'><option></option>";
				$extract=explode(' ',$infouser[4]);
				$tgldmy = explode('-',$extract[0]);
$edit_event_form .= $kep_is."<div id='kep-notif' class='notif'></div></td></tr>
				<tr><td>Tanggal<span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='tgl' id='datepicker' value='".$tgldmy[2]."-".$tgldmy[1]."-".$tgldmy[0]."' /><div id='no_telp_cp-notif' class='notif'></div></td></tr>
				<tr><td>Waktu <span class='asterisk'>*</span></td><td> : </td><td><select name='jam'>";
				$jam = explode(':',$extract[1]);
				for($i=0;$i<24;$i++){
					if(strlen($i)==1){
						if("0".$i==$jam[0]){
							$edit_event_form .="<option selected='selected'>0".$i."</option>";
						} else{
						$edit_event_form .="<option>0".$i."</option>";
						}
					} else{
						if($i==$jam[0]){
							$edit_event_form .="<option selected='selected'>".$i."</option>";
						} else{
						$edit_event_form .="<option>".$i."</option>";
						}
					}
				}
$edit_event_form	.="</select>:<select name='menit'>";
				for($j=0;$j<60;$j++){
					if(strlen($j)==1){
						if("0".$j==$jam[1]){
							$edit_event_form .="<option selected='selected'>0".$j."</option>";
						} else{
						$edit_event_form .="<option>0".$j."</option>";
						}
					} else{
						if($j==$jam[0]){
							$edit_event_form .="<option selected='selected'>".$j."</option>";
						} else{
						$edit_event_form .="<option>".$j."</option>";
						}
					}
				}
$edit_event_form .="</select><div id='waktu-notif' class='notif'></div></td></tr>
				<tr><td>Kapasitas <span class='asterisk'>*</span></td><td>: </td><td><input type='text' name='kap' value='".$infouser[5]."' /><div id='kap-notif' class='notif'></div></td></tr>
				<tr><td>Harga Tiket</td><td>: </td><td><input type='text' name='tiket'  value='".$infouser[6]."' /><div id='tiket-notif' class='notif'></div></td></tr>
				<tr><td>Lokasi <span class='asterisk'>*</span></td><td>: </td><td><input type='text' name='lokasi' value='".$infouser[7]."' /><div id='lokasi-notif' class='notif'></div></td></tr>
				<tr><td>Sifat Event <span class='asterisk'>*</span></td><td>: </td><td><select name='sifat'>";
				if($infouser[8]=='Umum'){
					$edit_event_form .= "<option selected='selected'>Umum</option><option>Privat</option>";
				} else{
					$edit_event_form .= "<option>Umum</option><option selected='selected'>Privat</option>";
				}
$edit_event_form .= "</select><div id='sifat-notif' class='notif'></div></td></tr>
				<tr><td>Kategori Event <span class='asterisk'>*</span></td><td>: </td><td><select name='cat'>";
					$querycat = pg_query('select * from kategori_event');
				while($cat_result = pg_fetch_row($querycat)){
					if($infouser[10]==$cat_result[0]){
					$edit_event_form .="<option selected='selected' value='".$cat_result[0]."'>".$cat_result[1]."</option>";
					} else{
						$edit_event_form .="<option value='".$cat_result[0]."'>".$cat_result[1]."</option>";
					}
				}
$edit_event_form .="</select><div id='cat-notif' class='notif'></div></td></tr>
				<tr><td>Poster <span class='asterisk'>*</span></td><td>: </td><td><input type='file' name='poster' id='poster' /><div id='poster-notif' class='notif'></div></td></tr>
				<tr><td>Deskripsi <span class='asterisk'>*</span></td><td> : </td><td><textarea name='deskripsi'>".$infouser[9]."</textarea><div id='deskripsi-notif' class='notif'></div></td></tr>
				<tr><td align='left'><span class='asterisk'>* wajib diisi</span></td><td></td><td align='right'><input type='button' id='add_eve_btn' value='Tambahkan' /></td></tr>
				</table>
				</form><div class='button1'><a href='index.php?action=show-event'>Kembali</a></div>";
}


//----------------INTERFACE ELEMENTS--------------------//
switch($action){
case 'loginform':
$loginform = "<form action=index.php?action=login method='POST'>
				<table class='custom-form custom-form-no-border'>
				<tr><td>Username</td><td> : </td><td><input type='text' name='user' /><div id='user-notif' class='notif'></div></td></tr>
				<tr><td>Password</td><td> : </td><td><input type='password' name='pass' /><div id='pass-notif' class='notif'></td></div></tr>
				<tr><td></td><td></td><td><input type='submit' value='LOGIN' /></td></tr>
				</table></form>";
				break;
case 'add-organisasi':
$add_organisasi_form = "<form enctype='multipart/form-data' id='add_org_form' action='index.php?action=save-organisasi&do=add' method='POST'>
				<table class='custom-form'>
				<tr><td>Nama Organisasi<span class='asterisk'>*</span></td><td>		: </td><td><input type='text' name='nama' /><div id='nama-notif' class='notif'></div></td></tr>
				<tr><td>Tingkatan<span class='asterisk'>*</span></td><td> 	: </td><td><select name='tk'><option>Universitas</option><option>Fakultas</option></select><div id='tk-notif' class='notif'></div></td></tr>
				<tr><td>Fakultas</td><td> 	: </td><td><select name='fak'><option></option><option>Fakultas Ilmu Komputer</option><option>Fakultas Hukum</option><option>Fakultas Ilmu Budaya</option><option>Fakultas Ilmu Sosial Politik</option>
				<option>Fakultas Ekonomi</option><option>Fakultas Teknik</option><option>Fakultas MIPA</option><option>Fakultas Ilmu Farmasi</option><option>Fakultas Ilmu Keperawatan</option><option>Fakultas Kesehatan Masyarakat</select>
				<div id='fak-notif' class='notif'></div></td></tr>
				<tr><td>Email <span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='email' /><div id='email-notif' class='notif'></div></td></tr>
				<tr><td>Website</td><td> 	: </td><td><input type='text' name='web' /><div id='web-notif' class='notif'></div></td></tr>
				<tr><td>Nomor Telepon CP <span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='no_telp' /><div id='no_telp-notif' class='notif'></div></td></tr>
				<tr><td>Kategori <span class='asterisk'>*</span></td><td> : </td><td><select name='cat'>";
				$querycat = pg_query('select kategori from pembuat_event group by kategori');
				while($cat_result = pg_fetch_row($querycat)){
					$add_organisasi_form .="<option value='".$cat_result[0]."'>".$cat_result[0]."</option>";
				}
				$add_organisasi_form .="</select><div id='cat-notif' class='notif'></div></td></tr>
				<tr><td>Logo</td><td>: </td><td><input type='file' name='logo' /><div id='logo-notif' class='notif'></div></td></tr>
				<tr><td>Deskripsi <span class='asterisk'>*</span></td><td> : </td><td><textarea name='deskripsi'></textarea><div id='deskripsi-notif' class='notif'></div></td></tr>
				<tr><td align='left'><span class='asterisk'>* wajib diisi</span></td><td></td><td align='right'><input type='submit' id='add-org' value='Tambahkan' /></td></tr>
				</table>
				</form><div class='button1'><a href='index.php?action=show-organisasi'>Kembali</a></div>";
				break;
case 'add-kepanitiaan':
$add_kepanitiaan_form = "<form enctype='multipart/form-data' id='add_kep_form' action='index.php?action=save-kepanitiaan&do=add' method='POST'>
				<table class='custom-form'>
				<tr><td>Nama Kepanitiaan<span class='asterisk'>*</span></td><td>: </td><td><input type='text' name='nama' /><div id='nama-notif' class='notif'></div></td></tr>
				<tr><td>Tingkatan<span class='asterisk'>*</span></td><td>: </td><td id='select_tk'><select name='tk'>";
				$querycat = pg_query('select tingkatan from organisasi,pembuat_event where id=id_organisasi group by tingkatan');
				while($cat_result = pg_fetch_row($querycat)){
					$add_kepanitiaan_form .="<option value='".$cat_result[0]."'>".$cat_result[0]."</option>";
				}
$add_kepanitiaan_form .= "</select><div id='tk-notif' class='notif'></div></td></tr>
				<tr><td>Organisasi Asal</td><td>		: </td><td id='orgy'><select id='select_org' name='org'>";
$add_kepanitiaan_form .= "</select><div id='nama-notif' class='notif'></div></td></tr>
				<tr><td>Email <span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='email' /><div id='email-notif' class='notif'></div></td></tr>
				<tr><td>Website </td><td> 	: </td><td><input type='text' name='web' /><div id='web-notif' class='notif'></div></td></tr>
				<tr><td>Nomor Telepon CP<span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='no_telp' /><div id='no_telp-notif' class='notif'></div></td></tr>
				<tr><td>Kategori <span class='asterisk'>*</span></td><td> : </td><td><select name='cat'>";
				$querycat = pg_query('select kategori from pembuat_event group by kategori');
				while($cat_result = pg_fetch_row($querycat)){
					$add_kepanitiaan_form .="<option value='".$cat_result[0]."'>".$cat_result[0]."</option>";
				}
$add_kepanitiaan_form .= "</select><div id='cat-notif' class='notif'></div></td></tr>
				<tr><td>Logo</td><td>: </td><td><input type='file' name='poster' /><div id='logo-notif' class='notif'></div></td></tr>
				<tr><td>Deskripsi <span class='asterisk'>*</span></td><td> : </td><td><textarea name='deskripsi'></textarea><div id='desc-notif' class='notif'></div></td></tr>
				<tr><td align='left'><span class='asterisk'>* wajib diisi</span></td><td></td><td align='right'><input type='submit' id='add-pan' value='Tambahkan' /></td></tr>
				</table>
				</form><div class='button1'><a href='index.php?action=show-kepanitiaan'>Kembali</a></div>";
				break;
case 'add-event':
$add_event_form = "<form enctype='multipart/form-data' id='add_eve_form' action='index.php?action=save-event&do=add' method='POST'>
				<table class='custom-form'>
				<tr><td>Nama Event<span class='asterisk'>*</span></td><td>		: </td><td><input type='text' name='nama' /><div id='nama-notif' class='notif'></div></td></tr>
				<tr><td>Organisasi <span class='asterisk'>*</span></td><td> 	: </td><td><select id='org' name='org'>";
				$querycat = pg_query('select id,nama from organisasi,pembuat_event where id=id_organisasi group by id');
				while($cat_result = pg_fetch_row($querycat)){
					$add_event_form .="<option value='".$cat_result[0]."'>".$cat_result[1]."</option>";
				}
$add_event_form .= "</select><div id='org-notif' class='notif'></div></td></tr>
				<tr><td>Kepanitiaan</td><td> 	: </td><td><select id='kep' name='kep'><option></option>";
$add_event_form .="</select><div id='kep-notif' class='notif'></div></td></tr>
				<tr><td>Tanggal<span class='asterisk'>*</span></td><td> 	: </td><td><input type='text' name='tgl' id='datepicker' /><div id='tgl-notif' class='notif'></div></td></tr>
				<tr><td>Waktu <span class='asterisk'>*</span></td><td> : </td><td><select name='jam'>";
				for($i=0;$i<24;$i++){
					if(strlen($i)==1){
						$add_event_form .="<option>0".$i."</option>";
					} else{
						$add_event_form .="<option>".$i."</option>";
					}
				}
$add_event_form	.="</select>:<select name='menit'>";
				for($j=0;$j<60;$j++){
					if(strlen($j)==1){
						$add_event_form .="<option>0".$j."</option>";
					} else{
						$add_event_form .="<option>".$j."</option>";
					}
				}
$add_event_form .="</select><div id='waktu-notif' class='notif'></div></td></tr>
				<tr><td>Kapasitas <span class='asterisk'>*</span></td><td>: </td><td><input type='text' name='kap' /><div id='kap-notif' class='notif'></div></td></tr>
				<tr><td>Harga Tiket</td><td>: </td><td><input type='text' name='tiket' /><div id='tiket-notif' class='notif'></div></td></tr>
				<tr><td>Lokasi <span class='asterisk'>*</span></td><td>: </td><td><input type='text' name='lokasi' /><div id='lokasi-notif' class='notif'></div></td></tr>
				<tr><td>Sifat Event <span class='asterisk'>*</span></td><td>: </td><td><select name='sifat'><option>Umum</option><option>Privat</option></select><div id='sifat-notif' class='notif'></div></td></tr>
				<tr><td>Kategori Event <span class='asterisk'>*</span></td><td>: </td><td><select name='cat'>";
					$querycat = pg_query('select * from kategori_event');
				while($cat_result = pg_fetch_row($querycat)){
					$add_event_form .="<option value='".$cat_result[0]."'>".$cat_result[1]."</option>";
				}
$add_event_form .="</select><div id='cat-notif' class='notif'></div></td></tr>
				<tr><td>Poster <span class='asterisk'>*</span></td><td>: </td><td><input type='file' name='poster' id='poster' /><div id='poster-notif' class='notif'></div></td></tr>
				<tr><td>Deskripsi <span class='asterisk'>*</span></td><td> : </td><td><textarea name='deskripsi'></textarea><div id='deskripsi-notif' class='notif'></div></td></tr>
				<tr><td align='left'><span class='asterisk'>* wajib diisi</span></td><td></td><td align='right'><input type='button' id='add_eve_btn' value='Tambahkan' /></td></tr>
				</table>
				</form><div class='button1'><a href='index.php?action=show-event'>Kembali</a></div>";
break;
case 'show':
			$hasil = pg_fetch_row($result);
			if($item=="eve"){
				$waktu = explode(" ",$hasil[4]);
				$jam = explode(":",$waktu[1]);
				$show="<div class='item-wrapper'>
			<font size='5'><b>".$hasil[2]."</b></font><br /><br /><table cellspacing='0' cellpadding='0'>
			<tr><td>Tanggal</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[3]."</td></tr>
			<tr><td>Waktu</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$jam[0].":".$jam[1]."</td></tr>
			<tr><td>Kapasitas</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[5]."</td></tr>
			<tr><td>Harga Tiket</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[6]."</td></tr>
			<tr><td>Lokasi</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[7]."</td></tr>
			<tr><td>Sifat</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[8]."</td></tr>
			<tr><td>Jumlah Pendaftar</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[11]."</td></tr>";
			$querycat = pg_fetch_row(pg_query("select nama from kategori_event where nomor='$hasil[10]'"));
			$show.="<tr><td>Kategori</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$querycat[0]."</td></tr>
			<tr><td>Pengisi Acara</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>";
			$querypa = pg_query("select nama_pengisi_acara from pengisi_acara where id_event='$id' and id_pembuat_event='$hasil[1]'");
			while($hasilpa=pg_fetch_row($querypa)){
				$show.=$hasilpa[0]."<br />";
			}
			$show .="</td></tr><tr><td colspan='3'><br /><b>Deskripsi:</b><br />".$hasil[9]."</td></tr></table>
			<br /><br />
			</div><a href='index.php?action=show-".$back."'>Kembali</a></div>";
			} else{
			$show="<div class='item-wrapper'>
			<img src='".$hasil[6]."' width='50' height='50' />
			<font size='5'><b>".$hasil[1]."</b></font><br /><br /><table cellspacing='0' cellpadding='0'>
			<tr><td>Email</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[2]."</td></tr>
			<tr><td>Website</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td><a href='http://".$hasil[3]."'>".$hasil[3]."</a></td></tr>
			<tr><td>Tingkatan</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[4]."</td></tr>";
			if($item=="kep"){
				$q = pg_fetch_row(pg_query("select nama from pembuat_event where id='$hasil[10]'"));
				$show .="<tr><td>Organisasi asal</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$q[0]."</td></tr>";
			}
			$show .="<tr><td>Kategori</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[5]."</td></tr>
			<tr><td>Contact Person</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;</td><td>".$hasil[8]."</td></tr>
			<tr><td colspan='3'><br /><b>Deskripsi:</b><br />".$hasil[7]."</td></tr>
			</table>
			<br /><br />
			</div><a href='index.php?action=show-".$back."'>Kembali</a></div>";
			}
			
			
			break;	
				
}			
//-------------------BUILD INTERFACE-------------------//
switch($action){
case 'home':
				$title = "Home";
				break;
case 'login':
				$title = "Login";
				break;
case 'show-organisasi':
				$title = "Organisasi";
				break;
case 'loginform':
				$content=$loginform;
				$title = "Login";
				break;
case 'show-kepanitiaan':
				$title = "Kepanitiaan";
				break;
case 'show-event':
				$title = "Event";
				break;
case 'add-organisasi':
				$title = "Tambahkan Organisasi";
				$content=$add_organisasi_form;
				break;
case 'add-kepanitiaan':
				$title = "Tambahkan Kepanitiaan";
				$content=$add_kepanitiaan_form;
				break;
case 'add-event':
				$title = "Tambahkan Event";
				$content=$add_event_form;
				break;
case 'logout':
				session_destroy();
				header('Location:index.php');
				break;
case 'edit-organisasi':
				$title = "Ubah Data Organisasi";
				break;
case 'edit-kepanitiaan':
				$title = "Ubah Data Kepanitiaan";
				break;
case 'save-organisasi':
				$title="Simpan Organisasi";
				$content = "Organisasi berhasil disimpan.<br /><br /><div class='button1'><a href='index.php?action=show-organisasi'>Kembali</a></div>";
				break;
case 'save-kepanitiaan':
				$title="Simpan Kepanitiaan";
				$content = "Kepanitiaan berhasil disimpan.<br /><br /><div class='button1'><a href='index.php?action=show-kepanitiaan'>Kembali</a></div>";
				break;
case 'save-event':
				$title="Simpan Event";
				$content = "Event berhasil disimpan.<br /><br /><div class='button1'><a href='index.php?action=show-event'>Kembali</a></div>";
				break;
case 'edit-event':
				$title = "Ubah Data Event";
				$content = $edit_event_form;
				break;
case 'confirm-delete':
				$title="Konfirmasi Penghapusan";
				switch($item){
					case 'org':
						$back = 'organisasi';
					break;
					case 'kep':
						$back = 'kepanitiaan';
					break;
					case 'eve':
					$back = 'event';
					break;
				}
				$content = "Apakah benar akan menghapus item ini?<br /><br /><div class='button1'><a href='index.php?action=delete&item=".$item."&id=".$id."&id_pembuat=".$id_pembuat."'>Hapus</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='index.php?action=show-".$back."'>Kembali</a></div>";
				break;
case 'delete':
				$title="Hapus Item";
				switch($item){
					case 'org':
						$back = 'organisasi';
					break;
					case 'kep':
						$back = 'kepanitiaan';
					break;
					case 'eve':
					$back = 'event';
					break;
				}
				$content = "Item berhasil dihapus.<br /><br /><div class='button1'><a href='index.php?action=show-".$back."'>Kembali</a></div>";
				break;
case 'show':
			switch($item){
				case 'org':
				$title="Detail Organisasi";
				break;
				case 'kep':
				$title="Detail Kepanitiaan";
				break;
				case 'eve':
				$title="Detail Event";
				break;
			}
				$content = $show;

			break;	
}
  ?>
  
	<div class="container-fluid">
  <!-- Data Table -->
  <div class="card mb-3" id="pages">
    <div class="card-header">
      <i class="fa fa-table"></i> <b><?php echo $title; ?></b>
    </div>
    <div class="card-body">
      <div class="table-responsive">
       
			<?php echo $content; ?>
      

      </div>	  
	  
    </div>
    <div class="card-footer small text-muted"></div>
  </div>
</div>
