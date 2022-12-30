<?php


final class UserFactory extends ModelFactory
{

    protected function getDefaults(): array
    {
        return [

            'isVerified' => true,
        ];

    }
}
