<?php 
namespace App\Helpers;

use Twilio\Rest\Client;
use Exception;

class SmsHelper
{
    /**
     * Send a WhatsApp message using Twilio.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message to send.
     * @throws Exception If the message fails to send.
     */
    public static function sendWhatsApp($to, $message)
    {
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_AUTH_TOKEN');
            $from = 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER'); // Use WhatsApp sandbox number

            $client = new Client($sid, $token);

            $client->messages->create(
                'whatsapp:' . $to, // Recipient's WhatsApp number
                [
                    'from' => $from,
                    'body' => $message,
                ]
            );
        } catch (Exception $e) {
            // Log the error or handle it as needed
            throw new Exception("Failed to send WhatsApp message: " . $e->getMessage());
        }
    }

    /**
     * Send a message via SMS or WhatsApp based on the configured channel.
     *
     * @param string $to The recipient's phone number.
     * @param string $message The message to send.
     * @throws Exception If the message fails to send.
     */
    public static function sendMessage($to, $message)
    {
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_AUTH_TOKEN');
            $channel = env('TWILIO_MESSAGE_CHANNEL', 'sms'); // Default to SMS

            $from = $channel === 'whatsapp' 
                ? 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER') 
                : env('TWILIO_PHONE_NUMBER');

            $to = $channel === 'whatsapp' 
                ? 'whatsapp:' . $to 
                : $to;

            $client = new Client($sid, $token);

            $client->messages->create(
                $to,
                [
                    'from' => $from,
                    'body' => $message,
                ]
            );
        } catch (Exception $e) {
            // Log the error or handle it as needed
            throw new Exception("Failed to send message: " . $e->getMessage());
        }
    }
}
?>