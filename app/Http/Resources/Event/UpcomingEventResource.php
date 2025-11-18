<?php

namespace App\Http\Resources\Event;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpcomingEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        if ($this->resource instanceof \Illuminate\Database\Eloquent\Model) {
            return $this->transformItem($this->resource);
        }

        if ($this->resource instanceof LengthAwarePaginator) {
            $collection = $this->resource->getCollection();
            return [
                "data" => $collection->map(function ($item) {
                    return $this->transformItem($item);
                }),

                "total_per_categories" => $collection->groupBy('eventCategory.name')->map(function ($item) {
                    return $item->count();
                })->toArray(),
                "current_page" => $this->resource->currentPage(),
                "last_page"    => $this->resource->lastPage(),
                "per_page"     => $this->resource->perPage(),
                "total"        => $this->resource->total()
            ];
        }

        return parent::toArray($request);
    }

    private function transformItem($item)
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'date' => $this->formatDate($item),
            'pic' => $item->pic,
            'location' => strip_tags($item->location),
            'description' => strip_tags($item->description),
            'category' => $item->eventCategory->name,
            'category_color' => $item->eventCategory->color,
            'company' => $item->company->name,
        ];
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
}
