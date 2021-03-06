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

use Surfnet\StepupSelfService\SelfServiceBundle\Exception\InvalidArgumentException;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
final class ProofOfPossessionResult
{
    const STATUS_CHALLENGE_OK = 0;
    const STATUS_INCORRECT_CHALLENGE = 1;
    const STATUS_CHALLENGE_EXPIRED = 2;
    const STATUS_TOO_MANY_ATTEMPTS = 3;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string|null
     */
    private $secondFactorId;

    /**
     * @param int $status One of
     * @param string|null $secondFactorId
     */
    private function __construct($status, $secondFactorId = null)
    {
        $this->secondFactorId = $secondFactorId;
        $this->status = $status;
    }

    /**
     * @return ProofOfPossessionResult
     */
    public static function challengeExpired()
    {
        return new self(self::STATUS_CHALLENGE_EXPIRED);
    }

    /**
     * @return ProofOfPossessionResult
     */
    public static function incorrectChallenge()
    {
        return new self(self::STATUS_INCORRECT_CHALLENGE);
    }

    /**
     * @return ProofOfPossessionResult
     */
    public static function proofOfPossessionCommandFailed()
    {
        return new self(self::STATUS_CHALLENGE_OK);
    }

    /**
     * @param string $secondFactorId
     * @return ProofOfPossessionResult
     */
    public static function secondFactorCreated($secondFactorId)
    {
        if (!is_string($secondFactorId)) {
            throw InvalidArgumentException::invalidType('string', 'secondFactorId', $secondFactorId);
        }

        return new self(self::STATUS_CHALLENGE_OK, $secondFactorId);
    }

    /**
     * @return ProofOfPossessionResult
     */
    public static function tooManyAttempts()
    {
        return new self(self::STATUS_TOO_MANY_ATTEMPTS);
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->status === self::STATUS_CHALLENGE_OK && $this->secondFactorId !== null;
    }

    /**
     * @return null|string
     */
    public function getSecondFactorId()
    {
        return $this->secondFactorId;
    }

    public function didProofOfPossessionFail()
    {
        return $this->status === self::STATUS_CHALLENGE_OK && $this->secondFactorId === null;
    }

    /**
     * @return boolean
     */
    public function wasIncorrectChallengeResponseGiven()
    {
        return $this->status === self::STATUS_INCORRECT_CHALLENGE;
    }

    /**
     * @return boolean
     */
    public function hasChallengeExpired()
    {
        return $this->status === self::STATUS_CHALLENGE_EXPIRED;
    }

    /**
     * @return boolean
     */
    public function wereTooManyAttemptsMade()
    {
        return $this->status === self::STATUS_TOO_MANY_ATTEMPTS;
    }
}
