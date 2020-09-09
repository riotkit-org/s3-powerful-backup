<?php declare(strict_types=1);

namespace App\Infrastructure\Security\Event\Subscriber;

use App\Domain\Security\Configuration\ApplicationInfo;
use App\Domain\Security\Configuration\JWTConfiguration;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Configures a custom lifetime for JWT tokens
 *
 * Notice: In "dev" environment the tokens are extended to +7 days lifetime for local development
 */
class JWTLifetimeSubscriber implements EventSubscriberInterface
{
    private ApplicationInfo  $appInfo;
    private JWTConfiguration $jwtConfig;

    public function __construct(ApplicationInfo $appInfo, JWTConfiguration $jwtConfig)
    {
        $this->appInfo   = $appInfo;
        $this->jwtConfig = $jwtConfig;
    }

    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onJWTCreated'
        ];
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $expiration = new \DateTime($this->jwtConfig->getDefaultLifetime());

        if ($this->appInfo->isDevelopmentEnvironment()) {
            $expiration = new \DateTime('+7 days');
        }

        $payload = $event->getData();
        $payload['exp'] = $expiration->getTimestamp();

        $event->setData($payload);
    }
}
