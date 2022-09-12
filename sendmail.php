<?php
    require_once('PHPMailer/PHPMailer.php');
    require_once('PHPMailer/SMTP.php');
    require_once('PHPMailer/Exception.php');

	$mail = new PHPMailer\PHPMailer\PHPMailer();

  try {
      $mail->isSMTP();                                            
      $mail->Host       = 'smtp.mail.ru';
      $mail->SMTPAuth   = true;                                  
      $mail->Username   = 'ящик@mail.ru';                   
      $mail->Password   = 'секретный пароль с mail почты для сторонних программ';
      $mail->SMTPSecure = 'ssl';         
      $mail->Port       = 465;
      $mail->SMTPOptions = [ 'ssl' => [ 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true, ] ];
      $mail->CharSet = 'UTF-8';

      $mail->From = 'куда@mail.ru';
      $mail->FromName = 'admin';
      $mail->addAddress('куда@mail.ru');

      //Content
      $mail->isHTML(true);                                  
      $mail->Subject = 'Письмо-заявка с вашего сайта(Subject)';

      // укажите 4, если почта не отправляется, чтобы узнать, почему
      //$mail->SMTPDebug = 4;
    
      //рука
      $hand = "Правая";
      if($_POST['hand'] == 'left') {
        $hand = "Левая";
      }
    
      //тело письма
      $body = '<h1>Заявка с вашего сайта(body)</h1>';

      if(trim(!empty($_POST['name']))) {
        $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
      }
      if(trim(!empty($_POST['email']))) {
        $body.='<p><strong>Email:</strong> '.$_POST['email'].'</p>';
      }
      if(trim(!empty($_POST['hand']))) {
        $body.='<p><strong>Рука:</strong> '.$hand.'</p>';
      }
      if(trim(!empty($_POST['age']))) {
        $body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
      }
      if(trim(!empty($_POST['message']))) {
        $body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
      }
    
      //Прикрепить файл
      if(!empty($_FILES['image']['tmp_name'])) {
        //путь загрузки файла
        $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
        //копируем файл
        $body.='<p><strong>Фото в приложении</strong></p>';
        $mail->addAttachment($_FILES['image']['tmp_name'], $filePath); 
      }
        
      $mail->Body = $body;
    
      $mail->send();
    
      echo 'Message has been sent';
   } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }
