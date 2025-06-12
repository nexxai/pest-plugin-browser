<?php

declare(strict_types=1);

use Pest\Browser\Support\JavaScriptSerializer;

it('serializes null values correctly', function (): void {
    $value = null;
    $result = JavaScriptSerializer::serializeValue($value);

    expect($result)->toBe(['v' => 'null']);
});

it('serializes boolean values correctly', function (): void {
    $true = JavaScriptSerializer::serializeValue(true);
    $false = JavaScriptSerializer::serializeValue(false);

    expect($true)->toBe(['b' => true]);
    expect($false)->toBe(['b' => false]);
});

it('serializes numeric values correctly', function (): void {
    $int = JavaScriptSerializer::serializeValue(42);
    $float = JavaScriptSerializer::serializeValue(3.14);

    expect($int)->toBe(['n' => 42]);
    expect($float)->toBe(['n' => 3.14]);
});

it('serializes special numeric values correctly', function (): void {
    $nan = JavaScriptSerializer::serializeValue(NAN);
    $infinity = JavaScriptSerializer::serializeValue(INF);
    $negInfinity = JavaScriptSerializer::serializeValue(-INF);

    expect($nan)->toBe(['v' => 'NaN']);
    expect($infinity)->toBe(['v' => 'Infinity']);
    expect($negInfinity)->toBe(['v' => '-Infinity']);
});

it('serializes strings correctly', function (): void {
    $string = JavaScriptSerializer::serializeValue('hello world');

    expect($string)->toBe(['s' => 'hello world']);
});

it('serializes arrays correctly', function (): void {
    $array = JavaScriptSerializer::serializeValue([1, 2, 3]);

    expect($array)->toHaveKey('a');
    expect($array['a'])->toHaveCount(3);
    expect($array['a'][0])->toBe(['n' => 1]);
    expect($array['a'][1])->toBe(['n' => 2]);
    expect($array['a'][2])->toBe(['n' => 3]);
});

it('serializes associative arrays as objects correctly', function (): void {
    $assoc = JavaScriptSerializer::serializeValue(['name' => 'John', 'age' => 30]);

    expect($assoc)->toHaveKey('o');
    expect($assoc['o'])->toBeArray();

    // Check for the name key-value pair
    $hasName = false;
    $hasAge = false;

    foreach ($assoc['o'] as $item) {
        if ($item['k'] === 'name' && $item['v'] === ['s' => 'John']) {
            $hasName = true;
        }
        if ($item['k'] === 'age' && $item['v'] === ['n' => 30]) {
            $hasAge = true;
        }
    }

    expect($hasName)->toBeTrue();
    expect($hasAge)->toBeTrue();
});

it('serializes objects correctly', function (): void {
    $obj = new stdClass();
    $obj->name = 'Jane';
    $obj->active = true;

    $result = JavaScriptSerializer::serializeValue($obj);

    expect($result)->toHaveKey('o');
    expect($result['o'])->toBeArray();

    // Check for the needed properties
    $hasName = false;
    $hasActive = false;

    foreach ($result['o'] as $item) {
        if ($item['k'] === 'name' && $item['v'] === ['s' => 'Jane']) {
            $hasName = true;
        }
        if ($item['k'] === 'active' && $item['v'] === ['b' => true]) {
            $hasActive = true;
        }
    }

    expect($hasName)->toBeTrue();
    expect($hasActive)->toBeTrue();
});

it('serializes nested structures correctly', function (): void {
    $nested = [
        'user' => [
            'name' => 'Alice',
            'tags' => ['developer', 'tester']
        ]
    ];

    $result = JavaScriptSerializer::serializeValue($nested);

    expect($result)->toHaveKey('o');
    expect($result['o'][0]['k'])->toBe('user');
    expect($result['o'][0]['v'])->toHaveKey('o');

    $user = $result['o'][0]['v']['o'];
    expect($user)->toContain(['k' => 'name', 'v' => ['s' => 'Alice']]);

    $tags = null;
    foreach ($user as $prop) {
        if ($prop['k'] === 'tags') {
            $tags = $prop['v'];
            break;
        }
    }

    expect($tags)->not->toBeNull();
    expect($tags)->toHaveKey('a');
    expect($tags['a'])->toContain(['s' => 'developer']);
    expect($tags['a'])->toContain(['s' => 'tester']);
});

it('creates argument structure correctly', function (): void {
    $arg = ['test' => true];
    $result = JavaScriptSerializer::serializeArgument($arg);

    expect($result)->toHaveKeys(['value', 'handles']);
    expect($result['value'])->toHaveKey('o');
    expect($result['handles'])->toBeArray();
    expect($result['handles'])->toBeEmpty();
});

it('parses primitive values correctly', function (): void {
    expect(JavaScriptSerializer::parseValue(['v' => 'null']))->toBeNull();
    expect(JavaScriptSerializer::parseValue(['v' => 'undefined']))->toBeNull();
    expect(JavaScriptSerializer::parseValue(['b' => true]))->toBeTrue();
    expect(JavaScriptSerializer::parseValue(['b' => false]))->toBeFalse();
    expect(JavaScriptSerializer::parseValue(['n' => 42]))->toBe(42);
    expect(JavaScriptSerializer::parseValue(['n' => 3.14]))->toBe(3.14);
    expect(JavaScriptSerializer::parseValue(['s' => 'hello']))->toBe('hello');
    expect(JavaScriptSerializer::parseValue(['v' => 'NaN']))->toBeNan();
    expect(JavaScriptSerializer::parseValue(['v' => 'Infinity']))->toBe(INF);
    expect(JavaScriptSerializer::parseValue(['v' => '-Infinity']))->toBe(-INF);
});

it('parses arrays correctly', function (): void {
    $array = [
        'a' => [
            ['n' => 1],
            ['n' => 2],
            ['s' => 'test']
        ]
    ];

    $result = JavaScriptSerializer::parseValue($array);

    expect($result)->toBeArray();
    expect($result)->toBe([1, 2, 'test']);
});

it('parses objects correctly', function (): void {
    $object = [
        'o' => [
            ['k' => 'name', 'v' => ['s' => 'John']],
            ['k' => 'age', 'v' => ['n' => 30]],
            ['k' => 'active', 'v' => ['b' => true]]
        ]
    ];

    $result = JavaScriptSerializer::parseValue($object);

    expect($result)->toBeArray();
    expect($result)->toBe([
        'name' => 'John',
        'age' => 30,
        'active' => true
    ]);
});

it('parses nested structures correctly', function (): void {
    $nested = [
        'o' => [
            [
                'k' => 'user',
                'v' => [
                    'o' => [
                        ['k' => 'name', 'v' => ['s' => 'Alice']],
                        [
                            'k' => 'hobbies',
                            'v' => [
                                'a' => [
                                    ['s' => 'reading'],
                                    ['s' => 'coding']
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ];

    $result = JavaScriptSerializer::parseValue($nested);

    expect($result)->toBeArray();
    expect($result)->toHaveKey('user');
    expect($result['user'])->toHaveKeys(['name', 'hobbies']);
    expect($result['user']['name'])->toBe('Alice');
    expect($result['user']['hobbies'])->toBe(['reading', 'coding']);
});
