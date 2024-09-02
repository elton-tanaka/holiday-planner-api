<?php

namespace App\Services;

use App\Repositories\Contracts\HolidayRepositoryInterface;
use Illuminate\Support\Facades\DB;

class HolidayService
{
    protected $holidayRepository;

    public function __construct(HolidayRepositoryInterface $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
    }

    public function getAllHolidays()
    {
        return $this->holidayRepository->getAllHolidays();
    }

    public function getHolidayById($id)
    {
        return $this->holidayRepository->getHolidayById($id);
    }

    public function createHoliday(array $holiday)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $holiday = $this->holidayRepository->createHoliday($holiday);
            $user->holidays()->attach($holiday->id);
            DB::commit();

            return $holiday;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function updateHoliday(int $id, array $holiday)
    {
        DB::beginTransaction();
        try {
            $holiday = $this->holidayRepository->updateHoliday($id, $holiday);
            DB::commit();

            return $holiday;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function destroyHoliday(int $id)
    {
        DB::beginTransaction();
        try {
            $holiday = $this->holidayRepository->getHolidayById($id);

            if ($holiday) {
                $holiday->users()->detach();
                $this->holidayRepository->destroyHoliday($id);
            }

            DB::commit();

            return $holiday;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
