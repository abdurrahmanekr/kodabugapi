<p><a href="#"><?=$_GET['service']?></a> / <?=$_GET['method']?></p>

<p class="description-method">
	Kodabug'a yeni bir oyun kaydetmek için kullanılır
</p>

<p>
<pre>/<?=$_GET['service']?>?data={"method": "<?=$_GET['method']?>",
	"question_name": "var değişken tanımlamada kullanılan ifadenin gerçek anlamı nedir ?",
	"question_type": "Text",
	"question_option": "['variable','varable', 'value', 'vatikan']"
	"question_true": "0",
	"file": "multipart/form-data",
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
		<td>question_name</td>
		<td>Sorunun başlığı</td>
	</tr>
	<tr>
		<td>question_type</td>
		<td>Sorunun hangi tipte olduğunu belirtir</td>
	</tr>
	<tr>
		<td>question_option</td>
		<td>Sorunun şıkları en fazla 4 şık</td>
	</tr>
	<tr>
		<td>question_true</td>
		<td>Sorunun şıklarına göre, doğru şıkkın index'i</td>
	</tr>
	<tr>
		<td>file</td>
		<td>O soru için özelleştirilebilir dosya</td>
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