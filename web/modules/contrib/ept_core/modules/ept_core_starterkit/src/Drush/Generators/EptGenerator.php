<?php

declare(strict_types = 1);

namespace Drupal\ept_core_starterkit\Drush\Generators;

use DrupalCodeGenerator\Asset\AssetCollection as Assets;
use DrupalCodeGenerator\Attribute\Generator;
use DrupalCodeGenerator\Command\BaseGenerator;
use DrupalCodeGenerator\GeneratorType;

#[Generator(
  name: 'ept:module',
  description: 'Generates Extra Paragraph Type (EPT) module',
  aliases: ['ept-module'],
  templatePath: __DIR__ . '/../../../generator',
  type: GeneratorType::MODULE_COMPONENT,
  label: 'EPT module',
)]

/**
 * EPT Generator class.
 */
final class EptGenerator extends BaseGenerator {

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars, Assets $assets): void {
    $ir = $this->createInterviewer($vars);

    $vars['machine_name'] = $ir->askMachineName();
    // @todo add validation for ept_* prefix.
    $vars['name'] = $ir->askName();
    $vars['machine_name_with_dashes'] = str_replace('_', '-', $vars['machine_name']);

    $assets->addFile('{machine_name}.info.yml', 'ept_starterkit.info.yml.twig');
    $assets->addFile('{machine_name}.libraries.yml', 'ept_starterkit.libraries.yml.twig');

    $assets->addFile('config/install/core.entity_form_display.paragraph.{machine_name}.default.yml', 'config/install/core.entity_form_display.paragraph.ept_starterkit.default.yml.twig');
    $assets->addFile('config/install/core.entity_view_display.paragraph.{machine_name}.default.yml', 'config/install/core.entity_view_display.paragraph.ept_starterkit.default.yml.twig');
    $assets->addFile('config/install/field.field.paragraph.{machine_name}.field_ept_settings.yml', 'config/install/field.field.paragraph.ept_starterkit.field_ept_settings.yml.twig');
    $assets->addFile('config/install/field.field.paragraph.{machine_name}.field_ept_text.yml', 'config/install/field.field.paragraph.ept_starterkit.field_ept_text.yml.twig');
    $assets->addFile('config/install/field.field.paragraph.{machine_name}.field_ept_title.yml', 'config/install/field.field.paragraph.ept_starterkit.field_ept_title.yml.twig');
    $assets->addFile('config/install/paragraphs.paragraphs_type.{machine_name}.yml', 'config/install/paragraphs.paragraphs_type.ept_starterkit.yml.twig');

    $assets->addFile('templates/paragraph--{machine_name_with_dashes}--default.html.twig', 'twig_files/paragraph--ept-starterkit--default.html.twig.twig');

    $assets->addFile('tests/src/Functional/InstallTest.php', 'tests/src/Functional/InstallTest.php.twig');
    $assets->addFile('logo.png');
    $assets->addFile('logo.svg');

    $assets->addFile('.gitignore', '.gitignore.twig');

    $assets->addFile('README.md', 'README.md.twig');
    $assets->addFile('composer.json', 'composer.json.twig');

    $assets->addFile('gulpfile.js', 'gulpfile.js.twig');
    $assets->addFile('css/styles.css', 'css/styles.css.twig');
    $assets->addFile('scss/styles.scss', 'scss/styles.scss.twig');
    $assets->addFile('package.json', 'package.json.twig');
    $assets->addFile('package-lock.json', 'package-lock.json.twig');
  }

}
