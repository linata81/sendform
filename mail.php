<!-- отправка писем без вложений функцией mail -->

<?php
$name = trim($_POST['name']);
$phone = trim($_POST['phone']);
$comment = trim($_POST['message']);
$zakaz = trim($_POST['zakaz']);

$body = '<h2>'.$zakaz.'</h2><h3>Данные покупателя:</h3>Имя: '.$name.'<br> Телефон: '.$phone.'<br> Почта: '.$email.'<br> Сообщение: ' .$comment;

$headers  = 'From: cc75916@vh354.timeweb.ru' . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'Content-Type: text/html; charset=utf-8' . "\r\n";

mail("linata81@yandex.ru", "тестовое письмо с сайта", $body,  $headers, "cc75916@vh354.timeweb.ru");
