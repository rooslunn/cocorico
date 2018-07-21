<?php


namespace Cocorico\CoreBundle\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Monolog\Logger;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class ListingFormSubscriber implements EventSubscriberInterface
{
    private const FIELD_ISBN_NAME = 'ISBN';

    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ListingFormEvents::LISTING_NEW_FORM_BUILD => ['onListingNewFormBuild', 1]
        ];
    }

    public function onListingNewFormBuild(ListingFormBuilderEvent $event): void
    {
        $form = $event->getFormBuilder()->getForm();
        $form->add(self::FIELD_ISBN_NAME, TextType::class, ['mapped' => false]);
        $this->logger->debug('Catch onListingNewFormBuild, added field ISBN', [$form->has(self::FIELD_ISBN_NAME)]);
    }
}