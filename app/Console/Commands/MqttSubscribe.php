<?php

namespace App\Console\Commands;

use App\Models\SensorData;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class MqttSubscribe extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Subscribe to MQTT topic and save temperature and humidity from shiftr.io';

    public function handle()
    {
        $server = 'sfl-official.cloud.shiftr.io';
        $port = 1883;
        $clientId = 'laravel-subscriber-' . uniqid();
        $username = 'sfl-official';
        $password = 'eDeHBopIdCqPWslY';

        $settings = (new ConnectionSettings)
            ->setUsername($username)
            ->setPassword($password)
            ->setKeepAliveInterval(60)
            ->setLastWillTopic('iot/lastwill')
            ->setLastWillMessage('Laravel client disconnected unexpectedly.');

        try {
            $mqtt = new MqttClient($server, $port, $clientId);
            $mqtt->connect($settings, true);

            $this->info("✅ Connected to shiftr.io broker at $server:$port");

            // Subscribe to the topic used in ESP32
            $mqtt->subscribe('iot/sensor/data', function (string $topic, string $message) {
                echo "📦 Received JSON: $message\n";

                $data = json_decode($message, true);

                if (isset($data['temperature'], $data['humidity'])) {
                    try {
                        SensorData::create([
                            'topic' => $topic,
                            'temperature' => $data['temperature'],
                            'humidity' => $data['humidity'],
                            'buzzer' => isset($data['buzzer']) ? (bool)$data['buzzer'] : false,
                        ]);

                        echo "✅ Data saved: Suhu = {$data['temperature']} | Kelembapan = {$data['humidity']} | Buzzer = " . ($data['buzzer'] ? 'ON' : 'OFF') . "\n";
                        Log::info('✅ MQTT Data Saved', $data);
                    } catch (\Throwable $e) {
                        Log::error("❌ DB Save Error: " . $e->getMessage());
                    }
                }
            }, 0);

            // Run loop to listen for messages continuously
            while (true) {
                $mqtt->loop(true); // blocking
                usleep(250000); // optional delay to reduce CPU
            }
        } catch (\Exception $e) {
            $this->error("❌ MQTT Connection Error: " . $e->getMessage());
            Log::error('MQTT CONNECTION ERROR', ['exception' => $e]);
        }
    }
}
