<?php

namespace App\Filament\Widgets;

use App\Models\SensorData;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SensorStat extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $latest = SensorData::latest()->first();

        $temperature = $latest?->temperature ?? 'N/A';
        $humidity = $latest?->humidity ?? 'N/A';
        $topic = $latest?->topic ?? '-';
        $time = $latest?->created_at?->format('d M Y H:i') ?? '-';

        $buzzerStatus = is_numeric($temperature) && is_numeric($humidity) &&
            ($temperature > 35 || $humidity > 70)
            ? '🔊 ON'
            : '🔇 OFF';

        return [
            Stat::make(
                '🌡️ Suhu',
                is_numeric($temperature) ? "{$temperature} °C" : $temperature
            )
                ->description("Topik: {$topic}\nWaktu: {$time}")
                ->extraAttributes(['class' => 'whitespace-pre-line'])
                ->descriptionIcon('heroicon-o-fire') 
                ->color(is_numeric($temperature) && $temperature > 35 ? 'red' : 'green'),

            Stat::make(
                '💧 Kelembapan',
                is_numeric($humidity) ? "{$humidity} %" : $humidity
            )
                ->description("Topik: {$topic}\nWaktu: {$time}")
                ->extraAttributes(['class' => 'whitespace-pre-line'])
                ->descriptionIcon('heroicon-o-sparkles')
                ->color(is_numeric($humidity) && $humidity > 70 ? 'red' : 'green'),

            Stat::make(
                '🔔 Status Buzzer',
                $buzzerStatus
            )
                ->description("Aktif jika suhu > 35°C atau kelembapan > 70%")
                ->descriptionIcon('heroicon-o-bell')
                ->color($buzzerStatus === '🔊 ON' ? 'red' : 'green'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
