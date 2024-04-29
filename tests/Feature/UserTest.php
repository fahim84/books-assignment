<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
//    public function test_example(): void
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }

    public function test_can_create_book(): void
    {
        $this->withoutExceptionHandling();
        $formdata = [
            'title' => 'unit title',
            'author' => 'unit author',
            'publication_year' => 2010,
            'isbn' => 'isbn-1234-unit'
        ];
        $this->post(route('books.store'),$formdata,
            ['Authorization' => 'Bearer 1|HHw1umcAXatwr6g9ECgWCAYKJzIDgiNHHi8ExRZk12979923']
        )->assertStatus(201);
    }

    public function test_can_update_book(): void
    {
        $this->withoutExceptionHandling();
        $formdata = [
            'title' => 'unit title edited',
            'author' => 'unit author edit',
            'publication_year' => 2010,
            'isbn' => 'isbn-1234-unit'
        ];
        $this->patch(route('books.update',18),$formdata,
            ['Authorization' => 'Bearer 1|HHw1umcAXatwr6g9ECgWCAYKJzIDgiNHHi8ExRZk12979923']
        )->assertStatus(201);
    }
}
