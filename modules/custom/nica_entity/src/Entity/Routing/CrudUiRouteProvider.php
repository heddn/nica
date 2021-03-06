<?php

/**
 * @file
 * Contains \Drupal\content_entity_base\Entity\Routing\CrudUiRouteProvider.
 */

namespace Drupal\nica_entity\Entity\Routing;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\Routing\EntityRouteProviderInterface;
use Drupal\entity\Routing\CreateHtmlRouteProvider;
use Symfony\Component\Routing\Route;

/**
 * Additional common routes needed for a CRUD UI.
 *
 * - add bundle page
 * - a collection page.
 */
class CrudUiRouteProvider extends CreateHtmlRouteProvider implements EntityRouteProviderInterface {

  /**
   * {@inheritdoc}
   */
  public function getRoutes(EntityTypeInterface $entity_type) {
    $routes = parent::getRoutes($entity_type);

    $routes->add('entity.' . $entity_type->id() . '.collection', $this->collectionRoute($entity_type));

    return $routes;
  }

  protected function collectionRoute(EntityTypeInterface $entity_type) {
    $route = new Route($entity_type->getLinkTemplate('collection'));
    $route->setDefault('_title', $entity_type->getLabel() . ' content');
    $route->setDefault('_entity_list', $entity_type->id());
    $route->setRequirement('_permission', 'view ' . $entity_type->id() . ' entity');
    return $route;
  }

  /**
   * {@inheritdoc}
   */
  protected function addPageRoute(EntityTypeInterface $entity_type) {
    if ($route = parent::addPageRoute($entity_type)) {
      /**
       * @TODO Remove when this feature is at the core.
       */
      $route->setDefault('_controller', '\Drupal\nica_entity\Controller\NicaEntityController::addPage');
      $route->setOption('_admin_route', TRUE);
      return $route;
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function addFormRoute(EntityTypeInterface $entity_type) {
    if ($route = parent::addFormRoute($entity_type)) {
      $route->setOption('_admin_route', TRUE);
      return $route;
    }
  }

}
