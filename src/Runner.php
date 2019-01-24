<?php
/**
 * Created by PhpStorm.
 * User: nrt
 * Date: 24/01/2019
 * Time: 12:27
 */

namespace smoetje;

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

class Runner
{
    public static function run()
    {
        // Get the API client and construct the service object.
        $gApp = new \smoetje\Testapp();
        $client = $gApp->getClient();
        $service = new \Google_Service_Sheets($client);

// Prints the names and majors of students in a sample spreadsheet:
// https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms';
        $range = 'Class Data!A2:E';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            print "No data found.\n";
        } else {
            print "Name, Major:\n";
            foreach ($values as $row) {
                // Print columns A and E, which correspond to indices 0 and 4.
                printf("%s, %s\n", $row[0], $row[4]);
            }
        }
    }
}