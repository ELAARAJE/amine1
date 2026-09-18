<?php

use Tests\TestCase;

// Feature tests run inside a full Laravel application context
pest()->extend(TestCase::class)->in('Feature');
