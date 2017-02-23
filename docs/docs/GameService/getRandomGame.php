<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	Oyun oynamak için kuyruğa oyun atar, yaklaşık 20 saniyelik bir içinde cevaplanması gerekir. Aksi taktirde oyuncu kaybetmiş sayılır
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
</table>
<!-- örnek cevap -->
<h3>Gelen Örnek Cevap</h3>
<p>
<pre>1</pre>
</p>