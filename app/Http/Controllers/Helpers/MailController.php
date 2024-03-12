<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\TreasureHunt;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendQRCodesMail(TreasureHunt $treasureHunt, string $email){
        $pdfFilename=ucfirst(strtolower(str_replace(" ","_",$treasureHunt->title.' '.__('El Tesoro Del Enebro').' '.now()->valueOf().'.pdf')));

        $pdf = Pdf::loadView('treasureHunts.qrCodes.pdf',['treasureHunt'=>$treasureHunt]);
        $mailData=[
            'emailTo'=>$email,
            'pdf'=>$pdf,
            'pdfFilename'=>$pdfFilename,
            'subject'=>__('Tus códigos QR'),
            'body'=>__('Aquí tienes tus códigos QR')
        ];

        Mail::send(
            'emails.treasureHuntQrCodesMail',
            [
                'title'=>$mailData['subject'],
                'body'=>$mailData['body']
            ],
            function ($message) use ($mailData){
                //Setting up the message options
                $message->to($mailData['emailTo'])
                    ->subject($mailData['subject'])
                    ->attachData($mailData['pdf']->output(),$mailData['pdfFilename']);
            }
        );
    }
}
