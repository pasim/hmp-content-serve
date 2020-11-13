<?php

namespace Drupal\Tests\prison_list\Functional;

use Drupal\comment\Tests\CommentTestTrait;
use Drupal\Component\Serialization\Json;
use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\Tests\BrowserTestBase;
use Drupal\Tests\field\Traits\EntityReferenceTestTrait;
use Drupal\Tests\jsonapi\Functional\JsonApiRequestTestTrait;
use Drupal\Tests\jsonapi\Functional\ResourceResponseTestTrait;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use Drupal\user\RoleInterface;
use GuzzleHttp\RequestOptions;


/**
 * Tests Prison List setup and staff.
 *
 * @group prison_list
 */
class PrisonListTest extends BrowserTestBase {

  use JsonApiRequestTestTrait;
  use ResourceResponseTestTrait;
  use EntityReferenceTestTrait;
  use CommentTestTrait;

  protected $defautVocabularry = 'prisons';

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'bartik';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'basic_auth',
    'editor',
    'node',
    'media',
    'media_library',
    'taxonomy',
    'comment',
    'path',
    'jsonapi_resources',
    'jsonapi_resources_test',
    'prison_list'
  ];

  protected function setUp() {
    parent::setUp();

    // Ensure the anonymous user role has no permissions at all.
//    $user_role = Role::load(RoleInterface::ANONYMOUS_ID);
//    foreach ($user_role->getPermissions() as $permission) {
//      $user_role->revokePermission($permission);
//    }
//    $user_role->save();
//    assert([] === $user_role->getPermissions(), 'The anonymous user role has no permissions at all.');
//
//    // Ensure the authenticated user role has no permissions at all.
//    $user_role = Role::load(RoleInterface::AUTHENTICATED_ID);
//    foreach ($user_role->getPermissions() as $permission) {
//      $user_role->revokePermission($permission);
//    }
//    $user_role->
//    $user_role->save();
//    assert([] === $user_role->getPermissions(), 'The authenticated user role has no permissions at all.');

  }


  /**
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *
   * Tests successfull taxonomy creation
   *
   */
  public function testPrisonListEntitiesExist(){

    /**
     * Testing for vocabullary staff
     */
    $entity = \Drupal\taxonomy\Entity\Vocabulary::load($this->defautVocabularry);
    $this->assertNotEmpty($entity, 'Entity is not created');
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid'=>$this->defautVocabularry]);
    $this->assertNotEmpty($terms, 'Test Taxonomy term');

    /**
     * Testing if fields have been created
     */
    $fields = \Drupal::service('entity_field.manager')->getFieldDefinitions('node', 'page');
    $this->assertTrue(isset($fields['field_media']), "Media field does not exist");
    $this->assertTrue(isset($fields['field_prison']), "Prison field does not exist");

  }

  public function testPrisonListNodeOverView(){

    $role = Role::load('editor');


    $account = $this->createUser($role->getPermissions());
    $this->drupalLogin($account);


    $edit = [];
    $edit['title[0][value]'] = $this->randomMachineName(8);
    $edit['body[0][value]'] = $this->randomMachineName(16);
    $this->drupalPostForm('node/add/page', $edit, t('Save'));

    // Check that the Basic page has been created.
//    $this->assertText(t('@post @title has been created.', ['@post' => 'Basic page', '@title' => $edit['title[0][value]']]), 'Basic page created.');
    //Back to Anonymous user
    $this->drupalLogout();

    $url = Url::fromUri('internal:/api/v1/content');
    $request_options = [];
    $request_options[RequestOptions::HEADERS]['Accept'] = 'application/vnd.api+json';
    $response = $this->request('GET', $url, $request_options);
    $this->assertSame(200, $response->getStatusCode(), var_export(Json::decode((string) $response->getBody()), TRUE));
    $response_document = Json::decode((string) $response->getBody());
    $this->assertCount(1, $response_document['data']);



  }

}
