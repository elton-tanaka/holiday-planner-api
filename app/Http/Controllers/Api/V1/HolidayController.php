<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\V1\HolidayRequest;
use App\Services\HolidayService;

class HolidayController extends Controller
{
    private $holidayService;

    public function __construct(HolidayService $holidayService)
    {
        $this->holidayService = $holidayService;
    }

    public function index()
    {
        try {
            $holidays = $this->holidayService->getAllHolidays();

            return response()->json([
                'message' => 'Holidays retrieved',
                'data' => [
                    'holidays' => $holidays,
                ],
            ]);
        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $holiday = $this->holidayService->getHolidayById($id);

            return response()->json([
                'message' => 'Holiday retrieved',
                'data' => [
                    'holiday' => $holiday,
                ],
            ]);
        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function store(HolidayRequest $request)
    {
        try {
            $holiday = $this->holidayService->createHoliday(request()->all());

            return response()->json([
                'message' => 'Holiday created',
                'data' => [
                    'holiday' => $holiday,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function update(int $id, HolidayRequest $request)
    {
        try {
            $holiday = $this->holidayService->updateHoliday($id, request()->all());

            return response()->json([
                'message' => 'Holiday updated',
                'data' => [
                    'holiday' => $holiday,
                ],
            ]);
        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->holidayService->destroyHoliday($id);

            return response()->json([
                'message' => 'Holiday deleted',
            ]);
        } catch (\Exception $e) {
            return response(['message' => 'Error: '.$e->getMessage()], 500);
        }
    }
}
