<?php
namespace core\entities\user;

use core\entities\AggregateRoot;
use core\entities\EventTrait;
use core\entities\user\events\UserSignupRequested;
use core\entities\user\events\UserCreatedByAdmin;
use core\services\auth\TokensManager;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $email_confirm_token
 * @property string $auth_key
 * @property integer $status
 * @property boolean $notification
 * @property integer $created_at
 * @property integer $updated_at
 * @property UserData $userData
 */
class User extends ActiveRecord implements IdentityInterface, AggregateRoot
{
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 0;
    const STATUS_WAIT = 10;

    use EventTrait;

    public static function create(UserData $userData, TokensManager $tokensManager, UploadedFile $avatar): self
    {
        $user = new static();
        $user->userData = $userData;
        $user->password_hash = $tokensManager->generatePassword();
        $user->status = self::STATUS_WAIT;
        $user->avatar = $avatar;
        $user->auth_key = $tokensManager->generateRandomString();
        $user->email_confirm_token = $tokensManager->generateRandomString();
        $user->recordEvent(new UserCreatedByAdmin($user));

        return $user;
    }

    public function edit(UserData $userData, UploadedFile $avatar): void
    {
        $this->userData = $userData;
        $this->avatar = $avatar;
    }

    public static function requestSignUp(UserData $userData, string $password, TokensManager $tokensManager, UploadedFile $avatar): self
    {
        $user = new static();
        $user->userData = $userData;
        $user->password_hash = $tokensManager->generatePassword($password);
        $user->status = self::STATUS_WAIT;
        $user->avatar = $avatar;
        $user->auth_key = $tokensManager->generateRandomString();
        $user->email_confirm_token = $tokensManager->generateRandomString();
        $user->recordEvent(new UserSignupRequested($user));

        return $user;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->status == self::STATUS_BLOCKED;
    }

    public function isWait(): bool
    {
        return $this->status == self::STATUS_WAIT;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }



    public function afterFind(): void
    {
        $this->userData = new UserData(
            $this->getAttribute('username'),
            $this->getAttribute('email'),
            $this->getAttribute('first_name'),
            $this->getAttribute('last_name')
        );

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('username', $this->userData->username);
        $this->setAttribute('email', $this->userData->email);
        $this->setAttribute('first_name', $this->userData->first_name);
        $this->setAttribute('last_name', $this->userData->last_name);

        return parent::beforeSave($insert);
    }
}
