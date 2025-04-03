namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request && $user = $request->getUser()) {
            $payload = $event->getData();
            $payload['user_id'] = $user->getId(); // Assumes the User entity has a getId() method
            $event->setData($payload);
        }
    }
}
