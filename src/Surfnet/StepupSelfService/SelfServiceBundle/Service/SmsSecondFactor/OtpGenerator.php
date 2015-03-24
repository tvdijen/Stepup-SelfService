<?php

/**
 * Copyright 2014 SURFnet bv
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Surfnet\StepupSelfService\SelfServiceBundle\Service\SmsSecondFactor;

final class OtpGenerator
{
    /**
     * @return string
     */
    public static function generate()
    {
        $randomCharacters = function () {
            $chr = rand(50, 81);

            // 9 is the gap between "7" (55) and "A" (65).
            return chr($chr >= 56 ? $chr + 9 : $chr);
        };

        return join('', array_map($randomCharacters, range(1, 8)));
    }
}