<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	Kuyruktaki bekleyen oyunu getirir
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
		<td>question</td>
		<td>İstenilen oyunun değerleri</td>
	</tr>
	<tr>
		<td>qid</td>
		<td>Oyunun unique idsi</td>
	</tr>
	<tr>
		<td>qusid</td>
		<td>Oyunu oluşturan kullanıcı idsi</td>
	</tr>
	<tr>
		<td>qname</td>
		<td>Oyunun başlığı</td>
	</tr>
	<tr>
		<td>qtype</td>
		<td>Sorunun tipi</td>
	</tr>
	<tr>
		<td>qoption</td>
		<td>Sorunun şıkları</td>
	</tr>
</table>
<!-- örnek cevap -->
<h3>Gelen Örnek Cevap</h3>
<p>
<pre>{
	"qid" : "1",
	"qusid" : "avarekodcu",
	"qname" : "var değişken tanımlamada kullanılan ifadenin gerçek anlamı nedir ?",
	"qtype" : "Text",
	"qoption" : "['variable','varable', 'value', 'vatikan']",
}</pre>
</p>