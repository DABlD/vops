<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class WelcomeController extends Controller
{
    public function index(){
        return $this->_view('welcome', [
            'title' => "Virtual OPS",
        ]);
    }

    public function sendEmail(Request $req){
        require base_path("vendor/autoload.php");

        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        try {
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'info@onehealthnetwork.com.ph';   //  sender username
            $mail->Password = '1nf0P@55w0rd';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom('transit.qr@gmail.com', 'QR ADMIN');
            $mail->addAddress($req->email);

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $req->subject;

            $mail->Body    = "
                Name: $req->name,
                Phone: $req->phone,

                Message: $req->message
            ";

            if( !$mail->send() ) {
                echo "Email sending failed";
            }
            
            else {
                echo "
                    <script>
                        window.alert('Email sent successfully. Please check your email');
                        window.close();
                    </script>
                ";
            }

        } catch (Exception $e) {
            dd($e->errorMessage());
            echo "Error. Email not sent";
        }
    }

    private function _view($view, $data = array()){
        return view($view, $data);
    }
}
