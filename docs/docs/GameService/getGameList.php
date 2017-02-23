<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	O kullanıcının oynamış olduğu oyunların listesini getirir
</p>

<p>
<pre>/<?=$_GET['service']?>?data={"method": "<?=$_GET['method']?>",
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
		<td>gid</td>
		<td>Oyunun unique idsi</td>
	</tr>
	<tr>
		<td>gusid</td>
		<td>Oyunu başlatan kullanıcı</td>
	</tr>
	<tr>
		<td>grivalid</td>
		<td>Oyunun rakip kullanıcısı</td>
	</tr>
	<tr>
		<td>uspoint</td>
		<td>Başlatan kullanıcının puanı</td>
	</tr>
	<tr>
		<td>rivalpoint</td>
		<td>Rakip kullanıcının puanı</td>
	</tr>
	<tr>
		<td>gmaxpoint</td>
		<td>Oyunu bitirme puanı</td>
	</tr>
</table>
<!-- örnek cevap -->
<h3>Gelen Örnek Cevap</h3>
<p>
<pre>[
	{
		"gid" : "1",
		"gusid" : "avarekodcu",
		"grivalid" : "rivalkodcu",
		"uspoint" : "65536",
		"rivalpoint" : "4",
		"gmaxpoint" : "5"
	},
	{
		"gid" : "2",
		"gusid" : "rivalkodcu",
		"grivalid" : "avarekodcu",
		"uspoint" : "1024",
		"rivalpoint" : "1",
		"gmaxpoint" : "3"
	},
	.
	.
	.
]</pre>
</p>