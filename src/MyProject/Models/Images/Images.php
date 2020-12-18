<?php

namespace MyProject\Models\Images;

use MyProject\Exceptions\InvalidArgumentException;

class Images extends \MyProject\Models\ActiveRecordEntity
{
    protected $id;

    protected $imagePath;

    protected $user_id;


    protected static function getTableName(): string
    {
        return 'images';
    }

    public function setImagePath($imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    public static function addImage($avatarPath, $userId): void
    {
        if (empty($avatarPath)) {
            throw new InvalidArgumentException('Не передан путь аватара');
        }

        $image = new Images();
        $image->setImagePath($avatarPath);
        $image->setUserId($userId);

        $image->save();
    }

}