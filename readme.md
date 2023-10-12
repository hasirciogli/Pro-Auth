# ProAuth0

**Yetkilendirme** ve **otorizasyon** Servisi & Projesi



### Türkçe Özellikler Listesi
<details>
  <summary>İstemci Sistemi (Clients)</summary>
  <div>
    <div>3 adet client tipi bulunmaktadır</div>
    
    system: Sistem clientleri sistem projeleriniz için kullanılmalıdır. 
    Örnek google ads adsense admob gibi diğer birimler.

    admin: Admin hesaplarında kullanılacak clientler. 
    Bu bizim ihtiyacımız için üretildi. 
    Kullanmayabilirsiniz.

    api: Apı cientleri ise public api paneli ile 
    bütün kullanıcıların client oluşturup yetkilendirme 
    sistemini kullanması için oluşturulan client tipidir.
     Kullanıcı client oluşturur entegrasyon tamamlar 
     ve sis onaylarsanzız client public olarak erişime 
     açılır.
  
  </div>
</details>
<details>
  <summary>İstek Limit Sistemi (RequestLimitter)</summary>
  <div>
    <div>3 adet limitter tipi bulunmaktadır</div>
    
    Authenticate: Authenticate kullanıcı bilgilerinin 
    post edildiği kısımda özel bir limitter bulunaktadır. 
    Eğer limit aşılırsa ip sistemin aldığı request 
    sayısına bağlı olarak 10-300 dakika arasında ip 
    yi banlar. ve asla o ip den giriş yapılamaz. Ya 
    elle açılacak yada seve seve bekleyecek ban 
    süresini. Banlar sahow banlanır. Ban yenildiği 
    takdirde kullanıcı bulunamadı hatasıyla bire bir
     aynı hata alınır. Kullanıcının ip ban yediğini 
     anlaması zorlaşır ama şifresini doğru bildiğinden 
     emin ise ve bu yazıyı okuyorsa artık anlayacaktır :)

    Api: Access token ile gelen isteklerde bir ip
     adresinden her seferinde farklı bir access token 
     geliyor ise veya token yanlış olmasına rağmen 
     ard arda istek tekrarlanıyorsa sistem otomatik 
     olarak 10 ile 100 dakika arasında banlar. Request 
     limit occurred gibi bir hata döndürecektir. Ban 
     süresi yapılan isteğe ve sayısı ile doğru orantılıdır.

    Authorize: Api ve Authenticate özellikleri bir arada
     kullanılmıştır. Süre token, grant, scope, hash aynı 
    anda kontrol edilir eğer bir hata alındıysa sistem 
    tekrar 100 ila 400 dakika arasında banlar. Authorize
     öenmlidir. Sistemdeki key'i tahmin edebilecek kadar 
     şanslı olacaklarını düşünmüyoruz. Ha eğer tahmin 
     ettiklerini varsayalım. Post ettikleri anda key'in 
     hash'ını gönderemeyecekleri için key iptal olacak 
     ve ip süresiz banlanacak. Kendileri bilir yani bize
      hava hoş banlar geçeriz :)

  </div>
</details>