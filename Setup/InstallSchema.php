<?php
/**
 * Copyright © 2015 UberTheme. All rights reserved.
*/

namespace shis0u\ubertheme-module-ubdatamigration-mod\Setup;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context){
        $installer = $setup;

        $installer->startSetup();

        $om = \Magento\Framework\App\ObjectManager::getInstance();
        $reader = $om->get('Magento\Framework\Module\Dir\Reader');
        $sourceDir = $reader->getModuleDir('', 'Ubertheme_Ubdatamigration').'/lib/';
        if (is_dir($sourceDir)) {
            //we will update/save source of this lib at pub folder
            $pubDir = $om->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::PUB);
            $toolDir = $pubDir->getAbsolutePath('ub-tool/');
            $helper = $om->get('shis0u\ubertheme-module-ubdatamigration-mod\Helper\File');
            //delete old source of tool
            $helper->rrmdir($toolDir);
            //copy new source of this tool
            $helper->xcopy($sourceDir, $toolDir, 0775);
            //delete source folders/files
            $helper->rrmdir($sourceDir);    
        }
        
        $installer->endSetup();
    }
}
