<?php

namespace App\Repositories\Contracts;

interface HolidayRepositoryInterface
{
    public function getAllHolidays();

    public function getHolidayById($id);

    public function createHoliday(array $holiday);

    public function updateHoliday(int $id, array $holiday);

    public function destroyHoliday(int $id);
}
