<?php
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
        $bill_images = $_POST["bill_image"];
        $target_dir = "bill_images";
        if (!is_dir($target_dir))
            mkdir($target_dir, 0777, true);
        $target_dir .= "/";
        $target_file = [];
        for($i=0; $i<count($bill_images); $i++){
            $image_parts = explode(";base64,", $bill_images[i]);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $image_fname = uniqid() . '.png';
            $target_file[$i] = $target_dir . $image_fname;
            file_put_contents($target_file[$i], $image_base64);
        }

        
        //send an email with an image and a csv file
        //$to_email = "aaue920921@gmail.com"; //Recipient email, Replace with own email here    
        $to_email = "it_starlight0808@outlook.com";
        //check if its an ajax request, exit if not
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            
            $output = json_encode(array( //create JSON data
                'type'=>'error', 
                'text' => 'Sorry Request must be Ajax POST'
            ));
            die($output); //exit script outputting json data
        }
        
        //proceed with PHP email.
        $headers = 'From: '. '' . "\r\n" .
        'Reply-To: '. '' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        $subject = 'VER Trip-' . $_POST["pname"] . '-' . $_POST["pjob"] . '-' . $_POST["start_date"];
        $message = file_get_contents('email_body.html');
        $bill_images_div = "";
        for($i=0;$i<count($target_file);$i++)
            $bill_images_div .= "<img src='https://mobileescaperoom.fun/gmapdist/".$target_file[$i]."' width='100%'/>"
        $message = strtr($message, array("{bill_images}" => $bill_images_div, "csv_info" => "https://mobileescaperoom.fun/gmapdist/" . $csv_filename));

        $send_mail = mail($to_email, $subject, $message, $headers);
        if ($send_mail)
        {
            echo "success";
        }
        else
        {
            echo "failed";
        }
        exit();
    } 
?>