<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AttendeeTenure
{
    private const DAYS_PER_MONTH = 30;

    private const MONTHS_PER_YEAR = 12;

    /**
     * @return array{years: int, months: int, days: int, attendees: int}
     */
    public static function sum(Builder $query): array
    {
        $totals = self::normalize(
            (int) (clone $query)->sum('year'),
            (int) (clone $query)->sum('month'),
            (int) (clone $query)->sum('day'),
        );

        $totals['attendees'] = (int) (clone $query)->count();

        return $totals;
    }

    /**
     * @return Collection<int, object{label: string, years: int, months: int, days: int, attendees: int}>
     */
    public static function groupedBy(Builder $query, string $column): Collection
    {
        $rows = (clone $query)
            ->get([$column, 'year', 'month', 'day']);

        return $rows
            ->groupBy(fn ($row) => self::normalizeLabel($row->{$column}))
            ->map(function (Collection $group, string $label) {
                $totals = self::normalize(
                    (int) $group->sum('year'),
                    (int) $group->sum('month'),
                    (int) $group->sum('day'),
                );

                return (object) [
                    'label' => $label,
                    'years' => $totals['years'],
                    'months' => $totals['months'],
                    'days' => $totals['days'],
                    'attendees' => $group->count(),
                ];
            })
            ->sortBy('label', SORT_NATURAL)
            ->values();
    }

    /**
     * @return Collection<int, object{service_type: string, cities: Collection<int, object{city: string, attendees: int}>, attendees: int}>
     */
    public static function serviceTypeCityBreakdown(Builder $query): Collection
    {
        $serviceTypes = config('attendee_service_types', []);
        $rows = (clone $query)->get(['service_type', 'city']);

        return collect($serviceTypes)->map(function (string $serviceType) use ($rows) {
            $group = $rows->where('service_type', $serviceType);

            $cities = $group
                ->groupBy(fn ($row) => self::normalizeLabel($row->city))
                ->map(fn (Collection $cityGroup, string $city) => (object) [
                    'city' => $city,
                    'attendees' => $cityGroup->count(),
                ])
                ->sortBy('city', SORT_NATURAL)
                ->values();

            return (object) [
                'service_type' => $serviceType,
                'cities' => $cities,
                'attendees' => $group->count(),
            ];
        });
    }

    /**
     * @return object{name: string, years: int, months: int, days: int}|null
     */
    public static function longestAttendee(Builder $query): ?object
    {
        $attendee = (clone $query)
            ->get(['name', 'year', 'month', 'day'])
            ->sortByDesc(fn ($row) => self::toComparableDays(
                (int) $row->year,
                (int) $row->month,
                (int) $row->day,
            ))
            ->first();

        if (! $attendee) {
            return null;
        }

        $totals = self::normalize(
            (int) $attendee->year,
            (int) $attendee->month,
            (int) $attendee->day,
        );

        return (object) [
            'name' => $attendee->name,
            'years' => $totals['years'],
            'months' => $totals['months'],
            'days' => $totals['days'],
        ];
    }

    public static function format(array $totals): string
    {
        return __('app.tenure_format', [
            'years' => $totals['years'] ?? 0,
            'months' => $totals['months'] ?? 0,
            'days' => $totals['days'] ?? 0,
        ]);
    }

    public static function toComparableDays(int $years, int $months, int $days): int
    {
        return ($years * self::MONTHS_PER_YEAR * self::DAYS_PER_MONTH)
            + ($months * self::DAYS_PER_MONTH)
            + $days;
    }

    /**
     * @return array{years: int, months: int, days: int}
     */
    public static function normalize(int $years, int $months, int $days): array
    {
        $months += intdiv($days, self::DAYS_PER_MONTH);
        $days %= self::DAYS_PER_MONTH;

        $years += intdiv($months, self::MONTHS_PER_YEAR);
        $months %= self::MONTHS_PER_YEAR;

        return compact('years', 'months', 'days');
    }

    private static function normalizeLabel(?string $value): string
    {
        $value = trim((string) $value);

        return $value !== '' ? $value : __('app.not_specified');
    }
}
