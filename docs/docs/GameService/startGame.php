<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	Rasgele bir rakiple oyun oynamak için veya belirli bir rakiple oynamak için kullanılır. Belirli bir rakiple oynamak için usid alanı doldurulmalıdır.
</p>

<p>
<pre>/<?=$_GET['service']?>?data={"method": "<?=$_GET['method']?>",
	"usid": "info@avarekodcu.com",
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
		<td>usid (isteğe bağlı)</td>
		<td>Rakip kullanıcının idsi bu alan girilmediği zaman rasgele kullanıcı ile oyun oynar</td>
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
	<tr>
		<td>qid</td>
		<td>Oyunun unique idsi</td>
	</tr>
	<tr>
		<td>rival</td>
		<td>Rakip kullanıcının idsi</td>
	</tr>
</table>
<!-- örnek cevap -->
<h3>Gelen Örnek Cevap</h3>
<p>
<pre>{
	gid: "7fd1769442fa28fe442927b25d95b862",
	rival: "info@rivalkodcu.com"
}</pre>
</p>