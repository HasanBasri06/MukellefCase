### Genel Bakış
Proje Laravel 11 ile oluşturulmuştur ve REST Api kullanılmıştır. API güvenliği için laravel paketi olan Sanctum kurulumu yapılmıştır. Bu sayede Bearer Token güvenliği sağlanmaktadır.

Proje bir uygulama içersindeki abonelik sistemini simüle etmektedir. Kullanıcı register olmaktadır ve kayıt olduğu bilgiler ile login olmaktadır. Tüm işlemleri login olmuş kullanıcılar tarafından yapılabilmektedir.

### Ekstra
Proje Desgin Pattern'lar ile güçlendirilmiştir. Projenin ana iskeleti Repository Pattern ile yapılmıştır, bu pattern'ın amacı kod okunabilirliği ve tekrarının kontrollü bir şekilde yapılmasıdır. Class'lar arası veri transferi içinde DTOs (Data Transfer Object) kullanılmıştır, dto kullanımı class arasında hangi tipte ve hangi veride isteklerin geleceğini belirlemektedir. Diğer pattern'imiz ise Strategy Pattern, bu paternimiz bizi iç içe geçmiş kontrol (if) yapılarından kurtarmaktadır. Projemiz içerisinde ise Ödeme alt yapısı için kullanılmıştır.

Projemiz için ödeme alt yapısı fiziksel olarak bulunmamaktadır, bu yüzden fake bir ödeme sistemi kurulmuştur. Kullanıcılar için kart ile ödeme eklenmiştir, fiziki bir bankamız olmadığı için sanal banka (fake) oluşturulmuştur, ve kullanıcılara rastgele bakiye atanmıştır.

### Ayarlar
Mail göndermek için `.env` dosyasının içinde email ayarlarınızı kendinize göre uyarlamalısınız.

Local ortamda projeyi ayağa kaldırmak için `php artisan serve` demeniz yeterli. Ödeme işlemleri __PaymentJob__ classı ile yapılmaktadır ve bu class da __payment__ isimli kuyruğa koyulmaktadır, bu yüzden ödeme işlemlerini de test etmek için php artisan `php artisan queue:work --queue=payment` yazmanız yeterli olacaktır.

### Endpoints
#### Rest APi
1. __[host]/api/register__ kayıt işlemi yapar. *email*, *name*, *password* ve *passwordConfirm* parametresi alır
2. __[host]/api/login__ giriş işlemi yapar. *email* ve *password* parametresi alır
3. __[host]/api/api/subscribe__ abone için ilk ödemeyi yapar. ardından 1 ay sonra tekrar ödeme planı oluşturur. 1 Ay sonra eğer sanal cüzdanda ücret yok ise ödeme işlemini yapmaz. Abone olma ve her ay tekrar ödeme alma işlemi default olarak active olarak gelir.
4. __[host]/api/subscribe/change-renewal__ Tekrar tekrar ödeme durumunu değiştirir. *change_renewal* ve *user_id* parametresi alır
5. __[host]/api/subscribe/change-subscribe__ Abone sistemini değitirir. parametre almaz eğer bu url istek gelirse, abone olma durumunda abonilikten çıkar, eğer abone değilse tekrar abone yapar.
6. __[host]/api/subscribe/payment-subscribe__ Manuel olarak abone ödemesi yapar. Eğer kullanıcı her ay ödemeyi kapatır ise manuel olarak bu url den istek alır.
7. __[host]/api/user__ kullanıcının order ve subscribe verilerini getirir. *user_id* parametresi alır.
#### Command
1. `php artisan subscribe:rewal {user_id}` komutu ile kullanıcı ödeme planını terminal üzerinden de planlayabilirsiniz.

__document/__ klasörü içinde postman api collection bulunmaktadır
