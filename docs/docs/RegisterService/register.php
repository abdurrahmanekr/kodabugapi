<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	Bir kullanıcıyı kayıt eden service
</p>

<p>
<pre>/<?=$_GET['service']?>?data={"method": "<?=$_GET['method']?>",
	"usname": "Abdurrahman",
	"surname": "Eker",
	"usmail": "info@avarekodcu.com",
	"password": "AvareAvareÇÇ::",
	"birth": "10-09-1996"
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
		<td>username</td>
		<td>Kullanıcının kendi adı</td>
	</tr>
	<tr>
		<td>surname</td>
		<td>Kullanıcının soyadı</td>
	</tr>
	<tr>
		<td>usmail</td>
		<td>Kullanıcı email daha önce alınmamış olması gerekir</td>
	</tr>
	<tr>
		<td>password</td>
		<td>Kullanıcının şifresi</td>
	</tr>
	<tr>
		<td>birth</td>
		<td>Kullanıcının doğum tarihi</td>
	</tr>
</table>

<!-- cevap parametreleri -->
<h3>Gelen Cevap</h3>
<table class="dev-table">
	<tr>
		<th>Parametre</th>
		<th>Açıklama</th>
	</tr>
	<tr>
		<td>exist</td>
		<td>Bu email'in daha önce alınıp alınmadığını belirtir. Eğer alınmışsa kayıt başarılı olmaz (0, 1)</td>
	</tr>
	<tr>
		<td>session_ticket</td>
		<td>Yeni kullanıcının ilk oturum numarası</td>
	</tr>
</table>
<!-- örnek cevap -->
<h3>Gelen Örnek Cevap</h3>
<p>
<pre>{
	"exist": "0",
	"session_ticket": "QWJkdXJyYWhtYW4gZWtlcg=="
}</pre>
</p>