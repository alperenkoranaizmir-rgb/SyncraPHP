<?php

it('returns a successful response', function () {
    $status = $this->get('/')->status();

    $this->assertTrue(in_array($status, [200, 302]));
});
