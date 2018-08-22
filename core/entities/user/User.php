<?php
namespace core\entities\user;

use core\entities\AggregateRoot;
use core\entities\EventTrait;
use core\entities\sf\Forecast;
use core\entities\sf\Tournament;
use core\entities\sf\UserTournaments;
use core\entities\sf\WinnersForecast;
use core\entities\user\events\PasswordResetRequestSubmitted;
use core\entities\user\events\UserSignupConfirmed;
use core\entities\user\events\UserSignupRequested;
use core\entities\user\events\UserCreatedByAdmin;
use core\services\auth\TokensManager;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

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
 * @property integer $last_login
 * @property integer $updated_at
 * @property UserData $userData
 *
 * @property UserTournaments[] $tournaments
 * @property Forecast[] $forecasts
 * @property WinnersForecast[] $winnersForecasts
 * @mixin ImageUploadBehavior
 */

class User extends ActiveRecord implements IdentityInterface, AggregateRoot
{

    const DEFAULT_AVATAR_PATH = '@static/origin/users/avatars/default';

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 0;
    const STATUS_WAIT = 10;

    public $userData;

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
        $user->subscribeToNews();
        $user->recordEvent(new UserCreatedByAdmin($user));

        return $user;
    }

    public function edit(UserData $userData, UploadedFile $avatar): void
    {
        $this->userData = $userData;
        $this->avatar = $avatar;
    }

    public static function requestSignUp(UserData $userData, string $password, bool $notification, $avatar, TokensManager $tokensManager): self
    {
        $user = new static();
        $user->userData = $userData;
        $user->password_hash = $tokensManager->generatePassword($password);
        $user->status = self::STATUS_WAIT;
        $user->avatar = $avatar;
        $user->notification = $notification;
        $user->auth_key = $tokensManager->generateRandomString();
        $user->email_confirm_token = $tokensManager->generateRandomString();
        $user->recordEvent(new UserSignupRequested($user));

        return $user;
    }

    public function confirmSignup(): void
    {
        $this->activate();
        $this->removeEmailConfirmToken();
        $this->recordEvent(new UserSignupConfirmed($this));
    }

    public function login(bool $rememberMe): bool
    {
        if (\Yii::$app->user->login($this, $rememberMe ? \Yii::$app->params['user.rememberMeDuration'] : 0)) {
            $this->last_login = time();
            return true;
        }
        return false;
    }

    public function requestPasswordReset(TokensManager $tokens)
    {
        if (!empty($this->password_reset_token) && $tokens->validateToken($this->password_reset_token)) {
            throw new \DomainException('Запрос на восстановление пароля уже был отправлен, проверьте почту');
        }
        $this->password_reset_token = $tokens->generateToken();
        $this->recordEvent(new PasswordResetRequestSubmitted($this));
    }

    public function resetPassword($password, TokensManager $tokens)
    {
        $this->password_hash = $tokens->generatePassword($password);
        $this->removePasswordResetToken();
    }

    public function activate(): void
    {
        if ($this->isBlocked()) {
            throw new \DomainException('Пользорватель заблокирован, обратитесь к администрации');
        }
        if ($this->isActive()) {
            throw new \DomainException('Пользорватель уже активен');
        }
        $this->status = self::STATUS_ACTIVE;
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

    public function isSubscribedNews(): bool
    {
        return $this->notification;
    }

    public function isSubsrcibedForTournamentNews(Tournament $tournament): bool
    {
        /** @var UserTournaments $one */
        $one = $this->getTournaments()->where(['tournament_id' => $tournament->id])->one();
        return $one->notification;
    }

    public function subscribeToNews(): void
    {
        if ($this->notification) {
            throw new \DomainException('Подписка уже активна');
        }
        $this->notification = true;
    }

    public function unsubscribeToNews(): void
    {
        if (!$this->notification) {
            throw new \DomainException('Подписка уже деактивирована');
        }
        $this->notification = false;
    }

    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = NULL;
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = NULL;
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
            TimestampBehavior::class,
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'avatar',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/users/avatars/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/users/avatars/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/users/avatars/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/users/avatars/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'menuPic' => ['width' => 40, 'height' => 40],
                ]
            ]
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

    public function getTournaments(): ActiveQuery
    {
        return $this->hasMany(UserTournaments::class, ['user_id' => 'id']);
    }

    public function getForecasts(): ActiveQuery
    {
        return $this->hasMany(Forecast::class, ['user_id' => 'id']);
    }

    public function getWinnersForecasts(): ActiveQuery
    {
        return $this->hasMany(WinnersForecast::class, ['user_id' => 'id']);
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
