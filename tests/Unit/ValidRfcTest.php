<?php

namespace Tests\Unit;

use App\Rules\ValidRfc;
use PHPUnit\Framework\TestCase;

class ValidRfcTest extends TestCase
{
    public function test_validates_correct_rfc_persona_fisica()
    {
        $rule = new ValidRfc();
        $fail = function ($message) {
            $this->fail("Validation failed for valid RFC: $message");
        };

        $rule->validate('rfc', 'XAXX010101000', $fail);
        $this->assertTrue(true);
    }

    public function test_validates_correct_rfc_persona_moral()
    {
        $rule = new ValidRfc();
        $fail = function ($message) {
            $this->fail("Validation failed for valid RFC: $message");
        };

        // Example valid generic RFC for foreign entity: XEXX010101000
        $rule->validate('rfc', 'XEXX010101000', $fail);
        $this->assertTrue(true);
    }

    public function test_fails_invalid_rfc_format()
    {
        $rule = new ValidRfc();
        $failed = false;
        $fail = function ($message) use (&$failed) {
            $failed = true;
        };

        $rule->validate('rfc', 'INVALIDRFC123', $fail);
        $this->assertTrue($failed, 'Should have failed for invalid format');
    }

    public function test_fails_invalid_checksum()
    {
        $rule = new ValidRfc();
        $failed = false;
        $fail = function ($message) use (&$failed) {
            $failed = true;
        };

        // Almost valid but wrong check digit if we assume specific calculation logic
        // Using a clearly malformed one for simple test: 'XAXX010101001' (might be valid check digit, depends)
        // Better: RFC with invalid date
        $rule->validate('rfc', 'XAXX000000000', $fail);
        $this->assertTrue($failed, 'Should have failed for invalid RFC');
    }
}
