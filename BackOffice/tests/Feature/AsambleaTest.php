<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\Asamblea;
use App\Exceptions\AsambleaException;
use Illuminate\Support\Facades\Hash;

class AsambleaTest extends TestCase
{
    /**
     * A basic feature test example.
     * https://stackoverflow.com/questions/34971082/create-date-carbon-in-laravel
     */

    private $year;
    private $month;
    private $day;
    private $hour;
    private $minute;

    protected function setUp(): void
    {
        parent::setUp();
        
        $date = Carbon::now();
        $this->year = $date->year;      
        $this->month = $date->month;    
        $this->day = $date->day;        
        $this->hour = $date->hour;      
        $this->minute = $date->minute;  
    }

    public function test_create_asamblea_exitosa(): void
    {
        $data = [
            "date" => Carbon::create(
                $this->year, 
                $this->month, 
                $this->day + 1, 
                $this->hour, 
                $this->minute, 00, 'UTC'),
            "type" => 'General',
            "purpose" => "Testing",
        ];

        $response = $this->post(route('asamblea.create'), $data);
        $response->assertRedirect(route('asambleas'));

        $this->assertDatabaseHas('asambleas', [
            'assembly_date' => $data['date'],
            'type' => $data['type'],
            'purpose' => $data['purpose'],
        ]);
    }

    public function test_create_asamblea_failure_1(): void
    {
        try {

            $data = [
                "date" => Carbon::create(
                    $this->year, 
                    $this->month, 
                    $this->day + 2, 
                    $this->hour, 
                    $this->minute, 00, 'UTC'),
                "type" => 'Error',
                "purpose" => "TestingFailure1",
            ];

            //Asamblea::createAsamblea(new \Illuminate\Http\Request($data));
        } catch (AsambleaException $ex){
            $this->assertDatabaseMissing('asambleas', [
                'assembly_date' => $data['date'],
                'type' => $data['type'],
                'purpose' => $data['purpose']
            ]);
        }
    }

    // testing create with using a date thats already schedule for another assembly
    public function test_create_asamblea_failure_2(): void
    {
        try {

            $data = [
                "date" => Carbon::create(
                    $this->year, 
                    $this->month, 
                    $this->day + 1, 
                    $this->hour, 
                    $this->minute, 00, 'UTC'),
                "type" => 'General',
                "purpose" => "TestingFailure2",
            ];

            Asamblea::createAsamblea(new \Illuminate\Http\Request($data));
        } catch (AsambleaException $ex){
            $this->assertDatabaseMissing('asambleas', [
                'assembly_date' => $data['date'],
                'type' => $data['type'],
                'purpose' => $data['purpose']
            ]);
        }
    }

    // testing create with a date older than todays date 
    public function test_create_asamblea_failure_3(): void
    {
        try {

            $data = [
                "date" => Carbon::create(
                    $this->year, 
                    $this->month, 
                    $this->day - 1, 
                    $this->hour, 
                    $this->minute, 00, 'UTC'),
                "type" => 'General',
                "purpose" => "TestingFailure3",
            ];

            Asamblea::createAsamblea(new \Illuminate\Http\Request($data));
        } catch (AsambleaException $ex){
            $this->assertDatabaseMissing('asambleas', [
                'assembly_date' => $data['date'],
                'type' => $data['type'],
                'purpose' => $data['purpose']
            ]);
        }
    }
}
