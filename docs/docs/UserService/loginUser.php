<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	Kullanının girişini yaptıktan sonra oturum numarasını veren service
</p>

<p>
<pre>/<?=$_GET['service']?>?data={"method": "<?=$_GET['method']?>",
	"usname": "avarekodcu",
	"password": "AvareKodcu::!!ÜÜ"
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
		<td>usname</td>
		<td>Kullanıcı adı veya maili</td>
	</tr>
	<tr>
		<td>password</td>
		<td>Kullancının şifresi</td>
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
		<td>username</td>
		<td>Kullanıcı adının doğru olup olmadığı (-1, 1)</td>
	</tr>
	<tr>
		<td>password</td>
		<td>Şifrenin doğru olup olmadığı (-1, 1)</td>
	</tr>
	<tr>
		<td>session_ticket</td>
		<td>Şifre ve Kullanıcı adı doğru ise dönecek oturum numarası (null, ?)</td>
	</tr>
</table>
<!-- örnek cevap -->
<h3>Gelen Örnek Cevap</h3>
<p>
<pre>{
	"username": "1",
	"password": "1",
	"session_ticket": "QWJkdXJyYWhtYW4gZWtlcg=="
}</pre>
</p>