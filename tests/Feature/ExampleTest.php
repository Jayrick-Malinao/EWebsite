<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_homepage_renders_the_landing_page_with_a_login_link(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Community health, organized digitally')
            ->assertSee(route('login'));
    }
}
