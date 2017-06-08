<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	Kullanıcı profil ayarlarını güncelleyeceği service, kullancı şifre güncellemek istiyorsa sadece şifre değişikliği yapabilir
	Diğer ayarları yapması için şifre göndermemesi yeterli. Güvenlik kontrolü için yapıldı
</p>

<p>
<pre>/<?=$_GET['service']?>?data={"method": "<?=$_GET['method']?>",
	"file": "multipart/form-data",
	"usname": "Abdurrahman",
	"surname": "Eker",
	"usmail": "info@avarekodcu.com",
	"birth": "10-09-1996",
	"password": "EkerAvareP^'!:",
	"newpassword": "kodabugele",
	"session_ticket": "QWJkdXJyYWhtYW4gZWtlcg=="
}</pre>
</p>
<h3>Giden Parametre</h3>
<!-- parametre detayları -->
<table class="dev-table">
	<tr>
		<th>Parametre</th>
		<th>Açıklama</th>
	</tr>
	<tr>
		<td>file</td>
		<td>Kullanıcının profile resmi</td>
	</tr>
	<tr>
		<td>usname</td>
		<td>Kullanıcının kendi adı</td>
	</tr>
	<tr>
		<td>surname</td>
		<td>Kullanıcının soyadı</td>
	</tr>
	<tr>
		<td>usmail</td>
		<td>Kullanıcı email'i eğer değiştirmek istediği emailden varsa başarısız olur</td>
	</tr>
	<tr>
		<td>birth</td>
		<td>Kullanıcı doğum tarihi</td>
	</tr>
	<tr>
		<td>password</td>
		<td>Kullanıcı şifresi</td>
	</tr>
	<tr>
		<td>newpassword</td>
		<td>Kullanıcı yeni şifresi</td>
	</tr>
	<tr>
		<td>session_ticket</td>
		<td>Kullancının bu methodu kullanabilmesi için gerekli oturum numarası</td>
	</tr>
</table>

<!-- cevap parametreleri -->
<h3>Gelen Cevap</h3>
<table class="dev-table">
	<tr>
		<th>Parametre</th>
		<th>Açıklama</th>
	</tr>
</table>
<!-- örnek cevap -->
<h3>Gelen Örnek Cevap</h3>
<p>
<pre>1</pre>
</p>
