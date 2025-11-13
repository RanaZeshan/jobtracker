<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetsService
{
    protected Sheets $service;

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName('Laravel Recruiter App');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->setAccessType('offline');

        $this->service = new Sheets($client);
    }

    /**
     * Append a row to the given spreadsheet & sheet.
     *
     * @param string $spreadsheetId
     * @param array  $row
     * @param string $sheetName
     * @return void
     */
    public function appendApplicationRow(string $spreadsheetId, array $row, string $sheetName = 'Sheet1'): void
    {
        $range = $sheetName.'!A:Z';

        $body = new Sheets\ValueRange([
            'values' => [ $row ],
        ]);

        $params = [
            'valueInputOption' => 'RAW',
        ];

        $this->service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    }

    /**
     * Delete all rows in a sheet that match the given key in column A.
     *
     * @param string $spreadsheetId The Google Sheet ID.
     * @param string $key           The unique key stored in column A.
     * @param string $sheetName     The tab name (default: Sheet1).
     * @return void
     */
    public function deleteRowsByKey(string $spreadsheetId, string $key, string $sheetName = 'Sheet1'): void
    {
        // 1) Find the sheet (tab) ID by title
        $spreadsheet = $this->service->spreadsheets->get($spreadsheetId);
        $sheetId = null;

        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                $sheetId = $sheet->getProperties()->getSheetId();
                break;
            }
        }

        if ($sheetId === null) {
            // Sheet/tab not found; nothing to delete
            return;
        }

        // 2) Read all values to find row indexes with this key in column A
        $range = $sheetName.'!A:Z';
        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues() ?? [];

        $rowsToDelete = [];

        foreach ($values as $index => $row) {
            // Column A = index 0
            if (isset($row[0]) && $row[0] === $key) {
                $rowsToDelete[] = $index;
            }
        }

        if (empty($rowsToDelete)) {
            // No matching rows
            return;
        }

        // 3) Build delete requests (delete from bottom to top so indexes don't shift)
        rsort($rowsToDelete);

        $requests = [];
        foreach ($rowsToDelete as $rowIndex) {
            $requests[] = new \Google\Service\Sheets\Request([
                'deleteDimension' => [
                    'range' => [
                        'sheetId'   => $sheetId,
                        'dimension' => 'ROWS',
                        'startIndex'=> $rowIndex,
                        'endIndex'  => $rowIndex + 1,
                    ],
                ],
            ]);
        }

        $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => $requests,
        ]);

        $this->service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
    }
}
