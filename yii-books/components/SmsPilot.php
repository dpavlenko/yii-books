<?php

namespace app\components;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;

class SmsPilot extends BaseObject
{
    public $apiKey;
    public $senderName = 'INFORM'; // Your registered sender ID, or use SMSPILOT default names

    /**
     * Sends an SMS using SMSPILOT HTTP API
     *
     * @param string $phone Phone number in international format (e.g., 79031234567)
     * @param string $message Text of the message
     * @return bool Returns true if successful, false otherwise
     */
    public function sendMessage($phone, $message)
    {
        if (empty($this->apiKey)) {
            throw new InvalidConfigException('SmsPilot::$apiKey must be set.');
        }

        $url = 'https://smspilot.ru';

        $params = [
            'send' => $message,
            'to' => $phone,
            'apikey' => $this->apiKey,
            'from' => $this->senderName, // Optional: requires registered sender name
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Parse JSON response from SMS Pilot
        $result = json_decode($response, true);

        // Check if message ID was returned, indicating success
        if ($httpCode === 200 && isset($result['send'][0]['server_id'])) {
            return true;
        }

        Yii::error("SMS Pilot Error: " . ($result['error']['description_rus'] ?? 'Unknown Error'), 'sms');
        return false;
    }
}
