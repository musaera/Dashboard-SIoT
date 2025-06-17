<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

## 📡 Laravel IoT Monitoring Dashboard

Sistem pemantauan suhu dan kelembapan secara real-time menggunakan Laravel + MQTT dengan visualisasi data melalui panel admin [Filament](https://filamentphp.com/). Data dikirim dari perangkat ESP32 menggunakan protokol MQTT ke broker [shiftr.io](https://shiftr.io) lalu disimpan ke database.

### 🚀 Fitur

- 🌡️ Monitoring suhu secara realtime
- 💧 Monitoring kelembapan
- 🔔 Buzzer aktif jika melebihi ambang batas
- 📦 Penyimpanan otomatis ke database
- 📊 Tampilan ringkas via Filament Dashboard

---

## ⚙️ Teknologi yang Digunakan

- Laravel 12
- PHP 8.3
- ESP32 (Wokwi Simulasi)
- MQTT via shiftr.io
- Filament Admin Panel
- DHT22 Sensor (Temperature & Humidity)
- Buzzer (Alarm)

---

## 📦 Format JSON dari MQTT

Topik yang digunakan: `iot/sensor/data`

```json
{
  "temperature": 36.5,
  "humidity": 72.0
}
