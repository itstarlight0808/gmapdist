<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';

    $baseurl = "https://mobileescaperoom.fun/gmapdist";
    if ($_POST)
    {
        //create a csv file with post data
        // output headers so that the file is downloaded rather than displayed
        //header('Content-type: text/csv');
        //header('Content-Disposition: attachment; filename="demo.csv"');
        
        // do not cache the file
        //header('Pragma: no-cache');
        //header('Expires: 0');
        
        // create a file pointer connected to the output stream
        //$file = fopen('php://output', 'wb');

        $csv_filename = 'downloads/VER Trip-' . $_POST["pname"] . '-' . $_POST["pjob"] . '-' . $_POST["start_date"] . '.csv';
        $file = fopen($csv_filename, 'wb');
        // send the column headers
        fputcsv($file, array('Name: ' . $_POST["pname"]));
        fputcsv($file, array('Job Name: ' . $_POST["pjob"]));
        fputcsv($file, array('Start Date: ' . $_POST["start_date"]));
        fputcsv($file, array('Rooms for Job: ' . $_POST["job_rooms"]));
        fputcsv($file, array('Job Hours: ' . $_POST["job_hours"]));
        $has_hotel = intval($_POST["has_hotel"]);
        if ($has_hotel == 0)
        {
            fputcsv($file, array('Hotel: No'));
        }
        else
        {
            fputcsv($file, array('Hotel: Yes'));
            fputcsv($file, array('Name of Hotel: ' . $_POST['hotel_name']));
            fputcsv($file, array('Nights stayed: ' . $_POST['hotel_stayed']));
        }
        $has_add_expense = intval($_POST["has_add_expense"]);
        if ($has_hotel == 0)
        {
            fputcsv($file, array('Add an additional expense (excluding meals): No'));
        }
        else
        {
            fputcsv($file, array('Add an additional expense (excluding meals): Yes'));
            fputcsv($file, array('Name of company/person paid: ' . $_POST['paid_name']));
            $arr_expense_amount = explode("^", $_POST["expense_amount"]);
            $arr_expense_purpose = explode("^", $_POST["expense_purpose"]);
            for ($i=0; $i<count($arr_expense_amount); $i++)
            {
                fputcsv($file, array('Amount: ' . $arr_expense_amount[$i]));
                fputcsv($file, array('Purpose: ' . $arr_expense_purpose[$i]));
            }
        }
        fputcsv($file, array('Trip Note: ' . $_POST["trip_note"]));
        fputcsv($file, array('Calculated distance: ' . $_POST["dist_msg"]));
        fclose($file);
        
        //upload the bill image
        $bill_images = isset($_POST["bill_image"])?$_POST["bill_image"]:[];
        $target_dir = "bill_images";
        if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);
        $target_dir .= "/";
        $target_file = [];
        for($i=0; $i<count($bill_images); $i++){
            $image_parts = explode(";base64,", $bill_images[$i]);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image_fname = uniqid() . '.png';
            $target_file[$i] = $target_dir . $image_fname;
            file_put_contents($target_file[$i], $image_base64);
        }

        
        //send an email with an image and a csv file
        //$to_email = "aaue920921@gmail.com"; //Recipient email, Replace with own email here    
        $to_email = "fatiza.sazali2@gmail.com";
        //check if its an ajax request, exit if not
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            
            $output = json_encode(array( //create JSON data
                'type'=>'error', 
                'text' => 'Sorry Request must be Ajax POST'
            ));
            die($output); //exit script outputting json data
        }

        $subject = 'VER Trip-' . $_POST["pname"] . '-' . $_POST["pjob"] . '-' . $_POST["start_date"];
        $message = file_get_contents('email_body.html');
        $bill_images_div = "";
        for($i=0;$i<count($target_file);$i++)
            $bill_images_div .= "<img src='cid:bill_image_$i' width='100%' alt='bill_image'/>";
        $message = strtr($message, array("{bill_images}" => $bill_images_div, "csv_info" => "https://mobileescaperoom.fun/gmapdist/" . $csv_filename));

        $mail = new PHPMailer(true);
        try {
           //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            // $mail->isSMTP();                                            //Send using SMTP
            // $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
            // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            // $mail->Username   = 'user@example.com';                     //SMTP username
            // $mail->Password   = 'secret';                               //SMTP password
            // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $mail->setFrom('noreply@mobileescaperoom.fun', 'mobileescaperoom.fun');
            $mail->addAddress('it_starlight0808@outlook.com', 'Joe User');     //Add a recipient
            $mail->addAddress('fatiza.sazali2@gmail.com');               //Name is optional
            // $mail->addReplyTo('from@example.com', 'mobileescaperoom.fun Mailer');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = 'You have unread message from mobileescaperoom.fun gmapdist travel app...';
            for($i=0;$i<count($target_file);$i++)
                $mail->addEmbeddedImage($target_file[$i], "bill_image_$i");
            $mail->send();
            echo json_encode(array("state"=>1, "msg"=>'Message has been sent'));
        } catch (Exception $e) {
            echo json_encode(array("state"=>0, "msg"=>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}"));
        }
        exit();
    } 
?>