<?php

namespace App\Services\Event;

use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function dataCalendar()
    {
        return Event::query()->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'location' => $event->location,
                    'pic' => $event->pic,
                    'status' => $event->status->label(),
                    'event_category' => $event->eventCategory->name,
                    'company' => $event->company->name,
                    'start' => $event->start_date->timezone('Asia/Jakarta')->toIso8601String(),
                    'end'   => $event->end_date->timezone('Asia/Jakarta')->toIso8601String(),
                    'date_str' => $this->formatDate($event),
                    'backgroundColor' => $event->eventCategory->color,
                    'borderColor' => $event->eventCategory->color,
                ];
            });
    }

    public function formatDate($event)
    {
        $start = \Carbon\Carbon::parse($event->start_date);
        $end = \Carbon\Carbon::parse($event->end_date);
        if ($start->isSameDay($end)) {
            return $start->format('d M Y, H:i') . ' - ' . $end->format('H:i') . ' WIB';
        } else {
            return $start->format('d M Y, H:i') . ' - ' . $end->format('d M Y, H:i') . ' WIB';
        }
    }

    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            return Event::query()->updateOrCreate([
                'id' => $data['id']
            ], [
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'pic' => $data['pic'],
                'status' => $data['status'],
                'event_category_id' => $data['category'],
                'company_id' => $data['company'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ]);
        });
    }

    public function move($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            return Event::query()->updateOrCreate([
                'id' => $id
            ], [
                'start_date' => $data['start'],
                'end_date' => $data['end'],
            ]);
        });
    }

    public function edit($id)
    {
        $event = Event::query()->findOrFail($id);
        return [
            'id' => $event->id,
            'title' => $event->title,
            'description' => $event->description,
            'location' => $event->location,
            'pic' => $event->pic,
            'status' => $event->status,
            'category' => $event->event_category_id,
            'company' => $event->company_id,
            'start_date' => $event->start_date->timezone('Asia/Jakarta')->toIso8601String(),
            'end_date'   => $event->end_date->timezone('Asia/Jakarta')->toIso8601String(),
        ];
    }
}
