<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\Validation\Validators;

use Attribute;
use Respect\Validation\Result;
use Respect\Validation\Validator;

use function count;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final readonly class Composite implements Validator
{
    private Validator $validator;

    public function __construct(Validator ...$validators)
    {
        $this->validator = match (count($validators)) {
            0 => new AlwaysValid(),
            1 => $validators[0],
            default => new AllOf(...$validators),
        };
    }

    public function evaluate(mixed $input): Result
    {
        return $this->validator->evaluate($input);
    }
}
