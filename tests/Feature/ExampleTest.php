<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The homepage redirects guests to the login page.
     */
    public function test_the_homepage_redirects_to_the_login_page(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }
}
