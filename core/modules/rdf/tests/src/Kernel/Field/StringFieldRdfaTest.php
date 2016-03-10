<?php
/**
 * @file
 * Contains \Drupal\Tests\rdf\Kernel\Field\StringFieldRdfaTest.
 */

namespace Drupal\Tests\rdf\Kernel\Field;

use Drupal\entity_test\Entity\EntityTest;
use Drupal\Tests\rdf\Kernel\Field\FieldRdfaTestBase;

/**
 * Tests RDFa output by text field formatters.
 *
 * @group rdf
 */
class StringFieldRdfaTest extends FieldRdfaTestBase {

  /**
   * {@inheritdoc}
   */
  protected $fieldType = 'string';

  /**
   * The 'value' property value for testing.
   *
   * @var string
   */
  protected $testValue = 'test_text_value';

  /**
   * The 'summary' property value for testing.
   *
   * @var string
   */
  protected $testSummary = 'test_summary_value';

  protected function setUp() {
    parent::setUp();

    $this->createTestField();

    // Add the mapping.
    $mapping = rdf_get_mapping('entity_test', 'entity_test');
    $mapping->setFieldMapping($this->fieldName, array(
      'properties' => array('schema:text'),
    ))->save();

    // Set up test entity.
    $this->entity = EntityTest::create();
    $this->entity->{$this->fieldName}->value = $this->testValue;
    $this->entity->{$this->fieldName}->summary = $this->testSummary;
  }

  /**
   * Tests string formatters.
   */
  public function testStringFormatters() {
    // Tests the string formatter.
    $this->assertFormatterRdfa(array('type'=>'string'), 'http://schema.org/text', array('value' => $this->testValue));
  }
}