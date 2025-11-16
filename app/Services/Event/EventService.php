<?php

namespace App\Services\Event;

use App\Enums\Event\Status;
use App\Helper\AuthHelper;
use App\Models\Event;
use App\Tools\CodeGenerator;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function datatable()
    {
        return Event::query()
            ->with([
                'eventCategory',
                'company',
            ])
            ->select([
                'id',
                'number',
                'title',
                'description',
                'location',
                'pic',
                'status',
                'event_category_id',
                'company_id',
                'start_date',
                'end_date',
                'created_at',
            ])
            ->addCanUpdateAndIsDelete('event')
            ->when(!AuthHelper::hasRole('administrator'), function ($query) {
                $query->where('company_id', AuthHelper::user()->company_id);
            })
            ->oldest();
    }

    public function outstandingDatatable()
    {
        return Event::query()
            ->with([
                'eventCategory',
                'company',
                'requestor',
            ])
            ->select([
                'id',
                'number',
                'title',
                'description',
                'location',
                'pic',
                'status',
                'event_category_id',
                'company_id',
                'requestor_id',
                'start_date',
                'end_date',
                'created_at',
            ])
            ->addCanApproveAndCanReject('event')
            ->where('status', Status::PENDING)
            ->oldest();
    }

    public function dataCalendar()
    {
        return Event::query()
            ->with([
                'eventCategory',
                'company',
            ])
            ->where('status', Status::VERIFIED->value)
            ->get()
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
            $user = AuthHelper::user();
            $payload = [
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'pic' => $data['pic'],
                'event_category_id' => $data['category'],
                'company_id' => $user->company_id,
                'requestor_id' => $user->id,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
            ];
            if (!$data['id']) {
                $payload['number'] = CodeGenerator::generateCodeBySequence();
            }
            return Event::query()->updateOrCreate([
                'id' => $data['id']
            ], $payload);
        });
    }

    public function storeCalendar(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = AuthHelper::user();
            return Event::query()->updateOrCreate([
                'id' => $data['id']
            ], [
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'pic' => $data['pic'],
                'event_category_id' => $data['category'],
                'company_id' => $data['company'],
                'requestor_id' => $user->id,
                'status' => Status::VERIFIED->value,
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

    public function destroy($id)
    {
        return Event::query()->findOrFail($id)->delete();
    }

    public function dataForShow($id)
    {
        $event = Event::query()->findOrFail($id);
        return (object) [
            'key' => $event->id,
            'number' => $event->number,
            'title' => $event->title,
            'description' => $event->description,
            'location' => $event->location,
            'pic' => $event->pic,
            'status' => $event->status,
            'category' => $event->eventCategory->name,
            'category_color' => $event->eventCategory->color,
            'company' => $event->company->name,
            'requestor' => $event->requestor?->name,
            'date' => $this->formatDate($event),
            'created_at' => $event->created_at->timezone('Asia/Jakarta')->diffForHumans(),
        ];
    }

    public function approve($id)
    {
        return Event::query()->findOrFail($id)->update([
            'status' => Status::VERIFIED->value,
        ]);
    }

    public function reject($id, $reason)
    {
        return Event::query()->findOrFail($id)->update([
            'status' => Status::REJECTED->value,
            'reason' => $reason,
        ]);
    }
}
