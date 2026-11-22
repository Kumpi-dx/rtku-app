<?php

test('the application redirects guests to the dashboard', function () {
    $this->get('/')->assertRedirect(route('dashboard'));
});

test('guests cannot access the admin dashboard', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});
