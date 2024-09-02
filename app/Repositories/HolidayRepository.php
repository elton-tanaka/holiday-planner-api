<?php

namespace App\Repositories;

use App\Models\Holiday;
use App\Repositories\Contracts\HolidayRepositoryInterface;

class HolidayRepository implements HolidayRepositoryInterface
{
    protected $holiday;

    public function __construct(Holiday $holiday)
    {
        $this->holiday = $holiday;
    }

    public function getAllHolidays()
    {
        return $this->holiday->all();
    }

    public function getHolidayById($id)
    {
        return $this->holiday->with('users')->findOrFail($id);
    }

    public function createHoliday(array $holiday)
    {
        return $this->holiday->create($holiday);
    }

    public function updateHoliday(int $id, array $data)
    {
        $holiday = $this->getHolidayById($id);
        $holiday->update($data);

        return $holiday;
    }

    public function destroyHoliday(int $id)
    {
        $holiday = $this->getHolidayById($id);
        $holiday->delete();

        return $holiday;
    }
}
