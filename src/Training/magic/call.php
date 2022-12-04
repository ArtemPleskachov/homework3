<?php

interface MailerInterface
{
    public function send();
}

class SmtpMailer implements MailerInterface //Simple Mail Transfer Protocol - cервіс для пересилання електронних листів
{
    public function send()
    {
        var_dump('відправляємо за допомогою Smt');
    }
}
class MailGunMailer implements MailerInterface//також створений для передачі листів, але належить до бібліотек
{
    public function send()
    {
        var_dump('відправляємо за допомогою GunMailer');
    }
}

class MailerDecorator  //Ми як клієнт не знаємо скільки програм для відправки листів маємо, тому створюємо базовий клас для відправки листів
{
    protected $mailer;

    /**
     * @param $mailer
     */

    //В параметрах конструктора, вказуємо інтерфейс, так як наші два класа виконують одну і ту саму функцію send()
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
######## Це приклад як ми могли зробити без __сall
    //    public function send()
//    {
//        return $this->mailer->send(); //запускаємо розсилку
//    }   //  - без використання методу __сall

// Якщо в майбутньому зміниться інтерфейс з назвою метода send() то програма перестане працювати!
######################################################

    public function __call($name, $arguments)
    {
        return $this->mailer->{$name}($arguments);
    }
//В даному випадку, використовуємо метод __call, щоб зробити нашу програму більш динамічною,
//об'єкт $mail буде спрацьовувати в любому випадку, навіть якщо ми захочемо розширити програму
//ще одним класом з сервісом для відправки то __call буде відпрацьовувати, або наприклад зміниться
//сам інтерфейс з зовсім іншою назвою методу, то метод __call приймає неіснуючи методи то він відпрацює і
//наші клієнти отримають свого листа
}

$mail = new MailerDecorator(new MailGunMailer());
$mail->send();
//Так же працює, якщо запустемо відправку через об'єкт SmtpMailer
//$mail = new MailerDecorator(new SmtpMailer());
//$mail->send();


################################################



