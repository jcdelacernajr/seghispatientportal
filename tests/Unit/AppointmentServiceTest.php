<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Services\AppointmentService;
use App\Repositories\AppointmentRepository;

/**
 * 
 * To create a unit test for the AppointmentService changeStatus method.
 * Run:php artisan make:test AppointmentService --unit
 * 
 * To test
 * Run: php artisan test tests/Unit/AppointmentServiceTest.php
 * 
 * Expected output:
 *   PASS  Tests\Unit\AppointmentServiceTest
 * ✓ change status successfully
 * ✓ change status throws exception when appointment not found
 *
 * Tests:  2 passed
 * Time:   0.09s
 * 
 */
class AppointmentServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testChangeStatusSuccessfully()
    {
        // Fake appointment object
        $appointment = Mockery::mock();
        $appointment->id = 1;
        $appointment->status = 'Pending';
        $appointment->shouldReceive('save')->once(); // Expect save() to be called once

        // Mock repository
        $mockRepo = Mockery::mock(AppointmentRepository::class);
        $mockRepo->shouldReceive('find')->with(1)->andReturn($appointment);

        // Inject mock repo into service
        $service = new AppointmentService($mockRepo);

        // Call the method
        $result = $service->changeStatus(1, 'Confirmed');

        // Assertions
        $this->assertEquals('Confirmed', $result->status);
        $this->assertEquals(1, $result->id);
    }

    public function testChangeStatusThrowsExceptionWhenAppointmentNotFound()
    {
        $mockRepo = Mockery::mock(AppointmentRepository::class);
        $mockRepo->shouldReceive('find')->with(999)->andReturn(null);

        $service = new AppointmentService($mockRepo);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Appointment not found");

        $service->changeStatus(999, 'Confirmed');
    }
}
