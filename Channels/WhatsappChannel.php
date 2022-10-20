<?php
namespace Modules\Notification\Channels;

use Illuminate\Notifications\Notification;

class WhatsappChannel
{

    public function __construct()
    {

    }


    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsapp($notifiable);

        $curl = curl_init();
        curl_setopt_array( $curl, array(
            CURLOPT_URL => "https://graph.facebook.com/v14.0/102377125972387/messages",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{ \"messaging_product\": \"whatsapp\", \"to\": \"".$notifiable->whatsapp."\", \"type\": \"template\", \"template\": { \"name\": \"hello_world\", \"language\": { \"code\": \"en_US\" } } }",
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "content-type: application/json",
                'Authorization: Bearer EAAGFsADogFMBAI1osyAY6ebSZAAVp938UTuEsgpU1KBZA2j2wCUa6s983KI0pZAZCqz2bMlti0JUZAI7MJk9OEC4YeZArIwGYZBlNMX0z76RsUNfTYbXaVOpaqi3WXkgVNWkBEr1iiZCXAfRF6ZAcPE9XyZA0HVgp4PJJplyNZC1TXUbFekxog0hT08hxcc3vs80RiGciQFeFBb0vBFe0KhBVGp'
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
    }

}