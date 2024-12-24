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
            $mail->Username = env('MAIL_USERNAME');   //  sender username
            $mail->Password = env('MAIL_PASSWORD');       // sender password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom('virtualopsdonotreply@gmail.com', 'VOPS NO REPLY');
            $mail->addAddress($req->email);

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $req->subject;

            $mail->Body    = "
                Name: $req->name <br>
                Phone: $req->phone <br><br>

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
