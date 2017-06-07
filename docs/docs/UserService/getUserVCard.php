<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	Bir kullanıcının basit ve sade bir biçimde bilgilerini getiren method, eğer bu methodu çağıran kişi kendisi ise özel bilgilerini de getirir
</p>

<p>
<pre>/<?=$_GET['service']?>?data={"method": "<?=$_GET['method']?>",
	"usid": "avarekodcu",
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
		<td>usid</td>
		<td>Kullanıcı adı veya maili</td>
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
		<td>copo</td>
		<td>coins_point (para puanı)</td>
	</tr>
	<tr>
		<td>hepo</td>
		<td>heart_point (can puanı)</td>
	</tr>
	<tr>
		<td>bugpo</td>
		<td>heart_point (böcek puanı)</td>
	</tr>
	<tr>
		<td>fipo</td>
		<td>fire_point (ateş puanı)</td>
	</tr>
	<tr>
		<td>keypo</td>
		<td>key_point (ipucu puanı)</td>
	</tr>
	<tr>
		<td>usname</td>
		<td>user_name (kullanıcı adı)</td>
	</tr>
	<tr>
		<td>surname</td>
		<td>kullanıcı soyismi</td>
	</tr>
	<tr>
		<td>uspoint</td>
		<td>user_point (kullanıcı puanı)</td>
	</tr>
	<tr>
		<td>photo</td>
		<td>Kullanıcının base64 resmi</td>
	</tr>
	<tr>
		<td>usmail (gizli)</td>
		<td>kullanıcının mail adresi</td>
	</tr>
	<tr>
		<td>birth (gizli)</td>
		<td>kullanıcının doğum günü</td>
	</tr>
</table>
<!-- örnek cevap -->
<h3>Gelen Örnek Cevap</h3>
<p>
<pre>{
	copo: "0",
	hepo: "0",
	bugpo: "0",
	fipo: "0",
	keypo: "0",
	usname: "Abdurrahman",
	surname: "Eker",
	uspoint: "0",
	photo: ""
}

eğer kendisi çağırmışsa:

{
	copo: "0",
	hepo: "0",
	bugpo: "0",
	fipo: "0",
	keypo: "0",
	usname: "Abdurrahman",
	surname: "Eker",
	uspoint: "0",
	photo: "",
	birth: "10-0-1996",
	usmail: "info@avarekodcu.com"

}
</pre>
</p>
