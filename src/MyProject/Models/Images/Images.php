<?php

namespace MyProject\Models\Images;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Services\Db;

class Images extends \MyProject\Models\ActiveRecordEntity
{
    protected $id;

    protected $imagePath;

    protected $userId;

    public static function getAttributeNameUserId()
    {
        return 'user_id';
    }

    protected static function getTableName(): string
    {
        return 'images';
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @return mixed
     */
    public function getUserId():int
    {
        return $this->userId;
    }

    public function setImagePath($imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
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

    public static function checkAvatar($pathAvatar, $userId): bool
    {
        $db = Db::getInstance();
        $result = $db->query('SELECT * FROM  `images` where user_id =:user_id;', [':user_id' => $userId], static::class);

        if ($result[0] !== null) {
            return true;
        } else {
            return false;
        }
    }

}